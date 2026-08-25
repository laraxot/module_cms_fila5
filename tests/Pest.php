<?php

declare(strict_types=1);

/*
 * |--------------------------------------------------------------------------
 * | Test Case
 * |--------------------------------------------------------------------------
 * |
 * | Il TestCase di default per tutti i test del modulo Cms.
 * | Ogni file di test dichiara esplicitamente uses(\Modules\Cms\Tests\TestCase::class),
 * | seguendo il pattern DRY comune a tutti i moduli (vedi Modules/Xot/tests/Pest.php).
 * | Nessun ->in() qui: e' un metodo interno al namespace Pest, non analizzabile
 * | da PHPStan al di fuori di esso (method.internalClass).
 * |
 */

/*
 * |--------------------------------------------------------------------------
 * | Expectations
 * |--------------------------------------------------------------------------
 * |
 * | Qui puoi definire aspettative globali per il modulo Cms.
 * | Quando definisci qui expectation globali, saranno disponibili
 * | in tutti i test del modulo.
 * |
 */

<<<<<<< .merge_file_1FM1FY
// `tests/PestHelpers.php` e' dichiarato in `autoload-dev.files` del composer.json del
// modulo: il `require_once` qui lo rendeva visibile solo a Pest, non all'autoload, quindi
// PHPStan leggeva le sue funzioni come inesistenti.
=======
require_once __DIR__.'/PestHelpers.php';
>>>>>>> .merge_file_AEIfXa
/*
 * |--------------------------------------------------------------------------
 * | Functions
 * |--------------------------------------------------------------------------
 * |
 * | Qui puoi definire funzioni helper globali per i test del modulo.
 * | Queste funzioni saranno disponibili in tutti i test.
 * |
 */

<<<<<<< .merge_file_1FM1FY
pest()->extend(Modules\Cms\Tests\TestCase::class)->in(__DIR__.'/Unit', __DIR__.'/Feature');
=======
<<<<<<< HEAD
pest()->extend(\Modules\Cms\Tests\TestCase::class)->in(__DIR__.'/Unit', __DIR__.'/Feature');
=======
pest()->extend(Modules\Cms\Tests\TestCase::class)->in(__DIR__.'/Unit', __DIR__.'/Feature');
>>>>>>> laraxot/dev
>>>>>>> .merge_file_AEIfXa
