<?php

declare(strict_types=1);

use Modules\Cms\Models\Policies\CmsBasePolicy;
use Modules\Cms\Models\Policies\ConfPolicy;
use Modules\Cms\Models\Policies\MenuPolicy;
use Modules\Cms\Models\Policies\ModulePolicy;
use Modules\Cms\Models\Policies\PageContentPolicy;
use Modules\Cms\Models\Policies\PagePolicy;
use Modules\Cms\Models\Policies\SectionPolicy;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('CmsBasePolicy is an abstract class', function () {
    $reflection = new ReflectionClass(CmsBasePolicy::class);

    Assert::assertTrue($reflection->isAbstract());
});

test('PagePolicy can be instantiated', function () {
    $policy = new PagePolicy();

<<<<<<< HEAD
   Assert::assertInstanceOf(PagePolicy::class, $policy);
=======
    Assert::assertInstanceOf(PagePolicy::class, $policy);
>>>>>>> laraxot/dev
});

test('SectionPolicy can be instantiated', function () {
    $policy = new SectionPolicy();

<<<<<<< HEAD
   Assert::assertInstanceOf(SectionPolicy::class, $policy);
=======
    Assert::assertInstanceOf(SectionPolicy::class, $policy);
>>>>>>> laraxot/dev
});

test('PageContentPolicy can be instantiated', function () {
    $policy = new PageContentPolicy();

<<<<<<< HEAD
   Assert::assertInstanceOf(PageContentPolicy::class, $policy);
=======
    Assert::assertInstanceOf(PageContentPolicy::class, $policy);
>>>>>>> laraxot/dev
});

test('ConfPolicy can be instantiated', function () {
    $policy = new ConfPolicy();

<<<<<<< HEAD
   Assert::assertInstanceOf(ConfPolicy::class, $policy);
=======
    Assert::assertInstanceOf(ConfPolicy::class, $policy);
>>>>>>> laraxot/dev
});

test('MenuPolicy can be instantiated', function () {
    $policy = new MenuPolicy();

<<<<<<< HEAD
   Assert::assertInstanceOf(MenuPolicy::class, $policy);
=======
    Assert::assertInstanceOf(MenuPolicy::class, $policy);
>>>>>>> laraxot/dev
});

test('ModulePolicy can be instantiated', function () {
    $policy = new ModulePolicy();

<<<<<<< HEAD
   Assert::assertInstanceOf(ModulePolicy::class, $policy);
=======
    Assert::assertInstanceOf(ModulePolicy::class, $policy);
>>>>>>> laraxot/dev
});

test('PagePolicy has expected methods', function () {
    $policy = new PagePolicy();
});
