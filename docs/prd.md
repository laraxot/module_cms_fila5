# Cms - Product Requirements Document (PRD)

> Documento vivente. Modulo Content Management System.

## 1. Purpose & Vision

Il modulo **Cms** gestisce pagine e contenuti dinamici tramite Laravel Folio, Livewire Volt e blocchi JSON. È il cuore del front-office: nessuna pagina pubblica esiste senza passare dal Cms.

**Visione**: Pagine 100% CMS-driven — contenuti in JSON, rendering via blocchi, zero controller tradizionali.

## 2. Problem Statement

Senza Cms:
- Ogni pagina richiederebbe Blade hardcoded e route manuali
- Nessuna separazione tra contenuto e presentazione
- Impossibile gestire pagine da admin senza deploy

## 3. Target Users

| User | Ruolo | Bisogni |
|------|-------|---------|
| **Content editor** | Gestisce contenuti | Modificare pagine da Filament |
| **Sviluppatore** | Crea blocchi | Componenti blocchi riutilizzabili |
| **Admin** | Configurazione | PageResource, sezioni, header/footer |

## 4. Scope

### In Scope
- PageResource Filament per gestione pagine
- JSON content blocks (config/local/{tenant}/database/content/)
- Folio catch-all per route pubbliche
- Block components per hero, sezioni, footer
- Integrazione con modulo Lang per localizzazione

### Out of Scope
- E-commerce o carrello
- Blog con commenti
- Versioning avanzato contenuti (audit)

## 5. Functional Requirements (Prioritized)

### P0: Core
- **FR-001**: Pagine pubbliche via JSON + Folio
- **FR-002**: Admin Filament per gestione pagine e contenuti
- **FR-003**: Blocchi contenuto modulari (hero, block, section)
- **FR-004**: Localizzazione contenuti (locale in JSON)

### P1: Enhancement
- **FR-005**: Sezioni globali (header, footer)
- **FR-006**: Metatag e SEO per pagina

## 6. Non-Functional Requirements

- **NFR-001**: PHPStan Level 10
- **NFR-002**: Nessun controller tradizionale per front-office
- **NFR-003**: Contenuti JSON in config/local/{tenant}/

## 7. Technical Architecture

- **Dipendenze**: Xot, Lang, UI, Folio, Volt
- **Storage**: JSON in `config/local/{tenant}/database/content/pages/`
- **Rendering**: Folio + Volt, blocchi in `Themes/{Theme}/resources/views/components/blocks/`

## 8. Risks & Assumptions

- Assunzione: tutti i contenuti pubblici passano da JSON
- Rischio: JSON troppo grandi — valutare migrazione DB per contenuti

## 9. References

- [PRD Progetto](../../../../docs/prd.md)
- [Content Blocks System](./content-blocks-system.md)
- [Folio Routing](./folio-routing-locale.md)

## Testing & Coverage

Il modulo Cms segue la **Metodologia "Super Mucca" (Laraxot Zen)**:
- **XotBaseTestCase**: Tutti i test estendono `Modules\Xot\Tests\XotBaseTestCase`.
- **MySQL Only**: Test eseguiti contro MySQL (.env.testing).
- **No RefreshDatabase**: Utilizzo di `DatabaseTransactions`.
- **Obiettivo**: 100% di coverage. Se un test fallisce, va sistemato o eliminato se il sito è funzionale.

## Appendice: framing prodotto/marketing (merged da PRD.md, 2026-09-17)

`PRD.md` (maiuscolo) era una seconda bozza di PRD, piu' estesa (514 righe) ma generica/aspirazionale
(personas "Marketing Manager", metriche SaaS, drag-and-drop non presente nel codice attuale) e non
verificata contro questo repo specifico. Sintesi mantenuta per non perdere il framing di business,
da validare con il product owner prima di considerarla normativa:

- **Problem statement**: piattaforme moderne richiedono content management flessibile con page
  building visuale, architettura a componenti, integrazione con altri moduli (Media, Seo) — senza
  un modulo CMS dedicato, creare pagine richiede sempre intervento sviluppatore.
- **Value proposition**: abilitare utenti non tecnici a creare/gestire pagine in autonomia; time-to-market
  piu' rapido per campagne; branding coerente.
- **Personas indicative**: Marketing Manager (crea landing page per campagne), Content Editor,
  Developer (costruisce blocchi riutilizzabili).
- **Non-goals dichiarati in quella bozza**: gestione articoli blog (modulo Blog), pagine e-commerce
  (moduli commerce), applicazioni web complesse.
- **Nota**: metriche, OKR e persona "Marketing Manager" in stile SaaS generico non sono state
  verificate contro il dominio reale di questo repo (prenotazioni ristorante) — trattarle come bozza,
  non come requisiti approvati.

