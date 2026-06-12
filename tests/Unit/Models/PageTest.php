<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\BaseModelLang;
use Modules\Cms\Models\Page;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;
use ReflectionClass;

final class PageTest extends TestCase
{
    public function test_page_model_can_be_instantiated(): void
    {
        $page = new Page();
        Assert::assertInstanceOf(Page::class, $page);
    }

    public function test_page_extends_base_model_lang(): void
    {
        $page = new Page();
        Assert::assertInstanceOf(BaseModelLang::class, $page);
    }

    public function test_page_has_expected_fillable_fields(): void
    {
        $page = new Page();
        $fillable = $page->getFillable();

        Assert::assertContains('title', $fillable);
        Assert::assertContains('slug', $fillable);
        Assert::assertContains('content', $fillable);
        Assert::assertContains('description', $fillable);
        Assert::assertContains('middleware', $fillable);
        Assert::assertContains('content_blocks', $fillable);
        Assert::assertContains('sidebar_blocks', $fillable);
        Assert::assertContains('footer_blocks', $fillable);
    }

    public function test_page_has_expected_casts(): void
    {
        $page = new Page();
        /** @var array<string, mixed> $casts */
        $casts = $page->getCasts();
        Assert::assertArrayHasKey('created_at', $casts);

        Assert::assertArrayHasKey('updated_at', $casts);

        Assert::assertArrayHasKey('content_blocks', $casts);

        Assert::assertArrayHasKey('sidebar_blocks', $casts);

        Assert::assertArrayHasKey('footer_blocks', $casts);

        Assert::assertArrayHasKey('middleware', $casts);
    }

    public function test_page_has_translatable_fields_configured(): void
    {
        $page = new Page();

        Assert::assertContains('title', $page->translatable);

        Assert::assertContains('content_blocks', $page->translatable);

        Assert::assertContains('sidebar_blocks', $page->translatable);

        Assert::assertContains('footer_blocks', $page->translatable);
    }

    public function test_page_has_sushi_to_jsons_trait(): void
    {
        $page = new Page();
        $traits = class_uses_recursive($page);

        Assert::assertContains(SushiToJsons::class, array_values($traits));
    }

    public function test_page_has_get_rows_method_for_sushi_functionality(): void
    {
        $page = new Page();

        Assert::assertNotEmpty($page->getRows());
    }

    public function test_page_has_schema_definition(): void
    {
        $page = new Page();

        $reflection = new ReflectionClass($page);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        /** @var array<string, mixed> $schema */
        $schema = $schemaProperty->getValue($page);
        Assert::assertArrayHasKey('id', $schema);
        Assert::assertArrayHasKey('title', $schema);
        Assert::assertArrayHasKey('slug', $schema);
        Assert::assertArrayHasKey('content', $schema);
        Assert::assertArrayHasKey('description', $schema);
        Assert::assertArrayHasKey('content_blocks', $schema);
    }

    public function test_page_has_get_middleware_by_slug_static_method(): void
    {
        $result = Page::getMiddlewareBySlug('non-existent-slug');
    }

    public function test_page_casts_content_blocks_to_array(): void
    {
        $page = new Page();
        $casts = $page->getCasts();

        Assert::assertSame('array', $casts['content_blocks']);
    }

    public function test_page_casts_middleware_to_array(): void
    {
        $page = new Page();
        $casts = $page->getCasts();

        Assert::assertSame('array', $casts['middleware']);
    }
}
