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

    /** @var DataCollection<BlockData>|array */
    public DataCollection|array $blocks;

    /** @var array<string, mixed> */
    public array $data = [];

<<<<<<< HEAD
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        array $data = [],
        string $side = 'content',
        ?string $slug = null,
        ?string $type = null,
    ) {
        $this->side = $side;
<<<<<<< HEAD
        $this->data = $data;

        // Resolve slug from data if not passed explicitly
        if (null === $slug && isset($data['slug'])) {
            $slug = (string) $data['slug'];
        }

        // Fallback or composition
        if (null === $slug) {
            $slug = '';
        }

=======
    public string $container0 = '';

    public string $slug0 = '';

    public function __construct(string $side, string $slug, ?string $type = null, array $data = [], string $container0 = '', string $slug0 = '')
    {
        // @var mixed data = $data;
        // @var mixed side = $side;
>>>>>>> 526b81f (.)
        if (null !== $type) {
=======
        if ($type !== null) {
>>>>>>> 5580e39 (.)
            $slug = $type.'-'.$slug;
        }
<<<<<<< HEAD

        $this->slug = $slug;

        $this->blocks = PageModel::getBlocksBySlug($this->slug, $this->side);
=======
        // @var mixed slug = $slug;
        // @var mixed container0 = $container0;
        // @var mixed slug0 = $slug0;
        /* @phpstan-ignore staticMethod.notFound, assign.propertyType */
        // @var mixed blocks = PageModel::getBlocksBySlug($slug, $side;
>>>>>>> 526b81f (.)
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): ViewContract
    {
        $view = 'cms::components.page';
<<<<<<< HEAD
        $viewParams = [
            ...$this->data,
            'blocks' => $this->blocks,
            'side' => $this->side,
            'slug' => $this->slug,
            'data' => $this->data,
=======
        $view_params = [
            'blocks' => // @var mixed blocks,
            'side' => // @var mixed side,
            'slug' => // @var mixed slug,
            'data' => // @var mixed data,
            'container0' => // @var mixed container0,
            'slug0' => // @var mixed slug0,
>>>>>>> 526b81f (.)
        ];
        // @phpstan-ignore-next-line
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $viewParams);
    }
}
