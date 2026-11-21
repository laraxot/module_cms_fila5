<?php

declare(strict_types=1);

/**
 * Contratto Filament 5.x layout: le Blade Cms head/foot devono contenere
 * le direttive filamentStyles / filamentScripts (Configuring your layout).
 *
 * @see https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout
 * @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
<<<<<<< .merge_file_MYLBsT
 */

use Modules\Cms\Tests\TestCase;
=======
 *
 * Le direttive stanno dentro `@if ($panelAssets)`: un sito pubblico senza componenti Filament
 * le spegne con `:panel-assets="false"` (meno CSS/JS su telefono). L'ordine resta quello di Filament.
 */

>>>>>>> .merge_file_jmOYkU
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

<<<<<<< .merge_file_MYLBsT
// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

=======
>>>>>>> .merge_file_jmOYkU
test('cms head blade contains @filamentStyles before theme vite css', function (): void {
    $path = module_path('Cms', 'resources/views/components/head.blade.php');
    Assert::assertFileExists($path);
    $blade = file_get_contents($path);
    Assert::assertStringContainsString('@filamentStyles', $blade);
<<<<<<< .merge_file_MYLBsT
    Assert::assertMatchesRegularExpression('/@filamentStyles\s*\n\s*@vite\(\[\'resources\/css\/app\.css\'\]/', $blade);
=======
    Assert::assertMatchesRegularExpression('/@if \(\$panelAssets\)[\s\S]*@filamentStyles\s*\n\s*@endif\s*\n\s*@vite\(\[\'resources\/css\/app\.css\'\]/', $blade);
>>>>>>> .merge_file_jmOYkU
});

test('cms foot blade contains notifications then @filamentScripts then theme vite js', function (): void {
    $path = module_path('Cms', 'resources/views/components/foot.blade.php');
    Assert::assertFileExists($path);
    $blade = file_get_contents($path);
    Assert::assertStringContainsString("@livewire('notifications')", $blade);
    // Nessun wrapp auth attorno alle notifications (contratto Filament layout).
    Assert::assertDoesNotMatchRegularExpression('/@auth\s*\n\s*@livewire\(\'notifications\'\)/', $blade);
    Assert::assertStringContainsString('@filamentScripts', $blade);
<<<<<<< .merge_file_MYLBsT
    Assert::assertMatchesRegularExpression("/@livewire\\('notifications'\\)\\s*\\n\\s*\\n@filamentScripts\\s*\\n@vite\\(\\['resources\\/js\\/app\\.js'\\]/", $blade);
=======
    Assert::assertMatchesRegularExpression("/@if \\(\\\$panelAssets\\)\\s*\\n\\s*@livewire\\('notifications'\\)\\s*\\n\\s*\\n\\s*@filamentScripts\\s*\\n@endif\\s*\\n@vite\\(\\['resources\\/js\\/app\\.js'\\]/", $blade);
>>>>>>> .merge_file_jmOYkU
});
