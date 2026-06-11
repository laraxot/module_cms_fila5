<?php

declare(strict_types=1);

use Modules\Cms\Support\PageSchemaBuilder;
use Modules\User\Models\User;
use Modules\Xot\Datas\MetatagData;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
/**
 * @param array<string, mixed> $schema
 *
 * @return array<string, mixed>
 */
function pageSchemaMainEntity(array $schema): array
{
    $mainEntity = $schema['mainEntity'] ?? null;

    /* @var array<string, mixed> $mainEntity */
    return $mainEntity;
}

test('it resolves home as webpage', function (): void {
    $builder = new PageSchemaBuilder();
    $schema = $builder->build(
        meta: MetatagData::make(),
        routeName: 'home',
        path: '/',
    );
    /* @var array<string, mixed> $schema */

    Assert::assertArrayHasKey('@type', $schema);
    Assert::assertSame('WebPage', $schema['@type']);
});

test('it resolves events index as collection page', function (): void {
    $builder = new PageSchemaBuilder();
    $schema = $builder->build(
        meta: MetatagData::make(),
        routeName: 'container0.index',
        path: 'it/events',
        routeParameters: ['container0' => 'events'],
    );
    /* @var array<string, mixed> $schema */

    Assert::assertArrayHasKey('@type', $schema);
    Assert::assertSame('CollectionPage', $schema['@type']);
});

test('it resolves event detail as item page with main entity', function (): void {
    $builder = new PageSchemaBuilder();
    $schema = $builder->build(
        meta: MetatagData::make(),
        routeName: 'container0.view',
        path: 'it/events/test-event-slug',
        routeParameters: [
            'container0' => 'events',
            'slug0' => 'test-event-slug',
        ],
    );
    /* @var array<string, mixed> $schema */

    Assert::assertArrayHasKey('@type', $schema);
    Assert::assertSame('ItemPage', $schema['@type']);
    Assert::assertArrayHasKey('mainEntity', $schema);

    $mainEntity = pageSchemaMainEntity($schema);
    Assert::assertArrayHasKey('@type', $mainEntity);
    Assert::assertSame('Event', $mainEntity['@type']);
    Assert::assertStringContainsString('/events/test-event-slug', (string) ($mainEntity['url'] ?? ''));
});

test('it resolves profile route as profile page with person main entity', function (): void {
    $builder = new PageSchemaBuilder();
    $user = new User([
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'name' => 'Mario Rossi',
    ]);

    $schema = $builder->build(
        meta: MetatagData::make(),
        routeName: 'profile.edit',
        path: 'profile/edit',
        user: $user,
    );
    /* @var array<string, mixed> $schema */

    Assert::assertArrayHasKey('@type', $schema);
    Assert::assertSame('ProfilePage', $schema['@type']);
    Assert::assertArrayHasKey('mainEntity', $schema);

    $mainEntity = pageSchemaMainEntity($schema);
    Assert::assertArrayHasKey('@type', $mainEntity);
    Assert::assertSame('Person', $mainEntity['@type']);
    Assert::assertArrayHasKey('name', $mainEntity);
    Assert::assertSame('Mario Rossi', $mainEntity['name']);
});

test('it resolves public profile detail route as profile page with person identifier', function (): void {
    $builder = new PageSchemaBuilder();

    $schema = $builder->build(
        meta: MetatagData::make(),
        routeName: 'container0.view',
        path: 'it/profile/019cca1b-1f72-700a-ba0b-0bb414ca0c88',
        routeParameters: [
            'container0' => 'profile',
            'slug0' => '019cca1b-1f72-700a-ba0b-0bb414ca0c88',
        ],
    );
    /* @var array<string, mixed> $schema */

    Assert::assertArrayHasKey('@type', $schema);
    Assert::assertSame('ProfilePage', $schema['@type']);
    Assert::assertArrayHasKey('mainEntity', $schema);

    $mainEntity = pageSchemaMainEntity($schema);
    Assert::assertArrayHasKey('@type', $mainEntity);
    Assert::assertSame('Person', $mainEntity['@type']);
    Assert::assertArrayHasKey('identifier', $mainEntity);
    Assert::assertSame('019cca1b-1f72-700a-ba0b-0bb414ca0c88', $mainEntity['identifier']);
});

test('it keeps auth routes as generic webpage', function (): void {
    $builder = new PageSchemaBuilder();
    $schema = $builder->build(
        meta: MetatagData::make(),
        routeName: 'auth.login',
        path: 'auth/login',
    );
    /* @var array<string, mixed> $schema */

    Assert::assertArrayHasKey('@type', $schema);
    Assert::assertSame('WebPage', $schema['@type']);
});
