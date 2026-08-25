<?php

declare(strict_types=1);

use Modules\Cms\Filament\Front\Pages\Welcome;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('Welcome page can be instantiated', function () {
<<<<<<< HEAD
    $page = new Welcome;
=======
    $page = new Welcome();
>>>>>>> laraxot/dev
});

test('Welcome page has view_type property', function () {
    $page = new Welcome;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('view_type');
    $property->setAccessible(true);

<<<<<<< HEAD
   Assert::assertSame('view_type', $property->getName());
=======
    Assert::assertSame('view_type', $property->getName());
>>>>>>> laraxot/dev
});

test('Welcome page has containers property', function () {
    $page = new Welcome;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('containers');
    $property->setAccessible(true);

<<<<<<< HEAD
   Assert::assertIsArray($property->getValue($page));
=======
    Assert::assertIsArray($property->getValue($page));
>>>>>>> laraxot/dev
});

test('Welcome page has items property', function () {
    $page = new Welcome;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('items');
    $property->setAccessible(true);

<<<<<<< HEAD
   Assert::assertIsArray($property->getValue($page));
=======
    Assert::assertIsArray($property->getValue($page));
>>>>>>> laraxot/dev
});

test('Welcome page has instanceModel property', function () {
    $page = new Welcome;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('instanceModel');
    $property->setAccessible(true);

<<<<<<< HEAD
   Assert::assertSame('instanceModel', $property->getName());
});

test('Welcome page has mount method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Welcome page has getViewData method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Welcome page has initView method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');
=======
    Assert::assertSame('instanceModel', $property->getName());
});

test('Welcome page has mount method', function () {
})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Welcome page has getViewData method', function () {
})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Welcome page has initView method', function () {
})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');
>>>>>>> laraxot/dev

// Rimossi `test('Welcome page has url method')` e `test('... setModel method')`: le
// closure erano vuote e nessuno dei due metodi esiste. `Welcome` dichiara solo `mount`,
// `getViewData` e `initView`; la catena `XotBasePage` -> `Filament\Pages\Page` espone
// `getUrl()` statico, non `url()`, e non ha `setModel()`. Riempirli li avrebbe resi
// rossi, rinominarli sarebbe stato inventare l'intento.
