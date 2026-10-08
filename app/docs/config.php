<?php

declare(strict_types=1);

use Illuminate\Support\Str;

if (! function_exists('trimPath')) {
    function trimPath(string $path): string
    {
        return trim($path, '/');
    }
}

// `$page` e `$item` sono oggetti runtime di Jigsaw (PageVariable, non installato in vendor):
// i loro metodi/proprieta' si leggono in modo difensivo invece di assumerne il tipo.
if (! function_exists('pageStringCall')) {
    function pageStringCall(mixed $page, string $method): string
    {
        if (! is_object($page) || ! is_callable([$page, $method])) {
            return '';
        }
        $value = $page->{$method}();

        return is_string($value) ? $value : '';
    }
}

if (! function_exists('pageProperty')) {
    function pageProperty(mixed $page, string $property): mixed
    {
        return is_object($page) ? $page->{$property} : null;
    }
}

if (! function_exists('docsEnv')) {
    // Questo file e' un config di Jigsaw (fuori da Laravel): legge .env/ambiente da $_SERVER/$_ENV.
    function docsEnv(string $key): ?string
    {
        $value = $_SERVER[$key] ?? $_ENV[$key] ?? null;

        return is_string($value) && '' !== $value ? $value : null;
    }
}

$moduleName = 'Cms';

return [
    'baseUrl' => '',
    'production' => false,
    'siteName' => 'Modulo '.$moduleName,
    'siteDescription' => 'Modulo '.$moduleName,
    'lang' => 'it',

    'collections' => [
        'posts' => [
            'path' => static function (mixed $page): string {
                // return $page->lang.'/posts/'.Str::slug($page->getFilename());
                // return 'posts/' . ($page->featured ? 'featured/' : '') . Str::slug($page->getFilename());

                return 'posts/'.Str::slug(pageStringCall($page, 'getFilename'));
            },
        ],
        'docs' => [
            'path' => static function (mixed $page): string {
                // return $page->lang.'/docs/'.Str::slug($page->getFilename());
                return 'docs/'.Str::slug(pageStringCall($page, 'getFilename'));
            },
        ],
    ],

    // Algolia DocSearch credentials
    'docsearchApiKey' => docsEnv('DOCSEARCH_KEY'),
    'docsearchIndexName' => docsEnv('DOCSEARCH_INDEX'),

    // navigation menu
    'navigation' => file_exists(__DIR__.'/navigation.php') ? require __DIR__.'/navigation.php' : [],

    // helpers
    'isActive' => static function (mixed $page, mixed $path): bool {
        return Str::endsWith(trimPath(pageStringCall($page, 'getPath')), trimPath(is_string($path) ? $path : ''));
    },
    'isItemActive' => static function (mixed $page, mixed $item): bool {
        return Str::endsWith(trimPath(pageStringCall($page, 'getPath')), trimPath(pageStringCall($item, 'getPath')));
    },
    'isActiveParent' => static function (mixed $page, mixed $menuItem): bool {
        if (is_object($menuItem) && property_exists($menuItem, 'children') && $menuItem->children instanceof Illuminate\Support\Collection) {
            return $menuItem->children->contains(static function (mixed $child) use ($page): bool {
                return is_string($child) && trimPath(pageStringCall($page, 'getPath')) === trimPath($child);
            });
        }

        return false;
    }, /*
    'url' => function ($page, $path) {
        return Str::startsWith($path, 'http') ? $path : '/' . trimPath($path);
    },
    */
    'url' => static function (mixed $page, mixed $path): string {
        $path = is_string($path) ? $path : '';
        if (Str::startsWith($path, 'http')) {
            return $path;
        }

        // return url('/'.$page->lang.'/'.trimPath($path));
        return url('/'.trimPath($path));
    },

    'children' => static function (mixed $page, mixed $docs): Illuminate\Support\Collection {
        if ($docs instanceof Illuminate\Support\Collection) {
            return $docs->where('parent_id', pageProperty($page, 'id'));
        }

        return collect();
    },
];
