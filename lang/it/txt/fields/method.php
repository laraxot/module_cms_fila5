<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/it/txt/fields/method.php
// Cms txt.fields.method — LangServiceProvider SSoT.
// claude-audit static: split fields.php (>500 LOC).
return [
    'label' => 'Metodo',
    'placeholder' => 'GET, POST, PUT, DELETE',
    'helper_text' => 'Metodo HTTP per form o richieste API',
    'tooltip' => '',
    'description' => '',
];
