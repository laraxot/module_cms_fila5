# Cms ADR index

Inventario canonico delle decisioni architetturali del modulo **Cms**: ogni file
`NNNN-slug.md` di questa cartella e' elencato con numero, titolo, stato e link.

Un ADR registra una scelta difficile da invertire con un trade-off reale: contesto,
driver, alternative considerate, decisione, conseguenze e una conferma ripetibile.
Una nuova decisione supera la vecchia (`status: superseded` + `superseded_by:`),
non riscrive la storia.

## Decisioni

| N. | Titolo | Stato | File |
|---|---|---|---|
| 0001 | CMS e middleware possiedono la risoluzione delle pagine Folio | accepted | [0001-cms-owns-page-resolution.md](0001-cms-owns-page-resolution.md) |
| 0002 | Le rotte /{container0}/{slug0} caricano un modello solo da un elenco esplicito e con la policy view | accepted | [0002-container0-model-allowlist.md](0002-container0-model-allowlist.md) |
| 0003 | FolioVoltServiceProvider del modulo Cms e' l'unico punto che monta Folio e Volt | accepted | [0003-folio-volt-sole-owner.md](0003-folio-volt-sole-owner.md) |
| 0004 | I middleware dichiarati nel JSON di una pagina passano da un'allowlist di configurazione | accepted | [0004-page-middleware-allowlist.md](0004-page-middleware-allowlist.md) |

Motivi, stato e contratti collegati: [README](../../archive/docs-legacy/docs/adr/README.md).

## Authoring

Use the shared template [0000-template.md](0000-template.md) and the rules in
[Xot ADR standards](../../../Xot/docs/adr/README.md). Do not create an ADR for a
local implementation detail or an unverified hypothesis.
