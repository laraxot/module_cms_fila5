---
title: "Cms — indice operativo"
type: index
tags: [documentation, cms]
created: 2026-09-26
updated: 2026-10-20
qmd: "cms indice operativo scopo pagine blocchi folio phpstan wave"
issues: []
discussions: []
status: active
---

# Cms Module Documentation

**Perche' esiste:** [scopo.md](./scopo.md). Wave PHPStan: [stories/phpstan-wave-coord.story.md](./stories/phpstan-wave-coord.story.md) (`.cursor-scratch/phpstan-wave/Cms.tsv`). Gate Modules a zero: [Xot phpstan-modules-zero-wave3](../../Xot/docs/stories/phpstan-modules-zero-wave3.story.md).

**Livewire → Widget (planning ready-for-dev):** l'unico `Http/Livewire` del modulo e' `Page\Show` → verdetto **KEEP FO** (pagina pubblica / Folio, non card panel). Canone fleet: [Xot livewire-to-filament-widgets-inventory](../../Xot/docs/bmad/livewire-to-filament-widgets-inventory.md) (riga Cms); SSoT modulo: [bmad/livewire-inventory.md](./bmad/livewire-inventory.md); gate anti-scope: [stories/12.1.cms-page-show-not-widget.story.md](./stories/12.1.cms-page-show-not-widget.story.md). Legal `TermsOfService`/`PrivacyPolicy` = **REUSE** widget User (non Cms).

## Overview

Il modulo Cms gestisce contenuti, composizione pagina e rendering CMS-driven dei blocchi. Nel lavoro corrente sulla parity Design Comuni, il Cms governa la struttura della homepage di test, mentre la resa visuale viene rifinita nel tema Sixteen.

## Lettura essenziale (scopo / contratti)

1. [scopo.md](./scopo.md) — Perché Cms: risoluzione pagina, blocchi JSON, confini col tema.
2. [actions/page-resolution-pipeline.md](./actions/page-resolution-pipeline.md) — Folio → `ResolvePageAction` / schema / blocchi localizzati.
3. [content-blocks-architecture.md](./content-blocks-architecture.md) — Filament Builder → JSON → Blade.
4. [wiki/concepts/header-nav-block-architecture.md](./wiki/concepts/header-nav-block-architecture.md) · [headernavblock-filament-builder.md](./wiki/concepts/headernavblock-filament-builder.md).
5. [safe.md](./safe.md) — Perché Safe su I/O JSON/filesystem (test e runtime).
6. [stories/phpstan-test-wave-cms.story.md](./stories/phpstan-test-wave-cms.story.md) — Test allineati al Cms JSON reale.

## Governance documentale

- [Contratto moduli/temi](../../../../bmad-output/docs-architecture/module-theme-docs-contract.md)
- [Tassonomia](../../../../bmad-output/docs-architecture/taxonomy.md)
- [Ownership](../../../../bmad-output/docs-architecture/ownership.md)

Questo indice e' l'ingresso operativo del Cms. Stub verso qui: `00-index.md`, `INDEX.md`. `index.md` e' catalogo generato: non creare altri indici.

## Stato verificato e mappa delle directory (2026-10-14)

Come il Cms serve davvero le pagine (JSON per tenant in `config/<tenant>/database/content/pages/`, rotte Folio del tema, blocchi con `type`, `ResolvePageAction`, `PageSlugMiddleware`) e cosa NON esiste (Services `PageService`/`BlockService`, modello `Block`, `PublishPageAction`) e' in [README.md](./README.md), con prove. Story di questo lavoro: [2026-10-14-docs-cms-studio](./stories/docs-cms-studio.story.md).

