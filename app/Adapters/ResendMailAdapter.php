<?php

declare(strict_types=1);

namespace App\Adapters;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Sendportal\Base\Adapters\BaseMailAdapter;
use Sendportal\Base\Services\Messages\MessageTrackingOptions;

class ResendMailAdapter extends BaseMailAdapter
{
    public const RESEND_API_URL = 'https://api.resend.com/emails';
    public const COOLDOWN_SECONDS = 60;
    public const DAILY_FREE_LIMIT = 100; // Limite diário por chave no plano gratuito da Resend

    /**
     * Envia o email utilizando o pool de até 10 chaves da Resend com carga randomizada e failover.
     *
     * @throws Exception
     */
    public function send(
        string $fromEmail,
        string $fromName,
        string $toEmail,
        string $subject,
        MessageTrackingOptions $trackingOptions,
        string $content
    ): string {
        $activeSlots = $this->resolveActiveKeySlots();

        if (empty($activeSlots)) {
            throw new Exception(
                'Nenhuma chave de API da Resend foi configurada. Preencha pelo menos um dos 10 slots disponíveis em Provedores de Email.'
            );
        }

        // Ordenação randomizada inteligente respeitando cota diária e saúde dos slots
        $orderedSlots = $this->getRandomizedSlotsForDispatch($activeSlots);
        $totalSlots = count($orderedSlots);
        $attempts = 0;
        $lastError = null;

        foreach ($orderedSlots as $slotInfo) {
            $attempts++;
            $slotNumber = $slotInfo['slot'];
            $apiKey = $slotInfo['key'];
            $todaySends = $this->getDailySendsCount($slotNumber);

            try {
                $payload = [
                    'from' => ! empty($fromName) ? "{$fromName} <{$fromEmail}>" : $fromEmail,
                    'to' => [$toEmail],
                    'subject' => $subject,
                    'html' => $content,
                    'headers' => [
                        'X-Sendportal-Engine' => 'Resend-MultiKey-RandomPool',
                        'X-Resend-Slot' => (string) $slotNumber,
                        'X-Entity-Ref-ID' => (string) Str::uuid(),
                    ],
                ];

                $response = Http::withToken($apiKey)
                    ->timeout(20)
                    ->acceptJson()
                    ->post(self::RESEND_API_URL, $payload);

                if ($response->successful()) {
                    $resendId = $response->json('id');

                    if (! empty($resendId)) {
                        // Incrementa a contagem de envios diários deste slot com expiração de 48h
                        $newCount = $this->incrementDailySends($slotNumber);

                        Log::info(
                            sprintf(
                                '[Resend Random Engine] 🎲 Slot #%02d selecionado aleatoriamente e despachado com sucesso para %s. Envios hoje neste slot: %d/%d. Resend ID: %s',
                                $slotNumber,
                                $toEmail,
                                $newCount,
                                self::DAILY_FREE_LIMIT,
                                $resendId
                            )
                        );

                        return (string) $resendId;
                    }
                }

                $statusCode = $response->status();
                $responseBody = $response->json();
                $errorMessage = Arr::get($responseBody, 'message', $response->body());

                // Caso seja Rate Limit (429) ou indisponibilidade do servidor (5xx)
                if ($statusCode === 429 || $statusCode >= 500) {
                    $this->markSlotInCooldown($slotNumber);
                    Log::warning(
                        sprintf(
                            '[Resend Random Engine] ⚠️ Slot #%02d atingiu limite/erro (%d: %s). Aplicado cooldown de %ds. Alternando para próximo slot randomizado...',
                            $slotNumber,
                            $statusCode,
                            $errorMessage,
                            self::COOLDOWN_SECONDS
                        )
                    );
                    $lastError = "Slot #{$slotNumber} ({$statusCode}): {$errorMessage}";
                    continue;
                }

                // Erro fatal de autenticação ou parâmetro nesta chave
                Log::error("[Resend Random Engine] ❌ Erro no Slot #{$slotNumber} ({$statusCode}): {$errorMessage}");
                $lastError = "Slot #{$slotNumber} ({$statusCode}): {$errorMessage}";

                // Se houver mais slots para tentar, continua a cascata randomizada
                if ($attempts < $totalSlots) {
                    continue;
                }
            } catch (Exception $e) {
                Log::error("[Resend Random Engine] ❌ Exceção ao disparar via Slot #{$slotNumber}: " . $e->getMessage());
                $lastError = "Slot #{$slotNumber}: " . $e->getMessage();
                continue;
            }
        }

        throw new Exception(
            "Falha ao despachar email através de todos os slots ativos da Resend. Último erro: {$lastError}"
        );
    }

