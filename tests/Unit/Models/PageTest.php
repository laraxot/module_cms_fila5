<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\BaseModelLang;
use Modules\Cms\Models\Page;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;

final class PageTest extends TestCase
{
    public function testPageModelCanBeInstantiated(): void
    {
        $page = new Page();
        Assert::assertInstanceOf(Page::class, $page);
    }

    public function testPageExtendsBaseModelLang(): void
    {
        $page = new Page();
        Assert::assertInstanceOf(BaseModelLang::class, $page);
    }

    public function testPageHasExpectedFillableFields(): void
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

    public function testPageHasExpectedCasts(): void
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

    public function testPageHasTranslatableFieldsConfigured(): void
    {
        $page = new Page();

        Assert::assertContains('title', $page->translatable);

        Assert::assertContains('content_blocks', $page->translatable);

        Assert::assertContains('sidebar_blocks', $page->translatable);

        Assert::assertContains('footer_blocks', $page->translatable);
    }

    public function testPageHasSushiToJsonsTrait(): void
    {
        $page = new Page();
        $traits = class_uses_recursive($page);

        Assert::assertContains(SushiToJsons::class, array_values($traits));
    }

    public function testPageHasGetRowsMethodForSushiFunctionality(): void
    {
        $page = new Page();

        Assert::assertNotEmpty($page->getRows());
    }

    public function testPageHasSchemaDefinition(): void
    {
        $page = new Page();

        $reflection = new \ReflectionClass($page);
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

    public function testPageHasGetMiddlewareBySlugStaticMethod(): void
    {
        $result = Page::getMiddlewareBySlug('non-existent-slug');
    }

    public function testPageCastsContentBlocksToArray(): void
    {
        $page = new Page();
        $casts = $page->getCasts();

        Assert::assertSame('array', $casts['content_blocks']);
    }

    public function testPageCastsMiddlewareToArray(): void
    {
        $page = new Page();
        $casts = $page->getCasts();

        Assert::assertSame('array', $casts['middleware']);
    }
}
