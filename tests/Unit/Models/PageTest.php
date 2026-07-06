<?php

declare(strict_types=1);

use Modules\Cms\Models\Page;
use PHPUnit\Framework\Assert;

it('instantiates the page model', function (): void {
    Assert::assertInstanceOf(Page::class, new Page());
});

it('has expected fillable fields', function (): void {
    $fillable = (new Page())->getFillable();

    foreach (['title', 'slug', 'content', 'description', 'middleware', 'content_blocks', 'sidebar_blocks', 'footer_blocks'] as $field) {
        Assert::assertContains($field, $fillable);
    }
});

it('has expected casts', function (): void {
    $casts = (new Page())->getCasts();

    foreach (['created_at', 'updated_at', 'content_blocks', 'sidebar_blocks', 'footer_blocks', 'middleware'] as $field) {
        Assert::assertArrayHasKey($field, $casts);
    }
});

it('has protected schema definition', function (): void {
    $page = new Page();
    $schemaProperty = (new ReflectionClass($page))->getProperty('schema');
    $schema = $schemaProperty->getValue($page);

    Assert::assertTrue($schemaProperty->isProtected());
    Assert::assertIsArray($schema);
    Assert::assertArrayHasKey('id', $schema);
    Assert::assertArrayHasKey('title', $schema);
    Assert::assertArrayHasKey('slug', $schema);
});

it('returns middleware by slug', function (): void {
    Assert::assertIsArray(Page::getMiddlewareBySlug('non-existent-slug'));
});
