<!DOCTYPE html>
<html lang="pt-BR" data-theme="mcp-os-multi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar | SendPortal Enterprise</title>

    <script>
        (function() {
            var theme = localStorage.getItem("sendportal_theme") || "mcp-os-multi";
            document.documentElement.setAttribute("data-theme", theme);
            var bgId = localStorage.getItem("sendportal_bg") || "strands";
            var shaderPalettes = {
                strands: "radial-gradient(ellipse at 50% 50%, #20113a 0%, #080611 50%, #040407 100%)",
                siderays: "radial-gradient(ellipse at 80% 20%, #1f1b2e 0%, #090614 60%, #040407 100%)",
                plasmawave: "radial-gradient(ellipse at 50% 50%, #220e38 0%, #08111e 60%, #040407 100%)",
                ferrofluid: "radial-gradient(ellipse at 50% 50%, #151520 0%, #08080d 60%, #040407 100%)",
                softaurora: "radial-gradient(ellipse at 50% 30%, #0e2428 0%, #0f1226 60%, #040407 100%)",
                dither: "radial-gradient(ellipse at 50% 50%, #1a102f 0%, #090514 60%, #040407 100%)",
                darkveil: "radial-gradient(ellipse at 50% 50%, #140b1e 0%, #06040a 60%, #040407 100%)",
                acidsquares: "radial-gradient(ellipse at 50% 50%, #1e1335 0%, #070712 60%, #040407 100%)",
                webthreads: "radial-gradient(ellipse at 50% 50%, #161a30 0%, #070a14 60%, #040407 100%)",
                balatro: "radial-gradient(ellipse at 50% 50%, #260d26 0%, #0c050f 60%, #040407 100%)",
                moltenmetal: "radial-gradient(ellipse at 50% 50%, #28120e 0%, #0c0505 60%, #040407 100%)",
                topography: "radial-gradient(ellipse at 50% 50%, #180e2b 0%, #080512 60%, #040407 100%)",
                lighttunnel: "radial-gradient(ellipse at 50% 50%, #1d0f36 0%, #060814 60%, #040407 100%)"
            };
            var initialBgStyle = shaderPalettes[bgId] || "radial-gradient(ellipse at 50% 50%, #1a102f 0%, #040407 100%)";
            document.write('<style>#bg-container { background: ' + initialBgStyle + ' !important; }</style>');
        })();
    </script>

    <link href="{{ asset('css/mcp-os-multi.css') }}?v=mcpos-3.1" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: transparent !important;
            color: #f4f4f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 1.5rem;
            position: relative;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(28px) saturate(170%);
            -webkit-backdrop-filter: blur(28px) saturate(170%);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 20px;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.18);
            padding: 2.25rem 2rem;
            position: relative;
            z-index: 10;
        }

        .login-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.65);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 0.4rem;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: #ffffff;
            outline: none;
            transition: all 0.2s ease;
            backdrop-filter: blur(16px);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(168, 85, 247, 0.6);
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.25);
        }

        .form-extra {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            font-size: 0.8125rem;
        }

        .remember-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            padding: 0.8rem;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(139, 92, 246, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            box-shadow: 0 6px 22px rgba(168, 85, 247, 0.55);
            transform: translateY(-1px);
        }

        .footer-note {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.45);
            position: relative;
            z-index: 10;
        }
    </style>
</head>
<body>

    <!-- Background Motor Permanente -->
    <div id="bg-container">
        <div class="bg-slide active" id="bg-slide-1"></div>
        <div class="bg-slide" id="bg-slide-2"></div>
        <div id="bg-webgl-container"></div>
    </div>
    <div id="bg-overlay"></div>

    <div class="login-card">
        <div class="login-header">
            <h1>SendPortal</h1>
            <p>Entre para gerenciar suas campanhas</p>
        </div>

        @if ($errors->any())
            <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 0.75rem 1rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: 0.8125rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            <div class="form-group">
                <label for="email">E-mail ou Usuário</label>
                <div class="input-wrapper">
                    <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="seu@email.com">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password" placeholder="••••••••">
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
        <span>MCP OS Glass System</span>
        <span> • </span>
        <span>SendPortal Enterprise</span>
    </div>

    <script type="module" src="{{ asset('js/mcp-os-webgl.js') }}?v=mcpos-3.1"></script>
    <script type="module" src="{{ asset('js/mcp-os-theme-manager.js') }}?v=mcpos-3.1"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            var btn = document.getElementById('btnSubmit');
            btn.style.opacity = '0.7';
            btn.innerHTML = '<span>Autenticando...</span>';
        });
    </script>
</body>
</html>
