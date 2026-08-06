<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
it('GET /it/settings acceptable (likely auth required)', function (): void {
    $res = cmsGet('/it/settings');
});
