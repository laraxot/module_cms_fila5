<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;


uses(Modules\Cms\Tests\TestCase::class);
test('PageSlugMiddleware can be instantiated', function () {
    $middleware = new PageSlugMiddleware();

    Assert::assertInstanceOf(PageSlugMiddleware::class, $middleware);
});

test('PageSlugMiddleware handle method exists', function () {
    $middleware = new PageSlugMiddleware();

    });
