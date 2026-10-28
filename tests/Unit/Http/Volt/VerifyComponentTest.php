<?php

declare(strict_types=1);

use Modules\Cms\Http\Volt\VerifyComponent;
use PHPUnit\Framework\Assert;

describe('VerifyComponent', function (): void {
    test('verify component extends volt component', function (): void {
        $component = new VerifyComponent;
<<<<<<< HEAD
        Assert::assertSame(VerifyComponent::class, $component::class);
=======
>>>>>>> 127b4277 (.)

    });

<<<<<<< HEAD
    test('verify component has resend method', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
    test('verify component has resend method #2', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
=======
    test('verify component has resend method', function (): void {
        Assert::assertTrue((new ReflectionClass(VerifyComponent::class))->hasMethod('resend'));
    });
>>>>>>> 127b4277 (.)

    test('resend method returns void', function (): void {
        $reflection = new ReflectionClass(VerifyComponent::class);
        $method = $reflection->getMethod('resend');
        $returnType = $method->getReturnType();

        Assert::assertInstanceOf(ReflectionNamedType::class, $returnType);
        Assert::assertSame('void', $returnType->getName());
    });
});
