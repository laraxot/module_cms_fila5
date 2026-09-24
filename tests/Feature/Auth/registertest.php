<?php

declare(strict_types=1);

<<<<<<< .merge_file_h500e0
use Modules\Cms\Tests\TestCase;
=======
<<<<<<< .merge_file_InBoHQ
namespace Modules\Cms\Tests\Feature\Auth;

use Modules\Xot\Tests\TestCase;
=======
<<<<<<< .merge_file_zQAN7S
use Modules\Cms\Tests\TestCase;
=======
namespace Modules\Cms\Tests\Feature\Auth;

use Modules\Xot\Tests\TestCase;
>>>>>>> .merge_file_yYC3Qx
>>>>>>> .merge_file_j7w3to
>>>>>>> .merge_file_kobH58

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

<<<<<<< .merge_file_h500e0
=======
<<<<<<< .merge_file_InBoHQ
=======
<<<<<<< .merge_file_zQAN7S
>>>>>>> .merge_file_kobH58
use PHPUnit\Framework\Assert;

uses(TestCase::class);
// NOTE: Helper functions moved to Modules\Cms\Tests\TestCase for DRY pattern
// Use cmsCreateTestUser()
<<<<<<< .merge_file_h500e0
=======
=======
>>>>>>> .merge_file_j7w3to
uses(TestCase::class);

// NOTE: Helper functions moved to Modules\Xot\Tests\TestCase for DRY pattern
// Use $this->createTestUser()
<<<<<<< .merge_file_InBoHQ
=======
>>>>>>> .merge_file_yYC3Qx
>>>>>>> .merge_file_j7w3to
>>>>>>> .merge_file_kobH58

describe('Register Page', function () {
    test('register page renders for guest', function () {
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/register');
<<<<<<< .merge_file_h500e0
=======
<<<<<<< .merge_file_InBoHQ
=======
<<<<<<< .merge_file_zQAN7S
>>>>>>> .merge_file_kobH58
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
<<<<<<< .merge_file_h500e0
=======
=======
>>>>>>> .merge_file_j7w3to
        $response->assertStatus(200);
    });

    test('authenticated user is redirected away from register page', function () {
        $user = $this->createTestUser();
        actingAs($user);
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/register');
        $response->assertRedirect('/');
<<<<<<< .merge_file_InBoHQ
=======
>>>>>>> .merge_file_yYC3Qx
>>>>>>> .merge_file_j7w3to
>>>>>>> .merge_file_kobH58
    });
});
