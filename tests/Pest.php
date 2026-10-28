<?php

declare(strict_types=1);
<<<<<<< HEAD

/*
 * Bootstrap Pest — modulo Cms.
 * Helper globali (cmsHomepageBlocks, cmsGet, …) in PestHelpers.php.
 * Binding TestCase solo qui: i file test non dichiarano uses(TestCase) ridondanti.
 * @see docs/stories/phpstan-cms-zero.story.md
 */
require_once __DIR__.'/PestHelpers.php';

uses(Modules\Cms\Tests\TestCase::class)->in('Feature', 'Unit');
=======
use Modules\Cms\Tests\TestCase;
>>>>>>> 127b4277 (.)

/**
 * |--------------------------------------------------------------------------
 * | Expectations
 * |--------------------------------------------------------------------------
 * |
<<<<<<< HEAD
 * | Qui puoi definire aspettative globali per il modulo Cms.
 * | Quando definisci here expectation globali, saranno disponibili
 * | in tutti i test del modulo.
 * |
 */

// expect()->extend('toBeValidHtml', function () {
//     return $this->toContain('<html');
// });

/*
 * |--------------------------------------------------------------------------
=======
 * | Il TestCase di default per tutti i test del modulo Cms.
 * | Utilizza il TestCase globale di Laravel con setup specifico per frontend.
 * |
 */

uses(TestCase::class)->in('Feature', 'Unit');

/*
 * |--------------------------------------------------------------------------
 * | Expectations
 * |--------------------------------------------------------------------------
 * |
 * | Qui puoi definire aspettative globali per il modulo Cms.
 * | Quando definisci here expectation globali, saranno disponibili
 * | in tutti i test del modulo.
 * |
 */

expect()->extend('toBeSubclassOf', function (string $parentClass) {
    $class = $this->value;
    if (! is_string($class)) {
        throw new InvalidArgumentException('Expected a class name string');
    }

    return $this->and(is_subclass_of($class, $parentClass));
});

/*
 * |--------------------------------------------------------------------------
>>>>>>> 127b4277 (.)
 * | Functions
 * |--------------------------------------------------------------------------
 * |
 * | Qui puoi definire funzioni helper globali per i test del modulo.
 * | Queste funzioni saranno disponibili in tutti i test.
 * |
 */

// function createTestUser() {
//     return User::factory()->create();
// }
