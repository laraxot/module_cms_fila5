<?php

declare(strict_types=1);

use Livewire\Features\SupportTesting\Testable;
use Livewire\Volt\Volt as LivewireVolt;

uses(Modules\Cms\Tests\TestCase::class);
test('login screen can be rendered', function (): void {
    $lang = app()->getLocale();
    cmsGet('/'.$lang.'/auth/login');
});

test('users can authenticate using the login screen', function (): void {
    $user = cmsCreateTestUser();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('authenticate');
    /* @var Testable<\Livewire\Component> $response */

    $response->assertHasNoErrors();
});
