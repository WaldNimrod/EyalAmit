# Gate CONTENT-ACCURACY — team_90 CR-FINAL | Run 2026-06-05

## Context bundle

- **Work Package:** WP-W2-15-CR-FINAL (leg 1 of 3 — team_90 full-site re-audit)
- **Domain:** EyalAmit.co.il-2026 (WordPress staging, branch `main`)
- **Write to:** `_COMMUNICATION/team_90/`
- **Mandate:** `_COMMUNICATION/team_90/MANDATE_WP-W2-15-CR-FINAL_FULL-AUDIT_v1.0.0.md`
- **Predecessor baseline:** `_COMMUNICATION/team_90/CONTENT-ACCURACY-REPORT-2026-06-04.md` (0/17 PASS · 33.64% simple)
- **Dual-PASS merge:** CR1–CR4 merged `main` @ `d267b15` (team_50 + team_190); post-merge spelling @ `2c202fa`
- **Staging:** http://eyalamit-co-il-2026.s887.upress.link
- **SSoT:** `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/`
- **Measured @:** 2026-06-05T20:06:50Z · repo `main` @ `9c48714` (includes CR-FINAL mandate commit; CR1–4 content @ `d267b15`+)

---

## §0 — Verdict box

| שדה | ערך |
|-----|-----|
| **Gate** | CR-FINAL_FULL-SITE-CONTENT-ACCURACY (team_90 leg 1/3) |
| **Verdict** | **PASS** — כל 16 עמודי CR1–CR4 עם מקור עומדים ב־F04 gate |
| **CR-FINAL team_90 leg** | **PASS** |
| **דיוק כללי (ממוצע עמודים)** | **96.51%** (היה 33.64% ב־2026-06-04) |
| **דיוק כללי (משוקלל לפי אורך מקור)** | **98.21%** (היה 32.00%) |
| **עמודים &lt;90% accuracy** | **1** — `/mokesh-dahiman` בלבד (**CR5, out of scope**) |
| **Gate F04 (≥95% sections + ≥90% sentences + 0 invented sections)** | **16 / 16 in-scope PASS** |
| **Gate-tool ratification** | **RATIFY-WITH-FINDINGS** — team_90 co-signs team_190 opinion (§4) |
| **Next step** | Route to **team_100** → activate **team_190** CR-FINAL full-site + **team_50** E2E (legs 2–3) |

**מסקנה אחת:** CR1–CR4 content reconciliation **מאומת** על live staging. אין חסמים ב־leg זה. HARD RULE נשאר: אין "ready" ל־team_00/Eyal עד **triple-PASS** (team_90 ✓ + team_190 + team_50 E2E).

---

## §1 — טבלת עמודים (CR-FINAL re-audit)

נוסחת **accuracy%** (F04):  
`pageAccuracy% = 0.4 × sectionCoverage% + 0.6 × sentenceCoverage%`

