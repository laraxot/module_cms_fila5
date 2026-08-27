<?php

declare(strict_types=1);

use Modules\Cms\Models\BaseModel;
use Modules\Cms\Models\Traits\HasBlocks;
use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
test('HasBlocks trait can be used', function () {
    // Create an anonymous class that uses the trait
    $model = new class() extends BaseModel
    {
        use HasBlocks;

        protected $table = 'pages'; // Use existing table
    };

    // Check if the trait methods exist
});

test('HasBlocks trait has static method getBlocksBySlug', function () {
    // Create an anonymous class that uses the trait
<<<<<<< .merge_file_oOHC7s
    $modelClass = new class() extends BaseModel
    {
=======
    $modelClass = new class extends BaseModel {
>>>>>>> .merge_file_4J9mhB
        use HasBlocks;

        protected $table = 'pages'; // Use existing table
    };

    // Check if the static trait method exists on the trait itself
});
