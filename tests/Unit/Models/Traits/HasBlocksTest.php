<?php

declare(strict_types=1);

use Modules\Cms\Models\Page;
use Modules\Cms\Models\Section;
use Modules\Cms\Models\Traits\HasBlocks;
use PHPUnit\Framework\Assert;

// Si usano i modelli reali che adottano il trait (Page, Section): un'anonymous class
// ereditata da BaseModel farebbe analizzare il trait fuori dal suo contesto e falserebbe
// i tipi dei suoi metodi.
test('HasBlocks trait can be used', function (): void {
    $model = new Page();

    Assert::assertContains(HasBlocks::class, class_uses_recursive($model));
    Assert::assertSame(
        ['title' => 'plain', 'nested' => ['sum' => '2']],
        $model->compile(['title' => 'plain', 'nested' => ['sum' => '{{ 1 + 1 }}']]),
    );
});

test('HasBlocks trait has static method getBlocksBySlug', function (): void {
    $reflection = new ReflectionMethod(Section::class, 'getBlocksBySlug');

    Assert::assertTrue($reflection->isStatic());
    Assert::assertContains(HasBlocks::class, class_uses_recursive(Section::class));
});
