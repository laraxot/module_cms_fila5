<?php

declare(strict_types=1);

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Modules\Cms\Filament\Clusters\Appearance\Pages\Headernav;
use PHPUnit\Framework\Assert;

use function Safe\class_implements;

test('Headernav page can be instantiated', function () {
<<<<<<< HEAD
    Assert::assertSame(Headernav::class, (new Headernav)::class);

=======
    $page = new Headernav;
>>>>>>> 127b4277 (.)
});

test('Headernav page has data property', function () {
    $page = new Headernav;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('data');
    $property->setAccessible(true);

    /** @var array<string, mixed> $dataValue */
    $dataValue = $property->getValue($page);
    Assert::assertArrayHasKey('sections', $dataValue);
});

test('Headernav page has headernavData property', function () {
    $page = new Headernav;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('headernavData');
    $property->setAccessible(true);

    Assert::assertSame('headernavData', $property->getName());
});

<<<<<<< HEAD
test('Headernav page has mount method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Headernav page has schema method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Headernav page has updateData method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Headernav page has fillForms method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Headernav page has getUpdateFormActions method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');
=======
test('Headernav page has mount method', function () {
    Assert::assertTrue((new ReflectionClass(Headernav::class))->hasMethod('mount'));
});

test('Headernav page has schema method', function () {
    Assert::assertTrue((new ReflectionClass(Headernav::class))->hasMethod('schema'));
});

test('Headernav page has updateData method', function () {
    Assert::assertTrue((new ReflectionClass(Headernav::class))->hasMethod('updateData'));
});

test('Headernav page has fillForms method', function () {
    Assert::assertTrue((new ReflectionClass(Headernav::class))->hasMethod('fillForms'));
});

test('Headernav page has getUpdateFormActions method', function () {
    Assert::assertTrue((new ReflectionClass(Headernav::class))->hasMethod('getUpdateFormActions'));
});
>>>>>>> 127b4277 (.)

test('Headernav page implements HasForms', function () {
    $interfaces = class_implements(Headernav::class);
    Assert::assertContains(HasForms::class, $interfaces);
});

test('Headernav page uses InteractsWithForms trait', function () {
    $reflection = new ReflectionClass(Headernav::class);
    $traits = $reflection->getTraitNames();
    Assert::assertContains(InteractsWithForms::class, $traits);
});
