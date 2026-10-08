---
type: decision-log
title: "Decision Log — Cms Homepage Audit"
links: {github_issue: #500, discussion: #501}
---
# Decision Log — Cms Homepage Audit

## Decisions

### 2026-10-08: BaseTreeModel e Menu: trait vendor (lavoro del 06/10 sera) senza annotazioni generiche
- **Choose**: Tenere `BaseTreeModel` e `Menu` all'ultima versione buona (blob `6b4adee6` e `e2a5c3ef`: trait vendor `HasRecursiveRelationships`, pulizia PHPStan della story `2026-10-06-phpstan-cleanup-cms`), togliendo solo `@template`/`@implements HasRecursiveRelationshipsContract<…>`.
- **Over**: Tornare al trait `TypedHasRecursiveRelationships` della versione del 06/10 del monorepo.
- **Because**: Il passaggio al trait vendor (`9d61081b`) è lavoro nuovo e voluto; il merge del 07/10 l'aveva solo spogliato delle annotazioni. `HasRecursiveRelationshipsContract` non è mai stato generico in nessuna versione, nemmeno nei commit irraggiungibili di Xot: le annotazioni davano `generics.notGeneric`. Il contratto in Xot è stato reso compatibile con il trait vendor (vedi decision-log Xot).
- **Aperti, non toccati**: `FolioVoltServiceProvider` referenzia `App\Http\Middleware\BlockLegacyPublicPages`, assente in questo progetto; `tests/Feature/Auth/LoginTest.php:163` `argument.templateType`. Nessuno dei due è una regressione.

### 2026-10-07: Audit della homepage
- **Choose**: Audit e miglioramento homepage del modulo Cms come priorità, basato sui documenti homepage-*.md esistenti e su competitor analysis.
- **Over**: Creazione di nuovi moduli o refactoring di altri moduli (priorità più bassa).
- **Because**: La homepage è il punto di ingresso del portale; un miglioramento della UI/UX ha impatto immediato sugli utenti.

### 2026-10-07: BMAD docs per homepage
- **Choose**: Creare story, investigation e decision-log nel modulo Cms (docs/stories, docs/investigation, docs/decision-log.md).
- **Over**: Creazione in un modulo separato o in root.
- **Because**: Regole del progetto (AGENTS.md): documenti nel modulo, frontmatter YAML con link GitHub/Discussion, ragionati a mano, non generati da script.

## Open Questions
- Quali KPI mostrare sulla homepage? (volume segnalazioni, MTTR, compliance SLA, distribuzione geografica?)
- Quale stack UI? (DaisyUI / Tailwind con DESIGN.md tokens?)
- Come integrare i dati real-time? (Filament widgets? Action che aggrega dati dal DB?)

## Evidence
- Competitor analysis (vedi docs/stories/homepage-audit-story.md)
- Documentazione esistente (docs/homepage-*.md)
- Regole architettura (no controller, action-based)
