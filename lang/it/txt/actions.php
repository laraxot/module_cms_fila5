<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/it/txt/actions.php
return array (
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
);
