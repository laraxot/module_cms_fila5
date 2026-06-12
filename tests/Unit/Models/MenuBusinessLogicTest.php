<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\Menu;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

final class MenuBusinessLogicTest extends TestCase
{
    public function testMenuImplementsRecursiveRelationshipsContract(): void
    {
        $menu = new Menu();
        Assert::assertInstanceOf(HasRecursiveRelationshipsContract::class, $menu);
    }

    public function testMenuHasRecursiveRelationshipsTrait(): void
    {
        $traits = class_uses_recursive(Menu::class);

        Assert::assertContains(HasRecursiveRelationships::class, array_values($traits));
    }

    public function testMenuHasSushiToJsonTrait(): void
    {
        $traits = class_uses(Menu::class);

        Assert::assertArrayHasKey(SushiToJsons::class, $traits);
    }

    public function testMenuHasExpectedFillableFields(): void
    {
        $menu = new Menu();
        $expectedFillable = [
            'title',
            'items',
            'parent_id',
        ];

        Assert::assertEquals($expectedFillable, $menu->getFillable());
    }

    public function testMenuCanGetLabel(): void
    {
        $menu = new Menu();
        $menu->title = 'Test Menu';

        Assert::assertSame('Test Menu', $menu->getLabel());
    }

    public function testMenuHasCorrectCastsForStructuredData(): void
    {
        $menu = new Menu();
        $casts = $menu->getCasts();

        Assert::assertSame('array', $casts['items']);
        Assert::assertSame('string', $casts['id']);
    }

    public function testMenuHasSchemaDefinitionForStructuredData(): void
    {
        $menu = new Menu();

        $reflection = new \ReflectionClass($menu);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        /** @var array<string, mixed> $schema */
        $schema = $schemaProperty->getValue($menu);
        Assert::assertSame('string', $schema['title']);
        Assert::assertSame('integer', $schema['parent_id']);
    }

    public function testMenuCanBuildTreeQueries(): void
    {
        $query = Menu::tree();

        Assert::assertInstanceOf(Builder::class, $query);
    }

    public function testMenuCanQueryByDepth(): void
    {
        $query = Menu::whereDepth(1);

        Assert::assertInstanceOf(Builder::class, $query);
    }
}
