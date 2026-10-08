<?php

declare(strict_types=1);

use Modules\Cms\View\Composers\ThemeComposer;
use PHPUnit\Framework\Assert;

test('ThemeComposer can be instantiated', function () {
    $composer = new ThemeComposer();
    Assert::assertInstanceOf(ThemeComposer::class, $composer);
});

test('ThemeComposer returns menu items as an array', function () {
    $menu = new \Modules\Cms\Models\Menu();
    $menu->title = 'unit-test-menu';
    $menu->setAttribute('items', ['home' => ['type' => 'internal', 'url' => 'home']]);
    $menu->save();

    Assert::assertSame(['home' => ['type' => 'internal', 'url' => 'home']], (new ThemeComposer())->getMenu('unit-test-menu'));
});

test('ThemeComposer returns a placeholder for an unsupported menu type', function () {
    Assert::assertSame('#', (new ThemeComposer())->getMenuUrl(['type' => 'unsupported', 'url' => 'unused']));
});

test('ThemeComposer renders page content as a view', function () {
    Assert::assertInstanceOf(
        \Illuminate\Contracts\View\View::class,
        (new ThemeComposer())->showPageContent('theme-composer-test-'.uniqid()),
    );
});

test('ThemeComposer returns all page models as an Eloquent collection', function () {
    Assert::assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, (new ThemeComposer())->getPages());
});

test('ThemeComposer returns null for a page slug that does not exist', function () {
    Assert::assertNull((new ThemeComposer())->getPageModel('theme-composer-missing-'.uniqid()));
});

test('ThemeComposer getMenuUrl returns hash for empty array', function () {
    $composer = new ThemeComposer();
    $result = $composer->getMenuUrl([]);
    Assert::assertSame('#', $result);
});

test('ThemeComposer getUrlPage returns hash for non-existent page', function () {
    $composer = new ThemeComposer();
    $result = $composer->getUrlPage('non-existent-page-'.uniqid());
    Assert::assertSame('#', $result);
});
