<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Modules\Cms\Actions\ListInstalledThemesAction;
use Modules\Cms\Datas\CmsConfigData;
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
        return CmsConfigData::tenantConfigName();
    }

    /**
     * @return array<string, Select|Toggle>
     */
    protected function getFormSchema(): array
    {
        return [
            'pub_theme' => Select::make('pub_theme')
                ->options(app(ListInstalledThemesAction::class)->execute())
                ->required(),
            'register_pub_theme' => Toggle::make('register_pub_theme'),
            'primary_lang' => Select::make('primary_lang')
                ->options(['it' => 'Italiano', 'en' => 'English'])
                ->required(),
        ];
    }
}
