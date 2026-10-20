<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\BaseModelLang;
use Modules\Cms\Models\Section;
use Modules\Cms\Models\Traits\HasBlocks;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

/**
 * Verifica il contratto pubblico del model Section (blocchi multilingua).
 */
final class SectionBusinessLogicTest extends TestCase
{
    public function testExtendsBaseModelLangForTranslations(): void
    {
        Assert::assertInstanceOf(BaseModelLang::class, new Section());
    }

    public function testDeclaresTranslatableNameAndBlocks(): void
    {
        Assert::assertSame(['name', 'blocks'], (new Section())->translatable);
    }

    public function testExposesExpectedFillableAttributes(): void
    {
        Assert::assertSame(['name', 'slug', 'blocks'], (new Section())->getFillable());
    }

    public function testUsesSushiToJsonTrait(): void
    {
        Assert::assertArrayHasKey(SushiToJsons::class, class_uses(Section::class));
    }

    public function testUsesHasBlocksTrait(): void
    {
        Assert::assertArrayHasKey(HasBlocks::class, class_uses(Section::class));
    }

    public function testCastsMultilingualFieldsAsArrays(): void
    {
        $casts = (new Section())->getCasts();

        Assert::assertSame('array', $casts['name']);
        Assert::assertSame('array', $casts['blocks']);
        Assert::assertSame('string', $casts['id']);
    }
}
