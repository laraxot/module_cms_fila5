<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Front\Pages;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Xot\Filament\Pages\XotBasePage;
use Webmozart\Assert\Assert;

class Home extends XotBasePage
{
    public string $view_type = 'home';
    public array $containers = [];
    public array $items = [];

    protected string $view = 'pub_theme::home';
    protected static string $layout = 'pub_theme::components.layouts.app';

    public function mount(): void
    {
        $this->initView();
    }

    public function getViewData(): array
    {
        return [];
    }

    public function initView(): void
    {
        $this->view_type = 'home';
        if (view()->exists($this->view)) {
            return;
        }
        $this->view = 'cms::filament.front.pages.welcome';
    }
}