    /**
     * Identifica todos os slots (de 1 a 10) que possuem chaves de API configuradas e não vazias.
     * Qualquer slot em branco é estritamente considerado DESATIVADO.
     *
     * @return array<int, array{slot: int, key: string}>
     */
    public function resolveActiveKeySlots(): array
    {
        $slots = [];

        for ($i = 1; $i <= 10; $i++) {
            $key = Arr::get($this->config, "key_{$i}")
                ?: Arr::get($this->config, "keys.{$i}")
                ?: Arr::get($this->config, "keys.key_{$i}")
                ?: ($i === 1 ? Arr::get($this->config, 'key') : null);

            $key = is_string($key) ? trim($key) : '';

            // Qualquer slot sem chave é AUTOMATICAMENTE DESATIVADO
            if (! empty($key)) {
                $slots[] = [
                    'slot' => $i,
                    'key' => $key,
                ];
            }
        }

        return $slots;
    }

    /**
     * Ordena e distribui a carga de trabalho de forma probabilisticamente randomizada.
     * Prioriza slots saudáveis que ainda não atingiram a cota de 100 envios/dia.
     *
     * @param array<int, array{slot: int, key: string}> $activeSlots
     * @return array<int, array{slot: int, key: string}>
     */
    public function getRandomizedSlotsForDispatch(array $activeSlots): array
    {
        if (count($activeSlots) <= 1) {
            return $activeSlots;
        }

        // 1. Separa slots saudáveis daqueles em cooldown temporário (erro 429/5xx)
        $healthy = [];
        $cooldown = [];

        foreach ($activeSlots as $slot) {
            if ($this->isSlotInCooldown($slot['slot'])) {
                $cooldown[] = $slot;
            } else {
                $healthy[] = $slot;
            }
        }

        // Se todos estiverem em cooldown, reseta para não interromper envios críticos
        $availablePool = ! empty($healthy) ? $healthy : $activeSlots;

        // 2. Classifica slots disponíveis com base na cota diária (100 emails/dia no plano free)
        $underQuota = [];
        $quotaReached = [];

        foreach ($availablePool as $slot) {
            $sendsToday = $this->getDailySendsCount($slot['slot']);
            if ($sendsToday < self::DAILY_FREE_LIMIT) {
                $underQuota[] = $slot;
            } else {
                $quotaReached[] = $slot;
            }
        }

        // 3. Randomização criptográfica da carga de trabalho
        // Embaralha randomicamente os slots abaixo da cota
        if (! empty($underQuota)) {
            $this->cryptoShuffle($underQuota);
        }

        // Embaralha randomicamente os slots que atingiram a cota (para uso como fallback/planos pagos)
        if (! empty($quotaReached)) {
            $this->cryptoShuffle($quotaReached);
        }

        // 4. Concatena a fila de despacho:
        // Primeiro: slots saudáveis abaixo de 100 envios (randomizados)
        // Segundo: slots saudáveis que já atingiram 100 envios (randomizados, caso o usuário tenha limites maiores)
        // Terceiro: slots em cooldown temporário (como última contingência de emergência)
        $ordered = array_merge($underQuota, $quotaReached);

        if (! empty($healthy) && ! empty($cooldown)) {
            $this->cryptoShuffle($cooldown);
            $ordered = array_merge($ordered, $cooldown);
        }

        return $ordered;
    }

    /**
     * Retorna a quantidade de envios realizados pelo slot na data atual.
     */
    public function getDailySendsCount(int $slotNumber): int
    {
        $cacheKey = $this->getDailyCacheKey($slotNumber);
        return (int) Cache::get($cacheKey, 0);
    }

    /**
     * Incrementa atomicamente a contagem diária de envios do slot.
     */
    public function incrementDailySends(int $slotNumber): int
    {
        $cacheKey = $this->getDailyCacheKey($slotNumber);
        $count = (int) Cache::increment($cacheKey);

        // Garante TTL de 48 horas no cache do Redis/Driver
        if ($count === 1) {
            Cache::put($cacheKey, 1, now()->addHours(48));
        }

        return $count;
    }

    /**
     * Gera a chave de cache diária para o slot.
     */
    protected function getDailyCacheKey(int $slotNumber): string
    {
        return 'resend_daily_sends_slot_' . $slotNumber . '_' . date('Y-m-d');
    }

    /**
     * Embaralhamento pseudo-aleatório seguro (Fisher-Yates com random_int).
     *
     * @param array<int, mixed> $array
     */
    protected function cryptoShuffle(array &$array): void
    {
        $count = count($array);
        for ($i = $count - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            $temp = $array[$i];
            $array[$i] = $array[$j];
            $array[$j] = $temp;
        }
    }

    public function isSlotInCooldown(int $slotNumber): bool
    {
        return (bool) Cache::get("resend_slot_cooldown_{$slotNumber}");
    }

    public function markSlotInCooldown(int $slotNumber): void
    {
        Cache::put("resend_slot_cooldown_{$slotNumber}", true, now()->addSeconds(self::COOLDOWN_SECONDS));
    }
}
