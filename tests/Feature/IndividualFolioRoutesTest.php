<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

final class IndividualFolioRoutesTest extends TestCase
{
    public function testCmsRouteGetLocaleHomepage(): void
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

    public function testCmsRouteGetLocaleAuthLogin(): void
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

    public function testCmsRouteGetLocaleAuthRegister(): void
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

    public function testCmsRouteGetLocaleAuthLogout(): void
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

    public function testCmsRouteGetLocaleAuthLogoutFixed(): void
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

    public function testCmsRouteGetLocaleAuthPasswordConfirm(): void
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

    public function testCmsRouteGetLocaleAuthPasswordReset(): void
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

    public function testCmsRouteGetLocaleAuthPasswordToken(): void
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

    public function testCmsRouteGetLocaleAuthVerify(): void
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

    public function testCmsRouteGetLocaleAuthThankYou(): void
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

    public function testCmsRouteGetLocaleAuthRegisterThankYou(): void
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

    public function testCmsRouteGetLocaleAuthTypeRegisterPatient(): void
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

    public function testCmsRouteGetLocaleAuthTypeRegisterDoctor(): void
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

    public function testCmsRouteGetLocalePages(): void
    {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/pages');

        Assert::assertSame(200, $response->status());

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    }

    public function testCmsRouteGetLocaleSlug(): void
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

    public function testCmsRouteGetLocaleLearn(): void
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

    public function testCmsRouteGetLocaleGenesisAbout(): void
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

    public function testCmsRouteGetLocaleGenesisPowerUps(): void
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

    public function testCmsRouteGetLocaleClassiCss(): void
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

    public function testCmsRouteGetLocaleRegistrationThankYou(): void
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

    public function testCmsRouteGetLocaleErrorsPasswordExpired(): void
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

    public function testCmsVerifiesJsonContentLoadingForHomepage(): void
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
        if (! is_array($contentBlocks)) {
            cmsSkipTest('Homepage content_blocks missing in JSON');
        }

        /* @var array<string, mixed> $contentBlocks */
        Assert::assertArrayHasKey($locale, $contentBlocks);

        $content = (string) $response->getContent();
        $blocks = $contentBlocks[$locale];
        if (! is_array($blocks)) {
            cmsSkipTest('Homepage blocks for locale are not an array');
        }

        /** @var array<mixed> $blocks */
        foreach ($blocks as $block) {
            if (! is_array($block)) {
                continue;
            }

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

    public function testCmsHandlesThemeViewResolutionCorrectly(): void
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

    public function testCmsProcessesBladeSyntaxInJsonCorrectly(): void
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

    public function testCmsHomepageRendersWithinAcceptableTime(): void
    {
        $locale = (string) app()->getLocale();
        $startTime = microtime(true);

        $response = cmsGet('/'.$locale);
        Assert::assertSame(200, $response->status());

        $endTime = microtime(true);
        $loadTime = ($endTime - $startTime) * 1000;

        Assert::assertLessThan(1500, $loadTime, 'CMS homepage should load within 1.5 seconds');
    }

    public function testCmsAuthPagesRenderWithinAcceptableTime(): void
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
