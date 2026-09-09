# Graph Report - sendportal  (2026-09-09)

## Corpus Check
- 113 files · ~604,877 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 851 nodes · 1367 edges · 134 communities (27 shown, 50 thin omitted)
- Extraction: 98% EXTRACTED · 2% INFERRED · 0% AMBIGUOUS · INFERRED: 24 edges (avg confidence: 0.85)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `f1bcf7e8`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

## Community Hubs (Navigation)
- ResendMailAdapter
- _
- 🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine
- main.blade.php
- TotpService
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
- q
- mcp-os-webgl.js
- 2026_09_08_000000_add_two_factor_to_users_table.php
- McpOsThemeManager
- U
- manifest.json
- ar
- ks
- tn
- .z
- it
- pt
- V
- zt
- .intersectMeshes
- sr
- le
- .update
- ke
- .addAttribute
- .copy
- W
- .sub
- .scale
- rr
- ct
- .draw
- zs
- vt
- oe
- .constructor
- .constructor
- ue
- ji
- De
- .copy
- qi

## God Nodes (most connected - your core abstractions)
1. `_` - 208 edges
2. `U` - 35 edges
3. `V` - 33 edges
4. `ks` - 25 edges
5. `tn` - 23 edges
6. `McpOsThemeManager` - 20 edges
7. `sr()` - 20 edges
8. `W` - 19 edges
9. `ar` - 19 edges
10. `requestAnimationFrame()` - 17 edges

## Surprising Connections (you probably didn't know these)
- `he()` --calls--> `_`  [EXTRACTED]
  public/js/ogl.js → public/js/ogl.js  _Bridges community 1 → community 120_
- `ke` --calls--> `_`  [EXTRACTED]
  public/js/ogl.js → public/js/ogl.js  _Bridges community 1 → community 115_
- `sr()` --calls--> `_`  [EXTRACTED]
  public/js/ogl.js → public/js/ogl.js  _Bridges community 1 → community 112_
- `R()` --calls--> `_`  [EXTRACTED]
  public/js/ogl.js → public/js/ogl.js  _Bridges community 1 → community 128_
- `zs` --calls--> `le()`  [EXTRACTED]
  public/js/ogl.js → public/js/ogl.js  _Bridges community 113 → community 124_

## Import Cycles
- None detected.

## Communities (134 total, 50 thin omitted)

### Community 0 - "ResendMailAdapter"
Cohesion: 0.18
Nodes (9): ResendMailAdapter, Exception, Illuminate\Support\Arr, Illuminate\Support\Facades\Cache, Illuminate\Support\Facades\Http, Illuminate\Support\Facades\Log, Illuminate\Support\Str, Sendportal\Base\Adapters\BaseMailAdapter (+1 more)

### Community 1 - "_"
Cohesion: 0.04
Nodes (41): _, ae(), at, bs(), ce(), dt, Ei, Et (+33 more)

### Community 2 - "🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine"
Cohesion: 0.12
Nodes (16): 1. 🌑 Visual Super 100% Vanta Black AMOLED & High Contrast Electric White, 2. ⚡ Motor Resend Multi-Key (Até 10 Chaves Simultâneas), 3. 🏷️ Gerenciador Completo de Etiquetas (Tags), 4. 🇧🇷 Tradução Completa para Português do Brasil (PT-BR), 📁 Arquitetura e Estrutura de Arquivos, 🛠️ Como Executar o Projeto, 🔑 Configuração das Chaves Resend, 📄 Licença (+8 more)

### Community 3 - "main.blade.php"
Cohesion: 0.29
Nodes (6): sendportal::layouts.partials.sidebar, sendportal::layouts.partials.success, sendportal::layouts.partials.error, sendportal::layouts.partials.errors, sendportal::layouts.partials.header, sendportal::layouts.partials.warning

### Community 4 - "TotpService"
Cohesion: 0.06
Nodes (26): App\Http\Controllers\Auth\ApiTokenController, LoginController, TwoFactorController, App\Http\Controllers\Controller, App\Http\Middleware\OwnsCurrentWorkspace, App\Http\Middleware\RequireWorkspace, App\Livewire\Setup, App\Models\ApiToken (+18 more)

### Community 6 - "campaigns/index.blade.php"
Cohesion: 0.50
Nodes (3): sendportal::campaigns.partials.status, sendportal::layouts.partials.pagination, sendportal::campaigns.partials.nav

### Community 7 - "messages/index.blade.php"
Cohesion: 0.50
Nodes (3): sendportal::layouts.partials.pagination, sendportal::messages.partials.status-row, sendportal::messages.partials.nav

### Community 95 - "q"
Cohesion: 0.06
Nodes (11): As(), br, en, gr, K, kr, nr, q (+3 more)

