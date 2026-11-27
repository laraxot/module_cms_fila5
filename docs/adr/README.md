---
title: "Decisioni architetturali — Cms"
type: documentation
module: Cms
status: active
---

# Decisioni architetturali — Cms

Gli ADR registrano decisioni difficili da invertire sul modulo CMS. L'indice
è [index.md](./index.md); il modello è [0000-template.md](./0000-template.md).

Ogni decisione documenta contesto, driver, alternative scartate, scelta,
conseguenze e conferma verificabile. Le configurazioni specifiche
dell'applicazione ospitante non appartengono a questo modulo.

## Decisioni

- [0001-cms-owns-page-resolution.md](0001-cms-owns-page-resolution.md) — CMS e middleware possiedono la risoluzione delle pagine Folio.
- [0002-container0-model-allowlist.md](0002-container0-model-allowlist.md) — Le rotte `/{container0}/{slug0}` caricano un modello solo da un elenco esplicito e con la policy `view`.
- [0003-folio-volt-sole-owner.md](0003-folio-volt-sole-owner.md) — `FolioVoltServiceProvider` del modulo Cms è l'unico punto che monta Folio e Volt.
- [0004-page-middleware-allowlist.md](0004-page-middleware-allowlist.md) — I middleware dichiarati nel JSON di una pagina passano da un'allowlist di configurazione.

## Harness minimo: ownership, evidenza e recupero (2026-11-27)

Questo indice appartiene a **module_cms_fila5**: ogni decisione su codice, dominio o tema va nell'ADR del package owner; il root registra soltanto i vincoli di composizione. Un ADR richiede una scelta reale con alternative e conseguenze, più una **Conferma** ripetibile (oppure la dichiarazione esplicita che manca). Non creare ADR fittizi per riempire un indice.

- [Confine LaravelDay/harness Xot](https://github.com/laraxot/module_xot_fila5/blob/dev/docs/adr/0042-laravel-day-harness-adoption-boundary.md); [ownership root](https://github.com/laraxot/base_ptvx_fila5/blob/dev/docs/adr/0001-harness-minimo-e-ownership.md).
- **BMAD**: la story owner-local conserva `scope`, `must_not_change`, `evidence`, `approval_required` nei cambi rischiosi.
- **ECC**: nessun marker di merge; distinguere la prova eseguita dal semplice riferimento a un test; se la conferma non è disponibile segnare `non eseguita`.
- **Second Brain**: QMD/Graphify e `.harness/memory/{facts,lessons}.md` sono puntatori a evidenza datata, non copie degli ADR. [Runbook](https://github.com/laraxot/base_ptvx_fila5/blob/dev/docs/harness/README.md) · [Rollout #15](https://github.com/laraxot/base_ptvx_fila5/issues/15).
