<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Modules\UI\Actions\Block\GetAllBlocksAction;
use Modules\UI\View\Components\Render\Blocks;
<<<<<<< HEAD
=======
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\DataCollection;
>>>>>>> 127b4277 (.)

use function Pest\Laravel\get;
use function Safe\file_get_contents;
use function Safe\json_decode;

<<<<<<< HEAD
=======
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

>>>>>>> 127b4277 (.)
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
        // Il loader salta il test se il tenant non ha la homepage e fallisce se la forma non e' valida.
        $homepageData = TestCase::homepageJsonForBlocksArchitecture();
=======
        $homepageJsonPath = config_path('local/fixcity/database/content/pages/home.json');
        expect(file_exists($homepageJsonPath))->toBeTrue();

        $homepageData = loadHomepageJsonForBlocksArchitectureTest();
>>>>>>> 127b4277 (.)

        // Verify CMS-specific JSON structure
        expect($homepageData)->toHaveKeys(['id', 'slug', 'content_blocks']);
        expect($homepageData['slug'])->toBe('home');
<<<<<<< HEAD
        expect($homepageData['content_blocks'])->toHaveKey($this->lang);

        // Verify blocks structure for CMS processing
        $blocks = cmsHomepageBlocks($this->lang);
        foreach ($blocks as $block) {
            expect($block)->toHaveKeys(['type', 'data']);
            expect($block['data'])->toHaveKey('view');
            expect($block['data']['view'])->toContain('::components.blocks.');
=======

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
>>>>>>> 127b4277 (.)
        }
    });

    test('cms blocks discovery system works correctly', function () {
        $allBlocks = app(GetAllBlocksAction::class)->execute();

<<<<<<< HEAD
        expect($allBlocks->count())->toBeGreaterThan(0);

        // Verify CMS blocks are discovered
        $cmsBlocks = collect($allBlocks)->filter(fn ($block) => 'Cms' === $block->module);
        if ($cmsBlocks->count() > 0) {
            foreach ($cmsBlocks as $block) {
                expect($block->toArray())->toHaveKeys(['name', 'class', 'module', 'path']);
                expect(class_exists($block->class))->toBeTrue("CMS block class {$block->class} should exist");
            }
=======
        Assert::assertInstanceOf(DataCollection::class, $allBlocks);
        expect($allBlocks->count())->toBeGreaterThan(0);

        // Verify CMS blocks are discovered
        foreach ($allBlocks->toCollection() as $block) {
            if ($block->module !== 'Cms') {
                continue;
            }

            $blockArray = $block->toArray();
            expect($blockArray)->toHaveKeys(['name', 'class', 'module', 'path']);
            Assert::assertIsString($blockArray['class']);
            expect(class_exists($blockArray['class']))->toBeTrue();
>>>>>>> 127b4277 (.)
        }
    });

    test('ui blocks render component processes homepage blocks', function () {
        // Verify the UI Blocks render component exists and works
<<<<<<< HEAD
        expect(class_exists(Blocks::class))->toBeTrue('Blocks render component should exist');

        // Load homepage blocks
        $blocks = cmsHomepageBlocks($this->lang);

        // Test component instantiation with blocks (stessa vista usata da ThemeComposer)
        $component = new Blocks('ui::components.render.blocks.v1', $blocks);
=======
        $blocksClass = Blocks::class;
        expect(class_exists($blocksClass))->toBeTrue();

        // Load homepage blocks
        $homepageData = loadHomepageJsonForBlocksArchitectureTest();

        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'];
        /** @var array<int, array<string, mixed>> $blocks */
        $blocks = $contentBlocks[$this->lang];

        // Test component instantiation with blocks
        $component = new $blocksClass('cms::components.blocks', $blocks);
>>>>>>> 127b4277 (.)
        expect($component->blocks)->toEqual($blocks);
    });

    test('homepage content management through cms works correctly', function () {
        $response = get('/'.$this->lang);
        $response->assertOk();

        $content = $response->getContent();

        // Load expected content from JSON
<<<<<<< HEAD
        $blocks = cmsHomepageBlocks($this->lang);

        // Verify that CMS-managed content appears on page
        foreach ($blocks as $block) {
            if (isset($block['data']['title'])) {
                expect($content)->toContain($block['data']['title']);
            }
            if (isset($block['data']['subtitle'])) {
                expect($content)->toContain($block['data']['subtitle']);
=======
        $homepageData = loadHomepageJsonForBlocksArchitectureTest();

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
>>>>>>> 127b4277 (.)
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
        $blocks = cmsHomepageBlocks($this->lang);

        foreach ($blocks as $block) {
            $view = $block['data']['view'];
=======
        $homepageData = loadHomepageJsonForBlocksArchitectureTest();

        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'];
        /** @var array<int, array<string, mixed>> $blocks */
        $blocks = $contentBlocks[$this->lang];

        foreach ($blocks as $block) {
            /** @var array<string, mixed> $blockData */
            $blockData = $block['data'];
            $view = $blockData['view'];
>>>>>>> 127b4277 (.)
            expect($view)->toStartWith('pub_theme::');
            expect($view)->toContain('components.blocks');
        }
    });

    test('cms handles multilingual content correctly', function () {
<<<<<<< HEAD
        $homepageData = TestCase::homepageJsonForBlocksArchitecture();

        // Verify current locale has content
        expect($homepageData['content_blocks'])->toHaveKey($this->lang);
        expect($homepageData['title'])->toHaveKey($this->lang);
=======
        $homepageData = loadHomepageJsonForBlocksArchitectureTest();

        // Verify CMS multilingual structure
        expect($homepageData['content_blocks'])->toBeArray();
        expect($homepageData['title'])->toBeArray();

        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'];
        /** @var array<string, mixed> $title */
        $title = $homepageData['title'];

        // Verify current locale has content
        expect($contentBlocks)->toHaveKey($this->lang);
        expect($title)->toHaveKey($this->lang);
>>>>>>> 127b4277 (.)

        // Test rendering with current locale
        $response = get('/'.$this->lang);
        $response->assertOk();

        $content = $response->getContent();
<<<<<<< HEAD
        expect($content)->toContain($homepageData['title'][$this->lang]);
=======
        expect($content)->toContain($title[$this->lang]);
>>>>>>> 127b4277 (.)
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
        // Esistenza della cartella e forma di locale, `type` (string) e `data` (object) di ogni blocco:
        // le verifica il loader (salta senza homepage, fallisce se la forma e' errata).
        $homepageData = TestCase::homepageJsonForBlocksArchitecture();
=======
        $pagesPath = config_path('local/fixcity/database/content/pages/');
        expect(file_exists($pagesPath))->toBeTrue();

        $homepageJsonPath = $pagesPath.'home.json';
        expect(file_exists($homepageJsonPath))->toBeTrue();

        $homepageData = loadHomepageJsonForBlocksArchitectureTest();
>>>>>>> 127b4277 (.)

        // Verify CMS-required fields
        expect($homepageData)->toHaveKeys(['id', 'slug', 'content_blocks']);
        expect($homepageData['slug'])->toBe('home');

<<<<<<< HEAD
        // Verify blocks structure
        foreach ($homepageData['content_blocks'] as $blocks) {
            foreach ($blocks as $block) {
=======
        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'];

        // Verify blocks structure
        foreach ($contentBlocks as $locale => $blocks) {
            Assert::assertIsString($locale);
            expect($blocks)->toBeArray();

            /** @var array<int, array<string, mixed>> $blocks */
            foreach ($blocks as $block) {
                expect($block)->toHaveKeys(['type', 'data']);
                expect($block['type'])->toBeString();
                expect($block['data'])->toBeArray();
>>>>>>> 127b4277 (.)
                expect($block['data'])->toHaveKey('view');
            }
        }
    });

    test('cms blade syntax processing works in json', function () {
<<<<<<< HEAD
        $blocks = cmsHomepageBlocks($this->lang);
        $landingBlock = collect($blocks)->firstWhere('type', 'landing-page');

        if ($landingBlock) {
            // Verify Blade syntax exists in JSON
            expect($landingBlock['data']['cta_link'])->toContain("{{ route('register') }}");
=======
        $homepageData = loadHomepageJsonForBlocksArchitectureTest();

        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'];
        /** @var array<int, array<string, mixed>> $blocks */
        $blocks = $contentBlocks[$this->lang];
        $landingBlock = collect($blocks)->firstWhere('type', 'landing-page');

        if ($landingBlock !== null) {
            /** @var array<string, mixed> $landingBlock */
            $landingBlockData = $landingBlock['data'];
            Assert::assertIsArray($landingBlockData);

            Assert::assertArrayHasKey('cta_link', $landingBlockData);
            Assert::assertIsString($landingBlockData['cta_link']);

            // Verify Blade syntax exists in JSON
            expect($landingBlockData['cta_link'])->toContain("{{ route('register') }}");
>>>>>>> 127b4277 (.)

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
        expect($renderTime)->toBeLessThan(2.0, 'CMS block rendering should be fast');
=======
        expect($renderTime)->toBeLessThan(2.0);
>>>>>>> 127b4277 (.)
    });
});
