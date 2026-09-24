<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/en/links.php
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
        'icon' => [
            'label' => 'icon',
            'placeholder' => 'icon',
            'helper_text' => 'icon',
            'description' => 'icon',
            'tooltip' => '',
        ],
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'actions' => [
    ],
];
