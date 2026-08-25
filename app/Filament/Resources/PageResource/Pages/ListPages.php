<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Pages;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Cms\Filament\Resources\PageResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;

class ListPages extends LangBaseListRecords
{
<<<<<<< HEAD
   public static string $resource = PageResource::class;
=======
    public static string $resource = PageResource::class;
>>>>>>> laraxot/dev

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'title' => TextColumn::make('title')->searchable(),
            'slug' => TextColumn::make('slug')->searchable(),
        ];
    }
}
