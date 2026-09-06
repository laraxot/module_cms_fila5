# Cms Module: Content Management

> **Page & Block Management** — Flexible content builder, multilingual blocks, schema-driven.

---

## Zen

**"Content is data. Pages are grids of blocks. Blocks are reusable."**

---

## Quick

### Models (12)
- **Page** — Content page (slug, title, blocks)
- **Block** — Reusable content unit (type, data, template)
- **Attachment** — Media file (polymorphic)

### Pattern
```
Page
  └─ Block[] (position, type, data)
       └─ Block.data (schema-driven, validated)
```

### Actions (8)
- `BuildPageSchemaAction` — Merge block schemas into page schema
- `ResolveBlockQueryAction` — Execute block query (e.g., latest posts)
- `GetViewThemeByViewAction` — Resolve template

### Forms (1)
- `DownloadAttachmentPlaceHolder` — File download

---

## Best/Bad

✓ Block reusability (no copy-paste)
✓ Schema validation per block type
❌ Storing unresolved data (resolve at render time)

---

## Roadmap

- Block versioning
- Scheduled publish/unpublish
- A/B testing blocks

---

```
┌──────────────────────┐
│ Cms (Content Mgmt)   │
├──────────────────────┤
│ Models: 12           │
│ Migrations: 3        │
│ Status: Stable       │
└──────────────────────┘
```

---

- **Generated**: 2026-09-06

