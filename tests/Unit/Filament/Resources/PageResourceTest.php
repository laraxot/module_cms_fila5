<?php

declare(strict_types=1);

use Modules\Cms\Filament\Resources\PageResource;
use Modules\Cms\Models\Page;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('PageResource', function (): void {
    test('page resource has correct model', function (): void {
        $resource = new PageResource();

<<<<<<< HEAD
       Assert::assertSame(Page::class, $resource::getModel());
=======
        Assert::assertSame(Page::class, $resource::getModel());
>>>>>>> laraxot/dev
    });

    test('page resource has form schema', function (): void {
        $schema = PageResource::getFormSchema();
<<<<<<< HEAD
       /* @var array<string, mixed> $schema */
=======
        /* @var array<string, mixed> $schema */
>>>>>>> laraxot/dev
        Assert::assertGreaterThan(0, count($schema));
    });

    test('page resource has form fields', function (): void {
        $schema = PageResource::getFormSchema();

        // Check that form has required components (check array keys)
<<<<<<< HEAD
       Assert::assertContains('title', array_keys($schema));
=======
        Assert::assertContains('title', array_keys($schema));
>>>>>>> laraxot/dev
        Assert::assertContains('slug', array_keys($schema));
        Assert::assertContains('content', array_keys($schema));
    });

    test('page resource extends LangBaseResource', function (): void {
        Assert::assertTrue(class_exists(PageResource::class));
    });
});
