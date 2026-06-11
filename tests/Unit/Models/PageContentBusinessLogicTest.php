<?php

declare(strict_types=1);

use ReflectionClass;
use PHPUnit\Framework\Assert;
use Modules\Cms\Models\PageContent;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Spatie\Translatable\HasTranslations;


uses(Modules\Cms\Tests\TestCase::class);
test('page content model can be instantiated', function (): void {
    $pageContent = new PageContent();
    Assert::assertInstanceOf(PageContent::class, $pageContent);
});

test('page content extends BaseModel', function (): void {
    $pageContent = new PageContent();
    Assert::assertInstanceOf(Modules\Cms\Models\BaseModel::class, $pageContent);
});

test('page content uses SushiToJsons trait', function (): void {
    $pageContent = new PageContent();
    $traits = class_uses_recursive($pageContent);

    Assert::assertContains(SushiToJsons::class, array_values($traits));
});

test('page content uses HasTranslations trait', function (): void {
    $pageContent = new PageContent();
    $traits = class_uses_recursive($pageContent);

    Assert::assertContains(HasTranslations::class, array_values($traits));
});

test('page content has correct translatable attributes', function (): void {
    $pageContent = new PageContent();

    Assert::assertContains('name', $pageContent->translatable);

    Assert::assertContains('blocks', $pageContent->translatable);
});

test('page content has correct fillable attributes', function (): void {
    $pageContent = new PageContent();
    $fillable = $pageContent->getFillable();

    Assert::assertContains('name', $fillable);

    Assert::assertContains('slug', $fillable);

    Assert::assertContains('blocks', $fillable);
});

test('page content has correct schema definition', function (): void {
    $pageContent = new PageContent();

    $reflection = new ReflectionClass($pageContent);
    $schemaProperty = $reflection->getProperty('schema');

    Assert::assertTrue($schemaProperty->isProtected());

    $schema = $schemaProperty->getValue($pageContent);
    /** @var array<string, mixed> $schema */
    Assert::assertArrayHasKey('id', $schema);
    Assert::assertArrayHasKey('name', $schema);
    Assert::assertArrayHasKey('slug', $schema);
    Assert::assertArrayHasKey('blocks', $schema);
    Assert::assertSame('json', $schema['name']);
    Assert::assertSame('json', $schema['blocks']);
    Assert::assertSame('string', $schema['slug']);
});

test('page content has correct casts', function (): void {
    $pageContent = new PageContent();
    $casts = $pageContent->getCasts();
    /** @var array<string, mixed> $casts */
    Assert::assertArrayHasKey('id', $casts);

    Assert::assertArrayHasKey('blocks', $casts);

    Assert::assertArrayHasKey('created_at', $casts);

    Assert::assertArrayHasKey('updated_at', $casts);

    Assert::assertSame('array', $casts['blocks']);
});

test('page content getRows method returns array', function (): void {
    $pageContent = new PageContent();
    $rows = $pageContent->getRows();
    Assert::assertNotEmpty($rows);
});

test('page content has sluggable configuration', function (): void {
    $pageContent = new PageContent();
    $sluggable = $pageContent->sluggable();
    /** @var array<string, mixed> $sluggable */
    Assert::assertArrayHasKey('slug', $sluggable);
    /** @var array<string, mixed> $slugConfig */
    $slugConfig = $sluggable['slug'];
    Assert::assertArrayHasKey('source', $slugConfig);

    Assert::assertSame('title', $slugConfig['source']);
});

test('page content blocks cast to array', function (): void {
    $pageContent = new PageContent();
    $casts = $pageContent->getCasts();

    Assert::assertSame('array', $casts['blocks']);
});

test('page content has datetime casts for timestamps', function (): void {
    $pageContent = new PageContent();
    $casts = $pageContent->getCasts();

    Assert::assertSame('datetime', $casts['created_at']);
    Assert::assertSame('datetime', $casts['updated_at']);
});
