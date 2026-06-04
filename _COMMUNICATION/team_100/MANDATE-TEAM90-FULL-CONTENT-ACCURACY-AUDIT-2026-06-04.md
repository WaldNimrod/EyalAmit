---
id: MANDATE-TEAM90-FULL-CONTENT-ACCURACY-AUDIT-2026-06-04
from_team: team_100 (Chief System Architect)
to_team: team_90 (Default Validator — Control & Research)
date: 2026-06-04
type: AUDIT_MANDATE
scope: FULL-SITE content-accuracy — every page's live text vs Eyal's source
staging: http://eyalamit-co-il-2026.s887.upress.link
status: ISSUED
---

# Mandate — Full-site content-accuracy audit (team_90)

## 0. Why
Eyal found many texts are invented (not what he supplied). The sample audit (`CONTENT-INTEGRITY-AUDIT-2026-06-04.md`) showed e.g. `/method` 0%, `/muzza` 0%, services ~25%. team_00 needs an **exhaustive, page-by-page accuracy measurement** before/while WP-W2-15 reconciles content: **what % of each page's content matches Eyal's source, and the overall % across the site.**

## 1. Identity & rules
- You are **team_90** (Default Validator / Control & Research). **Independent measurement** — quantify, don't fix; no code/content edits, no merge/deploy.
- Output **only** under `_COMMUNICATION/team_90/`.
- Dev/staging is HTTP by design; measure the **rendered** page text (not curl-only where layout matters, though for text extraction HTTP HTML is fine).

## 2. Canonical source (SSoT)
`docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/` (latest, 2026-05-25) — map in `INDEX-CONTENT-2026-05-25.md`. Pages ↔ source files:

| Page (live) | Source file |
|---|---|
| `/` | `דף הבית/homepage1-3 v2.md` |
| `/method` | `השיטה/method.md` |
| `/treatment` | `טיפול בדיג'רידו/treatment.md` |
| `/sound-healing` | `סאונדהילינג/sound_healing_final.md` |
| `/lessons` | `שיעורי נגינה/lesons.md` |
| `/faq` | `דף FAQ/FAQ FINAL.md` |
| `/muzza` | `מוזה הוצאה לאור - ספרים/MUZZA.md` |
| `/eyal-amit` (About) | `אודות - אייל עמית/אודות - אייל עמית.md` |
| book detail: tsva / kushi / vekatavt | `צבע בכחול וזרוק לים/eyal_tsva_FINAL.md` · `כושי בלאנטיס/kushi_full.md` · `וכתבת/vekatavta.md` |
| shop: didgeridoos / bags / stands-storage / stand-floor / repair | `כלים למכירה/buy didgeridoo.md` · `תיקים לדיגרידו/bags for didg.md` · `סטנדים לדיגרידו לאחסון/stend for hanging.md` · `סטנד רצפתי…/stend for playing.md` · `תיקון כלי דיגרידו/build didg.md` |
| `/mokesh-dahiman` (memorial) | `מוקש דהימן/ומה היום.docx` (NB: classified as *background*, not page copy — flag, still measure) |
| `/galleries`, `/media` | **no Eyal source** (mockup catalog) → report as N/A (no-source) |

Verify this map; add any page with a source I missed.

## 3. Method — per-page accuracy (deterministic, reproducible)
For each page:
1. **Parse the source** `.md`/`.docx` → ordered list of (a) **section titles** (`# SECTION …` / headings, strip the "SECTION NN –" prefix), and (b) **content sentences** ≥40 Hebrew chars (exclude DEV NOTES, CTA boilerplate).
2. **Fetch the live page**, strip `<script>/<style>/tags`, unescape entities, normalise (collapse whitespace; unify geresh `׳`↔`'`, quotes; strip markdown link syntax).
3. Compute:
   - **Section-coverage %** = (# source section titles found in live) / (total source sections).
   - **Sentence-coverage %** = (# source sentences present verbatim, normalised) / (total source sentences).
   - **Page accuracy %** = weighted mean (suggest 0.5·section + 0.5·sentence; state your formula).
4. Record **missing sections** (Eyal sections absent on live) and **invented blocks** (substantial live prose with no source match) per page.

Build/extend a small script (e.g. `scripts/qa/content-diff.mjs` / a Python equivalent) so the run is reproducible; commit it under `_COMMUNICATION/team_90/evidence/` (or scripts/qa with a note). State the exact normalisation + thresholds used.

## 4. Deliverable — accuracy report
`_COMMUNICATION/team_90/CONTENT-ACCURACY-REPORT-2026-06-04.md`:
- **§0 Overall accuracy** — single headline number (site-wide), both **unweighted page-mean** and **content-weighted** (by source length); state method.
- **§1 Per-page table** — `page · source file · section-cov % · sentence-cov % · accuracy % · verdict (ACCURATE ≥90 / PARTIAL 40–89 / INVENTED <40 / N/A no-source) · # missing sections`.
- **§2 Worst offenders** — ranked; the missing-sections list per page (actionable for WP-W2-15 reconciliation).
- **§3 No-source pages** — galleries/media/memorial-background flagged.
- **§4 Method + reproducibility** — script path, normalisation, formula, thresholds; evidence JSON under `_COMMUNICATION/team_90/evidence/content-accuracy-2026-06-04/`.
- **§5 Verdict box** at top: overall % + count of pages <90%.

## 5. Notes
- This **corroborates/expands** team_100's sample audit (`CONTENT-INTEGRITY-AUDIT-2026-06-04.md`) — verify it independently; correct any number.
- Cross-engine not required (this is measurement, not a constitutional gate) — but be independent and reproducible.
- Coordinate numbers with the WP-W2-15 CONTENT-ACCURACY gate (program plan F04) so the reconciliation's "after" can be measured the same way.

*team_100 — 2026-06-04 — quantify the content gap, every page.*
