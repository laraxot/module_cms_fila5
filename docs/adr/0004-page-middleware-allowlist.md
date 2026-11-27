---
title: "ADR — I middleware dichiarati nel JSON di una pagina passano da un'allowlist di configurazione"
type: decision
module: Cms
tags: [adr, cms, sicurezza, middleware, folio, dcp-283]
created: 2026-11-24
updated: 2026-11-26
status: accepted
decision-makers: [team Laraxot]
related:
  - ../../app/Actions/ValidatePageMiddlewareAction.php
  - ../../app/Http/Middleware/PageSlugMiddleware.php
  - ../../config/config.php
  - ../contracts/validate-page-middleware-action.md
---

# ADR: i middleware dichiarati nel JSON di una pagina passano da un'allowlist di configurazione

## Contesto

- Ogni pagina CMS è un JSON (`config/<tenant>/database/content/pages/*.json`) con un campo `middleware`, che
  `PageSlugMiddleware` applica alla richiesta (es. `auth`, `throttle:10,1`).
- Il JSON è un dato modificabile (editor, import, merge): senza un controllo, chi lo scrive farebbe eseguire qualunque
  classe con un metodo `handle` come middleware (DCP-283, punto C-03).
- Misurato all'epoca: i JSON del repository usano solo `auth` e `throttle` (più `web`, già applicato dallo stack Folio).

Domanda: come lasciare ai JSON la scelta della protezione senza dar loro il potere di eseguire codice arbitrario?

## Driver della decisione

- Un dato modificabile non deve poter nominare codice da eseguire (stessa famiglia di DCP-283 C-04, vedi
  [0002](0002-container0-model-allowlist.md)).
- Un errore su una pagina protetta deve chiudere la pagina, mai aprirla: un refuso (`auht`) non rende pubblica una pagina
  pensata per `auth`.
- Nessuna risposta 500 con dettagli per una protezione incerta; il log non deve contenere dati personali.
- Il Cms non conosce i domini applicativi: i moduli aggiungono i propri middleware da configurazione, non da codice del Cms
  ([0001](0001-cms-owns-page-resolution.md)).

## Alternative scartate

- Fidarsi del JSON: esecuzione di classi arbitrarie da un dato.
- Denylist (vietare `guest`, `api`, classi FQCN): ogni middleware nuovo del framework o di un modulo diventerebbe
  ammesso per default.
- Ammettere i nomi registrati nel Kernel (alias): includono `guest` (bloccherebbe i loggati) e alias di moduli pensati per
  altre rotte.
- In caso di errore servire la pagina senza protezione: una pagina pensata per `auth` diventerebbe pubblica.

## Decisione

- `ValidatePageMiddlewareAction` (`execute()`, righe 34-49) confronta il nome prima dei due punti con
  `cms.config.page_middleware_allowlist` (`config/config.php:18`, default `['auth', 'throttle']`); `web` passa sempre
  (`FOLIO_APPLIED_GROUPS`, riga 26) e non fa nulla.
- Un solo nome fuori elenco rifiuta l'intera lista (`InvalidArgumentException`).
- `PageSlugMiddleware::middlewaresOrRefuse()` (`PageSlugMiddleware.php:76-116`) tratta qualsiasi errore nel determinare la
  protezione (ricerca dello slug, lettura del campo, validazione, risolvibilità) come **503** con log di slug, nomi dei
  middleware e tipo di errore: una pagina con protezione incerta non si serve, né aperta né con un 500 che espone dettagli.
- L'allowlist si estende solo da configurazione, mai dal JSON.

## Conseguenze

- Pro: il JSON sceglie tra protezioni note; un errore di battitura (`auht`) chiude la pagina invece di aprirla.
- Contro: un middleware nuovo richiede di aggiornare la config del modulo o del tenant (o il service provider del modulo
  applicativo).
