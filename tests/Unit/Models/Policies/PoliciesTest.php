<?php

declare(strict_types=1);

use Modules\Cms\Models\Policies\MenuPolicy;
use Modules\Cms\Models\Policies\PagePolicy;
use Modules\Cms\Models\Policies\SectionPolicy;
use PHPUnit\Framework\Assert;

test('PagePolicy can be instantiated', function () {
    $policy = new PagePolicy;
<<<<<<< HEAD
    Assert::assertSame(PagePolicy::class, $policy::class);
=======
>>>>>>> 127b4277 (.)

});

test('MenuPolicy can be instantiated', function () {
    $policy = new MenuPolicy;
<<<<<<< HEAD
    Assert::assertSame(MenuPolicy::class, $policy::class);
=======
>>>>>>> 127b4277 (.)

});

test('SectionPolicy can be instantiated', function () {
    $policy = new SectionPolicy;
<<<<<<< HEAD
    Assert::assertSame(SectionPolicy::class, $policy::class);
=======
>>>>>>> 127b4277 (.)

});
