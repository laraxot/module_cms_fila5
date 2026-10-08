<?php

declare(strict_types=1);

use Modules\Cms\Filament\Pages\Themes;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use PHPUnit\Framework\Assert;

test('Themes page can be instantiated', function () {
    Assert::assertInstanceOf(Themes::class, new Themes());
});

test('Themes page has themes property', function () {
    $page = new Themes();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('themes');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Themes page saves the selected public theme', function () {
    $saveTenantConfig = Mockery::mock(SaveTenantConfigAction::class);
    $saveTenantConfig
        ->shouldReceive('execute')
        ->once()
        ->with('xra', ['pub_theme' => 'Sixteen']);

    app()->instance(SaveTenantConfigAction::class, $saveTenantConfig);

    (new Themes())->changePubTheme('Sixteen');
});

test('Themes page has getViewData method', function () {
    $page = new Themes();
    $method = new ReflectionMethod(Themes::class, 'getViewData');
    $method->setAccessible(true);

    Assert::assertSame([], $method->invoke($page));
});
