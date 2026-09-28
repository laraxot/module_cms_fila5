---
title: "cms filament v5"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "cms filament v5"
issues: []
discussions: []
---

# Task: Cms Filament v5 Alignment (Clusters & Nesting)

## 📋 Obiettivo
Modernizzare l'interfaccia di gestione contenuti sfruttando le funzionalità native di Filament v5, in particolare i Clusters e le Nested Resources.

## 🏗️ Struttura Proposta
- **ContentCluster**: 
    - **PageResource**: Gestione pagine.
        - **Blocks**: Nested Resource (sostituisce il Repeater semplice dove necessario).
        - **Metatags**: Nested Resource.
- **DesignCluster**:
    - **AppearanceResource**: Temi e stili.
    - **MenuResource**: Gestione navigazione.

## ✅ Checklist
- [ ] Definizione dei Cluster in `app/Filament/Clusters/`.
- [ ] Implementazione di `Block` come Nested Resource di `Page` per gestire contenuti molto complessi.
- [ ] Migrazione delle icone a Lucide (Filament v5 standard).
- [ ] Ottimizzazione del caricamento dei media nei blocchi tramite i nuovi componenti v5.

## 🔗 Riferimenti
- [Roadmap Cms](../roadmap.md)
- [Filament Nesting Opportunities](../filament-nesting-opportunities.md)
