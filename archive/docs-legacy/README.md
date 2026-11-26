# archive/docs-legacy

Archivio della documentazione storica del modulo Cms, spostata da `docs/`
durante la consolidazione del 2026-10 (issue laraxot/module_cms_fila5#63,
obiettivo: `docs/` <= 100 file `.md`).

## Contenuto

- `docs/` - snapshot integrale della precedente struttura `docs/` (radice,
  `wiki/`, `components/`, `sections/`, `blocks/`, `roadmap/`, `stories/`,
  `frontoffice/`, `bmad/`, `tests/`, `raw/`, `screenshots/` ecc.), inclusi
  file non-markdown che vivevano in `docs/`.

## Perche' e' qui

- `docs/` deve restare entro 100 file `.md` ricorsivi: restano solo indice,
  ADR, contratti, story attive e guide correnti (vedi `docs/00-INDEX.md`).
- Il materiale archiviato comprende: report di audit e PHPStan datati, vecchie
  roadmap e sprint, cataloghi di riferimento UI per-componente
  (`components/`, `sections/`, `blocks/` bulk), duplicati di case e
  underscore, varianti `-1`/`-old`/`-renamed`/date, file `.mdc`, `.lock` e
  allegati `.html`/`.jpg`.
- I link interni dei documenti mantenuti in `docs/` sono stati riscritti per
  puntare qui quando il destinatario e' stato archiviato.

## Regole

- Archivio in sola lettura: non modificare i file qui dentro.
- Se serve riusare un contenuto, copiarlo in `docs/` (o consolidarlo in un
  documento corrente) invece di linkare l'archivio come fonte primaria.
- Nessun documento nuovo va creato in `docs/` fuori dai percorsi consentiti
  (`adr/`, `contracts/`, `stories/` attive, guide tematiche indicizzate in
  `docs/00-INDEX.md`).
