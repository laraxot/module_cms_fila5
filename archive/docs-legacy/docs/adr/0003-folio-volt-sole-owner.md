---
title: "ADR — FolioVoltServiceProvider del modulo Cms e' l'unico punto che monta Folio e Volt"
type: decision
module: Cms
tags: [adr, cms, folio, volt, routing, provider]
created: 2026-11-24
updated: 2026-11-26
status: accepted
decision-makers: [team Laraxot]
related:
  - ../../app/Providers/FolioVoltServiceProvider.php
  - ../bmad/folio-volt-sole-owner.md
---

# ADR: `FolioVoltServiceProvider` del modulo Cms e' l'unico punto che monta Folio e Volt

## Contesto

- Le pagine del front office arrivano da più sorgenti: `resources/views/pages` del tema attivo (`pub_theme`, per ogni
  locale), `resources/views/pages` di ogni modulo abilitato, `pages/api` con prefisso `/api`.
- L'installer di Laravel Folio genera `app/Providers/FolioServiceProvider.php`; documenti vecchi lo citavano come owner.
  Due provider che montano Folio = rotte duplicate o in ordine diverso a seconda dell'ordine di boot (vedi
  [folio-volt-sole-owner](../bmad/folio-volt-sole-owner.md)).

Domanda: chi registra i percorsi Folio e Volt?

## Driver della decisione

- Un solo posto per ordine di registrazione, locali e middleware: Folio registra una rotta catch-all `fallback` e Laravel, tra
  più fallback, sceglie la prima registrata; il provider rimanda la registrazione a `booted()` perché la fallback di Folio
  finisca in coda (commento a `FolioVoltServiceProvider.php:42-50`, caso della home di un pannello Filament multi-tenant).
- Le pagine sono montate una volta per lingua con `SetFolioLocale` e il gruppo `web`: un secondo montaggio senza questi
  middleware serve le stesse pagine in modo diverso. È già successo: il vecchio `App\Providers\FolioServiceProvider`
  rimontava le pagine del tema senza il gruppo `web` ed è stato rimosso dal commit `1205c31d49` (2026-11-11).
- Il Cms deve restare l'unico modulo che sa come si monta il front office (le pagine dei moduli sono solo cartelle).

## Alternative scartate

- Provider Folio dell'applicazione (default dell'installer): un secondo cervello di routing fuori dai moduli, ignaro di tema
  e locali.
- Un `Folio::path` in ogni modulo: stessa logica di locale e middleware ripetuta N volte.

## Decisione

- Solo `Modules\Cms\Providers\FolioVoltServiceProvider` (`app/Providers/FolioVoltServiceProvider.php`), registrato dal
  modulo Cms: in `booted()` (`registerFolioPaths()`, righe 96-220) monta le pagine del tema per ogni locale, le pagine dei
  moduli abilitati per ogni locale e `pages/api` dei moduli con prefisso `/api` e solo `web`; fa `Volt::mount` sui percorsi
  delle pagine (tema, `livewire/` e `components/blocks` del tema, moduli). Aggiunge anche il middleware globale
  `RedirectUnlocalizedPath` (riga 57).
- Non esiste `App\Providers\FolioServiceProvider`; i provider dei moduli non chiamano `Folio::path`.

## Conseguenze

- Pro: un solo posto per ordine, locali e middleware delle pagine.
- Contro: Folio dipende dal modulo Cms; senza Cms non ci sono pagine.
- Chi aggiunge pagine a un modulo le mette in `resources/views/pages` del modulo, senza toccare provider.
- Il file dell'installer può ricomparire (è già successo, vedi Stato attuale): la decisione regge solo finché il test di
  Conferma resta in `Modules/Cms/tests`.

## Stato attuale

Il codice di oggi contraddice la decisione in due punti. Misurato il 2026-11-26, senza eseguire Pest:

1. `laravel/app/Providers/FolioServiceProvider.php` esiste (29 righe: `Folio::path(resource_path('views/pages'))->middleware(...)`
   alle righe 23-27, middleware vuoto). È tracciato dal commit `2f184dec3d` (2026-11-19, autore `marco76tv`, messaggio «.»,
   cioè un commit di sync) e identico al file nel working tree. Il file era già stato tolto da `1205c31d49` (2026-11-11) e
   la sua storia ha altre aggiunte (`14c648dc5d` 2026-01-20, `cd32814db4` 2026-05-13): ricompare. Oggi è dormiente, non viene avviato: `bootstrap/providers.php` elenca solo
   `AppServiceProvider`, e `config/app.php:217` nomina `Laravel\Folio\FolioServiceProvider` del vendor (import alla riga 27),
   non la classe dell'applicazione. `resources/views/pages` di `laravel/` contiene solo `.gitkeep`. Conseguenza: il test
   `Modules/Cms/tests/Unit/Providers/FolioVoltSoleOwnerTest.php` fallisce alla riga 26 (`assertFileDoesNotExist`), mentre
   `Modules/Xot/tests/Unit/Bootstrap/FolioProviderNotRegisteredTest.php` passa (controlla solo `bootstrap/providers.php`).
   Un altro test, `Modules/User/tests/Unit/NoCmsPhantomFolioImportsTest.php:5,12`, importa la classe e la chiama «stub no-op»:
   i due test oggi si contraddicono. Decisione che spetta al lead: rimuovere il file (ripristina ADR e test, nessun effetto a
   runtime perché non è registrato) oppure ammettere lo stub nell'ADR e correggere il test del Cms.
2. `Modules/Fixcity/app/Providers/FixcityServiceProvider.php:120` chiama `Folio::path($apiPages)->uri('/api')` da
   `registerFolioApiRoutes()` (chiamata alla riga 89), quindi `rg -n "Folio::path" Modules/*/app/Providers` trova oltre al
   Cms anche Fixcity. Il ramo oggi è morto: `$apiPages = dirname($this->module_dir, 3).'/resources/views/pages/api'` (riga
   114) con `module_dir = Modules/Fixcity/app/Providers` dà `laravel/Modules/resources/views/pages/api`, che non esiste, e il
   metodo esce alla riga 117. Le pagine `Modules/Fixcity/resources/views/pages/api` sono montate lo stesso, da
   `FolioVoltServiceProvider.php:193-199`. Da decidere: togliere `registerFolioApiRoutes()` dal Fixcity.

Inoltre il test e il riferimento `related` citavano `../bmad/0003-folio-volt-sole-owner.md`, che non esiste: il documento
vero è [docs/bmad/folio-volt-sole-owner.md](../bmad/folio-volt-sole-owner.md) (qui corretto; il docblock del test, riga 9,
resta da correggere).

## Conferma

- `cd laravel && vendor/bin/pest Modules/Cms/tests/Unit/Providers/FolioVoltSoleOwnerTest.php`: `app/Providers/FolioServiceProvider.php`
  non esiste e `FolioVoltServiceProvider` c'è. Oggi fallisce per il punto 1 di Stato attuale.
- `cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/Bootstrap/FolioProviderNotRegisteredTest.php`: `bootstrap/providers.php`
  non registra il provider dell'applicazione.
- Solo revisione: `rg -n "Folio::path" laravel/Modules/*/app/Providers` deve trovare solo `FolioVoltServiceProvider.php`
  (oggi trova anche `FixcityServiceProvider.php:120`, punto 2). Nessun test automatico lo verifica: proposta, un test Arch
  in `Modules/Xot/tests/Arch/`.
