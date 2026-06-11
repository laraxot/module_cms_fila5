<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(Modules\Cms\Tests\TestCase::class);
it('renders the italian privacy page from cms json content', function (): void {
        cmsGet('/it/privacy')
        ->assertOk()
        ->assertSee('Privacy Policy')
        ->assertSee('Ultimo aggiornamento: 9 marzo 2026')
        ->assertSee('Diritti dell\'interessato')
        ->assertSee('privacy@laravelpizza.com');
});

it('renders the italian terms page from cms json content', function (): void {
        cmsGet('/it/terms')
        ->assertOk()
        ->assertSee('Termini e Condizioni')
        ->assertSee('Ultimo aggiornamento: 9 marzo 2026')
        ->assertSee('Limitazione di responsabilita')
        ->assertSee('hello@laravelpizza.com');
});
