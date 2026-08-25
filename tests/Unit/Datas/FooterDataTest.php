<?php

declare(strict_types=1);

use Livewire\Wireable;
use Modules\Cms\Datas\FooterData;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\Data;

uses(TestCase::class);
test('FooterData can be instantiated', function (): void {
    $footerData = new FooterData();

    Assert::assertInstanceOf(FooterData::class, $footerData);
});

test('FooterData extends Spatie Data', function (): void {
    $footerData = new FooterData();

<<<<<<< HEAD
   Assert::assertInstanceOf(Data::class, $footerData);
=======
    Assert::assertInstanceOf(Data::class, $footerData);
>>>>>>> laraxot/dev
});

test('FooterData implements Wireable interface', function (): void {
    $footerData = new FooterData();

<<<<<<< HEAD
   Assert::assertInstanceOf(Wireable::class, $footerData);
=======
    Assert::assertInstanceOf(Wireable::class, $footerData);
>>>>>>> laraxot/dev
});

test('FooterData has default view path', function (): void {
    $footerData = new FooterData();

<<<<<<< HEAD
   Assert::assertSame('cms::components.footer', $footerData->view);
=======
    Assert::assertSame('cms::components.footer', $footerData->view);
>>>>>>> laraxot/dev
});

test('FooterData has nullable background_color property', function (): void {
    $footerData = new FooterData();

<<<<<<< HEAD
   Assert::assertNull($footerData->background_color);
=======
    Assert::assertNull($footerData->background_color);
>>>>>>> laraxot/dev
});

test('FooterData has nullable background property', function (): void {
    $footerData = new FooterData();

<<<<<<< HEAD
   Assert::assertNull($footerData->background);
=======
    Assert::assertNull($footerData->background);
>>>>>>> laraxot/dev
});

test('FooterData has nullable overlay_color property', function (): void {
    $footerData = new FooterData();

<<<<<<< HEAD
   Assert::assertNull($footerData->overlay_color);
=======
    Assert::assertNull($footerData->overlay_color);
>>>>>>> laraxot/dev
});

test('FooterData rules method returns validation rules', function (): void {
    $rules = FooterData::rules();
<<<<<<< HEAD
   /* @var array<string, mixed> $rules */
=======
    /* @var array<string, mixed> $rules */
>>>>>>> laraxot/dev
    Assert::assertArrayHasKey('background_color', $rules);

    Assert::assertArrayHasKey('background', $rules);

    Assert::assertArrayHasKey('overlay_color', $rules);

    Assert::assertArrayHasKey('view', $rules);
});

test('FooterData can be created from array using from method', function (): void {
    $data = [
        'background_color' => '#ffffff',
        'background' => 'image.jpg',
        'overlay_color' => 'rgba(0,0,0,0.5)',
    ];

    $footerData = FooterData::from($data);

<<<<<<< HEAD
   Assert::assertInstanceOf(FooterData::class, $footerData);
=======
    Assert::assertInstanceOf(FooterData::class, $footerData);
>>>>>>> laraxot/dev

    Assert::assertSame('#ffffff', $footerData->background_color);

    Assert::assertSame('image.jpg', $footerData->background);

    Assert::assertSame('rgba(0,0,0,0.5)', $footerData->overlay_color);
});

test('FooterData can be converted to array', function (): void {
    $footerData = FooterData::from([
        'background_color' => '#000000',
    ]);

    $array = $footerData->toArray();
<<<<<<< HEAD
   /* @var array<string, mixed> $array */
=======
    /* @var array<string, mixed> $array */
>>>>>>> laraxot/dev
    Assert::assertArrayHasKey('background_color', $array);
});
