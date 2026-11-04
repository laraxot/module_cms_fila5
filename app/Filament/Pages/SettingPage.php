<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Pages;

use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\File;
use Modules\Xot\Filament\Pages\BaseSettingPage;

/** Tenant settings entry point for Cms; no mutable settings are exposed yet. */
class SettingPage extends BaseSettingPage
{
    public static function getConfigName(): string
    {
        return 'xra';
    }

    /**
     * @return array<string, object>
     */
    protected function getFormSchema(): array
    {
        return [
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
    }
}
