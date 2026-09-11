<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\SectionResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Cms\Models\Section;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class SectionsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Section>
     */
    protected static string $model = Section::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'slug' => TextColumn::make('slug')->searchable()->sortable()->copyable(),
        ];
    }
}
