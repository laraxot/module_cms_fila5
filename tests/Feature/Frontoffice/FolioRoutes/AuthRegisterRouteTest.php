<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
it('GET /it/auth/register is reachable', function (): void {
    $res = cmsGet('/it/auth/register');
});
