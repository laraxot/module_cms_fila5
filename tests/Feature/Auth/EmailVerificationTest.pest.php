<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

// Test: Email verification screen can be rendered
test('email verification screen can be rendered', function () {
    $user = cmsCreateUnverifiedUser();

    $lang = app()->getLocale();
    $response = cmsActingAsGet($user, '/'.$lang.'/verify-email');
    $response->assertStatus(200);
});

// Test: Email can be verified
test('email can be verified', function () {
    $user = cmsCreateUnverifiedUser();

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id' => $user->getKey(),
        'hash' => sha1($user->getEmailForVerification()),
    ]);

    $response = cmsActingAsGet($user, $verificationUrl);

    Event::assertDispatched(Verified::class);
    $user->refresh();
    expect($user->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

// Test: Email is not verified with invalid hash
test('email is not verified with invalid hash', function () {
    $user = cmsCreateUnverifiedUser();

    $verificationUrl = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id' => $user->getKey(),
        'hash' => sha1('wrong-email'),
    ]);

    cmsActingAsGet($user, $verificationUrl);

    $user->refresh();
    expect($user->hasVerifiedEmail())->toBeFalse();
});
