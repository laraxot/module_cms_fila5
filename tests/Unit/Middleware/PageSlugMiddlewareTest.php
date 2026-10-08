<?php

declare(strict_types=1);

use Modules\Cms\Http\Middleware\PageSlugMiddleware;
use PHPUnit\Framework\Assert;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

test('PageSlugMiddleware can be instantiated', function () {
    $middleware = new PageSlugMiddleware();

    Assert::assertInstanceOf(PageSlugMiddleware::class, $middleware);
});

test('PageSlugMiddleware passes through requests without a routed CMS page', function () {
    $request = Request::create('/not-a-cms-route');
    $expectedResponse = new Response('next middleware');

    $response = (new PageSlugMiddleware())->handle(
        $request,
        fn (Request $nextRequest): Response => $expectedResponse,
    );

    Assert::assertSame($expectedResponse, $response);
});
