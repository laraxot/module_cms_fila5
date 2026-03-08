<?php

declare(strict_types=1);

<<<<<<< HEAD
use function Pest\Laravel\get;
||||||| 6161e129d
use Tests\TestCase;

use function Pest\Laravel\get;
=======
use Modules\Cms\Tests\TestCase;
>>>>>>> feature/ralph-loop-implementation

use Tests\TestCase;

uses(TestCase::class);

test('dashboard routes placeholder', function (): void {
    // Placeholder - actual tests require theme components
    expect(true)->toBeTrue();
});
