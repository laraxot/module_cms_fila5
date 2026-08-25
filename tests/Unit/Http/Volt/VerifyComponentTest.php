<?php

declare(strict_types=1);

use Livewire\Volt\Component as VoltComponent;
use Modules\Cms\Http\Volt\VerifyComponent;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('VerifyComponent', function (): void {
    test('verify component extends volt component', function (): void {
        $component = new VerifyComponent;

        Assert::assertInstanceOf(VoltComponent::class, $component);
    });

<<<<<<< .merge_file_VS7547
test('verify component has resend method', function (): void {
    })->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
=======
<<<<<<< HEAD
    test('verify component has resend method', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
=======
    test('verify component has resend method', function (): void {
    })->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
>>>>>>> laraxot/dev
>>>>>>> .merge_file_9aqWjK

    test('resend method returns void', function (): void {
        $reflection = new ReflectionClass(VerifyComponent::class);
        $method = $reflection->getMethod('resend');
        $returnType = $method->getReturnType();

        Assert::assertNull($returnType);

        Assert::assertSame('void', (string) $returnType);
    });
});
