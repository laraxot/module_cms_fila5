<?php
namespace Modules\Cms\Tests\Unit;

use Modules\Cms\Tests\TestCase;
use Modules\Cms\Models\Page;

it('has main model class', function () {
    expect(class_exists(Page::class))->toBeTrue();
});

it('has test infrastructure', function () {
    expect(true)->toBeTrue();
});
