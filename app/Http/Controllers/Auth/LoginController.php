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
     * Permite autenticacao com os aliases do administrador via hash seguro no banco.
     */
    protected function attemptLogin(Request $request)
    {
        $inputEmail = strtolower(trim((string) $request->input('email', '')));
        $password = (string) $request->input('password', '');
        $remember = $request->boolean('remember');

        $adminAliases = ['mcp6667@proton.me', 'admin@sendportal.local', 'admin@localhost'];

        if (in_array($inputEmail, $adminAliases, true)) {
            $user = User::find(1);
            if ($user && Hash::check($password, $user->password)) {
                $this->guard()->login($user, $remember);
                return true;
            }
        }

        return $this->guard()->attempt(
            $this->credentials($request), $remember
        );
    }

    /**
     * Intercepta login bem-sucedido para exigir verificacao em duas etapas (2FA / TOTP)
     */
    protected function authenticated(Request $request, $user)
    {
        Auth::logout();

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
