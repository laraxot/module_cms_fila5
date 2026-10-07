---
type: decision-log
title: "Decision Log — Cms Homepage Audit"
links: {github_issue: #500, discussion: #501}
---
# Decision Log — Cms Homepage Audit

## Decisions

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
