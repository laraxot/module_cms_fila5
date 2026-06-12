<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Modules\Cms\Tests\TestCase;
use Modules\UI\Actions\Block\GetAllBlocksAction;
use Modules\UI\View\Components\Render\Blocks;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\DataCollection;

final class HomepageFilamentBlocksArchitectureTest extends TestCase
{
    public string $lang = 'it';

    protected function setUp(): void
    {
        parent::setUp();
        $this->lang = app()->getLocale();
        $this->markTestSkipped('Homepage Filament blocks architecture tests target legacy homepage fixtures.');
    }

    public function test_homepage_renders_through_cms_page_component_system(): void
    {
        $response = $this->get('/'.$this->lang);
        $response->assertOk();

        $content = (string) $response->getContent();

        Assert::assertStringContainsString('x-page', $content);
        Assert::assertStringContainsString('side="content"', $content);
        Assert::assertStringContainsString('slug="home"', $content);
    }

    public function test_json_content_structure_is_properly_loaded_by_cms(): void
    {
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
    }

    public function test_cms_blocks_discovery_system_works_correctly(): void
    {
        $allBlocks = app(GetAllBlocksAction::class)->execute();

        Assert::assertInstanceOf(DataCollection::class, $allBlocks);
        Assert::assertGreaterThan(0, $allBlocks->count());

        $cmsBlocks = $allBlocks->filter(fn ($block): bool => 'Cms' === $block->module);
        if ($cmsBlocks->count() > 0) {
            $cmsBlocks->each(function ($block): void {
            });
        }
    }

    public function test_ui_blocks_render_component_processes_homepage_blocks(): void
    {
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
    }

    public function test_homepage_content_management_through_cms_works_correctly(): void
    {
        $response = $this->get('/'.$this->lang);
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
    }

    public function test_cms_theme_integrates_renders_blocks_correctly(): void
    {
        $response = $this->get('/'.$this->lang);
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
    }

    public function test_cms_handles_multilingual_content_correctly(): void
    {
        /** @var array<string, mixed> $homepageData */
        $homepageData = cmsJsonDecodeFile(config_path('local/fixcity/database/content/home.json'));

        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = $homepageData['content_blocks'] ?? [];
        Assert::assertArrayHasKey($this->lang, $contentBlocks);

        /** @var array<string, mixed> $titleByLocale */
        $titleByLocale = $homepageData['title'] ?? [];
        Assert::assertArrayHasKey($this->lang, $titleByLocale);

        $response = $this->get('/'.$this->lang);
        $response->assertOk();

        $content = (string) $response->getContent();
        $title = $titleByLocale[$this->lang] ?? null;
        Assert::assertIsString($title);
        Assert::assertStringContainsString($title, $content);
    }

    public function test_cms_page_component_passes_correct_data_to_blocks(): void
    {
        $response = $this->get('/'.$this->lang);
        $response->assertOk();

        $content = (string) $response->getContent();

        Assert::assertStringContainsString('side="content"', $content);
        Assert::assertStringContainsString('slug="home"', $content);

        if (auth()->check()) {
            Assert::assertStringContainsString('type=', $content);
        }
    }

    public function test_cms_json_storage_pattern_is_consistent(): void
    {
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
    }

    public function test_cms_blade_syntax_processing_works_in_json(): void
    {
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

            $response = $this->get('/'.$this->lang);
            $content = (string) $response->getContent();

            $expectedUrl = route('register');
            Assert::assertStringContainsString($expectedUrl, $content);
        }
    }

    public function test_cms_renders_valid_html_structure(): void
    {
        $response = $this->get('/'.$this->lang);
        $response->assertOk();

        $content = (string) $response->getContent();

        Assert::assertStringContainsString('<!DOCTYPE html>', $content);
        Assert::assertStringContainsString('<html', $content);
        Assert::assertStringContainsString('<head>', $content);
        Assert::assertStringContainsString('<body>', $content);
        Assert::assertStringContainsString('<title>', $content);
        Assert::assertStringContainsString('<meta name="viewport"', $content);
        Assert::assertStringContainsString('<meta name="description"', $content);
    }

    public function test_cms_performance_for_block_rendering_is_acceptable(): void
    {
        $startTime = microtime(true);

        $response = $this->get('/'.$this->lang);
        $response->assertOk();

        $renderTime = microtime(true) - $startTime;

        Assert::assertLessThan(2.0, $renderTime, 'CMS block rendering should be fast');
    }
}
