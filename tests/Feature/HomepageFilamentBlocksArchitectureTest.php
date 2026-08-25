<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Modules\Cms\Tests\TestCase;
use Modules\UI\Actions\Block\GetAllBlocksAction;
<<<<<<< .merge_file_OLdN9R
=======
use Modules\UI\View\Components\Render\Blocks;
<<<<<<< .merge_file_XiPVAT
>>>>>>> .merge_file_4mJBKE
use PHPUnit\Framework\Assert;

use function Pest\Laravel\get;

/*
 * Homepage JSON: solo TestCase::homepageJsonForBlocksArchitecture() (PSR-4).
 * Vietato `use function Modules\Cms\Tests\loadHomepage...` — helper globale, senza namespace.
 * Dopo markTestSkipped non mettere return: PHPStan lo segnala come deadCode.unreachable.
 * Story ROOT-17.10.
 */

it('discovers and validates cms and ui blocks', function () {
    // `GetAllBlocksAction` compone QueueableAction: `execute()` e' un metodo di
    // istanza, la chiamata statica funzionava solo per il magic dispatch.
    $allBlocks = app(GetAllBlocksAction::class)->execute();
=======
use PHPUnit\Framework\Assert;

use function Pest\Laravel\get;
<<<<<<< HEAD
=======

use PHPUnit\Framework\Assert;

>>>>>>> laraxot/dev
use function Safe\file_get_contents;
use function Safe\json_decode;

uses(TestCase::class);
>>>>>>> .merge_file_Wot7Er

    $homepageJsonPath = config_path('local/fixcity/database/content/pages/home.json');
    expect(file_exists($homepageJsonPath))->toBeTrue();

    $homepageData = TestCase::homepageJsonForBlocksArchitecture();

    expect($homepageData)->toHaveKeys(['id', 'slug', 'content_blocks']);
    expect($homepageData['slug'])->toBe('home');
    expect($allBlocks->count())->toBeGreaterThan(0);

    $cmsBlocks = $allBlocks->toCollection()->filter(fn (mixed $block) => 'Cms' === $block->module);
    if ($cmsBlocks->count() > 0) {
        $cmsBlocks->each(function (mixed $block) {
            expect($block->toArray())->toHaveKeys(['name', 'class', 'module', 'path']);
            expect(class_exists($block->class))->toBeTrue();
        });
    }
});

<<<<<<< .merge_file_XiPVAT
test('homepage content management through cms works correctly', function () {
<<<<<<< .merge_file_OLdN9R
    $homepageData = TestCase::homepageJsonForBlocksArchitecture();
=======
=======
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
>>>>>>> .merge_file_Wot7Er
        $response = get('/'.$this->lang);
        $response->assertOk();
>>>>>>> .merge_file_4mJBKE

    /** @var array<string, mixed> $contentBlocks */
    $contentBlocks = $homepageData['content_blocks'];

<<<<<<< .merge_file_OLdN9R
    if (! isset($contentBlocks[$this->lang])) {
        $this->markTestSkipped('No content blocks for language '.$this->lang);
    }
=======
        // Load expected content from JSON
<<<<<<< HEAD
       $homepageData = loadHomepageJsonForBlocksArchitectureTest();
=======
        $homepageData = loadHomepageJsonForBlocksArchitectureTest();
>>>>>>> laraxot/dev
>>>>>>> .merge_file_4mJBKE

    $response = get('/'.$this->lang);
    $response->assertOk();

    $content = $response->getContent();

    /** @var array<int, array<string, mixed>> $blocks */
    $blocks = $contentBlocks[$this->lang];

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
    $homepageData = TestCase::homepageJsonForBlocksArchitecture();

    /** @var array<string, mixed> $contentBlocks */
    $contentBlocks = $homepageData['content_blocks'];

    if (! isset($contentBlocks[$this->lang])) {
        $this->markTestSkipped('No content blocks for language '.$this->lang);
    }

<<<<<<< .merge_file_OLdN9R
    $response = get('/'.$this->lang);
    $response->assertOk();
=======
        // Load blocks to verify theme views
<<<<<<< HEAD
       $homepageData = loadHomepageJsonForBlocksArchitectureTest();
=======
        $homepageData = loadHomepageJsonForBlocksArchitectureTest();
>>>>>>> laraxot/dev
>>>>>>> .merge_file_4mJBKE

    $content = $response->getContent();

    expect($content)->toContain('pub_theme::');

    /** @var array<int, array<string, mixed>> $blocks */
    $blocks = $contentBlocks[$this->lang];

    foreach ($blocks as $block) {
        /** @var array<string, mixed> $blockData */
        $blockData = $block['data'];
        if (! isset($blockData['view'])) {
            continue;
        }
        $view = $blockData['view'];
        expect($view)->toStartWith('pub_theme::');
        expect($view)->toContain('components.blocks');
    }
});

