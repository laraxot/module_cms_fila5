<?php

declare(strict_types=1);

it('GET /it/settings acceptable (likely auth required)', function (): void {
    cmsGet('/it/settings');});
