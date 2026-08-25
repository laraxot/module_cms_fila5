<?php

declare(strict_types=1);

use Livewire\Volt\Component as VoltComponent;
use Modules\Cms\Http\Volt\Password\ConfirmComponent;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('Password ConfirmComponent', function (): void {
    test('confirm component extends volt component', function (): void {
        $component = new ConfirmComponent;

        Assert::assertInstanceOf(VoltComponent::class, $component);
    });

    test('confirm component has password property', function (): void {
        $component = new ConfirmComponent;

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('password'));

        Assert::assertSame('', $component->password);
    });

<<<<<<< .merge_file_KygURn
    test('confirm component has confirm method', function (): void {
=======
<<<<<<< .merge_file_2pLtl9
test('confirm component has confirm method', function (): void {
>>>>>>> .merge_file_X13YES
    })->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
=======
<<<<<<< HEAD
    test('confirm component has confirm method', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
=======
    test('confirm component has confirm method', function (): void {
    })->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
>>>>>>> laraxot/dev
>>>>>>> .merge_file_NosVhS

    test('confirm method declares redirect response return type', function (): void {
        $reflection = new ReflectionClass(ConfirmComponent::class);
        $method = $reflection->getMethod('confirm');
        $returnType = $method->getReturnType();

        Assert::assertNull($returnType);

        Assert::assertSame('Illuminate\Http\RedirectResponse', (string) $returnType);
    });
});
