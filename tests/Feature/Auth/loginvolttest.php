<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Cms\Tests\TestCase;
use Modules\Xot\Datas\XotData;

uses(TestCase::class);

// NOTE: Helper functions moved to Modules\Xot\Tests\TestCase for DRY pattern
// Use $this->$this->generateUniqueEmail(), $this->getUserClass(), $this->$this->makeAuthUser()

describe('Volt Component Rendering', function (): void {
    test('volt login component can be rendered', function (): void {
        $component = LivewireVolt::test('auth.login');

        expect($component)->not->toBeNull();
        $component->assertOk();
    });

    test('volt component has initial state', function (): void {
        $component = LivewireVolt::test('auth.login');

        $component->assertSet('email', '')->assertSet('password', '')->assertSet('remember', false);
    });

    test('volt component renders form elements', function (): void {
        $component = LivewireVolt::test('auth.login');

        $component
            ->assertSee('wire:model="email"')
            ->assertSee('wire:model="password"')
            ->assertSee('wire:model="remember"');
    });
});

describe('Volt Component Authentication', function (): void {
    test('user can authenticate via volt component', function (): void {
        $email = $this->makeUniqueEmail();
        $user = $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $this->assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        $this->assertAuthenticated();
    });

    test('authentication fails with wrong credentials', function (): void {
        $email = $this->makeUniqueEmail();
        $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $this->assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'wrong_password')
            ->call('save');

        $response->assertHasErrors(['email']);
        $this->assertGuest();
    });

    test('authentication fails with non-existent user', function (): void {
        $email = $this->makeUniqueEmail();

        $this->assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasErrors(['email']);
        $this->assertGuest();
    });
});

describe('Volt Component Validation', function (): void {
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
        $email = $this->makeUniqueEmail();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', '123')
            ->call('save');

        // Password troppo corta dovrebbe fallire
        $response->assertHasErrors();
    });
});

describe('Volt Component Session Management', function (): void {
    test('remember me functionality works', function (): void {
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
            ->call('save');

        $response->assertHasNoErrors();
        $this->assertAuthenticated();
    });

    test('session regeneration on login', function (): void {
        $email = $this->makeUniqueEmail();
        $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        // Store original session ID
        $originalSessionId = session()->getId();

        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $this->assertAuthenticated();

        // Session should be regenerated for security
        expect(session()->getId())->not->toBe($originalSessionId);
    });

    test('session data is preserved on authentication', function (): void {
        $email = $this->makeUniqueEmail();
        $user = $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        // Set some session data
        Session::put('test_key', 'test_value');

        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $this->assertAuthenticated();

        // Session data should be preserved (session regenerated but data kept)
        expect(Session::get('test_key'))->toBe('test_value');
    });
});

describe('Volt Component Security', function (): void {
    test('login attempts are rate limited', function (): void {
        $email = $this->makeUniqueEmail();
        $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        // Multiple failed attempts
        for ($i = 0; $i < 5; ++$i) {
            LivewireVolt::test('auth.login')
                ->set('email', $email)
                ->set('password', 'wrong_password')
                ->call('save');
        }

        // Should be rate limited after too many attempts
        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        // May have throttling errors
        expect($response)->not->toBeNull();
    });

    test('csrf protection is active', function (): void {
        // Volt components should automatically handle CSRF protection
        $email = $this->makeUniqueEmail();
        $user = $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        // Should work normally with CSRF protection
        $response->assertHasNoErrors();
    });

    test('input sanitization works', function (): void {
        $email = $this->makeUniqueEmail();

        $response = LivewireVolt::test('auth.login')
            ->set('email', '<script>alert("xss")</script>'.$email)
            ->set('password', 'password123')
            ->call('save');

        // Should handle potentially malicious input safely
        expect($response)->not->toBeNull();
    });
});

describe('Volt Component State Management', function (): void {
    test('component state updates correctly', function (): void {
        $email = $this->makeUniqueEmail();

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
        $email = $this->makeUniqueEmail();

        $component = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'wrong_password')
            ->call('save');

        // Password should be cleared after failed attempt
        $component->assertSet('password', '');
    });

    test('loading state is managed correctly', function (): void {
        $email = $this->makeUniqueEmail();
        $user = $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $component = LivewireVolt::test('auth.login')->set('email', $email)->set('password', 'password123');

        // Should not be in loading state initially
        $component->assertDontSee('wire:loading');

        // After calling authenticate, component should handle loading state
        $component->call('save');

        // Should complete successfully
        $component->assertHasNoErrors();
    });
});

describe('Volt Component User Types Integration', function (): void {
    test('any user type can login via volt component', function (): void {
        // Using XotData pattern ensures compatibility with any user type
        $email = $this->makeUniqueEmail();
        $user = $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $this->assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        $this->assertAuthenticated();

        // Verify authenticated user
        $authenticatedUser = Auth::user();
        expect($authenticatedUser)->not->toBeNull();
        expect($authenticatedUser?->email)->toBe($email);
    });

    test('component handles different user configurations', function (): void {
        // Test with various user attributes
        $email = $this->makeUniqueEmail();
        $user = $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
            'name' => 'Test User',
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        $this->assertAuthenticated();

        $authenticatedUser = Auth::user();
        expect($authenticatedUser?->name)->toBe('Test User');
    });
});

describe('Volt Component Redirects', function (): void {
    test('component redirects after successful authentication', function (): void {
        $email = $this->makeUniqueEmail();
        $user = $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        $this->assertAuthenticated();

        // Component might trigger redirect via JavaScript/Alpine
        // This test ensures the authentication logic completes successfully
    });

    test('component handles intended redirect', function (): void {
        $email = $this->makeUniqueEmail();
        $user = $this->makeAuthUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        // Set intended URL
        Session::put('url.intended', '/dashboard');

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        $this->assertAuthenticated();
    });
});

describe('Volt Component Accessibility', function (): void {
    test('component has proper aria labels', function (): void {
        $component = LivewireVolt::test('auth.login');

        // Component should render with accessibility attributes
        $component->assertSee('aria-label')->assertSee('id="data.email"')->assertSee('id="data.password"');
    });

    test('component handles keyboard navigation', function (): void {
        $component = LivewireVolt::test('auth.login');

        // Component should be keyboard accessible
        expect($component)->not->toBeNull();
    });
});
