<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Pages;

use Filament\Forms\Components\Select;
<<<<<<< HEAD
use Illuminate\Support\Facades\File;
=======
use Filament\Forms\Components\Toggle;
use Modules\Cms\Actions\ListInstalledThemesAction;
use Modules\Cms\Datas\CmsConfigData;
>>>>>>> f6951729f6a52934fe712dd4c9bebf8f917f3775
use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di Cms, solo super-admin: quale tema usa il front office.
 *
 * Scrive nel file `xra` del tenant (lo stesso che legge `XotData`), non in `cms.php`.
 *
 * @see CmsConfigData
 */
class SettingPage extends BaseSettingPage
{
    public static function getConfigName(): string
    {
<<<<<<< HEAD
        return 'xra';
    }

    /**
     * @return array<string, object>
=======
        return CmsConfigData::tenantConfigName();
    }

    /**
     * @return array<string, Select|Toggle>
>>>>>>> f6951729f6a52934fe712dd4c9bebf8f917f3775
     */
    protected function getFormSchema(): array
    {
        return [
<<<<<<< HEAD
            ...parent::getFormSchema(),
            'pub_theme' => Select::make('pub_theme')
                ->options($this->themeOptions())
                ->required(),
            'primary_lang' => Select::make('primary_lang')
                ->options(['it' => 'Italiano', 'en' => 'English'])
                ->required(),
        ];
    }

    /**
     * @return array<string, string>
     */
    private function themeOptions(): array
    {
        $options = [];
        foreach (File::directories(base_path('Themes')) as $directory) {
            if (! is_string($directory)) {
                continue;
            }

            $name = basename($directory);
            $options[$name] = $name;
        }

        return $options;
=======
            'pub_theme' => Select::make('pub_theme')
                ->options(app(ListInstalledThemesAction::class)->execute())
                ->required(),
            'register_pub_theme' => Toggle::make('register_pub_theme'),
        ];
>>>>>>> f6951729f6a52934fe712dd4c9bebf8f917f3775
    }
}
