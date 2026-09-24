<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/en/txt/fields/alignment.php
// Cms txt.fields.alignment — LangServiceProvider SSoT.
// claude-audit static: split fields.php (>500 LOC).
return [
    'label' => 'Allineamento',
    'help' => 'Allineamento del testo',
    'options' => [
        'left' => 'Sinistra',
        'center' => 'Centro',
        'right' => 'Destra',
        'justify' => 'Giustificato',
    ],
    'placeholder' => 'Sinistra, Centro, Destra',
    'helper_text' => 'Allineamento del contenuto all\'interno dell\'elemento',
    'tooltip' => '',
    'description' => '',
];
