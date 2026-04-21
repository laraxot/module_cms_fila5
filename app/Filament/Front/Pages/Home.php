<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Front\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class Home extends XotBasePage
{
    public string $view_type = 'home';
    public array $containers = [];
    public array $items = [];

    protected string $view = 'pub_theme::home';
    protected static string $layout = 'pub_theme::components.layouts.app';

    public function mount(): void
    {
        $this->initView();
    }

    public function getViewData(): array
    {
<<<<<<< HEAD
        return [];
=======
        $data = [];
        if ($this->containers !== []) {
            Assert::string($container_last = last($this->containers), '['.__LINE__.']['.__FILE__.']');
            $item_last = last($this->items);

            $container_last_singular = Str::singular($container_last);
            $container_last_model = Relation::getMorphedModel($container_last_singular);
            Assert::notNull($container_last_model, '['.__LINE__.']['.__FILE__.']');
            Assert::string($container_last_model, 'Container last model should be a string');

            $modelInstance = app($container_last_model);
            if (is_object($modelInstance) && method_exists($modelInstance, 'getRouteKeyName')) {
                $container_last_key_name = $modelInstance->getRouteKeyName();
                Assert::string($container_last_key_name, 'Route key name must be a string');

                /** @var class-string<Model> $modelClass */
                $modelClass = $container_last_model;

                // Ensure the model class has the where method
                if (! method_exists($modelClass, 'where')) {
                    throw new \RuntimeException("Model class {$modelClass} does not have where method");
                }

                /** @var Builder<Model> $query */
                $query = $modelClass::where($container_last_key_name, $item_last);
                $row = $query->first();
                $data[$container_last_singular] = $row;
            }
        }

        return $data;
>>>>>>> 5580e39 (.)
    }

    public function initView(): void
    {
        $this->view_type = 'home';
        if (view()->exists($this->view)) {
            return;
        }
<<<<<<< HEAD
        $this->view = 'cms::filament.front.pages.welcome';
=======
        if (\count($containers) > \count($items)) {
            $view = 'index';
        }
        if ($containers === []) {
            $view = 'home';
        }

        $this->view_type = $view;

        $views = [];

        if ($containers !== []) {
            $views[] = 'pub_theme::'.implode('.', $containers).'.'.$view;

            $firstContainer = $containers[0] ?? '';
            Assert::string($firstContainer, 'First container must be a string');

            $model_root = Str::singular($firstContainer);
            $res = Relation::getMorphedModel($model_root);
            Assert::string($res, '['.__LINE__.']['.__FILE__.']');

            $module_name = Str::between($res, 'Modules\\', '\\Models\\');
            Assert::string($module_name, 'Module name must be a string');
            $module_name_low = Str::lower($module_name);
            $views[] = $module_name_low.'::'.implode('.', $containers).'.'.$view;
        } else {
            $views[] = 'pub_theme::'.$view;
        }

        $view_work = Arr::first($views, view()->exists(...));
        Assert::string($view_work, __FILE__.':'.__LINE__.' - '.class_basename(self::class));

        $this->view = $view_work;
    }

    public function url(string $name, array $parameters = []): string
    {
        $parameters['lang'] = app()->getLocale();
        $record = $parameters['record'] ?? null;

        if ($record && is_object($record) && $name === 'show') {
            $container0 = class_basename($record);
            $container0 = Str::plural($container0);
            $container0 = Str::snake($container0);
            $parameters['container0'] = $container0;
            $parameters['item0'] = $record->slug ?? '';

            return route('test', $parameters);
        }

        if ($record && is_object($record) && $name === 'index') {
            $container0 = class_basename($record);
            $container0 = Str::plural($container0);
            $container0 = Str::snake($container0);
            $parameters['container0'] = $container0;

            return route('test', $parameters);
        }

        $parameters['container0'] = 'articles';
        $parameters['item0'] = 'zibibbo';

        return route('test', $parameters);
>>>>>>> 5580e39 (.)
    }
}
