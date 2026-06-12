<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\Page;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;
use ReflectionClass;

use function Safe\class_uses;

final class PageBusinessLogicTest extends TestCase
{
    public function test_page_has_expected_fillable_fields(): void
    {
        $page = new Page();
        $expectedFillable = [
            'content',
            'description',
            'slug',
            'title',
            'middleware',
            'content_blocks',
            'sidebar_blocks',
            'footer_blocks',
        ];

        Assert::assertEquals($expectedFillable, $page->getFillable());
    }

    public function test_page_has_sushi_to_json_trait(): void
    {
        $traits = class_uses(Page::class);

        Assert::assertArrayHasKey(SushiToJsons::class, $traits);
    }

    public function test_page_has_correct_casts_for_blocks_and_arrays(): void
    {
        $page = new Page();
        $casts = $page->getCasts();

        Assert::assertSame('array', $casts['content_blocks']);
        Assert::assertSame('array', $casts['sidebar_blocks']);
        Assert::assertSame('array', $casts['footer_blocks']);
        Assert::assertSame('array', $casts['middleware']);
    }

    public function test_page_has_schema_definition_for_structured_data(): void
    {
        $page = new Page();

        $reflection = new ReflectionClass($page);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        /** @var array<string, mixed> $schema */
        $schema = $schemaProperty->getValue($page);
        Assert::assertSame('json', $schema['content_blocks']);
        Assert::assertSame('json', $schema['sidebar_blocks']);
        Assert::assertSame('json', $schema['footer_blocks']);
    }
}
