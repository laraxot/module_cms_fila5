<?php

declare(strict_types=1);

namespace Modules\Cms\Enums;

use Modules\Xot\Traits\EnumTrait;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AttachmentDiskEnum: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case public_html = 'public_html';
    case videos = 'videos';
    case local = 'local';

    

    

    

    
}
