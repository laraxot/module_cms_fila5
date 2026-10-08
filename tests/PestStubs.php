<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Livewire\Component;
use Livewire\Features\SupportTesting\Testable;

// Stubs Pest/Livewire per PHPStan — non usati a runtime.
if (! function_exists('actingAs')) {
    /**
     * @param Authenticatable $user
     * @param string|null $driver
     * @return TestResponse<Response>
     */
    function actingAs(Authenticatable $user, ?string $driver = null): TestResponse
    {
        throw new RuntimeException('Stub not intended for runtime use: '.get_debug_type($user).'/'.get_debug_type($driver));
    }
}

if (! function_exists('livewire')) {
    /**
     * @param string $component
     * @param array<string, mixed> $params
     *
     * @return Testable<Component>
     */
    function livewire(string $component, array $params = []): Testable
    {
        throw new RuntimeException('Stub not intended for runtime use: '.get_debug_type($component).'/'.get_debug_type($params));
    }
}
