<?php

declare(strict_types=1);

use ReflectionClass;


use PHPUnit\Framework\Assert;
use Livewire\Volt\Component as VoltComponent;
use Modules\Cms\Http\Volt\RegisterComponent;


uses(Modules\Cms\Tests\TestCase::class);
describe('RegisterComponent', function (): void {
    test('register component extends volt component', function (): void {
        $component = new RegisterComponent();

        Assert::assertInstanceOf(VoltComponent::class, $component);
    });

    test('register component has expected public properties defaults', function (): void {
        $component = new RegisterComponent();

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('name'));

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('email'));

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('password'));

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('password_confirmation'));

        Assert::assertSame('', $component->name);

        Assert::assertSame('', $component->email);

        Assert::assertSame('', $component->password);

        Assert::assertSame('', $component->password_confirmation);
    });

    test('register component has register method', function (): void {
            });

    test('register method returns redirect response', function (): void {
        $reflection = new \ReflectionClass(RegisterComponent::class);
        $method = $reflection->getMethod('register');
        $returnType = $method->getReturnType();

        Assert::assertNull($returnType);

        Assert::assertSame('Illuminate\Http\RedirectResponse', (string) $returnType);
    });
});
