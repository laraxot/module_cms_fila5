<?php

declare(strict_types=1);

use Modules\Cms\Models\Conf;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('Conf model can be instantiated', function () {
    $conf = new Conf();

    Assert::assertInstanceOf(Conf::class, $conf);
});

test('Conf model has expected fillable fields', function () {
    $conf = new Conf();

    $fillable = $conf->getFillable();

<<<<<<< HEAD
   Assert::assertContains('id', $fillable);
=======
    Assert::assertContains('id', $fillable);
>>>>>>> laraxot/dev

    Assert::assertContains('name', $fillable);
});

test('Conf model has name as route key', function () {
    $conf = new Conf();

<<<<<<< HEAD
   Assert::assertSame('name', $conf->getRouteKeyName());
=======
    Assert::assertSame('name', $conf->getRouteKeyName());
>>>>>>> laraxot/dev
});

test('Conf model uses Sushi trait', function () {
    $reflection = new ReflectionClass(Conf::class);
    $traits = $reflection->getTraitNames();

<<<<<<< HEAD
   Assert::assertTrue(in_array(Sushi\Sushi::class, $traits));
=======
    Assert::assertTrue(in_array(Sushi\Sushi::class, $traits));
>>>>>>> laraxot/dev
});
