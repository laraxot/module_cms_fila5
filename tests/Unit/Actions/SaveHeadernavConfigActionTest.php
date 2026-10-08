<?php

declare(strict_types=1);

use Modules\Cms\Actions\SaveHeadernavConfigAction;
use Modules\Cms\Datas\HeadernavData;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use PHPUnit\Framework\Assert;

test('SaveHeadernavConfigAction can be instantiated', function () {
    $action = new SaveHeadernavConfigAction();

    Assert::assertInstanceOf(SaveHeadernavConfigAction::class, $action);
});

test('SaveHeadernavConfigAction saves the header navigation tenant config', function () {
    $data = HeadernavData::from([
        'background_color' => '#ffffff',
        'view' => 'cms::components.headernav',
    ]);

    $saveTenantConfig = Mockery::mock(SaveTenantConfigAction::class);
    $saveTenantConfig
        ->shouldReceive('execute')
        ->once()
        ->with('appearance', ['headernav' => $data->toArray()]);

    app()->instance(SaveTenantConfigAction::class, $saveTenantConfig);

    app(SaveHeadernavConfigAction::class)->execute($data);
});
