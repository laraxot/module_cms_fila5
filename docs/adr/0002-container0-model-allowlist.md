---
title: "ADR — Le rotte /{container0}/{slug0} caricano un modello solo da un elenco esplicito e con la policy view"
type: decision
module: Cms
tags: [adr, cms, sicurezza, folio, routing, policy, dcp-283]
created: 2026-11-24
updated: 2026-11-26
status: accepted
decision-makers: [team Laraxot]
related:
  - ../../app/Actions/ResolvePageAction.php
  - ../../config/config.php
  - ../contracts/page-resolution-action.md
---

# ADR: le rotte `/{container0}/{slug0}` caricano un modello solo da un elenco esplicito e con la policy `view`

## Contesto

- La pagina Folio del tema `[container0]/[slug0]` chiede a `ResolvePageAction` cosa mostrare. In origine l'Action ricavava
  un modello Eloquent dal primo segmento (ramo `profile`, euristica del singolare: `users` -> `User`).
- Misurato (DCP-283, C-04): `/it/profile/<uuid>` e `/it/user/<uuid>` rispondevano 200 per un utente reale, anche a un ospite,
  e 404 per uno inesistente (oracolo di esistenza); lo snapshot Livewire portava classe e chiave del modello.

Domanda: quali modelli può raggiungere un URL pubblico, e a quali condizioni?

## Driver della decisione

- Un URL pubblico non deve poter nominare un modello qualsiasi dell'applicazione (superficie esplicita, default negato).
- Nessun oracolo di esistenza: un record vietato deve essere indistinguibile da uno inesistente.
- Gli scope globali e la policy `view` del modello devono continuare a valere: l'Action non ne reimplementa la logica.
- Il Cms è condiviso con altri progetti: la mappa contenitore -> modello è configurazione del progetto ospite, non codice del
  Cms.

## Alternative scartate

- Euristica sul nome del contenitore: ogni modello dell'applicazione diventa raggiungibile da un URL.
- Denylist dei modelli sensibili (User, ...): un modello nuovo è esposto per default.
- 403 per un record negato: distingue "esiste ma non puoi" da "non esiste", cioè l'oracolo che si voleva chiudere.

## Decisione

In `app/Actions/ResolvePageAction.php` (`loadDynamicModel()`, righe 81-93):

- `blog` ed `events` passano solo dai finder dei contenuti pubblicati del modulo Blog (`findPublishedPostBySlug`,
  `findPublishedEventBySlug`), se il modulo è installato: un post non si legge come evento e viceversa.
- Ogni altro contenitore carica un modello solo se elencato in `cms.config.container0_models` (alias storico
  `xra.container0_model_map`, righe 101-113) e la classe è un `Model`. Default (`config/config.php:29`): mappa vuota, nessun
  modello.
- Il record si legge con `resolveRouteBinding()` (chiave di rotta e scope globali) ed è esposto solo se
  `Gate::allows('view', $item)` per chi guarda, ospite compreso (righe 122-136). Negato, assente o senza policy = `null`, come
  non trovato.

## Conseguenze

- Pro: superficie esplicita; gli scope dei modelli valgono; nessun oracolo di esistenza.
- Contro: un progetto che voleva pagine-modello deve elencarle in config e scrivere la policy `view`.
- Chi aggiunge un contenitore non scrive codice in `ResolvePageAction`: aggiunge la voce di config e la policy.
- In FixCity la mappa non è vuota: `config/local/fixcity/xra.php:17` elenca `tickets => Ticket` e
  `FixcityServiceProvider.php:78-82` lo impone anche se il tenant non lo dichiara; `/tickets/{id}` passa quindi da questa
  allowlist e dalla `TicketPolicy::view` (`Modules/Fixcity/app/Policies/TicketPolicy.php:22`). Un altro tenant parte da vuoto.
- Se `xra.container0_model_map` e `cms.config.container0_models` elencano lo stesso contenitore con classi diverse vince la
  prima chiave valida (`cms.config.container0_models`, riga 103).

## Conferma

- `cd laravel && vendor/bin/pest Modules/Cms/tests/Feature/ResolvePageModelExposureTest.php --group=CMS-RESOLVE-PAGE-INV-1`
  (e `-INV-2` ... `-INV-5`): contenitore non elencato, `profile`/`user`/`users` senza modello, policy che nega o assente,
  scope globale, voce non-modello ignorata, finder Blog. I casi con utenti reali richiedono il DB del modulo User: in sviluppo
  si lancia con `bash bashscripts/tools/pest-scratch-db.sh Modules/Cms/tests/Feature/ResolvePageModelExposureTest.php` dalla
  radice del repo, per non scrivere sul DB di sviluppo.
- Contratto con le invarianti: [page-resolution-action.md](../contracts/page-resolution-action.md).
- Revisione: un nuovo contenitore nel tenant richiede la voce di config e una policy `view` nello stesso commit; nessuna
  voce nuova in `ResolvePageAction`.
