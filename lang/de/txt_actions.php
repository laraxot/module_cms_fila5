<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from txt.php for maintainability (<500 LOC).
// Canon: Modules/Cms/docs/wiki/concepts/claude-audit-static.md
// File: lang/de/txt_actions.php
return array (
  'actions' => 
  array (
    'save' => 
    array (
      'label' => 'Salva',
      'success' => 'Contenuto salvato con successo',
      'error' => 'Errore durante il salvataggio del contenuto',
      'confirmation' => 'Vuoi salvare le modifiche apportate?',
    ),
    'cancel' => 
    array (
      'label' => 'Annulla',
      'confirmation' => 'Sei sicuro di voler annullare? Tutte le modifiche non salvate andranno perse.',
    ),
    'activeLocale' => 
    array (
      'label' => 'Lingua Attiva',
      'description' => 'Seleziona la lingua per la traduzione del contenuto',
      'help' => 'Modifica la lingua di editing per contenuti multilingua',
    ),
  ),
);
