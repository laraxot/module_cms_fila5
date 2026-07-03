<?php

declare(strict_types=1);

use Modules\Xot\Tests\TestCase;

// Use the project's base TestCase
uses(TestCase::class);

beforeEach(function (): void {
    if (! function_exists('moduleEnabled')) {
        $this->markTestSkipped('Module Cms is disabled');
    }
});

it('redirects root / to /{locale}', function (): void {
    $locale = app()->getLocale();
    $response->assertRedirect('/'.$locale);
});

it('serves localized homepage at /{locale}', function (): void {
    $locale = app()->getLocale();
    $response->assertStatus(200);
});
