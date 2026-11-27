---
title: "Contratto — ValidatePageMiddlewareAction"
type: contract
<<<<<<< .merge_file_ijVmPQ
action: "Modules\Cms\Actions\ValidatePageMiddlewareAction"
tags: [contract, action, cms, middleware, sicurezza]
created: 2026-11-24
updated: 2026-11-24
=======
action: "Modules\\Cms\\Actions\\ValidatePageMiddlewareAction"
tags: [contract, action, middleware, sicurezza, dcp-283]
module: Cms
status: accepted
created: 2026-11-26
updated: 2026-11-26
>>>>>>> .merge_file_sNZzgk
---

# ValidatePageMiddlewareAction

<<<<<<< .merge_file_ijVmPQ
Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/ValidatePageMiddlewareAction.php`. Perche': [ADR](../adr/page-middleware-allowlist.md).
Chiamante: `app/Http/Middleware/PageSlugMiddleware.php`. Action pura, con contratto perche' e' un confine di sicurezza.

## Input

- `$declared`: lista dei middleware letti dal campo `middleware` del JSON della pagina (es. `['auth', 'throttle:10,1']`).
- Implicito: `cms.config.page_middleware_allowlist`.

## Output

- La stessa lista, invariata, se ogni voce e' ammessa.
=======
Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`). Sorgente:
`app/Actions/ValidatePageMiddlewareAction.php`. Perché esiste: [ADR 0004](../adr/0004-page-middleware-allowlist.md).
Chiamante in produzione: `PageSlugMiddleware::middlewaresOrRefuse()` (`app/Http/Middleware/PageSlugMiddleware.php:94`);
la usa anche il test `tests/Unit/Content/PageJsonMiddlewareAllowlistTest.php` per controllare i JSON del repository.

## Input

- `list<string> $declared`: i valori del campo `middleware` del JSON di una pagina, già validati come lista di stringhe non
  vuote da `Page::declaredMiddleware()` (`app/Models/Page.php:154`). Ogni voce è un nome (`auth`) o un nome con parametri
  (`throttle:10,1`).
- `config('cms.config.page_middleware_allowlist')`: lista di nomi ammessi, letta a ogni chiamata (default
  `['auth', 'throttle']`, `config/config.php:18`).

## Output

- La stessa lista `$declared`, invariata nell'ordine e nei parametri, se ogni nome è ammesso. Lista vuota → lista vuota.
- Il confronto è sul testo prima del primo `:`, esatto e sensibile alle maiuscole.
>>>>>>> .merge_file_sNZzgk

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
<<<<<<< .merge_file_ijVmPQ
| CMS-PAGE-MIDDLEWARE-INV-1 | Si confronta il nome prima dei `:` in modo esatto (maiuscole, spazi, prefissi contano); fuori allowlist = eccezione. | `CMS-PAGE-MIDDLEWARE-INV-1` |
| CMS-PAGE-MIDDLEWARE-INV-2 | Un solo nome non ammesso rifiuta l'intera lista. | `CMS-PAGE-MIDDLEWARE-INV-2` |
| CMS-PAGE-MIDDLEWARE-INV-3 | `web` passa sempre: e' gia' applicato dallo stack Folio. | `CMS-PAGE-MIDDLEWARE-INV-3` |
| CMS-PAGE-MIDDLEWARE-INV-4 | L'allowlist viene solo dalla config; se non e' un array, non passa nulla tranne `web`. | `CMS-PAGE-MIDDLEWARE-INV-4` |

## Effetti collaterali

- Nessuno.

## Errori

- `InvalidArgumentException` al primo middleware non ammesso, con il nome e l'elenco ammesso nel messaggio.
  `PageSlugMiddleware` la trasforma in 503 con log.

## Non fa

