<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\AttachmentResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Cms\Models\Attachment;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class AttachmentsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Attachment>
     */
    protected static string $model = Attachment::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'title' => TextColumn::make('title')->searchable()->sortable(),
            'description' => TextColumn::make('description')->limit(50)->searchable(),
            'slug' => TextColumn::make('slug')->searchable()->sortable()->copyable(),
            'disk' => TextColumn::make('disk')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
