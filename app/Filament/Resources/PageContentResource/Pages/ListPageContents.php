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
<<<<<<< HEAD
   // public static string $resource = PageContentResource::class;
=======
    // public static string $resource = PageContentResource::class;
>>>>>>> laraxot/dev
    /**
     * @return array<int, Column|Stack>
     */
    public function getGridTableColumns(): array
    {
        /** @var array<int, Column> $columns */
<<<<<<< .merge_file_1NdSUD
        $columns = $this->getTableColumns(); // @phpstan-ignore method.deprecated (hook di progetto: la deprecazione e ereditata per nome dal prototipo Filament 5, il codice eseguito e il nostro — story 16.12)
=======
<<<<<<< HEAD
       $columns = $this->getTableColumns(); // @phpstan-ignore method.deprecated (hook di progetto: la deprecazione e ereditata per nome dal prototipo Filament 5, il codice eseguito e il nostro — story 16.12)
=======
        $columns = $this->getTableColumns(); // @phpstan-ignore method.deprecated (hook di progetto: la deprecazione e ereditata per nome dal prototipo Filament 5, il codice eseguito e il nostro — story 16.12)
>>>>>>> laraxot/dev
>>>>>>> .merge_file_7rKOeR

        return [
            Stack::make($columns),
        ];
    }

    /**
     * @return array<int, TextColumn>
     */
    public function getTableColumns(): array
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
