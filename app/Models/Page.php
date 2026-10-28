<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\MultipleRecordsFoundException;
use Illuminate\Support\Carbon;
use Modules\Cms\Database\Factories\PageFactory;
use Modules\Cms\Models\Traits\HasBlocks;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modules\Cms\Models\Page.
 *
 * @property string|null                         $id
 * @property array<array-key, mixed>|null        $title
 * @property string|null                         $slug
 * @property array<array-key, mixed>|null        $middleware
 * @property string|null                         $content
 * @property string|null                         $description
 * @property string|null                         $layout
 * @property array<array-key, mixed>|null        $blocks
 * @property array<array-key, mixed>|null        $content_blocks
 * @property array<array-key, mixed>|null        $sidebar_blocks
 * @property array<array-key, mixed>|null        $footer_blocks
 * @property Carbon|null                         $created_at
 * @property Carbon|null                         $updated_at
 * @property string|null                         $created_by
 * @property string|null                         $updated_by
 * @property ProfileContract|null                $creator
 * @property array<int|string, mixed>            $translatable_columns_from
 * @property array<string, array<string, mixed>> $translations
 * @property ProfileContract|null                $updater
 *
 * @method static Builder<static>|Page                                  newModelQuery()
 * @method static Builder<static>|Page                                  newQuery()
 * @method static Builder<static>|Page                                  query()
 * @method static Builder<static>|Page                                  whereContent($value)
 * @method static Builder<static>|Page                                  whereContentBlocks($value)
 * @method static Builder<static>|Page                                  whereCreatedAt($value)
 * @method static Builder<static>|Page                                  whereCreatedBy($value)
 * @method static Builder<static>|Page                                  whereDescription($value)
 * @method static Builder<static>|Page                                  whereFooterBlocks($value)
 * @method static Builder<static>|Page                                  whereId($value)
 * @method static Builder<static>|Page                                  whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Page                                  whereJsonContainsLocales(string $column, array<int, string> $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Page                                  whereLocale(string $column, string $locale)
 * @method static Builder<static>|Page                                  whereLocales(string $column, array<int, string> $locales)
 * @method static Builder<static>|Page                                  whereMiddleware($value)
 * @method static Builder<static>|Page                                  whereSidebarBlocks($value)
 * @method static Builder<static>|Page                                  whereSlug($value)
 * @method static Builder<static>|Page                                  whereTitle($value)
 * @method static Builder<static>|Page                                  whereUpdatedAt($value)
 * @method static Builder<static>|Page                                  whereUpdatedBy($value)
 * @method static Builder<static>|Page                                  where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static static|null                                           first(array|string $columns = ['*'])
 * @method static static|null                                           firstWhere(string $column, mixed $operator = null, mixed $value = null)
 * @method static static                                                firstOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 * @method static static                                                create(array<string, mixed> $attributes = [])
 * @method static static                                                updateOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 * @method static Builder<static>|Page                                  delete()
 * @method static Builder<static>|Page                                  whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotIn($column, $values, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereNull($columns, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotNull($columns, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereBetween($column, array<int, mixed> $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotBetween($column, array<int, mixed> $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereDate($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereMonth($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereDay($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereYear($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereTime($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereColumn($column, string $operator, mixed $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  orderBy($column, $direction = 'asc')
 * @method static Builder<static>|Page                                  latest($column = 'created_at')
 * @method static Builder<static>|Page                                  oldest($column = 'created_at')
 * @method static Builder<static>|Page                                  limit($value)
 * @method static Builder<static>|Page                                  take($value)
 * @method static Builder<static>|Page                                  skip($value)
 * @method static Builder<static>|Page                                  offset($value)
 * @method static int                                                   count()
 * @method static int                                                   max($column)
 * @method static int                                                   min($column)
 * @method static int                                                   sum($column)
 * @method static float                                                 avg($column)
 * @method static mixed                                                 pluck($column, $key = null)
 * @method static Builder<static>|Page                                  join($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  leftJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  rightJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  crossJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  having($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page                                  orWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereHas($relation, $operator = '>=', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page                                  whereDoesntHave($relation, $operator = '<', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page                                  whereJsonContains($column, mixed $value, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereJsonLength($column, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereJsonPath($path, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereJsonOverlaps($column, $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  with($relations)
 * @method static Builder<static>|Page                                  without($relations)
 * @method static Builder<static>|Page                                  withCount($relations)
 * @method static Builder<static>|Page                                  withSum($relation, $column)
 * @method static Builder<static>|Page                                  withAvg($relation, $column)
 * @method static Builder<static>|Page                                  withMin($relation, $column)
 * @method static Builder<static>|Page                                  withMax($relation, $column)
 * @method static Builder<static>|Page                                  findOrFail($id, $columns = ['*'])
 * @method static static                                                findOrFail($id, $columns = ['*'])
 * @method static static                                                firstOrFail($columns = ['*'])
 * @method static static                                                firstOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 * @method static static                                                create(array<string, mixed> $attributes = [])
 * @method static static                                                updateOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 * @method static static                                                update($attributes)
 * @method static Builder<static>|Page                                  where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotIn($column, $values, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereNull($columns, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotNull($columns, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereBetween($column, array<int, mixed> $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotBetween($column, array<int, mixed> $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereDate($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereMonth($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereDay($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereYear($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereTime($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereColumn($column, string $operator, mixed $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  orderBy($column, $direction = 'asc')
 * @method static Builder<static>|Page                                  latest($column = 'created_at')
 * @method static Builder<static>|Page                                  oldest($column = 'created_at')
 * @method static Builder<static>|Page                                  limit($value)
 * @method static Builder<static>|Page                                  take($value)
 * @method static Builder<static>|Page                                  skip($value)
 * @method static Builder<static>|Page                                  offset($value)
 * @method static int                                                   count()
 * @method static int                                                   max($column)
 * @method static int                                                   min($column)
 * @method static int                                                   sum($column)
 * @method static float                                                 avg($column)
 * @method static mixed                                                 pluck($column, $key = null)
 * @method static Builder<static>|Page                                  join($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  leftJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  rightJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  crossJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  having($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page                                  orWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereHas($relation, $operator = '>=', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page                                  whereDoesntHave($relation, $operator = '<', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page                                  whereJsonContains($column, mixed $value, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereJsonLength($column, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereJsonPath($path, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereJsonOverlaps($column, $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  with($relations)
 * @method static Builder<static>|Page                                  without($relations)
 * @method static Builder<static>|Page                                  withCount($relations)
 * @method static Builder<static>|Page                                  withSum($relation, $column)
 * @method static Builder<static>|Page                                  withAvg($relation, $column)
 * @method static Builder<static>|Page                                  withMin($relation, $column)
 * @method static Builder<static>|Page                                  withMax($relation, $column)
 * @method static Builder<static>|Page                                  findOrFail($id, $columns = ['*'])
 * @method static static                                                findOrFail($id, $columns = ['*'])
 * @method static static                                                firstOrFail($columns = ['*'])
 * @method static static                                                firstOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 * @method static static                                                create(array<string, mixed> $attributes = [])
 * @method static static                                                updateOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 * @method static static                                                update($attributes)
 * @method static int                                                   increment($column, $amount = 1, $extra = [])
 * @method static int                                                   decrement($column, $amount = 1, $extra = [])
 * @method static bool                                                  truncate()
 * @method static static                                                destroy($ids)
 * @method static static                                                restore()
 * @method static static                                                forceDelete()
 * @method static static                                                onlyTrashed()
 * @method static static                                                withTrashed()
 * @method static static                                                withoutTrashed()
 * @method static Collection<int, static>                               all($columns = ['*'])
 * @method static Collection<int, static>                               get($columns = ['*'])
 * @method static static|null                                           first($columns = ['*'])
 * @method static static|null                                           find($id, $columns = ['*'])
 * @method static Builder<static>|Page                                  newModelQuery()
 * @method static Builder<static>|Page                                  newQuery()
 * @method static Builder<static>|Page                                  query()
 * @method static Builder<static>|Page                                  whereContent($value)
 * @method static Builder<static>|Page                                  whereContentBlocks($value)
 * @method static Builder<static>|Page                                  whereCreatedAt($value)
 * @method static Builder<static>|Page                                  whereCreatedBy($value)
 * @method static Builder<static>|Page                                  whereDescription($value)
 * @method static Builder<static>|Page                                  whereFooterBlocks($value)
 * @method static Builder<static>|Page                                  whereId($value)
 * @method static Builder<static>|Page                                  whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Page                                  whereJsonContainsLocales(string $column, array<int, string> $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Page                                  whereLocale(string $column, string $locale)
 * @method static Builder<static>|Page                                  whereLocales(string $column, array<int, string> $locales)
 * @method static Builder<static>|Page                                  whereMiddleware($value)
 * @method static Builder<static>|Page                                  whereSidebarBlocks($value)
 * @method static Builder<static>|Page                                  whereSlug($value)
 * @method static Builder<static>|Page                                  whereTitle($value)
 * @method static Builder<static>|Page                                  whereUpdatedAt($value)
 * @method static Builder<static>|Page                                  whereUpdatedBy($value)
 * @method static Builder<static>|Page                                  where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static static|null                                           first(array|string $columns = ['*'])
 * @method static static|null                                           firstWhere(string $column, mixed $operator = null, mixed $value = null)
 * @method static static                                                firstOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 * @method static static                                                create(array<string, mixed> $attributes = [])
 * @method static static                                                updateOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 * @method static Builder<static>|Page                                  delete()
 * @method static Builder<static>|Page                                  whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotIn($column, $values, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereNull($columns, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotNull($columns, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereBetween($column, array<int, mixed> $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotBetween($column, array<int, mixed> $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereDate($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereMonth($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereDay($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereYear($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereTime($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereColumn($column, string $operator, mixed $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  orderBy($column, $direction = 'asc')
 * @method static Builder<static>|Page                                  latest($column = 'created_at')
 * @method static Builder<static>|Page                                  oldest($column = 'created_at')
 * @method static Builder<static>|Page                                  limit($value)
 * @method static Builder<static>|Page                                  take($value)
 * @method static Builder<static>|Page                                  skip($value)
 * @method static Builder<static>|Page                                  offset($value)
 * @method static int                                                   count()
 * @method static int                                                   max($column)
 * @method static int                                                   min($column)
 * @method static int                                                   sum($column)
 * @method static float                                                 avg($column)
 * @method static mixed                                                 pluck($column, $key = null)
 * @method static Builder<static>|Page                                  join($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  leftJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  rightJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  crossJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  having($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page                                  orWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereHas($relation, $operator = '>=', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page                                  whereDoesntHave($relation, $operator = '<', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page                                  whereJsonContains($column, mixed $value, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereJsonLength($column, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereJsonPath($path, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereJsonOverlaps($column, $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  with($relations)
 * @method static Builder<static>|Page                                  without($relations)
 * @method static Builder<static>|Page                                  withCount($relations)
 * @method static Builder<static>|Page                                  withSum($relation, $column)
 * @method static Builder<static>|Page                                  withAvg($relation, $column)
 * @method static Builder<static>|Page                                  withMin($relation, $column)
 * @method static Builder<static>|Page                                  withMax($relation, $column)
 * @method static Builder<static>|Page                                  findOrFail($id, $columns = ['*'])
 * @method static static                                                findOrFail($id, $columns = ['*'])
 * @method static static                                                firstOrFail($columns = ['*'])
 * @method static static                                                firstOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 * @method static static                                                create(array<string, mixed> $attributes = [])
 * @method static static                                                updateOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 * @method static static                                                update($attributes)
 * @method static Builder<static>|Page                                  where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotIn($column, $values, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereNull($columns, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotNull($columns, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereBetween($column, array<int, mixed> $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotBetween($column, array<int, mixed> $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereDate($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereMonth($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereDay($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereYear($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereTime($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereColumn($column, string $operator, mixed $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  orderBy($column, $direction = 'asc')
 * @method static Builder<static>|Page                                  latest($column = 'created_at')
 * @method static Builder<static>|Page                                  oldest($column = 'created_at')
 * @method static Builder<static>|Page                                  limit($value)
 * @method static Builder<static>|Page                                  take($value)
 * @method static Builder<static>|Page                                  skip($value)
 * @method static Builder<static>|Page                                  offset($value)
 * @method static int                                                   count()
 * @method static int                                                   max($column)
 * @method static int                                                   min($column)
 * @method static int                                                   sum($column)
 * @method static float                                                 avg($column)
 * @method static mixed                                                 pluck($column, $key = null)
 * @method static Builder<static>|Page                                  join($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  leftJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  rightJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  crossJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page                                  having($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page                                  orWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereNotExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereHas($relation, $operator = '>=', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page                                  whereDoesntHave($relation, $operator = '<', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page                                  whereJsonContains($column, mixed $value, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page                                  whereJsonLength($column, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereJsonPath($path, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  whereJsonOverlaps($column, $value, $boolean = 'and')
 * @method static Builder<static>|Page                                  with($relations)
 * @method static Builder<static>|Page                                  without($relations)
 * @method static Builder<static>|Page                                  withCount($relations)
 * @method static Builder<static>|Page                                  withSum($relation, $column)
 * @method static Builder<static>|Page                                  withAvg($relation, $column)
 * @method static Builder<static>|Page                                  withMin($relation, $column)
 * @method static Builder<static>|Page                                  withMax($relation, $column)
 * @method static Builder<static>|Page                                  findOrFail($id, $columns = ['*'])
 * @method static static                                                findOrFail($id, $columns = ['*'])
 * @method static static                                                firstOrFail($columns = ['*'])
 * @method static static                                                firstOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 * @method static static                                                create(array<string, mixed> $attributes = [])
 * @method static static                                                updateOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 * @method static static                                                update($attributes)
 * @method static int                                                   increment($column, $amount = 1, $extra = [])
 * @method static int                                                   decrement($column, $amount = 1, $extra = [])
 * @method static bool                                                  truncate()
 * @method static static                                                destroy($ids)
 * @method static static                                                restore()
 * @method static static                                                forceDelete()
 * @method static static                                                onlyTrashed()
 * @method static static                                                withTrashed()
 * @method static static                                                withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static static|null                                           first($columns = ['*'])
 * @method static static|null                                           find($id, $columns = ['*'])
 *
 * @property ProfileContract|null $deleter
 *
 * @method static PageFactory factory($count = null, $state = [])
 *
 * @property array<array-key, mixed>|null $blocks
 *
 * @method static Builder<static>|Page                        whereBlocks($value)
 * @method        array<int, array<string, mixed>>            getSushiRows()
 * @method static array<string, \Modules\Cms\Datas\BlockData> getBlocksBySlug(string $slug, ?string $side = null)
 * @method static array<int, string>                          getMiddlewareBySlug(string $slug)
 * @method static PageFactory                                 factory($count = null, $state = [])
 * @method static Builder<static>|Page                        newModelQuery()
 * @method static Builder<static>|Page                        newQuery()
 * @method static Builder<static>|Page                        query()
 * @method static Builder<static>|Page                        whereBlocks($value)
 * @method static Builder<static>|Page                        whereContent($value)
 * @method static Builder<static>|Page                        whereContentBlocks($value)
 * @method static Builder<static>|Page                        whereCreatedAt($value)
 * @method static Builder<static>|Page                        whereCreatedBy($value)
 * @method static Builder<static>|Page                        whereDescription($value)
 * @method static Builder<static>|Page                        whereFooterBlocks($value)
 * @method static Builder<static>|Page                        whereId($value)
 * @method static Builder<static>|Page                        whereMiddleware($value)
 * @method static Builder<static>|Page                        whereSidebarBlocks($value)
 * @method static Builder<static>|Page                        whereSlug($value)
 * @method static Builder<static>|Page                        whereTitle($value)
 * @method static Builder<static>|Page                        whereUpdatedAt($value)
 * @method static Builder<static>|Page                        whereUpdatedBy($value)
 * @method static Builder<static>|Page                        whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Page                        whereJsonContainsLocales(string $column, array<int, string> $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Page                        whereLocale(string $column, string $locale)
 * @method static Builder<static>|Page                        whereLocales(string $column, array<int, string> $locales)
 * @method static Collection<int, static>                     all($columns = ['*'])
 * @method static Collection<int, static>                     get($columns = ['*'])
 * @method static static|null                                 first($columns = ['*'])
 * @method static static|null                                 find($id, $columns = ['*'])
 * @method static array<string, \Modules\Cms\Datas\BlockData> getBlocksBySlug(string $slug, ?string $side = null)
 * @method static array<int, string>                          getMiddlewareBySlug(string $slug)
 * @method        array<int, array<string, mixed>>            getSushiRows()
 *
 * @mixin \Eloquent
 */
class Page extends BaseModelLang
{
    use HasBlocks;
    use SushiToJsons;

    /** @var list<string> */
    public array $translatable = [
        'title',
        // 'description',
        'blocks',
        'content_blocks',
        'sidebar_blocks',
        'footer_blocks',
    ];

    /** @var list<string> */
    protected $fillable = [
        'content',
        'description',
        'layout',
        'slug',
        'title',
        'middleware',
        'blocks',
        'content_blocks',
        'sidebar_blocks',
        'footer_blocks',
    ];

    /** @var array<string, string> */
    protected $schema = [
        'id' => 'integer',
        'title' => 'json',
        'slug' => 'string',
        'middleware' => 'json',
        'content' => 'string',
        'description' => 'string',
        'layout' => 'string',
        'blocks' => 'json',
        'content_blocks' => 'json',
        'sidebar_blocks' => 'json',
        'footer_blocks' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        $rows = $this->getSushiRows();

        return $rows;
    }

    public static function findUniqueBySlug(string $slug): ?self
    {
        try {
            return self::query()->where('slug', $slug)->sole();
        } catch (MultipleRecordsFoundException $e) {
            throw new \RuntimeException(sprintf("Page slug duplication detected for slug='%s': %d CMS pages found (expected 1). Check database / CMS JSON for duplicate '%s'.", $slug, $e->getCount(), $slug), previous: $e);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * Middleware dichiarati dal JSON della pagina, o `[]` se la pagina non esiste o non ne dichiara.
     *
     * @return list<string>
     *
     * @throws \UnexpectedValueException se il campo e' dichiarato ma non e' una lista di stringhe (DCP-283, C-03)
     */
    public static function getMiddlewareBySlug(string $slug): array
    {
        $page = self::findUniqueBySlug($slug);

        return $page instanceof self ? $page->declaredMiddleware() : [];
    }

    /**
     * Un campo `middleware` illeggibile NON equivale a "nessun middleware": renderebbe pubblica una pagina protetta.
     * Esempi misurati: la stringa `"auth"` al posto della lista il cast `array` la legge come null; `array_filter(is_string)`
     * toglieva le voci non stringa. Solo `null`, assente o `[]` sono una pagina pubblica.
     *
     * @return list<string>
     *
     * @throws \UnexpectedValueException
     */
    public function declaredMiddleware(): array
    {
        $middleware = $this->middleware;

        if ($middleware === null) {
            if (null !== ($this->getAttributes()['middleware'] ?? null)) {
                throw new \UnexpectedValueException(sprintf("Il campo 'middleware' della pagina '%s' e' dichiarato ma non e' una lista JSON.", (string) $this->slug));
            }

            return [];
        }

        if (! array_is_list($middleware)) {
            throw new \UnexpectedValueException(sprintf("Il campo 'middleware' della pagina '%s' non e' una lista.", (string) $this->slug));
        }

        $declared = [];
        foreach ($middleware as $entry) {
            if (! \is_string($entry) || trim($entry) === '') {
                throw new \UnexpectedValueException(sprintf("Il campo 'middleware' della pagina '%s' contiene una voce che non e' una stringa non vuota.", (string) $this->slug));
            }
            $declared[] = $entry;
        }

        return $declared;
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
            'layout' => 'string',
        ];
    }
}
