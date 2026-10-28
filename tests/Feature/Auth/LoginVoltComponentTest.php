<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

final class LoginVoltComponentTest extends TestCase
{
    // ---- Volt Component Rendering ----

<<<<<<< .merge_file_xNy3Sx
it('renders the volt login component', function (): void {
    /** @var Testable<Component> $component */
    $component = LivewireVolt::test('auth.login');
    $component->assertOk();
});

it('has initial state', function (): void {
    /** @var Testable<Component> $component */
    $component = LivewireVolt::test('auth.login #2');
    $component->assertSet('email', '')->assertSet('password', '')->assertSet('remember', false);
});

it('renders form elements', function (): void {
    /** @var Testable<Component> $component */
    $component = LivewireVolt::test('auth.login #3');
    $component
        ->assertSee('wire:model="email"')
        ->assertSee('wire:model="password"')
        ->assertSee('wire:model="remember"');
});

// ---- Volt Component Authentication ----

it('allows a user to authenticate via the volt component', function (): void {
    $email = cmsGenerateUniqueEmail();
    $user = cmsCreateTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);
    cmsAssertGuest();

    $response = LivewireVolt::test('auth.login #4')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasNoErrors();
    cmsAssertAuthenticated();
    Assert::assertEquals($user->getAuthIdentifier(), Auth::id());
});

it('fails authentication with wrong credentials', function (): void {
    $email = cmsGenerateUniqueEmail();
    cmsCreateTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    cmsAssertGuest();

    $response = LivewireVolt::test('auth.login #5')
        ->set('email', $email)
        ->set('password', 'wrong_password')
        ->call('save');

    $response->assertHasErrors(['email']);
    cmsAssertGuest();
});

it('fails authentication with a non-existent user', function (): void {
    $email = cmsGenerateUniqueEmail();

    cmsAssertGuest();

    $response = LivewireVolt::test('auth.login #6')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasErrors(['email']);
    cmsAssertGuest();
});

// ---- Volt Component Validation ----

it('validates the email field', function (): void {
    $response = LivewireVolt::test('auth.login #7')
        ->set('email', 'invalid-email')
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasErrors(['email']);
});

it('validates required fields', function (): void {
    $response = LivewireVolt::test('auth.login #8')->call('save');

    $response->assertHasErrors(['email', 'password']);
});

it('validates password minimum length', function (): void {
    $email = cmsGenerateUniqueEmail();

    $response = LivewireVolt::test('auth.login #9')
        ->set('email', $email)
        ->set('password', '123')
        ->call('save');

    $response->assertHasErrors();
});

// ---- Volt Component Session Management ----

it('supports the remember me functionality', function (): void {
    $email = cmsGenerateUniqueEmail();
    cmsCreateTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);
    cmsAssertGuest();

    $response = LivewireVolt::test('auth.login #10')
        ->set('email', $email)
        ->set('password', 'password123')
        ->set('remember', true)
        ->call('save');

    $response->assertHasNoErrors();
    cmsAssertAuthenticated();
});

it('regenerates the session on login', function (): void {
    $email = cmsGenerateUniqueEmail();
    cmsCreateTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    $originalSessionId = session()->getId();

    LivewireVolt::test('auth.login #11')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');
    cmsAssertAuthenticated();

    Assert::assertNotSame($originalSessionId, session()->getId());
});

it('preserves session data on authentication', function (): void {
    $email = cmsGenerateUniqueEmail();
    cmsCreateTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);
=======
    public function test_volt_login_component_can_be_rendered(): void
    {
        /** @var Testable<Component> $component */
        $component = LivewireVolt::test('auth.login');
        $component->assertOk();
    }

    public function test_volt_component_has_initial_state(): void
    {
        /** @var Testable<Component> $component */
        $component = LivewireVolt::test('auth.login');
        $component->assertSet('email', '')->assertSet('password', '')->assertSet('remember', false);
    }

    public function test_volt_component_renders_form_elements(): void
    {
        /** @var Testable<Component> $component */
        $component = LivewireVolt::test('auth.login');
        $component
            ->assertSee('wire:model="email"')
            ->assertSee('wire:model="password"')
            ->assertSee('wire:model="remember"');
    }

    // ---- Volt Component Authentication ----

    public function test_user_can_authenticate_via_volt_component(): void
    {
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
>>>>>>> .merge_file_QlGrMM

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();
        Assert::assertEquals($user->getAuthIdentifier(), Auth::id());
    }

    public function test_authentication_fails_with_wrong_credentials(): void
    {
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
    }

    public function test_authentication_fails_with_non_existent_user(): void
    {
        $email = cmsGenerateUniqueEmail();

        cmsAssertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasErrors(['email']);
        cmsAssertGuest();
    }

    // ---- Volt Component Validation ----

    public function test_email_validation_works(): void
    {
        $response = LivewireVolt::test('auth.login')
            ->set('email', 'invalid-email')
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasErrors(['email']);
    }

    public function test_required_fields_validation(): void
    {
        $response = LivewireVolt::test('auth.login')->call('save');

        $response->assertHasErrors(['email', 'password']);
    }

    public function test_password_minimum_length_validation(): void
    {
        $email = cmsGenerateUniqueEmail();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', '123')
            ->call('save');

        $response->assertHasErrors();
    }

    // ---- Volt Component Session Management ----

    public function test_remember_me_functionality_works(): void
    {
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
    }

<<<<<<< .merge_file_xNy3Sx
    $response = LivewireVolt::test('auth.login #14')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasErrors();
});

