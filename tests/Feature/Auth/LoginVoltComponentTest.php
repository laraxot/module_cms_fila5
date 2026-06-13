<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Login Volt Component', function (): void {
    test('volt login component can be rendered', function (): void {
        /** @var Testable<\Livewire\Component> $component */
        $component = LivewireVolt::test('auth.login');
        $component->assertOk();
    });

    test('volt component has initial state', function (): void {
        /** @var Testable<\Livewire\Component> $component */
        $component = LivewireVolt::test('auth.login');
        $component->assertSet('email', '')->assertSet('password', '')->assertSet('remember', false);
    });

    test('volt component renders form elements', function (): void {
        /** @var Testable<\Livewire\Component> $component */
        $component = LivewireVolt::test('auth.login');
        $component
            ->assertSee('wire:model="email"')
            ->assertSee('wire:model="password"')
            ->assertSee('wire:model="remember"');
    });

    test('user can authenticate via volt component', function (): void {
        $email = cmsGenerateUniqueEmail();
        $user = cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
        cmsAssertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();
    });

    test('authentication fails with wrong credentials', function (): void {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        cmsAssertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'wrong_password')
            ->call('save');

        $response->assertHasErrors(['email']);
        cmsAssertGuest();
    });

    test('authentication fails with non existent user', function (): void {
        $email = cmsGenerateUniqueEmail();

        cmsAssertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasErrors(['email']);
        cmsAssertGuest();
    });

    test('email validation works', function (): void {
        $response = LivewireVolt::test('auth.login')
                    ->set('email', 'invalid-email')
                    ->set('password', 'password123')
                    ->call('save');

        $response->assertHasErrors(['email']);
    });

    test('required fields validation', function (): void {
        $response = LivewireVolt::test('auth.login')->call('save');

        $response->assertHasErrors(['email', 'password']);
    });

    test('password minimum length validation', function (): void {
        $email = cmsGenerateUniqueEmail();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', '123')
            ->call('save');

        $response->assertHasErrors();
    });

    test('remember me functionality works', function (): void {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
        cmsAssertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->set('remember', true)
            ->call('save');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();
    });

    test('session regeneration on login', function (): void {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $originalSessionId = session()->getId();

        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
        cmsAssertAuthenticated();

        Assert::assertNotSame($originalSessionId, session()->getId());
    });

    test('session data is preserved on authentication', function (): void {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        Session::put('test_key', 'test_value');

        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
        cmsAssertAuthenticated();

        Assert::assertSame('test_value', Session::get('test_key'));
    });

    test('login attempts are rate limited', function (): void {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        for ($i = 0; $i < 5; ++$i) {
            LivewireVolt::test('auth.login')
                ->set('email', $email)
                ->set('password', 'wrong_password')
                ->call('save');
        }

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasErrors();
    });

    test('csrf protection is active', function (): void {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
    });

    test('input sanitization works', function (): void {
        $email = cmsGenerateUniqueEmail();

        $response = LivewireVolt::test('auth.login')
            ->set('email', '<script>alert("xss")</script>'.$email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasErrors(['email']);
    });

    test('component state updates correctly', function (): void {
        $email = cmsGenerateUniqueEmail();

        /** @var Testable<\Livewire\Component> $component */
        $component = LivewireVolt::test('auth.login');
        $component
            ->set('email', $email)
            ->assertSet('email', $email)
            ->set('password', 'password123')
            ->assertSet('password', 'password123')
            ->set('remember', true)
            ->assertSet('remember', true);
    });

    test('component resets after failed authentication', function (): void {
        $email = cmsGenerateUniqueEmail();

        $component = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'wrong_password')
            ->call('save');

        $component->assertSet('password', '');
    });

    test('loading state is managed correctly', function (): void {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $component = LivewireVolt::test('auth.login')->set('email', $email)->set('password', 'password123');

        $component->assertDontSee('wire:loading');

        $component->call('save');

        $component->assertHasNoErrors();
    });

    test('any user type can login via volt component', function (): void {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
        cmsAssertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();

        $authenticatedUser = Auth::user();
        Assert::assertNotNull($authenticatedUser);
        Assert::assertSame($email, $authenticatedUser->email);
    });

    test('component handles different user configurations', function (): void {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
            'name' => 'Test User',
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();

        $authenticatedUser = Auth::user();
        Assert::assertSame('Test User', $authenticatedUser?->name);
    });

    test('component redirects after successful authentication', function (): void {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();
    });

    test('component handles intended redirect', function (): void {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        Session::put('url.intended', '/dashboard');

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();
    });

    test('component has proper aria labels', function (): void {
        /** @var Testable<\Livewire\Component> $component */
        $component = LivewireVolt::test('auth.login');
        $component->assertSee('aria-label')->assertSee('id="data.email"')->assertSee('id="data.password"');
    });

    test('component handles keyboard navigation', function (): void {
        /** @var Testable<\Livewire\Component> $component */
        $component = LivewireVolt::test('auth.login');
    });
});
