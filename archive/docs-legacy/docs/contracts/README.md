---
title: "Contratti — Cms"
type: index
tags: [contracts, actions, interfaces, cms]
created: 2026-11-18
updated: 2026-11-26
---

# Contratti del modulo Cms

Cosa promettono le Action di Cms che decidono cosa un URL pubblico puo' mostrare e che riscrivono la config dell'aspetto del
tenant. Le Action `Head/*`, `Get*` e i resolver di blocchi calcolano valori per le viste e non hanno contratto.

Leggili prima di toccare la risoluzione delle pagine `[container0]/[slug0]`, i middleware dei JSON di pagina o il
salvataggio di testata e piede dal pannello.

Formato (6 sezioni, invarianti con ID e group Pest): [regola canonica](../../../Xot/docs/rules/action-behavioral-contract.md).
Lanciare le invarianti coperte: `vendor/bin/pest Modules/Cms/tests/<file> --group=<ID>`.

## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio.
Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in un contratto.

Cosa promette la superficie pubblica di questo pacchetto: le Action che scrivono dati, chiamano servizi esterni o hanno
effetti collaterali, e le interfacce (`app/Contracts`). Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.

Ogni invariante ha un ID stabile nel formato `CMS-<AREA>-INV-N` (per esempio `CMS-HEADERNAV-SAVE-INV-1`); il test Pest
corrispondente usa lo stesso ID come group. La classe implementatrice contiene `@contract docs/contracts/<file>.md`;
contratto, codice e test cambiano nello stesso commit.

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

Il docblock dell'Action rimanda al file con il marker `@contract docs/contracts/<file>.md`; la riga legacy
`Contratto di comportamento: docs/contracts/<file>.md` può restare.
Chi cambia il comportamento aggiorna il contratto nello stesso commit.

## Contratti

- [ResolvePageAction, contratto di risoluzione Folio](page-resolution-action.md) — modello solo da elenco e con policy `view`, poi pagina CMS esatta o generica; vista dalle rotte `[container0]/[slug0]`: `renderMode`, `item`, `pageSlug`; un contenitore fuori allowlist non carica modelli dall'URL. Il vecchio file `resolve-page-action.md` (tabella invarianti e ADR dell'allowlist) è stato fuso in questo.
- [ResolvePageMetaAction](page-meta-resolution-action.md) — titolo e descrizione della pagina in rendering: priorità modello poi blocchi, descrizioni da 160 caratteri al massimo, valore già registrato non sovrascritto.
- [ValidatePageMiddlewareAction](validate-page-middleware-action.md) — allowlist dei middleware dichiarati nel JSON di pagina; ADR correlato [0004](../adr/0004-page-middleware-allowlist.md).
- [Contratto `PageSlugMiddleware`](page-slug-middleware.md) — esegue i middleware dichiarati dal contenuto CMS; 404 profilo legacy non risolvibile, 503 fail-closed (`CMS-PAGE-SLUG-INV-*`).
- [SaveHeadernavConfigAction](save-headernav-config-action.md) — salva la testata in `appearance.headernav` (`CMS-HEADERNAV-SAVE-INV-1`).
- [SaveFooterConfigAction](save-footer-config-action.md) — salva il piede in `appearance.footer` (`CMS-FOOTER-SAVE-INV-1`).
- [ADR ownership della risoluzione](../adr/0001-cms-owns-page-resolution.md) — la risoluzione delle pagine è del Cms, non dei moduli applicativi.

## Garantito a FixCity e default per altri tenant

Il Cms e' condiviso (altri tenant, per esempio Meetup, non presente in questo checkout): ogni contratto ha una sezione
«Garantito a FixCity e default per altri tenant». In sintesi: la risoluzione delle pagine e l'allowlist dei middleware sono
uguali per tutti, solo la configurazione cambia (mappa `cms.config.container0_models`, allowlist, file `appearance.php` del
tenant); `ResolvePageMetaAction` non ha comportamento specifico di FixCity.

## Stato di copertura

