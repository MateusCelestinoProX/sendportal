# Graph Report - sendportal  (2026-09-08)

## Corpus Check
- 112 files · ~601,738 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 314 nodes · 341 edges · 104 communities (11 shown, 36 thin omitted)
- Extraction: 98% EXTRACTED · 2% INFERRED · 0% AMBIGUOUS · INFERRED: 6 edges (avg confidence: 0.85)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `f1bcf7e8`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

## Community Hubs (Navigation)
- ResendMailAdapter
- AppServiceProvider.php
- 🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine
- main.blade.php
- LoginController
- LocaleMiddleware.php
- campaigns/index.blade.php
- messages/index.blade.php
- bounces.blade.php
- clicks.blade.php
- opens.blade.php
- recipients.blade.php
- unsubscribes.blade.php
- app.blade.php
- tags/index.blade.php
- emails.content.partials.form
- emails.partials.form
- entrypoint.sh
- campaigns/create.blade.php
- design.blade.php
- campaigns/edit.blade.php
- campaigns/partials/form.blade.php
- reports/index.blade.php
- template.blade.php
- dashboard/index.blade.php
- email_services/create.blade.php
- email_services/edit.blade.php
- base.blade.php
- subscriptions.blade.php
- subscribers/create.blade.php
- subscribers/edit.blade.php
- subscribers/index.blade.php
- subscribers/show.blade.php
- tags/create.blade.php
- tags/edit.blade.php
- templates/create.blade.php
- templates/edit.blade.php
- templates/index.blade.php
- templates/partials/form.blade.php
- grid.blade.php
- TotpService
- mcp-os-webgl.js
- 2026_09_08_000000_add_two_factor_to_users_table.php
- McpOsThemeManager
- mcp-os-galleries.js
- manifest.json
- McpOsEcoEngine

## God Nodes (most connected - your core abstractions)
1. `McpOsThemeManager` - 20 edges
2. `requestAnimationFrame()` - 17 edges
3. `cancelAnimationFrame()` - 15 edges
4. `ResendMailAdapter` - 11 edges
5. `TotpService` - 10 edges
6. `McpOsEcoEngine` - 10 edges
7. `LoginController` - 9 edges
8. `TwoFactorController` - 7 edges
9. `resize()` - 7 edges
10. `🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine` - 7 edges

## Surprising Connections (you probably didn't know these)
- None detected - all connections are within the same source files.

## Import Cycles
- None detected.

## Communities (104 total, 36 thin omitted)

### Community 0 - "ResendMailAdapter"
Cohesion: 0.20
Nodes (8): ResendMailAdapter, Exception, Illuminate\Support\Arr, Illuminate\Support\Facades\Http, Illuminate\Support\Facades\Log, Illuminate\Support\Str, Sendportal\Base\Adapters\BaseMailAdapter, Sendportal\Base\Services\Messages\MessageTrackingOptions

### Community 1 - "AppServiceProvider.php"
Cohesion: 0.22
Nodes (8): App\Livewire\Setup, App\Models\ApiToken, AppServiceProvider, Illuminate\Pagination\Paginator, Illuminate\Support\ServiceProvider, Livewire\Livewire, RuntimeException, Sendportal\Base\Facades\Sendportal

### Community 2 - "🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine"
Cohesion: 0.12
Nodes (16): 1. 🌑 Visual Super 100% Vanta Black AMOLED & High Contrast Electric White, 2. ⚡ Motor Resend Multi-Key (Até 10 Chaves Simultâneas), 3. 🏷️ Gerenciador Completo de Etiquetas (Tags), 4. 🇧🇷 Tradução Completa para Português do Brasil (PT-BR), 📁 Arquitetura e Estrutura de Arquivos, 🛠️ Como Executar o Projeto, 🔑 Configuração das Chaves Resend, 📄 Licença (+8 more)

### Community 3 - "main.blade.php"
Cohesion: 0.29
Nodes (6): sendportal::layouts.partials.sidebar, sendportal::layouts.partials.success, sendportal::layouts.partials.error, sendportal::layouts.partials.errors, sendportal::layouts.partials.header, sendportal::layouts.partials.warning

### Community 4 - "LoginController"
Cohesion: 0.11
Nodes (18): App\Http\Controllers\Auth\ApiTokenController, LoginController, TwoFactorController, App\Http\Controllers\Controller, App\Http\Middleware\OwnsCurrentWorkspace, App\Http\Middleware\RequireWorkspace, App\Models\User, Illuminate\Contracts\View\View (+10 more)

### Community 6 - "campaigns/index.blade.php"
Cohesion: 0.50
Nodes (3): sendportal::campaigns.partials.status, sendportal::layouts.partials.pagination, sendportal::campaigns.partials.nav

### Community 7 - "messages/index.blade.php"
Cohesion: 0.50
Nodes (3): sendportal::layouts.partials.pagination, sendportal::messages.partials.status-row, sendportal::messages.partials.nav

### Community 96 - "mcp-os-webgl.js"
Cohesion: 0.20
Nodes (25): buildStrandsPalette(), cancelAnimationFrame(), hexToRgb(), hexToRgbArr(), hexToVec4Arr(), initAcidSquares(), initBalatro(), update() (+17 more)

### Community 97 - "2026_09_08_000000_add_two_factor_to_users_table.php"
Cohesion: 0.33
Nodes (3): Illuminate\Database\Migrations\Migration, Illuminate\Database\Schema\Blueprint, Illuminate\Support\Facades\Schema

### Community 101 - "mcp-os-galleries.js"
Cohesion: 0.21
Nodes (10): ALL_IMAGES, FLOWERS_IMAGES, GALLERY_PRESETS, GYM_IMAGES, IMAGE_GALLERIES, isGalleryPreset(), MOTIVATION_IMAGES, RED_IMAGES (+2 more)

### Community 102 - "manifest.json"
Cohesion: 0.33
Nodes (5): flowers, gym, motivation, red, soft

## Knowledge Gaps
- **76 isolated node(s):** `entrypoint.sh script`, `soft`, `motivation`, `gym`, `flowers` (+71 more)
  These have ≤1 connection - possible missing edges or undocumented components. (Counts symbols only; 190 node(s) total have ≤1 connection when file, concept and rationale nodes are included.)
- **36 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `TotpService` connect `TotpService` to `LoginController`?**
  _High betweenness centrality (0.009) - this node is a cross-community bridge._
- **What connects `entrypoint.sh script`, `soft`, `motivation` to the rest of the system?**
  _76 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine` be split into smaller, more focused modules?**
  _Cohesion score 0.11764705882352941 - nodes in this community are weakly interconnected._
- **Should `LoginController` be split into smaller, more focused modules?**
  _Cohesion score 0.10804597701149425 - nodes in this community are weakly interconnected._