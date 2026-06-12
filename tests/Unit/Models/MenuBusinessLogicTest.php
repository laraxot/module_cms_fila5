<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\Menu;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

use function Safe\class_uses;

final class MenuBusinessLogicTest extends TestCase
{
    public function test_menu_implements_recursive_relationships_contract(): void
    {
        $menu = new Menu();
        Assert::assertInstanceOf(HasRecursiveRelationshipsContract::class, $menu);
    }

    public function test_menu_has_recursive_relationships_trait(): void
    {
        $traits = class_uses_recursive(Menu::class);

        Assert::assertContains(HasRecursiveRelationships::class, array_values($traits));
    }

    public function test_menu_has_sushi_to_json_trait(): void
    {
        $traits = class_uses(Menu::class);

        Assert::assertArrayHasKey(SushiToJsons::class, $traits);
    }

    public function test_menu_has_expected_fillable_fields(): void
    {
        $menu = new Menu();
        $expectedFillable = [
            'title',
            'items',
            'parent_id',
        ];

        Assert::assertEquals($expectedFillable, $menu->getFillable());
    }

    public function test_menu_can_get_label(): void
    {
        $menu = new Menu();
        $menu->title = 'Test Menu';

        Assert::assertSame('Test Menu', $menu->getLabel());
    }

    public function test_menu_has_correct_casts_for_structured_data(): void
    {
        $menu = new Menu();
        $casts = $menu->getCasts();

        Assert::assertSame('array', $casts['items']);
        Assert::assertSame('string', $casts['id']);
    }

    public function test_menu_has_schema_definition_for_structured_data(): void
    {
        $menu = new Menu();

        $reflection = new ReflectionClass($menu);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        /** @var array<string, mixed> $schema */
        $schema = $schemaProperty->getValue($menu);
        Assert::assertSame('string', $schema['title']);
        Assert::assertSame('integer', $schema['parent_id']);
    }

    public function test_menu_can_build_tree_queries(): void
    {
        $query = Menu::tree();

        Assert::assertInstanceOf(Builder::class, $query);
    }

    public function test_menu_can_query_by_depth(): void
    {
        $query = Menu::whereDepth(1);

        Assert::assertInstanceOf(Builder::class, $query);
    }
}
