<?php

declare(strict_types=1);

use Modules\Cms\Filament\Front\Pages\Home;
use PHPUnit\Framework\Assert;

test('Home page can be instantiated', function () {
<<<<<<< HEAD
    Assert::assertSame(Home::class, (new Home)::class);

=======
    $page = new Home;
>>>>>>> 127b4277 (.)
});

test('Home page has view_type property', function () {
    $page = new Home;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('view_type');
    $property->setAccessible(true);

    Assert::assertSame('view_type', $property->getName());
});

test('Home page has containers property', function () {
    $page = new Home;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('containers');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Home page has items property', function () {
    $page = new Home;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('items');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

<<<<<<< HEAD
test('Home page has mount method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Home page has getViewData method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Home page has initView method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');
=======
test('Home page has mount method', function () {
    Assert::assertTrue((new ReflectionClass(Home::class))->hasMethod('mount'));
});

test('Home page has getViewData method', function () {
    Assert::assertTrue((new ReflectionClass(Home::class))->hasMethod('getViewData'));
});

test('Home page has initView method', function () {
    Assert::assertTrue((new ReflectionClass(Home::class))->hasMethod('initView'));
});
>>>>>>> 127b4277 (.)

test('Home page has url method', function () {})->todo();
