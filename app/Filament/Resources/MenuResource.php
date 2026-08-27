<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Modules\Cms\Models\Menu;
use Modules\Xot\Filament\Resources\XotBaseResource;

class MenuResource extends XotBaseResource
{
    protected static ?string $model = Menu::class;

    /**
<<<<<<< .merge_file_TRcO9x
     * Schema legacy del form: la sorgente di verità è MenuForm::getFormSchema().
=======
    * Schema legacy del form: la sorgente di verità è MenuForm::getFormSchema().
>>>>>>> .merge_file_mMGJFm
     *
     * @return array<int, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required()->maxLength(2048),
            Repeater::make('items')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('title')->required()->columnSpan(1),
                        TextInput::make('url')
                            ->required()
                            ->columnSpan(1),
                    ]),
                ]),
            Radio::make('target')
                ->options([
                    '_self' => 'Stessa pagina',
                    '_blank' => 'Nuova finestra',
                ])
                ->default('_self'),
            SpatieMediaLibraryFileUpload::make('icon')
                ->collection('cms-icons')
                ->helperText('Carica un\'icona per il menu'),
        ];
    }
}
