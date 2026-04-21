<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(TestCase::class);

dataset('userTypes', [
    'doctor' => ['doctor'],
    'patient' => ['patient'],
]);

test('guest can view :type registration page', function (string $type): void {
    $response = get("/it/auth/{$type}/register");
    expect($response->status())->toBe(200);
})->with('userTypes');

test('authenticated user is redirected from :type registration page', function (string $type): void {
    $user = $this->createTestUser();
    actingAs($user);

    $response = get("/it/auth/{$type}/register");
    expect($response->status())->toBe(302);
})->with('userTypes');

test(':type registration page contains expected elements', function (string $type): void {
    $response = get("/it/auth/{$type}/register");

    expect($response->status())->toBe(200);

    $content = $response->getContent();
    expect($content)->toContain('Registrazione')->toContain('Crea il tuo account');
})->with('userTypes');

test(':type registration page has proper HTML structure', function (string $type): void {
    $response = get("/it/auth/{$type}/register");

    $content = $response->getContent();
    expect($content)
        ->toContain('<!DOCTYPE html>')
        ->toContain('<html')
        ->toContain('</html>')
        ->toContain('<meta name="viewport"')
        ->toContain('width=device-width');
})->with('userTypes');

test(':type registration page uses Italian localization', function (string $type): void {
    $response = get("/it/auth/{$type}/register");

    expect($response->status())->toBe(200);

    $content = $response->getContent();
    expect($content)->toContain('Registrazione')->toContain('Crea il tuo account');
})->with('userTypes');

test(':type registration page loads within acceptable time limits', function (string $type): void {
    $startTime = microtime(true);

    $response = get("/it/auth/{$type}/register");

    $loadTime = microtime(true) - $startTime;

    expect($response->status())->toBe(200);
    expect($loadTime)->toBeLessThan(3.0);
})->with('userTypes');
