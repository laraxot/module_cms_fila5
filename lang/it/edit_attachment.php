<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/it/edit_attachment.php
return [
    'actions' => [
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
        'save' => [
            'label' => 'save',
        ],
        'cancel' => [
            'label' => 'cancel',
        ],
    ],
    'label' => 'Edit Attachment',
    'plural_label' => 'Edit Attachment (Plurale)',
    'navigation' => [
        'name' => 'Edit Attachment',
        'plural' => 'Edit Attachment',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Edit Attachment',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
];
