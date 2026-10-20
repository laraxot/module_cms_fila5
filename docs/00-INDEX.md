---
title: "00 INDEX"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-14
qmd: "00 INDEX"
issues: []
discussions: []
status: draft
---

# Cms Module Documentation

## Overview

Il modulo Cms gestisce contenuti, composizione pagina e rendering CMS-driven dei blocchi. Nel lavoro corrente sulla parity Design Comuni, il Cms governa la struttura della homepage di test, mentre la resa visuale viene rifinita nel tema Sixteen.

## Governance documentale

- [Contratto moduli/temi](../../../../bmad-output/docs-architecture/module-theme-docs-contract.md)
- [Tassonomia](../../../../bmad-output/docs-architecture/taxonomy.md)
- [Ownership](../../../../bmad-output/docs-architecture/ownership.md)

Questo indice è l'ingresso operativo del Cms. `index.md` e `00-index.md` sono
varianti storiche: non creare altri indici; prima di consolidarli verificare i
riferimenti con `rg`.

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

La radice di `docs/` ha 576 file .md (DOC-004/006 aperti: non spostati). `00-index.md` e' una variante storica con link a `../Meetup/docs/` inesistenti (annotati); `index.md` e' il catalogo generato (668 righe, `draft`).

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

--- BMAD + second brain note (agent AI update 2026-10-14) ---
- [second brain: kp-174d15a58ff94901b2b0df0d86b8907a] Design Comuni parity attiva
- [BMAD decision log: docs/decision-log.md] Convenzioni seguite per worklog + docs
- [AGENTS.md / D10 / D11] Design Comuni, NO Bootstrap Italia
