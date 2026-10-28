<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\Menu;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use PHPUnit\Framework\Assert;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

<<<<<<< HEAD
use function Safe\class_implements;
use function Safe\class_uses;

/**
 * Verifica il contratto pubblico del model Menu (navigazione gerarchica Sushi).
 */
final class MenuBusinessLogicTest extends TestCase
{
    public function test_extends_cms_base_model(): void {}

    public function test_implements_recursive_relationships_contract(): void
    {
        Assert::assertTrue(in_array(HasRecursiveRelationshipsContract::class, class_implements(Menu::class), true));
    }

    public function test_uses_recursive_relationships_trait(): void
    {
        Assert::assertArrayHasKey(HasRecursiveRelationships::class, class_uses(Menu::class));
    }

    public function test_uses_sushi_to_json_trait(): void
    {
        Assert::assertArrayHasKey(SushiToJsons::class, class_uses(Menu::class));
    }
=======
use function Safe\class_uses;

describe('Menu Business Logic', function (): void {
    test('menu implements recursive relationships contract', function (): void {
        $menu = new Menu;
        Assert::assertInstanceOf(HasRecursiveRelationshipsContract::class, $menu);
    });

    test('menu has recursive relationships trait', function (): void {
        $traits = class_uses_recursive(Menu::class);

        Assert::assertContains(HasRecursiveRelationships::class, array_values($traits));
    });

    test('menu has sushi to json trait', function (): void {
        $traits = class_uses(Menu::class);

        Assert::assertArrayHasKey(SushiToJsons::class, $traits);
    });

    test('menu has expected fillable fields', function (): void {
        $menu = new Menu;
        $expectedFillable = [
            'title',
            'items',
            'parent_id',
        ];
>>>>>>> 127b4277 (.)

    public function test_exposes_expected_fillable_attributes(): void
    {
        Assert::assertSame(['title', 'items', 'parent_id'], (new Menu)->getFillable());
    }

<<<<<<< HEAD
    public function test_resolves_human_readable_label_from_title(): void
    {
=======
    test('menu can get label', function (): void {
>>>>>>> 127b4277 (.)
        $menu = new Menu;
        $menu->title = 'Test Menu';

        Assert::assertSame('Test Menu', $menu->getLabel());
    }

<<<<<<< HEAD
    public function test_casts_structured_menu_items_as_array(): void
    {
        $casts = (new Menu)->getCasts();
=======
    test('menu has correct casts for structured data', function (): void {
        $menu = new Menu;
        $casts = $menu->getCasts();
>>>>>>> 127b4277 (.)

        Assert::assertSame('array', $casts['items']);
        Assert::assertSame('string', $casts['id']);
    }

<<<<<<< HEAD
    public function test_builds_adjacency_list_tree_queries(): void
    {
        Assert::assertInstanceOf(Builder::class, Menu::tree());
    }
=======
    test('menu has schema definition for structured data', function (): void {
        $menu = new Menu;
>>>>>>> 127b4277 (.)

    public function test_can_filter_menu_nodes_by_depth(): void
    {
        Assert::assertInstanceOf(Builder::class, Menu::whereDepth(1));
    }
}
