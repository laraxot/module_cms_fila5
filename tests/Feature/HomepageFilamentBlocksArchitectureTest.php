<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Modules\Cms\Tests\TestCase;
use Modules\UI\Actions\Block\GetAllBlocksAction;
use Modules\UI\View\Components\Render\Blocks;
use PHPUnit\Framework\Assert;

use function Pest\Laravel\get;
<<<<<<< HEAD
=======

use PHPUnit\Framework\Assert;

>>>>>>> laraxot/dev
use function Safe\file_get_contents;
use function Safe\json_decode;

uses(TestCase::class);

/**
 * Carica il JSON dell'homepage usato da questa suite, con narrowing esplicito
 * per evitare di ripetere 7 volte lo stesso json_decode() senza tipizzazione.
 *
 * @return array<string, mixed>
 */
function loadHomepageJsonForBlocksArchitectureTest(): array
{
    $homepageJsonPath = config_path('local/fixcity/database/content/pages/home.json');

    $json = file_get_contents($homepageJsonPath);

    $data = json_decode($json, true);

    Assert::assertIsArray($data);

    $result = [];
    foreach ($data as $key => $value) {
        Assert::assertIsString($key);
        $result[$key] = $value;
    }

    return $result;
}

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
<<<<<<< HEAD
       $homepageJsonPath = config_path('local/fixcity/database/content/pages/home.json');
=======
        $homepageJsonPath = config_path('local/fixcity/database/content/pages/home.json');
>>>>>>> laraxot/dev
        expect(file_exists($homepageJsonPath))->toBeTrue();

        $homepageData = loadHomepageJsonForBlocksArchitectureTest();

        // Verify CMS-specific JSON structure
        expect($homepageData)->toHaveKeys(['id', 'slug', 'content_blocks']);
        expect($homepageData['slug'])->toBe('home');
<<<<<<< HEAD
=======

