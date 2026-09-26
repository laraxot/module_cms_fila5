<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Livewire\Volt\Volt as LivewireVolt;
<<<<<<< HEAD
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;
=======
use Illuminate\Support\Facades\Hash;
use Modules\Cms\Tests\TestCase;
>>>>>>> laraxot/dev

use function Pest\Laravel\actingAs;

uses(TestCase::class);

test('confirm password screen can be rendered', function () {
<<<<<<< HEAD
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    $lang = app()->getLocale();
    $response = actingAs($user)->get('/'.$lang.'/confirm-password');
=======
    $user = TestCase::pestCreateTestUser(['password' => Hash::make('password')]);

    actingAs($user);
    $lang = app()->getLocale();
    $response = $this->get('/'.$lang.'/confirm-password');
>>>>>>> laraxot/dev

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
<<<<<<< HEAD
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();
=======
    $user = TestCase::pestCreateTestUser(['password' => Hash::make('password')]);
>>>>>>> laraxot/dev

    actingAs($user);

    $response = LivewireVolt::test('auth.confirm-password')->set('password', 'password')->call('confirmPassword');

<<<<<<< HEAD
    $response->assertHasNoErrors()->assertRedirect(route('dashboard', absolute: false));
});

test('password is not confirmed with invalid password', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();
=======
    $response->assertHasNoErrors();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('password is not confirmed with invalid password', function () {
    $user = TestCase::pestCreateTestUser(['password' => Hash::make('password')]);
>>>>>>> laraxot/dev

    actingAs($user);

    $response = LivewireVolt::test('auth.confirm-password')->set('password', 'wrong-password')->call('confirmPassword');

    $response->assertHasErrors(['password']);
});
