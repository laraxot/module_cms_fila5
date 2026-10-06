---
qmd: "STORY-CMS-FOLIO-LOCALE-AUTH-REDIRECT"
issues: []
discussions: []
title: "Story Cms Folio Locale Auth Redirect"
---

---
title: "Folio guests keep the requested locale on authentication redirects"
type: story
status: done
module: Cms
created: 2026-09-27
updated: 2026-09-27
tags: [bmad, folio, localization, authentication, fixcity]
qmd: "Folio guest auth redirect preserves requested locale en it login route"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/383"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/392"
related:
  - ../../folio-routing-locale.md
  - ../../locale-prefix-e2e-rule.md
  - ../../../../Fixcity/docs/bmad/gap-analysis.md
---

# Story

Come visitatore, quando apro una pagina Folio protetta in una lingua specifica,
voglio essere mandato alla pagina di accesso nella stessa lingua, così non perdo
il contesto prima di autenticarmi.

## Acceptance criteria

1. Guest su `/it/tickets/create` riceve redirect a `/it/auth/login`.
2. Guest su `/en/tickets/create` riceve redirect a `/en/auth/login`.
3. La locale app e quella di LaravelLocalization corrispondono al prefisso della
   richiesta quando viene generato il redirect.
4. Il comportamento JSON resta non redirect (risposta 401).
5. Nessuna credenziale o configurazione `.env.testing` viene alterata per i test.

## Implementazione

`bootstrap/app.php` configura `redirectGuestsTo` con
`LaravelLocalization::getLocalizedURL()` e la locale già risolta da
`SetFolioLocale`. Il fallback costruisce il path con la stessa locale, mai con la
route nominata `login` che usa la lingua predefinita. Test di regressione nel
modulo owner FixCity: `tests/Feature/Pages/TicketGuestLocaleRedirectTest.php`.

## Verifica

- Pest: redirect IT/EN e conservazione di `url.intended` + 401 JSON, 3 casi / 15
  asserzioni.
- Suite completa FixCity: 372 test / 1.585 asserzioni.
- Chromium end-to-end: `/it|en/tickets/create` da guest termina sul login
  localizzato; copy/footer e link corretti a 320/768/1440 px, nessun overflow o
  errore JavaScript.
