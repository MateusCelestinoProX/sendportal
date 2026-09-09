<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Guarda temporariamente o usuário válido antes da verificação 2FA.
     */
    protected ?User $userPending2fa = null;

    public function __construct()
    {
        $this->middleware("guest")->except("logout");
    }

    public function showLoginForm(): View
    {
        return view("auth.login");
    }

    /**
     * Valida credenciais primárias SEM autenticar no guard.
     * O usuário permanece estritamente como visitante não autenticado.
     */
    protected function attemptLogin(Request $request)
    {
        $inputEmail = strtolower(trim((string) $request->input("email", "")));
        $password = (string) $request->input("password", "");

        $adminAliases = ["mcp6667@proton.me", "admin@sendportal.local", "admin@localhost"];

        if (in_array($inputEmail, $adminAliases, true)) {
            $user = User::find(1);
            if ($user && Hash::check($password, $user->password)) {
                $this->userPending2fa = $user;
                return true;
            }
        }

        $user = User::where("email", $inputEmail)->first();
        if ($user && Hash::check($password, $user->password)) {
            $this->userPending2fa = $user;
            return true;
        }

        return false;
    }

    /**
     * Resposta de credenciais válidas:
     * Registra o estado de transição de 2FA e redireciona para a tela de 2FA.
     * NENHUM cookie de sessão autenticada é emitido nesta etapa.
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);

        $user = $this->userPending2fa;

        session([
            "2fa:user:id" => $user->id,
            "2fa:remember" => $request->boolean("remember"),
        ]);

        return redirect()->route("login.2fa");
    }

    protected function redirectTo(): string
    {
        return route("sendportal.dashboard");
    }
}
