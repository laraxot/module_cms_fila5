<?php

declare(strict_types=1);

<<<<<<< .merge_file_zQAN7S
use Modules\Cms\Tests\TestCase;
=======
namespace Modules\Cms\Tests\Feature\Auth;

use Modules\Xot\Tests\TestCase;
>>>>>>> .merge_file_yYC3Qx

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

<<<<<<< .merge_file_zQAN7S
use PHPUnit\Framework\Assert;

uses(TestCase::class);
// NOTE: Helper functions moved to Modules\Cms\Tests\TestCase for DRY pattern
// Use cmsCreateTestUser()
=======
uses(TestCase::class);

// NOTE: Helper functions moved to Modules\Xot\Tests\TestCase for DRY pattern
// Use $this->createTestUser()
>>>>>>> .merge_file_yYC3Qx

describe('Register Page', function () {
    test('register page renders for guest', function () {
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/register');
<<<<<<< .merge_file_zQAN7S
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
=======
        $response->assertStatus(200);
    });

    test('authenticated user is redirected away from register page', function () {
        $user = $this->createTestUser();
        actingAs($user);
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/register');
        $response->assertRedirect('/');
>>>>>>> .merge_file_yYC3Qx
    });
});
