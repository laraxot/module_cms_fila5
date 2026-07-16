---
title: "Tenant JSON come contenuto del front office"
type: concept
tags: [cms, tenant, json, x-page, blocks, frontoffice]
module: Cms
created: 2026-07-16
updated: 2026-07-16
qmd: "Cms tenant JSON pages sections x-page blocks contenuto front office"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/40"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/41"
related:
  - cms-page-middleware-json-ssot.md
  - x-page-data-bag-only.md
---

# Tenant JSON come contenuto del front office

Nel CMS Laraxot il tenant JSON non è configurazione accessoria: è l'input
editoriale di `<x-page>`. Le pagine descrivono blocchi e lingue; le sezioni
descrivono elementi trasversali come header e footer.

La separazione ha uno scopo preciso: Folio possiede il percorso, il CMS legge
i dati, il tema veste i blocchi. Questa architettura evita controller FO,
route manuali e un Blade diverso per ogni pagina.

Perciò il modulo deve considerare `database/content/pages` e `sections` dati
sacri del tenant. Un loader più elegante non compensa mai un contenuto perso.
