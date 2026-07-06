<?php

declare(strict_types=1);

use Modules\Cms\Datas\FooterData;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\Data;

it('creates footer data with defaults', function (): void {
    $footerData = new FooterData();

    Assert::assertInstanceOf(Data::class, $footerData);
    Assert::assertSame('cms::components.footer', $footerData->view);
    Assert::assertNull($footerData->background_color);
    Assert::assertNull($footerData->background);
    Assert::assertNull($footerData->overlay_color);
});

it('returns validation rules', function (): void {
    $rules = FooterData::rules();

    foreach (['background_color', 'background', 'overlay_color', 'view'] as $field) {
        Assert::assertArrayHasKey($field, $rules);
    }
});

it('hydrates from array and converts back', function (): void {
    $footerData = FooterData::from([
        'background_color' => '#ffffff',
        'background' => 'image.jpg',
        'overlay_color' => 'rgba(0,0,0,0.5)',
    ]);

    Assert::assertSame('#ffffff', $footerData->background_color);
    Assert::assertSame('image.jpg', $footerData->background);
    Assert::assertSame('rgba(0,0,0,0.5)', $footerData->overlay_color);
    Assert::assertArrayHasKey('background_color', $footerData->toArray());
});
