<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
it('SKIP dynamic /it/{slug}', function (): void {
    cmsSkipTest('Dynamic pages slug requires fixture.');
});
