<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/de/footer.php
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
