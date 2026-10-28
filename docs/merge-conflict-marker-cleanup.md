---
title: "merge conflict marker cleanup"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "merge conflict marker cleanup"
issues: []
discussions: []
status: draft
---

# Merge Conflict Marker Cleanup

> Updated: 2026-04-21

## Current Rule

Cms runtime files with conflict markers must be resolved before running broad quality gates because Filament discovery and model autoloading load them during `php artisan` bootstrap.

## Decisions Applied

- `Home.php`: kept the simple valid `initView()` flow and discarded placeholder fragments that contained invalid pseudo-code.
- `PageContent.php` and `Attachment.php`: kept the `getSushiRows()` docblock method reference and removed only conflict markers.
- `HasBlocks.php`: restored dynamic property access through `$this->{$field}` and kept the already constructed `BlockData` return path.
- `Page.php`: removed docblock conflict markers while preserving method annotations.

## Verification

Run targeted checks after touching Cms PHP files:

```bash
php -l Modules/Cms/app/Filament/Front/Pages/Home.php
php -l Modules/Cms/app/Models/PageContent.php
php -l Modules/Cms/app/Models/Attachment.php
```

