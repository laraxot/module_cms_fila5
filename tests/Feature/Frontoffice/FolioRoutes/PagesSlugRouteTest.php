<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

<<<<<<< Updated upstream
it('SKIP dynamic /it/pages/{slug}', function (): void {
=======
it('SKIP dynamic /it/{slug}', function (): void {
>>>>>>> Stashed changes
    /* @phpstan-ignore-next-line property.notFound */
    $this->markTestSkipped('Dynamic pages slug requires fixture.');
});
