<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
// use Modules\Cms\Filament\Resources\PageContentResource\RelationManagers;
// use Filament\Forms;
use Modules\Cms\Filament\Fields\PageContentBuilder;
use Modules\Cms\Models\PageContent;
use Modules\Lang\Filament\Resources\LangBaseResource;

// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageContentResource extends LangBaseResource
{
    protected static ?string $model = PageContent::class;

    /**
     * @return array<string, \Filament\Support\Components\Component>
     */
    #[\Override]
    public static function getFormSchema(): array
    {
        return array_values([
            'name' => TextInput::make('name')
                ->required()
                ->lazy()
                ->afterStateUpdated(static function (Set $set, Get $get, string $state): void {
                    if ($get('slug')) {
                        return;
                    }
                    $set('slug', Str::slug($state));
                }),
            'slug' => TextInput::make('slug')
                ->required()
                ->afterStateUpdated(static fn (Set $set, string $state) => $set('slug', Str::slug($state))),
            'content' => Section::make('Content')->schema([
                PageContentBuilder::make('blocks')->columnSpanFull(),
            ]),
        ]);
    }
}
