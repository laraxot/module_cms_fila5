<?php

declare(strict_types=1);

use Modules\Cms\Filament\Resources\MenuResource;
use Modules\Cms\Filament\Resources\PageContentResource;
use Modules\Cms\Filament\Resources\PageResource;
use Modules\Cms\Filament\Resources\SectionResource;
use PHPUnit\Framework\Assert;
use ReflectionNamedType;

test('cms resources extend proper base resources', function () {
    Assert::assertTrue((new ReflectionClass(PageResource::class))->isSubclassOf('Modules\\Lang\\Filament\\Resources\\LangBaseResource'));
    Assert::assertTrue((new ReflectionClass(PageContentResource::class))->isSubclassOf('Modules\\Lang\\Filament\\Resources\\LangBaseResource'));
    Assert::assertTrue((new ReflectionClass(SectionResource::class))->isSubclassOf('Modules\\Lang\\Filament\\Resources\\LangBaseResource'));
    Assert::assertTrue((new ReflectionClass(MenuResource::class))->isSubclassOf('Modules\\Xot\\Filament\\Resources\\XotBaseResource'));
});

test('cms resources do not implement unnecessary methods', function () {
    $resources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
        MenuResource::class,
    ];

    foreach ($resources as $resourceClass) {
        $reflection = new ReflectionClass($resourceClass);

        Assert::assertFalse($reflection->hasMethod('getPages'), "{$resourceClass} should not implement getPages()");
        Assert::assertFalse($reflection->hasMethod('getRelations'), "{$resourceClass} should not implement getRelations()");
        Assert::assertFalse($reflection->hasMethod('form'), "{$resourceClass} should not implement form()");
        Assert::assertFalse($reflection->hasMethod('table'), "{$resourceClass} should not implement table()");
    }
});

test('cms resources implement required getFormSchema method', function () {
    $resources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
        MenuResource::class,
    ];

    foreach ($resources as $resourceClass) {
        $reflection = new ReflectionClass($resourceClass);

        Assert::assertTrue($reflection->hasMethod('getFormSchema'), "{$resourceClass} must implement getFormSchema()");

        $method = $reflection->getMethod('getFormSchema');
        Assert::assertTrue($method->isPublic(), "{$resourceClass}::getFormSchema() must be public");
        Assert::assertTrue($method->isStatic(), "{$resourceClass}::getFormSchema() must be static");
        $returnType = $method->getReturnType();
        Assert::assertSame('array', $returnType instanceof ReflectionNamedType ? $returnType->getName() : null, "{$resourceClass}::getFormSchema() must return array");
    }
});

test('cms resources have correct model configuration', function () {
    Assert::assertSame('Modules\\Cms\\Models\\Page', PageResource::getModel());
    Assert::assertSame('Modules\\Cms\\Models\\PageContent', PageContentResource::getModel());
    Assert::assertSame('Modules\\Cms\\Models\\Section', SectionResource::getModel());
    Assert::assertSame('Modules\\Cms\\Models\\Menu', MenuResource::getModel());
});

test('multilingual resources provide translatable locales', function () {
    $multilingualResources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
    ];

    foreach ($multilingualResources as $resourceClass) {
        $locales = $resourceClass::getTranslatableLocales();

        Assert::assertIsArray($locales, "{$resourceClass} must provide translatable locales");
        Assert::assertNotEmpty($locales, "{$resourceClass} must provide translatable locales");
        Assert::assertContains('it', $locales, "{$resourceClass} must support Italian and English locales");
        Assert::assertContains('en', $locales, "{$resourceClass} must support Italian and English locales");
    }
});

test('cms resource form schemas return valid arrays', function () {
    $resources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
        MenuResource::class,
    ];

    foreach ($resources as $resourceClass) {
        $schema = (new $resourceClass)->getFormSchema();

        Assert::assertNotEmpty($schema, "{$resourceClass}::getFormSchema() must return non-empty array");
    }
});

test('page resource form schema contains expected fields', function () {
    $schema = (new PageResource)->getFormSchema();

    Assert::assertNotEmpty($schema);

    $hasTitleField = collect($schema)
        ->contains(
            fn ($field) => is_object($field) && method_exists($field, 'getName') && 'title' === $field->getName(),
        );

    $hasSlugField = collect($schema)
        ->contains(fn ($field) => is_object($field) && method_exists($field, 'getName') && 'slug' === $field->getName());

    Assert::assertTrue($hasTitleField, 'PageResource should have title field');
    Assert::assertTrue($hasSlugField, 'PageResource should have slug field');
});

test('menu resource form schema contains expected fields', function () {
    $schema = (new MenuResource)->getFormSchema();

    Assert::assertNotEmpty($schema);

    $hasTitleField = collect($schema)
        ->contains(
            fn ($field) => is_object($field) && method_exists($field, 'getName') && 'title' === $field->getName(),
        );

    $hasItemsField = collect($schema)
        ->contains(
            fn ($field) => is_object($field) && method_exists($field, 'getName') && 'items' === $field->getName(),
        );

    Assert::assertTrue($hasTitleField, 'MenuResource should have title field');
    Assert::assertTrue($hasItemsField, 'MenuResource should have items field');
});

test('resources use proper base resource functionality', function () {
    $resources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
        MenuResource::class,
    ];

    foreach ($resources as $resourceClass) {
        $pages = $resourceClass::getPages();
        $relations = $resourceClass::getRelations();

        Assert::assertIsArray($pages);
        Assert::assertArrayHasKey('index', $pages, "{$resourceClass} should have standard pages");
        Assert::assertArrayHasKey('create', $pages, "{$resourceClass} should have standard pages");
        Assert::assertArrayHasKey('edit', $pages, "{$resourceClass} should have standard pages");
        Assert::assertIsArray($relations, "{$resourceClass} should return relations array");
    }
});

test('resources follow naming conventions', function () {
    Assert::assertSame('PageResource', class_basename(PageResource::class));
    Assert::assertSame('PageContentResource', class_basename(PageContentResource::class));
    Assert::assertSame('SectionResource', class_basename(SectionResource::class));
    Assert::assertSame('MenuResource', class_basename(MenuResource::class));

    Assert::assertSame('Modules\\Cms\\Models\\Page', PageResource::getModel());
    Assert::assertSame('Modules\\Cms\\Models\\PageContent', PageContentResource::getModel());
    Assert::assertSame('Modules\\Cms\\Models\\Section', SectionResource::getModel());
    Assert::assertSame('Modules\\Cms\\Models\\Menu', MenuResource::getModel());
});

test('lang base resource provides multilingual features', function () {
    $multilingualResources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
    ];

    foreach ($multilingualResources as $resourceClass) {
        Assert::assertTrue(method_exists($resourceClass, 'getTranslatableLocales'));
        Assert::assertTrue(method_exists($resourceClass, 'getDefaultTranslatableLocale'));

        $locales = $resourceClass::getTranslatableLocales();
        $defaultLocale = $resourceClass::getDefaultTranslatableLocale();

        Assert::assertIsArray($locales);
        Assert::assertNotEmpty($locales);
        Assert::assertIsString($defaultLocale);
        Assert::assertNotSame('', $defaultLocale);
    }
});
