<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/en/txt/fields/version.php
// Cms txt.fields.version — LangServiceProvider SSoT.
// claude-audit static: split fields.php (>500 LOC).
return [
    'label' => 'Versione',
    'placeholder' => '1.0.0, v2.1, beta',
    'helper_text' => 'Versione del contenuto o componente',
    'tooltip' => '',
    'description' => '',
];
