<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\Lang;
use Illuminate\View\Component;
use Laravel\Head\Facades\Head as HeadManager;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Cms\Actions\BuildPageSchemaAction;
use Modules\Cms\Actions\Head\BuildHeadSchemaAction;
use Modules\Cms\Actions\Head\ResolveHreflangAlternatesAction;
use Modules\Cms\Actions\Head\ResolveRobotsPolicyAction;
use Modules\Cms\Models\Page;
use Modules\Xot\Datas\MetatagData;

use function Safe\json_decode;
use function Safe\parse_url;

/**
 * Il `<head>` del front office: la vista emette `<head>…</head>`, i layout non lo avvolgono.
 *
 * I valori di pagina si scrivono a runtime sullo strato più alto di `laravel/head`
 * (senza `flush()`, per non cancellare ciò che una pagina ha già impostato).
 * Testi e immagini del sito arrivano dal tema (`pub_theme::seo.*`, `pub_theme::header.*`);
 * un tag senza dato reale viene omesso, mai riempito con segnaposto o chiavi grezze.
 */
final class Head extends Component
{
    private const string SOCIAL_IMAGE = 'images/social-share.jpg';

    private const int SOCIAL_IMAGE_WIDTH = 1200;

    private const int SOCIAL_IMAGE_HEIGHT = 630;

