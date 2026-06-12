<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Illuminate\Support\Facades\File;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Services\TenantService;
use PHPUnit\Framework\Assert;

final class HeaderNavJsonTest extends TestCase
{
    /**
     * @return array<string, mixed>
     */
    private static function headerNavConfig(): array
    {
        $path = TenantService::filePath('database/content/sections/header.json');
        if (! file_exists($path)) {
            cmsSkipTest('header.json not found in this install: '.$path);
        }

        $decoded = File::json($path);
        if (! is_array($decoded)) {
            cmsSkipTest('header.json is not a valid JSON object: '.$path);
        }

        /** @var array<string, mixed> $config */
        $config = $decoded;

        return $config;
    }

    /**
     * @param array<string, mixed> $config
     *
     * @return list<array<string, mixed>>
     */
    private static function primaryNavItems(array $config): array
    {
        $sections = $config['sections'] ?? null;
        if (! is_array($sections)) {
            return [];
        }

        $primaryNav = $sections['primary_nav'] ?? null;
        if (! is_array($primaryNav)) {
            return [];
        }

        $items = $primaryNav['items'] ?? null;
        if (! is_array($items)) {
            return [];
        }

        /** @var list<array<string, mixed>> $normalized */
        $normalized = [];

        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            /* @var array<string, mixed> $item */
            $normalized[] = $item;
        }

        return $normalized;
    }

    /**
     * @param list<array<string, mixed>> $items
     *
     * @return list<string>
     */
    private static function navItemSlugs(array $items): array
    {
        return array_map(static function (array $item): string {
            $slug = $item['slug'] ?? '';

            return is_string($slug) ? $slug : '';
        }, $items);
    }

    public function testHeaderJsonContieneVociDiNavigazionePrimarie(): void
    {
        /** @var list<array<string, mixed>> $items */
        $items = self::primaryNavItems(self::headerNavConfig());

        $primary = array_values(array_filter(
            $items,
            static fn (array $item): bool => ($item['nav_group'] ?? 'primary') === 'primary',
        ));
        Assert::assertGreaterThan(0, count($primary));
    }

    public function testHeaderJsonHaLaStrutturaCorrettaConActivePatterns(): void
    {
        $config = self::headerNavConfig();
        $items = self::primaryNavItems($config);
        foreach ($items as $item) {
            Assert::assertArrayHasKey('label', $item);
            Assert::assertArrayHasKey('url', $item);
            Assert::assertArrayHasKey('nav_group', $item);
            Assert::assertArrayHasKey('order', $item);
            Assert::assertArrayHasKey('enabled', $item);
        }
    }

    public function testHeaderJsonContieneLinkSpecificiRichiesti(): void
    {
        $slugs = self::navItemSlugs(self::primaryNavItems(self::headerNavConfig()));

        Assert::assertContains('amministrazione', $slugs);
        Assert::assertContains('novita', $slugs);
        Assert::assertContains('servizi', $slugs);
        Assert::assertContains('vivere-il-comune', $slugs);
    }

    public function testHeaderJsonContieneLinkSecondariRichiesti(): void
    {
        /** @var list<array<string, mixed>> $items */
        $items = self::primaryNavItems(self::headerNavConfig());

        /** @var list<array<string, mixed>> $secondary */
        $secondary = array_values(array_filter(
            $items,
            static fn (array $item): bool => ($item['nav_group'] ?? 'primary') === 'secondary',
        ));
        $slugs = self::navItemSlugs($secondary);

        Assert::assertContains('iscrizioni', $slugs);
        Assert::assertContains('estate-in-citta', $slugs);
        Assert::assertContains('polizia-locale', $slugs);
    }

    public function testHeaderJsonHaTopicsUrlConfigurato(): void
    {
        $config = self::headerNavConfig();
        $sections = $config['sections'] ?? null;
        /** @var array<string, mixed> $sections */
        $primaryNav = $sections['primary_nav'] ?? null;
        /** @var array<string, mixed> $primaryNav */
        $topicsUrl = $primaryNav['topics_url'] ?? null;
        Assert::assertNotNull($topicsUrl);
        Assert::assertStringContainsString('argomenti', (string) $topicsUrl);
    }
}
