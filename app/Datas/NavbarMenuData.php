<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Spatie\LaravelData\Data;

class NavbarMenuData extends Data
{
    public $title;

    public string $url;

    public bool $active;

    public string $icon;
}
