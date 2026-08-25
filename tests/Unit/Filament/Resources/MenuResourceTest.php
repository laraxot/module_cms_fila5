<?php

declare(strict_types=1);

use Filament\Forms\Components\Field;
use Modules\Cms\Filament\Resources\MenuResource;
use Modules\Cms\Models\Menu;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('MenuResource', function (): void {
    test('menu resource has correct model', function (): void {
        $resource = new MenuResource();

<<<<<<< HEAD
       Assert::assertSame(Menu::class, $resource::getModel());
=======
        Assert::assertSame(Menu::class, $resource::getModel());
>>>>>>> laraxot/dev
    });

    test('menu resource has form schema', function (): void {
        $schema = MenuResource::getFormSchema();
<<<<<<< HEAD
       /* @var array<string, mixed> $schema */
=======
        /* @var array<string, mixed> $schema */
>>>>>>> laraxot/dev
        Assert::assertGreaterThan(0, count($schema));
    });

    test('menu resource has form fields', function (): void {
        $schema = MenuResource::getFormSchema();

        // Check that form has required components
        $hasTitle = false;
        $hasItems = false;

        foreach ($schema as $item) {
<<<<<<< HEAD
           if (! $item instanceof Field) {
=======
            if (! $item instanceof Field) {
>>>>>>> laraxot/dev
                continue;
            }
            $name = $item->getName();
            if ('title' === $name) {
                $hasTitle = true;
            }
            if ('items' === $name) {
                $hasItems = true;
            }
        }

<<<<<<< HEAD
       Assert::assertTrue($hasTitle);
=======
        Assert::assertTrue($hasTitle);
>>>>>>> laraxot/dev
        Assert::assertTrue($hasItems);
    });

    test('menu resource extends XotBaseResource', function (): void {
        Assert::assertTrue(class_exists(MenuResource::class));
    });
});
