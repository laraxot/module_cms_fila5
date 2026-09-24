<?php

declare(strict_types=1);

use Modules\Cms\Filament\Front\Pages\Welcome;
use PHPUnit\Framework\Assert;

test('Welcome page can be instantiated', function () {
    $page = new Welcome;
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

test('Welcome page has mount method', function () {
    Assert::assertTrue((new ReflectionClass(Welcome::class))->hasMethod('mount'));
});

test('Welcome page has getViewData method', function () {
    Assert::assertTrue((new ReflectionClass(Welcome::class))->hasMethod('getViewData'));
});

test('Welcome page has initView method', function () {
    Assert::assertTrue((new ReflectionClass(Welcome::class))->hasMethod('initView'));
});

test('Welcome page has url method', function () {})->todo();

test('Welcome page has setModel method', function () {})->todo();
