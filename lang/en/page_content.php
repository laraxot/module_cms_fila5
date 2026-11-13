<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Page Contents',
        'plural' => 'Page Contents',
        'group' => [
            'name' => 'Content Management',
            'description' => 'Manage the site page contents',
        ],
        'label' => 'Page Contents',
        'sort' => '87',
        'icon' => 'heroicon-o-document-text',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'Page content ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Content name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'slug' => [
            'label' => 'Slug',
<<<<<<< .merge_file_xyJQxK
            'placeholder' => 'Page content slug',
            'description' => 'slug',
            'helper_text' => 'slug',
=======
            'placeholder' => 'Slug del contenuto pagina',
>>>>>>> .merge_file_AHu5TL
            'tooltip' => '',
        ],
        'blocks' => [
            'label' => 'Blocks',
            'placeholder' => 'Content blocks',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Creation Date',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Last Modified',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_by' => [
            'label' => 'Created by',
            'placeholder' => 'Created by',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_by' => [
            'label' => 'Updated by',
            'placeholder' => 'Updated by',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'openFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'delete' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'edit' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'view' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
<<<<<<< .merge_file_xyJQxK
        'view' => 'View Content',
        'create' => [
            'label' => 'create',
        ],
        'edit' => 'Edit Content',
        'delete' => 'Delete Content',
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
=======
        'view' => 'Visualizza Contenuto',
        'edit' => 'Modifica Contenuto',
        'delete' => 'Elimina Contenuto',
>>>>>>> .merge_file_AHu5TL
    ],
    'messages' => [
        'created' => 'Content created successfully',
        'updated' => 'Content updated successfully',
        'deleted' => 'Content deleted successfully',
    ],
    'validation' => [
        'name_required' => 'The name is required',
        'slug_unique' => 'The slug must be unique',
        'blocks_required' => 'Content blocks are required',
    ],
    'model' => [
        'label' => 'page content.model',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