| page | source | section% | sentence% | accuracy% | verdict | gate | missing § |
|------|--------|----------|-----------|-----------|---------|------|-----------|
| `/` | `דף הבית/homepage1-3 v2.md` | 100 | 100 | **100.00** | ACCURATE | **PASS** | 0 |
| `/method/` | `השיטה/method.md` | 100 | 100 | **100.00** | ACCURATE | **PASS** | 0 |
| `/treatment/` | `טיפול…/treatment.md` | 100 | 100 | **100.00** | ACCURATE | **PASS** | 0 |
| `/sound-healing/` | `סאונדהילינג/sound_healing_final.md` | 100 | **100** | **100.00** | ACCURATE | **PASS** | 0 |
| `/lessons/` | `שיעורי נגינה/lesons.md` | 100 | 100 | **100.00** | ACCURATE | **PASS** | 0 |
| `/faq/` | `דף FAQ/FAQ FINAL.md` | 100 | **100** | **100.00** | ACCURATE | **PASS** | 0 |
| `/muzza` → `/books/` | `מוזה…/MUZZA.md` | 100 | 100 | **100.00** | ACCURATE | **PASS** | 0 |
| `/eyal-amit` → `/about/` | `אודות…/אודות - אייל עמית.md` | 100 | 100 | **100.00** | ACCURATE | **PASS** | 0 |
| `/books/vekatavta/` | `וכתבת/vekatavta.md` | 100 | 98.28 | **98.97** | ACCURATE | **PASS** | 0 |
| `/books/kushi-blantis/` | `כושי בלאנטיס/kushi_full.md` | 100 | 95.24 | **97.14** | ACCURATE | **PASS** | 0 |
| `/books/tsva-bekahol/` | `צבע בכחול…/eyal_tsva_FINAL.md` | 100 | 96.67 | **98.00** | ACCURATE | **PASS** | 0 |
| `/didgeridoos/` | `כלים למכירה/buy didgeridoo.md` | 100 | 100 | **100.00** | ACCURATE | **PASS** | 0 |
| `/bags/` | `תיקים…/bags for didg.md` | 100 | 100 | **100.00** | ACCURATE | **PASS** | 0 |
| `/stands-storage/` | `סטנדים…/stend for hanging.md` | 100 | 92.86 | **95.71** | ACCURATE | **PASS** | 0 |
| `/stand-floor/` | `סטנד רצפתי…/stend for playing.md` | 100 | 100 | **100.00** | ACCURATE | **PASS** | 0 |
| `/repair/` | `תיקון…/build didg.md` | 100 | 100 | **100.00** | ACCURATE | **PASS** | 0 |
| `/mokesh-dahiman` → `/about/moksha/` | `מוקש דהימן/ומה היום.docx` | 100 | 18.18 | 50.91 | PARTIAL | **FAIL** | 0 — **CR5** |
| `/galleries/` | — | — | — | — | **N/A** | — | CR5 |
| `/media/` | — | — | — | — | **N/A** | — | CR5 |

**ספי gate F04:** PASS = section ≥95% **ו** sentence ≥90% **ו** 0 invented sections (H2/H3 חיות שלא במקור).

**השוואה לבסיס 2026-06-04:** 0/17 PASS → **16/16 in-scope PASS**; ממוצע אתר 33.64% → **96.51%**.

---

## §2 — Post-QA fixes verification (mandate task 3)

| Fix | Expected | team_90 verification | Status |
|-----|----------|----------------------|--------|
| `/sound-healing/` sentence coverage | **100%** (steps.intro pass-through) | `summary.json`: 100% sentence · 0 missing | **CONFIRMED** |
| `/faq/` sentence coverage | **100%** (space-before-punct normalization) | `summary.json`: 100% sentence · 0 missing | **CONFIRMED** |
| `/muzza/` canonical redirect | **301** → `/books/` | `curl -sI /muzza/` → `301` · `Location: …/books/` | **CONFIRMED** |
| Muzza book links | `/books/<slug>` not `/muzeh/…` | Live `/books/` HTML: 7× `/books/` links · **0** `muzeh` | **CONFIRMED** |
| `hikikomori` spelling | **היקיקומורי** in render + source | Source `vekatavta.md`: 0× `היקוקומורי`/`היקוקמורי`; live `/books/vekatavta/`: 6× `היקיקומורי`, 0 old variants; merge `2c202fa` | **CONFIRMED** |

---

## §3 — Baseline delta (2026-06-04 → CR-FINAL)

| Metric | 2026-06-04 (pre-reconciliation) | CR-FINAL 2026-06-05 |
|--------|-----------------------------------|---------------------|
| gatePass (sourced pages) | **0 / 17** | **16 / 16** in-scope |
| siteAccuracySimpleAvgPct | 33.64% | **96.51%** |
| siteAccuracyWeightedPct | 32.00% | **98.21%** |
| Worst in-scope page | `/muzza/` 3.33% | all in-scope ≥ **95.71%** (`/stands-storage/`) |
| Gate script revision | team_90 baseline only | team_100 refinements ratified (§4) |

---

## §4 — Gate-tool ratification (team_90 gate owner)

team_90 **owns** `scripts/qa/content-diff.mjs`. Independently reviewed current canon against frozen baseline at `_COMMUNICATION/team_90/evidence/content-accuracy-2026-06-04/content-diff.mjs` and team_190 constitutional opinion (`VERDICT_WP-W2-15_L-GATE_VALIDATE_v1.md` §6).

**Verdict: RATIFY-WITH-FINDINGS** — team_90 **co-signs** team_190; no dissent on any change group.

