---
title: "Decision log — Cms"
type: decision-log
module: Cms
status: active
created: 2026-10-16
updated: 2026-10-18
tags: [bmad, decision-log, cms]
qmd: "decision log cms"
related:
  - ../bmad-planning.md
  - ../bmad-brainstorming.md
  - ./project-context.md
---

# Decision log — Cms

## 2026-10-16 — Kit BMAD owner

- **Decisione:** adottare `docs/bmad-planning.md` + `docs/bmad-brainstorming.md` + `docs/bmad/filament-blueprint.md` come SSoT di planning per questo owner.
- **Perche:** rimuovere stub copiati "Ticket Timeline" non pertinenti; allineare second brain e Filament blueprint allo scopo reale.
- **Track:** `bmad-method`

## 2026-10-18 — PHPStan su test Pest senza excludePaths

- **Decisione:** nei `*BusinessLogicTest.php` usare solo `PHPUnit\Framework\Assert`; niente chain `expect()` che triggerano `Internal error` di `pest-plugin-phpstan`.
- **Perche:** un crash dell'estensione blocca `phpstan analyse Modules/Cms` per intero; escludere i test non è accettabile.
- **Doc:** [testing.md](../testing.md), campagna Notify [phpstan-pest-patterns-modulo-notify.md](../../Notify/docs/wiki/memories/phpstan-pest-patterns-modulo-notify.md).
