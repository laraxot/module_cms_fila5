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
    // public static string $resource = PageContentResource::class;
    /**
     * @return array<int, Column|Stack>
     */
    public function getGridTableColumns(): array
    {
        /** @var array<int, Column> $columns */
        $columns = $this->getTableColumns(); // @phpstan-ignore method.deprecated (hook di progetto: la deprecazione e ereditata per nome dal prototipo Filament 5, il codice eseguito e il nostro — story 16.12)

        return [
            Stack::make($columns),
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
