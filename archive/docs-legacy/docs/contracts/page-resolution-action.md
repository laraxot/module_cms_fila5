---
title: "Contratto — ResolvePageAction"
type: contract
action: "Modules\\Cms\\Actions\\ResolvePageAction"
tags: [contract, action, folio, cms, sicurezza, dcp-283]
module: Cms
status: accepted
created: 2026-11-23
updated: 2026-11-26
---

# ResolvePageAction

Contratto di comportamento della risoluzione CMS per le rotte Folio `[container0]/[slug0]` (regola:
`Modules/Xot/docs/rules/action-behavioral-contract.md`). Sorgente: `app/Actions/ResolvePageAction.php`. Perché esiste:
[ADR 0002](../adr/0002-container0-model-allowlist.md) e [ADR 0001](../adr/0001-cms-owns-page-resolution.md). Chiamanti:
`Modules\Cms\View\Components\Page::resolveDynamicContext()` (`app/View/Components/Page.php:99`) e
`PageSlugMiddleware::rejectLegacyProfileRoutes()` (`app/Http/Middleware/PageSlugMiddleware.php:60`). Il vecchio file
`resolve-page-action.md` (tabella invarianti e ADR dell'allowlist) è stato fuso in questo.

## Input

- `string $container0`: contenitore della rotta, non vuoto (es. `blog`, `events`, `tickets`).
- `string $slug0`: slug o identificativo della risorsa, non vuoto (può arrivare dall'URL: non è fidato).
- `cms.config.container0_models` (default `[]`, `config/config.php:29`) e l'alias storico `xra.container0_model_map`: mappa
  contenitore => classe Eloquent. Se entrambe elencano il contenitore vince la prima chiave con una classe valida.

## Output

`ResolvePageData` (`app/Datas/ResolvePageData.php`) con:

- `renderMode`: `model` se è stato trovato un modello autorizzato, altrimenti `cms`;
- `item`: il modello (o l'articolo Blog) autorizzato, oppure `null`;
- `pageSlug`: `<container0>.view` se c'è un modello; altrimenti `<container0>.<slug0>` se esiste una pagina CMS con quello slug,
  altrimenti `<container0>.view` se esiste, altrimenti `<container0>.<slug0>` come ripiego (la pagina potrebbe non esistere:
  il chiamante decide il 404).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| CMS-RESOLVE-PAGE-INV-1 | Un contenitore non elencato nelle mappe non carica nessun modello dall'URL (`item` null, `renderMode` `cms`); `profile`, `user` e `users` non hanno più un ramo dedicato né l'euristica del singolare. Se cade, ogni modello dell'applicazione diventa raggiungibile da `/{container0}/{id}` (DCP-283 C-04). | `CMS-RESOLVE-PAGE-INV-1` |
| CMS-RESOLVE-PAGE-INV-2 | Un contenitore elencato espone il modello solo se `Gate::allows('view', $item)` per chi guarda, ospite compreso; policy che nega o assente = `item` null, indistinguibile da non trovato. Se cade, torna l'oracolo di esistenza (200 contro 404). | `CMS-RESOLVE-PAGE-INV-2` |
| CMS-RESOLVE-PAGE-INV-3 | Il record si legge con `resolveRouteBinding()`: chiave di rotta e scope globali del modello valgono; un record escluso da uno scope non è raggiungibile. Se cade, un record nascosto (bozza, soft delete) si vede da URL. | `CMS-RESOLVE-PAGE-INV-3` |
| CMS-RESOLVE-PAGE-INV-4 | Una voce di configurazione che non è una classe esistente sottoclasse di `Model` (stringa non-modello, numero) viene ignorata come se non ci fosse. Se cade, una config sbagliata farebbe istanziare una classe qualunque. | `CMS-RESOLVE-PAGE-INV-4` |
| CMS-RESOLVE-PAGE-INV-5 | `blog` ed `events`, se il modulo Blog è installato, passano solo dai finder dei contenuti pubblicati (`findPublishedPostBySlug`, `findPublishedEventBySlug`): un post non si legge come evento e viceversa; slug inesistente = `item` null. Se cade, bozze o contenuti del tipo sbagliato sono pubblici. | `CMS-RESOLVE-PAGE-INV-5` |
| CMS-RESOLVE-PAGE-INV-6 | Senza modello, `pageSlug` segue l'ordine: pagina CMS con slug `<container0>.<slug0>` se esiste, poi `<container0>.view` se esiste, poi `<container0>.<slug0>`; con un modello è `<container0>.view`. Se cade, una pagina dedicata non prevale più sul contenitore generico. | `CMS-RESOLVE-PAGE-INV-6` |
| CMS-RESOLVE-PAGE-INV-7 | Una `QueryException` durante `resolveRouteBinding()` (es. identificativo di tipo sbagliato per la colonna) dà `item` null invece di un 500. Se cade, un URL malformato produce errori di database. | — (non dimostrato) |

## Effetti collaterali

- Nell'ordine, per `blog`/`events` con Blog installato: risolve `Modules\Blog\View\Composers\ThemeComposer` dal container e
  chiama il finder (una lettura); la mappa non viene consultata.
- Altrimenti: legge le due chiavi di config; `app($modelClass)` istanzia il modello; `resolveRouteBinding()` (una `SELECT`);
  `Gate::allows('view', $item)` (la policy può leggere altro).
- Senza modello: fino a due `SELECT ... exists` su `pages` (`<container0>.<slug0>`, poi `<container0>.view`).
- Non modifica record, sessione, cache o risposta HTTP.

## Errori

- `QueryException` durante `resolveRouteBinding()` — trattata come modello non risolto (INV-7).
- Modello assente, slug assente o policy negata → `item: null`; il chiamante decide 404 o ripiego CMS (INV-2).
- Ogni altra eccezione (query su `pages`, istanziazione del modello, policy, finder Blog) risale al chiamante: nessun
  `catch` oltre a `QueryException`.

## Non fa

- Non esegue redirect e non risponde 404/403: ritorna dati.
- Non costruisce markup o metadata (vedi [page-meta-resolution-action.md](page-meta-resolution-action.md)).
- Non carica classi arbitrarie in base al nome presente nell'URL.
- Non decide la visibilità del payload di un record: la mappa `tickets` abilita il contenitore, la visibilità resta nella
  policy di Fixcity.
- Non conosce tenant né moduli applicativi: l'elenco dei contenitori è configurazione.

## Garantito a FixCity e default per altri tenant

- Garantito a FixCity: `tickets` è mappato a `Modules\Fixcity\Models\Ticket` da `config/local/fixcity/xra.php:17` e imposto da
  `FixcityServiceProvider.php:78-82`, quindi `/tickets/{id}` passa dall'allowlist e dalla `TicketPolicy::view`
  (`Modules/Fixcity/app/Policies/TicketPolicy.php:22`, ospite: solo se `isVisibleOnPublicFrontoffice()`). `blog` ed `events`
  usano i finder del modulo Blog, presente in questo checkout. Nessun altro contenitore carica modelli.
- Default per altri tenant (es. Meetup, non presente qui): mappa vuota, nessun modello da URL; senza il modulo Blog `blog` ed
  `events` ricadono nella mappa (`ResolvePageAction.php:86`). Pagine-modello = voce in `cms.config.container0_models` più
  policy `view` del modello.

## Limiti noti

- `PageSlugMiddleware` mantiene un elenco fisso `['profile', 'user', 'users']` per le rotte legacy
  (`PageSlugMiddleware.php:56`): non è configurabile.
