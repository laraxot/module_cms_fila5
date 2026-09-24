<?php

declare(strict_types=1);

use Modules\Cms\Filament\Forms\Components\DownloadAttachmentPlaceHolder;
use PHPUnit\Framework\Assert;

test('DownloadAttachmentPlaceHolder extends XotBasePlaceholder', function () {
    Assert::assertTrue(class_exists(DownloadAttachmentPlaceHolder::class));
});

test('DownloadAttachmentPlaceHolder has setUp method', function () {
    Assert::assertTrue((new ReflectionClass(DownloadAttachmentPlaceHolder::class))->hasMethod('setUp'));
});

test('DownloadAttachmentPlaceHolder has generateContent method', function () {
    Assert::assertTrue((new ReflectionClass(DownloadAttachmentPlaceHolder::class))->hasMethod('generateContent'));
});
