<?php

declare(strict_types=1);

use Modules\Cms\Actions\SaveFooterConfigAction;
use Modules\Cms\Datas\FooterData;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

test('SaveFooterConfigAction can be executed', function () {
    Assert::assertTrue((new ReflectionClass(SaveFooterConfigAction::class))->isInstantiable());
});

test('SaveFooterConfigAction saves footer data in the appearance tenant config', function () {
    $footerData = FooterData::from([
        'background_color' => '#ffffff',
        'background' => 'bg-light',
        'overlay_color' => '#000000',
    ]);

    $save = Mockery::mock(SaveTenantConfigAction::class);
    $save->shouldReceive('execute')
        ->once()
        ->with('appearance', ['footer' => $footerData->toArray()]);
    app()->instance(SaveTenantConfigAction::class, $save);

    (new SaveFooterConfigAction)->execute($footerData);
})->group('CMS-FOOTER-SAVE-INV-1');
