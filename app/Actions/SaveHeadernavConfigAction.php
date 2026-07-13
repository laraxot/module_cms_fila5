<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Modules\Cms\Datas\HeadernavData;
use Spatie\QueueableAction\QueueableAction;

class SaveHeadernavConfigAction
{
    use QueueableAction;

    public function execute(HeadernavData $data): void
    {
        $config = ['headernav' => $data->toArray()];
        app(\Modules\Tenant\Actions\Config\SaveTenantConfigAction::class)->execute('appearance', $config);
    }
}
