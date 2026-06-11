<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Modules\Cms\Actions\ResolvePageAction;
use Modules\Cms\Database\Factories\PageFactory;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

final class ResolvePageActionTest extends TestCase
{
    /**
     * The connections that should be transacted.
     *
     * @var array<int, string>
     */
    protected $connectionsToTransact = ['mysql', 'meetup', 'user', 'tenant'];

    public function testItResolvesADynamicModelFromKnownMappings(): void
    {
        if (! class_exists('Modules\\Meetup\\Models\\Event')) {
            $this->markTestSkipped('Meetup module not available.');
        }

        $this->markTestSkipped('Meetup EventFactory not configured in this workspace.');
    }

    public function testItResolvesACmsPageWithExactSlug(): void
    {
        $slug = 'about.us-'.uniqid();
        PageFactory::new()->createOne(['slug' => $slug]);

        $action = app(ResolvePageAction::class);
        $result = $action->execute('about', (string) Str::after($slug, 'about.'));

        Assert::assertSame('cms', $result->renderMode);
        Assert::assertSame($slug, $result->pageSlug);
    }

    public function testItFallsBackToContainerViewIfSlugNotFound(): void
    {
        $viewSlug = 'blog.view';
        PageFactory::new()->createOne(['slug' => $viewSlug]);

        $container = (string) Str::before($viewSlug, '.');
        $action = app(ResolvePageAction::class);
        $result = $action->execute($container, 'non-existent');

        Assert::assertSame('cms', $result->renderMode);
        Assert::assertSame($viewSlug, $result->pageSlug);
    }

    public function testItReturnsFullSlugAsFinalFallback(): void
    {
        $action = app(ResolvePageAction::class);
        $result = $action->execute('unknown', 'page');

        Assert::assertSame('cms', $result->renderMode);
        Assert::assertSame('unknown.page', $result->pageSlug);
    }
}
