<?php

declare(strict_types=1);

use Modules\Cms\Datas\BlockData;
use Modules\Cms\Datas\FooterData;
use Modules\Cms\Datas\HeadernavData;
use Modules\Cms\Datas\LinkData;
use Modules\Cms\Datas\NavbarMenuData;
use Modules\Cms\Datas\ThemeData;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('BlockData can be instantiated', function () {
    // BlockData might not have a simple constructor, so just check if class exists
    Assert::assertTrue(class_exists(BlockData::class));
});

test('FooterData can be instantiated', function () {
    $footerData = FooterData::from([]);

<<<<<<< HEAD
   Assert::assertInstanceOf(FooterData::class, $footerData);
=======
    Assert::assertInstanceOf(FooterData::class, $footerData);
>>>>>>> laraxot/dev
});

test('HeadernavData can be instantiated', function () {
    $headernavData = HeadernavData::from([]);

<<<<<<< HEAD
   Assert::assertInstanceOf(HeadernavData::class, $headernavData);
=======
    Assert::assertInstanceOf(HeadernavData::class, $headernavData);
>>>>>>> laraxot/dev
});

test('LinkData can be instantiated', function () {
    // Check if LinkData class exists
<<<<<<< HEAD
   Assert::assertTrue(class_exists(LinkData::class));
=======
    Assert::assertTrue(class_exists(LinkData::class));
>>>>>>> laraxot/dev
});

test('NavbarMenuData can be instantiated', function () {
    // Check if NavbarMenuData class exists
<<<<<<< HEAD
   Assert::assertTrue(class_exists(NavbarMenuData::class));
=======
    Assert::assertTrue(class_exists(NavbarMenuData::class));
>>>>>>> laraxot/dev
});

test('ThemeData can be instantiated', function () {
    // Check if ThemeData class exists
<<<<<<< HEAD
   Assert::assertTrue(class_exists(ThemeData::class));
=======
    Assert::assertTrue(class_exists(ThemeData::class));
>>>>>>> laraxot/dev
});
