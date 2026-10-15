---
title: "testing rules"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-15
qmd: "testing rules"
issues: []
discussions: []
module: theme
topic: testing-rules
canonical: ../../../Themes/docs/shared-components/testing-rules-Modules.md
status: stub
---

See canonical documentation: ../../../Themes/docs/shared-components/testing-rules-Modules.md

--- BMAD + Second Brain ---
- Scopo: documentazione tecnica del modulo.
- Utilità: riferimento sviluppatori/audit.
- Funzionalità: struttura, dipendenze, convenzioni (no date .md, git avanti).

## Cartella `tests/` (minuscolo obbligatorio)

- Nei moduli Laravel la directory dei test e' **`tests/`** (tutto minuscolo).
- **`Tests/` e' vietato**: su filesystem case-insensitive collide con `tests/`, rompe autoload PSR-4 e confonde Pest/PHPUnit.
- Path canonici: `laravel/Modules/<Modulo>/tests/`, `laravel/Themes/<Tema>/tests/`, `laravel/tests/`.

## PHPStan standing order

- Obiettivo: **zero errori** PHPStan sul codice del modulo.
- Non modificare `phpstan.neon` del progetto per "far passare" i fail.
- Qualita' + documentazione del modulo + BMAD vanno avanti insieme al fix, non dopo.
