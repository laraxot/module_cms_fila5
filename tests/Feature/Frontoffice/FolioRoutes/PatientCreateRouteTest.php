<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);


        return;
    }

    expect(in_array($status, [200, 204, 301, 302, 303, 307, 308, 401, 403, 404], true))->toBeTrue();
});
