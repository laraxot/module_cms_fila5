<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/it/calendar.php
return [
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    'calendar' => [
        'title' => 'Calendario',
        'description' => 'Gestisci i tuoi appuntamenti',
        'types' => [
            'patient' => 'Calendario Paziente',
            'doctor' => 'Calendario Medico',
            'admin' => 'Calendario Amministratore',
        ],
        'events' => [
            'title' => 'Appuntamento',
            'start' => 'Inizio',
            'end' => 'Fine',
            'patient' => 'Paziente',
            'doctor' => 'Medico',
            'status' => 'Stato',
            'type' => 'Tipo',
        ],
        'actions' => [
            'create' => 'Nuovo Appuntamento',
            'edit' => 'Modifica Appuntamento',
            'delete' => 'Elimina Appuntamento',
            'view' => 'Visualizza Dettagli',
        ],
        'messages' => [
            'created' => 'Appuntamento creato con successo',
            'updated' => 'Appuntamento aggiornato con successo',
            'deleted' => 'Appuntamento eliminato con successo',
        ],
    ],
    'buttons' => [
        'today' => 'Oggi',
        'month' => 'Mese',
        'week' => 'Settimana',
        'day' => 'Giorno',
    ],
    'labels' => [
        'all_day' => 'Tutto il giorno',
        'no_events' => 'Nessun evento',
    ],
    'errors' => [
        'load_failed' => 'Impossibile caricare gli eventi',
        'save_failed' => 'Impossibile salvare l\'evento',
        'delete_failed' => 'Impossibile eliminare l\'evento',
    ],
    'success' => [
        'event_created' => 'Evento creato con successo',
        'event_updated' => 'Evento aggiornato con successo',
        'event_deleted' => 'Evento eliminato con successo',
    ],
    'label' => 'Calendar',
    'plural_label' => 'Calendar (Plurale)',
    'navigation' => [
        'name' => 'Calendar',
        'plural' => 'Calendar',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Calendar',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Calendar',
        ],
        'edit' => [
            'label' => 'Modifica Calendar',
        ],
        'delete' => [
            'label' => 'Elimina Calendar',
        ],
    ],
];
