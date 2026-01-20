<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Tenant\Models\Traits\SushiToJsons;

/**
 * Modules\Cms\Models\Page.
 *
 * @property string                                      $id
 * @property array<array-key, mixed>|null                $title
 * @property string|null                                 $slug
 * @property array<array-key, mixed>|null                $middleware
 * @property string|null                                 $content
 * @property string|null                                 $description
 * @property array<array-key, mixed>|null                $content_blocks
 * @property array<array-key, mixed>|null                $sidebar_blocks
 * @property array<array-key, mixed>|null                $footer_blocks
 * @property Carbon|null                                 $created_at
 * @property Carbon|null                                 $updated_at
 * @property string|null                                 $created_by
 * @property string|null                                 $updated_by
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property mixed                                       $translations
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 *
 * @method static Builder<static>|Page                               newModelQuery()
 * @method static Builder<static>|Page                               newQuery()
 * @method static Builder<static>|Page                               query()
 * @method static Builder<static>|Page                               whereContent($value)
 * @method static Builder<static>|Page                               whereContentBlocks($value)
 * @method static Builder<static>|Page                               whereCreatedAt($value)
 * @method static Builder<static>|Page                               whereCreatedBy($value)
 * @method static Builder<static>|Page                               whereDescription($value)
 * @method static Builder<static>|Page                               whereFooterBlocks($value)
 * @method static Builder<static>|Page                               whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereLocales(string $column, array $locales)
 * @method static Builder<static>|Page                               whereMiddleware($value)
 * @method static Builder<static>|Page                               whereSidebarBlocks($value)
 * @method static Builder<static>|Page                               whereSlug($value)
 * @method static Builder<static>|Page                               whereTitle($value)
 * @method static Builder<static>|Page                               whereUpdatedAt($value)
 * @method static Builder<static>|Page                               whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class Page extends BaseModelLang
{
    use SushiToJsons;

    /** @var array<int, string> */
    public $translatable = [
        'title',
        // 'description',
        'content_blocks',
        'sidebar_blocks',
        'footer_blocks',
    ];

    protected $fillable = [
        'content',
        'description',
        'slug',
        'title',
        'middleware',
        'content_blocks',
        'sidebar_blocks',
        'footer_blocks',
    ];

    protected array $schema = [
        'id' => 'integer',
        'title' => 'json',
        'slug' => 'string',
        'middleware' => 'json',
        'content' => 'string',
        'description' => 'string',
        'content_blocks' => 'json',
        'sidebar_blocks' => 'json',
        'footer_blocks' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];

    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    public static function getMiddlewareBySlug(string $slug): array
    {
        $page = self::where('slug', $slug)->first();

        return $page->middleware ?? [];
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @return array<string, string> */
    #[\Override]
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            // 'images' => 'array',
            'date' => 'datetime',
            'published_at' => 'datetime',
            'active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'content_blocks' => 'array',
            'sidebar_blocks' => 'array',
            'footer_blocks' => 'array',
            'middleware' => 'array',
        ];
    }
}
