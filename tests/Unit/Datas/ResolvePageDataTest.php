<?php

declare(strict_types=1);

use Modules\Cms\Datas\ResolvePageData;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\Data;

uses(TestCase::class);
test('ResolvePageData can be instantiated with constructor', function (): void {
    $data = new ResolvePageData('folio', null, 'home');

    Assert::assertInstanceOf(ResolvePageData::class, $data);
});

test('ResolvePageData stores renderMode correctly', function (): void {
    $data = new ResolvePageData('cms', null, 'about');

<<<<<<< HEAD
   Assert::assertSame('cms', $data->renderMode);
=======
    Assert::assertSame('cms', $data->renderMode);
>>>>>>> laraxot/dev
});

test('ResolvePageData stores pageSlug correctly', function (): void {
    $data = new ResolvePageData('folio', null, 'contact');

<<<<<<< HEAD
   Assert::assertSame('contact', $data->pageSlug);
=======
    Assert::assertSame('contact', $data->pageSlug);
>>>>>>> laraxot/dev
});

test('ResolvePageData can store null item', function (): void {
    $data = new ResolvePageData('folio', null, 'home');

<<<<<<< HEAD
   Assert::assertNull($data->item);
=======
    Assert::assertNull($data->item);
>>>>>>> laraxot/dev
});

test('ResolvePageData can store object item', function (): void {
    $item = new stdClass();
    $item->title = 'Test Page';

    $data = new ResolvePageData('cms', $item, 'test');

<<<<<<< HEAD
   Assert::assertSame($item, $data->item);
=======
    Assert::assertSame($item, $data->item);
>>>>>>> laraxot/dev

    Assert::assertSame('Test Page', $data->item->title);
});

test('ResolvePageData can store array cast as object', function (): void {
    $item = (object) ['id' => 1, 'slug' => 'test'];

    $data = new ResolvePageData('cms', $item, 'test');

<<<<<<< HEAD
   Assert::assertInstanceOf(stdClass::class, $data->item);
=======
    Assert::assertInstanceOf(stdClass::class, $data->item);
>>>>>>> laraxot/dev
});

test('ResolvePageData extends Spatie Data', function (): void {
    $data = new ResolvePageData('folio', null, 'home');

<<<<<<< HEAD
   Assert::assertInstanceOf(Data::class, $data);
=======
    Assert::assertInstanceOf(Data::class, $data);
>>>>>>> laraxot/dev
});

test('ResolvePageData with different renderModes', function (): void {
    $modes = ['folio', 'cms', 'static', 'dynamic'];

    foreach ($modes as $mode) {
        $data = new ResolvePageData($mode, null, 'test');

<<<<<<< HEAD
       Assert::assertSame($mode, $data->renderMode);
=======
        Assert::assertSame($mode, $data->renderMode);
>>>>>>> laraxot/dev
    }
});

test('ResolvePageData handles various page slugs', function (): void {
    $slugs = ['home', 'about-us', 'contact', 'blog/post-1', 'deep/nested/page'];

    foreach ($slugs as $slug) {
        $data = new ResolvePageData('cms', null, $slug);

<<<<<<< HEAD
       Assert::assertSame($slug, $data->pageSlug);
=======
        Assert::assertSame($slug, $data->pageSlug);
>>>>>>> laraxot/dev
    }
});
