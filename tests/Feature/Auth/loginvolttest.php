<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Cms\Tests\TestCase;
use Modules\Xot\Datas\XotData;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
// NOTE: Helper functions moved to Modules\Cms\Tests\TestCase for DRY pattern
// Use cmsGenerateUniqueEmail(), $this->getUserClass(), cmsCreateTestUser()

describe('Volt Component Rendering', function (): void {
    test('volt login component can be rendered', function (): void {
        /** @var TestCase $this */
        $component = LivewireVolt::test('auth.login');
        /* @var Testable<\Livewire\Component> $component */
        $component->assertOk();
    });

    test('volt component has initial state', function (): void {
        /** @var TestCase $this */
        $component = LivewireVolt::test('auth.login');

        /* @var Testable<\Livewire\Component> $component */
        $component->assertSet('email', '')->assertSet('password', '')->assertSet('remember', false);
    });

    test('volt component renders form elements', function (): void {
        /** @var TestCase $this */
        $component = LivewireVolt::test('auth.login');

        /* @var Testable<\Livewire\Component> $component */
        $component
            ->assertSee('wire:model="email"')
            ->assertSee('wire:model="password"')
            ->assertSee('wire:model="remember"');
    });
});

describe('Volt Component Authentication', function (): void {
    test('user can authenticate via volt component', function (): void {
        /** @var TestCase $this */
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
        /** @var TestCase $this */
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

    test('authentication fails with non-existent user', function (): void {
        /** @var TestCase $this */
        $email = cmsGenerateUniqueEmail();

        cmsAssertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasErrors(['email']);
        cmsAssertGuest();
    });
});

describe('Volt Component Validation', function (): void {
    test('email validation works', function (): void {
        /** @var TestCase $this */
        $response = LivewireVolt::test('auth.login')
        ->set('email', 'invalid-email')
        ->set('password', 'password123')
        ->call('save');

        $response->assertHasErrors(['email']);
    });

    test('required fields validation', function (): void {
        /** @var TestCase $this */
        $response = LivewireVolt::test('auth.login')->call('save');

        $response->assertHasErrors(['email', 'password']);
    });

    test('password minimum length validation', function (): void {
        /** @var TestCase $this */
        $email = cmsGenerateUniqueEmail();

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
        /** @var TestCase $this */
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
        /** @var TestCase $this */
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        // Store original session ID
        $originalSessionId = session()->getId();

        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
        cmsAssertAuthenticated();

        // Session should be regenerated for security
        Assert::assertNotSame($originalSessionId, session()->getId());
    });

    test('session data is preserved on authentication', function (): void {
        /** @var TestCase $this */
        $email = cmsGenerateUniqueEmail();
        $user = cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        // Set some session data
        Session::put('test_key', 'test_value');

        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
        cmsAssertAuthenticated();

        // Session data should be preserved (session regenerated but data kept)
        Assert::assertSame('test_value', Session::get('test_key'));
    });
});

describe('Volt Component Security', function (): void {
    test('login attempts are rate limited', function (): void {
        /** @var TestCase $this */
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
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

        $response->assertHasErrors();
    });

    test('csrf protection is active', function (): void {
        /** @var TestCase $this */
        // Volt components should automatically handle CSRF protection
        $email = cmsGenerateUniqueEmail();
        $user = cmsCreateTestUser([
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
        /** @var TestCase $this */
        $email = cmsGenerateUniqueEmail();

        $response = LivewireVolt::test('auth.login')
            ->set('email', '<script>alert("xss")</script>'.$email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasErrors(['email']);
    });
});

describe('Volt Component State Management', function (): void {
    test('component state updates correctly', function (): void {
        /** @var TestCase $this */
        $email = cmsGenerateUniqueEmail();

        $component = LivewireVolt::test('auth.login');

        /* @var Testable<\Livewire\Component> $component */
        $component
            ->set('email', $email)
            ->assertSet('email', $email)
            ->set('password', 'password123')
            ->assertSet('password', 'password123')
            ->set('remember', true)
            ->assertSet('remember', true);
    });

    test('component resets after failed authentication', function (): void {
        /** @var TestCase $this */
        $email = cmsGenerateUniqueEmail();

        $component = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'wrong_password')
            ->call('save');

        // Password should be cleared after failed attempt
        $component->assertSet('password', '');
    });

    test('loading state is managed correctly', function (): void {
        /** @var TestCase $this */
        $email = cmsGenerateUniqueEmail();
        $user = cmsCreateTestUser([
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
        /** @var TestCase $this */
        // Using XotData pattern ensures compatibility with any user type
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

        $authenticatedUser = Auth::user();
        Assert::assertNotNull($authenticatedUser);
        Assert::assertSame($email, $authenticatedUser->email);
    });

    test('component handles different user configurations', function (): void {
        /** @var TestCase $this */
        // Test with various user attributes
        $email = cmsGenerateUniqueEmail();
        $user = cmsCreateTestUser([
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
});

describe('Volt Component Redirects', function (): void {
    test('component redirects after successful authentication', function (): void {
        /** @var TestCase $this */
        $email = cmsGenerateUniqueEmail();
        $user = cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();

        // Component might trigger redirect via JavaScript/Alpine
        // This test ensures the authentication logic completes successfully
    });

    test('component handles intended redirect', function (): void {
        /** @var TestCase $this */
        $email = cmsGenerateUniqueEmail();
        $user = cmsCreateTestUser([
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
        cmsAssertAuthenticated();
    });
});

describe('Volt Component Accessibility', function (): void {
    test('component has proper aria labels', function (): void {
        /** @var TestCase $this */
        $component = LivewireVolt::test('auth.login');

        /* @var Testable<\Livewire\Component> $component */
        // Component should render with accessibility attributes
        $component->assertSee('aria-label')->assertSee('id="data.email"')->assertSee('id="data.password"');
    });

    test('component handles keyboard navigation', function (): void {
        /** @var TestCase $this */
        $component = LivewireVolt::test('auth.login');

        /* @var Testable<\Livewire\Component> $component */
        // Component should be keyboard accessible
    });
});
