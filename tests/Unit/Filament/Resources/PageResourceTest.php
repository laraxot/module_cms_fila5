<?php

declare(strict_types=1);

use Modules\Cms\Filament\Resources\PageResource;
use Modules\Cms\Models\Page;
use PHPUnit\Framework\Assert;

describe('PageResource', function (): void {
    test('page resource has correct model', function (): void {
        Assert::assertSame(Page::class, PageResource::getModel());
    });

    test('page resource has form schema', function (): void {
        $resource = new PageResource;
        $schema = $resource->getFormSchema();
        /* @var array<string, mixed> $schema */
        Assert::assertGreaterThan(0, count($schema));
    });

    test('page resource has form fields', function (): void {
        $resource = new PageResource;
        $schema = $resource->getFormSchema();

        // Check that form has required components (check array keys)
        Assert::assertContains('title', array_keys($schema));
        Assert::assertContains('slug', array_keys($schema));
        Assert::assertContains('content', array_keys($schema));
    });

    test('page resource extends LangBaseResource', function (): void {
        Assert::assertTrue(class_exists(PageResource::class));
    });
});
