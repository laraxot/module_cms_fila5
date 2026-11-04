<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Pages;

use Modules\Xot\Filament\Pages\BaseSettingPage;

/** Tenant settings entry point for Cms; no mutable settings are exposed yet. */
class SettingPage extends BaseSettingPage
{
    /**
     * @return array<string, never>
     */
    protected function getFormSchema(): array
    {
        return [];
    }
}
