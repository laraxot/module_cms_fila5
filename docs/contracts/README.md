---
title: "Contratti"
type: index
tags: [contracts, actions, interfaces]
created: 2026-11-18
updated: 2026-11-18
---

# Contratti

Cosa promette la superficie pubblica di questo pacchetto: le Action che scrivono dati, chiamano servizi esterni o hanno
effetti collaterali, e le interfacce (`app/Contracts`). Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.

## Contratto di comportamento di un'Action

Un file per Action, nome in kebab-case della classe (`create-ticket-action.md`), frontmatter `type: contract` e
`action: <FQCN>`, e queste sei sezioni nell'ordine:

```markdown
## Input
## Output
## Invarianti
## Effetti collaterali
## Errori
## Non fa
```

Il docblock dell'Action rimanda al file con la riga `Contratto di comportamento: docs/contracts/<file>.md`.
Chi cambia il comportamento aggiorna il contratto nello stesso commit.

## Contratti

- [ResolvePageAction](page-resolution-action.md)
- [ResolvePageMetaAction](page-meta-resolution-action.md)
- [SaveFooterConfigAction](save-footer-config-action.md)
- [SaveHeadernavConfigAction](save-headernav-config-action.md)

- [Contratto `PageSlugMiddleware`](page-slug-middleware.md)
- [ADR ownership della risoluzione](../adr/cms-owns-page-resolution.md)

