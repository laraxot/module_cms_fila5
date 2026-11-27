---
title: "Contratto — SaveFooterConfigAction"
type: contract
action: "Modules\\Cms\\Actions\\SaveFooterConfigAction"
tags: [contract, action, tenant, appearance, footer]
module: Cms
status: accepted
created: 2026-11-23
updated: 2026-11-26
---

# SaveFooterConfigAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`). Sorgente:
`app/Actions/SaveFooterConfigAction.php`. Chiamante: la pagina Filament `Modules\Cms\Filament\Clusters\Appearance\Pages\Footer`
(`app/Filament/Clusters/Appearance/Pages/Footer.php`, `updateData()`). Gemella di
[SaveHeadernavConfigAction](save-headernav-config-action.md).

## Input

- Un `FooterData` (`app/Datas/FooterData.php`): `background_color`, `background`, `overlay_color`, `_tpl` (tutti nullable) e
  `view` (default `cms::components.footer`).
- Nessuna validazione propria: la fa il form Filament che costruisce il `Data`.

## Output

- `void`. Il risultato è nel file di configurazione del tenant, chiave `footer` della sezione `appearance`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| CMS-FOOTER-SAVE-INV-1 | `execute()` delega esattamente una volta a `SaveTenantConfigAction::execute('appearance', ['footer' => $data->toArray()])`: nessun'altra chiave, nessun'altra sezione. Se cade, il salvataggio del piede tocca la configurazione sbagliata. | `CMS-FOOTER-SAVE-INV-1` |
| CMS-FOOTER-SAVE-INV-2 | Vengono scritti tutti i campi del `Data`, `null` inclusi: un campo svuotato nel form sovrascrive il vecchio valore con `null` invece di lasciarlo. Se cade, non si riesce più a togliere uno sfondo dal pannello. | — (non dimostrato) |

## Effetti collaterali

- Nell'ordine: `$data->toArray()`; `app(SaveTenantConfigAction::class)->execute('appearance', ...)`, che risolve
  `config/<tenant>/appearance.php`, legge il file esistente (`File::getRequire`), fonde in profondità le chiavi associative,
  ordina tutte le chiavi (`Arr::sortRecursive`) e riscrive il file intero con `SaveArrayAction`. Contratto:
  `Modules/Tenant/docs/contracts/save-tenant-config-action.md`.
- Nessuna transazione, evento, coda o notifica da questa Action (la notifica «Saved successfully» è della pagina Filament).
- La config in memoria e `FooterData::make()` (singleton statico) non vengono aggiornati: il valore nuovo si vede dalla
  richiesta successiva.

## Errori

- Gli errori di persistenza (filesystem, `InvalidArgumentException` del percorso tenant) risalgono al chiamante invariati;
  `Footer::updateData()` cattura solo `Halt` (`Footer.php`, blocco `catch (Halt ...)`): ogni altra eccezione arriva a Livewire.
- Nessun errore di validazione: l'Action non valida.

## Non fa

- Non controlla i permessi: l'accesso è della pagina Filament.
- Non renderizza il footer e non modifica contenuti o traduzioni.
- Non cancella le altre chiavi di `appearance.php` né le chiavi di `footer` che il `Data` non conosce: la fusione le lascia.
- Non fa backup del file e non gestisce scritture concorrenti: l'ultima vince (limite di `SaveTenantConfigAction`).

## Garantito a FixCity e default per altri tenant

- Garantito a FixCity: scrive `laravel/config/local/fixcity/appearance.php`, chiave `footer` (oggi `view` =
  `cms::components.footer`).
- Default per altri tenant: stessa Action sul file `config/<tenant>/appearance.php` del loro tenant; `view` vale
  `cms::components.footer` se non impostato.

## Limiti noti

- Il test di INV-1 (`tests/Unit/Actions/SaveFooterConfigActionTest.php:22-36`) usa un mock di `SaveTenantConfigAction`, come
  quello di headernav, e non scrive sul file reale; fino al 2026-11-26 il test eseguiva il vero `SaveTenantConfigAction` e
  riscriveva `config/local/fixcity/appearance.php` (in test viene deviato solo `database/content/`,
  `GetTenantFilePathAction.php:33`). Il mock prova la chiamata, non il contenuto scritto: INV-2 resta non dimostrata.
- Come per headernav: `FooterData::make()` è un singleton statico, e un `appearance.php` che non restituisce un array viene
  sovrascritto (`SaveTenantConfigAction.php:28-36`).

## Verifica

- `cd laravel && vendor/bin/pest Modules/Cms/tests/Unit/Actions/SaveFooterConfigActionTest.php --group=CMS-FOOTER-SAVE-INV-1`
