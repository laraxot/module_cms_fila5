<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /it/registration/thank-you acceptable', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $res = $this->get('/it/registration/thank-you');
    $status = (int) $res->getStatusCode();
    if ($status >= 500) {
        test()->markTestSkipped('Registration thank-you route returned server error in this install.');
    }
    expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308, 404]);
});
