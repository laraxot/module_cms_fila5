<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\Section;
use Modules\Cms\Models\Traits\HasBlocks;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

final class SectionBusinessLogicTest extends TestCase
{
    public function testSectionHasExpectedFillableFields(): void
    {
        $section = new Section();
        $expectedFillable = [
            'name',
            'slug',
            'blocks',
        ];

        Assert::assertEquals($expectedFillable, $section->getFillable());
    }

    public function testSectionHasSushiToJsonTrait(): void
    {
        $traits = class_uses(Section::class);

        Assert::assertArrayHasKey(SushiToJsons::class, $traits);
    }

    public function testSectionHasHasBlocksTrait(): void
    {
        $traits = class_uses(Section::class);

        Assert::assertArrayHasKey(HasBlocks::class, $traits);
    }

    public function testSectionHasCorrectCastsForMultilingualAndStructuredData(): void
    {
        $section = new Section();
        $casts = $section->getCasts();

        Assert::assertSame('array', $casts['name']);
        Assert::assertSame('array', $casts['blocks']);
        Assert::assertSame('string', $casts['id']);
    }

    public function testSectionHasSchemaDefinitionForStructuredData(): void
    {
        $section = new Section();

        $reflection = new \ReflectionClass($section);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        /** @var array<string, mixed> $schema */
        $schema = $schemaProperty->getValue($section);
        Assert::assertSame('json', $schema['name']);
        Assert::assertSame('json', $schema['blocks']);
        Assert::assertSame('string', $schema['slug']);
    }

    public function testSectionCanGetRowsForSushiFunctionality(): void
    {
        $section = new Section();

        Assert::assertNotEmpty($section->getRows());
    }
}
