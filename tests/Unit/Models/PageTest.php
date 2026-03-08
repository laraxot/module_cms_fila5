<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Models\Page;

<<<<<<< HEAD
test('page model can be instantiated', function (): void {
    $page = new Page();
    expect($page)->toBeInstanceOf(Page::class);
});

test('page extends BaseModelLang', function (): void {
    $page = new Page();
    expect($page)->toBeInstanceOf(Modules\Cms\Models\BaseModelLang::class);
});

test('page has expected fillable fields', function (): void {
    $page = new Page();
    $fillable = $page->getFillable();

    // Check actual fillable fields from the model
    expect($fillable)->toContain('title')
        ->and($fillable)->toContain('slug')
        ->and($fillable)->toContain('content')
        ->and($fillable)->toContain('description')
        ->and($fillable)->toContain('middleware')
        ->and($fillable)->toContain('content_blocks')
        ->and($fillable)->toContain('sidebar_blocks')
        ->and($fillable)->toContain('footer_blocks');
});

test('page has expected casts', function (): void {
    $page = new Page();
    $casts = $page->getCasts();

    expect($casts)->toBeArray()
        ->and($casts)->toHaveKey('created_at')
        ->and($casts)->toHaveKey('updated_at')
        ->and($casts)->toHaveKey('content_blocks')
        ->and($casts)->toHaveKey('sidebar_blocks')
        ->and($casts)->toHaveKey('footer_blocks')
        ->and($casts)->toHaveKey('middleware');
});

test('page has translatable fields configured', function (): void {
    $page = new Page();

    expect($page->translatable)->toBeArray()
        ->and($page->translatable)->toContain('title')
        ->and($page->translatable)->toContain('content_blocks')
        ->and($page->translatable)->toContain('sidebar_blocks')
        ->and($page->translatable)->toContain('footer_blocks');
});

test('page has SushiToJsons trait', function (): void {
    $page = new Page();
    $traits = class_uses_recursive($page);

    expect(array_values($traits))->toContain(Modules\Tenant\Models\Traits\SushiToJsons::class);
});

test('page has getRows method for sushi functionality', function (): void {
    $page = new Page();

    expect(method_exists($page, 'getRows'))->toBeTrue();
    expect($page->getRows())->toBeArray();
});

test('page has schema definition', function (): void {
    $page = new Page();

    $reflection = new ReflectionClass($page);
    $schemaProperty = $reflection->getProperty('schema');

    expect($schemaProperty->isProtected())->toBeTrue();

    $schema = $schemaProperty->getValue($page);
    expect($schema)->toBeArray()
        ->and($schema)->toHaveKey('id')
        ->and($schema)->toHaveKey('title')
        ->and($schema)->toHaveKey('slug')
        ->and($schema)->toHaveKey('content')
        ->and($schema)->toHaveKey('description')
        ->and($schema)->toHaveKey('content_blocks');
});

test('page has getMiddlewareBySlug static method', function (): void {
    expect(method_exists(Page::class, 'getMiddlewareBySlug'))->toBeTrue();

    // Test with non-existent slug returns empty array
    $result = Page::getMiddlewareBySlug('non-existent-slug');
    expect($result)->toBeArray();
});

test('page casts content_blocks to array', function (): void {
    $page = new Page();
    $casts = $page->getCasts();

    expect($casts['content_blocks'])->toBe('array');
});

