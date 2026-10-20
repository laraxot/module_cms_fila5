<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Modules\UI\Actions\Block\GetAllBlocksAction;
use Modules\UI\View\Components\Render\Blocks;

use function Pest\Laravel\get;
use function Safe\file_get_contents;
use function Safe\json_decode;

describe('Homepage Filament Builder Blocks - CMS Module', function () {
    beforeEach(function () {
        $this->lang = app()->getLocale();
    });

    test('homepage renders through cms page component system', function () {
        $response = get('/'.$this->lang);
        $response->assertOk();

        $content = $response->getContent();

        // Verify CMS page component integration
        expect($content)->toContain('x-page');
        expect($content)->toContain('side="content"');
        expect($content)->toContain('slug="home"');
    });

    test('json content structure is properly loaded by cms', function () {
        $homepageJsonPath = config_path('local/<nome progetto>/database/content/pages/home.json');
        expect(file_exists($homepageJsonPath))->toBeTrue('Homepage JSON must exist for CMS');

        $homepageData = cmsJsonDecodeFile($homepageJsonPath);

        // Verify CMS-specific JSON structure
        expect($homepageData)->toHaveKeys(['id', 'slug', 'content_blocks']);
        expect($homepageData['slug'])->toBe('home');
        expect($homepageData['content_blocks'])->toHaveKey($this->lang);

        // Verify blocks structure for CMS processing
        $blocks = cmsHomepageBlocks($this->lang);
        foreach ($blocks as $block) {
            expect($block)->toHaveKeys(['type', 'data']);
            expect($block['data'])->toHaveKey('view');
            expect($block['data']['view'])->toContain('::components.blocks.');
        }
    });

    test('cms blocks discovery system works correctly', function () {
        $allBlocks = app(GetAllBlocksAction::class)->execute();

        expect($allBlocks->count())->toBeGreaterThan(0);

        // Verify CMS blocks are discovered
        $cmsBlocks = collect($allBlocks)->filter(fn ($block) => 'Cms' === $block->module);
        if ($cmsBlocks->count() > 0) {
            foreach ($cmsBlocks as $block) {
                expect($block->toArray())->toHaveKeys(['name', 'class', 'module', 'path']);
                expect(class_exists($block->class))->toBeTrue("CMS block class {$block->class} should exist");
            }
        }
    });

    test('ui blocks render component processes homepage blocks', function () {
        // Verify the UI Blocks render component exists and works
        $blocksClass = Blocks::class;
        expect(class_exists($blocksClass))->toBeTrue('Blocks render component should exist');

        // Load homepage blocks
        $blocks = cmsHomepageBlocks($this->lang);

        // Test component instantiation with blocks
        $component = new $blocksClass('pub_theme::components.blocks', $blocks);
        expect($component->blocks)->toEqual($blocks);
    });

    test('homepage content management through cms works correctly', function () {
        $response = get('/'.$this->lang);
        $response->assertOk();

        $content = $response->getContent();

        // Load expected content from JSON
        $blocks = cmsHomepageBlocks($this->lang);

        // Verify that CMS-managed content appears on page
        foreach ($blocks as $block) {
            if (isset($block['data']['title'])) {
                expect($content)->toContain($block['data']['title']);
            }
            if (isset($block['data']['subtitle'])) {
                expect($content)->toContain($block['data']['subtitle']);
            }
        }
    });

    test('cms theme integration renders blocks correctly', function () {
        $response = get('/'.$this->lang);
        $response->assertOk();

        $content = $response->getContent();

        // Verify theme-specific rendering
        expect($content)->toContain('pub_theme::');

        // Load blocks to verify theme views
        $blocks = cmsHomepageBlocks($this->lang);

        foreach ($blocks as $block) {
            $view = $block['data']['view'];
            expect($view)->toStartWith('pub_theme::');
            expect($view)->toContain('components.blocks');
        }
    });

    test('cms handles multilingual content correctly', function () {
        $homepageData = cmsJsonDecodeFile(config_path('local/<nome progetto>/database/content/pages/home.json'));

        // Verify CMS multilingual structure
        expect($homepageData['content_blocks'])->toBeArray();
        expect($homepageData['title'])->toBeArray();

        // Verify current locale has content
        expect($homepageData['content_blocks'])->toHaveKey($this->lang);
        expect($homepageData['title'])->toHaveKey($this->lang);

        // Test rendering with current locale
        $response = get('/'.$this->lang);
        $response->assertOk();

        $content = $response->getContent();
        $title = $homepageData['title'] ?? null;
        if (! is_array($title) || ! is_string($title[$this->lang] ?? null)) {
            throw new \RuntimeException('Homepage title has an invalid shape.');
        }
        expect($content)->toContain($title[$this->lang]);
    });

    test('cms page component passes correct data to blocks', function () {
        $response = get('/'.$this->lang);
        $response->assertOk();

        $content = $response->getContent();

        // Verify page component attributes are correct
        expect($content)->toContain('side="content"');
        expect($content)->toContain('slug="home"');

        // If user is authenticated, type should be passed
        if (auth()->check()) {
            expect($content)->toContain('type=');
        }
    });

    test('cms json storage pattern is consistent', function () {
        $pagesPath = config_path('local/<nome progetto>/database/content/pages/');
        expect(file_exists($pagesPath))->toBeTrue('CMS pages directory should exist');

        $homepageJsonPath = $pagesPath.'home.json';
        expect(file_exists($homepageJsonPath))->toBeTrue('Homepage JSON should exist');

        $homepageData = cmsJsonDecodeFile($homepageJsonPath);

        // Verify CMS-required fields
        expect($homepageData)->toHaveKeys(['id', 'slug', 'content_blocks']);
        expect($homepageData['slug'])->toBe('home');

        // Verify blocks structure
        $contentBlocks = $homepageData['content_blocks'] ?? null;
        if (! is_array($contentBlocks)) {
                throw new \RuntimeException('Content blocks must be an array.');
        }
        foreach ($contentBlocks as $locale => $blocks) {
            expect($locale)->toBeString();
            if (! is_array($blocks)) {
                throw new \RuntimeException('Blocks must be an array.');
            }
            foreach ($blocks as $block) {
                if (! is_array($block)) {
                    throw new \RuntimeException('Block must be an array.');
                }
                expect($block)->toHaveKeys(['type', 'data']);
                expect($block['type'])->toBeString();
                expect($block['data'])->toBeArray();
                expect($block['data'])->toHaveKey('view');
            }
        }
    });

    test('cms blade syntax processing works in json', function () {
        $blocks = cmsHomepageBlocks($this->lang);
        $landingBlock = collect($blocks)->firstWhere('type', 'landing-page');

        if ($landingBlock) {
            // Verify Blade syntax exists in JSON
            expect($landingBlock['data']['cta_link'])->toContain("{{ route('register') }}");

            // Verify it's processed correctly on the page
            $response = get('/'.$this->lang);
            $content = $response->getContent();

            $expectedUrl = route('register');
            expect($content)->toContain($expectedUrl);
        }
    });

    test('cms renders valid html structure', function () {
        $response = get('/'.$this->lang);
        $response->assertOk();

        $content = $response->getContent();

        // Verify HTML structure
        expect($content)->toContain('<!DOCTYPE html>');
        expect($content)->toContain('<html');
        expect($content)->toContain('<head>');
        expect($content)->toContain('<body>');
        expect($content)->toContain('<title>');

        // Verify meta tags
        expect($content)->toContain('<meta name="viewport"');
        expect($content)->toContain('<meta name="description"');
    });

    test('cms performance for block rendering is acceptable', function () {
        $startTime = microtime(true);

        $response = get('/'.$this->lang);
        $response->assertOk();

        $renderTime = microtime(true) - $startTime;

        // CMS should render blocks efficiently
        expect($renderTime)->toBeLessThan(2.0, 'CMS block rendering should be fast');
    });
});
