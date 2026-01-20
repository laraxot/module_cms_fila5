<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Illuminate\Support\Arr;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;

class BlockData extends Data implements Wireable
{
    use WireableData;

    public string $type;

    public array $data;

    public string $view;

    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
        Assert::string($view = Arr::get($data, 'view', 'ui::empty'), '['.__LINE__.']['.__FILE__.']');

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
                                $this->view = $view;

                                return;
                            }
                        }
                    }
                }
            }
            // Se arriviamo qui, la view non esiste
            throw new \Exception('view not found: '.$view);
        }

        $this->view = $view;
    }
}
