<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SendPortal - Verificação em Duas Etapas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-base: #09090b;
            --surface-card: rgba(18, 18, 22, 0.85);
            --surface-card-border: rgba(255, 255, 255, 0.1);
            --surface-input: #121216;
            --surface-input-border: #27272a;
            --surface-input-focus: #10b981;
            --text-main: #f4f4f5;
            --text-muted: #a1a1aa;
            --text-subtle: #71717a;
            --primary: #10b981;
            --primary-hover: #059669;
            --danger-bg: rgba(239, 68, 68, 0.12);
            --danger-border: rgba(239, 68, 68, 0.3);
            --danger-text: #f87171;
            --radius-card: 20px;
            --radius-btn: 10px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-base);
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(56, 189, 248, 0.05) 0px, transparent 50%);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            -webkit-font-smoothing: antialiased;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0.05) 100%);
            border: 1px solid rgba(16, 185, 129, 0.3);
            margin-bottom: 1rem;
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.15);
        }

        .brand-icon-wrapper svg {
            color: #10b981;
        }

        .brand-title {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #ffffff;
            margin-bottom: 0.25rem;
        }

        .badge-security {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: 0.02em;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: var(--primary);
            box-shadow: 0 0 8px var(--primary);
        }

        .glass-card {
            background: var(--surface-card);
            border: 1px solid var(--surface-card-border);
            border-radius: var(--radius-card);
            padding: 2.25rem 2rem;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .card-header {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #ffffff;
            margin-bottom: 0.5rem;
        }

        .card-desc {
            font-size: 0.875rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .card-desc strong {
            color: var(--text-main);
            font-weight: 600;
        }

        /* QR Code Container for Setup Mode */
        .qr-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1.75rem;
            padding: 1.25rem;
            background: rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
        }

        .qr-code-box {
            padding: 10px;
            background: #ffffff;
            border-radius: 10px;
            margin-bottom: 1rem;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.4);
        }

        .secret-container {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #18181b;
            border: 1px solid #27272a;
            border-radius: 8px;
            padding: 0.6rem 0.85rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.95rem;
            color: #38bdf8;
            font-weight: 700;
            letter-spacing: 0.1em;
        }

        .btn-copy {
            background: #27272a;
            border: 1px solid #3f3f46;
            color: #e4e4e7;
            padding: 0.3rem 0.65rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-copy:hover {
            background: #3f3f46;
            color: #ffffff;
        }

        /* 6-Digit Segmented Input - Alinhado rigorosamente ao TOTPInput do Deskcomm CRM */
        .totp-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin: 1.5rem 0 1.75rem 0;
        }

        .totp-digit {
            width: 46px;
            height: 56px;
            background-color: var(--surface-input);
            border: 1px solid var(--surface-input-border);
            border-radius: 10px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.6rem;
            font-weight: 700;
            text-align: center;
            color: #ffffff;
            outline: none;
            transition: all 0.15s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .totp-digit:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
            background-color: #16161b;
            transform: translateY(-1px);
        }

        .totp-digit.has-value {
            border-color: rgba(255, 255, 255, 0.2);
        }

        .totp-digit:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            border-color: #27272a;
        }

        /* Alert / Lockout Banner */
        .alert-banner {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            font-weight: 500;
            background-color: var(--danger-bg);
            border: 1px solid var(--danger-border);
            color: var(--danger-text);
            text-align: left;
        }

        .alert-banner svg {
            flex-shrink: 0;
        }

        /* Submit Action Button */
        .btn-submit {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-btn);
            font-size: 0.95rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover:not(:disabled) {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.45);
            transform: translateY(-1px);
        }

        .btn-submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        .cancel-link {
            display: block;
            text-align: center;
            margin-top: 1.25rem;
            font-size: 0.85rem;
            color: var(--text-subtle);
            text-decoration: none;
            transition: color 0.15s;
        }

        .cancel-link:hover {
            color: var(--text-main);
        }

        .footer-note {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.78rem;
            color: var(--text-subtle);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .footer-dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background-color: #3f3f46;
        }
    </style>
    @if ($mode === 'setup')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    @endif
