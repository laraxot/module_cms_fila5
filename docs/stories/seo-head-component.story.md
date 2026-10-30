---
title: "[STORY] Head SEO centralizzato per il tema Two"
type: story
module: Cms
status: implemented
priority: high
created: 2026-10-30
updated: 2026-10-30
tags: [bmad, ecc, seo, head, schema-org, theme-two, blade, laravel-head]
related:
  - "../seo-head-architecture.md"
  - "../../../../Themes/Two/docs/seo-multilingual-guide.md"
---

# [STORY] Head SEO centralizzato per il tema Two

## Scopo

Centralizzare il document head del front-office del tema Two in un componente Blade
class-based, evitando titoli, meta tag, asset e script duplicati tra i layout.
Il componente deve conservare il comportamento esistente, rendere esplicita la
responsabilità SEO e produrre markup valido, localizzato e verificabile.

## Decisione di ownership

- **Cms** possiede il componente visuale/layout `<x-cms::head>` e la sua integrazione
  con Vite, Livewire, Filament, Alpine e gli stack Blade.
- **Seo** resta la fonte dei dati SEO e delle API per modificarli.
- `laravel/head` è già una dipendenza del modulo Cms e va usato per le capacità
  fluenti/strutturate quando non duplica il contratto dati già presente.
- Schema.org viene emesso dal componente usando dati già risolti dal CMS; non si
  introducono provider o dipendenze parallele solo per serializzare JSON-LD.

## Acceptance criteria

- [x] Un solo `<head>` per ciascun layout pubblico di Two che adotta il componente.
- [x] Charset, viewport, title, description, robots opzionale, theme-color, OG,
      Twitter, canonical/alternate e asset SEO coerenti con la locale corrente.
- [x] JSON-LD `Organization` + `WebSite` sulla homepage; sulle pagine interne
      vengono usati entità pagina + `BreadcrumbList` risolti dal Cms.
- [x] Dark-mode anti-FOUC e `[x-cloak]` restano prima del primo paint.
- [x] Nessuna stringa utente hardcoded nelle Blade.
- [x] PHPStan e test mirati superano i gate del repo.
- [x] Browser check del tema Two a desktop e 360×640/390×844 senza errori console,
      head duplicato o contenuto hero nascosto.

## Piano di verifica

1. Testare il render con title/description/robots e homepage/non-homepage.
2. Verificare presenza/assenza dei tag condizionali e unicità dei meta principali.
3. Usare Playwright/Puppeteer se l'app è avviabile: desktop, mobile, dark mode,
   reduced motion, console e screenshot.
4. Eseguire PHPStan globale e Pest del modulo Cms/Seo.

## Dev Agent Record

- Stato iniziale: layout Two conteneva head duplicati e Cms possedeva già `Metatags`.
- Dipendenza `laravel/head`: presente nel composer del modulo Cms e in `vendor/`.
- Implementato `Modules\\Cms\\View\\Components\\Head`, con Laravel Head come
  renderer unico dei tag SEO e Schema.org.
- Migrati i layout class-based attivi `components/layouts/main` e `base` del tema
  Two; le copie legacy non montate sono state lasciate intatte.
- Evitata una seconda implementazione in `Modules/Seo`: Seo resta owner dei dati,
  mentre Cms è l'unico owner del renderer Blade, eliminando anche un manifest
  `_components.json` non conforme che impediva il bootstrap dei componenti.
- Verificato: `php -l`, PHPStan Cms, PHPStan globale, `view:cache` e Pest del
  test del componente. I test preesistenti del builder profilo richiedono il
  database `techplanner_data_test`, assente nell'ambiente di lavoro; non è stato
  creato o modificato alcun database.
- Verificato il render reale del componente via `artisan tinker`, inclusi title,
  description, canonical, Open Graph, Twitter e viewport prodotti da `@head`.
- Verificati anche robots, cinque alternate hreflang, theme-color e due blocchi
  JSON-LD nel render della homepage simulata.
- Eliminati i valori duplicati di `pub_theme` nelle configurazioni root, tenant
  TechPlanner e localhost: il valore canonico è ora univocamente `Two`. Il server
  già in esecuzione continua però a servire Sixteen finché non viene riavviato;
  Playwright non viene quindi usato per falsificare una verifica visuale di Two.
- Browser check eseguito su `http://127.0.0.1:8011/it` con Playwright a 390×844:
  hero completamente visibile sotto l'header, `meta` principali unici, un solo
  `head` nel DOM e zero errori console. Screenshot salvato in
  `build/two-home-mobile-head-final.png`.
- Playwright ha verificato il runtime attualmente esposto su `http://127.0.0.1:8000/it`
  (tema Sixteen): un solo head, description/canonical/alternate/JSON-LD presenti,
  viewport mobile 390×844 e screenshot salvato nell'output browser. Non viene
  dichiarato come prova del tema Two.
