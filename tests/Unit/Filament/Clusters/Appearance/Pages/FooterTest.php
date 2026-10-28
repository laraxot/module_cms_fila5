<?php

declare(strict_types=1);

use Modules\Cms\Filament\Clusters\Appearance\Pages\Footer;
use PHPUnit\Framework\Assert;

test('Footer page can be instantiated', function () {
<<<<<<< HEAD
    Assert::assertSame(Footer::class, (new Footer)::class);

=======
    $page = new Footer;
>>>>>>> 127b4277 (.)
});

test('Footer page has data property', function () {
    $page = new Footer;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('data');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Footer page has footerData property', function () {
    $page = new Footer;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('footerData');
    $property->setAccessible(true);

    // Property exists but is null by default
    Assert::assertSame('footerData', $property->getName());
});

<<<<<<< HEAD
test('Footer page has mount method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Footer page has schema method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Footer page has updateData method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Footer page has fillForms method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Footer page has getUpdateFormActions method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');
=======
test('Footer page has mount method', function () {
    Assert::assertTrue((new ReflectionClass(Footer::class))->hasMethod('mount'));
});

test('Footer page has schema method', function () {
    Assert::assertTrue((new ReflectionClass(Footer::class))->hasMethod('schema'));
});

test('Footer page has updateData method', function () {
    Assert::assertTrue((new ReflectionClass(Footer::class))->hasMethod('updateData'));
});

test('Footer page has fillForms method', function () {
    Assert::assertTrue((new ReflectionClass(Footer::class))->hasMethod('fillForms'));
});

test('Footer page has getUpdateFormActions method', function () {
    Assert::assertTrue((new ReflectionClass(Footer::class))->hasMethod('getUpdateFormActions'));
});
>>>>>>> 127b4277 (.)
