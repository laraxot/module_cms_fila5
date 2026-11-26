---
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
