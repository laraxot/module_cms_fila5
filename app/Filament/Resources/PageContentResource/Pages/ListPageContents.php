<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageContentResource\Pages;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;

class ListPageContents extends LangBaseListRecords
{
    // use ListRecords\Concerns\Translatable;
    // protected static string $resource = PageContentResource::class;
    /**
     * @return array<int, Column|Stack>
     */
    public function getGridTableColumns(): array
    {
        /** @var array<int, Column> $columns */
        $columns = $this->getTableColumns();

        return [
            Stack::make($columns),
        ];
    }

    /**
     * @return array<int, TextColumn>
     */
    public function getTableColumns(): array
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ...array_map(
                    fn($col) => is_object($col) ? $col : TextColumn::make($col),
                    $this->getTableColumns()
                )
            ]);
    }
    {
        return [
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('slug')->sortable()->searchable(),
        ];
    }

    /*
     * protected function getHeaderActions(): array
     * {
     * return [
     * CreateAction::make(),
     * Actions\LocaleSwitcher::make(),
     * ];
     * }
     */
}
