---
title: "PHPStan Fix Plan - Cms Module"
type: note
status: draft
created: 2026-10-20
updated: 2026-10-20
module: Cms
tags: [docs, cms, phpstan-fix-plan]
---

# PHPStan Fix Plan - Cms Module
Scopo: correggere errori PHPStan nei test Cms (FilamentBuilderBlocksTest.php e altri) mantenendo lo scopo del test (scoperta blocchi Filament, verifica classi esistenti, verifica chiavi array).
Approccio: swarm parallel, subagent per modulo, BMAD per ogni batch.
Scopo degli errori: i test devono verificare il comportamento reale del sistema (blocchi Filament, gestione utenti, notifiche).
