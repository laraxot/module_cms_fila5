---
title: "Contratto — SaveFooterConfigAction"
type: contract
action: "Modules\\Cms\\Actions\\SaveFooterConfigAction"
created: 2026-11-23
updated: 2026-11-23
---

# SaveFooterConfigAction

## Input
- Un `FooterData` validato.
## Output
- Nessun valore; la configurazione viene salvata nel tenant.
## Invarianti
- Scrive la chiave `footer` nella sezione tenant `appearance`.
## Effetti collaterali
- Delega la persistenza a `SaveTenantConfigAction`.
## Errori
- Gli errori di validazione o persistenza vengono propagati.
## Non fa
- Non renderizza il footer e non modifica contenuti o traduzioni.
