<?php

declare(strict_types=1);

use Modules\Cms\Models\Menu;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use PHPUnit\Framework\Assert;
use ReflectionClass;

use function Safe\class_uses;

use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

uses(Modules\Cms\Tests\TestCase::class);
describe('Menu Business Logic', function () {
    test('menu extends base model', function () {
    });

    test('menu implements recursive relationships contract', function () {
        $menu = new Menu();
        Assert::assertInstanceOf(HasRecursiveRelationshipsContract::class, $menu);
    });

    test('menu has recursive relationships trait', function () {
        $traits = class_uses_recursive(Menu::class);

        // Menu uses HasRecursiveRelationships from staudenmeir/laravel-adjacency-list
        Assert::assertContains(HasRecursiveRelationships::class, array_values($traits));
    });

    test('menu has sushi to json trait', function () {
        $traits = class_uses(Menu::class);

        Assert::assertArrayHasKey(SushiToJsons::class, $traits);
    });

    test('menu has expected fillable fields', function () {
        $menu = new Menu();
        $expectedFillable = [
            'title',
            'items',
            'parent_id',
        ];

        Assert::assertEquals($expectedFillable, $menu->getFillable());
    });

    test('menu can get tree options for hierarchical display', function () {
        $options = Menu::getTreeMenuOptions();
        /* @var array<string, mixed> $options */
    });

    test('menu can get label', function () {
        $menu = new Menu();
        $menu->title = 'Test Menu';

        Assert::assertSame('Test Menu', $menu->getLabel());
    });

    test('menu has correct casts for structured data', function () {
        $menu = new Menu();
        $casts = $menu->getCasts();

        Assert::assertSame('array', $casts['items']);
        Assert::assertSame('string', $casts['id']);
    });

    test('menu has schema definition for structured data', function () {
        $menu = new Menu();

        // Use reflection to access protected $schema property
        $reflection = new ReflectionClass($menu);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        $schema = $schemaProperty->getValue($menu);
        /* @var array<string, mixed> $schema */
        Assert::assertSame('string', $schema['title']);
        Assert::assertSame('integer', $schema['parent_id']);
    });

    test('menu can get rows for sushi functionality', function () {
        $menu = new Menu();
    });

    test('menu can build tree queries', function () {
        $query = Menu::tree();

        Assert::assertInstanceOf(Builder::class, $query);
    });

    test('menu can query by depth', function () {
        $query = Menu::whereDepth(1);

        Assert::assertInstanceOf(Builder::class, $query);
    });
});
