---
title: "Contratto — SaveHeadernavConfigAction"
type: contract
action: "Modules\\Cms\\Actions\\SaveHeadernavConfigAction"
tags: [contract, action, tenant, appearance, headernav]
module: Cms
status: accepted
created: 2026-11-23
updated: 2026-11-26
---

# SaveHeadernavConfigAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`). Salva la testata del sito nella
config `appearance` del tenant. Sorgente: `app/Actions/SaveHeadernavConfigAction.php`; delega a
`Modules\Tenant\Actions\Config\SaveTenantConfigAction`. Chiamante: la pagina Filament
`Modules\Cms\Filament\Clusters\Appearance\Pages\Headernav` (`app/Filament/Clusters/Appearance/Pages/Headernav.php`, riga 95).
Gemella di [SaveFooterConfigAction](save-footer-config-action.md).

## Input

- Un `HeadernavData` (`app/Datas/HeadernavData.php`): `background_color`, `background`, `overlay_color`, `overlay_opacity`,
  `class`, `style` (tutti nullable) e `view` (default `cms::components.headernav`).
- Nessuna validazione propria: la fa il form Filament che costruisce il `Data`.

## Output

- `void`. Il risultato è nel file di configurazione del tenant, chiave `headernav` della sezione `appearance`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| CMS-HEADERNAV-SAVE-INV-1 | `execute()` chiama `SaveTenantConfigAction::execute` una volta con sezione `appearance` e payload esatto `['headernav' => $data->toArray()]`: nessun'altra chiave. Se cade, il tema legge una chiave diversa o perde il merge con footer e altre voci. | `CMS-HEADERNAV-SAVE-INV-1` |
| CMS-HEADERNAV-SAVE-INV-2 | Non scrive file da sola: tutta la persistenza passa da `SaveTenantConfigAction` (modulo Tenant); l'Action non conosce il percorso del file. Se cade, Cms inventa un percorso tenant e salta merge e difesa da traversal del modulo owner. | — (non dimostrato: struttura del codice) |
| CMS-HEADERNAV-SAVE-INV-3 | Vengono scritti tutti i campi del `Data`, `null` inclusi: un campo svuotato nel form sovrascrive il vecchio valore con `null` invece di lasciarlo. Se cade, non si riesce più a togliere uno sfondo o una classe CSS dal pannello. | — (non dimostrato) |

## Effetti collaterali

- Nell'ordine: `$data->toArray()`; `app(SaveTenantConfigAction::class)->execute('appearance', ...)`, che risolve
  `config/<tenant>/appearance.php`, legge il file esistente (`File::getRequire`, esegue il PHP che contiene), fonde in
  profondità le chiavi associative, ordina tutte le chiavi (`Arr::sortRecursive`) e riscrive il file intero con
  `SaveArrayAction`. Contratto: `Modules/Tenant/docs/contracts/save-tenant-config-action.md`.
- Nessuna transazione, evento, coda o notifica da questa Action (la notifica «Saved successfully» è della pagina Filament).
- La config in memoria e `HeadernavData::make()` (singleton statico, `app/Datas/HeadernavData.php`) non vengono aggiornati: il
  valore nuovo si vede dalla richiesta successiva.

## Errori

- Gli errori di persistenza (filesystem, `InvalidArgumentException` del percorso tenant) risalgono al chiamante invariati,
  senza `catch` locale; la pagina `Headernav::updateData()` cattura `\Exception` (`Headernav.php:101`) e mostra il messaggio
  dell'eccezione in una notifica persistente (il messaggio può contenere percorsi del filesystem).
- Nessun errore di validazione: l'Action non valida.

## Non fa

- Non controlla i permessi: l'accesso è della pagina Filament.
- Non renderizza la navigazione e non modifica slug o contenuti delle pagine.
- Non tocca `footer` né le altre chiavi di `appearance.php`, né le chiavi di `headernav` che il `Data` non conosce: la fusione
  le lascia.
- Non fa backup del file e non gestisce scritture concorrenti: l'ultima vince (limite di `SaveTenantConfigAction`).

## Garantito a FixCity e default per altri tenant

- Garantito a FixCity: scrive `laravel/config/local/fixcity/appearance.php`, chiave `headernav` (oggi `view` =
  `fixcity::components.blocks.headernav.agid`, `_tpl` = `simple`). Il test di INV-1 usa un mock di `SaveTenantConfigAction`,
  quindi non scrive sul file reale.
- Default per altri tenant: stessa Action sul file `config/<tenant>/appearance.php` del loro tenant; se `view` non è
  impostato vale `cms::components.headernav` (default del `Data`).

## Limiti noti

- Una `HeadernavData::make()` già costruita nel processo non vede il salvataggio fino alla richiesta successiva (singleton
  statico): in un worker di lunga durata il valore vecchio resta finché il processo non si riavvia.
- Se `appearance.php` esiste ma non restituisce un array, `SaveTenantConfigAction` riparte da `[]` e sovrascrive il file
  (`SaveTenantConfigAction.php:28-36`).

## Verifica

- `cd laravel && vendor/bin/pest Modules/Cms/tests/Unit/Actions/SaveHeadernavConfigActionTest.php --group=CMS-HEADERNAV-SAVE-INV-1`
