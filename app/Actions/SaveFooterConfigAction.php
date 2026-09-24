<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Modules\Cms\Datas\FooterData;
use Spatie\QueueableAction\QueueableAction;

class SaveFooterConfigAction
{
    use QueueableAction;

    public function execute(FooterData $data): void
    {
        $config = ['footer' => $data->toArray()];
        app(\Modules\Tenant\Actions\Config\SaveTenantConfigAction::class)->execute('appearance', $config);
    }
}
