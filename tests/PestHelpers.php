<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Modules\Cms\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\json_decode;

/**
 * Helper Pest/PHPStan — modulo Cms.
 *
 * @see Modules/Gdpr/tests/PestHelpers.php
 */

function cmsTest(): TestCase
{
    $test = test();
    Assert::assertInstanceOf(TestCase::class, $test);

    return $test;
}

function cmsGenerateUniqueEmail(): string
{
    return TestCase::pestGenerateUniqueEmail();
}

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
 * @return T&\PHPUnit\Framework\MockObject\MockObject
 */
function cmsCreateMock(string $class): object
{
    return cmsTest()->createPHPUnitMock($class);
}

function cmsMockXotData(): void
{
    XotData::make()->update(['main_module' => 'User']);
}

/**
 * @return string
 */
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
 * @param  array<string, string>  $headers
 * @return TestResponse<Response>
 */
function cmsGet(string $uri, array $headers = []): TestResponse
{
    return cmsTest()->get($uri, $headers);
}

/**
 * @param  array<string, mixed>  $data
 * @param  array<string, string>  $headers
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
    cmsTest()->assertAuthenticated($guard);
}

function cmsAssertGuest(?string $guard = null): void
{
    cmsTest()->assertGuest($guard);
}

/**
 * @param  array<string, mixed>  $data
 * @return TestResponse<Response>
 */
function cmsActingAsGet(Authenticatable $user, string $uri, array $data = []): TestResponse
{
    return cmsActingAs($user)->get($uri, $data);
}
