---
title: "Contratto — ResolvePageMetaAction"
type: contract
action: "Modules\\Cms\\Actions\\ResolvePageMetaAction"
tags: [contract, action, metadata, seo]
module: Cms
status: accepted
created: 2026-11-23
updated: 2026-11-26
---

# ResolvePageMetaAction

Contratto per titolo e descrizione della pagina in corso di rendering (regola:
`Modules/Xot/docs/rules/action-behavioral-contract.md`). Sorgente: `app/Actions/ResolvePageMetaAction.php`; spiegazione
estesa in [page-title-and-description.md](../page-title-and-description.md). Chiamante: `<x-page>`
(`app/View/Components/Page.php:66-69`, solo con `side="content"`). Lettori dei valori registrati:
`app/View/Components/Head.php:169,256` e `Metatags.php:58-59`.

## Input

- `string $slug`: slug CMS della pagina (può essere vuoto).
- `iterable<BlockData> $blocks`: i blocchi della pagina, in ordine.
- `array<string, mixed> $data`: data bag opaco; conta solo la chiave `item` se è un `Model` Eloquent.

## Output

`execute()` restituisce `array{title: ?string, description: ?string}`. `remember()` non restituisce nulla e registra gli stessi
valori negli attributi della richiesta corrente, `cms.meta.title` e `cms.meta.description` (costanti `TITLE` e
`DESCRIPTION`).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| CMS-PAGE-META-INV-1 | Titolo: `title` del modello, poi `name`; se manca e `$slug` non è vuoto, il `title` della pagina CMS con quello slug; altrimenti `null`. Se cade, la pagina di un record mostra il titolo generico del contenitore. | — (non dimostrato) |
| CMS-PAGE-META-INV-2 | Descrizione: `description` del modello, poi `content`; se mancano, `description` e poi `subtitle` del primo blocco (in ordine) che ne ha uno; altrimenti `null`. | — (non dimostrato) |
| CMS-PAGE-META-INV-3 | Una descrizione derivata da un modello è lunga al massimo 160 caratteri (157 più `...`). Se cade, le meta description eccedono il limite dei motori di ricerca. | — (non dimostrato) |
| CMS-PAGE-META-INV-4 | Ogni valore è ripulito (`strip_tags`, spazi compressi): un valore non stringa o vuoto vale «assente» e non lancia mai eccezioni. Se cade, un campo `null` o un array nel JSON rompe il rendering dell'head. | — (non dimostrato) |
| CMS-PAGE-META-INV-5 | `remember()` non sovrascrive: se `cms.meta.title` è già tra gli attributi della richiesta (anche valorizzato a `null`), non scrive né titolo né descrizione. Se cade, un rendering annidato cambia il titolo già fissato dalla pagina esterna. | — (non dimostrato) |
| CMS-PAGE-META-INV-6 | `execute()` è una lettura: non scrive dati persistenti né attributi della richiesta. | — (non dimostrato) |

## Effetti collaterali

- `execute()`, nell'ordine: legge gli attributi del modello in `$data['item']` (nessuna query); se il titolo è ancora `null` e lo
  slug non è vuoto, una `SELECT` su `pages` (`where slug = $slug`, prima riga); legge i blocchi solo se manca la descrizione.
- `remember()`: controlla `request()->attributes`; se la chiave titolo manca, chiama `execute()` e imposta titolo e
  descrizione. È l'unico punto che muta stato, e vive per una sola richiesta (niente singleton: un titolo non resta
  appiccicato alla richiesta successiva con worker di lunga durata).
- Nessuna scrittura su database, file, cache o code.

## Errori

- Nessuna eccezione propria: dati non stringa o vuoti diventano `null` (INV-4); assenza di pagina, modello o blocco dà valori
  `null`.
- Un errore di database sulla `SELECT` di `pages` risale al chiamante.

## Non fa

- Non determina la visibilità del modello: riceve `item` già autorizzato da [ResolvePageAction](page-resolution-action.md).
- Non esegue query di dominio oltre alla pagina CMS indicata dallo slug.
- Non genera il markup dell'head e non compone il titolo con il brand: lo fa `Head`/`ComposeDocumentTitleAction`.
- Non decodifica entità HTML né traduce: usa il testo così com'è nel modello o nel blocco.

## Garantito a FixCity e default per altri tenant

Nessun comportamento specifico di FixCity: l'Action è identica per ogni tenant che installa Cms. Cosa cambia fra tenant è
solo il contenuto (JSON delle pagine, modelli mappati in [ResolvePageAction](page-resolution-action.md)); separatore del
titolo e noindex sono dei tenant nei file `head.php` e vivono in `Head/*`, non qui.

## Limiti noti

- Nessun test copre l'Action: ogni invariante è promessa, non dimostrata (`rg -l "ResolvePageMetaAction|cms\.meta" Modules/*/tests`
  non trova nulla).
- La descrizione ricavata da un blocco non è troncata a 160 caratteri (`ResolvePageMetaAction.php:60-66`): solo quella del
  modello lo è (riga 50).
- `strip_tags` toglie i tag ma lascia il testo dentro `<script>` e `<style>`, e non decodifica le entità (`&amp;` resta).
- Il titolo di ripiego usa `where('slug')->first()`: con slug duplicati prende una riga qualsiasi, a differenza di
  `PageSlugMiddleware`, che con slug duplicati risponde 503 (`Page::findUniqueBySlug`).
- `remember()` controlla solo la chiave del titolo: il primo scrittore fissa insieme titolo e descrizione, anche se la
  descrizione era `null` e un rendering successivo ne avrebbe una.
