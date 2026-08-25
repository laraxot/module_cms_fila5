<?php

declare(strict_types=1);

use Modules\Cms\Models\BaseModelLang;
use Modules\Cms\Models\Section;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('Section model can be instantiated', function () {
    $section = new Section();

    Assert::assertInstanceOf(Section::class, $section);
});

test('Section model has expected fillable fields', function () {
    $section = new Section();

    $fillable = $section->getFillable();

    // Actual fillable fields from the Section model
<<<<<<< HEAD
   Assert::assertContains('name', $fillable);
=======
    Assert::assertContains('name', $fillable);
>>>>>>> laraxot/dev
    Assert::assertContains('slug', $fillable);
    Assert::assertContains('blocks', $fillable);
});

test('Section model extends BaseModelLang', function () {
    $section = new Section();

    // Section extends BaseModelLang for translations support
<<<<<<< HEAD
   Assert::assertInstanceOf(BaseModelLang::class, $section);
=======
    Assert::assertInstanceOf(BaseModelLang::class, $section);
>>>>>>> laraxot/dev
});

test('Section model has expected casts', function () {
    $section = new Section();

    $casts = $section->getCasts();
<<<<<<< HEAD
   /* @var array<string, mixed> $casts */
=======
    /* @var array<string, mixed> $casts */
>>>>>>> laraxot/dev
});
