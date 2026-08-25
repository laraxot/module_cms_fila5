<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;
use Modules\Cms\View\Components\AppLayout;
use Modules\Cms\View\Components\GuestLayout;
use Modules\Cms\View\Components\Metatags;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('AppLayout component can be instantiated', function () {
    $component = new AppLayout();
    Assert::assertInstanceOf(AppLayout::class, $component);
});

test('GuestLayout component can be instantiated', function () {
    $component = new GuestLayout();
<<<<<<< HEAD
   Assert::assertInstanceOf(GuestLayout::class, $component);
=======
    Assert::assertInstanceOf(GuestLayout::class, $component);
>>>>>>> laraxot/dev
});

test('Metatags component can be instantiated', function () {
    $component = new Metatags();
<<<<<<< HEAD
   Assert::assertInstanceOf(Metatags::class, $component);
=======
    Assert::assertInstanceOf(Metatags::class, $component);
>>>>>>> laraxot/dev
});
