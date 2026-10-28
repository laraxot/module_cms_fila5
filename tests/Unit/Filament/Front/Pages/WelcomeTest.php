<?php

declare(strict_types=1);

use Modules\Cms\Filament\Front\Pages\Welcome;
use PHPUnit\Framework\Assert;

test('Welcome page can be instantiated', function () {
    Assert::assertSame(Welcome::class, (new Welcome)::class);

});

test('Welcome page has view_type property', function () {
    $page = new Welcome;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('view_type');
    $property->setAccessible(true);

    Assert::assertSame('view_type', $property->getName());
});

test('Welcome page has containers property', function () {
    $page = new Welcome;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('containers');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Welcome page has items property', function () {
    $page = new Welcome;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('items');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Welcome page has instanceModel property', function () {
    $page = new Welcome;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('instanceModel');
    $property->setAccessible(true);

    Assert::assertSame('instanceModel', $property->getName());
});

test('Welcome page has mount method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');
<<<<<<< .merge_file_OIdqeY

test('Welcome page has getViewData method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Welcome page has initView method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');
=======

test('Welcome page has getViewData method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Welcome page has initView method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Welcome page has url method', function () {})->todo();
>>>>>>> .merge_file_iYevIa

test('Welcome page has setModel method', function () {})->todo();
