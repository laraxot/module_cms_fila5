<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;
use Modules\Cms\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\MockObject\MockObject;

use function Safe\file_get_contents;
use function Safe\json_decode;

/**
 * Helper Pest/PHPStan — modulo Cms.
 *
 * @see Modules/Gdpr/tests/PestHelpers.php
 */
<<<<<<< HEAD
if (! function_exists('cmsTest')) {
    function cmsTest(): TestCase
    {
        return TestCase::$currentTest ?? throw new LogicException('cmsTest() va chiamato durante un test che estende Modules\Cms\Tests\TestCase.');
=======
function cmsTest(): TestCase
{
    if (TestCase::$currentTest !== null) {
        return TestCase::$currentTest;
>>>>>>> 127b4277 (.)
    }

    $test = test();
    Assert::assertInstanceOf(TestCase::class, $test);

    return $test;
}

function cmsGenerateUniqueEmail(): string
{
    return TestCase::pestGenerateUniqueEmail();
}

<<<<<<< HEAD
if (! function_exists('cmsCreateTestUser')) {
    /**
     * @param  array<string, mixed>  $attributes
     */
    function cmsCreateTestUser(array $attributes = []): XotUserContract
    {
        /** @var XotUserContract $user */
        $user = TestCase::pestCreateTestUser($attributes);

        return $user;
    }
}

if (! function_exists('cmsCreateUnverifiedUser')) {
    /**
     * @param  array<string, mixed>  $attributes
     */
    function cmsCreateUnverifiedUser(array $attributes = []): XotUserContract
    {
        $user = UserFactory::new()->unverified()->createOne($attributes);
        assert($user instanceof XotUserContract);

        return $user;
    }
}

if (! function_exists('cmsCreateMock')) {
    /**
     * @template T of object
     *
     * @param  class-string<T>  $class
     * @return T&MockObject
     */
    function cmsCreateMock(string $class): MockObject
    {
        return cmsTest()->createPHPUnitMock($class);
    }
=======
/**
 * @param  array<string, mixed>  $attributes
 */
function cmsCreateTestUser(array $attributes = []): UserContract
{
    return TestCase::pestCreateTestUser($attributes);
}

/**
 * @param  array<string, mixed>  $attributes
 */
function cmsCreateUnverifiedUser(array $attributes = []): User
{
    return UserFactory::new()->unverified()->createOne($attributes);
}

/**
 * @template T of object
 *
 * @param  class-string<T>  $class
 * @return T&MockObject
 */
function cmsCreateMock(string $class): object
{
    return cmsTest()->createPHPUnitMock($class);
>>>>>>> 127b4277 (.)
}

function cmsMockXotData(): void
{
    XotData::make()->update(['main_module' => 'User']);
}

function cmsReadFile(string $path): string
{
    return file_get_contents($path);
}

/**
 * @return array<string, mixed>
 */
function cmsJsonDecodeFile(string $path): array
{
    /** @var array<string, mixed> $decoded */
    $decoded = json_decode(cmsReadFile($path), true);

    return $decoded;
}

<<<<<<< HEAD
if (! function_exists('cmsHomepageBlocks')) {
    /**
     * Blocchi della homepage del tenant per una lingua (loader tipizzato su `TestCase`).
     *
     * @return list<array{type: string, data: array<string, mixed>}>
     */
    function cmsHomepageBlocks(string $locale): array
    {
        return TestCase::homepageBlocksForLocale($locale);
    }
}

if (! function_exists('cmsGet')) {
    /**
     * @param  array<string, string>  $headers
     * @return TestResponse<Response>
     */
    function cmsGet(string $uri, array $headers = []): TestResponse
    {
        return cmsTest()->get($uri, $headers);
    }
}

if (! function_exists('cmsGetOrSkipOnServerError')) {
    /**
     * @param  array<string, string>  $headers
     * @return TestResponse<Response>
     */
    function cmsGetOrSkipOnServerError(string $uri, array $headers = []): TestResponse
    {
        $response = cmsGet($uri, $headers);
=======
/**
 * @param  array<string, string>  $headers
 * @return TestResponse<Response>
 */
function cmsGet(string $uri, array $headers = []): TestResponse
{
    return cmsTest()->get($uri, $headers);
}

/**
 * @param  array<string, string>  $headers
 * @return TestResponse<Response>
 */
function cmsGetOrSkipOnServerError(string $uri, array $headers = []): TestResponse
{
    $response = cmsGet($uri, $headers);
>>>>>>> 127b4277 (.)

    if ((int) $response->getStatusCode() >= 500) {
        cmsSkipTest('Server error on '.$uri.': '.$response->getStatusCode());
    }

    return $response;
}

<<<<<<< HEAD
if (! function_exists('cmsPost')) {
    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, string>  $headers
     * @return TestResponse<Response>
     */
    function cmsPost(string $uri, array $data = [], array $headers = []): TestResponse
    {
        return cmsTest()->post($uri, $data, $headers);
    }
=======
/**
 * @param  array<string, mixed>  $data
 * @param  array<string, string>  $headers
 * @return TestResponse<Response>
 */
function cmsPost(string $uri, array $data = [], array $headers = []): TestResponse
{
    return cmsTest()->post($uri, $data, $headers);
>>>>>>> 127b4277 (.)
}

function cmsActingAs(Authenticatable $user, ?string $driver = null): TestCase
{
    return cmsTest()->actingAs($user, $driver);
}

<<<<<<< HEAD
if (! function_exists('cmsActingAsGet')) {
    /**
     * Autenticato + GET in un passo (verify-email e route signed).
     *
     * @param  array<string, string>  $headers
     * @return TestResponse<Response>
     */
    function cmsActingAsGet(Authenticatable $user, string $uri, array $headers = []): TestResponse
    {
        return cmsActingAs($user)->get($uri, $headers);
    }
=======
function cmsSkipTest(string $message = ''): void
{
    cmsTest()->markTestSkipped($message);
>>>>>>> 127b4277 (.)
}

function cmsAssertAuthenticated(?string $guard = null): void
{
    Assert::assertTrue(Auth::guard($guard)->check());
}

function cmsAssertGuest(?string $guard = null): void
{
    Assert::assertFalse(Auth::guard($guard)->check());
}

/**
 * @param  array<string, mixed>  $data
 * @return TestResponse<Response>
 */
function cmsActingAsGet(Authenticatable $user, string $uri, array $data = []): TestResponse
{
    return cmsActingAs($user)->get($uri, $data);
}