Misurato il 2026-11-26 con `audit_docs.py Modules/Cms` e leggendo i test (nessun test e' stato eseguito da questo lavoro):

| Contratto | Invarianti | Con group Pest su un test esistente |
|---|---|---|
| page-resolution-action | 7 | 6 (manca INV-7, `QueryException`) |
| page-meta-resolution-action | 6 | 0 (nessun test dell'Action) |
| validate-page-middleware-action | 6 | 5 (manca INV-6, voci di config non stringa) |
| page-slug-middleware | 10 | 8 (mancano INV-6, struttura del modulo; INV-10, candidato piu' specifico) |
| save-headernav-config-action | 3 | 1 (mancano INV-2 e INV-3) |
| save-footer-config-action | 2 | 1 (manca INV-2) |
| **Totale** | **34** | **21** (62%) |

- Le Action di Cms sono 23 (`app/Actions/**`): 5 hanno un contratto (22%), piu' il middleware `PageSlugMiddleware`. Le altre
  18 calcolano valori per le viste o gestiscono liste e percorsi: l'audit non ne trova una che scriva dati o chiami servizi
  esterni senza contratto, ma due scrivono file (`SanitizeHtmlAction` la cache, `FixJigSawByModuleAction` i `docs/` del
  modulo) e le prime tre del backlog sotto sono rischiose per altri motivi.
- «Con group» vuol dire che un test porta `->group('<ID>')`, non che sia verde: `ValidatePageMiddlewareActionTest`,
  `PageSlugMiddlewareFailClosedTest`, `ResolvePageModelExposureTest` e `SaveHeadernavConfigActionTest` non sono stati lanciati
  qui; il test sui JSON `PageJsonMiddlewareAllowlistTest` e' rosso per i due `guest` di `auth/login.json` (vedi [ADR
  0004](../adr/0004-page-middleware-allowlist.md), Stato attuale).

## Backlog contract

Action senza contratto, in ordine di priorita':

1. `ResolveBlockQueryAction` — il JSON del blocco sceglie la classe (`new $modelClass`, solo `class_exists`), gli scope
   (`$query->{$scope}()`) e la colonna di `orderBy`, senza elenco ammesso (`ResolveBlockQueryAction.php:21-58`, chiamata da
   `BlockData.php:56`). Stessa famiglia di DCP-283 C-03/C-04: serve un contratto e un elenco, prima di documentare
   il comportamento attuale come garantito.
2. `SanitizeHtmlAction` — difesa da XSS dei contenuti; scrive una cache su disco (`storage/framework/cache/htmlpurifier`,
   riga 39). Le invarianti vanno dai test esistenti, se ce ne sono.
3. `RedirectUnlocalizedPathAction` — risponde 302 verso un percorso costruito dal percorso della richiesta
   (`RedirectUnlocalizedPathAction.php:33,57`): va specificato cosa non puo' mai diventare un redirect aperto.
4. `BuildPageSchemaAction`, `ResolveRobotsPolicyAction` (contiene lo slug di dominio `HIDDEN_SLUGS`, vedi [ADR
   0001](../adr/0001-cms-owns-page-resolution.md)), `ResolveLocalizedBlockDataAction`, `FixJigSawByModuleAction`
   (scrive in `docs/` del modulo): da contrattualizzare quando si toccano.

## Backlog test

Invarianti dichiarate e senza group (13 su 34):

- `CMS-PAGE-META-INV-1` ... `-INV-6`: nessun test dell'Action `ResolvePageMetaAction` (`rg -l "ResolvePageMetaAction|cms\.meta"
  Modules/*/tests` non trova nulla). Un unico file di test unitario le copre tutte.
- `CMS-FOOTER-SAVE-INV-2` e `CMS-HEADERNAV-SAVE-INV-2`, `-INV-3`: vanno asseriti su un file `appearance.php` di un tenant di
  prova o con un mock del `Data`, non sul file del tenant reale.
- `CMS-PAGE-MIDDLEWARE-INV-6`: allowlist di config con voci non stringa o vuote.
- `CMS-RESOLVE-PAGE-INV-7`: `QueryException` in `resolveRouteBinding()` con un identificativo di tipo sbagliato.
- `CMS-PAGE-SLUG-INV-6` (nessun import di classi di dominio: un test Arch sul modulo) e `CMS-PAGE-SLUG-INV-10` (il percorso
  precede il nome della rotta).

Altri test da scrivere, non legati a una invariante:

- Un test statico che vieti `render()` e query nelle Blade delle pagine Folio (vedi [ADR 0001](../adr/0001-cms-owns-page-resolution.md)).
- Un test Arch che garantisca un solo proprietario di `Folio::path` (vedi [ADR 0003](../adr/0003-folio-volt-sole-owner.md)).
- Decidere quale dei due `PageSlugMiddlewareTest.php` omonimi tenere (`Unit/Middleware` o `Unit/Http/Middleware`).

## Indici e template

- [index.md](index.md) e [INDEX.md](INDEX.md) — inventari machine-readable dei sei contratti Cms.
- [_template.md](_template.md) — template minimo `type: contract` con `action: <FQCN>` e le sei sezioni.
