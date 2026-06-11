<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;
use Modules\Cms\Filament\Forms\Components\DownloadAttachmentPlaceHolder;


uses(Modules\Cms\Tests\TestCase::class);
test('DownloadAttachmentPlaceHolder extends XotBasePlaceholder', function () {
    Assert::assertTrue(class_exists(DownloadAttachmentPlaceHolder::class));
});

test('DownloadAttachmentPlaceHolder has setUp method', function () {
    });

test('DownloadAttachmentPlaceHolder has generateContent method', function () {
    });
