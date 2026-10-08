<?php

declare(strict_types=1);

use Modules\Cms\Http\Controllers\Admin\XotPanelController;
use Modules\Cms\Http\Controllers\BaseController;
use PHPUnit\Framework\Assert;

describe('XotPanelController', function (): void {
    test('xot panel controller extends base controller', function (): void {
        $controller = new XotPanelController();

        Assert::assertInstanceOf(BaseController::class, $controller);
    });

    test('xot panel controller has __call method', function (): void {
        $action = Mockery::mock();
        $action->shouldReceive('execute')
            ->once()
            ->with('admin', ['id' => 42])
            ->andReturn($panel = Mockery::mock());
        $panel->shouldReceive('out')->once()->andReturn('panel output');

        app()->instance('\Modules\Cms\Actions\Panel\DashboardAction', $action);

        $controller = new XotPanelController();

        Assert::assertSame('panel output', $controller->__call('dashboard', [['id' => 42], 'admin']));
    });

    test('xot panel controller uses correct namespace', function (): void {
        $reflector = new ReflectionClass(XotPanelController::class);

        Assert::assertSame('Modules\Cms\Http\Controllers\Admin', $reflector->getNamespaceName());
    });

    test('xot panel controller can be instantiated without constructor arguments', function (): void {
        Assert::assertInstanceOf(XotPanelController::class, new XotPanelController());
    });
});
