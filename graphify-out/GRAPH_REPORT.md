# Graph Report - sendportal  (2026-09-08)

## Corpus Check
- 108 files · ~30,569 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 234 nodes · 172 edges · 100 communities (9 shown, 34 thin omitted)
- Extraction: 100% EXTRACTED · 0% INFERRED · 0% AMBIGUOUS
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `81681161`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

## Community Hubs (Navigation)
- ResendMailAdapter
- AppServiceProvider.php
- 🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine
- main.blade.php
- LoginController.php
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
- web.php
- 2026_09_08_000000_add_two_factor_to_users_table.php

## God Nodes (most connected - your core abstractions)
1. `ResendMailAdapter` - 11 edges
2. `TotpService` - 10 edges
3. `LoginController` - 8 edges
4. `🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine` - 7 edges
5. `🛠️ Como Executar o Projeto` - 6 edges
6. `TwoFactorController` - 5 edges
7. `🌟 Principais Recursos e Diferenciais` - 5 edges
8. `AppServiceProvider` - 4 edges
9. `LocaleMiddleware` - 2 edges
10. `entrypoint.sh script` - 1 edges

## Surprising Connections (you probably didn't know these)
- None detected - all connections are within the same source files.

## Import Cycles
- None detected.

## Communities (100 total, 34 thin omitted)

### Community 0 - "ResendMailAdapter"
Cohesion: 0.18
Nodes (9): ResendMailAdapter, Exception, Illuminate\Support\Arr, Illuminate\Support\Facades\Cache, Illuminate\Support\Facades\Http, Illuminate\Support\Facades\Log, Illuminate\Support\Str, Sendportal\Base\Adapters\BaseMailAdapter (+1 more)

### Community 1 - "AppServiceProvider.php"
Cohesion: 0.24
Nodes (7): App\Livewire\Setup, App\Models\ApiToken, AppServiceProvider, Illuminate\Pagination\Paginator, Illuminate\Support\ServiceProvider, Livewire\Livewire, RuntimeException

### Community 2 - "🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine"
Cohesion: 0.12
Nodes (16): 1. 🌑 Visual Super 100% Vanta Black AMOLED & High Contrast Electric White, 2. ⚡ Motor Resend Multi-Key (Até 10 Chaves Simultâneas), 3. 🏷️ Gerenciador Completo de Etiquetas (Tags), 4. 🇧🇷 Tradução Completa para Português do Brasil (PT-BR), 📁 Arquitetura e Estrutura de Arquivos, 🛠️ Como Executar o Projeto, 🔑 Configuração das Chaves Resend, 📄 Licença (+8 more)

### Community 3 - "main.blade.php"
Cohesion: 0.29
Nodes (6): sendportal::layouts.partials.sidebar, sendportal::layouts.partials.success, sendportal::layouts.partials.error, sendportal::layouts.partials.errors, sendportal::layouts.partials.header, sendportal::layouts.partials.warning

### Community 4 - "LoginController.php"
Cohesion: 0.17
Nodes (11): LoginController, TwoFactorController, App\Http\Controllers\Controller, App\Models\User, Illuminate\Contracts\View\View, Illuminate\Foundation\Auth\AuthenticatesUsers, Illuminate\Http\RedirectResponse, Illuminate\Http\Request (+3 more)

### Community 6 - "campaigns/index.blade.php"
Cohesion: 0.50
Nodes (3): sendportal::campaigns.partials.status, sendportal::layouts.partials.pagination, sendportal::campaigns.partials.nav

### Community 7 - "messages/index.blade.php"
Cohesion: 0.50
Nodes (3): sendportal::layouts.partials.pagination, sendportal::messages.partials.status-row, sendportal::messages.partials.nav

### Community 96 - "web.php"
Cohesion: 0.29
Nodes (6): App\Http\Controllers\Auth\ApiTokenController, App\Http\Middleware\OwnsCurrentWorkspace, App\Http\Middleware\RequireWorkspace, Illuminate\Routing\Router, Illuminate\Support\Facades\Route, Sendportal\Base\Facades\Sendportal

### Community 97 - "2026_09_08_000000_add_two_factor_to_users_table.php"
Cohesion: 0.33
Nodes (3): Illuminate\Database\Migrations\Migration, Illuminate\Database\Schema\Blueprint, Illuminate\Support\Facades\Schema

## Knowledge Gaps
- **64 isolated node(s):** `entrypoint.sh script`, `sendportal::campaigns.partials.form`, `sendportal::templates.partials.editor`, `sendportal::campaigns.partials.form`, `emails.content.partials.form` (+59 more)
  These have ≤1 connection - possible missing edges or undocumented components. (Counts symbols only; 174 node(s) total have ≤1 connection when file, concept and rationale nodes are included.)
- **34 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `TotpService` connect `TotpService` to `LoginController.php`?**
  _High betweenness centrality (0.011) - this node is a cross-community bridge._
- **Why does `TwoFactorController` connect `LoginController.php` to `web.php`?**
  _High betweenness centrality (0.004) - this node is a cross-community bridge._
- **What connects `entrypoint.sh script`, `sendportal::campaigns.partials.form`, `sendportal::templates.partials.editor` to the rest of the system?**
  _64 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine` be split into smaller, more focused modules?**
  _Cohesion score 0.11764705882352941 - nodes in this community are weakly interconnected._