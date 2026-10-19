<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\BaseModel;
use Modules\Cms\Models\Menu;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use PHPUnit\Framework\Assert;

use function Safe\class_implements;
use function Safe\class_uses;

use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Verifica il contratto pubblico del model Menu (navigazione gerarchica Sushi).
 */
final class MenuBusinessLogicTest extends TestCase
{
    public function testExtendsCmsBaseModel(): void
    {
        Assert::assertInstanceOf(BaseModel::class, new Menu());
    }

    public function testImplementsRecursiveRelationshipsContract(): void
    {
        Assert::assertTrue(in_array(HasRecursiveRelationshipsContract::class, class_implements(Menu::class), true));
    }

    public function testUsesRecursiveRelationshipsTrait(): void
    {
        Assert::assertArrayHasKey(HasRecursiveRelationships::class, class_uses(Menu::class));
    }

    public function testUsesSushiToJsonTrait(): void
    {
        Assert::assertArrayHasKey(SushiToJsons::class, class_uses(Menu::class));
    }

    public function testExposesExpectedFillableAttributes(): void
    {
        Assert::assertSame(['title', 'items', 'parent_id'], (new Menu())->getFillable());
    }

    public function testResolvesHumanReadableLabelFromTitle(): void
    {
        $menu = new Menu();
        $menu->title = 'Test Menu';

        Assert::assertSame('Test Menu', $menu->getLabel());
    }

    public function testCastsStructuredMenuItemsAsArray(): void
    {
        $casts = (new Menu())->getCasts();

        Assert::assertSame('array', $casts['items']);
        Assert::assertSame('string', $casts['id']);
    }

    public function testBuildsAdjacencyListTreeQueries(): void
    {
        Assert::assertInstanceOf(Builder::class, Menu::tree());
    }

    public function testCanFilterMenuNodesByDepth(): void
    {
        Assert::assertInstanceOf(Builder::class, Menu::whereDepth(1));
    }
}
