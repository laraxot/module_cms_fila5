<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;
use Modules\Cms\View\Components\PageContent;
use Modules\Cms\View\Components\Section;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
/*
 * Smoke tests for Section and PageContent view components.
 *
 * Page component tests are in:
 *
 * @see \Modules\Cms\Tests\Unit\View\Components\PageComponentTest
 */
test('Section component can be instantiated', function () {
    $component = new Section('test-slug');

<<<<<<< HEAD
   Assert::assertInstanceOf(Section::class, $component);
=======
    Assert::assertInstanceOf(Section::class, $component);
>>>>>>> laraxot/dev
});

test('PageContent component can be instantiated', function () {
    $component = new PageContent('test-slug');

<<<<<<< HEAD
   Assert::assertInstanceOf(PageContent::class, $component);
=======
    Assert::assertInstanceOf(PageContent::class, $component);
>>>>>>> laraxot/dev
});
