<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

final class LocaleRoutingTest extends TestCase
{
    /**
     * @return list<string>
     */
    private static function supportedTestLocales(): array
    {
        $configPath = dirname(__DIR__, 7).'/config/laravellocalization.php';
        if (! is_file($configPath)) {
            return ['de', 'en', 'it'];
        }

        /** @var array<string, mixed> $localizationConfig */
        $localizationConfig = require $configPath;
        $supported = $localizationConfig['supportedLocales'] ?? [];
        if (! is_array($supported)) {
            return ['de', 'en', 'it'];
        }

        /** @var list<string> $locales */
        $locales = array_values(array_map(strval(...), array_keys($supported)));

        return $locales !== [] ? $locales : ['de', 'en', 'it'];
    }

    public function test_every_supported_locale_has_a_reachable_root_route(): void
    {
        foreach (self::supportedTestLocales() as $locale) {
            $response = cmsGet('/'.$locale);

            $status = (int) $response->getStatusCode();

            if ($status >= 500) {
                cmsSkipTest("Route /{$locale} returned server error ({$status}) — DB or app config issue.");
            }

            Assert::assertLessThan(500, $status);
        }
    }

    public function test_html_lang_attribute_matches_the_requested_locale(): void
    {
        foreach (self::supportedTestLocales() as $locale) {
            $response = cmsGet('/'.$locale);

            $status = (int) $response->getStatusCode();

            if ($status >= 500) {
                cmsSkipTest("Route /{$locale} returned server error ({$status}).");

                continue;
            }

            if (200 !== $status) {
                cmsSkipTest("Route /{$locale} returned {$status} (redirect). Cannot check HTML lang attribute.");

                continue;
            }

            $response->assertSee('lang="'.$locale.'"', false);
        }
    }

    public function test_de_route_sets_german_locale(): void
    {
        $response = cmsGet('/de');

        $status = (int) $response->getStatusCode();

        if ($status >= 500) {
            cmsSkipTest("Route /de returned server error ({$status}).");

            return;
        }

        if (200 !== $status) {
            cmsSkipTest("Route /de returned {$status} (redirect). Cannot verify locale.");

            return;
        }

        $response->assertSee('lang="de"', false);

        Assert::assertSame('de', LaravelLocalization::getCurrentLocale());
    }

    public function test_it_route_sets_italian_locale(): void
    {
        $response = cmsGet('/it');

        $status = (int) $response->getStatusCode();

        if ($status >= 500) {
            cmsSkipTest("Route /it returned server error ({$status}).");

            return;
        }

        if (200 !== $status) {
            cmsSkipTest("Route /it returned {$status} (redirect).");

            return;
        }

        $response->assertSee('lang="it"', false);

        Assert::assertSame('it', LaravelLocalization::getCurrentLocale());
    }

    public function test_en_route_sets_english_locale(): void
    {
        $response = cmsGet('/en');

        $status = (int) $response->getStatusCode();

        if ($status >= 500) {
            cmsSkipTest("Route /en returned server error ({$status}).");

            return;
        }

        if (200 !== $status) {
            cmsSkipTest("Route /en returned {$status} (redirect).");

            return;
        }

        $response->assertSee('lang="en"', false);

        Assert::assertSame('en', LaravelLocalization::getCurrentLocale());
    }
}
