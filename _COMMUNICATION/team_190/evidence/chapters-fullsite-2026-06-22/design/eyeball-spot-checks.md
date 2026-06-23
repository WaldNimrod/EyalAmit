# team_190 — Eyeball spot-checks (verbatim) — Chapters full-site — 2026-06-22

Validator engine: GPT-5.2 (team_190)

Staging base: `http://eyalamit-co-il-2026.s887.upress.link`

These are **manual, browser-rendered** spot-checks to complement the deterministic `content-diff.mjs` run.

## 1) `/treatment/` vs source `טיפול בדיג'רידו/treatment.md`
- **Source snippet**: `ובדיוק שם מתחילה העבודה.`
- **Live (browser snapshot)**: present on `/treatment/` (see `snapshot_treatment_a11y.log`).
- **Screenshot**: `eyeball_treatment_full.png`

## 2) `/books/vekatavta/` vs source `וכתבת/vekatavta.md`
- **Source snippet**: `ייחודי במיוחד לוכתבת הוא גם האלמנט של סריקת ה-QR:`
- **Live (browser snapshot)**: present on `/books/vekatavta/` (see snapshot output captured during navigation).
- **Screenshot**: `eyeball_vekatavta_full.png`

## 3) `/eyal-amit/mokesh-dahiman/` vs DOCX source (Mokesh memorial)
- **Source snippet** (from DOCX paragraph extraction): `יום אחד, בתחילת שנות השבעים, הגיע למלון בו מוקש ואבא שלו עבדו, תייר אוסטרלי חביב...`
- **Live (browser snapshot)**: present on `/eyal-amit/mokesh-dahiman/` (see `snapshot_mokesh_a11y.log`).
- **Screenshot**: `eyeball_mokesh_full.png`

