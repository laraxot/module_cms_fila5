<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/it/paragraph.php
return [
    'fields' => [
        'content' => [
            'label' => 'content',
            'placeholder' => 'content',
            'helper_text' => 'content',
            'description' => 'content',
            'tooltip' => '',
        ],
    ],
    'label' => 'Paragraph',
    'plural_label' => 'Paragraph (Plurale)',
    'navigation' => [
        'name' => 'Paragraph',
        'plural' => 'Paragraph',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Paragraph',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Paragraph',
        ],
        'edit' => [
            'label' => 'Modifica Paragraph',
        ],
        'delete' => [
            'label' => 'Elimina Paragraph',
        ],
    ],
];
