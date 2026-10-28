<?php

declare(strict_types=1);

use Modules\Cms\Filament\Pages\Themes;
use PHPUnit\Framework\Assert;

test('Themes page can be instantiated', function () {
<<<<<<< HEAD
    Assert::assertSame(Themes::class, (new Themes)::class);

=======
    $page = new Themes;
>>>>>>> 127b4277 (.)
});

test('Themes page has themes property', function () {
    $page = new Themes;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('themes');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

<<<<<<< HEAD
test('Themes page has changePubTheme method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Themes page has getViewData method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');
=======
test('Themes page has changePubTheme method', function () {
    Assert::assertTrue((new ReflectionClass(Themes::class))->hasMethod('changePubTheme'));
});

test('Themes page has getViewData method', function () {
    Assert::assertTrue((new ReflectionClass(Themes::class))->hasMethod('getViewData'));
});
>>>>>>> 127b4277 (.)
