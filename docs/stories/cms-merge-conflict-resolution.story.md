---
title: "cms merge conflict resolution.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-11-26
qmd: "cms merge conflict resolution.story"
issues: []
discussions: []
---

# Story: Cms PHP merge conflict resolution

Status: done (PHP markers)
Module: Modules/Cms
Owner: AI Agent (BMAD sprint)

## Scopo

Risolvere i marker di conflitto Git nei PHP di `Modules/Cms` (Actions, View/Components, tests)
con merge semantico: head/meta schema, Folio, allowlist middleware. Non toccare
`FolioVoltServiceProvider` (FR-15 / `RedirectUnlocalizedPath` già ok).

## Decisioni di merge

| Area | Scelta | Perché |
|------|--------|--------|
| Event schema (`BuildPageSchemaAction`) | `@id` riferimento `#event` (+ contratto `@type`/`url` se presente) | Event incompleto con solo URL fallisce Google |
| Head schema | param `business` + Organization tipizzata | LocalBusiness/ProfessionalService dal tenant |
| `Head` component | `panelAssets` + `stylesheet` + `businessData()` | FO pubblico può spegnere CSS/JS Filament |
| Allowlist middleware | `['auth', 'throttle']`, `guest` rifiutato | ADR `page-middleware-allowlist.md` |
| Test | group Pest + assert allineati al lato sopra | invarianti CMS-*-INV-* |

## Verifica

- `rg -l '<<<<<<<' laravel/Modules/Cms --glob '*.php'` → 0
- `php -l` sui file ex-conflitto → 0 errori
- FolioVolt + RedirectUnlocalizedPath intatti (FR-15)

## Fuori scope / non fatto

- commit
- phpstan.neon
- PHPStan full analyse
