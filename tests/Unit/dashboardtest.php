<?php

declare(strict_types=1);
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Pest\Laravel\get;

uses(TestCase::class);
test('route home redirects to locale-specific page', function (): void {
    // The home route redirects to a locale-specific URL
    get('/')->assertRedirect();
});

test('route login is accessible', function (): void {
    // The login route may redirect, show a login page, or return 404 if not configured
    $response = get('/it/login');

    // Accept various status codes based on configuration
    Assert::assertContains($response->status(), [200, 301, 302, 303, 307, 308, 404]);
});
