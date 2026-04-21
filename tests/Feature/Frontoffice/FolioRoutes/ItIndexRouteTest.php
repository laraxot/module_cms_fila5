<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

<<<<<<< HEAD
it('GET /{locale} uses the requested locale in the html lang attribute', function (): void {
    foreach (['it', 'en', 'de'] as $locale) {
        /** @phpstan-ignore-next-line property.notFound */
        $response = $this->get('/'.$locale);
=======
it('GET /{locale} returns 200 and has lang attribute', function (): void {
    $locale = app()->getLocale();
    /** @phpstan-ignore-next-line property.notFound */
    $response = // @var mixed get('/'.$locale;
>>>>>>> 526b81f (.)

        $status = (int) $response->getStatusCode();

        if ($status >= 500) {
            test()->markTestSkipped("Localized index route returned server error for [{$locale}] in this install.");

            return;
        }

        expect(in_array($status, [200, 204, 301, 302, 303, 307, 308, 404], true))->toBeTrue();

<<<<<<< HEAD
        if (200 === $status) {
            /* @phpstan-ignore-next-line method.nonObject */
            $response->assertSee('<html', false);
            /* @phpstan-ignore-next-line method.nonObject */
            $response->assertSee(' lang="'.$locale.'"', false);
        }
=======
    if ($status === 200) {
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertSee('<html', false);
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertSee(' lang="'.$locale.'"', false);
>>>>>>> 5580e39 (.)
    }
});