### Community 96 - "mcp-os-webgl.js"
Cohesion: 0.13
Nodes (26): buildStrandsPalette(), cancelAnimationFrame(), hexToRgb(), hexToRgbArr(), hexToVec4Arr(), initAcidSquares(), initBalatro(), update() (+18 more)

### Community 97 - "2026_09_08_000000_add_two_factor_to_users_table.php"
Cohesion: 0.33
Nodes (3): Illuminate\Database\Migrations\Migration, Illuminate\Database\Schema\Blueprint, Illuminate\Support\Facades\Schema

### Community 100 - "McpOsThemeManager"
Cohesion: 0.12
Nodes (11): ALL_IMAGES, FLOWERS_IMAGES, GALLERY_PRESETS, GYM_IMAGES, IMAGE_GALLERIES, isGalleryPreset(), MOTIVATION_IMAGES, RED_IMAGES (+3 more)

### Community 101 - "U"
Cohesion: 0.04
Nodes (19): ai(), ci(), di(), _e(), gi(), hi(), ii(), li() (+11 more)

### Community 102 - "manifest.json"
Cohesion: 0.33
Nodes (5): flowers, gym, motivation, red, soft

### Community 103 - "ar"
Cohesion: 0.08
Nodes (7): ar, dr(), kt(), mr, pr(), Ut(), yr

### Community 104 - "ks"
Cohesion: 0.10
Nodes (3): ge(), ks, me()

### Community 105 - "tn"
Cohesion: 0.14
Nodes (7): fr(), A(), E(), m(), p(), ns(), tn

### Community 106 - ".z"
Cohesion: 0.08
Nodes (4): Gs(), Hs(), qs(), Xs()

### Community 107 - "it"
Cohesion: 0.17
Nodes (3): Ds(), it, St

### Community 108 - "pt"
Cohesion: 0.10
Nodes (8): bi(), _i(), pt, Se(), Si(), Ti(), vi(), zi()

### Community 110 - "zt"
Cohesion: 0.14
Nodes (9): be(), gt, Ie(), Ne(), l(), zr, h(), l() (+1 more)

### Community 112 - "sr"
Cohesion: 0.17
Nodes (10): v(), nn(), sr(), C(), et(), j(), L(), N() (+2 more)

### Community 114 - ".update"
Cohesion: 0.20
Nodes (3): cs, is, Ys()

### Community 118 - "W"
Cohesion: 0.18
Nodes (4): on, rn, un, W

### Community 120 - ".scale"
Cohesion: 0.31
Nodes (3): he(), Lt, ur()

### Community 122 - "ct"
Cohesion: 0.29
Nodes (3): ct(), fi(), ve

### Community 124 - "zs"
Cohesion: 0.33
Nodes (3): bt(), Tt(), zs

### Community 125 - "vt"
Cohesion: 0.33
Nodes (3): Es(), Ms(), vt()

## Knowledge Gaps
- **104 isolated node(s):** `entrypoint.sh script`, `soft`, `motivation`, `gym`, `flowers` (+99 more)
  These have ≤1 connection - possible missing edges or undocumented components. (Counts symbols only; 320 node(s) total have ≤1 connection when file, concept and rationale nodes are included.)
- **50 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `_` connect `_` to `.constructor`, `ue`, `ji`, `De`, `.copy`, `qi`, `q`, `mcp-os-webgl.js`, `U`, `ar`, `ks`, `tn`, `.z`, `it`, `pt`, `V`, `zt`, `.intersectMeshes`, `sr`, `le`, `.update`, `ke`, `.addAttribute`, `.copy`, `W`, `.sub`, `.scale`, `rr`, `ct`, `.draw`, `zs`, `vt`, `oe`, `.constructor`?**
  _High betweenness centrality (0.389) - this node is a cross-community bridge._
- **Why does `V` connect `V` to `mcp-os-webgl.js`, `_`, `ji`, `De`, `qi`, `ar`, `zt`, `.intersectMeshes`, `sr`, `.update`, `.copy`, `.sub`, `.scale`, `.constructor`?**
  _High betweenness centrality (0.035) - this node is a cross-community bridge._
- **Why does `ks` connect `ks` to `mcp-os-webgl.js`, `_`, `q`?**
  _High betweenness centrality (0.034) - this node is a cross-community bridge._
- **What connects `entrypoint.sh script`, `soft`, `motivation` to the rest of the system?**
  _104 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `_` be split into smaller, more focused modules?**
  _Cohesion score 0.041742286751361164 - nodes in this community are weakly interconnected._
- **Should `🚀 SendPortal Super AMOLED Edition - Resend Multi-Key Engine` be split into smaller, more focused modules?**
  _Cohesion score 0.11764705882352941 - nodes in this community are weakly interconnected._
- **Should `TotpService` be split into smaller, more focused modules?**
  _Cohesion score 0.06382978723404255 - nodes in this community are weakly interconnected._