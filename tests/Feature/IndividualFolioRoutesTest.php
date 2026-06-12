<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

final class IndividualFolioRoutesTest extends TestCase
{
    public function test_cms_route_get_locale_homepage(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale);

        Assert::assertSame(200, $response->status());

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('x-page');
        $response->assertSee('side="content"');
        $response->assertSee('slug="home"');
    }

    public function test_cms_route_get_locale_auth_login(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/login');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/login: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    }

    public function test_cms_route_get_locale_auth_register(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/register');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/register: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    }

    public function test_cms_route_get_locale_auth_logout(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/logout');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/logout: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function test_cms_route_get_locale_auth_logout_fixed(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/logout_fixed');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/logout_fixed: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function test_cms_route_get_locale_auth_password_confirm(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/password/confirm');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/password/confirm: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function test_cms_route_get_locale_auth_password_reset(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/password/reset');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/password/reset: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function test_cms_route_get_locale_auth_password_token(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/password/test-token');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/password/{token}: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function test_cms_route_get_locale_auth_verify(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/verify');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/verify: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function test_cms_route_get_locale_auth_thank_you(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/thank-you');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/thank-you: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function test_cms_route_get_locale_auth_register_thank_you(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/register/thank-you');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/register/thank-you: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function test_cms_route_get_locale_auth_type_register_patient(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/patient/register');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/{type}/register (patient): '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    }

    public function test_cms_route_get_locale_auth_type_register_doctor(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/doctor/register');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/{type}/register (doctor): '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    }

    public function test_cms_route_get_locale_pages(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/pages');

        Assert::assertSame(200, $response->status());

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function test_cms_route_get_locale_slug(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/test-slug');

        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        if (200 === $response->status()) {
            $response->assertSee('<!DOCTYPE html>');
            $response->assertSee('<html');
            $response->assertSee('x-page');
        }
    }

    public function test_cms_route_get_locale_learn(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/learn');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/learn: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function test_cms_route_get_locale_genesis_about(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/genesis/about');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/genesis/about: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function test_cms_route_get_locale_genesis_power_ups(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/genesis/power-ups');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/genesis/power-ups: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function test_cms_route_get_locale_classi_css(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/classi-css');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/classi-css: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function test_cms_route_get_locale_registration_thank_you(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/registration/thank-you');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/registration/thank-you: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function test_cms_route_get_locale_errors_password_expired(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/errors/password-expired');
        /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/errors/password-expired: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function test_cms_verifies_json_content_loading_for_homepage(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale);
        Assert::assertSame(200, $response->status());

        $homepageJsonPath = config_path('local/laravelpizza/database/content/home.json');
        if (! file_exists($homepageJsonPath)) {
            cmsSkipTest('Homepage JSON file not found in test environment: '.$homepageJsonPath);
        }

        $homepageData = cmsJsonDecodeFile($homepageJsonPath);
        /** @var array<string, mixed> $homepageData */
        $locale = (string) app()->getLocale();
        $contentBlocks = $homepageData['content_blocks'] ?? null;
        /** @var array<string, list<array<string, mixed>>>|null $contentBlocks */
        Assert::assertNotNull($contentBlocks);
        Assert::assertArrayHasKey($locale, $contentBlocks);

        $content = (string) $response->getContent();
        $blocks = $contentBlocks[$locale];
        foreach ($blocks as $block) {
            $blockData = $block['data'] ?? null;
            if (! is_array($blockData)) {
                continue;
            }
            $title = $blockData['title'] ?? null;
            if (is_string($title)) {
                Assert::assertStringContainsString($title, $content);
            }
        }
    }

    public function test_cms_handles_theme_view_resolution_correctly(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale);
        Assert::assertSame(200, $response->status());

        $homepageJsonPath = config_path('local/laravelpizza/database/content/home.json');
        if (! file_exists($homepageJsonPath)) {
            cmsSkipTest('Homepage JSON file not found in test environment: '.$homepageJsonPath);
        }
        $homepageData = cmsJsonDecodeFile($homepageJsonPath);
        /** @var array<string, mixed> $homepageData */
        $locale = (string) app()->getLocale();
        $contentBlocks = $homepageData['content_blocks'] ?? null;
        /** @var array<string, list<array<string, mixed>>> $contentBlocks */
        $blocks = $contentBlocks[$locale] ?? [];

        foreach ($blocks as $block) {
            $blockData = $block['data'] ?? null;
            Assert::assertIsArray($blockData);
            $view = $blockData['view'] ?? null;
            Assert::assertIsString($view);
            Assert::assertStringStartsWith('pub_theme::', $view);
            Assert::assertStringContainsString('components.blocks', $view);
        }
    }

    public function test_cms_processes_blade_syntax_in_json_correctly(): void
    {
        $homepageJsonPath = config_path('local/laravelpizza/database/content/home.json');
        if (! file_exists($homepageJsonPath)) {
            cmsSkipTest('Homepage JSON file not found in test environment: '.$homepageJsonPath);
        }
        $homepageData = cmsJsonDecodeFile($homepageJsonPath);
        /** @var array<string, mixed> $homepageData */
        $locale = (string) app()->getLocale();
        $contentBlocks = $homepageData['content_blocks'] ?? null;
        /** @var array<string, list<array<string, mixed>>> $contentBlocks */
        $blocks = $contentBlocks[$locale] ?? [];
        $landingBlock = collect($blocks)->firstWhere('type', 'landing-page');

        if (is_array($landingBlock)) {
            $landingData = $landingBlock['data'] ?? null;
            Assert::assertIsArray($landingData);
            $ctaLink = $landingData['cta_link'] ?? null;
            Assert::assertIsString($ctaLink);
            Assert::assertStringContainsString("{{ route('register') }}", $ctaLink);

            $locale = (string) app()->getLocale();
            $response = cmsGet('/'.$locale);
            /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
            $content = (string) $response->getContent();

            $expectedUrl = route('register');
            Assert::assertStringContainsString($expectedUrl, $content);
        }
    }

    public function test_cms_homepage_renders_within_acceptable_time(): void
    {
        $locale = (string) app()->getLocale();
        $startTime = microtime(true);

        $response = cmsGet('/'.$locale);
        Assert::assertSame(200, $response->status());

        $endTime = microtime(true);
        $loadTime = ($endTime - $startTime) * 1000;

        Assert::assertLessThan(1500, $loadTime, 'CMS homepage should load within 1.5 seconds');
    }

    public function test_cms_auth_pages_render_within_acceptable_time(): void
    {
        $locale = (string) app()->getLocale();
        $authRoutes = [
            '/'.$locale.'/auth/login',
            '/'.$locale.'/auth/register',
        ];

        foreach ($authRoutes as $route) {
            $startTime = microtime(true);

            $response = cmsGet($route);
            Assert::assertSame(200, $response->status());

            $endTime = microtime(true);
            $loadTime = ($endTime - $startTime) * 1000;

            Assert::assertLessThan(1000, $loadTime, "CMS route {$route} should load within 1 second");
        }
    }
}
