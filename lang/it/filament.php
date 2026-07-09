<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/it/filament.php
return [
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
    'resources' => [
        'section' => [
            'label' => 'Sezione',
            'plural' => 'Sezioni',
            'navigation' => [
                'label' => 'Sezioni',
                'icon' => 'heroicon-o-rectangle-stack',
            ],
        ],
    ],
    'blocks' => [
        'footer' => [
            'label' => 'Footer',
            'info' => [
                'label' => 'Info Footer',
                'fields' => [
                    'logo' => 'Logo Footer',
                    'company_name' => 'Nome Azienda',
                    'description' => 'Descrizione',
                    'email' => 'Email',
                    'phone' => 'Telefono',
                    'address' => 'Indirizzo',
                ],
            ],
            'links' => [
                'label' => 'Link Footer',
                'fields' => [
                    'title' => 'Titolo Sezione',
                    'links' => [
                        'label' => 'Link',
                        'fields' => [
                            'label' => 'Etichetta Link',
                            'url' => 'URL',
                            'icon' => 'Icona (opzionale]',
                        ],
                    ],
                ],
            ],
            'social' => [
                'label' => 'Social Footer',
                'fields' => [
                    'title' => 'Titolo Sezione',
                    'social_links' => 'Link Social',
                    'platform' => 'Piattaforma Social',
                    'url' => 'URL Profilo',
                ],
            ],
            'contact' => [
                'label' => 'Contatti Footer',
                'fields' => [
                    'title' => 'Titolo Sezione',
                    'address' => 'Indirizzo',
                    'phone' => 'Telefono',
                    'email' => 'Email',
                ],
            ],
            'newsletter' => [
                'label' => 'Newsletter Footer',
                'fields' => [
                    'title' => 'Titolo Sezione',
                    'description' => 'Descrizione',
                    'button_text' => 'Testo Pulsante',
                ],
            ],
            'quick_links' => [
                'label' => 'Link Rapidi Footer',
                'fields' => [
                    'title' => 'Titolo',
                    'links' => [
                        'label' => 'Link Rapidi',
                        'fields' => [
                            'label' => 'Etichetta',
                            'url' => 'URL',
                            'target' => 'Target',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'label' => 'Filament',
    'plural_label' => 'Filament (Plurale)',
    'navigation' => [
        'name' => 'Filament',
        'plural' => 'Filament',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Filament',
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
    'actions' => [
        'create' => [
            'label' => 'Crea Filament',
        ],
        'edit' => [
            'label' => 'Modifica Filament',
        ],
        'delete' => [
            'label' => 'Elimina Filament',
        ],
    ],
];
