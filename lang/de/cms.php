<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/de/cms.php
return [
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
    'sections' => [
        'fields' => [
            'name' => [
                'label' => 'Nome',
                'tooltip' => 'Inserisci il nome della sezione',
            ],
            'slug' => [
                'label' => 'Slug',
                'tooltip' => 'Identificatore univoco della sezione',
            ],
            'image' => [
                'label' => 'Immagine',
                'tooltip' => 'Seleziona un\'immagine per la sezione',
            ],
            'content' => [
                'label' => 'Contenuto',
                'tooltip' => 'Inserisci il contenuto della sezione',
            ],
            'status' => [
                'label' => 'Stato',
                'tooltip' => 'Seleziona lo stato della sezione',
                'options' => [
                    'draft' => 'Bozza',
                    'published' => 'Pubblicato',
                    'archived' => 'Archiviato',
                ],
            ],
        ],
    ],
    'blocks' => [
        'quick_links' => [
            'fields' => [
                'label' => [
                    'label' => 'Etichetta',
                    'tooltip' => 'Inserisci l\'etichetta per i link rapidi',
                ],
                'links' => [
                    'label' => 'Link',
                    'tooltip' => 'Aggiungi i link rapidi',
                    'fields' => [
                        'label' => [
                            'label' => 'Etichetta',
                            'tooltip' => 'Inserisci l\'etichetta del link',
                        ],
                        'url' => [
                            'label' => 'URL',
                            'tooltip' => 'Inserisci l\'URL del link',
                        ],
                    ],
                ],
            ],
        ],
        'footer' => [
            'links' => [
                'fields' => [
                    'links' => [
                        'label' => 'Link',
                        'tooltip' => 'Aggiungi i link del footer',
                        'fields' => [
                            'label' => [
                                'label' => 'Etichetta',
                                'tooltip' => 'Inserisci l\'etichetta del link',
                            ],
                            'url' => [
                                'label' => 'URL',
                                'tooltip' => 'Inserisci l\'URL del link',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'filament' => [
        'blocks' => [
            'footer' => [
                'links' => [
                    'fields' => [
                        'links' => [
                            'fields' => [
                                'label' => [
                                    'label' => 'Etichetta',
                                    'tooltip' => 'Inserisci l\'etichetta del link',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
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
    'fields' => [
    ],
    'actions' => [
    ],
];
