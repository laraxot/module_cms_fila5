<?php

declare(strict_types=1);

use Modules\Cms\Filament\Pages\Themes;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('Themes page can be instantiated', function () {
<<<<<<< HEAD
    $page = new Themes;
=======
    $page = new Themes();
>>>>>>> laraxot/dev
});

test('Themes page has themes property', function () {
    $page = new Themes;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('themes');
    $property->setAccessible(true);

<<<<<<< HEAD
   Assert::assertIsArray($property->getValue($page));
});

test('Themes page has changePubTheme method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Themes page has getViewData method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');
=======
    Assert::assertIsArray($property->getValue($page));
});

test('Themes page has changePubTheme method', function () {
})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Themes page has getViewData method', function () {
})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');
<<<<<<< .merge_file_7dDDym
=======
>>>>>>> laraxot/dev
>>>>>>> .merge_file_EuDZ45
