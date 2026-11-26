---
title: "Contratto PageSlugMiddleware"
type: contract
action: "Modules\\Cms\\Http\\Middleware\\PageSlugMiddleware"
tags: [contract, middleware, folio, sicurezza, dcp-283]
module: Cms
owner: Cms
status: accepted
created: 2026-11-23
updated: 2026-11-26
---

# Contratto `PageSlugMiddleware`

Contratto di comportamento di un middleware (non è un'Action, ma segue lo stesso formato: regola
`Modules/Xot/docs/rules/action-behavioral-contract.md`). Applica la protezione dichiarata dal JSON CMS sulle rotte Folio senza
conoscere domini applicativi. Sorgente: `app/Http/Middleware/PageSlugMiddleware.php`. Perché esiste: [ADR
0001](../adr/0001-cms-owns-page-resolution.md) e [ADR 0004](../adr/0004-page-middleware-allowlist.md). Allowlist:
[ValidatePageMiddlewareAction](validate-page-middleware-action.md). Risoluzione del modello:
[ResolvePageAction](page-resolution-action.md). Lo attacca ogni pagina Folio che vuole la protezione dichiarata dal suo JSON,
con `middleware(PageSlugMiddleware::class)` (per esempio `Themes/Sixteen/resources/views/pages/[container0]/[slug0]/index.blade.php:13`,
`Modules/Fixcity/resources/views/pages/tickets/create.blade.php:16`); elenco completo:
`rg -l "PageSlugMiddleware::class" Themes/*/resources/views/pages Modules/*/resources/views/pages`.

## Input

Una richiesta Folio con i parametri di rotta (`container0`, `slug0`, `container1`, e gli alias `container`/`slug`), il nome
della rotta e il percorso. Lo slug CMS si cerca tra questi candidati, in quest'ordine, e vince il primo che ha una pagina:
percorso senza lingua con i segmenti uniti da punto (`events/my` → `events.my`), nome della rotta, `container0.slug0`,
`container0.container1`, `container.slug`, `container0.slug`, `slug0`, `slug`
(`resolveCmsPageSlug()`, righe 146-211). La pagina fornisce il campo `middleware` del suo JSON.

## Output

