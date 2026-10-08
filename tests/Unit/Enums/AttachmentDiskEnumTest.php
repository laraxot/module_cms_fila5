<?php

declare(strict_types=1);

use Modules\Cms\Enums\AttachmentDiskEnum;
use PHPUnit\Framework\Assert;

test('AttachmentDiskEnum has all cases', function () {
    $cases = AttachmentDiskEnum::cases();

    Assert::assertCount(3, $cases);
});

test('AttachmentDiskEnum cases have correct values', function () {
    Assert::assertSame('public_html', AttachmentDiskEnum::public_html->value);
    Assert::assertSame('videos', AttachmentDiskEnum::videos->value);
    Assert::assertSame('local', AttachmentDiskEnum::local->value);
});

test('AttachmentDiskEnum cases provide labels', function () {
    foreach (AttachmentDiskEnum::cases() as $case) {
        Assert::assertNotSame('', $case->getLabel());
    }
});

test('AttachmentDiskEnum cases provide colors', function () {
    foreach (AttachmentDiskEnum::cases() as $case) {
        Assert::assertNotSame('', $case->getColor());
    }
});

test('AttachmentDiskEnum cases provide icons', function () {
    foreach (AttachmentDiskEnum::cases() as $case) {
        Assert::assertNotSame('', $case->getIcon());
    }
});

test('AttachmentDiskEnum cases provide descriptions', function () {
    foreach (AttachmentDiskEnum::cases() as $case) {
        Assert::assertNotSame('', $case->getDescription());
    }
});
