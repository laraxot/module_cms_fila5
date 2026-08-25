<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\AttachmentResource\Pages;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Cms\Filament\Resources\AttachmentResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;

class ListAttachments extends LangBaseListRecords
{
<<<<<<< HEAD
   public static string $resource = AttachmentResource::class;
=======
    public static string $resource = AttachmentResource::class;
>>>>>>> laraxot/dev

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'title' => TextColumn::make('title')->searchable(),
            'slug' => TextColumn::make('slug')->searchable(),
            'attachment' => TextColumn::make('attachment')->searchable(),
        ];
    }
}
