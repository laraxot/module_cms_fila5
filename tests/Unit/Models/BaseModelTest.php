<?php

declare(strict_types=1);

use Modules\Cms\Models\BaseModel;

beforeEach(function (): void {
    $this->baseModel = new class extends BaseModel {
        protected $table = 'test_cms_table';
    };
});

test('base model extends eloquent model', function (): void {
});
