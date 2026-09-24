<?php

declare(strict_types=1);

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
});
