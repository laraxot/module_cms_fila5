<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\MenuResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Cms\Models\Menu;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class MenusTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Menu>
     */
    protected static string $model = Menu::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'title' => TextColumn::make('title')->searchable()->sortable(),
            'parent_id' => TextColumn::make('parent.title')->searchable()->sortable(),
        ];
    }
}
