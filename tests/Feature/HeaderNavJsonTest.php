<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Modules\Tenant\Services\TenantService;
use PHPUnit\Framework\Assert;


uses(Modules\Cms\Tests\TestCase::class);
/**
 * @return array<string, mixed>
 */
function headerNavConfig(): array
{
    $path = TenantService::filePath('database/content/sections/header.json');
    Assert::assertTrue(file_exists($path));
    $config = File::json($path);
    /** @var array<string, mixed> $config */
    return $config;
}

/**
 * @param  array<string, mixed>  $config
 * @return list<array<string, mixed>>
 */
function primaryNavItems(array $config): array
{
    $sections = $config['sections'] ?? null;
    /** @var array<string, mixed> $sections */
    $primaryNav = $sections['primary_nav'] ?? null;
    /** @var array<string, mixed> $primaryNav */
    $items = $primaryNav['items'] ?? [];
    /** @var list<array<string, mixed>> $items */
    return $items;
}

/**
 * @param  list<array<string, mixed>>  $items
 * @return list<string>
 */
function navItemSlugs(array $items): array
{
    return array_map(static function (array $item): string {
        $slug = $item['slug'] ?? '';

        return is_string($slug) ? $slug : '';
    }, $items);
}

it('header.json contiene voci di navigazione primarie', function (): void {
    /** @var list<array<string, mixed>> $items */
    $items = primaryNavItems(headerNavConfig());

    $primary = array_values(array_filter(
        $items,
        static fn (array $item): bool => ($item['nav_group'] ?? 'primary') === 'primary',
    ));
    Assert::assertGreaterThan(0, count($primary));
});

it('header.json ha la struttura corretta con active_patterns', function (): void {
    $config = headerNavConfig();
    $items = primaryNavItems($config);
    foreach ($items as $item) {
        Assert::assertArrayHasKey('label', $item);
        Assert::assertArrayHasKey('url', $item);
        Assert::assertArrayHasKey('nav_group', $item);
        Assert::assertArrayHasKey('order', $item);
        Assert::assertArrayHasKey('enabled', $item);
    }
});

it('header.json contiene link specifici richiesti', function (): void {
    $slugs = navItemSlugs(primaryNavItems(headerNavConfig()));

    Assert::assertContains('amministrazione', $slugs);
    Assert::assertContains('novita', $slugs);
    Assert::assertContains('servizi', $slugs);
    Assert::assertContains('vivere-il-comune', $slugs);
});

it('header.json contiene link secondari richiesti', function (): void {
    /** @var list<array<string, mixed>> $items */
    $items = primaryNavItems(headerNavConfig());

    /** @var list<array<string, mixed>> $secondary */
    $secondary = array_values(array_filter(
        $items,
        static fn (array $item): bool => ($item['nav_group'] ?? 'primary') === 'secondary',
    ));
    $slugs = navItemSlugs($secondary);

    Assert::assertContains('iscrizioni', $slugs);
    Assert::assertContains('estate-in-citta', $slugs);
    Assert::assertContains('polizia-locale', $slugs);
});

it('header.json ha topics_url configurato', function (): void {
    $config = headerNavConfig();
    $sections = $config['sections'] ?? null;
    /** @var array<string, mixed> $sections */
    $primaryNav = $sections['primary_nav'] ?? null;
    /** @var array<string, mixed> $primaryNav */
    $topicsUrl = $primaryNav['topics_url'] ?? null;
    Assert::assertNotNull($topicsUrl);
    Assert::assertStringContainsString('argomenti', (string) $topicsUrl);
});
