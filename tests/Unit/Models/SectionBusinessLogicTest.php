<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\Section;
use Modules\Cms\Models\Traits\HasBlocks;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

<<<<<<< HEAD
/**
 * Verifica il contratto pubblico del model Section (blocchi multilingua).
 */
final class SectionBusinessLogicTest extends TestCase
{
    public function test_extends_base_model_lang_for_translations(): void {}
=======
describe('Section Business Logic', function (): void {
    test('section has expected fillable fields', function (): void {
        $section = new Section;
        $expectedFillable = [
            'name',
            'slug',
            'blocks',
        ];
>>>>>>> 127b4277 (.)

    public function test_declares_translatable_name_and_blocks(): void
    {
        Assert::assertSame(['name', 'blocks'], (new Section)->translatable);
    }

    public function test_exposes_expected_fillable_attributes(): void
    {
        Assert::assertSame(['name', 'slug', 'blocks'], (new Section)->getFillable());
    }

    public function test_uses_sushi_to_json_trait(): void
    {
        Assert::assertArrayHasKey(SushiToJsons::class, class_uses(Section::class));
    }

    public function test_uses_has_blocks_trait(): void
    {
        Assert::assertArrayHasKey(HasBlocks::class, class_uses(Section::class));
    }

<<<<<<< HEAD
    public function test_casts_multilingual_fields_as_arrays(): void
    {
        $casts = (new Section)->getCasts();
=======
        Assert::assertArrayHasKey(HasBlocks::class, $traits);
    });

    test('section has correct casts for multilingual and structured data', function (): void {
        $section = new Section;
        $casts = $section->getCasts();
>>>>>>> 127b4277 (.)

        Assert::assertSame('array', $casts['name']);
        Assert::assertSame('array', $casts['blocks']);
        Assert::assertSame('string', $casts['id']);
<<<<<<< HEAD
    }
}
=======
    });

    test('section has schema definition for structured data', function (): void {
        $section = new Section;

        $reflection = new \ReflectionClass($section);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        /** @var array<string, mixed> $schema */
        $schema = $schemaProperty->getValue($section);
        Assert::assertSame('json', $schema['name']);
        Assert::assertSame('json', $schema['blocks']);
        Assert::assertSame('string', $schema['slug']);
    });

    test('section can get rows for sushi functionality', function (): void {
        $section = new Section;

        Assert::assertNotEmpty($section->getRows());
    });
});
>>>>>>> 127b4277 (.)
