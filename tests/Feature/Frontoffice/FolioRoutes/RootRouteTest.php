<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
<<<<<<< HEAD
t('GET / redirects to /{locale}', function (): void {
=======
it('GET / redirects to /{locale}', function (): void {
>>>>>>> laraxot/dev
    $locale = app()->getLocale();
    cmsGet('/')->assertRedirect('/'.$locale);
});
