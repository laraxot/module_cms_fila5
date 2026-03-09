<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /de shows localized guest auth labels in the header', function (): void {
    $this->get('/de')
        ->assertOk()
        ->assertSee('lang="de"', false)
        ->assertSeeText('Anmelden')
        ->assertSeeText('Konto erstellen')
        ->assertDontSeeText('Accedi')
        ->assertDontSeeText('Registrati');
});
