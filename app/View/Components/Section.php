<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use Modules\Cms\Models\Section as SectionModel;

/**
 * Section Component.
 *
 * Renders a reusable section of the site using the Section model.
 *
 * @property string      $slug The unique identifier for the section
 * @property string|null $view Custom view path for rendering
 * @property array       $data Additional data to pass to the view
 */
class Section extends Component
{
    public string $slug;

    public array $blocks = [];

    public ?string $name = null;

    public ?string $class = null;

    public ?string $id = null;

    public ?string $tpl = null;

    /**
     * Create a new component instance.
     *
     * @param string      $slug  Unique identifier for the section
     * @param string|null $class Additional CSS classes
     * @param string|null $id    Custom ID for the section
     */
    public function __construct(
        string $slug,
        ?string $class = null,
        ?string $id = null,
        ?string $tpl = null,
    ) {
        $this->slug = $slug;
        $this->class = $class;
        $this->id = $id;
        $this->tpl = $tpl;
        $this->blocks = SectionModel::getBlocksBySlug($this->slug);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): ViewContract
    {
        $view = 'pub_theme::components.sections.'.$this->slug;
        if ($this->tpl) {
            $view .= '.'.$this->tpl;
        }

        // Verifica che la view esista, con gestione più robusta per i namespace
        // Se la view usa un namespace (es. pub_theme::), verifica anche il file fisico
        if (! view()->exists($view)) {
            // Se la view usa un namespace, prova a verificare il file fisico direttamente
            if (str_contains($view, '::')) {
                [$namespace, $path] = explode('::', $view, 2);
                $viewFinder = view()->getFinder();
                if (method_exists($viewFinder, 'getHints')) {
                    /** @var array<string, array<int, string>|string> $hints */
                    $hints = $viewFinder->getHints();
                    if (isset($hints[$namespace])) {
                        /** @var array<int, string>|string $namespaceHint */
                        $namespaceHint = $hints[$namespace];
                        $namespacePath = is_array($namespaceHint) ? $namespaceHint[0] : $namespaceHint;
                        if (is_string($namespacePath)) {
                            $filePath = $namespacePath.'/'.str_replace('.', '/', $path).'.blade.php';
                            // Se il file esiste fisicamente, considera la view valida
                            // Questo risolve problemi di timing durante il bootstrap
                            if (file_exists($filePath)) {
                                // @phpstan-ignore-next-line - View è valida perché il file esiste fisicamente
                                return view($view);
                            }
                        }
                    }
                }
            }
            // Se arriviamo qui, la view non esiste
            throw new \Exception('View '.$view.' not found');
        }

        return view($view);
    }
}
