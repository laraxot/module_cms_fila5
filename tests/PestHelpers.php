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
function cmsTest(): TestCase
{
<<<<<<< HEAD
    if (TestCase::$currentTest !== null) {
=======
    if (null !== TestCase::$currentTest) {
>>>>>>> laraxot/dev
        return TestCase::$currentTest;
    }

    $test = test();
    Assert::assertInstanceOf(TestCase::class, $test);

    return $test;
}

function cmsGenerateUniqueEmail(): string
{
    return TestCase::pestGenerateUniqueEmail();
}

/**
<<<<<<< HEAD
 * @param  array<string, mixed>  $attributes
=======
 * @param array<string, mixed> $attributes
>>>>>>> laraxot/dev
 */
function cmsCreateTestUser(array $attributes = []): UserContract
{
    return TestCase::pestCreateTestUser($attributes);
}

/**
<<<<<<< HEAD
 * @param  array<string, mixed>  $attributes
=======
 * @param array<string, mixed> $attributes
>>>>>>> laraxot/dev
 */
function cmsCreateUnverifiedUser(array $attributes = []): User
{
    $user = UserFactory::new()->unverified()->createOne($attributes);
    assert($user instanceof User);

    return $user;
}

/**
 * @template T of object
 *
<<<<<<< HEAD
 * @param  class-string<T>  $class
=======
 * @param class-string<T> $class
 *
>>>>>>> laraxot/dev
 * @return T&MockObject
 */
function cmsCreateMock(string $class): object
{
    return cmsTest()->createPHPUnitMock($class);
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

/**
<<<<<<< HEAD
 * @param  array<string, string>  $headers
=======
 * @param array<string, string> $headers
 *
>>>>>>> laraxot/dev
 * @return TestResponse<Response>
 */
function cmsGet(string $uri, array $headers = []): TestResponse
{
    return cmsTest()->get($uri, $headers);
}

/**
<<<<<<< HEAD
 * @param  array<string, string>  $headers
=======
 * @param array<string, string> $headers
 *
>>>>>>> laraxot/dev
 * @return TestResponse<Response>
 */
function cmsGetOrSkipOnServerError(string $uri, array $headers = []): TestResponse
{
    $response = cmsGet($uri, $headers);

    if ((int) $response->getStatusCode() >= 500) {
        cmsSkipTest('Server error on '.$uri.': '.$response->getStatusCode());
    }

    return $response;
}

/**
<<<<<<< HEAD
 * @param  array<string, mixed>  $data
 * @param  array<string, string>  $headers
=======
 * @param array<string, mixed>  $data
 * @param array<string, string> $headers
 *
>>>>>>> laraxot/dev
 * @return TestResponse<Response>
 */
function cmsPost(string $uri, array $data = [], array $headers = []): TestResponse
{
    return cmsTest()->post($uri, $data, $headers);
}

function cmsActingAs(Authenticatable $user, ?string $driver = null): TestCase
{
    return cmsTest()->actingAs($user, $driver);
}

function cmsSkipTest(string $message = ''): void
{
    cmsTest()->markTestSkipped($message);
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
<<<<<<< HEAD
 * @param  array<string, mixed>  $data
=======
 * @param array<string, mixed> $data
 *
>>>>>>> laraxot/dev
 * @return TestResponse<Response>
 */
function cmsActingAsGet(Authenticatable $user, string $uri, array $data = []): TestResponse
{
    return cmsActingAs($user)->get($uri, $data);
}
