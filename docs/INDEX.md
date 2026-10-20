---
title: "Cms — Indice canonico docs"
status: canonical
module: Cms
updated: 2026-10-20
---

> Indice canonico. Indici storici alternativi: `00-INDEX.md`, `00-index.md`, `index.md`, `INDEX.md` (precedente alias supersede), `DESIGN_COMUNI_INDEX.md`, `design-comuni-index.md`, `design_comuni_index.md`, `rules-index.md`. Nessun file storico cancellato.

> Convenzione: [Docs Organization — Modules & Themes](../../Xot/docs/conventions/docs-organization.md)

# Cms — Indice docs

Modulo Cms (content management, temi, filamenti, frontoffice).

## Panoramica
- [README.md](./README.md)
- [INTRODUCTION.md / introduction.md](./introduction.md) — introduzione
- [HEADLINE.md / homepage.md](./homepage.md) — homepage e contenuti
- [GETTING-STARTED.md / getting-started.md](./getting-started.md)
- [SCOPOM.md / scopo.md](./scopo.md)
- [STRATEGY.md / strategy.md](./strategy.md)

## Architettura
- [filament/](./filament/) — componenti Filament (form, resource, widget, blade)
- [filament-architecture-principles.md](./filament-architecture-principles.md)
- [page-component-architecture.md](./page-component-architecture.md)
- [frontend-architecture/index.md](./frontend-architecture/index.md) — architettura frontend
- [frontoffice/](./frontoffice/) — frontoffice (autenticazione, routing, temi)
- [themes/](./themes/) — temi (struttura, asset, vite, locale)
- [sections/](./sections/) — sezioni header/footer
- [modular-architecture-update-summary.md](./modular-architecture-update-summary.md)

## PHPStan
- [phpstan.md / phpstan-analysis.md / phpstan-compliance.md](./phpstan.md) — suite report PHPStan
- [phpstan-corrections.md / phpstan-fixes.md](./phpstan-fixes.md) — correzioni
- [phpstan-quality-gate.md](./phpstan-quality-gate.md)
- [phpstan-roadmap.md](./phpstan-roadmap.md)

## BMAD / Stories
- [stories/](./stories/) — storie feature (CMS, PHPStan, merge, docs-audit)
- [bmad/](./bmad/) — se presente (es. tramite root-links); riferimenti in `stories/bmad-mod-root-cleanup.story.md`
- [wiki/bmad-method.md](./wiki/bmad-method.md) — metodo BMAD

## Testing
- [testing.md / TESTING.md](./testing.md) — testing
- [tests/](./tests/) — test architettura e registrazione
- [testing-registration-widget.md](./testing-registration-widget.md)
- [testing-homepage-content-management-fix.md](./testing-homepage-content-management-fix.md)

## API / Guide
- [wiki/](./wiki/) — wiki completa (`index.md`, `commands/`, `concepts/`, `rules/`, `skills/`, `troubleshooting/`)
- [design-comuni/](./design-comuni/) / [DESIGN_COMUNI_INDEX.md](./DESIGN_COMUNI_INDEX.md) — design comuni
- [migrations/](./migrations/) — migrazioni tema → componenti
- [development/roadmap/](./development/roadmap/) — roadmap
- [interfaces / modules-integration-reference.md](./modules-integration-reference.md)
- [qmd-setup.md](./QMD-SETUP.md) — setup ricerca

## Struttura
- `stories/` — storie feature (30+ file, es. `phpstan-cms-zero.story.md`, `docs-cms-studio.story.md`)
- `wiki/` — wiki modulare (`concepts/`, `commands/`, `rules/`, `memories/`, `skills/`, `troubleshooting/`)
- `errors/` — errori (404, event-detail, git-conflicts, livewire-property, pub-theme-view)
- `bmad/` — riferimenti BMAD (tramite `stories/` e `wiki/`)
- `filament/` — componenti, forme, risorse, widget blade
- `themes/`, `frontoffice/`, `sections/`, `pages/`, `data/` — sezioni verticali
- `development/`, `roadmap/`, `migrations/`, `standards/` — pianificazione e standard
- `raw/` — importazioni storiche (`root-import/`)
- `tests/`, `testing/`, `outputs/` — test, output

---
*Aggiornato: 2026-10-20 — conforme a `docs-organization.md`; `INDEX.md` (precedente alias a `00-INDEX.md`) sostituito con indice canonico; `00-INDEX.md`, `index.md`, `INDEX.md` storici lasciati in posto.
