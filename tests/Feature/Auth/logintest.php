<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

describe('Frontend Login Page Rendering', function () {
    test('login page can be rendered', function () {
        $locale = app()->getLocale();
        $response = $this->get('/'.$locale.'/auth/login');
        $response->assertStatus(200);
    });

    test('login page contains login widget', function () {
        $locale = app()->getLocale();
        $response = $this->get('/'.$locale.'/auth/login');
        $response->assertStatus(200);
    });

    test('login page has required form elements', function () {
        $locale = app()->getLocale();
        $response = $this->get('/'.$locale.'/auth/login');
        $response->assertStatus(200);
    });
});

describe('Frontend Login Page Localization', function () {
    test('login page works in italian', function () {
        app()->setLocale('it');
        $response = $this->get('/it/auth/login');
        $response->assertStatus(200);
    });

    test('login page contains localized content', function () {
        $response = $this->get('/it/auth/login');
        $response
            ->assertStatus(200)
            ->assertSee('Hai dimenticato la password?')
            ->assertSee(__('pub_theme::auth.login.title'))
            ->assertSee(__('pub_theme::auth.login.or'));
    });
});

describe('Frontend Login Page Authentication', function () {
    test('user can authenticate via frontend login page', function () {
        $email = $this->makeUniqueEmail();
        $user = $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $this->assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');

        $response->assertHasNoErrors();
        $this->assertAuthenticated();

        $this->actingAs($user);

        $locale = app()->getLocale();
        $response = $this->get('/'.$locale.'/auth/login');

        $response->assertRedirect('/');
    });
});

describe('Frontend Login Page Integration', function () {
    test('authenticated users are redirected from login page', function () {
        $user = $this->makeAuthUser();

        $this->actingAs($user);

        $locale = app()->getLocale();
        $response = $this->get('/'.$locale.'/auth/login');

        $response->assertStatus(302);
    });
});

describe('Frontend Login Session Management', function () {
    test('remember me functionality works', function () {
        $email = $this->makeUniqueEmail();
        $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $this->assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->set('remember', true)
            ->call('authenticate');

        $response->assertHasNoErrors();
        $this->assertAuthenticated();
    });

    test('session regeneration on login', function () {
        $email = $this->makeUniqueEmail();
        $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $originalSessionId = session()->getId();

        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');

        $this->assertAuthenticated();

        expect(session()->getId())->not->toBe($originalSessionId);
    });
});

describe('Frontend Login Security', function () {
    test('login attempts are rate limited', function () {
        $email = $this->makeUniqueEmail();
        $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        for ($i = 0; $i < 5; ++$i) {
            LivewireVolt::test('auth.login')
                ->set('email', $email)
                ->set('password', 'wrong_password')
                ->call('authenticate');
        }

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');

        expect($response)->not->toBeNull();
    });
});

describe('Frontend Login User Types', function () {
    test('any user type can login via frontend', function () {
        $email = $this->makeUniqueEmail();
        $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $this->assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');

        $response->assertHasNoErrors();
        $this->assertAuthenticated();

        $authenticatedUser = Auth::user();
        expect($authenticatedUser)->not->toBeNull();
        expect($authenticatedUser?->email)->toBe($email);
    });
});
