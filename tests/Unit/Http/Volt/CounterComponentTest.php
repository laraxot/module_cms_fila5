<?php

declare(strict_types=1);

use Livewire\Volt\Component;
use Modules\Cms\Http\Volt\CounterComponent;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('CounterComponent', function (): void {
    test('counter component extends volt component', function (): void {
        $component = new CounterComponent;

        Assert::assertInstanceOf(Component::class, $component);
    });

    test('counter component has count property', function (): void {
        $component = new CounterComponent;

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('count'));
    });

<<<<<<< .merge_file_zP9PZP
test('counter component has increment method', function (): void {
=======
<<<<<<< HEAD
    test('counter component has increment method', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');

    test('counter component has decrement method', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
=======
    test('counter component has increment method', function (): void {
>>>>>>> .merge_file_Xt7G8S
    })->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');

    test('counter component has decrement method', function (): void {
    })->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
<<<<<<< .merge_file_zP9PZP
=======
>>>>>>> laraxot/dev
>>>>>>> .merge_file_Xt7G8S

    test('counter component uses correct namespace', function (): void {
        $reflector = new ReflectionClass(CounterComponent::class);

<<<<<<< .merge_file_zP9PZP
Assert::assertSame('Modules\Cms\Http\Volt', $reflector->getNamespaceName());
=======
<<<<<<< HEAD
       Assert::assertSame('Modules\Cms\Http\Volt', $reflector->getNamespaceName());
=======
        Assert::assertSame('Modules\Cms\Http\Volt', $reflector->getNamespaceName());
>>>>>>> laraxot/dev
>>>>>>> .merge_file_Xt7G8S
    });

    test('counter component count starts at zero', function (): void {
        $component = new CounterComponent;

        Assert::assertSame(0, $component->count);
    });
});
