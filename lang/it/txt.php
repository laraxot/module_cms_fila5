<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from txt.php for maintainability (<500 LOC).
// Canon: Modules/Cms/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/txt_loader.php
return merge_translation_files(__DIR__.'/txt_fields.php', __DIR__.'/txt_actions.php', __DIR__.'/txt_sections.php', __DIR__.'/txt_messages.php', __DIR__.'/txt_validation.php', __DIR__.'/txt_label.php', __DIR__.'/txt_plural_label.php', __DIR__.'/txt_navigation.php'
);
