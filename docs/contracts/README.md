---
<<<<<<< .merge_file_KdTGfx
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
=======
title: "Contratti comportamentali — Cms"
type: documentation
module: Cms
status: active
---

# Contratti comportamentali — Cms

Questa cartella descrive gli input, gli output, gli invarianti, gli effetti e
gli errori osservabili delle Action del modulo CMS. L'indice alfabetico è in
[INDEX.md](./INDEX.md); i contratti devono restare aderenti al codice e ai
test del modulo.

## Convenzioni

- ogni Action con effetti osservabili ha un contratto con riferimento @see;
- gli invarianti importanti sono verificabili con Pest o con un controllo
  source-level ripetibile;
- il file _template.md è il modello per i nuovi contratti;
- le integrazioni applicative restano configurabili dall'host.

## Verifica

Da laravel/: vendor/bin/pest Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php.
>>>>>>> .merge_file_VqrsZ3
