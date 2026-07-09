<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/de/section_fields.php
return merge_translation_files(__DIR__.'/section_fields_p01.php', __DIR__.'/section_fields_p02.php'
);
