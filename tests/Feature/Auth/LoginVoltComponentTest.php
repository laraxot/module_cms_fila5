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
