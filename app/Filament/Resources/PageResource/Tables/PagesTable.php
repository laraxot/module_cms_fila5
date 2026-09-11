<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class PagesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'title' => TextColumn::make('title')->searchable()->sortable(),
            'slug' => TextColumn::make('slug')->searchable()->sortable()->copyable(),
            'description' => TextColumn::make('description')->limit(50),
            'middleware' => TextColumn::make('middleware'),
        ];
    }
}