>>>>>>> laraxot/dev
        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'];
        expect($contentBlocks)->toHaveKey($this->lang);

        // Verify blocks structure for CMS processing
        /** @var array<int, array<string, mixed>> $blocks */
        $blocks = $contentBlocks[$this->lang];
        foreach ($blocks as $block) {
            expect($block)->toHaveKeys(['type', 'data']);

            /** @var array<string, mixed> $blockData */
            $blockData = $block['data'];
            expect($blockData)->toHaveKey('view');
            expect($blockData['view'])->toContain('::components.blocks.');
        }
    });

    test('cms blocks discovery system works correctly', function () {
        $allBlocks = app(GetAllBlocksAction::class)->execute();

<<<<<<< HEAD
       expect($allBlocks->count())->toBeGreaterThan(0);

        // Verify CMS blocks are discovered
        $cmsBlocks = $allBlocks->toCollection()->filter(fn ($block) => $block->module === 'Cms');
=======
        expect($allBlocks->count())->toBeGreaterThan(0);

        // Verify CMS blocks are discovered
        $cmsBlocks = $allBlocks->toCollection()->filter(fn ($block) => 'Cms' === $block->module);
>>>>>>> laraxot/dev
        if ($cmsBlocks->count() > 0) {
            $cmsBlocks->each(function ($block) {
                expect($block->toArray())->toHaveKeys(['name', 'class', 'module', 'path']);
                expect(class_exists($block->class))->toBeTrue();
            });
        }
    });

    test('ui blocks render component processes homepage blocks', function () {
        // Verify the UI Blocks render component exists and works
        $blocksClass = Blocks::class;
<<<<<<< HEAD
       expect(class_exists($blocksClass))->toBeTrue();
=======
        expect(class_exists($blocksClass))->toBeTrue();
>>>>>>> laraxot/dev

        // Load homepage blocks
        $homepageData = loadHomepageJsonForBlocksArchitectureTest();

        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'];
        /** @var array<int, array<string, mixed>> $blocks */
        $blocks = $contentBlocks[$this->lang];

        // Test component instantiation with blocks
        $component = new $blocksClass('cms::components.blocks', $blocks);
        expect($component->blocks)->toEqual($blocks);
    });

    test('homepage content management through cms works correctly', function () {
        $response = get('/'.$this->lang);
        $response->assertOk();

        $content = $response->getContent();

        // Load expected content from JSON
<<<<<<< HEAD
       $homepageData = loadHomepageJsonForBlocksArchitectureTest();
=======
        $homepageData = loadHomepageJsonForBlocksArchitectureTest();
>>>>>>> laraxot/dev

        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'];
        /** @var array<int, array<string, mixed>> $blocks */
        $blocks = $contentBlocks[$this->lang];

        // Verify that CMS-managed content appears on page
        foreach ($blocks as $block) {
            /** @var array<string, mixed> $blockData */
            $blockData = $block['data'];
            if (isset($blockData['title'])) {
                expect($content)->toContain($blockData['title']);
            }
            if (isset($blockData['subtitle'])) {
                expect($content)->toContain($blockData['subtitle']);
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
<<<<<<< HEAD
       $homepageData = loadHomepageJsonForBlocksArchitectureTest();
=======
        $homepageData = loadHomepageJsonForBlocksArchitectureTest();
>>>>>>> laraxot/dev

        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'];
        /** @var array<int, array<string, mixed>> $blocks */
        $blocks = $contentBlocks[$this->lang];

        foreach ($blocks as $block) {
            /** @var array<string, mixed> $blockData */
            $blockData = $block['data'];
            $view = $blockData['view'];
            expect($view)->toStartWith('pub_theme::');
            expect($view)->toContain('components.blocks');
        }
    });

    test('cms handles multilingual content correctly', function () {
<<<<<<< HEAD
       $homepageData = loadHomepageJsonForBlocksArchitectureTest();
=======
        $homepageData = loadHomepageJsonForBlocksArchitectureTest();
>>>>>>> laraxot/dev

        // Verify CMS multilingual structure
        expect($homepageData['content_blocks'])->toBeArray();
        expect($homepageData['title'])->toBeArray();

<<<<<<< HEAD
       /** @var array<string, mixed> $contentBlocks */
=======
        /** @var array<string, mixed> $contentBlocks */
>>>>>>> laraxot/dev
        $contentBlocks = $homepageData['content_blocks'];
        /** @var array<string, mixed> $title */
        $title = $homepageData['title'];

        // Verify current locale has content
        expect($contentBlocks)->toHaveKey($this->lang);
        expect($title)->toHaveKey($this->lang);

        // Test rendering with current locale
        $response = get('/'.$this->lang);
        $response->assertOk();

        $content = $response->getContent();
<<<<<<< HEAD
       expect($content)->toContain($title[$this->lang]);
=======
        expect($content)->toContain($title[$this->lang]);
>>>>>>> laraxot/dev
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
<<<<<<< HEAD
       $pagesPath = config_path('local/fixcity/database/content/pages/');
=======
        $pagesPath = config_path('local/fixcity/database/content/pages/');
>>>>>>> laraxot/dev
        expect(file_exists($pagesPath))->toBeTrue();

        $homepageJsonPath = $pagesPath.'home.json';
        expect(file_exists($homepageJsonPath))->toBeTrue();

        $homepageData = loadHomepageJsonForBlocksArchitectureTest();

        // Verify CMS-required fields
        expect($homepageData)->toHaveKeys(['id', 'slug', 'content_blocks']);
        expect($homepageData['slug'])->toBe('home');

<<<<<<< HEAD
       /** @var array<string, mixed> $contentBlocks */
=======
        /** @var array<string, mixed> $contentBlocks */
>>>>>>> laraxot/dev
        $contentBlocks = $homepageData['content_blocks'];

        // Verify blocks structure
        foreach ($contentBlocks as $locale => $blocks) {
            expect($locale)->not->toBeEmpty();
            expect($blocks)->toBeArray();

            /** @var array<int, array<string, mixed>> $blocks */
            foreach ($blocks as $block) {
                expect($block)->toHaveKeys(['type', 'data']);
                expect($block['type'])->toBeString();
                expect($block['data'])->toBeArray();
                expect($block['data'])->toHaveKey('view');
            }
        }
    });

    test('cms blade syntax processing works in json', function () {
<<<<<<< HEAD
       $homepageData = loadHomepageJsonForBlocksArchitectureTest();
=======
        $homepageData = loadHomepageJsonForBlocksArchitectureTest();
>>>>>>> laraxot/dev

        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'];
        /** @var array<int, array<string, mixed>> $blocks */
        $blocks = $contentBlocks[$this->lang];
        $landingBlock = collect($blocks)->firstWhere('type', 'landing-page');

<<<<<<< HEAD
        if ($landingBlock !== null) {
=======
        if (null !== $landingBlock) {
>>>>>>> laraxot/dev
            /** @var array<string, mixed> $landingBlock */
            $landingBlockData = $landingBlock['data'];
            Assert::assertIsArray($landingBlockData);

            Assert::assertArrayHasKey('cta_link', $landingBlockData);
            Assert::assertIsString($landingBlockData['cta_link']);

            // Verify Blade syntax exists in JSON
            expect($landingBlockData['cta_link'])->toContain("{{ route('register') }}");

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
<<<<<<< HEAD
       expect($renderTime)->toBeLessThan(2.0);
=======
        expect($renderTime)->toBeLessThan(2.0);
>>>>>>> laraxot/dev
    });
});
