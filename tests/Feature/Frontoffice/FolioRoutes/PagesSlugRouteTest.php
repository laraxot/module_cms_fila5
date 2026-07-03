<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

/* @phpstan-ignore-next-line property.notFound */
it('SKIP dynamic /it/{slug}', function (): void {
    $this->markTestSkipped('Dynamic pages slug requires fixture.');
});
