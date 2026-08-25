<?php

declare(strict_types=1);

use Modules\Cms\Actions\ResolveBlockQueryAction;
use Modules\Cms\Models\Page;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('ResolveBlockQueryAction can be instantiated', function () {
    $action = new ResolveBlockQueryAction();

    Assert::assertInstanceOf(ResolveBlockQueryAction::class, $action);
});

test('ResolveBlockQueryAction returns empty array when model is null', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([]);

<<<<<<< HEAD
   Assert::assertSame([], $result);
=======
    Assert::assertSame([], $result);
>>>>>>> laraxot/dev
});

test('ResolveBlockQueryAction returns empty array when model class does not exist', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute(['model' => 'NonExistentModelClass']);

<<<<<<< HEAD
   Assert::assertSame([], $result);
=======
    Assert::assertSame([], $result);
>>>>>>> laraxot/dev
});

test('ResolveBlockQueryAction returns empty array when model class is invalid', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute(['model' => '']);

<<<<<<< HEAD
   Assert::assertSame([], $result);
=======
    Assert::assertSame([], $result);
>>>>>>> laraxot/dev
});

test('ResolveBlockQueryAction executes query with model', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'limit' => 10,
        'orderBy' => 'created_at',
        'direction' => 'desc',
    ]);
<<<<<<< HEAD
   /* @var array<string, mixed> $result */
=======
    /* @var array<string, mixed> $result */
>>>>>>> laraxot/dev
    Assert::assertArrayHasKey('items', $result);
    Assert::assertIsArray($result['items']);
});

test('ResolveBlockQueryAction applies scopes', function () {
    $action = new ResolveBlockQueryAction();

    // Test with singular scope
    $result = $action->execute([
        'model' => Page::class,
        'scope' => 'published',
    ]);
<<<<<<< HEAD
   /* @var array<string, mixed> $result */
=======
    /* @var array<string, mixed> $result */
>>>>>>> laraxot/dev
});

test('ResolveBlockQueryAction applies scopes array', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'scopes' => [],
    ]);
<<<<<<< HEAD
   /* @var array<string, mixed> $result */
=======
    /* @var array<string, mixed> $result */
>>>>>>> laraxot/dev
});

test('ResolveBlockQueryAction applies orderBy and direction', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'orderBy' => 'updated_at',
        'direction' => 'asc',
    ]);
<<<<<<< HEAD
   /* @var array<string, mixed> $result */
=======
    /* @var array<string, mixed> $result */
>>>>>>> laraxot/dev
});

test('ResolveBlockQueryAction applies limit', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'limit' => 5,
    ]);
<<<<<<< HEAD
   /* @var array<string, mixed> $result */
=======
    /* @var array<string, mixed> $result */
>>>>>>> laraxot/dev
    Assert::assertArrayHasKey('items', $result);
});

test('ResolveBlockQueryAction uses default wrap_in value', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
    ]);

<<<<<<< HEAD
   Assert::assertArrayHasKey('items', $result);
=======
    Assert::assertArrayHasKey('items', $result);
>>>>>>> laraxot/dev
});

test('ResolveBlockQueryAction uses custom wrap_in value', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'wrap_in' => 'pages',
    ]);

<<<<<<< HEAD
   Assert::assertArrayHasKey('pages', $result);
=======
    Assert::assertArrayHasKey('pages', $result);
>>>>>>> laraxot/dev
});

test('ResolveBlockQueryAction handles non-string wrap_in', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'wrap_in' => 123,
    ]);

<<<<<<< HEAD
   Assert::assertArrayHasKey('items', $result);
=======
    Assert::assertArrayHasKey('items', $result);
>>>>>>> laraxot/dev
});
