<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;
use Spatie\LaravelData\DataCollection;

/**
<<<<<<< HEAD
* CMS page shell: blocks loaded by slug. Route/context keys live only in {@see $data}.
=======
 * CMS page shell: blocks loaded by slug. Route/context keys live only in {@see $data}.
>>>>>>> laraxot/dev
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
final class Page extends Component
{
    public string $side;

<<<<<<< HEAD
   public string $slug = '';
=======
    public string $slug = '';
>>>>>>> laraxot/dev

    /** @var DataCollection<int, BlockData>|array<string, BlockData> */
    public DataCollection|array $blocks;

    /** @var array<string, mixed> */
    public array $data = [];

    /**
<<<<<<< HEAD
    * @param array<string, mixed> $data Opaque context bag (container0, slug0, models, …)
=======
     * @param array<string, mixed> $data Opaque context bag (container0, slug0, models, …)
>>>>>>> laraxot/dev
     */
    public function __construct(
        string $side = 'content',
        ?string $slug = null,
        ?string $type = null,
        array $data = [],
    ) {
        $this->side = $side;
        $this->data = $data;

        if (null === $slug && isset($data['slug']) && is_string($data['slug'])) {
            $slug = $data['slug'];
        }

        if (null === $slug) {
            $slug = '';
        }

        if (null !== $type) {
            $slug = $type.'-'.$slug;
        }

        $this->slug = $slug;

<<<<<<< HEAD
       $this->blocks = PageModel::getBlocksBySlug($this->slug, $this->side);
=======
        $this->blocks = PageModel::getBlocksBySlug($this->slug, $this->side);
>>>>>>> laraxot/dev
    }

    public function render(): ViewContract|Factory
    {
        $viewName = 'cms::components.page';

        return view($viewName, array_merge($this->data, [
            'blocks' => $this->blocks,
            'side' => $this->side,
            'slug' => $this->slug,
            'data' => $this->data,
<<<<<<< HEAD
       ]));
=======
        ]));
>>>>>>> laraxot/dev
    }
}
