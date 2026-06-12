<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Http\Volt;

use Livewire\Volt\Component as VoltComponent;
use Modules\Cms\Http\Volt\RegisterComponent;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

final class RegisterComponentTest extends TestCase
{
    public function testRegisterComponentExtendsVoltComponent(): void
    {
        $component = new RegisterComponent();

        Assert::assertInstanceOf(VoltComponent::class, $component);
    }

    public function testRegisterComponentHasExpectedPublicPropertiesDefaults(): void
    {
        $component = new RegisterComponent();

        Assert::assertTrue((new \ReflectionClass($component))->hasProperty('name'));

        Assert::assertTrue((new \ReflectionClass($component))->hasProperty('email'));

        Assert::assertTrue((new \ReflectionClass($component))->hasProperty('password'));

        Assert::assertTrue((new \ReflectionClass($component))->hasProperty('password_confirmation'));

        Assert::assertSame('', $component->name);

        Assert::assertSame('', $component->email);

        Assert::assertSame('', $component->password);

        Assert::assertSame('', $component->password_confirmation);
    }

    public function testRegisterComponentHasRegisterMethod(): void
    {
        /* @phpstan-ignore-next-line */
        Assert::assertTrue(method_exists(RegisterComponent::class, 'register'));
    }

    public function testRegisterMethodReturnsRedirectResponse(): void
    {
        $reflection = new \ReflectionClass(RegisterComponent::class);
        $method = $reflection->getMethod('register');
        $returnType = $method->getReturnType();

        Assert::assertNotNull($returnType);
        /* @var \ReflectionNamedType $returnType */
        Assert::assertSame('Illuminate\Http\RedirectResponse', $returnType->getName());
    }
}
