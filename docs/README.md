---
title: "Cms Module Documentation"
type: documentation
tags: [module, documentation, cms, content-management]
created: 2026-07-14
updated: 2026-09-17
---

# Modulo Cms

## Overview

Il modulo **Cms** gestisce il sistema di content management per la piattaforma Laraxot. Fornisce un sistema flessibile basato su Filament Builder Blocks per creare, modificare e pubblicare contenuti dinamici, incluse pagine, sezioni e blocchi di contenuto.

## Scopo

- Gestione completa di pagine e contenuti dinamici
- Sistema modulare di blocchi (Builder Blocks) per composizione pagine
- Storage JSON ottimizzato per persistenza contenuti
- Interfaccia amministrativa Filament completamente integrata
- Supporto multi-lingua per tutti i contenuti

## Funzionalità Principali

- **Page Management**: Creazione, modifica e pubblicazione pagine
- **Block System**: Sistema modulare blocchi per composizione dinamica
- **Content Builder**: Interfaccia Filament per composizione pagine
- **Folio Integration**: File-based routing per pagine pubbliche
- **Blade Components**: Componenti riutilizzabili per rendering frontend
- **JSON Storage**: Persistenza efficiente contenuti strutturati
- **Multi-language**: Supporto i18n completo per tutti i contenuti

## Struttura del Modulo

```
Modules/Cms/
├── app/
│   ├── Models/
│   │   ├── Page.php              # Pagina (slug, content_blocks per locale, meta SEO)
│   │   ├── PageContent.php       # Contenuto/blocchi riutilizzabili
│   │   ├── Section.php           # Sezione modulare riutilizzabile
│   │   ├── Menu.php              # Navigazione ad albero (adjacency list)
│   │   ├── Conf.php              # Configurazione system-wide (Sushi)
│   │   └── Attachment.php        # Allegati/media
│   ├── Actions/                  # Nessun layer Services: business logic in Actions
│   │   ├── ResolvePageAction.php         # Risolve container0/slug0 -> modello o Page
│   │   ├── BuildPageSchemaAction.php     # Costruisce lo schema.org JSON-LD
│   │   ├── ResolveBlockQueryAction.php   # Query dinamiche per blocchi
│   │   ├── ResolveLocalizedBlockDataAction.php
│   │   └── View/GetCmsViewAction.php     # Risoluzione type-safe delle view
│   ├── Filament/
│   │   ├── Resources/
│   │   │   ├── PageResource.php
│   │   │   ├── PageContentResource.php
│   │   │   ├── SectionResource.php
│   │   │   ├── MenuResource.php
│   │   │   └── AttachmentResource.php
│   │   └── Blocks/                # Definizioni Filament Builder dei blocchi
│   └── Traits/
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── resources/
│   ├── views/
│   │   └── components/            # x-cms:: (page, section, blocks/*, footer/*, headernav/*)
│   └── lang/
├── tests/
├── docs/                          # vedi docs/index.md e docs/wiki/ per la navigazione
├── module.json
└── composer.json
```

Nota: il modulo non ha una cartella `app/Services` — la logica applicativa vive nelle Action
(`Spatie\QueueableAction`), non in classi `*Service`.

## Componenti Principali

| Classe | Scopo | Extends |
|--------|-------|---------|
| `Page` | Pagina con slug, `content_blocks` per locale, meta SEO | `BaseModelLang` |
| `PageContent` | Contenuto/blocchi riutilizzabili | `BaseModel` |
| `Section` | Sezione modulare riutilizzabile | `BaseModelLang` |
| `Menu` | Navigazione ad albero (adjacency list) | `BaseModel` |
| `Conf` | Configurazione system-wide (Sushi) | `BaseModel` |
| `PageResource` | Amministrazione Filament di `Page` | `LangBaseResource` (→ `XotBaseResource`) |
| `ResolvePageAction` | Risolve `(container0, slug0)` in modello dinamico o `Page` | Action (`QueueableAction`) |
| `GetCmsViewAction` | Risoluzione type-safe del nome vista | Action (`QueueableAction`) |

Dettaglio della pipeline di risoluzione pagina/blocchi: vedi
[actions/page-resolution-pipeline.md](./actions/page-resolution-pipeline.md) e
[wiki/overviews/cms-module.md](./wiki/overviews/cms-module.md).

## Utilizzo Comune

### Scenario 1: Struttura di un blocco di contenuto

