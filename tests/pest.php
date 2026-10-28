<?php

declare(strict_types=1);
<<<<<<< HEAD
=======
use Modules\Cms\Tests\TestCase;
>>>>>>> 127b4277 (.)

/*
 * Bootstrap Pest — modulo Cms.
 * Helper globali (cmsHomepageBlocks, cmsGet, …) in PestHelpers.php.
 * Binding TestCase solo qui: i file test non dichiarano uses(TestCase) ridondanti.
 * @see docs/stories/phpstan-cms-zero.story.md
 *
 * Nota: su FS case-sensitive esistono sia Pest.php sia pest.php (variante storica).
 * Tenere lo stesso bootstrap in entrambi finche' non si decide la sola PascalCase.
 */
require_once __DIR__.'/PestHelpers.php';

uses(TestCase::class)->in('Feature', 'Unit');

/*
 * |--------------------------------------------------------------------------
 * | Expectations
 * |--------------------------------------------------------------------------
 */

// expect()->extend('toBeValidHtml', function () {
//     return $this->toContain('<html');
// });

/*
 * |--------------------------------------------------------------------------
 * | Functions
 * |--------------------------------------------------------------------------
 */

// function createTestUser() {
//     return User::factory()->create();
// }
