---
<<<<<<< .merge_file_PZeywt
title: "best practices"
=======
title: "Best Practices"
>>>>>>> .merge_file_rX0Usq
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
<<<<<<< .merge_file_PZeywt
qmd: "best practices"
=======
qmd: "Best Practices"
>>>>>>> .merge_file_rX0Usq
issues: []
discussions: []
---

# Best Practices – Cms

## Principi DRY/KISS
- **DRY**: Centralizza parsing pagine in `CmsService`. Usa cache per output renderizzato.
- **KISS**: Mantieni template semplici; evita logica complessa nelle view.
- **Clean Code**: Segui struttura `Model -> Repository -> Controller`.

## Componenti
- Usa `PageRepository` per query ricorrenti.
- Usa `BlockRenderer` per componenti modulari.

## Test
- Testa endpoint CMS con snapshot testing.
- Copri edge case per permessi pagina (draft vs published).

## Documentazione
<<<<<<< .merge_file_PZeywt
- Aggiorna `docs/INDEX.md` con nuovi blocchi disponibili.
=======
- Aggiorna `docs/index.md` con nuovi blocchi disponibili.
>>>>>>> .merge_file_rX0Usq
- Documenta flusso approvazione contenuti.
