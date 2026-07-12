<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/it/quick_links.php
return [
    'fields' => [
        'title' => [
            'label' => 'title',
            'placeholder' => 'title',
            'helper_text' => 'title',
            'description' => 'title',
            'tooltip' => '',
        ],
        'links' => [
            'label' => 'links',
            'placeholder' => 'links',
            'helper_text' => 'links',
            'description' => 'links',
            'tooltip' => '',
        ],
        'label' => [
            'label' => 'label',
            'placeholder' => 'label',
            'helper_text' => 'label',
            'description' => 'label',
            'tooltip' => '',
        ],
        'url' => [
            'label' => 'url',
            'placeholder' => 'url',
            'helper_text' => 'url',
            'description' => 'url',
            'tooltip' => '',
        ],
        'target' => [
            'label' => 'target',
            'placeholder' => 'target',
            'helper_text' => 'target',
            'description' => 'target',
            'tooltip' => '',
        ],
    ],
    'label' => 'Quick Links',
    'plural_label' => 'Quick Links (Plurale)',
    'navigation' => [
        'name' => 'Quick Links',
        'plural' => 'Quick Links',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Quick Links',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Quick Links',
        ],
        'edit' => [
            'label' => 'Modifica Quick Links',
        ],
        'delete' => [
            'label' => 'Elimina Quick Links',
        ],
    ],
];
