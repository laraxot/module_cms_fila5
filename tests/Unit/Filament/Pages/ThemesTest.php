<?php

declare(strict_types=1);

use Modules\Cms\Filament\Pages\Themes;
use PHPUnit\Framework\Assert;

test('Themes page can be instantiated', function () {
    $page = new Themes;
});

test('Themes page has themes property', function () {
    $page = new Themes;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('themes');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Themes page has changePubTheme method', function () {
    Assert::assertTrue((new ReflectionClass(Themes::class))->hasMethod('changePubTheme'));
});

test('Themes page has getViewData method', function () {
    Assert::assertTrue((new ReflectionClass(Themes::class))->hasMethod('getViewData'));
});
