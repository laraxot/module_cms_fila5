<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/** Tenant configuration reserved for future Cms settings. */
class CmsConfigData extends Data
{
    use MakesFromTenantConfig;
}
