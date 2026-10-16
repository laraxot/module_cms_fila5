<?php

declare(strict_types=1);

use Modules\Cms\Models\Policies\CmsBasePolicy;
use Modules\Cms\Models\Policies\ConfPolicy;
use Modules\Cms\Models\Policies\MenuPolicy;
use Modules\Cms\Models\Policies\ModulePolicy;
use Modules\Cms\Models\Policies\PageContentPolicy;
use Modules\Cms\Models\Policies\PagePolicy;
use Modules\Cms\Models\Policies\SectionPolicy;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

test('CmsBasePolicy is an abstract class', function () {
    $reflection = new ReflectionClass(CmsBasePolicy::class);

    Assert::assertTrue($reflection->isAbstract());
});

test('PagePolicy can be instantiated', function () {
    $policy = new PagePolicy();

    Assert::assertInstanceOf(PagePolicy::class, $policy);
});

test('SectionPolicy can be instantiated', function () {
    $policy = new SectionPolicy();

    Assert::assertInstanceOf(SectionPolicy::class, $policy);
});

test('PageContentPolicy can be instantiated', function () {
    $policy = new PageContentPolicy();

    Assert::assertInstanceOf(PageContentPolicy::class, $policy);
});

test('ConfPolicy can be instantiated', function () {
    $policy = new ConfPolicy();

    Assert::assertInstanceOf(ConfPolicy::class, $policy);
});

test('MenuPolicy can be instantiated', function () {
    $policy = new MenuPolicy();

    Assert::assertInstanceOf(MenuPolicy::class, $policy);
});

test('ModulePolicy can be instantiated', function () {
    $policy = new ModulePolicy();

    Assert::assertInstanceOf(ModulePolicy::class, $policy);
});

test('PagePolicy grants abilities from the page.* permissions', function () {
    $policy = new PagePolicy();
    $user = cmsCreateMock(UserContract::class);
    $user->method('hasPermissionTo')->willReturnCallback(
        static fn (mixed $permission): bool => 'page.viewAny' === $permission,
    );

    Assert::assertTrue($policy->viewAny($user));
    Assert::assertFalse($policy->create($user));
});

test('CmsBasePolicy before() short-circuits only for super-admin', function () {
    $policy = new PagePolicy();
    $admin = cmsCreateMock(UserContract::class);
    $admin->method('hasRole')->willReturn(true);
    $user = cmsCreateMock(UserContract::class);
    $user->method('hasRole')->willReturn(false);

    Assert::assertTrue($policy->before($admin, 'viewAny'));
    Assert::assertNull($policy->before($user, 'viewAny'));
});
