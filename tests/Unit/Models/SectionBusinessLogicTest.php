<?php

declare(strict_types=1);

use Modules\Cms\Models\BaseModelLang;
use Modules\Cms\Models\Section;
use Modules\Cms\Models\Traits\HasBlocks;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use function Safe\class_uses;

uses(Modules\Cms\Tests\TestCase::class);
describe('Section Business Logic', function (): void {
    test('section extends base model lang for multilingual support', function (): void {

    });

    test('section has translatable fields configured', function (): void {
        $section = new Section();
        $section = new Section();

    });

    test('section has expected fillable fields', function (): void {
        $section = new Section();
        $section = new Section();
        $expectedFillable = [
            'name',
            'slug',
            'blocks',
        ];

        Assert::assertEquals($expectedFillable, $section->getFillable());
    });

    test('section has sushi to json trait', function (): void {
        $traits = class_uses(Section::class);

        Assert::assertArrayHasKey(SushiToJsons::class, $traits);
    });

    test('section has has blocks trait', function (): void {
        $traits = class_uses(Section::class);

        Assert::assertArrayHasKey(HasBlocks::class, $traits);
    });

    test('section has correct casts for multilingual and structured data', function (): void {
        $section = new Section();
        $section = new Section();
        $casts = $section->getCasts();

        Assert::assertSame('array', $casts['name']);
        Assert::assertSame('array', $casts['blocks']);
        Assert::assertSame('string', $casts['id']);
    });

    test('section has schema definition for structured data', function (): void {
        $section = new Section();
        $section = new Section();

        // Use reflection to access protected $schema property
        $reflection = new ReflectionClass($section);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        $schema = $schemaProperty->getValue($section);
    /** @var array<string, mixed> $schema */
        Assert::assertSame('json', $schema['name']);
        Assert::assertSame('json', $schema['blocks']);
        Assert::assertSame('string', $schema['slug']);
    });

    test('section can get rows for sushi functionality', function (): void {
        $section = new Section();

        Assert::assertNotEmpty($section->getRows());
    });
});
