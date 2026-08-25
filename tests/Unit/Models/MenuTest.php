<?php

declare(strict_types=1);

use Modules\Cms\Models\Menu;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

uses(TestCase::class);
test('Menu model can be instantiated', function () {
    $menu = new Menu();

    Assert::assertInstanceOf(Menu::class, $menu);
});

test('Menu model has expected fillable fields', function () {
    $menu = new Menu();

    $fillable = $menu->getFillable();

<<<<<<< HEAD
   Assert::assertContains('title', $fillable);
=======
    Assert::assertContains('title', $fillable);
>>>>>>> laraxot/dev

    Assert::assertContains('parent_id', $fillable);
});

test('Menu model implements HasRecursiveRelationships', function () {
    $reflection = new ReflectionClass(Menu::class);
    $traits = $reflection->getTraitNames();

<<<<<<< HEAD
   Assert::assertTrue(in_array(HasRecursiveRelationships::class, $traits));
=======
    Assert::assertTrue(in_array(HasRecursiveRelationships::class, $traits));
>>>>>>> laraxot/dev
});

test('Menu model uses SushiToJsons trait', function () {
    $reflection = new ReflectionClass(Menu::class);
    $traits = $reflection->getTraitNames();

<<<<<<< HEAD
   Assert::assertTrue(in_array(SushiToJsons::class, $traits));
=======
    Assert::assertTrue(in_array(SushiToJsons::class, $traits));
>>>>>>> laraxot/dev
});
