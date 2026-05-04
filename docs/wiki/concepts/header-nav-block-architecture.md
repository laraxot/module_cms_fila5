# Header Nav Block Architecture

**Modulo:** Cms  
**Story:** 8-107  
**Data:** 2026-05-04

---

## Visione

Il sito FixCity è un CMS headless basato su **blocchi JSON**. Ogni sezione del sito (`header`, `footer`, `sidebar`, ...) è un record `Section` che aggrega blocchi di contenuto. I blocchi sono dati puri — nessun link hardcoded nel codice Blade.

**Regola fondamentale:** se il dato può variare da un Comune all'altro, DEVE stare nel JSON, non nel Blade.

---

## Catena Completa

```
<x-section slug="header" />
  └── Modules\Cms\View\Components\Section (View Component)
        └── SectionModel::getBlocksBySlug('header')
              └── Section Model usa:
                    ├── SushiToJsons (Sushi: SQLite in-memory da JSON)
                    │     └── TenantService::filePath('database/content/sections/')
                    │           └── header.json  ← SSoT dei dati
                    └── HasBlocks::getBlocks()
                          └── foreach blocco → new BlockData(type, data, slug, active)
                                └── BlockData[] (array con chiave indice numerico)
                                      └── passato come $blocks a v1.blade.php
```

---

## Struttura del JSON `header.json`

```json
{
  "id": "1",
  "slug": "header",
  "name": "Header",
  "blocks": {
    "it": [
      {
        "id": "header-slim",
        "type": "header-slim",
        "weight": 1,
        "active": true,
        "data": { ... }
      },
      {
        "id": "header-nav",
        "type": "header-nav-wrapper",
        "weight": 2,
        "active": true,
        "data": {
          "view": "pub_theme::components.blocks.header.nav-wrapper",
          "municipality": "Il mio Comune",
          "subtitle": "Un comune da vivere",
          "logo": "/themes/Sixteen/images/logo-comune.svg",
          "social": [...],
          "search": {"action": "/it/ricerca"},
          "items": [
            {
              "label": "Amministrazione",
              "url": "/it/amministrazione",
              "data_element": "management",
              "active_patterns": [
                {"pattern": "*amministrazione*"}
              ]
            },
            ...
          ],
          "secondary_items": [
            {"label": "Iscrizioni", "url": "/it/iscrizioni"},
            ...
          ],
          "topics_url": "/it/argomenti"
        }
      }
    ]
  }
}
```

---

## `active_patterns` — Perché e Come

I link di navigazione devono evidenziarsi ("active state") non solo sulla loro URL esatta, ma su tutte le pagine correlate. Esempio: "Servizi" deve essere attivo su `/it/servizi`, `/it/segnalazione-crea`, `/it/servizio/*`.

Invece di hardcodare questa logica in Blade, ogni voce ha `active_patterns`: un array di pattern per `request()->is()`.

**Nel JSON (formato Repeater Filament):**
```json
"active_patterns": [
  {"pattern": "*servizi*"},
  {"pattern": "*segnalazione*"},
  {"pattern": "*servizio*"}
]
```

**Nel Blade:**
```blade
@php
$patterns = collect($item['active_patterns'] ?? [])->pluck('pattern')->toArray();
$isActive = collect($patterns)->contains(fn($p) => request()->is(ltrim($p, '/')));
@endphp
```

---

## `HeaderNavBlock` — Editor Filament

**File:** `laravel/Modules/Cms/app/Filament/Blocks/HeaderNavBlock.php`

Estende `XotBaseBlock` (regola Laraxot: mai estendere direttamente `Block` di Filament).

Viene scoperto automaticamente da `GetAllBlocksAction` via glob:
```
Modules/*/app/../Filament/Blocks/*.php
```

Viene esposto nell'admin tramite `SectionResource` → `PageContentBuilder` → lista di blocchi disponibili per ogni sezione.

### Schema Filament

```
Repeater: items (voci primarie)
  ├── TextInput: label
  ├── TextInput: url
  ├── TextInput: data_element
  └── Repeater: active_patterns
        └── TextInput: pattern

Repeater: secondary_items (voci secondarie)
  ├── TextInput: label
  └── TextInput: url

TextInput: topics_url
```

---

## Come `v1.blade.php` Accede ai Blocchi

```blade
@php
    // I blocchi hanno chiave numerica (0, 1, ...) - non usare l'id del blocco come chiave
    $headerNavBlock = collect($blocks ?? [])
        ->first(fn($b) => $b->type === 'header-nav-wrapper');
    $navItems = $headerNavBlock?->data['items'] ?? [];
    $navSecondaryItems = $headerNavBlock?->data['secondary_items'] ?? [];
    $topicsUrl = $headerNavBlock?->data['topics_url'] ?? '/it/argomenti';
@endphp
```

---

## Come Aggiungere una Nuova Voce Nav

**Via JSON diretto:**
1. Aprire `laravel/config/local/fixcity/database/content/sections/header.json`
2. Aggiungere un elemento a `blocks.it[1].data.items`
3. `php artisan optimize:clear` (Sushi ricarica al prossimo boot)

**Via Admin Filament:**
1. Accedere a `/admin/cms/sections`
2. Modificare "Header"
3. Nel blocco "Header Nav" → Repeater "items" → aggiungere riga
4. Salvare (SushiToJsons scrive automaticamente il JSON su disco)

---

## Regole Critiche

1. **MAI hardcodare link nav in Blade** — vanno nel JSON
2. **MAI usare l'id del blocco come chiave array** — usare `collect()->first(fn($b) => $b->type === '...')`
3. **`request()->is()` senza slash iniziale** — es. `it/servizi*` non `/it/servizi*`
4. **`active_patterns` è un array di `{pattern: string}`** (Repeater annidato), non array di stringhe
5. **Sushi cache:** dopo modifica JSON manuale fare `php artisan optimize:clear`

---

## Vedi Anche

- `laravel/Themes/Sixteen/docs/wiki/concepts/header-nav-dynamic-links.md` — uso nel tema
- `laravel/Themes/Sixteen/docs/wiki/concepts/header-ssot.md` — SSoT header v1.blade.php
- Story 8-107: `_bmad-output/implementation-artifacts/8-107-header-nav-items-from-json-filament-builder.md`
