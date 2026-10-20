---
title: PHPStan lane cms, regressione da test riespansi dopo il pull
type: story
module: Cms
phase: implementazione, quality gate
status: in-progress
created: 2026-10-20
updated: 2026-10-20
related:
  - ../../../Xot/docs/stories/phpstan-test-wave-regression.story.md
---

# PHPStan lane cms: test riespansi dopo il pull

Lane `cms` del run del 2026-10-20. Coordinamento e regole: [phpstan-test-wave-regression](../../../Xot/docs/stories/phpstan-test-wave-regression.story.md). Bucket: 69 file (66 test, 3 sorgenti), 742 errori nella baseline delle 09:00.

## Scopo capito

Il merge `c0a06773` del repo `Modules/Cms` (2026-10-20 09:03) ha riportato in `tests/` i corpi del lato `bed01e6d`: specifiche generiche scritte per un Cms con tabelle SQL (`pages.status`, `meta_title`, `page_contents`, `sections`, `Page::factory()`) e per un progetto con homepage `<nome progetto>`. Il Cms reale e' un altro:

- `Models\Page`, `PageContent`, `Section`, `Menu` leggono file JSON per tenant (trait `SushiToJsons` del modulo Tenant). Nessuna tabella `pages`, nessuna colonna `status`/`template`/`published_at`, nessuna relazione `contents()`/`sections()`, nessuna factory necessaria per le righe.
- Nel progetto Quaeris non esiste `config/local/<tenant>/database/content/pages/home.json` e il path dei test conteneva il segnaposto letterale `<nome progetto>`.
- Il `TestCase` di modulo era stato svuotato dal merge (14 righe): sparivano `createPHPUnitMock`, `pestGenerateUniqueEmail`, `pestCreateTestUser`, `$currentTest`, da cui dipende `tests/PestHelpers.php` (autoload-dev), usato da quasi tutti i test.

Il run del 2026-10-08 (commit `9b709db8`, `d93863bd`) aveva gia' allineato questi test al Cms reale. Per i file in cui il corpo del merge e' una specifica fantasma si e' riusata quella forma, che e' la "forma neutralizzata gia' usata dal repo" della regola 3: il corpo del merge resta in git (`git -C Modules/Cms show c0a06773:<path>`).

## Cause corrette

| Causa | Errori | Correzione alla sorgente |
|---|---|---|
| `uses(Modules\Cms\Tests\TestCase::class)` ridondante (gia' in `tests/Pest.php`) | 39 | rimosso dai file; in `FolioRoutes/*` (29 file), `Auth/RegisterTypeTest`, `RegisterTypeWidgetTest`, `passwordconfirmationtest`, `EmailVerificationTest.pest` |
| `@phpstan-ignore` superflui (`ignore.unmatchedLine`) | 25 | rimossi da `Auth/LoginTest`, `Auth/RegisterTest` (nessun nuovo ignore aggiunto) |
| `static::generateUniqueEmail()`, `static::createTestUser()`, `static::getUserClass()` dentro closure Pest (`outOfClass.static`) | 24 | `$this->...` (Pest lega la closure al TestCase) in `LoginWidgetTest`/`loginwidgettest`; `cmsGenerateUniqueEmail()` in `RegisterTypeWidgetTest` |
| `Model::factory()` / `->create()` su `mixed` negli Auth | ~45 | `$this->createTestUser()` / `cmsCreateUnverifiedUser()` al posto di `XotData::getUserClass()::factory()` (`AuthenticationTest`, `PasswordResetTest`, `EmailVerificationTest.pest`) |
| `Page`/`PageContent`/`Section` trattati come modelli SQL | ~290 | test riallineati al modello JSON (`PageTest`, `BaseModelTest`, `PageManagementBusinessLogicTest`, `CmsContentManagementTest`) |
| `assertViewIs('...')` con `string` al posto di `view-string` | 8 | `GetViewByClassAction::execute(RegistrationWidget::class)` |
| `LoginWidget::getView()` inesistente | 1 | la vista del widget si risolve con `GetViewByClassAction` (stessa convenzione di `XotBaseWidget`) |
| `Variable $user is never read` (utente creato solo per l'effetto) | 15 | assegnazione tolta |
| Placeholder `expect(true)->toBeTrue()` | 4 | `->skip('...')` con rimando ai file che hanno i test veri (`LoginVoltTest`, `PasswordConfirmationTest`) |

### Sorgenti di produzione

- `Actions/ResolvePageAction`: il merge aveva introdotto `use Modules\Blog\...` per `blog` e `events`, ma il modulo Blog non esiste in Quaeris (6 errori `class.notFound`). Ora le classi sono risolte per nome e usate solo se `class_exists`; se il Blog manca si ripiega sulla risoluzione per convenzione (`Modules\<Container>\Models\<Singolare>`). Comportamento identico dove il Blog c'e'.
- `Datas/BlockData`: `substr($name, 0, strrpos(...))` con `int|false` sostituito da `Str::beforeLast($name, '.')` (stesso risultato, nessun `false`).
- `Models/Page::findUniqueBySlug`: rilanciava `MultipleRecordsFoundException` con una stringa al posto del contatore (il costruttore vuole `int $count`: il messaggio sarebbe diventato "<testo> records were found."). Ora lancia `\RuntimeException` con messaggio, conteggio vero (`getCount()`) e `previous`. Nessun chiamante cattura il tipo vecchio (`ThemeComposer`, `Livewire\Page\Show`, `PageSlugMiddleware` usano il risultato).

## Duplicati per maiuscole (da decidere)

`tests/Feature/Auth` e `tests/Unit` contengono coppie di file che differiscono solo per le maiuscole (`LoginTest.php`/`logintest.php`, `AuthenticationTest.php`/`authenticationtest.php`, `RegisterTypeTest.php`/`registertypetest.php`, `RegisterTypeWidgetTest.php`/`registertypewidgettest.php`, `PasswordConfirmationTest.php`/`passwordconfirmationtest.php`, `LoginWidgetTest.php`/`loginwidgettest.php`, `DashboardTest.php`/`dashboardtest.php`, `ExampleTest.php`/`exampletest.php`, ...). Su filesystem insensibili alle maiuscole collidono. Non cancellati: sono stati portati allo stesso contenuto dove erano gemelli. Decisione aperta: tenere solo la variante PascalCase (vedi [case-variant-collisions](../case-variant-collisions.md)).

## Verifica

PHPStan mirato per batch da 8 file (`--memory-limit=2G`), `php -l` sui file toccati. Pest non eseguito: il DB di test `quaeris_data_test` non esiste.

## Residui e decisioni aperte

Da compilare a fine lane.
