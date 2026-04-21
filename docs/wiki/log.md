# Cms Wiki Log

## [2026-04-15] init | wiki bootstrap
- Struttura wiki/log.md inizializzata.
- Layer raw: tutti i file in `docs/` (eccetto `wiki/`).
- Layer wiki: `docs/wiki/` — LLM-maintained, sintesi ad alto riuso.
- Schema: `docs/.schema/WIKI_SCHEMA.md`
- Adozione moduli: `docs/project/llm-wiki-module-adoption.md`

## [2026-04-21] conflict-resolution-batch-1 | cms
- Risolti manualmente marker Git in:
  - `app/Actions/ResolvePageAction.php`
  - `app/View/Components/Page.php`
  - `tests/Feature/FilamentBuilderBlocksTest.php`
- Ripristinata la logica di risoluzione pagina (`container0/slug0`, slug esplicito, fallback da data).
- Verifica eseguita:
  - `php -l` sui file corretti
  - `./vendor/bin/pest Modules/Cms/tests/Feature/FilamentBuilderBlocksTest.php` (pass)

## [2026-04-21] runtime-fix-home-it | cms
- Verificato endpoint `http://127.0.0.1:8000/it` con errore runtime iniziale: `ParseError` in `app/View/Components/Section.php`.
- Corretto componente `Section`:
  - rimozione frammenti corrotti da merge conflict;
  - ripristino assegnazioni proprietà in costruttore;
  - ripristino risoluzione view `pub_theme::components.sections.{slug}.{tpl}`;
  - passaggio parametri view coerenti (`blocks`, `slug`, `class`, `id`).
- Verifica finale:
  - `php -l app/View/Components/Section.php` (pass)
  - `curl http://127.0.0.1:8000/it` -> `HTTP 200`
