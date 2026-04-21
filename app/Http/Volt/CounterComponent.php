<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt;

use Livewire\Volt\Component;

class CounterComponent extends Component
{
    public int $count = 0;

    public function increment(): void
    {
<<<<<<< HEAD
        ++$this->count;
||||||| 6161e129d
        $this->count++;
=======
        ++$count;
>>>>>>> feature/ralph-loop-implementation
    }

    public function decrement(): void
    {
<<<<<<< HEAD
        --$this->count;
||||||| 6161e129d
        $this->count--;
=======
        --$count;
>>>>>>> feature/ralph-loop-implementation
    }
}
