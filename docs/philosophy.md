# Cms Module: Content Management Philosophy

> **Block-Based Page Builder** — Custom Filament Builder integration. Zero external deps (Xot, UI, Tenant only).

---

## Zen

**"Content is blocks. Blocks are registered by UI. Cms orchestrates them."**

---

## Architecture

### Core Pattern

```
UI Module (defines block types)
  ↓
UI::GetAllBlocksAction (discover ComponentFileData blocks)
  ↓
Cms::PageContentBuilder (wraps Filament\Forms\Components\Builder)
  ↓
PageContent model (stores block[] data JSON)
  ↓
PageContentResource (edit UI)
```

### Models (12)

- **PageContent** — Page with blocks array (JSON)
- **Block** — Metadata only (blocks live in blocks array)
- **Attachment** — Polymorphic media

### Filament Pattern

**PageContentResource** extends **LangBaseResource** (i18n support)
- Custom form: `PageContentBuilder::make('blocks')`
- `Builder::blocks([...])` — Filament native component (NOT Fabricator)
- Each block registered by UI module as ComponentFileData
- Block schema + validation built into each block class

### Actions (8)

- `BuildPageSchemaAction` — Merge block schemas
- `ResolveBlockQueryAction` — Execute block queries (e.g., latest posts)
- `GetViewThemeByViewAction` — Resolve template path
- Utilities for rendering, schema validation

### Integrations

**UI Module** (critical):
- UI defines all block types
- UI::GetAllBlocksAction discovers blocks
- Cms loads blocks dynamically (no hardcoding)
- Blocks implement Filament\Forms\Components\Builder\Block interface

**Lang Module**:
- PageContentResource extends LangBaseResource (translatable pages)

**Xot, Tenant**:
- BaseModel, tenant scoping

---

## Dependencies

| Dep | Version | Use |
|-----|---------|-----|
| **(None)** | — | Zero external packages |
| Xot | Path | Base classes |
| UI | Path | Block discovery |
| Tenant | Path | Scoping |

**Design Decision**: No Filament Fabricator. Custom PageContentBuilder wrapper provides:
- Dynamic block registration (via UI)
- Schema-driven validation (per-block)
- JSON persistence (blocks array)
- Full control over render logic

---

## Best/Bad Practices

✓ **Block registration via UI**
```php
// UI module registers blocks
GetAllBlocksAction::execute() → discovers all Block\*.php
```

✓ **Schema-driven per block**
```php
// Each block class defines getFormSchema()
Block::make('name')->schema([...])
```

✓ **PageContent is dumb** (stores blocks[], doesn't interpret)

❌ **Hardcoding block types** (violates extensibility)
❌ **Block logic in PageContent** (violates separation)
❌ **External page builder** (Fabricator dependency unwanted here)

---

## Roadmap

- Block versioning (migrate old blocks)
- Block templates (layouts)
- A/B testing block variants
- SEO fields per block
- Block-level revisions (history)

---

## Summary

```
┌──────────────────────────────┐
│ Cms (Block Page Builder)     │
├──────────────────────────────┤
│ Pattern: Custom Builder      │
│ Models: 12                   │
│ Actions: 8                   │
│ External deps: 0             │
│ Block discovery: UI::Action  │
│ Status: Stable               │
└──────────────────────────────┘
```

---

- **Generated**: 2026-09-06 (verified + revised)
- **Author**: Claude (code-verified)
