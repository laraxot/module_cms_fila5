---
title: "ADR del modulo Cms"
type: index
tags: [adr, decisioni, cms]
created: 2026-11-18
updated: 2026-11-26
---

# ADR del modulo Cms

Il **perche'** del routing delle pagine pubbliche: chi monta Folio, chi risolve lo slug, cosa puo' raggiungere un URL
`/{container0}/{slug0}`, quali protezioni puo' chiedere il JSON di una pagina. Sono decisioni di sicurezza (DCP-283) che
sembrano rigidita' inutili. Una decisione per file, con le alternative scartate; il nome del file e' `NNNN-argomento.md`
(numero di decisione, niente date: la data sta nella frontmatter).

Leggili prima di: aggiungere un provider o un percorso Folio, esporre un modello da URL, aggiungere un middleware a una pagina.

## Metodo Harness

Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale. Un ADR deve rendere
leggibili contesto, driver, alternative, decisione, conseguenze e una conferma ripetibile; non e' un diario ne' una spiegazione
retroattiva inventata.

Le decisioni si verificano contro codice e test correnti. Una modifica sostanziale crea un nuovo ADR e segna il precedente
`superseded` o `deprecated`. Regole: [action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md)
e [ADR di Xot](../../../Xot/docs/adr/README.md).

## Formato

Il punto di partenza e' [0000-template.md](0000-template.md). Gli ADR di questa cartella usano queste sezioni, nell'ordine:

```markdown
---
title: "ADR — <decisione in una riga>"
type: decision
status: proposed | accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
decision-makers: []
module: Cms
---

# ADR: <decisione>

## Contesto
Fatti e vincoli che hanno reso necessaria la scelta (misure, norme, policy, incidenti), chiusi dalla domanda a cui risponde.

## Driver della decisione
Vincoli, rischi e obiettivi che pesano sulla scelta.

## Alternative scartate
Ogni alternativa seria, con il motivo per cui non e' stata scelta.

## Decisione
Cosa si fa, in concreto, e dove sta nel codice (file e riga).

## Conseguenze
Pro, contro, debito che resta, cosa misurare.

## Stato attuale
Solo quando il codice di oggi contraddice la decisione: cosa si trova, con file:riga e commit. Non corregge il codice.

## Conferma
Comandi o test che esistono e falliscono se la decisione viene violata; solo cio' che si puo' ripetere.
```

## Decisioni

| ADR | Decisione | Stato | Contratti e test collegati |
|---|---|---|---|
| [0001](0001-cms-owns-page-resolution.md) | Il Cms possiede slug, contenuto e middleware di pagina; il tema e' una shell senza logica di dominio. | accepted; Stato attuale: due eccezioni di dominio in `Page.php` e `ResolveRobotsPolicyAction.php` | [page-slug-middleware](../contracts/page-slug-middleware.md), [page-resolution-action](../contracts/page-resolution-action.md) |
| [0002](0002-container0-model-allowlist.md) | Un modello si carica da URL solo se il contenitore e' in un elenco esplicito e la policy `view` lo consente; nessuna euristica, nessun oracolo di esistenza. | accepted | [page-resolution-action](../contracts/page-resolution-action.md); `ResolvePageModelExposureTest` |
| [0003](0003-folio-volt-sole-owner.md) | `FolioVoltServiceProvider` del Cms e' l'unico owner di Folio e Volt. | accepted; Stato attuale: `laravel/app/Providers/FolioServiceProvider.php` esiste ancora, decisione del lead aperta | `FolioVoltSoleOwnerTest` (nessun contratto: non e' un'Action) |
| [0004](0004-page-middleware-allowlist.md) | I middleware dichiarati nel JSON di una pagina passano da `cms.config.page_middleware_allowlist`; protezione incerta = 503. | accepted; Stato attuale: due `auth/login.json` dichiarano `guest` | [validate-page-middleware-action](../contracts/validate-page-middleware-action.md), [page-slug-middleware](../contracts/page-slug-middleware.md) |

## Stato di copertura

Misurato il 2026-11-26 su `Modules/Cms/docs/adr`:

- 4 ADR su 4 hanno le sezioni Contesto, Driver, Alternative scartate, Decisione, Conseguenze e Conferma, con righe di codice e
  comandi verificabili.
- 3 ADR su 4 (0001, 0003, 0004) hanno uno «Stato attuale» perche' il codice li contraddice in qualche punto; nessuno e' stato
  corretto nel codice da questo lavoro: le scelte sono del lead e sono elencate nel rapporto.
- Nessun ADR `superseded` o `deprecated`.
- Decisioni senza ADR (da scrivere se diventano scelte e non solo fatti): la scrittura della config di testata e piede del
  tenant da pannello (`SaveTenantConfigAction`, vedi i [contratti](../contracts/README.md)); la fusione dei blocchi JSON con
  `ResolveBlockQueryAction` (classe e scope scelti dal JSON, senza elenco: aperta come difetto, non come decisione).
