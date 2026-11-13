<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Cms/docs/wiki/concepts/claude-audit-static.md
// File: lang/en/section_actions.php
return [
    'actions' => [
        'create' => [
            'label' => 'Create Section',
            'modal' => [
                'heading' => 'Create New Section',
                'submit' => 'Create',
                'cancel' => 'Cancel',
            ],
        ],
        'edit' => [
            'label' => 'Edit Section',
            'modal' => [
                'heading' => 'Edit Section',
                'submit' => 'Save',
                'cancel' => 'Cancel',
            ],
        ],
        'delete' => [
            'label' => 'Delete Section',
            'modal' => [
                'heading' => 'Delete Section',
                'description' => 'Are you sure you want to delete this section?',
                'submit' => 'Delete',
                'cancel' => 'Cancel',
            ],
        ],
        'view' => [
            'label' => 'View Section',
        ],
        'activeLocale' => [
            'label' => 'Active Language',
        ],
        'cancel' => [
            'label' => 'cancel',
        ],
        'save' => [
            'label' => 'save',
        ],
        'preview' => [
            'label' => 'preview',
        ],
    ],
];
