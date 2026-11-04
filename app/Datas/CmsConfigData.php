<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/** Tenant configuration reserved for future Cms settings. */
class CmsConfigData extends Data
{
    use MakesFromTenantConfig;

    public bool $enabled = true;

    public string $pub_theme = 'TwentyOne';

    public string $primary_lang = 'it';

}
