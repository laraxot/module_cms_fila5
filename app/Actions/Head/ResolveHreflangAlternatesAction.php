<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Head;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\QueueableAction\QueueableAction;

/**
 * Alternative linguistiche (hreflang) della pagina corrente.
 *
 * Ogni versione deve elencare se stessa e tutte le altre con URL assolute
 * (Google: link reciproci); `x-default` punta alla lingua predefinita.
 */
final class ResolveHreflangAlternatesAction
{
    use QueueableAction;

    public const string X_DEFAULT = 'x-default';

    /**
     * @param  list<string>|null  $onlyLocales  lingue in cui la pagina esiste davvero; `null` = tutte quelle supportate
     * @return array<string, string> codice lingua => URL assoluta
     */
    public function execute(?array $onlyLocales = null): array
    {
        $urls = [];
        foreach (array_keys(LaravelLocalization::getSupportedLocales()) as $code) {
            $url = LaravelLocalization::getLocalizedURL($code, null, [], true);
            if (is_string($url) && ($onlyLocales === null || in_array((string) $code, $onlyLocales, true))) {
                $urls[(string) $code] = $url;
            }
        }

        // `?page=N` identifica un contenuto diverso (paginazione): resta negli URL dichiarati,
        // altrimenti ogni pagina della serie dichiara le stesse alternative della prima.
        return $this->build($urls, LaravelLocalization::getDefaultLocale(), $this->paginationQuery());
    }

    /**
     * @param  array<string, string>  $localizedUrls  codice lingua => URL della stessa pagina in quella lingua
     * @param  string  $query  query da conservare negli URL (es. `?page=2`), senza `?` iniziale
     * @return array<string, string>
     */
    public function build(array $localizedUrls, string $defaultLocale, string $query = ''): array
    {
        $suffix = $query !== '' ? '?'.$query : '';
        $alternates = [];
        foreach ($localizedUrls as $code => $url) {
            $alternates[$code] = $this->withoutQuery($url).$suffix;
        }

        if (count($alternates) < 2) {
            return [];
        }

        if (isset($alternates[$defaultLocale])) {
            $alternates[self::X_DEFAULT] = $alternates[$defaultLocale];
        }

        return $alternates;
    }

    private function withoutQuery(string $url): string
    {
        return explode('#', explode('?', $url, 2)[0], 2)[0];
    }

    /** Solo `page` intero >= 2: e' l'unico parametro che cambia il contenuto di una pagina pubblica. */
    private function paginationQuery(): string
    {
        $page = request()->query('page');

        return is_numeric($page) && (int) $page >= 2 ? 'page='.(int) $page : '';
    }
}
