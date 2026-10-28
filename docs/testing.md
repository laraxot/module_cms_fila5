---
title: "testing"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< .merge_file_hjbnQI
updated: 2026-10-18
=======
updated: 2026-10-28
>>>>>>> .merge_file_bDhHlj
qmd: "testing"
issues: []
discussions: []
status: draft
---

# Cms Module Testing Guide

## Overview

This module follows the project's [testing guidelines](../../docs/TESTING.md) and uses Pest PHP as the testing framework.

## Test Structure

```
tests/
  Feature/    # Feature tests
  Unit/       # Unit tests
  Pest.php    # Module-specific Pest configuration
  TestCase.php # Base test case for the module
```

## PestHelpers (PHPStan + merge)

- Funzioni in `tests/PestHelpers.php` sono **globali** (`cmsActingAsGet`, `cmsGet`, …).
  Non usare `use function Modules\Cms\Tests\...`: quel namespace non esiste sul file.
- Ogni helper e' dietro `function_exists(...)`: evita `Cannot redeclare` se un merge
  o un doppio autoload ripete la definizione.
- Homepage blocchi: fonte di verità `TestCase::homepageJsonForBlocksArchitecture()`
  (PSR-4, non si perde nei merge). Wrapper globale opzionale:
  `loadHomepageJsonForBlocksArchitectureTest()`. Story [ROOT-17.10](../../../../docs/stories/17-10-helper-e-blocchi-persi-nella-bonifica.md).
  Il loader cerca in `config/<tenant>/database/content/pages/` (via `GetTenantFilePathAction`) il JSON con
  slug `home`, valida la forma (`id`, `content_blocks` per lingua, ogni blocco con `type` e `data`) e
  **salta il test** se il tenant non ha la homepage. Per i blocchi di una lingua: `TestCase::homepageBlocksForLocale()`
  (o `cmsHomepageBlocks()` nei test Pest). Nei test non si scrivono path di tenant a mano.
- `createPHPUnitMock()` e `skipTest()` sono metodi d'istanza di `TestCase` (come `XotBaseTestCase`);
  `skipTest()` salta davvero il test, non lo fa fallire.
- Prima di rimuovere un helper: `grep -rn '\bnomeHelper(' Modules --include='*.php'`.
- `cmsSkipTest(string $message = ''): never` e' l'helper globale per saltare un test: delega a `TestCase::skipTest()` e quindi
  vale solo nei test che estendono `Modules\Cms\Tests\TestCase` (`cmsTest()` lancia `LogicException` altrimenti; un file che usa
  la `Tests\TestCase` della radice usa `->skip($condizione, $motivo)` di Pest). Essendo `never`, dopo la chiamata non si scrive
  `return;`/`continue;` (PHPStan: `deadCode.unreachable`).
- Utenti di test: `cmsCreateTestUser()` restituisce `Modules\Xot\Contracts\UserContract`, `cmsCreateUnverifiedUser()` un `User`.
  `XotUserContract` non esiste.
- Lezione 2026-10-28: `Function cmsSkipTest not found` (43 chiamate) veniva da un conflitto `<<<<<<<`/`>>>>>>>` in `PestHelpers.php`
  risolto tenendo un solo lato: la funzione stava nell'altro. Dopo un merge che tocca `PestHelpers.php`, `grep -rn 'function cms'` e
  PHPStan sul modulo prima di committare.

## Writing Tests

### Authentication Tests

Authentication tests are located in `tests/Feature/Auth/`. These tests cover:

- User registration
- Login/logout
- Password reset
- Email verification
- Profile management

### Example Authentication Test

```php
test('users can login with valid credentials', function () {
    $user = User::factory()->create();
    
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    
    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
});
```

## Running Tests

Run all Cms module tests:
```bash
./vendor/bin/pest Modules/Cms/tests
```

Run a specific test file:
```bash
./vendor/bin/pest Modules/Cms/tests/Feature/Auth/AuthenticationTest.php
```

## Unit model business logic (PHPStan)

I test in `tests/Unit/Models/*BusinessLogicTest.php` sono classi PHPUnit pure (`TestCase` + `PHPUnit\Framework\Assert`): verificano solo API pubbliche del model (fillable, translatable, `getCasts()`, query builder) e non usano Pest `expect()` per evitare errori PHPStan sulle higher-order expectation. I flussi con factory/DB restano nei test Feature.

### Campagna `Internal error` (pest-plugin-phpstan)

Se PHPStan abortisce l'intero modulo con `Internal error`, la causa tipica è
`HigherOrderExpectationTypeExtension` su mixin Pest (`toBeSubclassOf`,
`toContain`, chain `->not`, ecc.).

**Perché:** l'analisi deve includere i test; escludere `tests/` nasconde il
crash e rompe l'obiettivo zero-errori.

**Fix:** stesso pattern Notify/Geo — `Assert::assert*` nei BusinessLogic test;
dettaglio SSoT Notify: [phpstan-pest-patterns-modulo-notify.md](../../Notify/docs/wiki/memories/phpstan-pest-patterns-modulo-notify.md).
Regola assoluta: [phpstan test mai escludere](../../Notify/docs/regole-critiche/phpstan-test-mai-escludere.md).

## Best Practices

1. **Use Factories**: Always use factories to create test data
2. **Test Edge Cases**: Include tests for validation errors and edge cases
3. **Keep Tests Focused**: Each test should verify one specific behavior
4. **Use Descriptive Names**: Test names should clearly indicate what's being tested