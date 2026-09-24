<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

final class LoginTest extends TestCase
{
    public function test_login_page_can_be_rendered(): void
    {
        $locale = app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/login');
        Assert::assertSame(200, $response->status());
    }

    public function test_login_page_contains_login_widget(): void
    {
        $locale = app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/login');
        Assert::assertSame(200, $response->status());
    }

    public function test_login_page_has_required_form_elements(): void
    {
        $locale = app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/login');
        Assert::assertSame(200, $response->status());
    }

    public function test_login_page_works_in_italian(): void
    {
        app()->setLocale('it');
        $response = cmsGet('/it/auth/login');
        Assert::assertSame(200, $response->status());
    }

    public function test_login_page_contains_localized_content(): void
    {
        $response = cmsGet('/it/auth/login');
        $response
            ->assertStatus(200)
            ->assertSee('Hai dimenticato la password?')
            ->assertSee(__('pub_theme::auth.login.title'))
            ->assertSee(__('pub_theme::auth.login.or'));
    }

    public function test_user_can_authenticate_via_frontend_login_page(): void
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
            ->call('authenticate');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();

        $this->actingAs($user);

        $locale = app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/login');

        Assert::assertSame('/', $response->headers->get('Location'));
    }

    public function test_authenticated_users_are_redirected_from_login_page(): void
    {
        $user = cmsCreateTestUser();

        $this->actingAs($user);

        $locale = app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/login');

        Assert::assertSame(302, $response->status());
    }

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
            ->call('authenticate');

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
            ->call('authenticate');
        cmsAssertAuthenticated();

        Assert::assertNotSame($originalSessionId, session()->getId());
    }

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
                ->call('authenticate');
        }

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');

        Assert::assertNull($response);
    }

    public function test_any_user_type_can_login_via_frontend(): void
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
            ->call('authenticate');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();

        $authenticatedUser = Auth::user();
        Assert::assertNotNull($authenticatedUser);
        Assert::assertSame($email, $authenticatedUser->email);
    }
}
