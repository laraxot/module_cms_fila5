<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;
use Spatie\LaravelData\DataCollection;

/**
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
final class Page extends Component
{
    public string $side;

    public string $slug;

    public string $container0 = '';

    public string $slug0 = '';

    /** @var DataCollection<BlockData>|array */
    public DataCollection|array $blocks;

    /** @var array<string, mixed> */
    public array $data = [];

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        array $data = [],
        string $side = 'content',
        ?string $slug = null,
        ?string $type = null,
        string $container0 = '',
        string $slug0 = '',
    ) {
        $this->side = $side;
        $this->data = $data;
        $this->container0 = $container0;
        $this->slug0 = $slug0;

        // Resolve slug from data if not passed explicitly
        if (null === $slug && isset($data['slug'])) {
            $slug = (string) $data['slug'];
        }

        // Fallback or composition
        if (null === $slug) {
            $slug = '';
        }

        if ($type !== null) {
            $slug = $type.'-'.$slug;
        }

        $this->slug = $slug;

        // BlockData construction handles URL localization automatically via LocalizeBlockDataAction
        $this->blocks = PageModel::getBlocksBySlug($this->slug, $this->side);
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): ViewContract
    {
        $view = 'cms::components.page';
        $viewParams = [
            ...$this->data,
            'blocks' => $this->blocks,
            'side' => $this->side,
            'slug' => $this->slug,
            'data' => $this->data,
            'container0' => $this->container0,
            'slug0' => $this->slug0,
        ];

        // @phpstan-ignore-next-line
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $viewParams);
    }
}
