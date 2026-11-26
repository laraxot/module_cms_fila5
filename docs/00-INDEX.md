---
title: "00 INDEX"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-13
qmd: "00 INDEX"
issues: [63]
discussions: []
---

# Cms Module Documentation

Ingresso operativo della documentazione del modulo Cms. Il modulo gestisce
contenuti, composizione pagina e rendering CMS-driven dei blocchi; nel lavoro
corrente sulla parity Design Comuni governa la struttura della homepage di
test, mentre la resa visuale vive nel tema Sixteen.

## Documentazione corrente (docs/)

- [README.md](./README.md) - Panoramica del modulo e struttura
- [CHANGELOG.md](./CHANGELOG.md) - Cronologia modifiche
- [BEST_PRACTICES.md](./BEST_PRACTICES.md) - Best practice consolidate
- [best-practices/](./best-practices/) - Convenzioni blade, Filament, namespace, rendering
- [adr/](./adr/INDEX.md) - Decisioni architetturali (ADR)
- [contracts/](./contracts/INDEX.md) - Contratti delle Action pubbliche
- [stories/](./stories/) - Solo story attive (in-progress, in-review, planning, todo)
- [roadmap/](./roadmap/index.md) - Stato e prossimi passi
- [bmad/](./bmad/status.md) - Stato lavoro BMAD
- [wiki/](./wiki/index.md) - Wiki di dominio del modulo
- [actions/](./actions/page-resolution-pipeline.md) - Pipeline di risoluzione pagine
- [architecture/](./architecture/structure.md) - Struttura e homepage
- [blocks/](./blocks/index.md) - Blocchi di contenuto (indice)

## Guide tematiche

- [page-directory-structure.md](./page-directory-structure.md) - Regola directory pagine
- [page-component-architecture.md](./page-component-architecture.md) - Architettura componenti pagina
- [content-blocks-architecture.md](./content-blocks-architecture.md) - Architettura content blocks
- [json-content-system-architecture.md](./json-content-system-architecture.md) - Storage JSON contenuti
- [cms-driven-pages-system.md](./cms-driven-pages-system.md) - Pagine CMS-driven
- [page-content-management.md](./page-content-management.md) - Gestione contenuti pagina
- [filament-blocks-system.md](./filament-blocks-system.md) - Sistema blocchi Filament
- [block-data-flow.md](./block-data-flow.md) - Flusso dati dei blocchi
- [page-block-data-resolution.md](./page-block-data-resolution.md) - Risoluzione dati blocco
- [layout-runtime-contract.md](./layout-runtime-contract.md) - Contratto runtime layout
- [cms-theme-template-runtime-architecture.md](./cms-theme-template-runtime-architecture.md) - Runtime template tema
- [queueable-actions.md](./queueable-actions.md) - Regole Action Queueable
- [x-page-context-data-rule.md](./x-page-context-data-rule.md) - Regola X-Page context data
- [multi-step-forms.md](./multi-step-forms.md) - Form multi-step
- [folio-routing-system.md](./folio-routing-system.md) - Routing Folio
- [testing-guidelines.md](./testing-guidelines.md) - Linee guida testing
- [file-naming-rules.md](./file-naming-rules.md) - Regole nomi file
- [LICENSE.md](./LICENSE.md)

## Design Comuni (parity)

- [DESIGN_COMUNI_INDEX.md](./DESIGN_COMUNI_INDEX.md) - Indice workstream parity
- [design-comuni-homepage.md](./design-comuni-homepage.md) - Homepage di test
- [design-comuni-faq.md](./design-comuni-faq.md) - Pagina FAQ
- [design-comuni-argomenti.md](./design-comuni-argomenti.md) - Pagina argomenti
- [design-comuni-risultati-ricerca.md](./design-comuni-risultati-ricerca.md) - Risultati ricerca
- [design-comuni-page-census.md](./design-comuni-page-census.md) - Censimento pagine

## Theme cross links

- [../../../Themes/Sixteen/docs/00-index.md](../../../Themes/Sixteen/docs/00-index.md) - Indice docs del tema
- [../../../Themes/Sixteen/docs/design-comuni/00-index.md](../../../Themes/Sixteen/docs/design-comuni/00-index.md) - Workspace attivo parity homepage

## Runtime architecture

- La pagina di test e' servita da `Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`.
- Il contenuto locale della homepage arriva da `config/local/fixcity/database/content/pages/tests.homepage.json`.
- Il Cms mantiene il contratto dati e la struttura dei blocchi.
- Il tema Sixteen mantiene layout, CSS e JS di parity visuale.

## Archivio

La documentazione storica (audit, report PHPStan, vecchie roadmap, cataloghi
di riferimento UI, duplicati case/underscore, file `.old`/`.mdc`) e' in
[archive/docs-legacy/docs/](../archive/docs-legacy/docs/) con README
esplicativo. I link interni dei documenti mantenuti puntano gia' li' dove il
destinatario e' stato archiviato.
