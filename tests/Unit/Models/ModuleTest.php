<?php

declare(strict_types=1);

use Modules\Cms\Models\BaseModel;
use Modules\Cms\Models\Module;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('Module model can be instantiated', function () {
    $module = new Module();

    Assert::assertInstanceOf(Module::class, $module);
});

test('Module model has expected fillable fields', function () {
    $module = new Module();

    $fillable = $module->getFillable();

<<<<<<< HEAD
   Assert::assertContains('id', $fillable);
=======
    Assert::assertContains('id', $fillable);
>>>>>>> laraxot/dev

    Assert::assertContains('name', $fillable);
});

test('Module model extends BaseModel', function () {
    $module = new Module();

<<<<<<< HEAD
   Assert::assertInstanceOf(BaseModel::class, $module);
=======
    Assert::assertInstanceOf(BaseModel::class, $module);
>>>>>>> laraxot/dev
});

test('Module model uses Sushi trait', function () {
    $reflection = new ReflectionClass(Module::class);
    $traits = $reflection->getTraitNames();

<<<<<<< HEAD
   Assert::assertTrue(in_array(Sushi\Sushi::class, $traits));
=======
    Assert::assertTrue(in_array(Sushi\Sushi::class, $traits));
>>>>>>> laraxot/dev
});

test('Module model has id as route key', function () {
    $module = new Module();

<<<<<<< HEAD
   Assert::assertSame('id', $module->getRouteKeyName());
=======
    Assert::assertSame('id', $module->getRouteKeyName());
>>>>>>> laraxot/dev
});
