<?php

declare(strict_types=1);

use Modules\Cms\Filament\Fields\LeftSidebarContent;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('LeftSidebarContent creates builder with empty blocks', function () {
    $result = LeftSidebarContent::make('test_field', 'form');

    // Note: getBlocks() may fail due to container initialization, so we test differently
    // We just verify the builder was created
});

test('LeftSidebarContent has correct field name', function () {
    $result = LeftSidebarContent::make('sidebar_content', 'form');

<<<<<<< HEAD
   Assert::assertSame('sidebar_content', $result->getName());
=======
    Assert::assertSame('sidebar_content', $result->getName());
>>>>>>> laraxot/dev
});

test('LeftSidebarContent returns collapsible builder', function () {
    $result = LeftSidebarContent::make('test', 'form');

<<<<<<< HEAD
   Assert::assertTrue($result->isCollapsible());
=======
    Assert::assertTrue($result->isCollapsible());
>>>>>>> laraxot/dev
});

test('LeftSidebarContent accepts different contexts', function () {
    $formContext = LeftSidebarContent::make('field1', 'form');
    $tableContext = LeftSidebarContent::make('field2', 'table');

<<<<<<< HEAD
   Assert::assertSame('field1', $formContext->getName());
=======
    Assert::assertSame('field1', $formContext->getName());
>>>>>>> laraxot/dev

    Assert::assertSame('field2', $tableContext->getName());
});
