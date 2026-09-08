<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar | SendPortal Enterprise</title>
    <script>
        if (window.location.protocol === 'http:' && window.location.hostname !== 'localhost' && window.location.hostname !== '127.0.0.1') {
            window.location.href = window.location.href.replace('http:', 'https:');
        }
    </script>
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #09090b;
            color: #f4f4f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: -150px;
            left: 50%;
            transform: translateX(-50%);
            width: 700px;
            height: 500px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.18) 0%, rgba(9, 9, 11, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.15) inset;
            margin-bottom: 1.25rem;
            transition: transform 0.2s ease;
        }

        .brand-icon:hover {
            transform: scale(1.04);
        }

        .brand-title {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: #ffffff;
            margin-bottom: 0.35rem;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            background: rgba(37, 99, 235, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #60a5fa;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .brand-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #3b82f6;
            box-shadow: 0 0 8px #3b82f6;
        }

        .card {
            background-color: #121215;
            border: 1px solid #27272a;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 0 1px rgba(255, 255, 255, 0.05) inset;
            backdrop-filter: blur(12px);
            padding: 2.25rem 2rem;
        }

        .card-heading {
            font-size: 1.15rem;
            font-weight: 600;
            color: #f4f4f5;
            margin-bottom: 0.5rem;
        }

        .card-subheading {
            font-size: 0.875rem;
            color: #a1a1aa;
            margin-bottom: 1.75rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: #d4d4d8;
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: #71717a;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            background-color: #18181b;
            border: 1px solid #3f3f46;
            border-radius: 10px;
            padding: 0.85rem 1rem 0.85rem 2.75rem;
            font-size: 0.95rem;
            color: #ffffff;
            outline: none;
            transition: all 0.2s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
            background-color: #1c1c21;
        }

        input::placeholder {
            color: #52525b;
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 0.85rem 1rem;
            border-radius: 10px;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 0.65rem;
        }

        .form-extra {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }

        .remember-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            color: #a1a1aa;
            user-select: none;
        }

        .remember-group input[type="checkbox"] {
            accent-color: #3b82f6;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 0.9rem;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.01em;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45);
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(37, 99, 235, 0.25);
        }

        .footer-note {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.8rem;
            color: #71717a;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .footer-dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background-color: #52525b;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="brand-header">
            <div class="brand-icon">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
            </div>
            <h1 class="brand-title">SendPortal</h1>
            <div class="brand-badge">
                <span class="brand-badge-dot"></span>
                Cluster de E-mails Ativo
            </div>
        </div>

        <div class="card">
            <h2 class="card-heading">Acessar Painel</h2>
            <p class="card-subheading">Entre com suas credenciais corporativas</p>

            @if ($errors->any())
                <div class="alert-danger">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; margin-top:2px;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <div>
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="form-group">
                    <label for="email">E-mail do Administrador</label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email', 'admin@sendportal.local') }}" required autofocus placeholder="admin@sendportal.local">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Senha de Acesso</label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <input id="password" type="password" name="password" required placeholder="••••••••">
                    </div>
                </div>

                <div class="form-extra">
                    <label class="remember-group">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember', true) ? 'checked' : '' }}>
                        <span>Lembrar credenciais</span>
                    </label>
                </div>

                <button type="submit" class="btn-submit" id="btnSubmit">
                    <span>Entrar no SendPortal</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </button>
            </form>
        </div>

        <div class="footer-note">
            <span>Deskcomm Enterprise</span>
            <span class="footer-dot"></span>
            <span>SendPortal Core v2</span>
            <span class="footer-dot"></span>
            <span>Cloud VPS</span>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            var btn = document.getElementById('btnSubmit');
            btn.style.opacity = '0.7';
            btn.innerHTML = '<span>Autenticando...</span>';
        });
    </script>
</body>
</html>
