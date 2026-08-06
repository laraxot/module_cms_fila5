<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;
use Livewire\Wireable;
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class FooterData extends Data implements Wireable
{
    use WireableData;

    public ?string $background_color = null;

    public ?string $background = null;

    public ?string $overlay_color = null;

    /**
     * The view path.
     */
    public string $view = 'cms::components.footer';

    public ?string $_tpl = null;

    private static ?self $instance = null;

    public static function make(): self
    {
        if (! self::$instance instanceof FooterData) {
            $data = app(GetTenantConfigArrayAction::class)->execute('appearance');
            $data = Arr::get($data, 'footer', []);
            self::$instance = self::from($data);
        }

        return self::$instance;
    }

    public function view(): Renderable
    {
        if (! view()->exists(// @var mixed view
            $message = 'The view ['.// @var mixed view.'] does not exist';
            throw new \Exception($message);
        }
        /** @var array<string, mixed> */
        $view_params = // @var mixed toArray(;

        return view(// @var mixed view, $view_params;
    }

    /**
     * @return array<string, mixed>
     */
    /**
     * @return array<string, mixed>
     */
    public static function rules(): array
    {
        return [
            'background_color' => ['nullable', 'string'],
            'background' => ['nullable', 'string'],
            'overlay_color' => ['nullable', 'string'],
            'view' => ['nullable', 'string'],
            '_tpl' => ['nullable', 'string'],
        ];
    }
}
