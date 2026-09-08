<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verificação em Duas Etapas (2FA) - SendPortal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: #09090b;
            color: #f4f4f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.12) 0%, rgba(0, 0, 0, 0) 70%);
            top: -150px;
            right: -150px;
            z-index: 0;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, rgba(0, 0, 0, 0) 70%);
            bottom: -150px;
            left: -150px;
            z-index: 0;
            pointer-events: none;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 1;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-icon {
            width: 54px;
            height: 54px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
            margin-bottom: 0.85rem;
        }

        .brand-title {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            color: #ffffff;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.25rem 0.75rem;
            background-color: #18181b;
            border: 1px solid #27272a;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            color: #10b981;
            margin-top: 0.5rem;
        }

        .brand-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #10b981;
            box-shadow: 0 0 8px #10b981;
        }

        .card {
            background-color: #121215;
            border: 1px solid #27272a;
            border-radius: 18px;
            padding: 2.25rem 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .card-heading {
            font-size: 1.25rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.35rem;
            text-align: center;
        }

        .card-subheading {
            font-size: 0.875rem;
            color: #a1a1aa;
            margin-bottom: 1.75rem;
            text-align: center;
            line-height: 1.45;
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

        .qr-section {
            background: #18181b;
            border: 1px solid #27272a;
            border-radius: 12px;
            padding: 1.25rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .qr-container {
            background: #ffffff;
            padding: 12px;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .secret-box {
            background: #09090b;
            border: 1px dashed #3f3f46;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-family: monospace;
            font-size: 1.05rem;
            letter-spacing: 0.15em;
            color: #38bdf8;
            font-weight: 700;
            user-select: all;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-copy {
            background: #27272a;
            border: 1px solid #3f3f46;
            color: #e4e4e7;
            padding: 0.3rem 0.65rem;
            border-radius: 6px;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-copy:hover {
            background: #3f3f46;
            color: #ffffff;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #e4e4e7;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .totp-input {
            width: 100%;
            background-color: #18181b;
            border: 2px solid #3f3f46;
            border-radius: 12px;
            padding: 0.85rem;
            font-size: 1.6rem;
            letter-spacing: 0.3em;
            text-align: center;
            color: #ffffff;
            outline: none;
            transition: all 0.2s ease;
            font-weight: 700;
        }

        .totp-input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
            background-color: #1c1c21;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 0.95rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.45);
            transform: translateY(-1px);
        }

        .cancel-link {
            display: block;
            text-align: center;
            margin-top: 1.25rem;
            font-size: 0.85rem;
            color: #71717a;
            text-decoration: none;
            transition: color 0.2s;
        }

        .cancel-link:hover {
            color: #e4e4e7;
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
    <!-- Lightweight Pure JS QRCode Generator -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body>
    <div class="auth-wrapper">
        <div class="brand-header">
            <div class="brand-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </div>
            <h1 class="brand-title">SendPortal</h1>
            <div class="brand-badge">
                <span class="brand-badge-dot"></span>
                Autenticação de Dois Fatores (2FA)
            </div>
        </div>

        <div class="card">
            @if ($mode === 'setup')
                <h2 class="card-heading">Configurar Autenticador</h2>
                <p class="card-subheading">
                    Escaneie o QR Code abaixo no seu aplicativo de autenticação (Proton Pass, Google Authenticator, 1Password) ou digite a chave manual.
                </p>

                <div class="qr-section">
                    <div class="qr-container" id="qrcode"></div>
                    <p style="font-size: 0.78rem; color: #a1a1aa; margin-bottom: 0.5rem;">Chave Secreta de Pareamento:</p>
                    <div class="secret-box">
                        <span id="secretText">{{ $secret }}</span>
                        <button type="button" class="btn-copy" onclick="copySecret()">Copiar</button>
                    </div>
                </div>
            @else
                <h2 class="card-heading">Código de Segurança</h2>
                <p class="card-subheading">
                    Digite o código de 6 dígitos gerado pelo aplicativo autenticador para o e-mail <strong>{{ $user->email }}</strong>.
                </p>
            @endif

            @if ($errors->any())
                <div class="alert-danger">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; margin-top:2px;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('login.2fa.verify') }}" id="twoFactorForm">
                @csrf

                <div class="form-group">
                    <label for="code">Token de 6 dígitos</label>
                    <input id="code" type="text" name="code" class="totp-input" maxlength="6" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code" required autofocus placeholder="000000">
                </div>

                <button type="submit" class="btn-submit" id="btnSubmit">
                    <span>{{ $mode === 'setup' ? 'Ativar e Entrar' : 'Validar e Acessar' }}</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </button>

                <a href="{{ route('login') }}" class="cancel-link">← Voltar para o login</a>
            </form>
        </div>

        <div class="footer-note">
            <span>Deskcomm Enterprise</span>
            <span class="footer-dot"></span>
            <span>Motor RFC 6238</span>
            <span class="footer-dot"></span>
            <span>Cloud VPS</span>
        </div>
    </div>

    @if ($mode === 'setup')
    <script>
        new QRCode(document.getElementById("qrcode"), {
            text: "{!! $otpAuthUri !!}",
            width: 170,
            height: 170,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.M
        });

        function copySecret() {
            var text = document.getElementById('secretText').innerText;
            navigator.clipboard.writeText(text).then(function() {
                alert('Chave secreta copiada para a área de transferência!');
            });
        }
    </script>
    @endif

    <script>
        document.getElementById('twoFactorForm').addEventListener('submit', function() {
            var btn = document.getElementById('btnSubmit');
            btn.style.opacity = '0.7';
            btn.innerHTML = '<span>Verificando...</span>';
        });
    </script>
</body>
</html>
