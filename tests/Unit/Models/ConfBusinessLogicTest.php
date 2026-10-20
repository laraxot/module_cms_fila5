<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\BaseModel;
use Modules\Cms\Models\Conf;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

use Sushi\Sushi;

/**
 * Verifica il contratto pubblico del model Conf (config tenant in-memory via Sushi).
 */
final class ConfBusinessLogicTest extends TestCase
{
    public function testExtendsCmsBaseModel(): void
    {
        Assert::assertInstanceOf(BaseModel::class, new Conf());
    }

    public function testUsesSushiTraitForInMemoryRows(): void
    {
        Assert::assertArrayHasKey(Sushi::class, class_uses(Conf::class));
    }

    public function testExposesExpectedFillableAttributes(): void
    {
        Assert::assertSame(['id', 'name'], (new Conf())->getFillable());
    }

    public function testUsesNameAsRouteKey(): void
    {
        Assert::assertSame('name', (new Conf())->getRouteKeyName());
    }
}
