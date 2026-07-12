<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/it/stats.php
return [
    'fields' => [
        'title' => [
            'label' => 'title',
            'placeholder' => 'title',
            'helper_text' => 'title',
            'description' => 'title',
            'tooltip' => '',
        ],
        'stats' => [
            'label' => 'stats',
            'placeholder' => 'stats',
            'helper_text' => 'stats',
            'description' => 'stats',
            'tooltip' => '',
        ],
        'number' => [
            'label' => 'number',
            'placeholder' => 'number',
            'helper_text' => 'number',
            'description' => 'number',
            'tooltip' => '',
        ],
        'label' => [
            'label' => 'label',
            'placeholder' => 'label',
            'helper_text' => 'label',
            'description' => 'label',
            'tooltip' => '',
        ],
    ],
    'label' => 'Stats',
    'plural_label' => 'Stats (Plurale)',
    'navigation' => [
        'name' => 'Stats',
        'plural' => 'Stats',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Stats',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Stats',
        ],
        'edit' => [
            'label' => 'Modifica Stats',
        ],
        'delete' => [
            'label' => 'Elimina Stats',
        ],
    ],
];
