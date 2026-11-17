<?php

declare(strict_types=1);

it('GET /it/auth/logout_fixed remains absent after legacy route removal', function (): void {
    $res = $this->get('/it/auth/logout_fixed');
    expect($res->getStatusCode())->toBe(404);
});
