<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Models\Traits\HasBlocks;

// Create a test model that uses the trait
class TestModelWithBlocks extends Modules\Cms\Models\BaseModel
{
    use HasBlocks;

    protected $table = 'pages'; // Use existing table
}

test('HasBlocks trait can be used', function () {
    $model = new TestModelWithBlocks();

    // Check if the trait methods exist
    expect(method_exists($model, 'getBlocks'))->toBeTrue()
        ->and(method_exists($model, 'compile'))->toBeTrue();
});

test('HasBlocks trait has static method getBlocksBySlug', function () {
    // Check if the static trait method exists
    expect(method_exists(TestModelWithBlocks::class, 'getBlocksBySlug'))->toBeTrue();
});
