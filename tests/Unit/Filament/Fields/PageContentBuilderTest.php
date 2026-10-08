<?php

declare(strict_types=1);

use Filament\Forms\Components\Builder;
use Modules\Cms\Filament\Fields\PageContentBuilder;
use PHPUnit\Framework\Assert;

test('PageContentBuilder can be instantiated', function () {
    $field = PageContentBuilder::make('content');

    Assert::assertInstanceOf(Builder::class, $field);
    Assert::assertSame('content', $field->getName());
});
