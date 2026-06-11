<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
it('GET /it/auth/login is reachable', function (): void {
    $res = cmsGet('/it/auth/login');
});
