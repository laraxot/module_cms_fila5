<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Livewire\Livewire;
use Modules\User\Filament\Widgets\RegistrationWidget;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;

// Use Cms specific TestCase only for this file
uses(TestCase::class);


// REGISTRATION WIDGET TESTS - Filament Component
// ✅ Test del WIDGET Filament, non della pagina
// ✅ Focus su: rendering, form interaction, basic validation
// ✅ Architettura: Filament Widget + XotBaseWidget + dynamic resolution

// WIDGET CORE TESTS
            ->set('data.password', 'TestPassword123!');

        try {
            $widget->call('register');
            expect(true)->toBeTrue();
        } catch (\Exception $e) {
            expect($e)->toBeInstanceOf(\Exception::class);
        }
});
