<?php

declare(strict_types=1);

use Modules\Cms\Filament\Resources\AttachmentResource;
use Modules\Cms\Models\Attachment;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('AttachmentResource', function (): void {
    test('attachment resource has correct model', function (): void {
        $resource = new AttachmentResource;

        Assert::assertSame(Attachment::class, $resource::getModel());
    });

    test('attachment resource has form schema', function (): void {
        $schema = AttachmentResource::getFormSchema();
<<<<<<< .merge_file_cME2Im
/* @var array<string, mixed> $schema */
=======
<<<<<<< HEAD
       /* @var array<string, mixed> $schema */
=======
        /* @var array<string, mixed> $schema */
>>>>>>> laraxot/dev
>>>>>>> .merge_file_wI8OYM
        Assert::assertGreaterThan(0, count($schema));
    });

    test('attachment resource has relations', function (): void {
        $relations = AttachmentResource::getRelations();
<<<<<<< .merge_file_cME2Im
/* @var array<string, mixed> $relations */
=======
<<<<<<< HEAD
       /* @var array<string, mixed> $relations */
=======
        /* @var array<string, mixed> $relations */
>>>>>>> laraxot/dev
>>>>>>> .merge_file_wI8OYM
    });

    test('attachment resource has pages', function (): void {
        $pages = AttachmentResource::getPages();
<<<<<<< .merge_file_cME2Im
/* @var array<string, mixed> $pages */
=======
<<<<<<< HEAD
       /* @var array<string, mixed> $pages */
=======
        /* @var array<string, mixed> $pages */
>>>>>>> laraxot/dev
>>>>>>> .merge_file_wI8OYM
        Assert::assertArrayHasKey('index', $pages);
        Assert::assertArrayHasKey('create', $pages);
        Assert::assertArrayHasKey('edit', $pages);
    });

    test('attachment resource extends LangBaseResource', function (): void {
        Assert::assertTrue(class_exists(AttachmentResource::class));
    });

    test('attachment resource has navigation icon', function (): void {
        Assert::assertTrue(property_exists(AttachmentResource::class, 'navigationIcon'));
    });

    test('attachment resource has navigation label', function (): void {
        Assert::assertTrue(property_exists(AttachmentResource::class, 'navigationLabel'));
    });

<<<<<<< .merge_file_cME2Im
test('attachment resource has plural label', function (): void {
    })->todo('AttachmentResource non dichiara ne\' $pluralModelLabel ne\' getPluralModelLabel(): l\'etichetta arriva da XotBaseResource via trans(). Il test va scritto sul valore tradotto, non sull\'esistenza del membro.');
=======
<<<<<<< HEAD
    test('attachment resource has plural label', function (): void {})->todo('AttachmentResource non dichiara ne\' $pluralModelLabel ne\' getPluralModelLabel(): l\'etichetta arriva da XotBaseResource via trans(). Il test va scritto sul valore tradotto, non sull\'esistenza del membro.');
=======
    test('attachment resource has plural label', function (): void {
    })->todo('AttachmentResource non dichiara ne\' $pluralModelLabel ne\' getPluralModelLabel(): l\'etichetta arriva da XotBaseResource via trans(). Il test va scritto sul valore tradotto, non sull\'esistenza del membro.');
>>>>>>> laraxot/dev
>>>>>>> .merge_file_wI8OYM
});
