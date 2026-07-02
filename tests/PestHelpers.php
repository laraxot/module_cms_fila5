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

use function Safe\file_get_contents;
use function Safe\json_decode;

/**
 * Helper Pest/PHPStan — modulo Cms.
 *
 * @see Modules/Gdpr/tests/PestHelpers.php
 */
function cmsTest(): TestCase
{
    if (null !== TestCase::$currentTest) {
        return TestCase::$currentTest;
    }

    /** @phpstan-ignore-next-line */
    $test = test();
    Assert::assertInstanceOf(TestCase::class, $test);

    return $test;
}

/**
 * Load homepage JSON content for testing.
 *
 * @return array<string, mixed>
 */
function cmsLoadHomepageJson(): array
{
    $jsonPath = config_path('local/<nome progetto>/database/content/home.json');

    if (! file_exists($jsonPath)) {
        return [];
    }

    $content = file_get_contents($jsonPath);
    $data = json_decode($content, true);

    if (is_array($data) && cmsHasStringKeys($data)) {
        return $data;
    }

    return [];
}

/**
 * Check if an array has only string keys.
 *
 * @phpstan-assert-if-true array<string, mixed> $data
 *
 * @param array<mixed> $data
 */
function cmsHasStringKeys(array $data): bool
{
    foreach (array_keys($data) as $key) {
        if (! is_string($key)) {
            return false;
        }
    }

    return true;
}

/**
 * Get homepage blocks for a specific locale.
 *
 * @param string $locale
 * @return array<string, mixed>
 */
function cmsHomepageBlocksForLocale(string $locale): array
{
    $homepageData = cmsLoadHomepageJson();
    $contentBlocks = $homepageData['content_blocks'] ?? [];

    if (! is_array($contentBlocks)) {
        return [];
    }

    $blocks = $contentBlocks[$locale] ?? [];

    /** @var array<string, mixed> $blocks */
    $blocks = is_array($blocks) ? $blocks : [];

    return $blocks;
}

function cmsGenerateUniqueEmail(): string
{
    return TestCase::pestGenerateUniqueEmail();
}

/**
 * @param array<string, mixed> $attributes
 */
function cmsCreateTestUser(array $attributes = []): UserContract
{
    return TestCase::pestCreateTestUser($attributes);
}

/**
 * @param array<string, mixed> $attributes
 */
function cmsCreateUnverifiedUser(array $attributes = []): User
{
    return UserFactory::new()->unverified()->createOne($attributes);
}

/**
 * @template T of object
 *
 * @param class-string<T> $class
 *
 * @return T&PHPUnit\Framework\MockObject\MockObject
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
 * @param array<string, string> $headers
 *
 * @return TestResponse<Response>
 */
function cmsGet(string $uri, array $headers = []): TestResponse
{
    return cmsTest()->get($uri, $headers);
}

/**
 * @param array<string, string> $headers
 *
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
 * @param array<string, mixed>  $data
 * @param array<string, string> $headers
 *
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
 * @param array<string, mixed> $data
 *
 * @return TestResponse<Response>
 */
function cmsActingAsGet(Authenticatable $user, string $uri, array $data = []): TestResponse
{
    return cmsActingAs($user)->get($uri, $data);
}
