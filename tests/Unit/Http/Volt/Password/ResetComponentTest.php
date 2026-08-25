<?php

declare(strict_types=1);

use Livewire\Volt\Component as VoltComponent;
use Modules\Cms\Http\Volt\Password\ResetComponent;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('Password ResetComponent', function (): void {
    test('reset component extends volt component', function (): void {
        $component = new ResetComponent;

        Assert::assertInstanceOf(VoltComponent::class, $component);
    });

    test('reset component has expected public properties', function (): void {
        $component = new ResetComponent;

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('email'));

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('emailSentMessage'));

        Assert::assertNull($component->email);

        Assert::assertFalse($component->emailSentMessage);
    });

<<<<<<< .merge_file_pRxa1z
    test('reset component has send reset password link method', function (): void {
=======
<<<<<<< .merge_file_QVgRlw
test('reset component has send reset password link method', function (): void {
>>>>>>> .merge_file_0cJt5U
    })->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
=======
<<<<<<< HEAD
    test('reset component has send reset password link method', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
=======
    test('reset component has send reset password link method', function (): void {
    })->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
>>>>>>> laraxot/dev
>>>>>>> .merge_file_LJhnqT

    test('send reset password link method returns void', function (): void {
        $reflection = new ReflectionClass(ResetComponent::class);
        $method = $reflection->getMethod('sendResetPasswordLink');
        $returnType = $method->getReturnType();

        Assert::assertNull($returnType);

        Assert::assertSame('void', (string) $returnType);
    });
});