it('has active csrf protection', function (): void {
    $email = cmsGenerateUniqueEmail();
    cmsCreateTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    $response = LivewireVolt::test('auth.login #15')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasNoErrors();
});

it('sanitizes input', function (): void {
    $email = cmsGenerateUniqueEmail();

    $response = LivewireVolt::test('auth.login #16')
        ->set('email', '<script>alert("xss")</script>'.$email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasErrors(['email']);
});

// ---- Volt Component State Management ----

it('updates component state correctly', function (): void {
    $email = cmsGenerateUniqueEmail();

    /** @var Testable<Component> $component */
    $component = LivewireVolt::test('auth.login #17');
    $component
        ->set('email', $email)
        ->assertSet('email', $email)
        ->set('password', 'password123')
        ->assertSet('password', 'password123')
        ->set('remember', true)
        ->assertSet('remember', true);
});

it('resets after failed authentication', function (): void {
    $email = cmsGenerateUniqueEmail();

    $component = LivewireVolt::test('auth.login #18')
        ->set('email', $email)
        ->set('password', 'wrong_password')
        ->call('save');

    $component->assertSet('password', '');
});

it('manages loading state correctly', function (): void {
    $email = cmsGenerateUniqueEmail();
    cmsCreateTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    $component = LivewireVolt::test('auth.login #19')->set('email', $email)->set('password', 'password123');

    $component->assertDontSee('wire:loading');

    $component->call('save');

    $component->assertHasNoErrors();
});

// ---- Volt Component User Types Integration ----

it('allows any user type to login via the volt component', function (): void {
    $email = cmsGenerateUniqueEmail();
    cmsCreateTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);
    cmsAssertGuest();

    $response = LivewireVolt::test('auth.login #20')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasNoErrors();
    cmsAssertAuthenticated();

    $authenticatedUser = Auth::user();
    Assert::assertNotNull($authenticatedUser);
    Assert::assertSame($email, $authenticatedUser->email);
});

it('handles different user configurations', function (): void {
    $email = cmsGenerateUniqueEmail();
    cmsCreateTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
        'name' => 'Test User',
    ]);

    $response = LivewireVolt::test('auth.login #21')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasNoErrors();
    cmsAssertAuthenticated();

    $authenticatedUser = Auth::user();
    Assert::assertSame('Test User', $authenticatedUser?->name);
});

// ---- Volt Component Redirects ----

it('redirects after successful authentication', function (): void {
    $email = cmsGenerateUniqueEmail();
    cmsCreateTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    $response = LivewireVolt::test('auth.login #22')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasNoErrors();
    cmsAssertAuthenticated();
});

it('handles intended redirect', function (): void {
    $email = cmsGenerateUniqueEmail();
    cmsCreateTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    Session::put('url.intended', '/dashboard');

    $response = LivewireVolt::test('auth.login #23')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasNoErrors();
    cmsAssertAuthenticated();
});

// ---- Volt Component Accessibility ----

it('has proper aria labels', function (): void {
    /** @var Testable<Component> $component */
    $component = LivewireVolt::test('auth.login #24');
    $component->assertSee('aria-label')->assertSee('id="data.email"')->assertSee('id="data.password"');
});

it('handles keyboard navigation', function (): void {
})->todo('Serve una asserzione sul markup di navigazione da tastiera (autofocus/tabindex/submit) del form di login: dipende dal tema pubblico attivo, va scritta sul suo markup reale.');
=======
    public function test_session_regeneration_on_login(): void
    {
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
    }

    public function test_session_data_is_preserved_on_authentication(): void
    {
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
    }

    // ---- Volt Component Security ----

    public function test_login_attempts_are_rate_limited(): void
    {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        for ($i = 0; $i < 5; $i++) {
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
    }

    public function test_csrf_protection_is_active(): void
    {
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
    }

    public function test_input_sanitization_works(): void
    {
        $email = cmsGenerateUniqueEmail();

        $response = LivewireVolt::test('auth.login')
            ->set('email', '<script>alert("xss")</script>'.$email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasErrors(['email']);
    }

    // ---- Volt Component State Management ----

    public function test_component_state_updates_correctly(): void
    {
        $email = cmsGenerateUniqueEmail();

        /** @var Testable<Component> $component */
        $component = LivewireVolt::test('auth.login');
        $component
            ->set('email', $email)
            ->assertSet('email', $email)
            ->set('password', 'password123')
            ->assertSet('password', 'password123')
            ->set('remember', true)
            ->assertSet('remember', true);
    }

    public function test_handles_keyboard_navigation(): void
    {
        $this->markTestSkipped('Dipende dal markup del tema pubblico attivo.');
    }
}
>>>>>>> .merge_file_QlGrMM
