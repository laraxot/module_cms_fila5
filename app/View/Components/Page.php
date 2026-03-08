<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;

class Page extends Component
{
    public string $side;

    public string $slug;

    /** @var array<string, BlockData> */
    public array $blocks;

    public array $data = [];

    public string $container0 = '';

    public string $slug0 = '';

    public function __construct(string $side, string $slug, ?string $type = null, array $data = [], string $container0 = '', string $slug0 = '')
    {
<<<<<<< HEAD
        $this->data = $data;
        $this->side = $side;
||||||| 6161e129d
        $this->data = $data;
        $this->side = $side;
        if ($type !== null) {
=======
        $data = $data;
        $side = $side;
>>>>>>> feature/ralph-loop-implementation
        if (null !== $type) {
            $slug = $type.'-'.$slug;
        }
<<<<<<< HEAD
        $this->slug = $slug;
        $this->blocks = PageModel::getBlocksBySlug($slug, $side);
    }

    public function __constructOLD(string $side, string $slug, ?string $type = null, array $data = []): void
    {
        $this->data = $data;
        $this->side = $side;
        if (null !== $type) {
            $slug = $type.'-'.$slug;
        }
        $this->slug = $slug;
        $field = $side.'_blocks';
        // $page = PageModel::firstOrCreate(['slug' => $slug], ['title' => $slug, $field => []]);
        $page = PageModel::firstWhere('slug', $slug);

        if (null === $page) {
            abort(404, 'page not found: '.$slug);
        }
        $metatag = MetatagData::make();

        // Ensure title is string|null, not array
        $title = $page->title;
        if (is_array($title)) {
            $title = null;
        }

        $metatag->concatTitle($title);

        $metatag->concatDescription($page->description);
        $blocks = $page->$field;
        if (is_array($blocks) && ! empty($blocks)) {
            $locales = array_keys($blocks);
            $current_lang = app()->getLocale();
            if (in_array($current_lang, $locales)) {
                $blocks = $blocks[$current_lang];
            } elseif (in_array('it', $locales)) {
                $blocks = $blocks['it'];
            }
        }

        if (! is_array($blocks)) {
            $primary_lang = XotData::make()->primary_lang;
            /* @phpstan-ignore-next-line method.notFound */
            $blocks = $page->getTranslation($field, $primary_lang);
        }
        if (! is_array($blocks)) {
            $blocks = [];
        }
        $blocks = Arr::map($blocks, function ($block) use ($data) {
            if (! is_array($block)) {
                return $block;
            }

            if (! array_key_exists('data', $block)) {
                $block['data'] = $data;

                return $block;
            }

            if (! is_array($block['data'])) {
                $block['data'] = $data;

                return $block;
            }

            $block['data'] = array_merge($data, $block['data']);

            return $block;
        });

        /** @var DataCollection<BlockData> $collection */
        $collection = BlockData::collect($blocks);
        $this->blocks = $collection;
||||||| 6161e129d
        $this->slug = $slug;
        $this->blocks = PageModel::getBlocksBySlug($slug, $side);
    }

    public function __constructOLD(string $side, string $slug, ?string $type = null, array $data = []): void
    {
        $this->data = $data;
        $this->side = $side;
        if ($type !== null) {
            $slug = $type.'-'.$slug;
        }
        $this->slug = $slug;
        $field = $side.'_blocks';
        // $page = PageModel::firstOrCreate(['slug' => $slug], ['title' => $slug, $field => []]);
        $page = PageModel::firstWhere('slug', $slug);

        if ($page === null) {
            abort(404, 'page not found: '.$slug);
        }
        $metatag = MetatagData::make();

        // Ensure title is string|null, not array
        $title = $page->title;
        if (is_array($title)) {
            $title = null;
        }

        $metatag->concatTitle($title);

        $metatag->concatDescription($page->description);
        $blocks = $page->$field;
        if (is_array($blocks) && ! empty($blocks)) {
            $locales = array_keys($blocks);
            $current_lang = app()->getLocale();
            if (in_array($current_lang, $locales)) {
                $blocks = $blocks[$current_lang];
            } elseif (in_array('it', $locales)) {
                $blocks = $blocks['it'];
            }
        }

        if (! is_array($blocks)) {
            $primary_lang = XotData::make()->primary_lang;
            /* @phpstan-ignore-next-line method.notFound */
            $blocks = $page->getTranslation($field, $primary_lang);
        }
        if (! is_array($blocks)) {
            $blocks = [];
        }
        $blocks = Arr::map($blocks, function ($block) use ($data) {
            if (! is_array($block)) {
                return $block;
            }

            if (! array_key_exists('data', $block)) {
                $block['data'] = $data;

                return $block;
            }

            if (! is_array($block['data'])) {
                $block['data'] = $data;

                return $block;
            }

            $block['data'] = array_merge($data, $block['data']);

            return $block;
        });

        /** @var DataCollection<BlockData> $collection */
        $collection = BlockData::collect($blocks);
        $this->blocks = $collection;
=======
        $slug = $slug;
        $container0 = $container0;
        $slug0 = $slug0;
        /* @phpstan-ignore staticMethod.notFound, assign.propertyType */
        $blocks = PageModel::getBlocksBySlug($slug, $side);
>>>>>>> feature/ralph-loop-implementation
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): ViewContract
    {
        $view = 'cms::components.page';
        $view_params = [
            'blocks' => $blocks,
            'side' => $side,
            'slug' => $slug,
            'data' => $data,
            'container0' => $container0,
            'slug0' => $slug0,
        ];
        // @phpstan-ignore-next-line
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $view_params);
    }
}
