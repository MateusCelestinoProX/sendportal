<div class="resend-multi-key-container mb-4 w-100">
    <!-- Header informativo Resend API -->
    <div class="resend-info-card p-4 mb-4" style="background: #09090b; border: 1px solid #27272a; border-radius: 12px; box-shadow: 0 4px 25px rgba(0, 0, 0, 0.6);">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center">
                <span class="badge px-3 py-2 mr-3" style="background: #ffffff; color: #000000; font-weight: 900; letter-spacing: 0.8px; font-size: 0.88rem; border-radius: 6px;">
                    ⚡ RESEND API
                </span>
                <span class="font-weight-bold" style="color: #ffffff; font-size: 1rem;">
                    Carga Randomizada &amp; Failover Automático
                </span>
            </div>
            <div class="mt-2 mt-md-0">
                <span class="badge" style="background: #18181b; color: #ffffff; border: 1px solid #3f3f46; font-size: 0.8rem; padding: 7px 12px; border-radius: 6px;">
                    100 envios/dia por chave ativa
                </span>
            </div>
        </div>

        <p class="mb-3" style="color: #e4e4e7; line-height: 1.6; font-size: 0.92rem;">
            O SendPortal opera de forma nativa e integrada com o núcleo da <strong>Resend</strong>. 
            A carga de trabalho é <strong>probabilisticamente randomizada</strong> a cada disparo entre todas as chaves ativas para máxima entrega e confiabilidade.
        </p>

        <div class="row pt-3" style="border-top: 1px solid #1f1f23;">
            <div class="col-lg-4 col-md-6 mb-2">
                <div class="p-2 d-flex align-items-center" style="background: rgba(255, 255, 255, 0.02); border-radius: 6px; border: 1px solid #1f1f23;">
                    <span class="mr-2" style="font-size: 1.1rem;">🔒</span>
                    <span style="color: #d4d4d8; font-size: 0.82rem;">
                        <strong>Desativação Automática:</strong> Campos vazios ficam 100% desativados.
                    </span>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-2">
                <div class="p-2 d-flex align-items-center" style="background: rgba(255, 255, 255, 0.02); border-radius: 6px; border: 1px solid #1f1f23;">
                    <span class="mr-2" style="font-size: 1.1rem;">🎲</span>
                    <span style="color: #d4d4d8; font-size: 0.82rem;">
                        <strong>Carga Randomizada:</strong> Sorteio estocástico a cada envio.
                    </span>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-2">
                <div class="p-2 d-flex align-items-center" style="background: rgba(255, 255, 255, 0.02); border-radius: 6px; border: 1px solid #1f1f23;">
                    <span class="mr-2" style="font-size: 1.1rem;">🛡️</span>
                    <span style="color: #d4d4d8; font-size: 0.82rem;">
                        <strong>Failover 429:</strong> Cooldown de 60s se atingir limite de taxa.
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid com as Chaves de API no Canvas Total -->
    <div class="row">
        @for ($i = 1; $i <= 10; $i++)
            @php
                $keyVal = Arr::get($settings ?? [], "key_{$i}") 
                    ?: Arr::get($settings ?? [], "keys.{$i}") 
                    ?: ($i === 1 ? Arr::get($settings ?? [], 'key') : '');
                $keyVal = is_string($keyVal) ? trim($keyVal) : '';
                $isConfigured = ! empty($keyVal);
                
                // Consulta envios de hoje para o slot se houver
                $cacheKey = 'resend_daily_sends_slot_' . $i . '_' . date('Y-m-d');
                $todaySends = (int) \Illuminate\Support\Facades\Cache::get($cacheKey, 0);
                $percent = min(100, $todaySends);
            @endphp
            <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                <div class="card h-100 resend-slot-card" id="slot-card-{{ $i }}" style="background: #000000; border: 1px solid {{ $isConfigured ? '#3f3f46' : '#27272a' }}; border-radius: 12px; transition: all 0.2s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.5);">
                    <div class="card-body p-3 p-xl-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <span class="badge mr-2 px-2 py-1" style="background: #18181b; color: #ffffff; border: 1px solid #27272a; font-family: monospace; font-size: 0.8rem; font-weight: 700;">
                                    #{{ sprintf('%02d', $i) }}
                                </span>
                                <span class="font-weight-bold" style="color: #ffffff; font-size: 0.95rem;">
                                    Chave {{ sprintf('%02d', $i) }}
                                </span>
                                @if($i === 1)
                                    <span class="badge ml-2" style="background: #27272a; color: #ffffff; font-size: 0.7rem; font-weight: 700; border-radius: 4px;">
                                        Primário
                                    </span>
                                @endif
                            </div>

                            <div>
                                <span 
                                    class="badge slot-status-badge" 
                                    id="badge-slot-{{ $i }}"
                                    style="{{ $isConfigured ? 'background: #052e16; color: #4ade80; border: 1px solid #166534;' : 'background: #18181b; color: #71717a; border: 1px solid #27272a;' }} font-size: 0.75rem; padding: 5px 10px; border-radius: 6px; font-weight: 600;"
                                >
                                    {{ $isConfigured ? '● Ativa no Pool (Randomizada)' : '○ Desativada (Vazia)' }}
                                </span>
                            </div>
                        </div>

                        <div class="input-group mb-2">
                            <input 
                                type="password" 
                                name="settings[key_{{ $i }}]" 
                                id="resend-key-{{ $i }}"
                                class="form-control resend-key-input" 
                                data-slot="{{ $i }}"
                                style="background: #09090b; color: #ffffff; border: 1px solid #27272a; font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace; font-size: 0.92rem; height: 48px; border-radius: 8px 0 0 8px;" 
                                value="{{ $keyVal }}" 
                                placeholder="re_123456789..." 
                                autocomplete="new-password"
                            >
                            <div class="input-group-append">
                                <button 
                                    class="btn btn-outline-secondary toggle-key-visibility px-3" 
                                    type="button" 
                                    data-target="resend-key-{{ $i }}" 
                                    style="border-color: #27272a; background: #18181b; color: #ffffff; border-radius: 0 8px 8px 0;"
                                    title="Exibir/Ocultar Chave"
                                >
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 pt-2" style="border-top: 1px solid #18181b;">
                            <span class="small" style="color: #71717a; font-size: 0.78rem;">
                                Chave de API Secreta Resend
                            </span>
                            <div class="d-flex align-items-center">
                                <span class="small font-weight-bold mr-2" id="quota-slot-{{ $i }}" style="color: {{ $todaySends >= 100 ? '#f87171' : '#a1a1aa' }}; font-size: 0.78rem;">
                                    Envios hoje: {{ $todaySends }}/100
                                </span>
                                <div style="width: 45px; height: 6px; background: #18181b; border-radius: 3px; overflow: hidden; border: 1px solid #27272a;">
                                    <div style="width: {{ $percent }}%; height: 100%; background: {{ $percent >= 100 ? '#ef4444' : '#ffffff' }}; transition: width 0.3s ease;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>

<script>
    (function() {
        // Toggle de visualização de senha para todas as caixas
        document.querySelectorAll('.toggle-key-visibility').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                var targetId = this.getAttribute('data-target');
                var input = document.getElementById(targetId);
                var icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Atualização reativa e instantânea de status ao digitar ou colar
        document.querySelectorAll('.resend-key-input').forEach(function(input) {
            input.addEventListener('input', function() {
                var slotNum = this.getAttribute('data-slot');
                var badge = document.getElementById('badge-slot-' + slotNum);
                var card = document.getElementById('slot-card-' + slotNum);
                var val = this.value.trim();

                if (val.length > 0) {
                    badge.textContent = '● Ativa no Pool (Randomizada)';
                    badge.style.background = '#052e16';
                    badge.style.color = '#4ade80';
                    badge.style.border = '1px solid #166534';
                    card.style.borderColor = '#3f3f46';
                } else {
                    badge.textContent = '○ Desativada (Vazia)';
                    badge.style.background = '#18181b';
                    badge.style.color = '#71717a';
                    badge.style.border = '1px solid #27272a';
                    card.style.borderColor = '#27272a';
                }
            });
        });
    })();
</script>
