# Roadmap - Modulo CMS

## Scopo
Gestione contenuti modulare (sezioni, blocchi, pagine) per frontoffice e backoffice con Filament v4, pieno supporto a traduzioni, performance e UX.

## Obiettivi
- **Content Model chiaro**: sezioni e blocchi con data shape documentata.
- **Editor UX**: esperienze Filament ottimizzate, anteprima, validazioni.
- **Performance**: caching per sezioni/blocchi, hydration lazy.
- **Traduzioni**: chiavi strutturate per campi/azioni, no label()/placeholder() nel codice.

## Architettura
- Blocchi come value objects/DTO (Spatie Data) con renderer Blade/Components.
- Storage contenuti in JSON (config/local/...) con sincronizzazione su DB dove necessario.
- Integrazione temi: namespacing coerente per viste e componenti.

## Piano di Lavoro
### Fase 1 – Fondamenta
- [ ] Mappare tutti i tipi di blocchi esistenti con schema dei dati (docs/blocks/*.md)
- [ ] Definire interfacce per renderer dei blocchi (contratti Xot)
- [ ] Creare cache layer (per sezione, per pagina)

### Fase 2 – Backoffice Filament
- [ ] Adeguare Resources a XotBaseResource e pagine a XotBasePage
- [ ] Moduli di editing con anteprima e validazioni schema-driven
- [ ] Policy di accesso per tenant/ruolo

### Fase 3 – Frontoffice
- [ ] Uniformare namespace componenti e viste tema (docs: namespace_* files)
- [ ] Pipeline assets e immagini responsive per blocchi media
- [ ] Strategie di indicizzazione SEO per pagine dinamiche

### Fase 4 – Internazionalizzazione
- [ ] Strutturare chiavi i18n per campi/azioni: `cms::resource.fields.*`
- [ ] Copertura di traduzione per blocchi core + fallback

## Collegamenti
- Business logic CMS: `./business-logic-overview.md`
- Filament integrazione v4: `./filament_integration.md`
- Strategie contenuti: `./content_management.md`

## Note di Qualità
- PHPStan Livello 9 obbligatorio
- Vietato estendere classi Filament direttamente (usare XotBase*)
- Aggiornare questa roadmap a ogni milestone completata