<<<<<<< .merge_file_OLdN9R
test('cms handles multilingual content correctly', function () {
    $homepageData = TestCase::homepageJsonForBlocksArchitecture();
=======
    test('cms handles multilingual content correctly', function () {
<<<<<<< HEAD
       $homepageData = loadHomepageJsonForBlocksArchitectureTest();
=======
        $homepageData = loadHomepageJsonForBlocksArchitectureTest();
>>>>>>> laraxot/dev
>>>>>>> .merge_file_4mJBKE

    expect($homepageData['content_blocks'])->toBeArray();
    expect($homepageData['title'])->toBeArray();

<<<<<<< .merge_file_OLdN9R
    /** @var array<string, mixed> $contentBlocks */
    $contentBlocks = $homepageData['content_blocks'];
    /** @var array<string, mixed> $title */
    $title = $homepageData['title'];
=======
<<<<<<< HEAD
       /** @var array<string, mixed> $contentBlocks */
=======
        /** @var array<string, mixed> $contentBlocks */
>>>>>>> laraxot/dev
        $contentBlocks = $homepageData['content_blocks'];
        /** @var array<string, mixed> $title */
        $title = $homepageData['title'];
>>>>>>> .merge_file_4mJBKE

    if (! isset($contentBlocks[$this->lang]) || ! isset($title[$this->lang])) {
        $this->markTestSkipped('Missing multilingual content for language '.$this->lang);
    }

    $response = get('/'.$this->lang);
    $response->assertOk();

<<<<<<< .merge_file_OLdN9R
    $content = $response->getContent();
    expect($content)->toContain($title[$this->lang]);
});
=======
        $content = $response->getContent();
<<<<<<< HEAD
       expect($content)->toContain($title[$this->lang]);
=======
        expect($content)->toContain($title[$this->lang]);
>>>>>>> laraxot/dev
    });
>>>>>>> .merge_file_4mJBKE

test('cms page component passes correct data to blocks', function () {
    $response = get('/'.$this->lang);
    $response->assertOk();

    $content = $response->getContent();

    expect($content)->toContain('side="content"');
    expect($content)->toContain('slug="home"');

    if (auth()->check()) {
        expect($content)->toContain('type=');
    }
});

<<<<<<< .merge_file_OLdN9R
test('cms json storage pattern is consistent', function () {
    $pagesPath = config_path('local/fixcity/database/content/pages/');
    expect(file_exists($pagesPath))->toBeTrue();
=======
    test('cms json storage pattern is consistent', function () {
<<<<<<< HEAD
       $pagesPath = config_path('local/fixcity/database/content/pages/');
=======
        $pagesPath = config_path('local/fixcity/database/content/pages/');
>>>>>>> laraxot/dev
        expect(file_exists($pagesPath))->toBeTrue();
>>>>>>> .merge_file_4mJBKE

    $homepageJsonPath = $pagesPath.'home.json';
    expect(file_exists($homepageJsonPath))->toBeTrue();

    $homepageData = TestCase::homepageJsonForBlocksArchitecture();

    expect($homepageData)->toHaveKeys(['id', 'slug', 'content_blocks']);
    expect($homepageData['slug'])->toBe('home');

<<<<<<< .merge_file_OLdN9R
    /** @var array<string, mixed> $contentBlocks */
    $contentBlocks = $homepageData['content_blocks'];
=======
<<<<<<< HEAD
       /** @var array<string, mixed> $contentBlocks */
=======
        /** @var array<string, mixed> $contentBlocks */
>>>>>>> laraxot/dev
        $contentBlocks = $homepageData['content_blocks'];
>>>>>>> .merge_file_4mJBKE

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

<<<<<<< .merge_file_OLdN9R
test('cms blade syntax processing works in json', function () {
    $homepageData = TestCase::homepageJsonForBlocksArchitecture();
=======
    test('cms blade syntax processing works in json', function () {
<<<<<<< HEAD
       $homepageData = loadHomepageJsonForBlocksArchitectureTest();
=======
        $homepageData = loadHomepageJsonForBlocksArchitectureTest();
>>>>>>> laraxot/dev
>>>>>>> .merge_file_4mJBKE

    /** @var array<string, mixed> $contentBlocks */
    $contentBlocks = $homepageData['content_blocks'];

<<<<<<< .merge_file_OLdN9R
    if (! isset($contentBlocks[$this->lang])) {
        $this->markTestSkipped('No content blocks for language '.$this->lang);
    }
=======
<<<<<<< HEAD
        if ($landingBlock !== null) {
=======
        if (null !== $landingBlock) {
>>>>>>> laraxot/dev
            /** @var array<string, mixed> $landingBlock */
            $landingBlockData = $landingBlock['data'];
            Assert::assertIsArray($landingBlockData);
>>>>>>> .merge_file_4mJBKE

    /** @var array<int, array<string, mixed>> $blocks */
    $blocks = $contentBlocks[$this->lang];
    $landingBlock = collect($blocks)->firstWhere('type', 'landing-page');

    if (null !== $landingBlock) {
        /** @var array<string, mixed> $landingBlockData */
        $landingBlockData = $landingBlock['data'];
        Assert::assertIsArray($landingBlockData);

        Assert::assertArrayHasKey('cta_link', $landingBlockData);
        Assert::assertIsString($landingBlockData['cta_link']);

        expect($landingBlockData['cta_link'])->toContain("{{ route('register') }}");

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

    expect($content)->toContain('<!DOCTYPE html>');
    expect($content)->toContain('<html');
    expect($content)->toContain('<head>');
    expect($content)->toContain('<body>');
    expect($content)->toContain('<title>');

    expect($content)->toContain('<meta name="viewport"');
    expect($content)->toContain('<meta name="description"');
});

test('cms performance for block rendering is acceptable', function () {
    $startTime = microtime(true);

<<<<<<< .merge_file_OLdN9R
    $response = get('/'.$this->lang);
    $response->assertOk();

    $renderTime = microtime(true) - $startTime;

    expect($renderTime)->toBeLessThan(2.0);
});
=======
        // CMS should render blocks efficiently
<<<<<<< HEAD
       expect($renderTime)->toBeLessThan(2.0);
=======
        expect($renderTime)->toBeLessThan(2.0);
>>>>>>> laraxot/dev
    });
>>>>>>> .merge_file_4mJBKE
