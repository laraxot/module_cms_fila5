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
            'placeholder' => 'Page content slug',
            'description' => 'slug',
            'helper_text' => 'slug',
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
            'label' => 'toggleColumns',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'delete' => [
            'label' => 'delete',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'edit' => [
            'label' => 'edit',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'view' => [
            'label' => 'view',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view' => 'View Content',
        'create' => [
            'label' => 'create',
        ],
        'edit' => 'Edit Content',
        'delete' => 'Delete Content',
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
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
