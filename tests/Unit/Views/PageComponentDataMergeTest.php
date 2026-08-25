<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;
use Modules\Cms\View\Components\Page;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('page component merges route context into block data', function (): void {
    $block = (object) [
        'view' => 'cms::tests.fixtures.slug-probe',
        'data' => [
            'name' => 'probe',
        ],
    ];

    $html = view('cms::components.page', [
        'blocks' => [$block],
        'side' => 'content',
        'slug' => 'events.view',
        'data' => [
            'slug0' => 'event-slug-123',
            'container0' => 'events',
            'slug1' => 'speaker-slug-456',
            'container1' => 'speakers',
        ],
    ])->render();

<<<<<<< HEAD
   Assert::assertStringContainsString('slug0=event-slug-123', $html);
=======
    Assert::assertStringContainsString('slug0=event-slug-123', $html);
>>>>>>> laraxot/dev

    Assert::assertStringContainsString('container0=events', $html);

    Assert::assertStringContainsString('slug1=speaker-slug-456', $html);

    Assert::assertStringContainsString('container1=speakers', $html);

    Assert::assertStringContainsString('name=probe', $html);

    Assert::assertStringContainsString('data_name=probe', $html);
});

test('page render exposes nested context', function (): void {
    $component = new Page(
        side: 'content',
        slug: 'events.view',
        data: [
            'container0' => 'events',
            'slug0' => 'event-slug-123',
            'container1' => 'speakers',
            'slug1' => 'speaker-slug-456',
        ],
    );

<<<<<<< HEAD
   Assert::assertArrayHasKey('container0', $component->data);
=======
    Assert::assertArrayHasKey('container0', $component->data);
>>>>>>> laraxot/dev

    Assert::assertSame('events', $component->data['container0']);

    Assert::assertArrayHasKey('slug0', $component->data);

    Assert::assertSame('event-slug-123', $component->data['slug0']);

    Assert::assertArrayHasKey('container1', $component->data);

    Assert::assertSame('speakers', $component->data['container1']);

    Assert::assertArrayHasKey('slug1', $component->data);

    Assert::assertSame('speaker-slug-456', $component->data['slug1']);

    $view = $component->render();
    $viewData = $view->getData();

<<<<<<< HEAD
   Assert::assertArrayHasKey('container0', $viewData);
=======
    Assert::assertArrayHasKey('container0', $viewData);
>>>>>>> laraxot/dev

    Assert::assertSame('events', $viewData['container0']);

    Assert::assertArrayHasKey('slug0', $viewData);

    Assert::assertSame('event-slug-123', $viewData['slug0']);

    Assert::assertArrayHasKey('container1', $viewData);

    Assert::assertSame('speakers', $viewData['container1']);

    Assert::assertArrayHasKey('slug1', $viewData);

    Assert::assertSame('speaker-slug-456', $viewData['slug1']);
});

test('page component internal view keys override conflicting data keys', function (): void {
    $component = new Page(
        side: 'content',
        slug: 'events.view',
        data: [
            'side' => 'sidebar',
            'slug' => 'user-provided-slug',
            'container0' => 'events',
            'slug0' => 'event-slug-123',
        ],
    );

    $viewData = $component->render()->getData();

<<<<<<< HEAD
   Assert::assertArrayHasKey('side', $viewData);
=======
    Assert::assertArrayHasKey('side', $viewData);
>>>>>>> laraxot/dev

    Assert::assertSame('content', $viewData['side']);

    Assert::assertArrayHasKey('slug', $viewData);

    Assert::assertSame('events.view', $viewData['slug']);

    Assert::assertArrayHasKey('container0', $viewData);

    Assert::assertSame('events', $viewData['container0']);

    Assert::assertArrayHasKey('slug0', $viewData);

    Assert::assertSame('event-slug-123', $viewData['slug0']);
});
