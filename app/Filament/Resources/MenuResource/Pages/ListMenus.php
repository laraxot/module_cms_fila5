<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\MenuResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListMenus extends XotBaseListRecords
{
    /**
     * Get list table columns.
     *
     * @return array<Tables\Columns\Column>
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
            TextColumn::make('title'),
        ];
    }
    // protected static string $resource = MenuResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