</head>
<body>
    <div class="auth-container">
        <div class="brand-header">
            <div class="brand-icon-wrapper">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </div>
            <h1 class="brand-title">SendPortal</h1>
            <div class="badge-security">
                <span class="badge-dot"></span>
                Verificação em Duas Etapas (2FA)
            </div>
        </div>

        <div class="glass-card">
            <div class="card-header">
                @if ($mode === 'setup')
                    <h2 class="card-title">Configurar Autenticador</h2>
                    <p class="card-desc">
                        Escaneie o QR Code abaixo no seu aplicativo (Google Authenticator, Proton Pass, 1Password) ou insira a chave manual.
                    </p>
                @else
                    <h2 class="card-title">Código de Segurança</h2>
                    <p class="card-desc">
                        Digite o código de 6 dígitos gerado pelo aplicativo autenticador para <strong>{{ $user->email }}</strong>.
                    </p>
                @endif
            </div>

            @if ($mode === 'setup')
                <div class="qr-wrapper">
                    <div class="qr-code-box" id="qrcode"></div>
                    <div style="width: 100%; text-align: left; margin-bottom: 0.4rem;">
                        <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">Chave Secreta de Pareamento:</span>
                    </div>
                    <div class="secret-container">
                        <span id="secretKeyText">{{ $secret }}</span>
                        <button type="button" class="btn-copy" onclick="copySecretKey()">Copiar</button>
                    </div>
                </div>
            @endif

            @php
                $initialSeconds = session('secondsLeft', $secondsLeft ?? 0);
            @endphp

            <div id="lockoutAlert" class="alert-banner" style="{{ $errors->any() || $initialSeconds > 0 ? '' : 'display: none;' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <div id="alertMessage">
                    @if ($initialSeconds > 0)
                        Muitas tentativas. Tente novamente em <span id="timerSpan">{{ $initialSeconds }}</span>s.
                    @elseif ($errors->any())
                        {{ $errors->first() }}
                    @endif
                </div>
            </div>

            <form method="POST" action="{{ route('login.2fa.verify') }}" id="totpForm" autocomplete="off">
                @csrf
                <input type="hidden" name="code" id="fullCode" value="">

                <!-- 6 Caixas Independentes de Dígitos (Idêntico ao Deskcomm CRM) -->
                <div class="totp-group" role="group" aria-label="Código de 6 dígitos">
                    <input class="totp-digit" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]*" autocomplete="one-time-code" data-index="0" autofocus>
                    <input class="totp-digit" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]*" autocomplete="off" data-index="1">
                    <input class="totp-digit" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]*" autocomplete="off" data-index="2">
                    <input class="totp-digit" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]*" autocomplete="off" data-index="3">
                    <input class="totp-digit" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]*" autocomplete="off" data-index="4">
                    <input class="totp-digit" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]*" autocomplete="off" data-index="5">
                </div>

                <button type="submit" class="btn-submit" id="btnSubmit" disabled>
                    <span>{{ $mode === 'setup' ? 'Ativar e Entrar' : 'Validar e Acessar' }}</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </button>

                <a href="{{ route('login') }}" class="cancel-link">← Cancelar e voltar para o login</a>
            </form>
        </div>

        <div class="footer-note">
            <span>Deskcomm Enterprise</span>
            <span class="footer-dot"></span>
            <span>Chave de Acesso RFC 6238</span>
            <span class="footer-dot"></span>
            <span>Cloud VPS</span>
        </div>
    </div>

    @if ($mode === 'setup')
    <script>
        new QRCode(document.getElementById("qrcode"), {
            text: "{!! $otpAuthUri !!}",
            width: 160,
            height: 160,
            colorDark: "#09090b",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.M
        });

        function copySecretKey() {
            var text = document.getElementById('secretKeyText').innerText.trim();
            navigator.clipboard.writeText(text).then(function() {
                alert('Chave de segurança copiada!');
            });
        }
    </script>
    @endif

    <script>
        (function() {
            const form = document.getElementById('totpForm');
            const hiddenInput = document.getElementById('fullCode');
            const btnSubmit = document.getElementById('btnSubmit');
            const digits = Array.from(document.querySelectorAll('.totp-digit'));
            const alertBanner = document.getElementById('lockoutAlert');
            const alertMessage = document.getElementById('alertMessage');
            const timerSpan = document.getElementById('timerSpan');

            let secondsLeft = {{ (int) $initialSeconds }};
            let isLocked = secondsLeft > 0;

            function updateLockoutState() {
                if (secondsLeft > 0) {
                    isLocked = true;
                    digits.forEach(d => d.disabled = true);
                    btnSubmit.disabled = true;
                    if (timerSpan) {
                        timerSpan.textContent = secondsLeft;
                    }
                    secondsLeft--;
                    setTimeout(updateLockoutState, 1000);
                } else if (isLocked) {
                    isLocked = false;
                    digits.forEach(d => d.disabled = false);
                    alertBanner.style.display = 'none';
                    digits[0].focus();
                    checkCompletion();
                }
            }

            if (isLocked) {
                updateLockoutState();
            }

            function getJoinedCode() {
                return digits.map(d => d.value).join('');
            }

            function checkCompletion() {
                const code = getJoinedCode();
                hiddenInput.value = code;
                const isComplete = (code.length === 6 && digits.every(d => d.value !== ''));
                btnSubmit.disabled = !isComplete || isLocked;
                return isComplete;
            }

            digits.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    const val = input.value.replace(/\D/g, '');
                    input.value = val.slice(-1);
                    if (input.value) {
                        input.classList.add('has-value');
                        if (index < digits.length - 1) {
                            digits[index + 1].focus();
                        }
                    } else {
                        input.classList.remove('has-value');
                    }

                    if (checkCompletion()) {
                        // Submissão instantânea ao preencher o 6º dígito (idêntico ao Deskcomm CRM)
                        triggerSubmit();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace') {
                        if (input.value) {
                            input.value = '';
                            input.classList.remove('has-value');
                            checkCompletion();
                        } else if (index > 0) {
                            digits[index - 1].focus();
                            digits[index - 1].value = '';
                            digits[index - 1].classList.remove('has-value');
                            checkCompletion();
                        }
                    } else if (e.key === 'ArrowLeft' && index > 0) {
                        e.preventDefault();
                        digits[index - 1].focus();
                    } else if (e.key === 'ArrowRight' && index < digits.length - 1) {
                        e.preventDefault();
                        digits[index + 1].focus();
                    }
                });

                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const text = (e.clipboardData || window.clipboardData).getData('text') || '';
                    const clean = text.replace(/\D/g, '').slice(0, 6);
                    if (!clean) return;

                    clean.split('').forEach((char, i) => {
                        if (digits[i]) {
                            digits[i].value = char;
                            digits[i].classList.add('has-value');
                        }
                    });

                    const lastIdx = Math.min(clean.length, 5);
                    digits[lastIdx].focus();

                    if (checkCompletion()) {
                        triggerSubmit();
                    }
                });

                input.addEventListener('focus', () => {
                    input.select();
                });
            });

            function triggerSubmit() {
                if (isLocked) return;
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<span>Verificando...</span>';
                form.submit();
            }

            form.addEventListener('submit', function(e) {
                if (!checkCompletion() || isLocked) {
                    e.preventDefault();
                    return;
                }
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<span>Verificando...</span>';
            });
        })();
    </script>
</body>
</html>
