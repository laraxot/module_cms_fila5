<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;

it('GET /it/patient/referto acceptable', function (): void {
    $status = (int) cmsGetOrSkipOnServerError('/it/patient/referto')->getStatusCode();

    Assert::assertContains(
        $status,
        [200, 204, 301, 302, 303, 307, 308, 401, 403, 404],
        'Unexpected status for /it/patient/referto: '.$status,
    );
});
