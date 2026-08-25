<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\Section;
use Modules\Cms\Models\Traits\HasBlocks;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

uses(TestCase::class);

describe('Section Business Logic', function (): void {
    test('section has expected fillable fields', function (): void {
        $section = new Section();
        $expectedFillable = [
            'name',
            'slug',
            'blocks',
        ];

<<<<<<< HEAD
       Assert::assertEquals($expectedFillable, $section->getFillable());
=======
        Assert::assertEquals($expectedFillable, $section->getFillable());
>>>>>>> laraxot/dev
    });

    test('section has sushi to json trait', function (): void {
        $traits = class_uses(Section::class);

<<<<<<< HEAD
       Assert::assertArrayHasKey(SushiToJsons::class, $traits);
=======
        Assert::assertArrayHasKey(SushiToJsons::class, $traits);
>>>>>>> laraxot/dev
    });

    test('section has has blocks trait', function (): void {
        $traits = class_uses(Section::class);

<<<<<<< HEAD
       Assert::assertArrayHasKey(HasBlocks::class, $traits);
=======
        Assert::assertArrayHasKey(HasBlocks::class, $traits);
>>>>>>> laraxot/dev
    });

    test('section has correct casts for multilingual and structured data', function (): void {
        $section = new Section();
<<<<<<< HEAD
       $casts = $section->getCasts();
=======
        $casts = $section->getCasts();
>>>>>>> laraxot/dev

        Assert::assertSame('array', $casts['name']);
        Assert::assertSame('array', $casts['blocks']);
        Assert::assertSame('string', $casts['id']);
    });

    test('section has schema definition for structured data', function (): void {
        $section = new Section();

<<<<<<< HEAD
       $reflection = new \ReflectionClass($section);
=======
        $reflection = new \ReflectionClass($section);
>>>>>>> laraxot/dev
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        /** @var array<string, mixed> $schema */
        $schema = $schemaProperty->getValue($section);
        Assert::assertSame('json', $schema['name']);
        Assert::assertSame('json', $schema['blocks']);
        Assert::assertSame('string', $schema['slug']);
    });

    test('section can get rows for sushi functionality', function (): void {
        $section = new Section();

<<<<<<< HEAD
       Assert::assertNotEmpty($section->getRows());
=======
        Assert::assertNotEmpty($section->getRows());
>>>>>>> laraxot/dev
    });
});
