---
title: "ADR — CMS e middleware possiedono la risoluzione delle pagine Folio"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-26
decision-makers: [team Laraxot]
module: Cms
---

# CMS e Folio risolvono le pagine tramite slug

## Contesto

Il front office usa pagine Folio sottili e blocchi configurati nei contenuti CMS (JSON di pagina).
Le rotte con un identificativo applicativo (`/tickets/{id}`, `/events/{slug}`, `/profile/{uuid}`) non sono però slug CMS
distinti: usano una pagina contenitore (`<container0>.view`) e delegano la visibilità del record al modulo owner. Il Cms è un
modulo condiviso: può essere installato senza conoscere quei moduli applicativi (Fixcity, Ticket, Blog, Meetup).

Domanda: chi decide che cosa mostra un URL pubblico e dove vive questa logica: il tema, la pagina Folio, il Cms o il modulo
applicativo?

## Driver della decisione

- Evitare duplicazioni tra CMS, Folio e temi: la stessa struttura deve valere per Sixteen e Design Comuni.
- Il Cms deve restare riutilizzabile senza Fixcity/Ticket: i domini applicativi si agganciano dal proprio service provider.
- Non divulgazione: una rotta legacy (`profile`, `user`, `users`) non può diventare un fallback pubblico né rivelare se un
  record esiste.
- La shell Folio del tema deve restare priva di logica di dominio (test statici sulle pagine, vedi Conferma).

## Alternative scartate

- Duplicare ogni pagina CMS in una view del tema.
- Spostare il routing applicativo nei componenti visuali.
- Usare `render()` nelle pagine Folio per fare redirect o fallback CMS.
- Considerare ogni segmento numerico una pagina CMS autonoma: così si perde il contenitore del dominio e si duplica la
  politica di visibilità del modulo owner.

## Decisione

CMS possiede risoluzione dello slug, contenuto e middleware pagina; il tema fornisce shell e viste dei blocchi senza creare
alias semantici.

- `Modules\Cms\Http\Middleware\PageSlugMiddleware` governa la protezione dichiarata dal JSON: contratto in
  [page-slug-middleware.md](../contracts/page-slug-middleware.md). Le route legacy `profile`, `user` e `users` non possono
  diventare un fallback pubblico: il middleware applica `ResolvePageAction` e risponde 404 quando non esiste un contenuto
  autorizzato (`rejectLegacyProfileRoutes()`, `PageSlugMiddleware.php:43-64`).
- Il tema passa solo i segmenti ricevuti da Folio e il data bag a `<x-page>`; non risolve `Page`, non calcola metadata, non
  sceglie layout e non introduce rami per login, ticket, blog o eventi.
- `Modules\Cms\View\Components\Page` risolve il contenitore CMS per le rotte dinamiche (`resolveDynamicContext()`) e mantiene
  gli identificativi applicativi nel data bag. Non trasforma gli identificativi in slug e non decide la visibilità dei
  record: la decide l'Action o la policy del modulo owner (vedi [0002](0002-container0-model-allowlist.md)). I metadati
  dinamici vanno negli attributi della richiesta prima del rendering dell'head; `Head` li considera prima dei fallback del
  CMS e del tenant ([page-meta-resolution-action.md](../contracts/page-meta-resolution-action.md)).
- I redirect di dominio non appartengono al Cms: il modulo owner li dichiara nel proprio middleware tramite il JSON della
  pagina. Il Cms resta riutilizzabile senza Fixcity/Ticket e il tema resta una shell generica.
- L'allowlist dei middleware è un punto di estensione: un modulo applicativo può aggiungere la propria classe dal proprio
  service provider (lo fa `FixcityServiceProvider::registerPageMiddleware()`). La validazione resta fail-closed, ma il Cms non
  elenca classi di domini opzionali nella propria configurazione o nel proprio codice
  ([0004](0004-page-middleware-allowlist.md)).

## Conseguenze

- Positive: la stessa struttura è riusabile tra temi; gli slug e la configurazione tenant diventano parte del contratto di
  pagina. Un contenitore CMS fornisce il blocco e i metadati comuni a molti record dinamici, mentre l'Action del modulo owner
  mantiene la privacy del record.
