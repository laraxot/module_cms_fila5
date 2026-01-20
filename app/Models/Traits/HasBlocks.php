<?php

declare(strict_types=1);

namespace Modules\Cms\Models\Traits;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Modules\Cms\Datas\BlockData;
use Modules\Xot\Datas\XotData;

trait HasBlocks
{
    /**
     * @return array<string, mixed>
     */
    public function getBlocks(): array
    {
        $blocks = $this->blocks;

        if (! is_array($blocks)) {
            $primary_lang = XotData::make()->primary_lang;
            $blocks = $this->getTranslation('blocks', $primary_lang);
        }

        if (! is_array($blocks)) {
            $blocks = [];
        }

        $blocks = $this->compile($blocks);

        return BlockData::collect($blocks);
    }

    /**
     * @return array<string, mixed>
     */
    public function compile(array $blocks): array
    {
        foreach ($blocks as $key => $value) {
            if (is_array($value)) {
                $blocks[$key] = $this->compile($value);
            }
            if (is_string($value) && Str::containsAll($value, ['{{', '}}'])) {
                $blocks[$key] = Blade::render($value);
            }
        }

        return $blocks;
    }

    public static function getBlocksBySlug(string $slug): array
    {
        $model = static::class;
        $record = $model::firstWhere('slug', $slug);
        if (! $record) {
            return [];
        }

        /* @phpstan-ignore-next-line method.notFound, return.type */
        return $record->getBlocks();
    }
}
