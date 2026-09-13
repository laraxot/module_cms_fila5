<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Modules\Lang\Filament\Resources\LangBaseResource;
use Modules\Cms\Models\Page;

class PageResource extends LangBaseResource
{
    protected static ?string $model = Page::class;
}
