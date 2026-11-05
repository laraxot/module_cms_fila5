<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Modules\Cms\Datas\CmsConfigData;
use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di Cms: tema del sito pubblico, registrazione del tema, lingua primaria.
 *
 * Salva in `config/{tenant}/xra.php` (le chiavi vivono lì per compatibilità con XotData).
 *
 * @see CmsConfigData
 */
class SettingPage extends BaseSettingPage
{
    /**
     * @return array<string, Select|Toggle>
     */
    protected function getFormSchema(): array
    {
        $themes = $this->getAvailableThemes();

        return [
            'pub_theme' => Select::make('pub_theme')
                ->options($themes)
                ->searchable()
                ->required(),

            'register_pub_theme' => Toggle::make('register_pub_theme'),

            'primary_lang' => Select::make('primary_lang')
                ->options([
                    'it' => 'Italiano',
                    'en' => 'English',
                    'fr' => 'Français',
                    'de' => 'Deutsch',
                    'es' => 'Español',
                ])
                ->required(),
        ];
    }

    /**
     * Temi disponibili: le directory di `Themes/` che esistono fisicamente.
     *
     * @return array<string, string>
     */
    private function getAvailableThemes(): array
    {
        $themesPath = base_path('Themes');
        if (! is_dir($themesPath)) {
            return [];
        }

        $themes = [];
        foreach (scandir($themesPath) ?: [] as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }
            if (is_dir($themesPath.'/'.$entry)) {
                $themes[$entry] = $entry;
            }
        }

        return $themes;
    }
}
