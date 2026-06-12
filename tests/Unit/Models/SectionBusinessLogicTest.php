<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\Section;
use Modules\Cms\Models\Traits\HasBlocks;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;
use ReflectionClass;

use function Safe\class_uses;

final class SectionBusinessLogicTest extends TestCase
{
    public function test_section_has_expected_fillable_fields(): void
    {
        $section = new Section();
        $expectedFillable = [
            'name',
            'slug',
            'blocks',
        ];

        Assert::assertEquals($expectedFillable, $section->getFillable());
    }

    public function test_section_has_sushi_to_json_trait(): void
    {
        $traits = class_uses(Section::class);

        Assert::assertArrayHasKey(SushiToJsons::class, $traits);
    }

    public function test_section_has_has_blocks_trait(): void
    {
        $traits = class_uses(Section::class);

        Assert::assertArrayHasKey(HasBlocks::class, $traits);
    }

    public function test_section_has_correct_casts_for_multilingual_and_structured_data(): void
    {
        $section = new Section();
        $casts = $section->getCasts();

        Assert::assertSame('array', $casts['name']);
        Assert::assertSame('array', $casts['blocks']);
        Assert::assertSame('string', $casts['id']);
    }

    public function test_section_has_schema_definition_for_structured_data(): void
    {
        $section = new Section();

        $reflection = new ReflectionClass($section);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        /** @var array<string, mixed> $schema */
        $schema = $schemaProperty->getValue($section);
        Assert::assertSame('json', $schema['name']);
        Assert::assertSame('json', $schema['blocks']);
        Assert::assertSame('string', $schema['slug']);
    }

    public function test_section_can_get_rows_for_sushi_functionality(): void
    {
        $section = new Section();

        Assert::assertNotEmpty($section->getRows());
    }
}