| # | Change group | team_90 ruling | Lowers bar? |
|---|--------------|----------------|-------------|
| 1 | HTML-entity decode before `#`-strip | **RATIFY** | No — fixes `esc_html()` false negatives |
| 2 | Section-coverage calibration (title OR empty OR all sentences) | **RATIFY** — Principal-approved 2026-06-05 | No — structural labels excluded; content sentences still required |
| 3 | Per-line sentence split + paragraph fallback | **RATIFY** | No — aligns units with PHP render blocks |
| 4 | Dev scaffolding exclusion (`**DEV NOTES:**`, QA/להשלמה sections, `> DEV NOTE`, strikethrough) | **RATIFY** | No — author-only copy never for publish |
| 5 | FAQ `Category:` / `(חלק N)` title strip | **RATIFY** | No — source annotation vs live heading |
| 6 | Dash / ellipsis / maqaf / space-before-punct unification | **RATIFY** | No — `wptexturize()` + tag-strip artifacts only |
| 7 | Module `export`s for testability | **RATIFY** | No — no scoring change |

### Carried findings (non-blocking)

| ID | Note |
|----|------|
| GT-CR-FINAL-01 | `inventedBlocks` still flags fused UI chrome inside `<main>`; **gatePass** uses `inventedSections` (H2/H3) only — backlog for scrape scoping |
| GT-CR-FINAL-02 | Residual sentence gaps &lt;100% on book pages + `/stands-storage/` (92.86% — `/contact`-in-prose slug) — above gate bar; Eyal routing item |

**Canon path:** `scripts/qa/content-diff.mjs` · frozen CR-FINAL copy: `_COMMUNICATION/team_90/evidence/content-accuracy-cr-final-2026-06-05/content-diff.mjs`

---

## §5 — שיטה + רפרודוקציה

```bash
cd EyalAmit.co.il-2026
node scripts/qa/content-diff.mjs \
  --base http://eyalamit-co-il-2026.s887.upress.link \
  --out _COMMUNICATION/team_90/evidence/content-accuracy-cr-final-2026-06-05
```

Exit code: **0** · Evidence: `summary.json` + per-page `*.json`

### נרמול (post-ratification — see §4)

Beyond 2026-06-04 baseline: entity decode · section calibration · sentence granularity · dev-scaffold exclusion · FAQ title strips · WP display-transform glyph unification. Formula metadata documented in `summary.json` → `formula`.

---

## §6 — Out of scope / CR5

| Route | Status | Counted in CR1–4 rollup? |
|-------|--------|--------------------------|
| `/mokesh-dahiman` | FAIL (18.18% sentence) — Eyal-blocked CR5 | **No** |
| `/galleries/`, `/media/` | N/A — no Eyal source | **No** |

---

## §7 — CR-FINAL gate chain + routing

| Leg | Owner | Status |
|-----|-------|--------|
| 1 — Full-site content-accuracy re-audit | **team_90** | **PASS** (this report) |
| 2 — Full-site validate | team_190 | **PENDING** |
| 3 — E2E | team_50 | **PENDING** |

| Action | Owner |
|--------|-------|
| Acknowledge team_90 CR-FINAL leg PASS | team_100 |
| Issue team_190 CR-FINAL full-site mandate | team_100 |
| Issue team_50 CR-FINAL E2E mandate | team_100 |
| Inform team_00/Eyal "ready" | **BLOCKED** until triple-PASS |

---

## §8 — Evidence index

| Artifact | Path |
|----------|------|
| CR-FINAL summary | `_COMMUNICATION/team_90/evidence/content-accuracy-cr-final-2026-06-05/summary.json` |
| Per-page JSON | `_COMMUNICATION/team_90/evidence/content-accuracy-cr-final-2026-06-05/*.json` |
| Gate script snapshot | `_COMMUNICATION/team_90/evidence/content-accuracy-cr-final-2026-06-05/content-diff.mjs` |
| Pre-reconciliation baseline | `_COMMUNICATION/team_90/evidence/content-accuracy-2026-06-04/summary.json` |
| team_190 L-GATE_VALIDATE | `_COMMUNICATION/team_190/VERDICT_WP-W2-15_L-GATE_VALIDATE_v1.md` |

---

**Signed:** team_90 · CONTENT-ACCURACY gate owner · 2026-06-05 · CR-FINAL leg 1 **PASS**

**Delivery:** file-based per ADR043 §4 (Hub API unreachable this session)