I blocchi sono array JSON salvati in `content_blocks.{locale}` su `Page` (non esiste
un modello `Block` dedicato né un'action `CreatePageAction`):

```php
use Modules\Cms\Models\Page;

$page = Page::create([
    'slug' => 'home',
    'content_blocks' => [
        'it' => [
            ['type' => 'hero', 'data' => ['view' => 'pub_theme::components.blocks.hero.main', 'title' => 'Titolo']],
            ['type' => 'text', 'data' => ['view' => 'pub_theme::components.blocks.text.main', 'content' => '...']],
        ],
    ],
]);
```

### Scenario 2: Renderizzare i blocchi nel tema (Blade)

Ogni blocco dichiara la propria `view` nel JSON: il rendering non passa da uno
`@switch` su `type`, ma risolve direttamente la view indicata (vedi `BlockData` in
[wiki/overviews/cms-module.md](./wiki/overviews/cms-module.md)):

```blade
@foreach ($page->content_blocks[app()->getLocale()] ?? [] as $block)
    @include($block['data']['view'], ['data' => $block['data']])
@endforeach
```

## Configuration

### Block Types

Non esiste un file di configurazione centrale dei tipi di blocco (`config/local/cms/blocks.php`
non esiste in questo repo). I tipi di blocco sono definiti come `Builder\Block` di Filament
nello schema del `Builder::make('content_blocks')` (vedi
[wiki/overviews/cms-module.md](./wiki/overviews/cms-module.md) per un esempio), e le view
associate risiedono in `Themes/{pub_theme}/resources/views/components/blocks/`.

### Content Storage

Il contenuto è salvato come JSON strutturato per locale nel campo `content_blocks` di `Page`
(vedi anche [docs/examples/blocks.json](./examples/blocks.json)):

```json
{
  "it": [
    {
      "type": "hero",
      "data": {
        "view": "pub_theme::components.blocks.hero.main",
        "title": "Welcome",
        "subtitle": "Laraxot CMS"
      }
    }
  ]
}
```

## Testing

```bash
# Run Cms module tests
./vendor/bin/pest Modules/Cms/tests

# Run specific test category
./vendor/bin/pest Modules/Cms/tests/Unit/Models/PageTest.php

# With coverage
./vendor/bin/pest Modules/Cms/tests --coverage
```

## Quality Standards

- **PHPStan**: Level 10 (zero baseline)
- **Test Coverage**: Minimum 80%
- **Code Style**: PSR-12 via Pint

Run locally:
```bash
php -d memory_limit=-1 ./vendor/bin/phpstan analyse --level=max Modules/Cms
./vendor/bin/pest Modules/Cms/tests --coverage
./vendor/bin/pint Modules/Cms
```

## Documentation Index

`docs/` in questo modulo contiene centinaia di file storici/duplicati: usare
[docs/index.md](./index.md) come mappa completa (organizzata per argomento, con la sezione
"Storico / da consolidare" per i duplicati). Punti di ingresso consigliati:

- [wiki/overviews/cms-module.md](./wiki/overviews/cms-module.md) — Overview architetturale sintetico e verificato (modelli, blocchi, routing Folio)
- [actions/page-resolution-pipeline.md](./actions/page-resolution-pipeline.md) — Come una rotta Folio diventa contenuto renderizzato
- [queueable-actions.md](./queueable-actions.md) — Convenzione Action del modulo (nessun layer Services)

Attenzione: molti `README.md`/`index.md` nelle sottocartelle di `docs/` (es. `blocks/README.md`,
`frontoffice/README.md`, `content/README.md`) sono boilerplate generico non aggiornato al codice
reale di questo modulo (elencano classi/file che non esistono qui) — non fidarsi del loro
contenuto senza verifica; vedi finding dedicato.

## Dipendenze / Moduli Correlati

- [Xot - Framework Base](../../Xot/docs/README.md) — Always dependency
- [UI - Components](../../UI/docs/README.md) — For UI components library
- [Lang - Translations](../../Lang/docs/README.md) — For i18n support
- [Media - File Management](../../Media/docs/README.md) — For image/file handling

## Documenti Correlati

- [PHPStan Configuration](../../../phpstan.neon)

## Regole Critiche

1. **Always extend Xot base classes** — Never extend Laravel/Filament directly
2. **Use namespace `Modules\Cms`** — Never `app\Cms`
3. **Strict typing** — `declare(strict_types=1);` in all files
4. **Relative links only** — All doc links must be relative paths
5. **No placeholder text** — Remove PROJECT_NAME, [CHANGE_ME], etc
6. **JSON validation** — Validate block data structure before storage
7. **No merge conflict markers** — Ensure clean commits

## Standard Rules & Workflow

- [[BMAD Method](../../../../docs/wiki/concepts/bmad-method.md)]
- [[Context Engineering](../../../../docs/wiki/concepts/context-engineering.md)]
- [[LLM Wiki Governance](../../../../docs/wiki/concepts/llm-wiki-governance.md)]

---

**Status**: ✅ Production  
**Last Updated**: 2026-09-17  
**Requirements**: PHP 8.3+, Laravel 12, Filament 5  
**PHPStan Level**: 10 (Target)

**Note**: `docs/` in questo modulo contiene un grande volume di file storici/duplicati mai
consolidati — questo file resta la SSoT per la struttura codice, ma per la navigazione
completa (incluse le varianti duplicate) usare [docs/index.md](./index.md).
