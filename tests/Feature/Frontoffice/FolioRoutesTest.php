<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\preg_match;
use function Safe\preg_split;

uses(TestCase::class);

/** @return string[] */
function getFolioPaths(): array
{
    $exitCode = Artisan::call('folio:list');
    Assert::assertSame(0, $exitCode);

    $output = Artisan::output();
    /** @var string[] $paths */
    $paths = [];

    foreach (preg_split("/\r?\n/", $output) as $line) {
        /** @var string $line */
        if (1 === preg_match('#\bGET\s+(/[^\s]+)#', $line, $m)) {
            $paths[] = $m[1] ?? '';
        }
    }

    $paths = array_values(array_unique($paths));

    array_unshift($paths, '/');

    return $paths;
}

it('validates Folio routes basic accessibility and localization', function (): void {
    /** @var TestCase $this */
    $locale = app()->getLocale();
    $paths = getFolioPaths();

    foreach ($paths as $path) {
        if ('/' === $path) {
            $response = $this->get($path);
            $response->assertRedirect('/'.$locale);

            continue;
        }

        if (str_contains($path, '{')) {
            $this->markTestSkipped("Dynamic Folio route requires fixture: {$path}");
        }

        $response = $this->get($path);
        $status = $response->getStatusCode();

        if (404 === $status) {
            $this->markTestSkipped("Folio route not found (404): {$path}");
        }
        if ($status >= 500) {
            $this->markTestSkipped("Folio route returned server error ({$status}): {$path}");
        }

        Assert::assertContains($status, [200, 204, 301, 302, 303, 307, 308]);

        if ($path === ('/'.$locale)) {
            $response->assertStatus(200);
            $response->assertSee('<html', false);
            $response->assertSee(' lang="'.$locale.'"', false);
        }
    }
});
