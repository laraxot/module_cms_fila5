---
title: "Contratto — SaveHeadernavConfigAction"
type: contract
action: "Modules\\Cms\\Actions\\SaveHeadernavConfigAction"
created: 2026-11-23
updated: 2026-11-23
---

# SaveHeadernavConfigAction

## Input
- Un `HeadernavData` validato.
## Output
- Nessun valore; la configurazione viene salvata nel tenant.
## Invarianti
- Scrive la chiave `headernav` nella sezione tenant `appearance`.
## Effetti collaterali
- Delega la persistenza a `SaveTenantConfigAction`.
## Errori
- Gli errori di validazione o persistenza vengono propagati.
## Non fa
- Non renderizza la navigazione e non modifica slug o contenuti.
