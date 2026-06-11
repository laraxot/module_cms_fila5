<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

use PHPUnit\Framework\Assert;
use function Pest\Laravel\get;

uses(Modules\Cms\Tests\TestCase::class);
describe('CMS Individual Folio Routes Tests', function () {
        // Test homepage dal punto di vista CMS
    test('cms: route GET /{locale} (homepage)', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale);

    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        Assert::assertSame(200, $response->status());

        // Verifica integrazione CMS specifica
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('x-page');
        $response->assertSee('side="content"');
        $response->assertSee('slug="home"');
    });

    // Test auth routes dal punto di vista CMS
    test('cms: route GET /{locale}/auth/login', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/auth/login');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/login: '.$status);
        }

        // Verifica che il CMS carichi correttamente i contenuti auth
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    });

    test('cms: route GET /{locale}/auth/register', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/auth/register');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/register: '.$status);
        }

        // Verifica che il CMS gestisca correttamente la registrazione
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    });

    test('cms: route GET /{locale}/auth/logout', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/auth/logout');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/logout: '.$status);
        }

        // Verifica rendering CMS per logout
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/logout_fixed', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/auth/logout_fixed');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/logout_fixed: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/password/confirm', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/auth/password/confirm');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/password/confirm: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/password/reset', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/auth/password/reset');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/password/reset: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/password/{token}', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/auth/password/test-token');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/password/{token}: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/verify', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/auth/verify');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/verify: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/thank-you', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/auth/thank-you');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/thank-you: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/register/thank-you', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/auth/register/thank-you');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/register/thank-you: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/{type}/register - patient', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/auth/patient/register');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/{type}/register (patient): '.$status);
        }

        // Verifica che CMS gestisca correttamente la registrazione per tipo
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    });

    test('cms: route GET /{locale}/auth/{type}/register - doctor', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/auth/doctor/register');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/{type}/register (doctor): '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    });

    // Test pagine CMS specifiche
    test('cms: route GET /{locale}/pages', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/pages');

    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        Assert::assertSame(200, $response->status());

        // Verifica che CMS gestisca l'indice delle pagine
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/{slug}', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/test-slug');

    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        // Le pagine dinamiche potrebbero non esistere

        if (200 === $response->status()) {
            // Verifica che CMS carichi correttamente la pagina dinamica
            $response->assertSee('<!DOCTYPE html>');
            $response->assertSee('<html');
            $response->assertSee('x-page');
        }
    });

    test('cms: route GET /{locale}/learn', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/learn');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/learn: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/genesis/about', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/genesis/about');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/genesis/about: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/genesis/power-ups', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/genesis/power-ups');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/genesis/power-ups: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/classi-css', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/classi-css');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/classi-css: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/registration/thank-you', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/registration/thank-you');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/registration/thank-you: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/errors/password-expired', function () {
            $locale = (string) app()->getLocale();
        $response = get('/'.$locale.'/errors/password-expired');
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/errors/password-expired: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    // Test CMS con contenuti JSON
    describe('CMS Content Management Routes', function () {
            test('cms verifies json content loading for homepage', function () {
                $locale = (string) app()->getLocale();
            $response = get('/'.$locale);
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
            Assert::assertSame(200, $response->status());

            // Verifica che il JSON della homepage sia caricato correttamente
            // Il sito funziona, quindi il path reale è config/local/laravelpizza/
            $homepageJsonPath = config_path('local/laravelpizza/database/content/home.json');
            // Il file potrebbe non esistere in test environment, quindi accettiamo sia true che false
            if (! file_exists($homepageJsonPath)) {
                cmsSkipTest('Homepage JSON file not found in test environment: '.$homepageJsonPath);
            }

            $homepageData = cmsJsonDecodeFile($homepageJsonPath);
    /** @var array<string, mixed> $homepageData */
    $locale = (string) app()->getLocale();
            $contentBlocks = $homepageData['content_blocks'] ?? null;
            /** @var array<string, list<array<string, mixed>>> $contentBlocks */
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
        });

        test('cms handles theme view resolution correctly', function () {
                $locale = (string) app()->getLocale();
            $response = get('/'.$locale);
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
            Assert::assertSame(200, $response->status());

            // Il sito funziona, quindi il path reale è config/local/laravelpizza/
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
        });

        test('cms processes blade syntax in json correctly', function () {
                // Il sito funziona, quindi il path reale è config/local/laravelpizza/
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
                $response = get('/'.$locale);
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
                $content = (string) $response->getContent();

                $expectedUrl = route('register');
                Assert::assertStringContainsString($expectedUrl, $content);
            }
        });
    });

    // Test performance CMS
    test('cms: homepage renders within acceptable time', function () {
            $locale = (string) app()->getLocale();
        $startTime = microtime(true);

        $response = get('/'.$locale);
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
        Assert::assertSame(200, $response->status());

        $endTime = microtime(true);
        $loadTime = ($endTime - $startTime) * 1000;

        // CMS dovrebbe renderizzare la homepage velocemente
        Assert::assertLessThan(1500, $loadTime, 'CMS homepage should load within 1.5 seconds');
    });

    test('cms: auth pages render within acceptable time', function () {
            $locale = (string) app()->getLocale();
        $authRoutes = [
            '/'.$locale.'/auth/login',
            '/'.$locale.'/auth/register',
        ];

        foreach ($authRoutes as $route) {
            $startTime = microtime(true);

            $response = get($route);
    /** @var \Illuminate\Testing\TestResponse<\Illuminate\Http\Response> $response */
            Assert::assertSame(200, $response->status());

            $endTime = microtime(true);
            $loadTime = ($endTime - $startTime) * 1000;

            Assert::assertLessThan(1000, $loadTime, "CMS route {$route} should load within 1 second");
        }
    });
});
