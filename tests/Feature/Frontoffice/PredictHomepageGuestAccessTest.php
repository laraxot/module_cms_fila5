<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice;

use Illuminate\Support\Facades\Auth;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

final class PredictHomepageGuestAccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        cmsSkipTest('Predict.local homepage tests not applicable to fixcity install.');
    }

    public function testServesItForGuestsOnPredictLocalWithoutRequiringLogin(): void
    {
        Assert::assertFalse(Auth::check());

        $response = $this->get('/it');

        $response->assertOk();
        $response->assertDontSee('http-equiv="refresh"', false);
        $response->assertSee('<html', false);
        $response->assertSee('lang="it"', false);
    }

    public function testReturnsAnEmptySliderDatasetInsteadOfCrashingWhenPredictBannersAreUnavailable(): void
    {
        if (! class_exists('Modules\\Predict\\View\\Composers\\ThemeComposer')) {
            cmsSkipTest('Predict ThemeComposer not available');
        }

        /** @var object $composer */
        $composer = app('Modules\\Predict\\View\\Composers\\ThemeComposer');
        Assert::assertIsObject($composer);
        Assert::assertTrue(method_exists($composer, 'getMethodData'));

        /** @var array<string, mixed> $data */
        $data = $composer->getMethodData('getBanner');
        Assert::assertIsArray($data);
    }
}
