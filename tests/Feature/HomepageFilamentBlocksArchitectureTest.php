<?php

declare(strict_types=1);



use Modules\Cms\Tests\TestCase;
use Modules\UI\Actions\Block\GetAllBlocksAction;
use Modules\UI\View\Components\Render\Blocks;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\DataCollection;
use function Pest\Laravel\get;


uses(Modules\Cms\Tests\TestCase::class);
describe('Homepage Filament Builder Blocks - CMS Module', function (): void {
    beforeEach(function (): void {
        /** @var Modules\Cms\Tests\TestCase $this */
        /** @var \Modules\Cms\Tests\TestCase $this */
        $this->lang = app()->getLocale();
    });

    test('homepage renders through cms page component system', function (): void {
        /** @var Modules\Cms\Tests\TestCase $this */
        /** @var \Modules\Cms\Tests\TestCase $this */
        $response = get('/'.$this->lang);
        $response->assertOk();

        $content = (string) $response->getContent();

        Assert::assertStringContainsString('x-page', $content);
        Assert::assertStringContainsString('side="content"', $content);
        Assert::assertStringContainsString('slug="home"', $content);
    });

    test('json content structure is properly loaded by cms', function (): void {
        /** @var Modules\Cms\Tests\TestCase $this */
        /** @var \Modules\Cms\Tests\TestCase $this */
        $homepageJsonPath = config_path('local/fixcity/database/content/home.json');

        /** @var array<string, mixed> $homepageData */
        $homepageData = cmsJsonDecodeFile($homepageJsonPath);
    Assert::assertSame('home', $homepageData['slug']);

        $contentBlocks = $homepageData['content_blocks'] ?? null;
        /** @var array<string, mixed> $contentBlocks */
        Assert::assertArrayHasKey($this->lang, $contentBlocks);

        $blocks = $contentBlocks[$this->lang] ?? [];
        /** @var list<array<string, mixed>> $blocks */

        foreach ($blocks as $block) {
            $data = $block['data'] ?? null;
            /** @var array<string, mixed> $data */
            Assert::assertArrayHasKey('view', $data);
            $view = $data['view'] ?? null;
            Assert::assertIsString($view);
            Assert::assertStringContainsString('::components.blocks.', $view);
        }
    });

    test('cms blocks discovery system works correctly', function (): void {
        /** @var Modules\Cms\Tests\TestCase $this */
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
        /** @var Modules\Cms\Tests\TestCase $this */
        /** @var \Modules\Cms\Tests\TestCase $this */
        /** @var array<string, mixed> $homepageData */
        $homepageData = cmsJsonDecodeFile(config_path('local/fixcity/database/content/home.json'));

        $contentBlocks = $homepageData['content_blocks'] ?? null;
        /** @var array<string, mixed> $contentBlocks */
        $blocks = $contentBlocks[$this->lang] ?? [];
        /** @var list<array<string, mixed>> $blocks */

        $firstBlock = $blocks[0] ?? [];
        /** @var array<string, mixed> $firstBlock */
        $firstData = $firstBlock['data'] ?? [];
        /** @var array<string, mixed> $firstData */
        $view = is_string($firstData['view'] ?? null) ? $firstData['view'] : 'pub_theme::components.blocks.default';

        $component = new Blocks($view, $blocks);
        Assert::assertEquals($blocks, $component->blocks);
    });

    test('homepage content management through cms works correctly', function (): void {
        /** @var Modules\Cms\Tests\TestCase $this */
        /** @var \Modules\Cms\Tests\TestCase $this */
        $response = get('/'.$this->lang);
        $response->assertOk();

        $content = (string) $response->getContent();

        /** @var array<string, mixed> $homepageData */
        $homepageData = cmsJsonDecodeFile(config_path('local/fixcity/database/content/home.json'));

        $contentBlocks = $homepageData['content_blocks'] ?? null;
        /** @var array<string, mixed> $contentBlocks */
        $blocks = $contentBlocks[$this->lang] ?? [];
        /** @var list<array<string, mixed>> $blocks */

        foreach ($blocks as $block) {
            $data = $block['data'] ?? null;
            if (! is_array($data)) {
                continue;
            }
            /** @var array<string, mixed> $data */
            if (isset($data['title']) && is_string($data['title'])) {
                Assert::assertStringContainsString($data['title'], $content);
            }
            if (isset($data['subtitle']) && is_string($data['subtitle'])) {
                Assert::assertStringContainsString($data['subtitle'], $content);
            }
        }
    });

    test('cms theme integration renders blocks correctly', function (): void {
        /** @var Modules\Cms\Tests\TestCase $this */
        /** @var \Modules\Cms\Tests\TestCase $this */
        $response = get('/'.$this->lang);
        $response->assertOk();

        $content = (string) $response->getContent();

        Assert::assertStringContainsString('pub_theme::', $content);

        /** @var array<string, mixed> $homepageData */
        $homepageData = cmsJsonDecodeFile(config_path('local/fixcity/database/content/home.json'));

        $contentBlocks = $homepageData['content_blocks'] ?? null;
        /** @var array<string, mixed> $contentBlocks */
        $blocks = $contentBlocks[$this->lang] ?? [];
        /** @var list<array<string, mixed>> $blocks */

        foreach ($blocks as $block) {
            $data = $block['data'] ?? null;
            /** @var array<string, mixed> $data */
            $view = $data['view'] ?? null;
            Assert::assertIsString($view);
            Assert::assertStringStartsWith('pub_theme::', $view);
            Assert::assertStringContainsString('components.blocks', $view);
        }
    });

    test('cms handles multilingual content correctly', function (): void {
        /** @var Modules\Cms\Tests\TestCase $this */
        /** @var \Modules\Cms\Tests\TestCase $this */
        /** @var array<string, mixed> $homepageData */
        $homepageData = cmsJsonDecodeFile(config_path('local/fixcity/database/content/home.json'));

        $contentBlocks = $homepageData['content_blocks'] ?? null;
        /** @var array<string, mixed> $contentBlocks */
        Assert::assertArrayHasKey($this->lang, $contentBlocks);

        $titleByLocale = $homepageData['title'] ?? null;
        /** @var array<string, mixed> $titleByLocale */
        Assert::assertArrayHasKey($this->lang, $titleByLocale);

        $response = get('/'.$this->lang);
        $response->assertOk();

        $content = (string) $response->getContent();
        $title = $titleByLocale[$this->lang] ?? null;
        Assert::assertIsString($title);
        Assert::assertStringContainsString($title, $content);
    });

    test('cms page component passes correct data to blocks', function (): void {
        /** @var Modules\Cms\Tests\TestCase $this */
        /** @var \Modules\Cms\Tests\TestCase $this */
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
        /** @var Modules\Cms\Tests\TestCase $this */
        $pagesPath = config_path('local/fixcity/database/content/');
        $homepageJsonPath = $pagesPath.'home.json';

        /** @var array<string, mixed> $homepageData */
        $homepageData = cmsJsonDecodeFile($homepageJsonPath);
    Assert::assertSame('home', $homepageData['slug']);

        $contentBlocks = $homepageData['content_blocks'] ?? null;
        /** @var array<string, mixed> $contentBlocks */

        foreach ($contentBlocks as $locale => $blocks) {
            /** @var list<array<string, mixed>> $blocks */

            foreach ($blocks as $block) {
                $data = $block['data'] ?? null;
                /** @var array<string, mixed> $data */
                Assert::assertArrayHasKey('view', $data);
            }
        }
    });

    test('cms blade syntax processing works in json', function (): void {
        /** @var Modules\Cms\Tests\TestCase $this */
        /** @var \Modules\Cms\Tests\TestCase $this */
        /** @var array<string, mixed> $homepageData */
        $homepageData = cmsJsonDecodeFile(config_path('local/fixcity/database/content/home.json'));

        $contentBlocks = $homepageData['content_blocks'] ?? null;
        /** @var array<string, mixed> $contentBlocks */
        $blocks = $contentBlocks[$this->lang] ?? [];
        /** @var list<array<string, mixed>> $blocks */

        $landingBlock = collect($blocks)->firstWhere('type', 'landing-page');

        if (is_array($landingBlock)) {
            /** @var array<string, mixed> $landingBlock */
            $data = $landingBlock['data'] ?? null;
            /** @var array<string, mixed> $data */
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
        /** @var Modules\Cms\Tests\TestCase $this */
        /** @var \Modules\Cms\Tests\TestCase $this */
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
        /** @var Modules\Cms\Tests\TestCase $this */
        /** @var \Modules\Cms\Tests\TestCase $this */
        $startTime = microtime(true);

        $response = get('/'.$this->lang);
        $response->assertOk();

        $renderTime = microtime(true) - $startTime;

        Assert::assertLessThan(2.0, $renderTime, 'CMS block rendering should be fast');
    });
});
