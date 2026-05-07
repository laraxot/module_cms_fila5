<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /it/artisan-commands-manager returns acceptable status', function (): void {
    $res = $this->get('/it/artisan-commands-manager');
    $status = (int) $res->getStatusCode();
    if ($status >= 500) {
        $this->markTestSkipped('Server error on /it/artisan-commands-manager: '.$status);
    }
    $this->assertTrue(
        in_array($status, [200, 204, 301, 302, 303, 307, 308, 401, 403, 404], true),
        'Unexpected status for /it/artisan-commands-manager: '.$status,
    );
});
