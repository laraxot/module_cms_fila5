---
status: accepted
module: Cms
---

# CMS e Folio risolvono le pagine tramite slug

## Contesto

Il front office usa pagine Folio sottili e blocchi configurati nei contenuti CMS.

## Decisione

CMS possiede risoluzione dello slug, contenuto e middleware pagina; il tema fornisce shell e viste dei blocchi senza creare alias semantici.

## Driver della decisione

- Evitare duplicazioni tra CMS, Folio e temi.

## Alternative scartate

- Duplicare ogni pagina CMS in una view del tema.
- Spostare il routing applicativo nei componenti visuali.

## Conseguenze

La stessa struttura è riusabile tra temi; gli slug e la configurazione tenant diventano parte del contratto di pagina.

## Conferma

Verificare middleware, resolver CMS e test Folio prima di aggiungere una nuova pagina.
