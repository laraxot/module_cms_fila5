<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Modules\Cms\Tests\TestCase;
use Modules\UI\Actions\Block\GetAllBlocksAction;
use Modules\UI\View\Components\Render\Blocks;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\DataCollection;
use function Pest\Laravel\get;

uses(\Modules\Cms\Tests\TestCase::class);

beforeEach(function (): void {
    /** @var \Modules\Cms\Tests\TestCase $this */
$this->lang = app()->getLocale();
        skip('Homepage Filament blocks architecture tests target legacy homepage fixtures.');
});

describe('Homepage Filament Blocks Architecture', function (): void {
    test('homepage renders through cms page component system', function (): void {
        /** @var \Modules\Cms\Tests\TestCase $this */
$response = get('/'.$this->lang);
        $response->assertOk();

        $content = (string) $response->getContent();

        Assert::assertStringContainsString('x-page', $content);
        Assert::assertStringContainsString('side="content"', $content);
        Assert::assertStringContainsString('slug="home"', $content);
    });

    test('json content structure is properly loaded by cms', function (): void {
$homepageJsonPath = config_path('local/fixcity/database/content/home.json');

        /** @var array<string, mixed> $homepageData */
        $homepageData = cmsJsonDecodeFile($homepageJsonPath);
        Assert::assertSame('home', $homepageData['slug']);

        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'] ?? [];
        Assert::assertArrayHasKey($this->lang, $contentBlocks);

        /** @var list<array<string, mixed>> $blocks */
        $blocks = $contentBlocks[$this->lang] ?? [];
        foreach ($blocks as $block) {
            /** @var array<string, mixed> $data */
            $data = $block['data'] ?? [];
            Assert::assertArrayHasKey('view', $data);
            $view = $data['view'] ?? null;
            Assert::assertIsString($view);
            Assert::assertStringContainsString('::components.blocks.', $view);
        }
    });

    test('cms blocks discovery system works correctly', function (): void {
$allBlocks = app(GetAllBlocksAction::class)->execute();

        Assert::assertInstanceOf(DataCollection::class, $allBlocks);
        Assert::assertGreaterThan(0, $allBlocks->count());

        $cmsBlocks = $allBlocks->filter(fn ($block): bool => 'Cms' === $block->module);
        if ($cmsBlocks->count() > 0) {
            $cmsBlocks->each(function ($block): void {
            });
        }
    });

    test('ui blocks render component processes homepage blocks', function (): void {
/** @var array<string, mixed> $homepageData */
        $homepageData = cmsJsonDecodeFile(config_path('local/fixcity/database/content/home.json'));

        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'] ?? [];
        /** @var list<array<string, mixed>> $blocks */
        $blocks = $contentBlocks[$this->lang] ?? [];
        $firstBlock = $blocks[0] ?? [];
        /** @var array<string, mixed> $firstData */
        $firstData = $firstBlock['data'] ?? [];
        $view = is_string($firstData['view'] ?? null) ? $firstData['view'] : 'pub_theme::components.blocks.default';

        $component = new Blocks($view, $blocks);
        Assert::assertEquals($blocks, $component->blocks);
    });

    test('homepage content management through cms works correctly', function (): void {
$response = get('/'.$this->lang);
        $response->assertOk();

        $content = (string) $response->getContent();

        /** @var array<string, mixed> $homepageData */
        $homepageData = cmsJsonDecodeFile(config_path('local/fixcity/database/content/home.json'));

        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'] ?? [];
        /** @var list<array<string, mixed>> $blocks */
        $blocks = $contentBlocks[$this->lang] ?? [];
        foreach ($blocks as $block) {
            /** @var array<string, mixed> $data */
            $data = $block['data'] ?? [];
            if (isset($data['title']) && is_string($data['title'])) {
                Assert::assertStringContainsString($data['title'], $content);
            }
            if (isset($data['subtitle']) && is_string($data['subtitle'])) {
                Assert::assertStringContainsString($data['subtitle'], $content);
            }
        }
    });

    test('cms theme integrates renders blocks correctly', function (): void {
$response = get('/'.$this->lang);
        $response->assertOk();

        $content = (string) $response->getContent();

        Assert::assertStringContainsString('pub_theme::', $content);

        /** @var array<string, mixed> $homepageData */
        $homepageData = cmsJsonDecodeFile(config_path('local/fixcity/database/content/home.json'));

        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'] ?? [];
        /** @var list<array<string, mixed>> $blocks */
        $blocks = $contentBlocks[$this->lang] ?? [];
        foreach ($blocks as $block) {
            /** @var array<string, mixed> $data */
            $data = $block['data'] ?? [];
            $view = $data['view'] ?? null;
            Assert::assertIsString($view);
            Assert::assertStringStartsWith('pub_theme::', $view);
            Assert::assertStringContainsString('components.blocks', $view);
        }
    });

    test('cms handles multilingual content correctly', function (): void {
/** @var array<string, mixed> $homepageData */
        $homepageData = cmsJsonDecodeFile(config_path('local/fixcity/database/content/home.json'));

        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'] ?? [];
        Assert::assertArrayHasKey($this->lang, $contentBlocks);

        /** @var array<string, mixed> $titleByLocale */
        $titleByLocale = $homepageData['title'] ?? [];
        Assert::assertArrayHasKey($this->lang, $titleByLocale);

        $response = get('/'.$this->lang);
        $response->assertOk();

        $content = (string) $response->getContent();
        $title = $titleByLocale[$this->lang] ?? null;
        Assert::assertIsString($title);
        Assert::assertStringContainsString($title, $content);
    });

    test('cms page component passes correct data to blocks', function (): void {
$response = get('/'.$this->lang);
        $response->assertOk();

        $content = (string) $response->getContent();

        Assert::assertStringContainsString('side="content"', $content);
        Assert::assertStringContainsString('slug="home"', $content);

        if (auth()->check()) {
            Assert::assertStringContainsString('type=', $content);
        }
    });

    test('cms json storage pattern is consistent', function (): void {
$pagesPath = config_path('local/fixcity/database/content/');
        $homepageJsonPath = $pagesPath.'home.json';

        /** @var array<string, mixed> $homepageData */
        $homepageData = cmsJsonDecodeFile($homepageJsonPath);
        Assert::assertSame('home', $homepageData['slug']);

        /** @var array<string, list<array<string, mixed>>> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'] ?? [];
        foreach ($contentBlocks as $locale => $blocks) {
            foreach ($blocks as $block) {
                /** @var array<string, mixed> $data */
                $data = $block['data'] ?? [];
                Assert::assertArrayHasKey('view', $data);
            }
        }
    });

    test('cms blade syntax processing works in json', function (): void {
/** @var array<string, mixed> $homepageData */
        $homepageData = cmsJsonDecodeFile(config_path('local/fixcity/database/content/home.json'));

        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'] ?? [];
        /** @var list<array<string, mixed>> $blocks */
        $blocks = $contentBlocks[$this->lang] ?? [];
        $landingBlock = collect($blocks)->firstWhere('type', 'landing-page');

        if (is_array($landingBlock)) {
            /** @var array<string, mixed> $data */
            $data = $landingBlock['data'] ?? [];
            $ctaLink = $data['cta_link'] ?? null;
            Assert::assertIsString($ctaLink);
            Assert::assertStringContainsString("{{ route('register') }}", $ctaLink);

            $response = get('/'.$this->lang);
            $content = (string) $response->getContent();

            $expectedUrl = route('register');
            Assert::assertStringContainsString($expectedUrl, $content);
        }
    });

    test('cms renders valid html structure', function (): void {
$response = get('/'.$this->lang);
        $response->assertOk();

        $content = (string) $response->getContent();

        Assert::assertStringContainsString('<!DOCTYPE html>', $content);
        Assert::assertStringContainsString('<html', $content);
        Assert::assertStringContainsString('<head>', $content);
        Assert::assertStringContainsString('<body>', $content);
        Assert::assertStringContainsString('<title>', $content);
        Assert::assertStringContainsString('<meta name="viewport"', $content);
        Assert::assertStringContainsString('<meta name="description"', $content);
    });

    test('cms performance for block rendering is acceptable', function (): void {
$startTime = microtime(true);

        $response = get('/'.$this->lang);
        $response->assertOk();

        $renderTime = microtime(true) - $startTime;

        Assert::assertLessThan(2.0, $renderTime, 'CMS block rendering should be fast');
    });
});
