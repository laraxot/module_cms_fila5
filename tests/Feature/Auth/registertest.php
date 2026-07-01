<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(TestCase::class);
// NOTE: Helper functions moved to Modules\Cms\Tests\TestCase for DRY pattern
// Use cmsCreateTestUser()

describe('Register Page', function () {
    test('register page renders for guest', function () {
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/register');
        /* @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        Assert::assertSame(200, $response->status());
    });

    test('authenticated user is redirected away from register page', function () {
        $user = cmsCreateTestUser();
        actingAs($user);
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/register');
        /* @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        Assert::assertSame('/', $response->headers->get('Location'));
    });
});