- Non verifica che il middleware esista o sia risolvibile (lo fa `PageSlugMiddleware::assertResolvable`).
- Non applica i middleware.
- Non legge il JSON: riceve la lista gia' estratta.
=======
| CMS-PAGE-MIDDLEWARE-INV-1 | Un nome che non è in allowlist e non è `web` lancia `InvalidArgumentException`: classi FQCN, `guest`, `api`, refusi (`auht`), maiuscole diverse (`Auth`), spazi davanti, nome vuoto, solo parametri, prefissi di un nome ammesso (`authorize:view`). Se cade, chi edita un JSON fa eseguire qualunque classe con un metodo `handle`. | `CMS-PAGE-MIDDLEWARE-INV-1` |
| CMS-PAGE-MIDDLEWARE-INV-2 | Un solo nome non ammesso rifiuta l'intera lista: nessuna lista parziale, l'eccezione nomina la voce rifiutata. Se cade, una pagina protetta perderebbe `auth` e manterrebbe le altre voci. | `CMS-PAGE-MIDDLEWARE-INV-2` |
| CMS-PAGE-MIDDLEWARE-INV-3 | `web` non viene mai rifiutato (gruppo già applicato dallo stack Folio, `FOLIO_APPLIED_GROUPS`) e resta nella lista restituita. Se cade, una pagina con `web` nel JSON risponde 503 a tutti. | `CMS-PAGE-MIDDLEWARE-INV-3` |
| CMS-PAGE-MIDDLEWARE-INV-4 | L'elenco ammesso viene solo da `cms.config.page_middleware_allowlist`, riletto a ogni chiamata; se il valore non è un array non è ammesso nulla tranne `web`. Se cade, il JSON potrebbe estendere da solo la propria allowlist. | `CMS-PAGE-MIDDLEWARE-INV-4` |
| CMS-PAGE-MIDDLEWARE-INV-5 | Una lista in cui ogni nome è ammesso torna identica a quella ricevuta (stesso ordine, stessi parametri); la lista vuota è valida e significa pagina pubblica. Se cade, `throttle:10,1` perderebbe i parametri o l'ordine della catena cambierebbe. | `CMS-PAGE-MIDDLEWARE-INV-5` |
| CMS-PAGE-MIDDLEWARE-INV-6 | Le voci di config che non sono stringhe o sono stringhe vuote vengono ignorate (`allowedNames()`, righe 54-62): non ammettono nulla. Se cade, un `''` in config ammetterebbe il nome vuoto. | — (non dimostrato) |

## Effetti collaterali

- Nell'ordine: legge `config('cms.config.page_middleware_allowlist')`; confronta le voci in ordine di dichiarazione fino alla
  prima non ammessa.
- Nessuna scrittura, nessuna query, nessun log, nessuna chiamata esterna: il log del 503 è del chiamante
  (`PageSlugMiddleware.php:104-112`).

## Errori

- `InvalidArgumentException` — alla prima voce non ammessa; il messaggio contiene la voce e l'elenco ammesso
  (`implode`, oppure `nessuno` se vuoto) — protegge INV-1 e INV-2.
- Il chiamante in produzione cattura qualsiasi `Throwable` e risponde 503 (`PageSlugMiddleware.php:103-114`): la validazione
  non decide lo stato HTTP.

## Non fa

- Non controlla che il middleware esista o sia risolvibile (alias o classe): lo fa `PageSlugMiddleware::assertResolvable()`
  (`PageSlugMiddleware.php:136-141`).
- Non esegue né istanzia nessun middleware e non valida i parametri dopo il `:` (`throttle:abc` passa): limite noto.
- Non aggiunge nomi all'allowlist: i moduli applicativi la estendono dal proprio service provider.
- Non verifica il tipo delle voci: una voce non stringa darebbe `TypeError` in `explode()`; la garanzia di una lista di
  stringhe è di `Page::declaredMiddleware()`.
- Non decide cosa succede alla pagina: 503, 404 o redirect sono del chiamante.

## Garantito a FixCity e default per altri tenant

- Garantito a FixCity (evidenza nei test di FixCity e di Cms): l'allowlist effettiva è `['auth', 'throttle']` più
  `Modules\Fixcity\Http\Middleware\RedirectTicketTrackCodeMiddleware`, aggiunto da
  `FixcityServiceProvider::registerPageMiddleware()` (`Modules/Fixcity/app/Providers/FixcityServiceProvider.php:51-63`) in
  `booted()`. I JSON del tenant dichiarano `auth` (`tickets/create`, `area-personale/*`), `throttle:10,1` e quel FQCN
  (`tickets/track`).
- Limite noto: i due `auth/login.json` dichiarano `guest`, che questa Action rifiuta (INV-1); vedi
  [ADR 0004, Stato attuale](../adr/0004-page-middleware-allowlist.md).
- Default per altri tenant (es. Meetup, non presente in questo checkout): solo `auth` e `throttle`; il Cms non nomina classi
  di dominio. Un tenant che vuole un altro middleware lo aggiunge a `cms.config.page_middleware_allowlist` nella propria
  configurazione o dal proprio service provider; mai dal JSON.

## Limiti noti

- `web` nel JSON è accettato ma inutile (no-op): documentato per non farlo togliere per errore dai JSON esistenti; prima del
  fix D17 (2026-10-13) dava 500 (`Target class [web] does not exist`).
>>>>>>> .merge_file_sNZzgk
