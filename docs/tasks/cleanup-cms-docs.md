---
title: "cleanup cms docs"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "cleanup cms docs"
issues: []
discussions: []
---

# Task: Cms Docs Consolidation & Cleanup

## 📋 Obiettivo
Sfoltire l'enorme documentazione del modulo Cms (320+ file), eliminando duplicati (es. file con suffisso `-1.md` o `_1.md`), file di report temporanei e indici obsoleti.

## 🚨 Problemi Identificati
- 320 file in root `docs/`.
- File duplicati prodotti da merge errati (es. `algolia-docsearch-1.md`).
- Riferimenti a percorsi inesistenti (`../Meetup/`).
- File di report `.txt` e `.jpg` sparsi nella documentazione.

## ✅ Checklist
- [ ] Rimuovere tutti i file con suffisso `-1.md`, `_1.md`.
- [ ] Archiviare file storici in `archive/`.
- [ ] Eliminare file `.txt` (es. `links.txt`, `filament-5-nested-resources.txt`) se non strettamente necessari.
- [ ] Consolidare le varie versioni della Roadmap nel `roadmap.md` principale.
- [ ] Aggiornare `00-index.md` rimuovendo riferimenti a Meetup.

## 🔗 Riferimenti
- [Roadmap Cms](../roadmap.md)
