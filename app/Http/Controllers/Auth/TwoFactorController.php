<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\TotpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class TwoFactorController extends Controller
{
    private const MAX_ATTEMPTS = 5;
    private const LOCKOUT_SECONDS = 60;

    public function show2fa(TotpService $totp): View|RedirectResponse
    {
        $userId = session('2fa:user:id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);
        if (!$user) {
            session()->forget('2fa:user:id');
            return redirect()->route('login');
        }

        $lockoutKey = "2fa:lockout:{$user->id}";
        $lockoutUntil = Cache::get($lockoutKey);
        $secondsLeft = 0;
        if ($lockoutUntil && $lockoutUntil > now()->timestamp) {
            $secondsLeft = $lockoutUntil - now()->timestamp;
        }

        // Se já possui 2FA confirmado, pede apenas o token
        if ($user->two_factor_secret && $user->two_factor_confirmed_at) {
            return view('auth.two_factor', [
                'mode' => 'verify',
                'user' => $user,
                'secondsLeft' => $secondsLeft,
            ]);
        }

        // Primeiro acesso: gerar segredo e exibir dados de pareamento
        $secret = session('2fa:setup:secret');
        if (!$secret) {
            $secret = $totp->generateSecret();
            session(['2fa:setup:secret' => $secret]);
        }

        $otpAuthUri = $totp->getOtpAuthUri('SendPortal', $user->email, $secret);
        $formattedSecret = $totp->formatSecret($secret);

        return view('auth.two_factor', [
            'mode' => 'setup',
            'user' => $user,
            'secret' => $secret,
            'formattedSecret' => $formattedSecret,
            'otpAuthUri' => $otpAuthUri,
            'secondsLeft' => $secondsLeft,
        ]);
    }

    public function verify2fa(Request $request, TotpService $totp): RedirectResponse
    {
        $userId = session('2fa:user:id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::findOrFail($userId);

        $lockoutKey = "2fa:lockout:{$user->id}";
        $attemptsKey = "2fa:attempts:{$user->id}";

        $lockoutUntil = Cache::get($lockoutKey);
        if ($lockoutUntil && $lockoutUntil > now()->timestamp) {
            $remaining = $lockoutUntil - now()->timestamp;
            return back()->withErrors([
                'code' => "Muitas tentativas incorretas. Aguarde {$remaining} segundos e tente novamente.",
            ])->with('secondsLeft', $remaining);
        }

        $rawCode = (string) ($request->input('code') ?? '');
        // Sanitiza espaços e hífens para conveniência do usuário (ex: "123 456" ou "123-456")
        $cleanCode = preg_replace('/\D/', '', $rawCode);

        if (strlen($cleanCode) !== 6) {
            return back()->withErrors([
                'code' => 'Informe o código completo de 6 dígitos gerado pelo seu autenticador.',
            ]);
        }

        // Caso 1: Configuração inicial (Setup)
        if (!$user->two_factor_confirmed_at) {
            $secret = session('2fa:setup:secret');
            if (!$secret || !$totp->verify($secret, $cleanCode)) {
                $this->handleFailedAttempt($user->id, $attemptsKey, $lockoutKey);
                $remaining = Cache::has($lockoutKey) ? (Cache::get($lockoutKey) - now()->timestamp) : 0;
                $msg = $remaining > 0 
                    ? "Muitas tentativas incorretas. Aguarde {$remaining} segundos e tente novamente."
                    : 'Código de autenticação incorreto. Verifique o relógio do aparelho e tente novamente.';
                return back()->withErrors(['code' => $msg])->with('secondsLeft', $remaining);
            }

            // Sucesso na ativação do 2FA
            $user->two_factor_secret = encrypt($secret);
            $user->two_factor_confirmed_at = now();
            $user->save();

            $this->clearRateLimit($attemptsKey, $lockoutKey);

            session()->forget(['2fa:user:id', '2fa:setup:secret']);
            $remember = session('2fa:remember', false);
            session()->forget('2fa:remember');

            // Emissão da chave de acesso / sessão autenticada SOMENTE AQUI
            Auth::loginUsingId($user->id, $remember);
            $request->session()->regenerate();

            return redirect()->route('sendportal.dashboard');
        }

        // Caso 2: Login com 2FA já configurado (Verify)
        try {
            $secret = decrypt($user->two_factor_secret);
        } catch (\Exception $e) {
            return back()->withErrors([
                'code' => 'Erro ao descriptografar chave de segurança. Contate o suporte.',
            ]);
        }

        if (!$totp->verify($secret, $cleanCode)) {
            $this->handleFailedAttempt($user->id, $attemptsKey, $lockoutKey);
            $remaining = Cache::has($lockoutKey) ? (Cache::get($lockoutKey) - now()->timestamp) : 0;
            $msg = $remaining > 0 
                ? "Muitas tentativas incorretas. Aguarde {$remaining} segundos e tente novamente."
                : 'Código de autenticação incorreto ou expirado. Tente novamente.';
            return back()->withErrors(['code' => $msg])->with('secondsLeft', $remaining);
        }

        // Sucesso na validação do 2FA
        $this->clearRateLimit($attemptsKey, $lockoutKey);

        session()->forget('2fa:user:id');
        $remember = session('2fa:remember', false);
        session()->forget('2fa:remember');

        // Emissão da chave de acesso / sessão autenticada SOMENTE AQUI
        Auth::loginUsingId($user->id, $remember);
        $request->session()->regenerate();

        return redirect()->route('sendportal.dashboard');
    }

    private function handleFailedAttempt(int $userId, string $attemptsKey, string $lockoutKey): void
    {
        $attempts = (int) Cache::get($attemptsKey, 0) + 1;
        Cache::put($attemptsKey, $attempts, now()->addMinutes(15));

        if ($attempts >= self::MAX_ATTEMPTS) {
            Cache::put($lockoutKey, now()->addSeconds(self::LOCKOUT_SECONDS)->timestamp, now()->addSeconds(self::LOCKOUT_SECONDS));
            Cache::forget($attemptsKey);
        }
    }

    private function clearRateLimit(string $attemptsKey, string $lockoutKey): void
    {
        Cache::forget($attemptsKey);
        Cache::forget($lockoutKey);
    }
}
