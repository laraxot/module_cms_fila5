<?php

declare(strict_types=1);

use Modules\Cms\Models\BaseModel;
use Modules\Cms\Models\PageContent;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;
use Spatie\Translatable\HasTranslations;

it('instantiates page content model', function (): void {
    $pageContent = new PageContent();

    Assert::assertInstanceOf(PageContent::class, $pageContent);
    Assert::assertInstanceOf(BaseModel::class, $pageContent);
});

it('uses expected traits', function (): void {
    $traits = class_uses_recursive(new PageContent());

    Assert::assertContains(SushiToJsons::class, array_values($traits));
    Assert::assertContains(HasTranslations::class, array_values($traits));
});

it('has expected fillable and casts', function (): void {
    $pageContent = new PageContent();
    $fillable = $pageContent->getFillable();
    $casts = $pageContent->getCasts();

    foreach (['name', 'slug', 'blocks'] as $field) {
        Assert::assertContains($field, $fillable);
    }

    Assert::assertSame('array', $casts['blocks']);
    Assert::assertSame('datetime', $casts['created_at']);
    Assert::assertSame('datetime', $casts['updated_at']);
});

it('has protected schema definition', function (): void {
    $pageContent = new PageContent();
    $schemaProperty = (new ReflectionClass($pageContent))->getProperty('schema');
    $schema = $schemaProperty->getValue($pageContent);

    Assert::assertTrue($schemaProperty->isProtected());
    Assert::assertIsArray($schema);
    Assert::assertArrayHasKey('name', $schema);
    Assert::assertArrayHasKey('slug', $schema);
    Assert::assertArrayHasKey('blocks', $schema);
});

it('returns rows and sluggable configuration', function (): void {
    $pageContent = new PageContent();
    $sluggable = $pageContent->sluggable();

    Assert::assertSame(['slug' => ['source' => 'title']], $sluggable);
});
