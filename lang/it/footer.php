<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/it/footer.php
return [
    'fields' => [
        'view' => [
            'label' => 'Visualizzazione',
            'tooltip' => 'Seleziona la visualizzazione da mostrare',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'updateAction' => [
            'label' => 'Aggiorna Footer',
            'tooltip' => 'Aggiorna le impostazioni del footer',
            'icon' => 'heroicon-o-pencil',
            'color' => 'primary',
        ],
    ],
    'label' => 'Footer',
    'plural_label' => 'Footer (Plurale)',
    'navigation' => [
        'name' => 'Footer',
        'plural' => 'Footer',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Footer',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
];