La richiesta prosegue verso la pagina Folio dopo l'esecuzione, nell'ordine dichiarato, dei middleware del JSON; oppure
riceve 404 (rotta legacy di profilo non risolvibile) o 503 (protezione non determinabile). I redirect di dominio sono
middleware del modulo owner, non responsabilità del Cms.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| CMS-PAGE-SLUG-INV-1 | Se la lettura o la validazione dei middleware dichiarati fallisce (errore nella ricerca dello slug, slug duplicato, lettura del campo, nome non ammesso o non risolvibile) la richiesta risponde 503 e la pagina non viene servita (`$next` non chiamato; fail-closed DCP-283 C-03). I test coprono lettura che fallisce e slug duplicato; «non risolvibile» è nel codice (`assertResolvable()`, righe 136-141). Se cade, una pagina pensata per `auth` diventa pubblica. | `CMS-PAGE-SLUG-INV-1` |
| CMS-PAGE-SLUG-INV-2 | Un middleware fuori allowlist o un refuso di nome (`auht`) non viene istanziato né eseguito: 503 da `handle()`, `InvalidArgumentException` se la catena è invocata direttamente. Se cade, chi edita un JSON esegue codice arbitrario. | `CMS-PAGE-SLUG-INV-2` |
| CMS-PAGE-SLUG-INV-3 | Il log del 503 porta slug, nomi dei middleware dichiarati, classe dell'eccezione e motivo; mai IP, utente, percorso, URL o query string (il percorso può contenere identificativi). Se cade, il log di errore diventa un archivio di dati personali. | `CMS-PAGE-SLUG-INV-3` |
| CMS-PAGE-SLUG-INV-4 | Su `profile`, `user` e `users` con `container0` e `slug0`, se `ResolvePageAction` non restituisce un `item` autorizzato la risposta è 404, uguale per record reale e inesistente. Se cade, riappare il fallback pubblico e l'oracolo di esistenza (DCP-283 C-04). | `CMS-PAGE-SLUG-INV-4` |
| CMS-PAGE-SLUG-INV-5 | `web` nel JSON è un no-op; senza middleware dichiarati, o se nessuna pagina CMS corrisponde alla richiesta, la richiesta prosegue invariata. Se cade, `web` torna a dare 500 (`Target class [web] does not exist`) o una pagina pubblica viene fermata. | `CMS-PAGE-SLUG-INV-5` |
| CMS-PAGE-SLUG-INV-6 | I moduli applicativi aggiungono i propri middleware all'allowlist dal proprio service provider; il Cms non importa classi di Ticket o Fixcity (`rg "Modules.(Fixcity\|Ticket)" Modules/Cms/app` non trova nulla; restano due riferimenti per nome in `Page.php` e `ResolveRobotsPolicyAction.php`, vedi [ADR 0001](../adr/0001-cms-owns-page-resolution.md), Stato attuale). Se cade, il Cms diventa un grafo di dipendenze applicative. | — (non dimostrato: struttura, controllo con `rg`) |
| CMS-PAGE-SLUG-INV-7 | I middleware in allowlist girano davvero, con i loro parametri: `auth` ferma l'ospite (`AuthenticationException`), `throttle:10,1` risponde con le intestazioni `X-RateLimit-*` del limite 10. Se cade, la protezione dichiarata nel JSON è decorativa. | `CMS-PAGE-SLUG-INV-7` |
| CMS-PAGE-SLUG-INV-8 | Un middleware dichiarato che non restituisce una `Response`, o che non ha `handle`, non lascia proseguire la richiesta (`LogicException`). Se cade, una protezione difettosa lascerebbe passare la pagina. | `CMS-PAGE-SLUG-INV-8` |
| CMS-PAGE-SLUG-INV-9 | Se la pagina Folio (il `$next` finale) non restituisce una `Response`, il middleware risponde 500 con corpo `Internal Server Error` invece di propagare un valore sbagliato. | `CMS-PAGE-SLUG-INV-9` |
| CMS-PAGE-SLUG-INV-10 | Il candidato più specifico vince: il percorso (`profile/edit` → `profile.edit`) precede il nome della rotta (`profile.view`), così il middleware di una sotto-pagina non è nascosto da quello del contenitore. Se cade, `profile/edit` perde il suo `auth`. | — (non dimostrato) |

## Effetti collaterali

Nell'ordine in cui avvengono (`handle()`, righe 31-38):

1. Rotte legacy: se `container0` è `profile`/`user`/`users` e `slug0` non è vuoto, esegue `ResolvePageAction` (letture
   Eloquent e Gate); con `item` null fa `abort(404)`. Avviene fuori dal blocco che produce il 503.
2. Ricerca dello slug CMS: una `SELECT ... sole()` su `pages` per candidato, fino al primo esistente
   (`Page::findUniqueBySlug`); legge `laravellocalization.supportedLocales` per togliere il prefisso lingua.
3. Lettura dei middleware della pagina (`Page::getMiddlewareBySlug`), poi `ValidatePageMiddlewareAction`
   ([contratto](validate-page-middleware-action.md)) e, per ogni nome diverso da `web`, risoluzione dell'alias dal Kernel HTTP
   (`getMiddlewareAliases()`) e verifica che la classe esista o sia legata al container.
