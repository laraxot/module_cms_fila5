<?php

declare(strict_types=1);

namespace Modules\Cms\Http\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Modules\Xot\Contracts\UserContract;

/**
 * Class XotComposer.
 */
final class XotComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $user = Auth::user();
        if (! $user instanceof UserContract) {
            return;
        }

        $profile = $user->profile;
        $lang = app()->getLocale();
        $params = [];
        $routeCurrent = Route::current();
        if ($routeCurrent instanceof \Illuminate\Routing\Route) {
            $params = $routeCurrent->parameters();
        }

        $view->with('params', $params);
        $view->with('lang', $lang);
        $view->with('profile', $profile);
    }
}
