# Event Detail mostra "Nessun evento trovato" - data merge gap

## Sintomo

Su `/it/events/{slug}` il link dal listing apre il dettaglio ma la pagina mostra "Nessun evento trovato".

## Root cause

Nel template CMS page i blocchi erano renderizzati cosi:

`@include($block->view, $block->data)`

In questo modo i dati globali della route (`container0`, `slug0`, `data`) non venivano passati ai blocchi.

Per `events/detail.blade.php` significa:
- `slug0` vuoto
- nessun `item/event` disponibile
- nessuna query `Event::where('slug', ... )`
- fallback UI: "Nessun evento trovato"

## Fix DRY + KISS

Centralizzare nel page renderer il merge dati:

- `array_merge($data, $block->data)`

Cosi ogni blocco riceve sempre il contesto route + i propri dati specifici.
