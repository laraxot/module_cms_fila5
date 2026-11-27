---
title: "Audit qualità modulo Cms"
type: story
status: review
module: Cms
issue: https://github.com/laraxot/base_techplanner_fila5/issues/64
created: 2026-11-19
updated: 2026-11-19
tags: [audit, qualita, phpstan, pest, docs]
---

# Audit qualità — modulo Cms

## Baseline

- PHPStan `Modules/Cms`: 0 errori (prima e dopo).
- Pest `Modules/Cms/tests`: 146 falliti / 573 passati (invariato); `tests/Unit/Actions/Head`: 82/82 verdi.
- Il comportamento SEO della Head (JSON-LD business da `metatag.business`, `@stack('styles')` in
  `cms::components.head`) non è stato toccato.

## Trovato

- Docs: 13 file con data/timestamp nel nome, 11 con trattino finale, 34 duplicati byte-identici,
  `INDEX.md` vuoto accanto a `index.md`, file `test*.md` vuoti.
- `app/`: nessun doppione di classi; i `mixed` rimasti (125) sono confini con JSON grezzo, cast Eloquent e
  callback di framework.
- `Actions/SanitizeHtmlAction` non ha chiamanti: i blocchi di testo HTML dei temi non passano dal purificatore.

## Fatto

- Docs: date tolte dai nomi (data nel frontmatter `created:`), file con trattino finale rinominati o fusi,
  duplicati rimossi, `INDEX.md` e `test.md` vuoti rimossi, link interni e verso doc Xot rinominate corretti.
  Indice unico: [index.md](../index.md); `00-index.md`/`00-INDEX.md` marcati come storici.
- Nessuna modifica al codice in `app/`.

## Resta

- 146 test falliti, cause fuori dal modulo o d'ambiente: redirect 302 di localizzazione (24+24),
  attese su 404 (25), viste Livewire `auth.*` dei temi con più radici, tabella `articles` assente in sqlite,
  JSON non valido in `config/net/sottana1/database/content/pages/contatti.json`.
- Decidere se collegare `SanitizeHtmlAction` alle viste che stampano HTML con `{!! !!}` (temi) o eliminarla.
- ~1000 file in `docs/`: restano molte varianti quasi uguali (`-1`, `-2`, `_`): serve un consolidamento a mano.
