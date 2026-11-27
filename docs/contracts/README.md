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

## File

- [page-resolution-action.md](page-resolution-action.md) — `ResolvePageAction`: da URL a pagina CMS o modello autorizzato.
- [page-meta-resolution-action.md](page-meta-resolution-action.md) — `ResolvePageMetaAction`: titolo e descrizione della pagina.
- [page-slug-middleware.md](page-slug-middleware.md) — `PageSlugMiddleware`: middleware dichiarati nel JSON di pagina, fail-closed.
- [validate-page-middleware-action.md](validate-page-middleware-action.md) — `ValidatePageMiddlewareAction`: allowlist dei middleware di pagina.
- [save-footer-config-action.md](save-footer-config-action.md) — `SaveFooterConfigAction`: salvataggio della configurazione footer.
- [save-headernav-config-action.md](save-headernav-config-action.md) — `SaveHeadernavConfigAction`: salvataggio della configurazione header/nav.

L'indice di lavoro con le classi e gli ID invariante e' in [index.md](index.md);
il modello per i nuovi contratti e' [_template.md](_template.md).
