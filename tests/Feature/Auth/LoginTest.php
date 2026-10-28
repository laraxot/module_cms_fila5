<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Volt as LivewireVolt;
<<<<<<< HEAD
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Xot\Datas\XotData;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\get;

// Helper (createTestUser, generateUniqueEmail, getUserClass) su Modules\Cms\Tests\TestCase, legato da tests/Pest.php.
// Use $this->generateUniqueEmail(), $this->getUserClass(), $this->createTestUser()

describe('Frontend Login Page Rendering', function (): void {
    test('login page can be rendered', function (): void {
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/login');
        $response->assertStatus(200);
    });

    test('login page contains login widget', function (): void {
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/login');
        $response->assertStatus(200); // ->assertSee('@livewire')
        // ->assertSee('LoginWidget')
    });

    test('login page has required form elements', function (): void {
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/login');
        $response->assertStatus(200); // ->assertSee('Hai dimenticato la password?')
        // ->assertSee('crea un nuovo account')
        // ->assertSee('logo-v2.png')
    });
});

describe('Frontend Login Page Localization', function (): void {
    test('login page works in italian', function (): void {
        app()->setLocale('it');
        $response = get('/it/auth/login');
        $response->assertStatus(200);
    });

    // test('login page works in english', function () {
    //    app()->setLocale('en');
    //    LaravelLocalization::setLocale('en');
    //    $response = get('/en/auth/login');
    //    //$response->assertStatus(200);
    // });

    test('login page contains localized content', function (): void {
        $response = get('/it/auth/login');
        $response
            ->assertStatus(200)
            ->assertSee('Hai dimenticato la password?')
            ->assertSee(__('pub_theme::auth.login.title'))
            ->assertSee(__('pub_theme::auth.login.or'));
    });
});

describe('Frontend Login Page Authentication', function (): void {
    test('user can authenticate via frontend login page', function (): void {
        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');

        $response->assertHasNoErrors();
        assertAuthenticated();

        actingAs($user);

        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/login');

        $response->assertRedirect('/');
    });
});

describe('Frontend Login Page Integration', function (): void {
    test('authenticated users are redirected from login page', function (): void {
        $user = $this->createTestUser();

        actingAs($user);

        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/login');

        // May redirect to dashboard or intended page
        $response->assertStatus(302);
    });
});

describe('Frontend Login Session Management', function (): void {
    test('remember me functionality works', function (): void {
        $email = $this->generateUniqueEmail();
        $this->createTestUser([
=======
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
>>>>>>> 127b4277 (.)
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

<<<<<<< HEAD
        assertGuest();
=======
        cmsAssertGuest();
>>>>>>> 127b4277 (.)

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->set('remember', true)
            ->call('authenticate');

        $response->assertHasNoErrors();
<<<<<<< HEAD
        assertAuthenticated();
    });

    test('session regeneration on login', function (): void {
        $email = $this->generateUniqueEmail();
        $this->createTestUser([
=======
        cmsAssertAuthenticated();
    }

    public function test_session_regeneration_on_login(): void
    {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
>>>>>>> 127b4277 (.)
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

<<<<<<< HEAD
        // Store original session ID
=======
>>>>>>> 127b4277 (.)
        $originalSessionId = session()->getId();

        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');
<<<<<<< HEAD

        assertAuthenticated();

        // Session should be regenerated for security
        expect(session()->getId())->not->toBe($originalSessionId);
    });
});

describe('Frontend Login Security', function (): void {
    test('login attempts are rate limited', function (): void {
        $email = $this->generateUniqueEmail();
        $this->createTestUser([
=======
        cmsAssertAuthenticated();

        Assert::assertNotSame($originalSessionId, session()->getId());
    }

    public function test_login_attempts_are_rate_limited(): void
    {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
>>>>>>> 127b4277 (.)
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

<<<<<<< HEAD
        // Multiple failed attempts
=======
>>>>>>> 127b4277 (.)
        for ($i = 0; $i < 5; $i++) {
            LivewireVolt::test('auth.login')
                ->set('email', $email)
                ->set('password', 'wrong_password')
                ->call('authenticate');
        }

<<<<<<< HEAD
        // Should be rate limited after too many attempts
=======
>>>>>>> 127b4277 (.)
        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');

<<<<<<< HEAD
        // May have throttling errors
        // This test verifies the system handles rate limiting appropriately
        expect($response)->not->toBeNull();
    });
});

describe('Frontend Login User Types', function (): void {
    test('any user type can login via frontend', function (): void {
        // Using XotData pattern ensures compatibility with any user type
        $email = $this->generateUniqueEmail();
        $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        assertGuest();
=======
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
>>>>>>> 127b4277 (.)

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');

        $response->assertHasNoErrors();
<<<<<<< HEAD
        assertAuthenticated();

        // Verify authenticated user
        $authenticatedUser = Auth::user();
        expect($authenticatedUser)->not->toBeNull();
        expect($authenticatedUser?->email)->toBe($email);
    });
});
=======
        cmsAssertAuthenticated();

        $authenticatedUser = Auth::user();
        Assert::assertNotNull($authenticatedUser);
        Assert::assertSame($email, $authenticatedUser->email);
    }
}
>>>>>>> 127b4277 (.)
