<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Xot\Datas\XotData;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('login screen can be rendered', function (): void {
    $lang = app()->getLocale();
    get('/'.$lang.'/auth/login')->assertStatus(200);
});

test('users can authenticate using the login screen', function (): void {
    $user = cmsCreateTestUser();

    $response = LivewireVolt::test('auth.login')
        ->set('email', (string) $user->email)
        ->set('password', 'password')
        ->call('authenticate');
    /* @var Testable<\Livewire\Component> $response */

    $response->assertHasNoErrors();
});

/*
 * test('users cannot authenticate with invalid password', function(): void {
 * $userClass = XotData::make()->getUserClass();
 * $user = $userClass::factory()->create();
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
 * test('users can logout', function(): void {
 * $userClass = XotData::make()->getUserClass();
 * $user = $userClass::factory()->create();
 *
 * $response = actingAs($user)->post('/logout');
 *
 * Assert::assertSame('/', $response->headers->get('Location'));
 *
 * expect(Auth::guest())->toBeTrue();
 * });
 */
