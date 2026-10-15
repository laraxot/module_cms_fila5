<?php

declare(strict_types=1);

namespace Tests\Modules\Cms\Feature\Auth;

use Tests\Modules\Xot\TestCase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(TestCase::class);

// NOTE: Helper functions moved to Tests\Modules\Xot\TestCase for DRY pattern
// Use $this->createTestUser()

describe('Register Page', function () {
    test('register page renders for guest', function () {
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/register');
        $response->assertStatus(200);
    });

    test('authenticated user is redirected away from register page', function () {
        $user = $this->createTestUser();
        actingAs($user);
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/register');
        $response->assertRedirect('/');
    });
});
