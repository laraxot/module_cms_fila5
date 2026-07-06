<?php

declare(strict_types=1);

use Modules\Cms\Datas\BlockData;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

it('creates block data with type and payload', function (): void {
    $blockData = new BlockData('hero', ['view' => 'ui::empty', 'title' => 'Test']);

    Assert::assertSame('hero', $blockData->type);
    Assert::assertSame('Test', $blockData->data['title']);
    Assert::assertSame('ui::empty', $blockData->view);
});

it('extends spatie data', function (): void {
    Assert::assertInstanceOf(Data::class, new BlockData('text', ['view' => 'ui::empty']));
});

it('collects block data items', function (): void {
    $collection = BlockData::collection([
        new BlockData('hero', ['view' => 'ui::empty', 'title' => 'Hero']),
        new BlockData('text', ['view' => 'ui::empty', 'content' => 'Text']),
    ]);

    Assert::assertInstanceOf(DataCollection::class, $collection);
});

it('uses default empty view', function (): void {
    Assert::assertSame('ui::empty', (new BlockData('simple', []))->view);
});
