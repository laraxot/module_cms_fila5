<?php

declare(strict_types=1);

use ReflectionClass;
use PHPUnit\Framework\Assert;
use Modules\Cms\Filament\Pages\Themes;


uses(Modules\Cms\Tests\TestCase::class);
test('Themes page can be instantiated', function () {
    $page = new Themes();

});

test('Themes page has themes property', function () {
    $page = new Themes();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('themes');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Themes page has changePubTheme method', function () {
    });

test('Themes page has getViewData method', function () {
    });
