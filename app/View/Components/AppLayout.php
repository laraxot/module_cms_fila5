<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
<<<<<<< HEAD
   public function render(): Factory|View
=======
    public function render(): Factory|View
>>>>>>> laraxot/dev
    {
        $view = 'pub_theme::layouts.app';
        $view_params = [];

        return view($view, $view_params);
    }
}
