<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Head;

use Laravel\Head\Schema\Breadcrumbs;
use Laravel\Head\Schema\Organization;
use Laravel\Head\Schema\SchemaObject;
use Laravel\Head\Schema\WebSite;
use Spatie\QueueableAction\QueueableAction;

/**
 * Dati strutturati schema.org del `<head>`.
 *
 * Home: `Organization` + `WebSite` (descrivono chi è il sito, una volta sola).
 * Pagine interne: l'entità di pagina già risolta + `BreadcrumbList`.
 * Non si pubblicano proprietà senza dato reale (indirizzo, telefono, sameAs):
 * Google le tratta come contenuto da verificare.
 */
final class BuildHeadSchemaAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $page entità di pagina già risolta (vedi BuildPageSchemaAction)
     *
     * @return list<SchemaObject|array<string, mixed>>
     */
    public function execute(
        bool $isHome,
        string $brand,
        string $homeUrl,
        string $pageTitle,
        string $pageUrl,
        string $locale,
        ?string $logoUrl,
        array $page,
    ): array {
        if ($isHome) {
            return [$this->organization($brand, $homeUrl, $logoUrl), $this->webSite($brand, $homeUrl, $locale)];
        }

        return [$page, $this->breadcrumbs($brand, $homeUrl, $pageTitle, $pageUrl)];
    }

    private function organization(string $brand, string $homeUrl, ?string $logoUrl): Organization
    {
        $organization = (new Organization())->name($brand)->url($homeUrl);

        return null !== $logoUrl ? $organization->logo($logoUrl) : $organization;
    }

    private function webSite(string $brand, string $homeUrl, string $locale): SchemaObject
    {
        return (new WebSite())->name($brand)->url($homeUrl)->set('inLanguage', $locale);
    }

    private function breadcrumbs(string $brand, string $homeUrl, string $pageTitle, string $pageUrl): Breadcrumbs
    {
        return (new Breadcrumbs())->item($brand, $homeUrl)->item($pageTitle, $pageUrl);
    }
}
