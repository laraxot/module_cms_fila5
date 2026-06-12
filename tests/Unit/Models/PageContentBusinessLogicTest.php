<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\PageContent;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;
use Spatie\Translatable\HasTranslations;

final class PageContentBusinessLogicTest extends TestCase
{
    public function testPageContentModelCanBeInstantiated(): void
    {
        $pageContent = new PageContent();
        Assert::assertInstanceOf(PageContent::class, $pageContent);
    }

    public function testPageContentExtendsBaseModel(): void
    {
        $pageContent = new PageContent();
        Assert::assertInstanceOf(\Modules\Cms\Models\BaseModel::class, $pageContent);
    }

    public function testPageContentUsesSushiToJsonsTrait(): void
    {
        $pageContent = new PageContent();
        $traits = class_uses_recursive($pageContent);

        Assert::assertContains(SushiToJsons::class, array_values($traits));
    }

    public function testPageContentUsesHasTranslationsTrait(): void
    {
        $pageContent = new PageContent();
        $traits = class_uses_recursive($pageContent);

        Assert::assertContains(HasTranslations::class, array_values($traits));
    }

    public function testPageContentHasCorrectTranslatableAttributes(): void
    {
        $pageContent = new PageContent();

        Assert::assertContains('name', $pageContent->translatable);

        Assert::assertContains('blocks', $pageContent->translatable);
    }

    public function testPageContentHasCorrectFillableAttributes(): void
    {
        $pageContent = new PageContent();
        $fillable = $pageContent->getFillable();

        Assert::assertContains('name', $fillable);

        Assert::assertContains('slug', $fillable);

        Assert::assertContains('blocks', $fillable);
    }

    public function testPageContentHasCorrectSchemaDefinition(): void
    {
        $pageContent = new PageContent();

        $reflection = new \ReflectionClass($pageContent);
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

    public function testPageContentHasCorrectCasts(): void
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

    public function testPageContentGetRowsMethodReturnsArray(): void
    {
        $pageContent = new PageContent();
        $rows = $pageContent->getRows();
        Assert::assertNotEmpty($rows);
    }

    public function testPageContentHasSluggableConfiguration(): void
    {
        $pageContent = new PageContent();
        $sluggable = $pageContent->sluggable();
        Assert::assertArrayHasKey('slug', $sluggable);
        /** @var array<string, mixed> $slugConfig */
        $slugConfig = $sluggable['slug'];
        Assert::assertArrayHasKey('source', $slugConfig);

        Assert::assertSame('title', $slugConfig['source']);
    }

    public function testPageContentBlocksCastToArray(): void
    {
        $pageContent = new PageContent();
        $casts = $pageContent->getCasts();

        Assert::assertSame('array', $casts['blocks']);
    }

    public function testPageContentHasDatetimeCastsForTimestamps(): void
    {
        $pageContent = new PageContent();
        $casts = $pageContent->getCasts();

        Assert::assertSame('datetime', $casts['created_at']);
        Assert::assertSame('datetime', $casts['updated_at']);
    }
}
