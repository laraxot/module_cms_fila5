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

## Harness minimo: ownership, evidenza e recupero (2026-11-27)

I contratti di **module_cms_fila5** restano accanto alle Action, interfacce o superfici di questo package; root e Xot definiscono lo standard, non copiano le promesse. Un contratto comportamentale esplicita **Input, Output, Invarianti, Effetti collaterali, Errori, Non fa**; ogni ID di invariante punta a un group Pest effettivo oppure segnala `non dimostrata`. Se esiste la classe, il docblock deve rimandare al file con `@contract` e `@see`; per temi senza classi PHP non inventare Action/contratti.

- [Standard Xot](https://github.com/laraxot/module_xot_fila5/blob/dev/docs/contracts/contract-authoring-standard.md) · [ownership root](https://github.com/laraxot/base_ptvx_fila5/blob/dev/docs/adr/0001-harness-minimo-e-ownership.md) · [runbook ECC/Second Brain](https://github.com/laraxot/base_ptvx_fila5/blob/dev/docs/harness/README.md).
- **BMAD**: prima di cambiare una promessa, fissa nella story owner scope, esclusioni, evidenza e approvazioni richieste.
- **ECC**: i marker di merge rendono invalido l'indice; citare una suite non significa averla eseguita. Distingui `pass`, `fail`, `non eseguito` e registra il debito in [rollout #15](https://github.com/laraxot/base_ptvx_fila5/issues/15).
- **Second Brain**: QMD/Graphify e `.harness/memory/{facts,lessons}.md` sono puntatori a evidenza datata, non copie dei contratti.