- Negative: la protezione di una pagina vale solo se il file Folio attacca `middleware(PageSlugMiddleware::class)`; una
  pagina che non lo fa ignora il campo `middleware` del suo JSON. Il data bag di `<x-page>` diventa un contratto implicito tra
  temi e Cms.
- Quando si alleggerisce una shell, i test feature devono verificare che le funzionalità precedenti siano ancora fornite dal
  middleware, dal JSON CMS, dall'Action o dalla route del modulo owner.

## Stato attuale

Il codice di oggi contraddice due frasi della decisione ("il Cms non elenca domini opzionali", "riutilizzabile senza
Fixcity/Ticket"). Misurato il 2026-11-26:

- `Modules/Cms/app/View/Components/Page.php:102` calcola `$isDynamicTicket = $container0 === 'tickets' && ctype_digit($slug0)`
  e, alle righe 115-123, costruisce un blocco `ticket_detail` con la view `pub_theme::components.pages.ticket-detail` e
  `header_active => 'all-services'`; alle righe 127-129 esce prima dei due `abort(404)` (righe 132 e 136). È un ramo di
  dominio Fixcity dentro il Cms. Da decidere (lead): spostarlo in un hook registrato da Fixcity oppure aggiornare questa
  decisione ammettendo l'eccezione.
- `Modules/Cms/app/Actions/Head/ResolveRobotsPolicyAction.php:38` elenca slug di pagine Fixcity
  (`HIDDEN_SLUGS = ['tickets.confirmation', 'segnalazione-dettaglio', 'segnalazioni.index']`): stessa natura, stesso esito da
  decidere.
- Il resto della decisione è rispettato: `PageSlugMiddleware.php` non nomina Ticket né Fixcity, e Fixcity estende
  l'allowlist da `FixcityServiceProvider.php:51-63`.

## Conferma

- Unit: `cd laravel && vendor/bin/pest Modules/Cms/tests/Unit/Http/Middleware/PageSlugMiddlewareFailClosedTest.php`: il
  middleware risponde 503 se la protezione non è determinabile, applica `auth` e `throttle`, lascia passare se nessuna pagina
  CMS corrisponde (invarianti `CMS-PAGE-SLUG-INV-1` ... `-INV-3`, `-INV-5`, `-INV-7`, `-INV-8`, `-INV-9` del
  [contratto](../contracts/page-slug-middleware.md); `-INV-6` e `-INV-10` non sono dimostrate).
- `Modules/Cms/tests/Unit/Actions/ResolvePageActionTest.php`: ordine di risoluzione dello slug (`CMS-RESOLVE-PAGE-INV-6`).
- `Modules/Cms/tests/Unit/Views/PageComponentDataMergeTest.php`: `<x-page>` unisce il contesto di rotta nel data bag dei
  blocchi senza trasformare gli identificativi in slug.
- `Modules/Cms/tests/Feature/ResolvePageModelExposureTest.php`: `profile`, `user` e `users` non diventano un fallback pubblico
  (`CMS-PAGE-SLUG-INV-4`, `CMS-RESOLVE-PAGE-INV-1`).
- `Modules/Cms/tests/Feature/IndividualFolioRoutesTest.php`: le pagine Folio rispondono sulle rotte attese.
- Shell del tema senza logica di dominio: `cd laravel && vendor/bin/pest Themes/Sixteen/tests/Unit/FolioPageMountContractTest.php`
  (group `SIXTEEN-FOLIO-INV-4`) vieta rami `blog`/`events`, `@include('pub_theme::components.pages.` e `Auth::check` in
  `[container0]/index.blade.php`. Non esiste oggi un test statico che vieti `render()` o query nelle Blade di tutte le pagine
  Folio: da scrivere.
- Revisione: nessun ramo di dominio nuovo in `Modules/Cms/app` (`rg -n -i "ticket|fixcity" Modules/Cms/app` oggi trova
  `Page.php` e `ResolveRobotsPolicyAction.php`, le due eccezioni note sopra, più commenti).
