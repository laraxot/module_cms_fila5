<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Cms\Models\Conf;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;
<<<<<<< HEAD
use Sushi\Sushi;

use function Safe\class_uses;

=======

use function Safe\class_uses;

use Sushi\Sushi;

>>>>>>> laraxot/dev
uses(TestCase::class);
describe('Conf Business Logic', function (): void {
    test('conf extends eloquent model', function (): void {
        Assert::assertTrue(
            (new ReflectionClass(Conf::class))->isSubclassOf(Model::class),
        );
    });

    test('conf uses sushi trait for in-memory data', function (): void {
        $traits = class_uses(Conf::class);

<<<<<<< HEAD
       Assert::assertArrayHasKey(Sushi::class, $traits);
=======
        Assert::assertArrayHasKey(Sushi::class, $traits);
>>>>>>> laraxot/dev
    });

    test('conf has expected fillable fields', function (): void {
        $conf = new Conf;
        $expectedFillable = [
            'id',
            'name',
        ];

<<<<<<< HEAD
       Assert::assertEquals($expectedFillable, $conf->getFillable());
=======
        Assert::assertEquals($expectedFillable, $conf->getFillable());
>>>>>>> laraxot/dev
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
