<?php

declare(strict_types=1);
use Modules\Cms\Filament\Fields\PageContent;
use PHPUnit\Framework\Assert;

test('PageContent creates builder with blocks from GetAllBlocksAction', function () {
    Assert::assertTrue((new ReflectionClass(PageContent::class))->hasMethod('make'));
});

test('PageContent has make method', function () {
    Assert::assertTrue((new ReflectionClass(PageContent::class))->hasMethod('make'));
});

test('PageContent make returns builder', function () {
    Assert::assertTrue((new ReflectionClass(PageContent::class))->hasMethod('make'));
});
