<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\BaseModelLang;
use Modules\Cms\Models\Page;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

/**
 * Verifica il contratto pubblico del model Page (pagine CMS multilingua).
 */
final class PageBusinessLogicTest extends TestCase
{
    public function testExtendsBaseModelLangForTranslations(): void
    {
        Assert::assertInstanceOf(BaseModelLang::class, new Page());
    }

    public function testDeclaresTranslatablePageFields(): void
    {
        $expected = [
            'title',
            'blocks',
            'content_blocks',
            'sidebar_blocks',
            'footer_blocks',
        ];

        Assert::assertSame($expected, (new Page())->translatable);
    }

    public function testExposesExpectedFillableAttributes(): void
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

        Assert::assertSame($expected, (new Page())->getFillable());
    }

    public function testUsesSushiToJsonTrait(): void
    {
        Assert::assertArrayHasKey(SushiToJsons::class, class_uses(Page::class));
    }

    public function testReturnsEmptyMiddlewareWhenSlugIsUnknown(): void
    {
        Assert::assertSame([], Page::getMiddlewareBySlug('non-existent-slug-for-unit-test'));
    }

    public function testCastsBlockFieldsAndMiddlewareAsArrays(): void
    {
        $casts = (new Page())->getCasts();

        Assert::assertSame('array', $casts['content_blocks']);
        Assert::assertSame('array', $casts['sidebar_blocks']);
        Assert::assertSame('array', $casts['footer_blocks']);
        Assert::assertSame('array', $casts['middleware']);
    }
}