4. Qualsiasi `Throwable` dei passi 2-3 → `Log::error` (slug, middleware, classe dell'eccezione, motivo) e `abort(503)`
   (righe 103-114). Il motivo è il messaggio solo per `InvalidArgumentException`/`UnexpectedValueException`; per le altre
   eccezioni è `file:riga`, perché i messaggi del database possono contenere il valore cercato.
5. Catena: per ogni middleware (salta `web`) istanzia la classe dal container e chiama `handle($request, $next, ...parametri)`;
   al termine della catena chiama `$next`.

## Errori

- 404 (`HttpException` da `abort`) — rotta legacy senza `item` autorizzato — protegge INV-4.
- 503 (`HttpException`) — protezione non determinabile, nome non ammesso o non risolvibile — protegge INV-1, INV-2.
- `LogicException` — middleware senza `handle` o che non restituisce una `Response`; avviene dopo il blocco del 503, quindi
  risale al gestore globale delle eccezioni — protegge INV-8.
- Le eccezioni dei middleware dichiarati (`AuthenticationException` di `auth`) risalgono invariate — INV-7.
- Risposta 500 con corpo `Internal Server Error` se `$next` della pagina restituisce qualcosa che non è una `Response`
  (righe 242-248) — INV-9.

## Non fa

- Non renderizza Blade o componenti visuali.
- Non calcola titoli, meta description o layout (vedi [page-meta-resolution-action.md](page-meta-resolution-action.md)).
- Non contiene markup, query di presentazione o branch speciali del tema.
- Non applica la protezione a una pagina Folio che non lo attacca: il campo `middleware` di quel JSON viene ignorato.
- Non esegue redirect di dominio e non importa moduli applicativi: i middleware owner si aggiungono all'allowlist dal service
  provider del modulo.
- Non cambia l'elenco `profile`/`user`/`users` per tenant: è una costante nel codice (riga 56).

## Garantito a FixCity e default per altri tenant

- Garantito a FixCity: le pagine del tenant con `auth` (`tickets/create`, `area-personale/*`) e con `throttle:10,1`
  (`tickets/track`) sono protette da questo middleware; lo verificano i test dei JSON di Fixcity
  (`Modules/Fixcity/tests/Unit/TicketCreatePageMiddlewareGuardTest.php`, `TicketTrackPageJsonGuardTest.php`,
  `PersonalAreaPagesJsonGuardTest.php`) più, per il lato Cms, i group sopra. `tickets/track` esegue anche
  `RedirectTicketTrackCodeMiddleware` (contratto: `Modules/Fixcity/docs/contracts/redirect-ticket-track-code-middleware.md`).
- Limite noto per FixCity: `auth/login.json` dichiara `guest`, non in allowlist (INV-1/INV-2: la pagina darebbe 503 se il suo
  slug fosse trovato); vedi [ADR 0004, Stato attuale](../adr/0004-page-middleware-allowlist.md).
- Default per altri tenant (es. Meetup, non presente in questo checkout): il middleware è identico; l'allowlist è
  `['auth', 'throttle']`; nessun redirect di dominio. Una pagina Folio di un altro modulo ottiene la protezione solo se attacca
  `middleware(PageSlugMiddleware::class)`.

## Limiti noti

- Un nome senza parametri (`auth`) arriva alla catena con `parseMiddleware()` → `['auth', ['']]`, perché `explode(',', '')`
  restituisce `['']`: `handle()` riceve un argomento stringa vuota (righe 218-232, 285-287). Con `auth` equivale al guard di
  default; un middleware con parametri variadici lo vedrebbe.
- `declaredMiddlewares()` e `findPageBySlug()` sono punti d'innesto per i test (`protected`): non sono API per i moduli.
- Esistono due file di test omonimi, `tests/Unit/Middleware/PageSlugMiddlewareTest.php` e
  `tests/Unit/Http/Middleware/PageSlugMiddlewareTest.php`: i group stanno su entrambi, quello da tenere è da decidere.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Cms/tests/Unit/Http/Middleware --group=CMS-PAGE-SLUG-INV-1` (e `-INV-2`, `-INV-3`,
  `-INV-5` ... `-INV-9`): file `PageSlugMiddlewareFailClosedTest.php` e `PageSlugMiddlewareTest.php`.
- `cd laravel && vendor/bin/pest Modules/Cms/tests/Feature/ResolvePageModelExposureTest.php --group=CMS-PAGE-SLUG-INV-4`:
  richiede il DB del modulo User; in sviluppo si lancia con `bash bashscripts/tools/pest-scratch-db.sh` dalla radice del repo.
