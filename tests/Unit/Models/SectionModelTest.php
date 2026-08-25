<?php

declare(strict_types=1);

use Modules\Cms\Models\BaseModelLang;
use Modules\Cms\Models\Section;
use Modules\Cms\Models\Traits\HasBlocks;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('Section Model', function (): void {
    test('section model can be instantiated', function (): void {
        $model = new Section();

<<<<<<< HEAD
       Assert::assertInstanceOf(Section::class, $model);
=======
        Assert::assertInstanceOf(Section::class, $model);
>>>>>>> laraxot/dev
    });

    test('section model has expected fillable fields', function (): void {
        $model = new Section();

        $fillable = $model->getFillable();

<<<<<<< HEAD
       Assert::assertContains('name', $fillable);
=======
        Assert::assertContains('name', $fillable);
>>>>>>> laraxot/dev

        Assert::assertContains('slug', $fillable);

        Assert::assertContains('blocks', $fillable);
    });

    test('section model has expected casts', function (): void {
        $model = new Section();

        $casts = $model->getCasts();

<<<<<<< HEAD
       Assert::assertArrayHasKey('id', $casts);
=======
        Assert::assertArrayHasKey('id', $casts);
>>>>>>> laraxot/dev

        Assert::assertArrayHasKey('slug', $casts);

        Assert::assertArrayHasKey('blocks', $casts);

        Assert::assertArrayHasKey('name', $casts);
    });

    test('section model has translatable fields', function (): void {
        $model = new Section();

<<<<<<< HEAD
       Assert::assertContains('name', $model->translatable);
=======
        Assert::assertContains('name', $model->translatable);
>>>>>>> laraxot/dev

        Assert::assertContains('blocks', $model->translatable);
    });

    test('section model uses HasBlocks trait', function (): void {
        $model = new Section();

<<<<<<< HEAD
       Assert::assertTrue(in_array(HasBlocks::class, class_uses_recursive($model)));
=======
        Assert::assertTrue(in_array(HasBlocks::class, class_uses_recursive($model)));
>>>>>>> laraxot/dev
    });

    test('section model uses SushiToJsons trait', function (): void {
        $model = new Section();

<<<<<<< HEAD
       Assert::assertTrue(in_array(SushiToJsons::class, class_uses_recursive($model)));
=======
        Assert::assertTrue(in_array(SushiToJsons::class, class_uses_recursive($model)));
>>>>>>> laraxot/dev
    });

    test('section model has getRows method', function (): void {
        $model = new Section();
    });

    test('section model extends BaseModelLang', function (): void {
        $model = new Section();

<<<<<<< HEAD
       Assert::assertInstanceOf(BaseModelLang::class, $model);
=======
        Assert::assertInstanceOf(BaseModelLang::class, $model);
>>>>>>> laraxot/dev
    });
});
