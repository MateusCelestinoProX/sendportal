# Graph Report - sendportal  (2026-09-07)

## Corpus Check
- 101 files · ~27,634 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 193 nodes · 115 edges · 95 communities (7 shown, 33 thin omitted)
- Extraction: 100% EXTRACTED · 0% INFERRED · 0% AMBIGUOUS
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `087b7c46`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

## Community Hubs (Navigation)
- ResendMailAdapter
- AppServiceProvider.php
- 🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine
- main.blade.php
- 🛠️ Como Executar o Projeto
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

## God Nodes (most connected - your core abstractions)
1. `ResendMailAdapter` - 11 edges
2. `🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine` - 7 edges
3. `🛠️ Como Executar o Projeto` - 6 edges
4. `🌟 Principais Recursos e Diferenciais` - 5 edges
5. `AppServiceProvider` - 4 edges
6. `LocaleMiddleware` - 2 edges
7. `entrypoint.sh script` - 1 edges
8. `sendportal::campaigns.partials.form` - 1 edges
9. `sendportal::templates.partials.editor` - 1 edges
10. `sendportal::campaigns.partials.form` - 1 edges

## Surprising Connections (you probably didn't know these)
- None detected - all connections are within the same source files.

## Import Cycles
- None detected.

## Communities (95 total, 33 thin omitted)

### Community 0 - "ResendMailAdapter"
Cohesion: 0.18
Nodes (9): ResendMailAdapter, Exception, Illuminate\Support\Arr, Illuminate\Support\Facades\Cache, Illuminate\Support\Facades\Http, Illuminate\Support\Facades\Log, Illuminate\Support\Str, Sendportal\Base\Adapters\BaseMailAdapter (+1 more)

### Community 1 - "AppServiceProvider.php"
Cohesion: 0.20
Nodes (9): App\Livewire\Setup, App\Models\ApiToken, App\Models\User, AppServiceProvider, Illuminate\Pagination\Paginator, Illuminate\Support\ServiceProvider, Livewire\Livewire, RuntimeException (+1 more)

### Community 2 - "🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine"
Cohesion: 0.18
Nodes (10): 1. 🌑 Visual Super 100% Vanta Black AMOLED & High Contrast Electric White, 2. ⚡ Motor Resend Multi-Key (Até 10 Chaves Simultâneas), 3. 🏷️ Gerenciador Completo de Etiquetas (Tags), 4. 🇧🇷 Tradução Completa para Português do Brasil (PT-BR), 📁 Arquitetura e Estrutura de Arquivos, 🔑 Configuração das Chaves Resend, 📄 Licença, 🌟 Principais Recursos e Diferenciais (+2 more)

### Community 3 - "main.blade.php"
Cohesion: 0.29
Nodes (6): sendportal::layouts.partials.sidebar, sendportal::layouts.partials.success, sendportal::layouts.partials.error, sendportal::layouts.partials.errors, sendportal::layouts.partials.header, sendportal::layouts.partials.warning

### Community 4 - "🛠️ Como Executar o Projeto"
Cohesion: 0.33
Nodes (6): 🛠️ Como Executar o Projeto, Passo 1: Clonar o Repositório, Passo 2: Configurar o Ambiente, Passo 3: Iniciar os Contêineres, Passo 4: Acessar no Navegador, Pré-requisitos

### Community 6 - "campaigns/index.blade.php"
Cohesion: 0.50
Nodes (3): sendportal::campaigns.partials.status, sendportal::layouts.partials.pagination, sendportal::campaigns.partials.nav

### Community 7 - "messages/index.blade.php"
Cohesion: 0.50
Nodes (3): sendportal::layouts.partials.pagination, sendportal::messages.partials.status-row, sendportal::messages.partials.nav

## Knowledge Gaps
- **64 isolated node(s):** `entrypoint.sh script`, `sendportal::campaigns.partials.form`, `sendportal::templates.partials.editor`, `sendportal::campaigns.partials.form`, `emails.content.partials.form` (+59 more)
  These have ≤1 connection - possible missing edges or undocumented components. (Counts symbols only; 157 node(s) total have ≤1 connection when file, concept and rationale nodes are included.)
- **33 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine` connect `🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine` to `🛠️ Como Executar o Projeto`?**
  _High betweenness centrality (0.005) - this node is a cross-community bridge._
- **Why does `🛠️ Como Executar o Projeto` connect `🛠️ Como Executar o Projeto` to `🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine`?**
  _High betweenness centrality (0.004) - this node is a cross-community bridge._
- **What connects `entrypoint.sh script`, `sendportal::campaigns.partials.form`, `sendportal::templates.partials.editor` to the rest of the system?**
  _64 weakly-connected nodes found - possible documentation gaps or missing edges._