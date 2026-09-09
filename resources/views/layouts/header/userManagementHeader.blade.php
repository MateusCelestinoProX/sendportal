@auth()
    <ul class="navbar-nav flex-row ml-md-auto d-md-flex align-items-center">
        @php $workspaces = auth()->user()->workspaces; @endphp

        @if (count($workspaces) == 1)
            <li class="nav-item mr-4 px-2">
            <span class="nav-link font-weight-bold" id="bd-versions" aria-haspopup="true" aria-expanded="false" style="color: #ffffff !important; text-shadow: 0 0 10px rgba(255,255,255,0.4);">
                 {{ auth()->user()->currentWorkspace->name }}
            </span>
            </li>
        @elseif (count($workspaces) > 1 && auth()->user()->currentWorkspace)
            <li class="nav-item dropdown mr-4 px-2 workspace-select">
                <a class="nav-link dropdown-toggle font-weight-bold" href="#" id="bd-versions"
                   style="color: #ffffff !important;"
                   data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    {{ auth()->user()->currentWorkspace->name }}<i class="ml-2 fas fa-caret-down" style="color: #ffffff !important;"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions" style="background-color: #09090b !important; border: 1px solid #27272a !important;">
                    @foreach($workspaces as $workspace)
                        <a class="dropdown-item px-3" href="{{ route('workspaces.switch', $workspace->id) }}" style="color: #ffffff !important;">
                            <i class="fas fa-circle mr-2 {{ auth()->user()->currentWorkspace->id == $workspace->id ? 'text-white' : 'text-muted' }}"></i>{{ $workspace->name }}
                        </a>
                    @endforeach
                </div>
            </li>
        @endif

        <!-- MCP OS Backgrounds Button -->
        <li class="nav-item d-flex align-items-center mr-3">
            <button id="mcp-bg-toggle-btn" class="mcp-bg-button" type="button" title="Alterar Fundo e Galerias MCP OS" onclick="if(window.mcpOsThemeManager){window.mcpOsThemeManager.openModal();}else if(window.openBackgroundsModal){window.openBackgroundsModal();}">
                <span style="display:flex; align-items:center; gap:6px;">
                    <i class="fas fa-magic" style="color: #c4b5fd;"></i>
                    <span>Backgrounds</span>
                </span>
                <span id="mcp-active-bg-badge" class="mcp-bg-badge">Strands</span>
            </button>
        </li>

        <li class="nav-item dropdown pl-2 user-dropdown">

            <a class="nav-link dropdown-toggle mr-md-1 font-weight-bold" href="#" id="bd-versions"
               style="color: #ffffff !important;"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
               title="{{ auth()->user()->full_name }}">
                <img src="{{ auth()->user()->avatar }}" height="26" class="rounded-circle mr-2"
                     alt="{{ auth()->user()->name }}" style="border: 1px solid #ffffff; box-shadow: 0 0 8px rgba(255,255,255,0.35);">
                <span class="d-none d-sm-inline-block text-white">{{ \Illuminate\Support\Str::limit( auth()->user()->name, 25) }}</span>
                <i class="ml-2 fas fa-caret-down text-white"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">

                {{-- My Profile --}}
                <a class="dropdown-item px-3" href="{{ route('profile.show') }}"><i
                            class="fas fa-user mr-2 color-gray-300"></i>{{ __('My Profile') }}</a>

                {{-- Workspaces --}}
                <a class="dropdown-item px-3" href="{{ route('workspaces.index') }}"><i
                            class="fas fa-layer-group mr-2 color-gray-300"></i>{{ __('Workspaces') }}</a>

                {{-- API Tokens --}}
                <a class="dropdown-item px-3" href="{{ route('api-tokens.index') }}"><i
                            class="fas fa-key mr-2 color-gray-300"></i>{{ __('API Tokens') }}</a>

                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header text-muted" style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.05em; padding: 4px 16px;">Temas do Sistema</h6>
                <a class="dropdown-item px-3" href="javascript:void(0)" id="mcp-opt-multi" onclick="if(window.mcpOsThemeManager){window.mcpOsThemeManager.applyTheme('mcp-os-multi');}else if(window.switchMcpTheme){window.switchMcpTheme('mcp-os-multi');}" style="display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fas fa-sparkles mr-2" style="color: #c4b5fd;"></i>MCP OS Multi</span>
                    <i class="fas fa-check" id="mcp-check-multi" style="display: none; color: #a855f7;"></i>
                </a>
                <a class="dropdown-item px-3" href="javascript:void(0)" id="mcp-opt-amoled" onclick="if(window.mcpOsThemeManager){window.mcpOsThemeManager.applyTheme('amoled');}else if(window.switchMcpTheme){window.switchMcpTheme('amoled');}" style="display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fas fa-moon mr-2 text-muted"></i>AMOLED Vanta</span>
                    <i class="fas fa-check text-white" id="mcp-check-amoled" style="display: none;"></i>
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item px-3" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="fas fa-sign-out-alt mr-2 color-gray-300"></i>{{ __('Log out') }}</a>
            </div>
        </li>
    </ul>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
@endauth
