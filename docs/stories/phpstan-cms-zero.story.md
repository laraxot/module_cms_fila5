---
title: PHPStan Cms a zero (solo tests)
type: story
module: Cms
phase: quality-gate
status: done
<<<<<<< .merge_file_WcEcGQ
related:
=======
created: 2026-10-20
updated: 2026-10-28
tags: [cms, phpstan, tests, swarm]
related:
  - ./phpstan-cms-zero.dev.md
>>>>>>> .merge_file_yaknTK
  - ./phpstan-test-wave-cms.story.md
  - ./phpstan-cms-swarm-wave.story.md
  - ../00-INDEX.md
  - ../phpstan-fix-plan/plan.md
  - ../../../../../bashscripts/docs/prompts/11-phpstan.md
---

# PHPStan Cms a zero (solo tests)

## Scopo

Portare `Modules/Cms` a **0 errori PHPStan** sui test (inventario `/tmp/phpstan_by_module/Cms.txt`: 145 errori in 7 file), correggendo la causa e non silenziando. I test devono verificare il contratto reale del Cms: pagine JSON per tenant, blocchi tipizzati, risorse Filament su `XotBaseResource`/`LangBaseResource`, rotte Folio.

## Inventario (famiglie)

| Famiglia | File | Causa radice | Fix |
|---|---|---|---|
| `theCodingMachineSafe.function` + `argument.type` su `file_get_contents`/`json_decode` | Homepage*, IndividualFolio*, PestHelpers | I/O nativo puo' restituire `false` | `use function Safe\…` e loader tipizzato su `TestCase` |
| `function.notFound` `cmsHomepageBlocks` | Homepage*, FilamentBuilder*, IndividualFolio* | Helper non collegato / path fantasma `<nome progetto>` | `cmsHomepageBlocks()` delega a `TestCase::homepageBlocksForLocale()`; `Pest.php` fa `require_once PestHelpers.php` |
| `offsetAccess.nonOffsetAccessible` / `foreach.nonIterable` su JSON `mixed` | stessi + PestHelpers | Decode senza shape | `homepageJsonForBlocksArchitecture()` restituisce array shape (`id`, `slug`, `title`, `content_blocks`) |
| `method.deprecated` `DataCollection::filter/each` | Homepage*, FilamentBuilder* | Spatie Data v5 | `collect($dataCollection)->…` (Collection Laravel) |
| `pest.expectation.redundant` | Homepage*, FilamentBuilder* | `toBeInstanceOf`/`toBeArray` su tipo gia' noto | rimossi |
| `method.staticCall` / `alreadyNarrowedType` su Resource | ResourceExtensionTest | `getFormSchema()` final vuoto su Resource; schema in `Schemas\*Form` | assert su `getFormClass()` e dichiarazione metodi |
| `pest.config.redundantLocalUse` / Folio parse | FolioRoutesTest | `uses(TestCase)` ridondante; `preg_match` su mixed | binding solo in Pest.php; `Safe\preg_*` + guardie |
| `argument.type` `strpos` su `string\|false` | HomepageContentManagementTest | `getContent()` puo' essere false | guardia `is_string` prima di `strpos` |

Nessun `@phpstan-ignore`, baseline, `assert()` o cast solo per silenziare. `phpstan.neon` non toccato.

## Verifica

```bash
cd laravel
./vendor/bin/phpstan clear-result-cache
./vendor/bin/phpstan analyse Modules/Cms --no-progress --memory-limit=2G
# → [OK] No errors (exit 0)
```

Misura sul working tree: inventario 09:55 (145) → dopo consolidamento loader + Resource/Folio (10:12+) → **0**.

Spike fleet ~12:21 (`phpstan.parse`, marker merge in Lang/AI/Cms): **`parse` ≠ errori di tipo** — [Lang phpstan-lang-zero](../../Lang/docs/stories/phpstan-lang-zero.story.md).

## Collegamenti

- Dettaglio lane/swarm: [phpstan-test-wave-cms.story.md](./phpstan-test-wave-cms.story.md)
- Gate TSV: [phpstan-cms-swarm-wave.story.md](./phpstan-cms-swarm-wave.story.md)
- Piano: [../phpstan-fix-plan/plan.md](../phpstan-fix-plan/plan.md)
- Indice modulo: [../00-INDEX.md](../00-INDEX.md)
<<<<<<< .merge_file_WcEcGQ
=======

## Ripasso 2026-10-28 (swarm PHPStan Modules, 168 errori / 38 file)

Dopo il merge da `laraxot/dev` (rebase aperto nel repo del modulo) il modulo era tornato a errori: i conflitti `<<<<<<<` erano stati risolti
tenendo un solo lato. Misura: baseline 168 -> 144 sul working tree all'avvio -> **0** (`phpstan analyse Modules/Cms`, exit 0). Pest NON eseguito (DB sacri).

| Causa radice | Errori | Scopo del codice | Fix |
|---|---|---|---|
| `cmsSkipTest` persa nel merge di `tests/PestHelpers.php` | 43 | saltare un test (DB/app non configurati) | ridichiarata `never`, delega a `TestCase::skipTest()`; tolti i `return;`/`continue;` morti nei chiamanti |
| `XotUserContract` (classe inesistente) | ~25 | utente di test | `UserContract`; `TestCase::pestCreateTestUser()` restituisce `UserContract` (niente `@var`/`assert`) |
| `BuildPageSchemaAction`: `$publicFirstName/LastName/Email` non definite | 12 | JSON-LD `Person` del profilo | lette con `readNullableStringProperty()` e usate una volta sola (bug runtime: variabili indefinite) |
| `app/docs/config.php` tornato alla versione non tipizzata | ~41 | config Jigsaw del sito docs | ripristinata la versione verificata (helper `pageStringCall`/`pageProperty`/`docsEnv`, closure tipizzate) |
| `PageSlugMiddleware`: `Router` senza `use`; `@method getMiddlewareBySlug` stale su `Page` | 3 | alias middleware / middleware dichiarati dal JSON | `use Illuminate\Routing\Router`; tolte le 2 righe `@method` che nascondevano `list<string>` |
| `TestCase` senza `use` (Homepage*, `pest.php`, `MenuBusinessLogicTest`) | 5 | binding Pest/PHPUnit | `Modules\Cms\Tests\TestCase` |
| `XotPanelController`/`BaseController` rimossi di proposito in `ce5d0208` (2026-10-23), test riapparso dal merge | 6 | - | test riscritto: asserisce che `app/Http/Controllers` e' vuoto (regola "no Controller HTTP") |
| `Modules\Blog\Models\Article` (modulo opzionale assente) | 5 | test del finder blog/events | classe risolta a runtime + `->skip()` se Blog non c'e' |
| `SetFolioLocale::handle(): mixed` | 3 | locale da URL per Folio | `@param \Closure(Request): Response`, ritorno `Response` |
| `Menu`/`BaseTreeModel` generics, `ViewSection` return | 3 | albero menu / infolist | `@implements HasRecursiveRelationshipsContract<Model>` nel docblock di classe; `@return array<string, Component>` |
| `typeCoverage.paramTypeCoverage` (24 parametri) | 24 | closure di test/config | tipi veri (`ComponentFileData`, `Component`, `NavigationItem`, `?UserContract`, `?string`, `int\|string`) |

Dettaglio tecnico e decisioni aperte: [phpstan-cms-zero.dev.md](./phpstan-cms-zero.dev.md).

### GitHub

TODO (`gh` non installato).
>>>>>>> .merge_file_yaknTK
