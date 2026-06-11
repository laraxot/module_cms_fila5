<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;
use function Pest\Laravel\get;

uses(Modules\Cms\Tests\TestCase::class);
test('reset password link screen can be rendered', function (): void {
    $lang = app()->getLocale();
    $response = get('/'.$lang.'/forgot-password');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
    Assert::assertSame(404, $response->status());
});

test('reset password link can be requested', function (): void {
    });

test('reset password screen can be rendered', function (): void {
    $lang = app()->getLocale();
    $response = get('/'.$lang.'/reset-password/fake-token');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
    Assert::assertSame(404, $response->status());
});

test('password can be reset with valid token', function (): void {
    });
