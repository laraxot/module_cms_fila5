<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from txt.php for maintainability (<500 LOC).
// Canon: Modules/Cms/docs/wiki/concepts/claude-audit-static.md
// File: lang/en/txt_sections.php
return array (
  'sections' => 
  array (
    'content' => 
    array (
      'label' => 'Contenuto',
      'description' => 'Gestione del contenuto principale',
    ),
    'media' => 
    array (
      'label' => 'Media',
      'description' => 'Immagini, video e contenuti multimediali',
    ),
    'design' => 
    array (
      'label' => 'Design',
      'description' => 'Aspetto visivo e layout',
    ),
    'navigation' => 
    array (
      'label' => 'Navigazione',
      'description' => 'Menu, link e struttura di navigazione',
    ),
    'company' => 
    array (
      'label' => 'Azienda',
      'description' => 'Informazioni aziendali e contatti',
    ),
    'social' => 
    array (
      'label' => 'Social Media',
      'description' => 'Profili e collegamenti social',
    ),
    'cta' => 
    array (
      'label' => 'Call-to-Action',
      'description' => 'Pulsanti e inviti all\'azione',
    ),
    'structure' => 
    array (
      'label' => 'Struttura',
      'description' => 'Layout e organizzazione della pagina',
    ),
    'advanced' => 
    array (
      'label' => 'Avanzato',
      'description' => 'Impostazioni tecniche e personalizzazioni',
    ),
  ),
);