    private const string DEFAULT_THEME_COLOR = '#0f2b46';

    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $description = null,
        public readonly ?bool $homepage = null,
        public readonly ?string $themeColor = null,
    ) {
    }

    public function render(): ViewContract
    {
        $meta = MetatagData::make();
        $brand = $this->resolveBrand($meta);
        $page = $this->resolvePage();
        $pageTitle = $this->resolvePageTitle($page);
        $title = $this->composeDocumentTitle($pageTitle, $brand);
        $description = $this->resolveDescription();
        $canonical = url()->current();
        $localeCodes = array_keys(LaravelLocalization::getSupportedLocales());
        $translatedLocales = $this->translatedLocales($page);
        $translated = null === $translatedLocales || in_array(app()->getLocale(), $translatedLocales, true);
        $robots = app(ResolveRobotsPolicyAction::class);
        $path = request()->path();
        $image = $this->themeAssetUrl($meta, self::SOCIAL_IMAGE);

        HeadManager::title($title, exact: true)
            ->viewport('width=device-width, initial-scale=1.0')
            ->applicationName($brand)
            ->canonical($canonical, forceHttps: false)
            ->robots($robots->execute($path, $localeCodes, $translated))
            ->og(type: $meta->getType(), title: $title, description: $description, url: $canonical, siteName: $brand, locale: $this->openGraphLocale())
            ->twitter(card: null !== $image ? 'summary_large_image' : 'summary', title: $title, description: $description);

        if (null !== $description) {
            HeadManager::description($description);
        }

        HeadManager::themeColor($this->themeColor ?? self::DEFAULT_THEME_COLOR);

        if (null !== $image) {
            HeadManager::ogImage($image, alt: $brand, width: self::SOCIAL_IMAGE_WIDTH, height: self::SOCIAL_IMAGE_HEIGHT)->twitterImage($image, alt: $brand);
        }

        $this->applyIcons($meta);

        if ($robots->isIndexable($path, $localeCodes, $translated)) {
            HeadManager::alternates(app(ResolveHreflangAlternatesAction::class)->execute($translatedLocales));
            $this->applySchema($meta, $brand, $pageTitle, $description, $canonical);
        }

        return view('cms::components.head');
    }

    private function resolveBrand(MetatagData $meta): string
    {
        $key = 'pub_theme::header.brand.name';

        return Lang::has($key) ? trim((string) __($key)) : trim($meta->getBrandName());
    }

    private function resolveDescription(): ?string
    {
        if (null !== $this->description && '' !== trim($this->description)) {
            return trim($this->description);
        }

        $key = 'pub_theme::seo.site.description';

        return Lang::has($key) ? trim((string) __($key)) : null;
    }

    private function openGraphLocale(): ?string
    {
        $regional = LaravelLocalization::getCurrentLocaleRegional();

        return is_string($regional) && '' !== $regional ? $regional : null;
    }

    private function composeDocumentTitle(string $pageTitle, string $brand): string
    {
        if ('' === $pageTitle) {
            return $brand;
        }

        return '' === $brand || str_contains($pageTitle, $brand) ? $pageTitle : $pageTitle.' — '.$brand;
    }

    private function resolvePageTitle(?Page $page): string
    {
        $pageTitle = trim((string) $this->title);
        if ('' !== $pageTitle || null === $page) {
            return $pageTitle;
        }

        $titleValue = $page->getAttribute('title');

        return is_string($titleValue) ? trim($titleValue) : '';
    }

    /**
     * Lingue in cui la pagina CMS ha un titolo scritto davvero (le altre ripiegano sulla lingua predefinita).
     * `null` quando la rotta non è una pagina CMS o il dato non è leggibile: nessuna restrizione.
     *
     * @return list<string>|null
     */
    private function translatedLocales(?Page $page): ?array
    {
        if (null === $page) {
            return null;
        }

        $raw = $page->getRawOriginal('title');
        $titles = is_string($raw) && str_starts_with(ltrim($raw), '{') ? json_decode($raw, true) : $raw;
        if (! is_array($titles)) {
            return null;
        }

        $written = array_filter($titles, static fn (mixed $text): bool => is_string($text) && '' !== trim($text));

        return array_values(array_map('strval', array_keys($written)));
    }

    private function resolvePage(): ?Page
    {
        $route = request()->route();
        if (! is_object($route)) {
            return null;
        }

        $container = $route->parameter('container0');
        $slug = $route->parameter('slug0');
        $routeName = (string) $route->getName();
        $slugs = array_values(array_filter([
            is_string($container) && is_string($slug) && '' !== $slug ? $container.'.'.$slug : null,
            is_string($container) ? $container : null,
            ! in_array($routeName, ['', 'container0', 'container0.view'], true) ? $routeName : null,
        ]));
        foreach ($slugs as $cmsSlug) {
            $page = Page::findUniqueBySlug($cmsSlug);
            if (null !== $page) {
                return $page;
            }
        }

        return null;
    }

    private function applyIcons(MetatagData $meta): void
    {
        $favicon = $this->themeAssetUrl($meta, 'favicon.ico');
        $appleTouchIcon = $this->themeAssetUrl($meta, 'favicon-180x180.png');
        $manifest = $this->themeAssetUrl($meta, 'site.webmanifest');

        if (null !== $favicon) {
            HeadManager::favicon($favicon);
        }

        if (null !== $appleTouchIcon) {
            HeadManager::appleTouchIcon($appleTouchIcon, '180x180');
        }

        if (null !== $manifest) {
            HeadManager::manifest($manifest);
        }
    }

    /** URL dell'asset del tema, solo se il file esiste davvero in `public/`. */
    private function themeAssetUrl(MetatagData $meta, string $file): ?string
    {
        $url = $meta->getPubThemeAsset($file);
        $path = parse_url($url, PHP_URL_PATH);

        return is_string($path) && is_file(public_path(ltrim($path, '/'))) ? $url : null;
    }

    private function applySchema(MetatagData $meta, string $brand, string $pageTitle, ?string $description, string $canonical): void
    {
        $isHome = $this->isHomepage();
        $logo = $meta->getBrandLogo();
        $schemas = app(BuildHeadSchemaAction::class)->execute(
            isHome: $isHome,
            brand: $brand,
            homeUrl: url('/'.app()->getLocale()),
            pageTitle: '' !== $pageTitle ? $pageTitle : $brand,
            pageUrl: $canonical,
            locale: app()->getLocale(),
            logoUrl: '' !== $logo ? url($logo) : null,
            page: $isHome ? [] : $this->resolvePageEntity($meta, '' !== $pageTitle ? $pageTitle : $brand, $description),
        );

        foreach ($schemas as $schema) {
            HeadManager::schema($schema);
        }
    }

    /** @return array<string, mixed> */
    private function resolvePageEntity(MetatagData $meta, string $name, ?string $description): array
    {
        $route = request()->route();
        $user = auth()->user();
        $routeParameters = [];
        if (is_object($route)) {
            foreach ($route->parameters() as $key => $value) {
                if (is_string($key)) {
                    $routeParameters[$key] = $value;
                }
            }
        }

        return app(BuildPageSchemaAction::class)->execute(
            meta: $meta,
            routeName: is_object($route) ? $route->getName() : null,
            path: request()->path(),
            routeParameters: $routeParameters,
            user: $user instanceof Authenticatable ? $user : null,
            name: $name,
            description: $description ?? '',
        );
    }

    private function isHomepage(): bool
    {
        if (null !== $this->homepage) {
            return $this->homepage;
        }

        $route = request()->route();
        $path = trim(request()->path(), '/');
        $locale = (string) app()->getLocale();

        return (is_object($route) && 'home' === $route->getName()) || '' === $path || $path === $locale;
    }
}
