<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\TotpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TwoFactorController extends Controller
{
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

        // Se já possui 2FA confirmado, pede apenas o token
        if ($user->two_factor_secret && $user->two_factor_confirmed_at) {
            return view('auth.two_factor', [
                'mode' => 'verify',
                'user' => $user,
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
        ]);
    }

    public function verify2fa(Request $request, TotpService $totp): RedirectResponse
    {
        $userId = session('2fa:user:id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $request->validate([
            'code' => ['required', 'string'],
        ], [
            'code.required' => 'Informe o código de 6 dígitos gerado pelo seu autenticador.',
        ]);

        $user = User::findOrFail($userId);

        // Caso 1: Configuração inicial (Setup)
        if (!$user->two_factor_confirmed_at) {
            $secret = session('2fa:setup:secret');
            if (!$secret || !$totp->verify($secret, (string) $request->code)) {
                return back()->withErrors([
                    'code' => 'Código de autenticação incorreto. Verifique o relógio do aparelho e tente novamente.',
                ]);
            }

            $user->two_factor_secret = encrypt($secret);
            $user->two_factor_confirmed_at = now();
            $user->save();

            session()->forget(['2fa:user:id', '2fa:setup:secret']);
            $remember = session('2fa:remember', false);
            session()->forget('2fa:remember');

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

        if (!$totp->verify($secret, (string) $request->code)) {
            return back()->withErrors([
                'code' => 'Código de autenticação incorreto ou expirado. Tente novamente.',
            ]);
        }

        session()->forget('2fa:user:id');
        $remember = session('2fa:remember', false);
        session()->forget('2fa:remember');

        Auth::loginUsingId($user->id, $remember);
        $request->session()->regenerate();

        return redirect()->route('sendportal.dashboard');
    }
}
