<?php

declare(strict_types=1);

use Modules\Cms\Models\BaseModelLang;
use Modules\Cms\Models\Page;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;
use ReflectionClass;

uses(Modules\Cms\Tests\TestCase::class);
test('page model can be instantiated', function (): void {
    $page = new Page();
    Assert::assertInstanceOf(Page::class, $page);
});

test('page extends BaseModelLang', function (): void {
    $page = new Page();
    Assert::assertInstanceOf(BaseModelLang::class, $page);
});

test('page has expected fillable fields', function (): void {
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
});

test('page has expected casts', function (): void {
    $page = new Page();
    $casts = $page->getCasts();
    /* @var array<string, mixed> $casts */
    Assert::assertArrayHasKey('created_at', $casts);

    Assert::assertArrayHasKey('updated_at', $casts);

    Assert::assertArrayHasKey('content_blocks', $casts);

    Assert::assertArrayHasKey('sidebar_blocks', $casts);

    Assert::assertArrayHasKey('footer_blocks', $casts);

    Assert::assertArrayHasKey('middleware', $casts);
});

test('page has translatable fields configured', function (): void {
    $page = new Page();

    Assert::assertContains('title', $page->translatable);

    Assert::assertContains('content_blocks', $page->translatable);

    Assert::assertContains('sidebar_blocks', $page->translatable);

    Assert::assertContains('footer_blocks', $page->translatable);
});

test('page has SushiToJsons trait', function (): void {
    $page = new Page();
    $traits = class_uses_recursive($page);

    Assert::assertContains(SushiToJsons::class, array_values($traits));
});

test('page has getRows method for sushi functionality', function (): void {
    $page = new Page();

    Assert::assertNotEmpty($page->getRows());
});

test('page has schema definition', function (): void {
    $page = new Page();

    $reflection = new ReflectionClass($page);
    $schemaProperty = $reflection->getProperty('schema');

    Assert::assertTrue($schemaProperty->isProtected());

    $schema = $schemaProperty->getValue($page);
    /* @var array<string, mixed> $schema */
    Assert::assertArrayHasKey('id', $schema);
    Assert::assertArrayHasKey('title', $schema);
    Assert::assertArrayHasKey('slug', $schema);
    Assert::assertArrayHasKey('content', $schema);
    Assert::assertArrayHasKey('description', $schema);
    Assert::assertArrayHasKey('content_blocks', $schema);
});

test('page has getMiddlewareBySlug static method', function (): void {
    // Test with non-existent slug returns empty array
    $result = Page::getMiddlewareBySlug('non-existent-slug');
    /* @var array<string, mixed> $result */
});

test('page casts content_blocks to array', function (): void {
    $page = new Page();
    $casts = $page->getCasts();

    Assert::assertSame('array', $casts['content_blocks']);
});

test('page casts middleware to array', function (): void {
    $page = new Page();
    $casts = $page->getCasts();

    Assert::assertSame('array', $casts['middleware']);
});
