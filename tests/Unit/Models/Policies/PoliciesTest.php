<?php

declare(strict_types=1);

use Modules\Cms\Models\Policies\MenuPolicy;
use Modules\Cms\Models\Policies\PagePolicy;
use Modules\Cms\Models\Policies\SectionPolicy;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('PagePolicy can be instantiated', function () {
    $policy = new PagePolicy();

    Assert::assertInstanceOf(PagePolicy::class, $policy);
});

test('MenuPolicy can be instantiated', function () {
    $policy = new MenuPolicy();

<<<<<<< HEAD
   Assert::assertInstanceOf(MenuPolicy::class, $policy);
=======
    Assert::assertInstanceOf(MenuPolicy::class, $policy);
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
