<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace Modules\Cms\Tests\Feature\Auth;
=======
use PHPUnit\Framework\Assert;
>>>>>>> 127b4277 (.)

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

<<<<<<< HEAD
// Helper (createTestUser, generateUniqueEmail, getUserClass) su Modules\Cms\Tests\TestCase, legato da tests/Pest.php.
// Use $this->createTestUser()
=======
// NOTE: Helper functions moved to Modules\Cms\Tests\TestCase for DRY pattern
// Use cmsCreateTestUser()
>>>>>>> 127b4277 (.)

describe('Register Page', function () {
    test('register page renders for guest', function () {
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/register');
<<<<<<< HEAD
        $response->assertStatus(200);
    });

    test('authenticated user is redirected away from register page', function () {
        $user = $this->createTestUser();
        actingAs($user);
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/register');
        $response->assertRedirect('/');
=======
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
>>>>>>> 127b4277 (.)
    });
});
