---
title: "Contratti — Cms"
type: index
tags: [contracts, actions, cms]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti del modulo Cms

Cosa promettono le Action di Cms che decidono cosa un URL pubblico puo' mostrare e che riscrivono la config dell'aspetto del
tenant. Le Action `Head/*`, `Get*` e i resolver di blocchi calcolano valori per le viste e non hanno contratto.

Leggili prima di toccare la risoluzione delle pagine `[container0]/[slug0]`, i middleware dei JSON di pagina o il
salvataggio di testata e piede dal pannello.

Formato (6 sezioni, invarianti con ID e group Pest): [regola canonica](../../../Xot/docs/rules/action-behavioral-contract.md).
Lanciare le invarianti coperte: `vendor/bin/pest Modules/Cms/tests/<file> --group=<ID>`.

## Contratti

- [ResolvePageAction](resolve-page-action.md) — modello solo da elenco e con policy `view`, poi pagina CMS esatta o generica.
- [ValidatePageMiddlewareAction](validate-page-middleware-action.md) — allowlist dei middleware dichiarati nel JSON di pagina.
- [SaveHeadernavConfigAction](save-headernav-config-action.md) — salva la testata nella chiave `headernav` di `appearance.php` del tenant.
- [SaveFooterConfigAction](save-footer-config-action.md) — salva il piede nella chiave `footer` di `appearance.php` del tenant.
