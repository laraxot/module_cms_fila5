<?php

declare(strict_types=1);

/**
 * Contratto Filament 5.x layout: le Blade Cms head/foot devono contenere
 * le direttive filamentStyles / filamentScripts.
 *
 * @see https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout
 * @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
<<<<<<< .merge_file_TUFmcv
=======
 *
 * Le direttive sono sempre emesse dal contratto del front office. L'ordine resta quello di Filament.
>>>>>>> .merge_file_MNqBqM
 */
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

// This is a pure Blade contract test; it does not boot the Laravel application.
/** @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md */
test('cms head blade contains @filamentStyles before theme vite css', function (): void {
    $path = dirname(__DIR__, 3).'/resources/views/components/head.blade.php';
    Assert::assertFileExists($path);
    $blade = file_get_contents($path);
    Assert::assertStringContainsString('@filamentStyles', $blade);
    Assert::assertMatchesRegularExpression('/@filamentStyles\s*\n\s*@vite\(\[\'resources\/css\/app\.css\'\]/', $blade);
});

/** @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md */
test('cms foot blade contains notifications then @filamentScripts then theme vite js', function (): void {
    $path = dirname(__DIR__, 3).'/resources/views/components/foot.blade.php';
    Assert::assertFileExists($path);
    $blade = file_get_contents($path);
    Assert::assertStringContainsString("@livewire('notifications')", $blade);
    Assert::assertDoesNotMatchRegularExpression('/@auth\s*\n\s*@livewire\(\'notifications\'\)/', $blade);
    Assert::assertStringContainsString('@filamentScripts', $blade);
    Assert::assertMatchesRegularExpression("/@livewire\\('notifications'\\)\\s*\\n\\s*\\n@filamentScripts\\s*\\n@vite\\(\\['resources\\/js\\/app\\.js'\\]/", $blade);
});
