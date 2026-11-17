<?php

declare(strict_types=1);

it('GET /it/auth/register/thank-you remains absent after legacy page removal', function (): void {
    $res = $this->get('/it/auth/register/thank-you');
    expect($res->getStatusCode())->toBe(404);
});
