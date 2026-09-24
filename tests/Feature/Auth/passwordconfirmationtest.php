<?php

declare(strict_types=1);

<<<<<<< .merge_file_KTuV68
=======
<<<<<<< .merge_file_WC0Rrf
=======
<<<<<<< .merge_file_kXLOcu
>>>>>>> .merge_file_HZQ6RY
use Livewire\Features\SupportTesting\Testable;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('confirm password screen can be rendered', function (): void {
    $user = cmsCreateTestUser();

    $lang = app()->getLocale();
    $response = cmsActingAsGet($user, '/'.$lang.'/confirm-password');

    Assert::assertSame(200, $response->status());
});

test('password can be confirmed', function (): void {
    $user = cmsCreateTestUser();

    cmsActingAs($user);

    $component = LivewireVolt::test('auth.confirm-password')->set('password', 'password')->call('confirmPassword');
    Assert::assertInstanceOf(Testable::class, $component);

    $component->assertHasNoErrors();
    $component->assertRedirect(route('dashboard', absolute: false));
});

test('password is not confirmed with invalid password', function (): void {
    $user = cmsCreateTestUser();

    cmsActingAs($user);

    $component = LivewireVolt::test('auth.confirm-password')->set('password', 'wrong-password')->call('confirmPassword');
    Assert::assertInstanceOf(Testable::class, $component);

    $component->assertHasErrors(['password']);
<<<<<<< .merge_file_KTuV68
=======
=======
>>>>>>> .merge_file_3KxAyB
namespace Modules\Cms\Tests\Feature\Auth;

use Livewire\Volt\Volt as LivewireVolt;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\actingAs;

uses(TestCase::class);

test('confirm password screen can be rendered', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    $lang = app()->getLocale();
    $response = actingAs($user)->get('/'.$lang.'/confirm-password');

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    actingAs($user);

    $response = LivewireVolt::test('auth.confirm-password')->set('password', 'password')->call('confirmPassword');

    $response->assertHasNoErrors()->assertRedirect(route('dashboard', absolute: false));
});

test('password is not confirmed with invalid password', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    actingAs($user);

    $response = LivewireVolt::test('auth.confirm-password')->set('password', 'wrong-password')->call('confirmPassword');

    $response->assertHasErrors(['password']);
<<<<<<< .merge_file_WC0Rrf
=======
>>>>>>> .merge_file_FioX7X
>>>>>>> .merge_file_3KxAyB
>>>>>>> .merge_file_HZQ6RY
});
