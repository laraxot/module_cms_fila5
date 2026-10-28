<?php

declare(strict_types=1);

use Modules\Cms\View\Components\AppLayout;
use Modules\Cms\View\Components\GuestLayout;
use Modules\Cms\View\Components\Metatags;
use PHPUnit\Framework\Assert;

test('AppLayout component can be instantiated', function () {
    $component = new AppLayout;
<<<<<<< HEAD
    Assert::assertSame(AppLayout::class, $component::class);
=======
    Assert::assertInstanceOf(AppLayout::class, $component);
>>>>>>> 127b4277 (.)
});

test('GuestLayout component can be instantiated', function () {
    $component = new GuestLayout;
<<<<<<< HEAD
    Assert::assertSame(GuestLayout::class, $component::class);
=======
    Assert::assertInstanceOf(GuestLayout::class, $component);
>>>>>>> 127b4277 (.)
});

test('Metatags component can be instantiated', function () {
    $component = new Metatags;
<<<<<<< HEAD
    Assert::assertSame(Metatags::class, $component::class);
=======
    Assert::assertInstanceOf(Metatags::class, $component);
>>>>>>> 127b4277 (.)
});
