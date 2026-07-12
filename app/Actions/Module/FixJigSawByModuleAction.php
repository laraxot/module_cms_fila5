<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Module;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\FixPathAction;
use Nwidart\Modules\Laravel\Module;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\Finder\SplFileInfo;

final class FixJigSawByModuleAction
{
    use QueueableAction;

    /**
     * @return list<string>
     */
    public function execute(Module $module): array
    {
        $res = [];
        $stubsDir = \Safe\realpath(__DIR__.'/../../Console/Commands/stubs/docs');
        // if ($stubsDir === false) {
        //    throw new Exception('['.__LINE__.']['.__FILE__.']');
        // }

        $stubs = File::allFiles($stubsDir);
        foreach ($stubs as $stub) {
            if (! $stub->isFile()) {
                continue;
            }

            if ($stub->getExtension() !== 'stub') {
                continue;
            }

            $res[] = $this->publishStub($stub, $module);
        }

        return $res;
    }

    private function publishStub(SplFileInfo $stub, Module $module): string
    {
        $filename = str_replace('.stub', '', $stub->getRelativePathname());
        $filePath = $module->getPath().'/docs/'.$filename;
        $filePath = app(FixPathAction::class)->execute($filePath);
        /*
         * //mkdir(): Permission denied
         * if (! is_dir(dirname($filePath))) {
         * (new Filesystem())->makeDirectory(dirname($filePath));
         * }
         */

        $replace = [
            'ModuleName' => $module->getName(),
        ];

        $fileContent = str_replace(array_keys($replace), array_values($replace), $stub->getContents());
        File::put($filePath, $fileContent);

        return $filePath;
    }
}
