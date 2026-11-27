---
title: "INDEX contratti — Cms"
type: index
module: Cms
status: active
created: 2026-11-27
updated: 2026-11-27
---

# Indice dei contratti — Cms

Ogni file `type: contract` descrive una Action o una superficie del modulo con le sei
sezioni canoniche (`Input`, `Output`, `Invarianti`, `Effetti collaterali`, `Errori`,
`Non fa`) e il marker `action: <FQCN>` nella frontmatter. La classe rimanda al file con
`@contract docs/contracts/<file>.md` nel docblock. L'inventario machine-readable e'
in [INDEX.md](INDEX.md); il formato e' descritto in [README.md](README.md).

## Risoluzione pagine e meta

| Contratto | Action | Invarianti (group Pest) | File |
|---|---|---|---|
| ResolvePageAction | `Modules\Cms\Actions\ResolvePageAction` | CMS-RESOLVE-PAGE-INV-1..6 (`CMS-RESOLVE-PAGE-INV-7` non dimostrato) | [page-resolution-action.md](page-resolution-action.md) |
| ResolvePageMetaAction | `Modules\Cms\Actions\ResolvePageMetaAction` | CMS-PAGE-META-INV-1..6 (tutte non dimostrate) | [page-meta-resolution-action.md](page-meta-resolution-action.md) |
| PageSlugMiddleware | `Modules\Cms\Http\Middleware\PageSlugMiddleware` | CMS-PAGE-SLUG-INV-1..5, 7..9 dimostrate; INV-6 e INV-10 non dimostrate | [page-slug-middleware.md](page-slug-middleware.md) |

## Middleware e configurazione

| Contratto | Action | Invarianti (group Pest) | File |
|---|---|---|---|
| ValidatePageMiddlewareAction | `Modules\Cms\Actions\ValidatePageMiddlewareAction` | CMS-PAGE-MIDDLEWARE-INV-1..5 dimostrate; INV-6 non dimostrato | [validate-page-middleware-action.md](validate-page-middleware-action.md) |
| SaveFooterConfigAction | `Modules\Cms\Actions\SaveFooterConfigAction` | CMS-FOOTER-SAVE-INV-1 dimostrato; INV-2 non dimostrato | [save-footer-config-action.md](save-footer-config-action.md) |
| SaveHeadernavConfigAction | `Modules\Cms\Actions\SaveHeadernavConfigAction` | CMS-HEADERNAV-SAVE-INV-1 dimostrato; INV-2 e INV-3 non dimostrati | [save-headernav-config-action.md](save-headernav-config-action.md) |

## Note

- Le decisioni dietro i contratti stanno in [../adr/](../adr/README.md).
- Il vecchio `resolve-page-action.md` e' stato fuso in `page-resolution-action.md`
  (stessi ID invariante, versione piu' ricca): non esiste piu' come file separato.
