<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
function cmsProfileGenerateUniqueEmail(): string
{
    return 'test+'.Str::uuid()->toString().'@example.com';
}

test('profile settings page can be rendered', function () {
    $lang = app()->getLocale();
    $response = \Pest\Laravel\get('/'.$lang.'/settings/profile');
    Assert::assertSame(404, $response->status());
});

test('profile information can be updated', function () {
});

test('email verification status is reset if email changes', function () {
});

test('email verification status is not reset if email does not change', function () {
});

test('user account can be deleted', function () {
});

test('user account deletion fails with wrong password', function () {
});
