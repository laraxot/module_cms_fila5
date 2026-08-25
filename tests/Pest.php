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

// `tests/PestHelpers.php` e' dichiarato in `autoload-dev.files` del composer.json del
// modulo: il `require_once` qui lo rendeva visibile solo a Pest, non all'autoload, quindi
// PHPStan leggeva le sue funzioni come inesistenti.
/*
 * |--------------------------------------------------------------------------
 * | Functions
 * |--------------------------------------------------------------------------
 * |
 * | Qui puoi definire funzioni helper globali per i test del modulo.
 * | Queste funzioni saranno disponibili in tutti i test.
 * |
 */

pest()->extend(Modules\Cms\Tests\TestCase::class)->in(__DIR__.'/Unit', __DIR__.'/Feature');
