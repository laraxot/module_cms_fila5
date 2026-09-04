<?php

declare(strict_types=1);

use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;

return [
    'adm_theme' => 'AdminLTE',
    'enable_ads' => false,
    'model' => [
        'profile' => Profile::class,
        'user' => User::class,
    ],
];
