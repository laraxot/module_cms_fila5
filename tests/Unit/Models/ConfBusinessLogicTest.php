<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\Conf;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Sushi\Sushi;
<<<<<<< HEAD

use function Safe\class_uses;

/**
 * Verifica il contratto pubblico del model Conf (config tenant in-memory via Sushi).
 */
final class ConfBusinessLogicTest extends TestCase
{
    public function test_extends_cms_base_model(): void {}

    public function test_uses_sushi_trait_for_in_memory_rows(): void
    {
        Assert::assertArrayHasKey(Sushi::class, class_uses(Conf::class));
    }
=======

use function Safe\class_parents;
use function Safe\class_uses;

describe('Conf Business Logic', function (): void {
    test('conf extends eloquent model', function (): void {
        Assert::assertContains(Model::class, array_values(class_parents(Conf::class)));
    });
>>>>>>> 127b4277 (.)

    public function test_exposes_expected_fillable_attributes(): void
    {
        Assert::assertSame(['id', 'name'], (new Conf)->getFillable());
    }

<<<<<<< HEAD
    public function test_uses_name_as_route_key(): void
    {
        Assert::assertSame('name', (new Conf)->getRouteKeyName());
    }
}
=======
        Assert::assertArrayHasKey(Sushi::class, $traits);
    });

    test('conf has expected fillable fields', function (): void {
        $conf = new Conf;
        $expectedFillable = [
            'id',
            'name',
        ];

        Assert::assertEquals($expectedFillable, $conf->getFillable());
    });

    test('conf uses name as route key', function (): void {
        $conf = new Conf;

        Assert::assertSame('name', $conf->getRouteKeyName());
    });

    test('conf can get rows from tenant service', function (): void {
        $conf = new Conf;

        Assert::assertNotEmpty($conf->getRows());
    });
});
>>>>>>> 127b4277 (.)
