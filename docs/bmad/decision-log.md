---
title: "Decision log — Cms"
type: decision-log
module: Cms
status: active
created: 2026-10-16
updated: 2026-10-20
tags: [bmad, decision-log, cms]
qmd: "decision log cms"
related:
  - ../bmad-planning.md
  - ../bmad-brainstorming.md
  - ./project-context.md
---

# Decision log — Cms

## 2026-10-20 — Gate PHPStan Modules zero; Filament blueprint SSoT UI admin

- **Decisione:** gate `analyse Modules` a zero; `PageResource` / JSON tenant e liste FO si allineano a [filament-blueprint.md](./filament-blueprint.md) (XotBase, Lang, niente label hardcoded).
- **Track:** [phpstan-modules-zero-standing-order](../../Xot/docs/wiki/memories/phpstan-modules-zero-standing-order.md).

## 2026-10-16 — Kit BMAD owner

- **Decisione:** adottare `docs/bmad-planning.md` + `docs/bmad-brainstorming.md` + `docs/bmad/filament-blueprint.md` come SSoT di planning per questo owner.
- **Perche:** rimuovere stub copiati "Ticket Timeline" non pertinenti; allineare second brain e Filament blueprint allo scopo reale.
- **Track:** `bmad-method`

## 2026-10-18 — PHPStan su test Pest senza excludePaths

- **Decisione:** nei `*BusinessLogicTest.php` usare solo `PHPUnit\Framework\Assert`; niente chain `expect()` che triggerano `Internal error` di `pest-plugin-phpstan`.
- **Perche:** un crash dell'estensione blocca `phpstan analyse Modules/Cms` per intero; escludere i test non è accettabile.
- **Doc:** [testing.md](../testing.md), campagna Notify [phpstan-pest-patterns-modulo-notify.md](../../Notify/docs/wiki/memories/phpstan-pest-patterns-modulo-notify.md).

## 2026-10-20 — PHPStan swarm e ordine permanente

- **Decisione:** il modulo Cms partecipa al gate unico `analyse Modules` con helper test su `TestCase` static tipizzato (pattern Lang/Cms/User); ogni turn non banale esegue la catena PHPStan → sorgente → docs senza conferma.
- **Perche:** `pest-plugin-phpstan` e test misti PHPUnit/Pest bloccano l'intero albero se non si corregge alla fonte; escludere path non e' accettabile.
- **Track:** [11-phpstan.md](../../../../bashscripts/docs/prompts/11-phpstan.md), [filament-blueprint](./filament-blueprint.md), memoria [phpstan-modules-zero-standing-order](../../Xot/docs/wiki/memories/phpstan-modules-zero-standing-order.md).
