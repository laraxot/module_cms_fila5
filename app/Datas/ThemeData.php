<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Spatie\LaravelData\Data;

class ThemeData extends Data
{
    public string $name; // ": "MaterialBlog",

    public string $type = 'pub';

    public string $description = '';

<<<<<<< HEAD
   /** @var array<int, string> */
=======
    /** @var array<int, string> */
>>>>>>> laraxot/dev
    public array $keywords = [];

    public bool $active = true;

    public int $order = 0;

<<<<<<< HEAD
   /** @var array<int, string> */
=======
    /** @var array<int, string> */
>>>>>>> laraxot/dev
    public array $aliases = [];

    /** @var array<int, string> */
    public array $files = [];

    /** @var array<int, string> */
    public array $requires = [];
}
