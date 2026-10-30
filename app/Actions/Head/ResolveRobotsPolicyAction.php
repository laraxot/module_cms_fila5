<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Head;

use Spatie\QueueableAction\QueueableAction;

/**
 * Decide se una pagina pubblica va indicizzata e quale direttiva robots emettere.
 *
 * Una sola fonte per `<meta name="robots">` e per chi costruisce la sitemap:
 * le aree riservate restano raggiungibili (il noindex va letto dal crawler),
 * ma non devono finire nell'indice.
 */
final class ResolveRobotsPolicyAction
{
    use QueueableAction;

    private const string INDEXABLE = 'index, follow, max-image-preview:large';

    private const string HIDDEN = 'noindex, follow';

    /** Primo segmento di percorso (dopo la lingua) che non si indicizza. */
    /** @var list<string> */
    private const array HIDDEN_SEGMENTS = ['auth', 'profile', 'dashboard', 'coming-soon', 'preview-content'];

    /**
     * @param list<string> $localeCodes codici lingua che possono prefissare il percorso (`it`, `en`, ...)
     * @param bool         $translated  `false` se la pagina non ha contenuto nella lingua corrente (duplicato della lingua di ripiego)
     */
    public function execute(string $path, array $localeCodes, bool $translated = true): string
    {
        return $this->isIndexable($path, $localeCodes, $translated) ? self::INDEXABLE : self::HIDDEN;
    }

    /**
     * @param list<string> $localeCodes
     */
    public function isIndexable(string $path, array $localeCodes, bool $translated = true): bool
    {
        if (! $translated) {
            return false;
        }

        $segments = array_values(array_filter(explode('/', trim($path, '/')), static fn (string $segment): bool => '' !== $segment));

        if (isset($segments[0]) && in_array($segments[0], $localeCodes, true)) {
            array_shift($segments);
        }

        return ! in_array($segments[0] ?? '', self::HIDDEN_SEGMENTS, true);
    }
}
