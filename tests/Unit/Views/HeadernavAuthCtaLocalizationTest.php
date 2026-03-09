<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Views;

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

test('headernav auth ctas use theme localization keys and not legacy auth keys', function (): void {
    $paths = [
        base_path('Modules/Cms/resources/views/components/headernav/simple.blade.php'),
        base_path('Modules/Cms/resources/views/components/blocks/headernav/simple.blade.php'),
    ];

    foreach ($paths as $path) {
        $content = file_get_contents($path);

        expect($content)->not->toBeFalse();
        if (! is_string($content)) {
            continue;
        }

        expect($content)
            ->toContain("__('pub_theme::navigation.auth.login')")
            ->toContain("__('pub_theme::navigation.auth.register')")
            ->not->toContain("__('user::auth.login-in')")
            ->not->toContain("__('user::auth.sign-up')");
    }
});

test('headernav auth ctas use localized auth urls', function (): void {
    $paths = [
        base_path('Modules/Cms/resources/views/components/headernav/simple.blade.php'),
        base_path('Modules/Cms/resources/views/components/blocks/headernav/simple.blade.php'),
    ];

    foreach ($paths as $path) {
        $content = file_get_contents($path);

        expect($content)->not->toBeFalse();
        if (! is_string($content)) {
            continue;
        }

        expect($content)
            ->toContain("localizeUrl('/auth/login')")
            ->toContain("localizeUrl('/auth/register')");
    }
});
