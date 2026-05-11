<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class PageInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, \Filament\Infolists\Components\Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'title' => TextEntry::make('title'),
            'slug' => TextEntry::make('slug'),
            'created_at' => TextEntry::make('created_at')->dateTime(),
        ];
    }
}
