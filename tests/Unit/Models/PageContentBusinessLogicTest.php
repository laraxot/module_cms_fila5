<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\PageContent;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use Spatie\Translatable\HasTranslations;

final class PageContentBusinessLogicTest extends TestCase
{
    public function test_page_content_model_can_be_instantiated(): void
    {
        $pageContent = new PageContent();
        Assert::assertInstanceOf(PageContent::class, $pageContent);
    }

    public function test_page_content_extends_base_model(): void
    {
        $pageContent = new PageContent();
        Assert::assertInstanceOf(\Modules\Cms\Models\BaseModel::class, $pageContent);
    }

    public function test_page_content_uses_sushi_to_jsons_trait(): void
    {
        $pageContent = new PageContent();
        $traits = class_uses_recursive($pageContent);

        Assert::assertContains(SushiToJsons::class, array_values($traits));
    }

    public function test_page_content_uses_has_translations_trait(): void
    {
        $pageContent = new PageContent();
        $traits = class_uses_recursive($pageContent);

        Assert::assertContains(HasTranslations::class, array_values($traits));
    }

    public function test_page_content_has_correct_translatable_attributes(): void
    {
        $pageContent = new PageContent();

        Assert::assertContains('name', $pageContent->translatable);

        Assert::assertContains('blocks', $pageContent->translatable);
    }

    public function test_page_content_has_correct_fillable_attributes(): void
    {
        $pageContent = new PageContent();
        $fillable = $pageContent->getFillable();

        Assert::assertContains('name', $fillable);

        Assert::assertContains('slug', $fillable);

        Assert::assertContains('blocks', $fillable);
    }

    public function test_page_content_has_correct_schema_definition(): void
    {
        $pageContent = new PageContent();

        $reflection = new ReflectionClass($pageContent);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        /** @var array<string, mixed> $schema */
        $schema = $schemaProperty->getValue($pageContent);
        Assert::assertArrayHasKey('id', $schema);
        Assert::assertArrayHasKey('name', $schema);
        Assert::assertArrayHasKey('slug', $schema);
        Assert::assertArrayHasKey('blocks', $schema);
        Assert::assertSame('json', $schema['name']);
        Assert::assertSame('json', $schema['blocks']);
        Assert::assertSame('string', $schema['slug']);
    }

    public function test_page_content_has_correct_casts(): void
    {
        $pageContent = new PageContent();
        /** @var array<string, mixed> $casts */
        $casts = $pageContent->getCasts();
        Assert::assertArrayHasKey('id', $casts);

        Assert::assertArrayHasKey('blocks', $casts);

        Assert::assertArrayHasKey('created_at', $casts);

        Assert::assertArrayHasKey('updated_at', $casts);

        Assert::assertSame('array', $casts['blocks']);
    }

    public function test_page_content_get_rows_method_returns_array(): void
    {
        $pageContent = new PageContent();
        $rows = $pageContent->getRows();
        Assert::assertNotEmpty($rows);
    }

    public function test_page_content_has_sluggable_configuration(): void
    {
        $pageContent = new PageContent();
        $sluggable = $pageContent->sluggable();
        Assert::assertArrayHasKey('slug', $sluggable);
        /** @var array<string, mixed> $slugConfig */
        $slugConfig = $sluggable['slug'];
        Assert::assertArrayHasKey('source', $slugConfig);

        Assert::assertSame('title', $slugConfig['source']);
    }

    public function test_page_content_blocks_cast_to_array(): void
    {
        $pageContent = new PageContent();
        $casts = $pageContent->getCasts();

        Assert::assertSame('array', $casts['blocks']);
    }

    public function test_page_content_has_datetime_casts_for_timestamps(): void
    {
        $pageContent = new PageContent();
        $casts = $pageContent->getCasts();

        Assert::assertSame('datetime', $casts['created_at']);
        Assert::assertSame('datetime', $casts['updated_at']);
    }
}
