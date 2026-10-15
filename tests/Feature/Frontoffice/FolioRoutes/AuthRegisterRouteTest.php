<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;

it('GET /it/auth/register is reachable', function (): void {
    $status = (int) cmsGetOrSkipOnServerError('/it/auth/register')->getStatusCode();

    Assert::assertContains(
        $status,
        [200, 204, 301, 302, 303, 307, 308, 401, 403, 404],
        'Unexpected status for /it/auth/register: '.$status,
    );
});
