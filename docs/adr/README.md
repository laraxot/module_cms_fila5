---
<<<<<<< .merge_file_CCDQVY
title: "ADR — Cms"
type: index
tags: [adr, decisioni, cms]
created: 2026-11-18
updated: 2026-11-24
---

# ADR del modulo Cms

Il **perche'** del routing delle pagine pubbliche: chi monta Folio, cosa puo' raggiungere un URL `/{container0}/{slug0}`,
quali protezioni puo' chiedere il JSON di una pagina. Sono decisioni di sicurezza (DCP-283) che sembrano rigidita' inutili.

Leggili prima di: aggiungere un provider o un percorso Folio, esporre un modello da URL, aggiungere un middleware a una pagina.

Formato (5 sezioni, frontmatter `type: decision`): [regola canonica](../../../Xot/docs/rules/action-behavioral-contract.md).

## Decisioni

- [FolioVoltServiceProvider e' l'unico owner di Folio e Volt](folio-volt-sole-owner.md) — niente `App\Providers\FolioServiceProvider`, niente `Folio::path` nei moduli.
- [Modelli da URL solo da un elenco esplicito e con la policy view](container0-model-allowlist.md) — `cms.config.container0_models`, nessuna euristica, nessun oracolo di esistenza.
- [Middleware dei JSON di pagina da un'allowlist](page-middleware-allowlist.md) — solo nomi in `cms.config.page_middleware_allowlist`; protezione incerta = 503.
=======
title: "Decisioni architetturali — Cms"
type: documentation
module: Cms
status: active
---

# Decisioni architetturali — Cms

Gli ADR registrano decisioni difficili da invertire sul modulo CMS. L'indice
è [INDEX.md](./INDEX.md); il modello è [0000-template.md](./0000-template.md).

Ogni decisione documenta contesto, driver, alternative scartate, scelta,
conseguenze e conferma verificabile. Le configurazioni specifiche
dell'applicazione ospitante non appartengono a questo modulo.
>>>>>>> .merge_file_w0iuVk
