<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Assert;

/*
 * `XotPanelController` e `BaseController` sono stati rimossi di proposito (regola di progetto: nessun Controller HTTP,
 * la logica sta nelle Actions e le pagine in Folio/Volt/Filament). Il test dichiara la regola invece del vecchio controller.
 */
describe('Cms senza Controller HTTP', function (): void {
    test('app/Http/Controllers non contiene classi', function (): void {
        $dir = dirname(__DIR__, 5).'/app/Http/Controllers';

        $files = is_dir($dir) ? File::allFiles($dir) : [];

        Assert::assertCount(0, $files);
    });
});
