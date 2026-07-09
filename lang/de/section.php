<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from section.php for maintainability (<500 LOC).
// Canon: Modules/Cms/docs/wiki/concepts/claude-audit-static.md
// File: lang/de/section_loader.php
return merge_translation_files(__DIR__.'/section_navigation.php', __DIR__.'/section_fields.php', __DIR__.'/section_model.php', __DIR__.'/section_actions.php', __DIR__.'/section_messages.php', __DIR__.'/section_label.php', __DIR__.'/section_plural_label.php'
);
