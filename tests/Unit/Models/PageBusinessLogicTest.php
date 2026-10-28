<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\Page;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

<<<<<<< HEAD
/**
 * Verifica il contratto pubblico del model Page (pagine CMS multilingua).
 */
final class PageBusinessLogicTest extends TestCase
{
    public function test_extends_base_model_lang_for_translations(): void {}

    public function test_declares_translatable_page_fields(): void
    {
        $expected = [
=======
describe('Page Business Logic', function (): void {
    test('page has expected fillable fields', function (): void {
        $page = new Page;
        $expectedFillable = [
            'content',
            'description',
            'slug',
>>>>>>> 127b4277 (.)
            'title',
            'blocks',
            'content_blocks',
            'sidebar_blocks',
            'footer_blocks',
        ];

        Assert::assertSame($expected, (new Page)->translatable);
    }

    public function test_exposes_expected_fillable_attributes(): void
    {
        $expected = [
            'content',
            'description',
            'layout',
            'slug',
            'title',
            'middleware',
            'blocks',
            'content_blocks',
            'sidebar_blocks',
            'footer_blocks',
        ];

        Assert::assertSame($expected, (new Page)->getFillable());
    }

<<<<<<< HEAD
    public function test_uses_sushi_to_json_trait(): void
    {
        Assert::assertArrayHasKey(SushiToJsons::class, class_uses(Page::class));
    }

    public function test_returns_empty_middleware_when_slug_is_unknown(): void
    {
        Assert::assertSame([], Page::getMiddlewareBySlug('non-existent-slug-for-unit-test'));
    }

    public function test_casts_block_fields_and_middleware_as_arrays(): void
    {
        $casts = (new Page)->getCasts();
=======
    test('page has correct casts for blocks and arrays', function (): void {
        $page = new Page;
        $casts = $page->getCasts();
>>>>>>> 127b4277 (.)

        Assert::assertSame('array', $casts['content_blocks']);
        Assert::assertSame('array', $casts['sidebar_blocks']);
        Assert::assertSame('array', $casts['footer_blocks']);
        Assert::assertSame('array', $casts['middleware']);
<<<<<<< HEAD
    }
}
=======
    });

    test('page has schema definition for structured data', function (): void {
        $page = new Page;

        $reflection = new \ReflectionClass($page);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        /** @var array<string, mixed> $schema */
        $schema = $schemaProperty->getValue($page);
        Assert::assertSame('json', $schema['content_blocks']);
        Assert::assertSame('json', $schema['sidebar_blocks']);
        Assert::assertSame('json', $schema['footer_blocks']);
    });
});
>>>>>>> 127b4277 (.)
