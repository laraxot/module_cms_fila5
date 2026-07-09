<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/en/footer.php
return [
    'fields' => [
        'view' => [
            'label' => 'View',
            'tooltip' => 'Select the view to display',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'updateAction' => [
            'label' => 'Update Footer',
            'tooltip' => 'Update footer settings',
            'icon' => 'heroicon-o-pencil',
            'color' => 'primary',
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
];
