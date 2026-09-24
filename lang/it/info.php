<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/it/info.php
return [
    'fields' => [
        'title' => [
            'label' => 'title',
            'placeholder' => 'title',
            'helper_text' => 'title',
            'description' => 'title',
            'tooltip' => '',
        ],
        'description' => [
            'label' => 'description',
            'placeholder' => 'description',
            'helper_text' => 'description',
            'description' => 'description',
            'tooltip' => '',
        ],
        'logo' => [
            'label' => 'logo',
            'placeholder' => 'logo',
            'helper_text' => 'logo',
            'description' => 'logo',
            'tooltip' => '',
        ],
        'copyright' => [
            'label' => 'copyright',
            'placeholder' => 'copyright',
            'helper_text' => 'copyright',
            'description' => 'copyright',
            'tooltip' => '',
        ],
    ],
    'label' => 'Info',
    'plural_label' => 'Info (Plurale)',
    'navigation' => [
        'name' => 'Info',
        'plural' => 'Info',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Info',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Info',
        ],
        'edit' => [
            'label' => 'Modifica Info',
        ],
        'delete' => [
            'label' => 'Elimina Info',
        ],
    ],
];
