<?php

declare(strict_types=1);

namespace Modules\Cms\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Laravel\Folio\Folio;
use Livewire\Volt\Volt;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Modules\Cms\Http\Middleware\SetFolioLocale;
use Modules\Xot\Datas\XotData;
use Nwidart\Modules\Facades\Module;

use function Safe\realpath;

use Webmozart\Assert\Assert;

class FolioVoltServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /*
         * Folio::path(resource_path('views/pages'))->middleware([
         * '*' => [
         * //
         * ],
         * ]);
         */
        $base_middleware = $this->resolveBaseMiddleware();
        $base_middleware[] = LaravelLocalizationRoutes::class;
        $base_middleware[] = LocaleSessionRedirect::class;
        $base_middleware[] = LaravelLocalizationRedirectFilter::class;
        // $base_middleware[]=\Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class;
        // $base_middleware[]=\Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class;

        $theme_path = XotData::make()->getPubThemeViewPath('pages');

        // Ottieni tutte le lingue supportate
        $supportedLocalesConfig = config('laravellocalization.supportedLocales', ['it' => []]);
        Assert::isArray($supportedLocalesConfig);
        /** @var array<string, mixed> $supportedLocalesConfig */
        $supportedLocales = array_map('strval', array_keys($supportedLocalesConfig));

        /**
         * @var Collection<int, \Nwidart\Modules\Module> $modules
         */
        $modules = Module::all();
        $paths = [];

        // Verifica che il percorso tema esista e sia una directory prima di passarlo a Folio
        if (File::exists($theme_path) && File::isDirectory($theme_path)) {
            foreach ($supportedLocales as $locale) {
                Folio::path($theme_path)
                    ->uri($locale)
                    ->middleware([
                        '*' => [
                            SetFolioLocale::class,
                            ...$base_middleware,
                        ],
                    ]);
            }
            $paths[] = $theme_path;
        }

        // Theme Livewire block components: livewire/ → blocks.events.detail, components/blocks → events.detail
        $theme_views = \dirname($theme_path);
        $theme_livewire = $theme_views.\DIRECTORY_SEPARATOR.'livewire';
        if (File::exists($theme_livewire) && File::isDirectory($theme_livewire)) {
            $paths[] = realpath($theme_livewire);
        }
        $theme_components_blocks = $theme_views.\DIRECTORY_SEPARATOR.'components'.\DIRECTORY_SEPARATOR.'blocks';
        if (File::exists($theme_components_blocks) && File::isDirectory($theme_components_blocks)) {
            $paths[] = realpath($theme_components_blocks);
        }

        foreach ($modules as $module) {
            $path = $module->getPath().'/resources/views/pages';
            if (! File::exists($path) || ! File::isDirectory($path)) {
                continue;
            }

            $apiPath = $path.'/api';
            if (File::exists($apiPath) && File::isDirectory($apiPath)) {
                Folio::path($apiPath)
                    ->uri('/api')
                    ->middleware([
                        '*' => ['web'],
                    ]);
            }

            $paths[] = $path;
            foreach ($supportedLocales as $locale) {
                Folio::path($path)
                    ->uri($locale)
                    ->middleware([
                        '*' => [
                            SetFolioLocale::class,
                            ...$base_middleware,
                        ],
                    ]);
            }
        }

        if (! empty($paths)) {
            Volt::mount($paths);
        }
    }

    /**
     * @return list<class-string|string>
     */
    private function resolveBaseMiddleware(): array
    {
        try {
            if (app()->runningInConsole() && ! app()->environment('testing')) {
                return ['web'];
            }

            $middleware = app(\Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction::class)->execute('middleware');
            if (! is_array($middleware)) {
                return ['web'];
            }

            $base = Arr::get($middleware, 'base', []);
            if (! is_array($base)) {
                return ['web'];
            }

            if (! \in_array('web', $base, true)) {
                array_unshift($base, 'web');
            }

            /** @var list<class-string|string> $typedBase */
            $typedBase = array_values(array_filter(
                $base,
                static fn (mixed $middleware): bool => is_string($middleware),
            ));

            return $typedBase;
        } catch (\Exception) {
            return ['web'];
        }
    }
}