| Directory | Ruolo | File .md |
|---|---|---|
| `README.md`, `wiki/` | canonici (README verificato; per le regole su JSON e middleware vedi `wiki/concepts/cms-page-middleware-json-ssot.md`; `wiki/content-architecture.md` e' stale: descrive modelli ContentPage/ContentBlock inesistenti) | 57 in wiki |
| `stories/`, `bmad/` | evidence BMAD | 22 e 17 |
| `architecture/`, `frontoffice/`, `blocks/`, `components/`, `sections/`, `folio/`, `livewire/`, `frontend-architecture/` | riferimenti tecnici: leggere dopo il README, molti sono datati | 6, 23, 28, 43, 31, 1, 1, 3 |
| `design-comuni/`, `themes/`, `webdesign/`, `responsive/`, `screenshots/` | evidence della parity con Design Comuni (la resa visuale e' nel tema Sixteen) | 3, 13, 3, 1, 9 |
| `roadmap/`, `migrations/`, `refactoring/` | piani e storico | 38, 8, 1 |
| `errors/`, `investigation/`, `testing/`, `tests/` | diagnosi e test | 8, 1, 1, 11 |
| `raw/` | sorgenti immutabili | 38 |
| `llm-wiki/`, `root-md-files/`, `_integration/`, `localization/`, `localizzazione/`, `it/`, `packages/`, `prompts/`, `outputs/` e altre | legacy | varie |

La radice di `docs/` ha 576 file .md (DOC-004/006 aperti: non spostati). `00-index.md` e' stub (il testo Meetup rotto resta in git); `index.md` e' il catalogo generato (668 righe, `draft`).

## Quality gate PHPStan e test

**Config unica:** un solo gate per tutto il monorepo — `laravel/phpstan.neon` (solo l'umano lo modifica; agenti: `cd laravel && ./vendor/bin/phpstan analyse …` senza `-c`, `--level` o `.neon` nuovi). Il codice si adatta al gate, non il contrario. SSoT: [Xot — phpstan single neon](../../Xot/docs/wiki/memories/phpstan-single-neon-config.md).

- [stories/phpstan-cms-zero.story.md](./stories/phpstan-cms-zero.story.md) - gate a **0 errori** PHPStan su `Modules/Cms` (famiglie Safe/JSON tipizzato, `cmsHomepageBlocks`, DataCollection v5, Resource schema).
- [stories/phpstan-test-wave-cms.story.md](./stories/phpstan-test-wave-cms.story.md) - lane cms del run PHPStan del 2026-10-20: perche' i test del merge `c0a06773` erano specifiche per un Cms con tabelle SQL, cosa e' stato riallineato al modello JSON, cosa resta da decidere.
- [wiki/concepts/env-testing-cms-tests.md](./wiki/concepts/env-testing-cms-tests.md) - base class dei test del modulo e `.env.testing`.

## 📚 Design Comuni - Index Completo

- **[DESIGN_COMUNI_INDEX.md](./DESIGN_COMUNI_INDEX.md)** - **INDEX COMPLETO** con tutti i link bidirezionali

## Active design-comuni references

- [design-comuni-homepage.md](./design-comuni-homepage.md) - Coordinamento Cms per la homepage parity
- [design-comuni-faq.md](./design-comuni-faq.md) - Pagina FAQ ✅ 90%
- [design-comuni-argomenti.md](./design-comuni-argomenti.md) - Pagina argomenti
- [design-comuni-risultati-ricerca.md](./design-comuni-risultati-ricerca.md) - Pagina risultati ricerca
- [design-comuni-page-census.md](./design-comuni-page-census.md) - Censimento 38 pagine
- [design-comuni-services-implementation.md](./design-comuni-services-implementation.md) - Implementazione servizi
- [design-comuni-batch-audit.md](./design-comuni-batch-audit.md) - Audit batch pagine
- [design-comuni-batch-parity.md](./design-comuni-batch-parity.md) - Verifica parity
- [architecture/homepage-structure.md](./architecture/homepage-structure.md) - Flusso runtime aggiornato della homepage di test
- [PAGE_COMPONENT_ARCHITECTURE.md](./PAGE_COMPONENT_ARCHITECTURE.md) - Architettura generale componenti pagina

## Theme cross links

- [../../../Themes/Sixteen/docs/00-index.md](../../../Themes/Sixteen/docs/00-INDEX.md) - Indice docs del tema
- [../../../Themes/Sixteen/docs/design-comuni/00-index.md](../../../Themes/Sixteen/docs/design-comuni/00-index.md) - Workspace attivo parity homepage
- [../../../Themes/Sixteen/docs/design-comuni/ALL_PAGES_ANALYSIS.md](../../../Themes/Sixteen/docs/design-comuni/ALL_PAGES_ANALYSIS.md) - Analisi 54 pagine
- [../../../Themes/Sixteen/docs/design-comuni/PROGRESS_REPORT.md](../../../Themes/Sixteen/docs/design-comuni/PROGRESS_REPORT.md) - Report progresso
- [../../../docs/design-comuni/MASTER_INDEX.md](../../../../docs/design-comuni/MASTER_INDEX.md) - Master Index globale

## Runtime architecture

- La pagina di test e' servita da `Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`.
- Il contenuto locale della homepage arriva da `config/local/fixcity/database/content/pages/tests.homepage.json`.
- Il Cms mantiene il contratto dati e la struttura dei blocchi.
- Il tema Sixteen mantiene layout, CSS e JS di parity visuale.

## Operational rule for this workstream

- Se il problema e' strutturale, verificare prima Cms JSON + routing.
- Se il problema e' visivo, lavorare nel tema e documentare i risultati anche qui.
- Mantenere collegamenti bidirezionali tra docs di modulo e docs di tema.

## Story URL -> JSON (2026-10-13)
- [DCP-41 da URL a JSON: strumento e regola](stories/dcp-41-url-to-json-resolver.story.md)

## PHPStan tests swarm wave (2026-10-20)
- [phpstan-cms-zero.story.md](stories/phpstan-cms-zero.story.md) — inventorio 145 → 0 su modulo Cms (verify canonico)
- [phpstan-cms-swarm-wave.story.md](stories/phpstan-cms-swarm-wave.story.md) — verify gate: TSV 359 → 0 su `Cms.files`
- [phpstan-test-wave-cms.story.md](stories/phpstan-test-wave-cms.story.md) — cause e fix Feature/Unit + PestHelpers

--- BMAD + second brain note (agent AI update 2026-10-14) ---
- [second brain: kp-174d15a58ff94901b2b0df0d86b8907a] Design Comuni parity attiva
- [BMAD decision log: docs/decision-log.md] Convenzioni seguite per worklog + docs
- [AGENTS.md / D10 / D11] Design Comuni, NO Bootstrap Italia