test('page casts middleware to array', function (): void {
    $page = new Page();
    $casts = $page->getCasts();

    expect($casts['middleware'])->toBe('array');
||||||| 6161e129d
test('page model can be instantiated', function (): void {
    $page = new Page;
    expect($page)->toBeInstanceOf(Page::class);
});

test('page extends BaseModelLang', function (): void {
    $page = new Page;
    expect($page)->toBeInstanceOf(Modules\Cms\Models\BaseModelLang::class);
});

test('page has expected fillable fields', function (): void {
    $page = new Page;
    $fillable = $page->getFillable();

    // Check actual fillable fields from the model
    expect($fillable)->toContain('title')
        ->and($fillable)->toContain('slug')
        ->and($fillable)->toContain('content')
        ->and($fillable)->toContain('description')
        ->and($fillable)->toContain('middleware')
        ->and($fillable)->toContain('content_blocks')
        ->and($fillable)->toContain('sidebar_blocks')
        ->and($fillable)->toContain('footer_blocks');
});

test('page has expected casts', function (): void {
    $page = new Page;
    $casts = $page->getCasts();

    expect($casts)->toBeArray()
        ->and($casts)->toHaveKey('created_at')
        ->and($casts)->toHaveKey('updated_at')
        ->and($casts)->toHaveKey('content_blocks')
        ->and($casts)->toHaveKey('sidebar_blocks')
        ->and($casts)->toHaveKey('footer_blocks')
        ->and($casts)->toHaveKey('middleware');
});

test('page has translatable fields configured', function (): void {
    $page = new Page;

    expect($page->translatable)->toBeArray()
        ->and($page->translatable)->toContain('title')
        ->and($page->translatable)->toContain('content_blocks')
        ->and($page->translatable)->toContain('sidebar_blocks')
        ->and($page->translatable)->toContain('footer_blocks');
});

test('page has SushiToJsons trait', function (): void {
    $page = new Page;
    $traits = class_uses_recursive($page);

    expect(array_values($traits))->toContain(Modules\Tenant\Models\Traits\SushiToJsons::class);
});

test('page has getRows method for sushi functionality', function (): void {
    $page = new Page;

    expect(method_exists($page, 'getRows'))->toBeTrue();
    expect($page->getRows())->toBeArray();
});

test('page has schema definition', function (): void {
    $page = new Page;

    $reflection = new ReflectionClass($page);
    $schemaProperty = $reflection->getProperty('schema');

    expect($schemaProperty->isProtected())->toBeTrue();

    $schema = $schemaProperty->getValue($page);
    expect($schema)->toBeArray()
        ->and($schema)->toHaveKey('id')
        ->and($schema)->toHaveKey('title')
        ->and($schema)->toHaveKey('slug')
        ->and($schema)->toHaveKey('content')
        ->and($schema)->toHaveKey('description')
        ->and($schema)->toHaveKey('content_blocks');
});

test('page has getMiddlewareBySlug static method', function (): void {
    expect(method_exists(Page::class, 'getMiddlewareBySlug'))->toBeTrue();

    // Test with non-existent slug returns empty array
    $result = Page::getMiddlewareBySlug('non-existent-slug');
    expect($result)->toBeArray();
});

test('page casts content_blocks to array', function (): void {
    $page = new Page;
    $casts = $page->getCasts();

    expect($casts['content_blocks'])->toBe('array');
});

test('page casts middleware to array', function (): void {
    $page = new Page;
    $casts = $page->getCasts();

    expect($casts['middleware'])->toBe('array');
=======
describe('Page Model', function (): void {
    test('page model can be instantiated', function (): void {
        $page = new Page();

        expect($page)->toBeInstanceOf(Page::class);
    });

    test('page model has expected fillable fields', function (): void {
        $page = new Page();

        $fillable = $page->getFillable();

        expect($fillable)->toContain('title')
            ->and($fillable)->toContain('slug')
            ->and($fillable)->toContain('content')
            ->and($fillable)->toContain('description')
            ->and($fillable)->toContain('middleware')
            ->and($fillable)->toContain('blocks')
            ->and($fillable)->toContain('content_blocks')
            ->and($fillable)->toContain('sidebar_blocks')
            ->and($fillable)->toContain('footer_blocks');
    });

    test('page model has expected casts', function (): void {
        $page = new Page();

        $casts = $page->getCasts();

        expect($casts)->toHaveKey('content_blocks')
            ->and($casts)->toHaveKey('sidebar_blocks')
            ->and($casts)->toHaveKey('footer_blocks')
            ->and($casts)->toHaveKey('middleware');
    });

    test('page model has translatable fields', function (): void {
        $page = new Page();

        expect($page->translatable)->toContain('title')
            ->and($page->translatable)->toContain('blocks')
            ->and($page->translatable)->toContain('content_blocks')
            ->and($page->translatable)->toContain('sidebar_blocks')
            ->and($page->translatable)->toContain('footer_blocks');
    });

    test('page model has getMiddlewareBySlug method', function (): void {
        expect(method_exists(Page::class, 'getMiddlewareBySlug'))->toBeTrue();
    });

    test('page model uses HasBlocks trait', function (): void {
        $page = new Page();

        expect(in_array('Modules\Cms\Models\Traits\HasBlocks', class_uses_recursive($page)))->toBeTrue();
    });

    test('page model uses SushiToJson trait', function (): void {
        $page = new Page();

        expect(in_array('Modules\Tenant\Models\Traits\SushiToJson', class_uses_recursive($page)))->toBeTrue();
    });

    test('page model has getRows method', function (): void {
        $page = new Page();

        expect(method_exists($page, 'getRows'))->toBeTrue();
    });
>>>>>>> feature/ralph-loop-implementation
});
