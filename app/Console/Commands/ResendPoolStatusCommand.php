<?php

namespace App\Console\Commands;

use App\Adapters\ResendMailAdapter;
use Illuminate\Console\Command;
use Sendportal\Base\Models\EmailService;

class ResendPoolStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resend:pool-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exibe o status, cotas e saúde dos slots do pool Resend Multi-Key';

    /**
     * Subdomínios conhecidos associados a cada slot no cluster production.
     */
    protected array $subdomains = [
        1 => 'carlinhos.automationai.fun',
        2 => 'serjao.automationai.fun',
        3 => 'drogadinho.automationai.fun',
        4 => 'mateus.automationai.fun',
        5 => 'alunos.automationai.fun',
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $services = EmailService::where('type_id', 8)->get();

        if ($services->isEmpty()) {
            $this->error('Nenhum serviço Resend (type_id=8) encontrado no SendPortal.');
            return 1;
        }

        foreach ($services as $service) {
            $this->info("=== Workspace #{$service->workspace_id} - {$service->name} ===");
            $adapter = new ResendMailAdapter($service->settings);
            $activeSlots = collect($adapter->resolveActiveKeySlots())->keyBy('slot');

            $rows = [];
            for ($i = 1; $i <= 10; $i++) {
                $isActive = $activeSlots->has($i);
                $key = $isActive ? $activeSlots->get($i)['key'] : null;
                $maskedKey = $key ? substr($key, 0, 8) . '...' . substr($key, -4) : '-';
                $subdomain = $this->subdomains[$i] ?? '-';
                $sendsToday = $isActive ? $adapter->getDailySendsCount($i) : 0;
                $inCooldown = $isActive && $adapter->isSlotInCooldown($i);

                $status = $isActive
                    ? ($inCooldown ? '<fg=yellow>COOLDOWN</>' : '<fg=green>ATIVO</>')
                    : '<fg=gray>DESATIVADO</>';

                $rows[] = [
                    "Slot #{$i}",
                    $status,
                    $subdomain,
                    $maskedKey,
                    "{$sendsToday} / " . ResendMailAdapter::DAILY_FREE_LIMIT,
                    $inCooldown ? 'Sim' : 'Não',
                ];
            }

            $this->table(
                ['Slot', 'Status', 'Subdomínio Verificado', 'Chave (Mascarada)', 'Envios Hoje', 'Cooldown'],
                $rows
            );
            $this->newLine();
        }

        return 0;
    }
}
