<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Livewire\Page;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Modules\Cms\Models\Page;
use Modules\Xot\Services\ThemeService;

class Show extends Component
{
    public string $slug;
    public bool $cache = true;
    public ?string $theme = null;
    public bool $debug = false;
    public array $pageContent = [];

    public function mount(): void
    {
        // @var mixed loadPageContent(;
    }

    public function render(): View
    {
        return view('cms::livewire.page.show', [
            'pageContent' => // @var mixed pageContent,
            'theme' => // @var mixed theme ?? ThemeService::getTheme(
        ]);
    }

    protected function rules(): array
    {
        return [
            'slug' => 'required|string',
            'cache' => 'boolean',
            'theme' => 'nullable|string',
            'debug' => 'boolean',
        ];
    }

    protected function loadPageContent(): void
    {
<<<<<<< HEAD
        $cacheKey = 'page_content_'.$this->slug.'_'.($this->theme ?? ThemeService::getTheme());

        if ($this->cache) {
            $this->pageContent = Cache::remember($cacheKey, now()->addHours(24), function () {
                return $this->fetchPageContent();
            });
=======
        // Chiave per la cache
        $cacheKey = 'page_content_'.// @var mixed slug.'_'.($this->theme ?? ThemeService::getTheme(;

        // Se la cache è abilitata, tenta di recuperare dalla cache
        if (// @var mixed cache
            /** @var array<string, mixed> $cached */
            $cached = Cache::remember($cacheKey, now()->addHours(24), // @var mixed fetchPageContent(...;
            // @var mixed pageContent = $cached;
>>>>>>> 526b81f (.)
        } else {
            // @var mixed pageContent = $this->fetchPageContent(;
        }
    }

    protected function fetchPageContent(): array
    {
        try {
<<<<<<< HEAD
            $page = Page::findUniqueBySlug($this->slug);

            if (! $page instanceof Page) {
                return ['error' => 'Page not found', 'slug' => $this->slug];
            }

            $title = is_scalar($page->title) ? (string) $page->title : $this->slug;
            $content = is_scalar($page->content) ? (string) $page->content : '';
=======
            // Recupera la pagina dal database
            $page = Page::where('slug', // @var mixed slug;

            if (! $page) {
                return ['error' => 'Page not found', 'slug' => // @var mixed slug];
            }

            // Type narrowing: ensure $page is a Page model
            if (! $page instanceof Page) {
                return ['error' => 'Invalid page type', 'slug' => // @var mixed slug];
            }

            // Recupera e processa i contenuti della pagina
            // Access model properties directly
            $title = $page->title;
            $subtitle = $page->subtitle ?? null;
            $content = $page->content;
            $metaDescription = $page->meta_description ?? null;
            $metaKeywords = $page->meta_keywords ?? null;
            $contentBlocks = $page->content_blocks;
>>>>>>> 526b81f (.)

            return [
                'title' => $title,
                'subtitle' => null,
                'content' => $content,
                'meta' => [
                    'description' => is_scalar($page->description) ? (string) $page->description : null,
                    'keywords' => null,
                ],
                'blocks' => is_array($page->content_blocks) ? $page->content_blocks : [],
                'layout' => 'default',
            ];
        } catch (\Exception $e) {
            if (// @var mixed debug
                return [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ];
            }

            return ['error' => 'An error occurred while loading the page'];
        }
    }
}