- Chi aggiunge una pagina con un middleware nuovo deve prima estendere l'allowlist; il test sui JSON lo segnala.
- L'allowlist effettiva di FixCity non è quella di default: `FixcityServiceProvider::registerPageMiddleware()`
  (`Modules/Fixcity/app/Providers/FixcityServiceProvider.php:51-63`) aggiunge in `booted()` il FQCN
  `Modules\Fixcity\Http\Middleware\RedirectTicketTrackCodeMiddleware`, usato da `tickets/track.json`. Quindi l'elenco può
  contenere anche classi, ma solo per mano di un provider, mai del JSON.
- La protezione di una pagina vale solo dove il file Folio attacca `middleware(PageSlugMiddleware::class)` (vedi
  [0001](0001-cms-owns-page-resolution.md)).
- `web` nel JSON non dà più 500: prima del fix D17 (2026-10-13) la catena risolveva `web` come classe e falliva con `Target
  class [web] does not exist`; oggi `web` è un no-op in validazione e in catena (`PageSlugMiddleware.php:97,263`). `guest`
  invece resta rifiutato: bloccherebbe i loggati.

## Stato attuale

Il codice di oggi contraddice il «Misurato» del Contesto e la decisione su `guest`. Misurato il 2026-11-26 leggendo i JSON
del repository:

- `laravel/config/local/fixcity/database/content/pages/auth/login.json:10` e
  `laravel/Modules/Fixcity/config/database/content/pages/auth/login.json:10` dichiarano `"middleware": ["guest"]`. `guest`
  non è in allowlist: `ValidatePageMiddlewareAction` lo rifiuta (dataset `guest bloccherebbe i loggati`,
  `ValidatePageMiddlewareActionTest.php:47`) e `PageJsonMiddlewareAllowlistTest.php` (`Assert::fail` alla riga 83) è rosso
  finché resta. Ultima modifica che tocca la voce nel tenant: commit `59054b8b09` (2026-11-23, «.»). Effetto a runtime non
  verificato in questa passata (il server di sviluppo non era raggiungibile): se `PageSlugMiddleware` trova la pagina per lo
  slug (il JSON dichiara `"slug": "login"`, il middleware cerca prima `auth.login`), `/it/auth/login` risponde 503 a tutti.
  Da decidere (lead): togliere `guest` dai due JSON, oppure ammettere `guest` e gestire i loggati (decisione D17 dice di no).
- Limite del test `PageJsonMiddlewareAllowlistTest`: le voci con un backslash (FQCN) sono tolte prima di chiamare
  `ValidatePageMiddlewareAction` (righe 75-79) e controllate solo con `class_exists` (riga 92). Un FQCN nel JSON passa il test
  anche se nessun provider l'ha aggiunto alla allowlist; a runtime, invece, viene rifiutato (503).

## Conferma

- `cd laravel && vendor/bin/pest Modules/Cms/tests/Unit/Actions/ValidatePageMiddlewareActionTest.php` (group
  `CMS-PAGE-MIDDLEWARE-INV-1` ... `-INV-5`): nomi fuori elenco, maiuscole, spazi, prefissi, `guest`, `api`, FQCN rifiutati;
  `web` ammesso; elenco solo da config; la lista valida torna invariata.
- `cd laravel && vendor/bin/pest Modules/Cms/tests/Unit/Http/Middleware/PageSlugMiddlewareFailClosedTest.php` (group
  `CMS-PAGE-SLUG-INV-1`, `-INV-2`, `-INV-3`, `-INV-5`, `-INV-7`, `-INV-8`): 503 se la protezione non è determinabile,
  nessun middleware fuori allowlist viene eseguito, log senza dati personali, `auth` e `throttle` girano davvero.
- `Modules/Cms/tests/Unit/Content/PageJsonMiddlewareAllowlistTest.php`: ogni JSON di pagina del repository dichiara solo
  middleware in allowlist (oggi rosso per i due `guest`, vedi Stato attuale).
- Contratto: [validate-page-middleware-action.md](../contracts/validate-page-middleware-action.md).
