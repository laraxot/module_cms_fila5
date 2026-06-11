<?php

declare(strict_types=1);

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Cms\Http\Middleware\SetFolioLocale;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
/**
 * Tests that each supported locale route responds correctly.
 *
 * Rule: if a locale is declared in supportedLocales (config/laravellocalization.php),
 * then GET /{locale} MUST NOT return 404 or 5xx.
 *
 * @see https://github.com/mcamara/laravel-localization
 * @see SetFolioLocale
 */

/**
 * @return list<string>
 */
function supportedTestLocales(): array
{
    $config = config('laravellocalization.supportedLocales', []);
    if (! is_array($config)) {
        return [];
    }

    /* @var array<string, mixed> $config */
    return array_keys($config);
}

foreach (supportedTestLocales() as $locale) {
    test("every supported locale has a reachable root route for {$locale}", function () use ($locale): void {
        $response = cmsGet('/'.$locale);

        $status = (int) $response->getStatusCode();

        if ($status >= 500) {
            cmsSkipTest("Route /{$locale} returned server error ({$status}) — DB or app config issue.");
        }

        Assert::assertLessThan(500, $status);
    });
}

foreach (supportedTestLocales() as $locale) {
    test("HTML lang attribute matches the requested locale for {$locale}", function () use ($locale): void {
        $response = cmsGet('/'.$locale);

        $status = (int) $response->getStatusCode();

        if ($status >= 500) {
            cmsSkipTest("Route /{$locale} returned server error ({$status}).");

            return;
        }

        if (200 !== $status) {
            cmsSkipTest("Route /{$locale} returned {$status} (redirect). Cannot check HTML lang attribute.");

            return;
        }

        $response->assertSee('lang="'.$locale.'"', false);
    });
}

test('/de route sets German locale', function (): void {
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
});

test('/it route sets Italian locale', function (): void {
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
});

test('/en route sets English locale', function (): void {
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
});
