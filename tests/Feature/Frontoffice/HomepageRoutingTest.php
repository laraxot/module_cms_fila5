<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
// Use the project's base TestCase

beforeEach(function (): void {
    /* @var Modules\Cms\Tests\TestCase $this */
    if (! Nwidart\Modules\Facades\Module::isEnabled('Cms')) {
        cmsSkipTest('Module Cms is disabled');
    }
});

it('redirects root / to /{locale}', function (): void {
    /** @var TestCase $this */
    /** @var TestCase $this */
    $locale = app()->getLocale();
    $response = $this->get('/');
    Assert::assertSame('/'.$locale, $response->headers->get('Location'));
});

it('serves localized homepage at /{locale}', function (): void {
    /** @var TestCase $this */
    /** @var TestCase $this */
    $locale = app()->getLocale();
    $response = $this->get('/'.$locale);
    Assert::assertSame(200, $response->status());
});
