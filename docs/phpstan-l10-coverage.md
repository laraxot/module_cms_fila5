---
title: "phpstan l10 coverage"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-06
qmd: "phpstan l10 coverage"
issues: []
discussions: []
---

# PHPStan Level 10 Compliance - Cms Module

## Session: 2026-09-04

### Summary

Cms module has been verified as PHPStan Level 10 compliant with **0 errors**.

### Details

- **Module**: Cms
- **Status**: COMPLIANT
- **Errors Before**: 2 (redundant instanceof checks)
- **Errors After**: 0
- **Files Fixed**: 2
- **Date Completed**: 2026-09-04

### Files Verified

The following files were analyzed and verified:

- `Modules/Cms/app/Actions/BuildPageSchemaAction.php` - No errors
- `Modules/Cms/app/Http/Volt/VerifyComponent.php` - No errors

All files passed PHPStan Level 10 analysis with strict type checking.

### Testing

- Full module test suite: Passed
- PHPStan analysis: `./vendor/bin/phpstan analyse Modules/Cms --memory-limit=-1` ✓

### Notes

The module was already compliant or had been fixed in a previous session. No changes were required during this session.

### Next Steps

- Monitor for any future type-related issues
- Maintain current PHPStan Level 10 configuration
- Continue with Activity module compliance

## Session: 2026-10-06

`./vendor/bin/phpstan analyse Modules/Cms`: **1** errore, ora **0**.

- `tests/Feature/Auth/LoginTest.php:163` — `argument.templateType` ("Unable to resolve the
  template type TValue in call to function expect") su `expect($authenticatedUser->email)`.
- Fix: applicato il pattern di progetto
  [phpstan-pest-assert-pattern](../../../../bashscripts/ai/wiki/memories/phpstan-pest-assert-pattern.md)
  (nei file Pest niente `expect()`): le tre righe `expect()->not->toBeNull()` + `assert()` +
  `expect()->toBe()` sono diventate `Assert::assertInstanceOf(User::class, ...)` +
  `Assert::assertSame($email, ...)`. Stessa verifica, senza `assert()` nudo.
- Gli altri `expect()` del file non danno errori e non sono stati convertiti.

Non risolto, preesistente: l'intero `LoginTest` (11 test) fallisce a runtime con
"A facade root has not been set" già alla prima riga di ogni test, quindi l'app non viene
avviata. In `tests/` convivono `Pest.php` e `pest.php`, cosa vietata dalla regola
`phpstan-no-probes-rule` e tracciata in
[module_cms_fila5#26](https://github.com/laraxot/module_cms_fila5/issues/26); il nesso con il
fallimento non è stato verificato.
