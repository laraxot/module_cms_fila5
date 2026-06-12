<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Support;

use Modules\Cms\Support\PageSchemaBuilder;
use Modules\Cms\Tests\TestCase;
use Modules\User\Models\User;
use Modules\Xot\Datas\MetatagData;
use PHPUnit\Framework\Assert;

final class PageSchemaBuilderTest extends TestCase
{
    /**
     * @param array<string, mixed> $schema
     *
     * @return array<string, mixed>
     */
    private static function pageSchemaMainEntity(array $schema): array
    {
        $mainEntity = $schema['mainEntity'] ?? null;

        /** @var array<string, mixed> $mainEntity */
        return $mainEntity;
    }

    public function test_it_resolves_home_as_webpage(): void
    {
        $builder = new PageSchemaBuilder();
        $schema = $builder->build(
            meta: MetatagData::make(),
            routeName: 'home',
            path: '/',
        );

        Assert::assertArrayHasKey('@type', $schema);
        Assert::assertSame('WebPage', $schema['@type']);
    }

    public function test_it_resolves_events_index_as_collection_page(): void
    {
        $builder = new PageSchemaBuilder();
        $schema = $builder->build(
            meta: MetatagData::make(),
            routeName: 'container0.index',
            path: 'it/events',
            routeParameters: ['container0' => 'events'],
        );

        Assert::assertArrayHasKey('@type', $schema);
        Assert::assertSame('CollectionPage', $schema['@type']);
    }

    public function test_it_resolves_event_detail_as_item_page_with_main_entity(): void
    {
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

        Assert::assertArrayHasKey('@type', $schema);
        Assert::assertSame('ItemPage', $schema['@type']);
        Assert::assertArrayHasKey('mainEntity', $schema);

        $mainEntity = self::pageSchemaMainEntity($schema);
        Assert::assertArrayHasKey('@type', $mainEntity);
        Assert::assertSame('Event', $mainEntity['@type']);
        Assert::assertStringContainsString('/events/test-event-slug', (string) ($mainEntity['url'] ?? ''));
    }

    public function test_it_resolves_profile_route_as_profile_page_with_person_main_entity(): void
    {
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

        Assert::assertArrayHasKey('@type', $schema);
        Assert::assertSame('ProfilePage', $schema['@type']);
        Assert::assertArrayHasKey('mainEntity', $schema);

        $mainEntity = self::pageSchemaMainEntity($schema);
        Assert::assertArrayHasKey('@type', $mainEntity);
        Assert::assertSame('Person', $mainEntity['@type']);
        Assert::assertArrayHasKey('name', $mainEntity);
        Assert::assertSame('Mario Rossi', $mainEntity['name']);
    }

    public function test_it_resolves_public_profile_detail_route_as_profile_page_with_person_identifier(): void
    {
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

        Assert::assertArrayHasKey('@type', $schema);
        Assert::assertSame('ProfilePage', $schema['@type']);
        Assert::assertArrayHasKey('mainEntity', $schema);

        $mainEntity = self::pageSchemaMainEntity($schema);
        Assert::assertArrayHasKey('@type', $mainEntity);
        Assert::assertSame('Person', $mainEntity['@type']);
        Assert::assertArrayHasKey('identifier', $mainEntity);
        Assert::assertSame('019cca1b-1f72-700a-ba0b-0bb414ca0c88', $mainEntity['identifier']);
    }

    public function test_it_keeps_auth_routes_as_generic_webpage(): void
    {
        $builder = new PageSchemaBuilder();
        $schema = $builder->build(
            meta: MetatagData::make(),
            routeName: 'auth.login',
            path: 'auth/login',
        );

        Assert::assertArrayHasKey('@type', $schema);
        Assert::assertSame('WebPage', $schema['@type']);
    }
}
