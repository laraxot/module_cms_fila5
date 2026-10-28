<?php

declare(strict_types=1);

use Modules\Cms\Models\BaseModelLang;
use Modules\Cms\Models\Section;
use PHPUnit\Framework\Assert;

test('Section model can be instantiated', function () {
<<<<<<< HEAD
    Assert::assertSame(Section::class, (new Section)::class);
=======
    $section = new Section;
>>>>>>> 127b4277 (.)

});

test('Section model has expected fillable fields', function () {
    $section = new Section;

    $fillable = $section->getFillable();

    // Actual fillable fields from the Section model
    Assert::assertContains('name', $fillable);
    Assert::assertContains('slug', $fillable);
    Assert::assertContains('blocks', $fillable);
});

test('Section model extends BaseModelLang', function () {
<<<<<<< HEAD
    Assert::assertSame(Section::class, (new Section)::class);
=======
    $section = new Section;
>>>>>>> 127b4277 (.)

    // Section extends BaseModelLang for translations support
});

test('Section model has expected casts', function () {
    $section = new Section;

    $casts = $section->getCasts();

    Assert::assertArrayHasKey('slug', $casts);
    Assert::assertArrayHasKey('blocks', $casts);
    Assert::assertArrayHasKey('name', $casts);
});
