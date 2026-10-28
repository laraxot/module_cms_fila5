<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace Modules\Cms\Tests\Feature\Auth;

use Livewire\Volt\Volt as LivewireVolt;

use function Pest\Laravel\get;

test('login screen can be rendered', function (): void {
    $lang = app()->getLocale();
    get('/'.$lang.'/auth/login')->assertStatus(200);
});

test('users can authenticate using the login screen', function (): void {
    $user = $this->createTestUser();
=======
use Livewire\Features\SupportTesting\Testable;
use Livewire\Volt\Volt as LivewireVolt;

test('login screen can be rendered', function (): void {
    $lang = app()->getLocale();
    cmsGet('/'.$lang.'/auth/login');
});

test('users can authenticate using the login screen', function (): void {
    $user = cmsCreateTestUser();
>>>>>>> 127b4277 (.)

    $response = LivewireVolt::test('auth.login')
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('authenticate');
<<<<<<< HEAD

    $response->assertHasNoErrors(); // ->assertRedirect(route('dashboard', absolute: false))

    // expect(Auth::user())->not->toBeNull();
});

/*
 * test('users cannot authenticate with invalid password', function (): void {
 * $user = $this->createTestUser();
 *
 * $response = LivewireVolt::test('auth.login')
 * ->set('email', $user->email)
 * ->set('password', 'wrong-password')
 * ->call('login');
 *
 * $response->assertHasErrors('email');
 *
 * expect(Auth::guest())->toBeTrue();
 * });
 *
 * test('users can logout', function (): void {
 * $user = $this->createTestUser();
 *
 * $response = actingAs($user)->post('/logout');
 *
 * $response->assertRedirect('/');
 *
 * expect(Auth::guest())->toBeTrue();
 * });
 */
=======
    /* @var Testable<\Livewire\Component> $response */

    $response->assertHasNoErrors();
});
>>>>>>> 127b4277 (.)
