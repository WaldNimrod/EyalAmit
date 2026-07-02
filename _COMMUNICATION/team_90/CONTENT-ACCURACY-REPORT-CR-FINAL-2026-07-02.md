# Gate CR-FINAL_FULL-SITE-CONTENT-ACCURACY (re-run) — team_90 | Run 2026-07-02

## Context bundle

- **Work Package:** WP-W2-15-CR-FINAL (leg 1 re-run — expanded scope)
- **Domain:** EyalAmit.co.il-2026 (WordPress staging, branch `main`)
- **Write to:** `_COMMUNICATION/team_90/`
- **Mandate:** `_communication/team_100/MANDATE-TEAM90-FULL-SITE-AUDIT-2026-07-02_v1.0.0.md`
- **Predecessor baseline:** `_communication/team_90/CONTENT-ACCURACY-REPORT-CR-FINAL-2026-06-05.md` (16/16 in-scope PASS · 96.51% / 98.21%)
- **Staging:** http://eyalamit-co-il-2026.s887.upress.link
- **Hub:** http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/ (`generatedAt` 2026-07-02T12:18:20Z — matches local)
- **Measured @:** 2026-07-02T20:51:03Z · repo `main` @ `b968eed`

---

## §0 — Verdict box

| שדה | ערך |
|-----|-----|
| **Gate** | CR-FINAL_FULL-SITE-CONTENT-ACCURACY + images + browser QA + hub admin (team_90 leg 1 re-run) |
| **Verdict** | **FAIL** — P0 content regression on `/eyal-amit/` + image/slot audit FAIL |
| **CR-FINAL team_90 leg** | **FAIL** |
| **דיוק כללי (ממוצע עמודים)** | **99.70%** (היה 96.51% ב־2026-06-05) |
| **דיוק כללי (משוקלל לפי אורך מקור)** | **99.60%** (היה 98.21%) |
| **Gate F04 in-scope** | **15 / 16 PASS** (היה 16/16) — **P0 regression:** `/eyal-amit/` |
| **qa_probe (16×5 viewports)** | **80/80 PASS** — 0 overflow, 0 forbidden |
| **Image audit** | **FAIL** — 19 DOM-broken imgs, 9 missing image-map slots |
| **Hub admin (8 interfaces)** | **8/8 PASS** |
| **Gate-tool ratification** | **METHODOLOGY DRIFT** — `content-diff.mjs` differs from frozen 06-05 copy (§6) |
| **Legs 2/3 status** | **UNCHANGED** — team_190 + team_50 triple-PASS closed 2026-06-06 (see §7) |
| **Next step** | Route to **team_100** → team_10 fix `/eyal-amit/` section + image/slot gaps → re-run team_90 |

**מסקנה אחת:** תוכן רוב העמודים **משתפר** מול 06-05, אך **רגרסיה P0** בעמוד אודות + כשל אימות תמונות/סלוטים מונעים PASS ב־leg זה. אין "ready" חדש ל־Eyal.

---

## §1 — טבלת עמודים (content-diff re-run)

נוסחת **accuracy%** (F04): `pageAccuracy% = 0.4 × sectionCoverage% + 0.6 × sentenceCoverage%`

| page | section% | sentence% | accuracy% | gate | Δ vs 06-05 gate |
|------|----------|-----------|-----------|------|-----------------|
| `/` | 100 | 100 | 100.00 | PASS | = |
| `/method/` | 100 | 98.85 | 99.31 | PASS | = |
| `/treatment/` | 100 | 100 | 100.00 | PASS | = |
| `/sound-healing/` | 100 | 100 | 100.00 | PASS | = |
| `/lessons/` | 100 | 100 | 100.00 | PASS | = |
| `/faq/` | 100 | 100 | 100.00 | PASS | = |
| `/books/` | 100 | 100 | 100.00 | PASS | = |
| **`/eyal-amit/`** | **92.31** | 97.92 | **95.67** | **FAIL** | **P0: was PASS** |
| `/books/vekatavta/` | 100 | 100 | 100.00 | PASS | = |
| `/books/kushi-blantis/` | 100 | 100 | 100.00 | PASS | = |
| `/books/tsva-bekahol/` | 100 | 100 | 100.00 | PASS | ↑ (was 98.00) |
| `/didgeridoos/` | 100 | 100 | 100.00 | PASS | = |
| `/bags/` | 100 | 100 | 100.00 | PASS | = |
| `/stands-storage/` | 100 | 100 | 100.00 | PASS | ↑ (was 95.71) |
| `/stand-floor/` | 100 | 100 | 100.00 | PASS | = |
| `/repair/` | 100 | 100 | 100.00 | PASS | = |
| `/mokesh-dahiman` (CR5) | 100 | 100 | 100.00 | PASS* | ↑ — **out of rollup** |
| `/galleries/`, `/media/` | N/A | N/A | N/A | — | CR5 blocked |

\* mokesh measured but excluded from CR1–4 rollup per §6.

**חסר ב־`/eyal-amit/`:** סעיף §07 «המרכז לטיפול בדיג'רידו – סטודיו נשימה מעגלית פרדס חנה» — כותרת H2 לא מופיעה ב־live (תוכן משפט חלקי קיים בגרסה מקוצרת).

---

## §2 — Regressions (P0)

| ID | Page | 06-05 | 07-02 | Finding |
|----|------|-------|-------|---------|
| **P0-CRF-01** | `/eyal-amit/` | gate PASS (100/100 @ `/about/`) | gate **FAIL** (92.31% section) | Missing section §07 title + truncated studio sentence — likely WP-W2-16 / slug migration side-effect |

---

## §3 — Image audit (NEW)

**Tool:** `_communication/team_90/evidence/image-audit-cr-final-2026-07-02/image-audit.cjs`  
**SSOT:** `_communication/team_110/image-map.json` (71 slots; 8 pages mapped to WP paths)

| Metric | Value |
|--------|-------|
| Pages audited | 16 in-scope |
| Total `<img>` enumerated | 110 |
| DOM-broken (`naturalWidth===0` after scroll+wait) | **19** |
| image-map slots not found on live page | **9** |
| Pages PASS (0 broken + 0 missing slots) | **8/16** |
| **Verdict** | **FAIL** |

**Per-page summary:**

| page | imgs | broken | slots missing | pass |
|------|------|--------|---------------|------|
| `/` | 22 | 8 | 2 (hero video/poster) | FAIL |
| `/method/` | 8 | 2 | 0 | FAIL |
| `/treatment/` | 9 | 0 | 1 | FAIL |
| `/sound-healing/` | 7 | 0 | 0 | PASS |
| `/lessons/` | 6 | 1 | 0 | FAIL |
| `/faq/` | 2 | 0 | 0 | PASS |
| `/books/` | 4 | 0 | 0 | PASS |
| `/eyal-amit/` | 7 | 2 | 4 | FAIL |
| `/books/vekatavta/` | 8 | 1 | 0 | FAIL |
| `/books/kushi-blantis/` | 11 | 4 | 2 | FAIL |
| `/books/tsva-bekahol/` | 2 | 1 | 0 | FAIL |
| `/didgeridoos/` | 3 | 0 | 0 | PASS |
| `/bags/` | 4 | 0 | 0 | PASS |
| `/stands-storage/` | 8 | 0 | 0 | PASS |
| `/stand-floor/` | 2 | 0 | 0 | PASS |
| `/repair/` | 7 | 0 | 0 | PASS |

**Methodology note:** sampled «broken» URLs return HTTP 200 (e.g. `eyal-bright.jpg`). Failures correlate with lazy-loaded / carousel off-screen images — team_90 recommends team_10 verify visually + fix hero `<video>` presence on home. Evidence: `evidence/image-audit-cr-final-2026-07-02/per-page/*.json`.

---

## §4 — Browser QA / cross-viewport (NEW)

**Tool:** `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs`  
**Config:** `evidence/qa-probe-cr-final-2026-07-02/qa_probe_config.json`  
**Engine:** Chrome headless-shell only (no Firefox/Safari — **limitation stated**)

| Metric | Value |
|--------|-------|
| Pages | 16 in-scope |
| Viewports | w360, w390, w414, w768, w1440 |
| Total checks | **80** |
| Failures | **0** |
| Screenshots | `evidence/qa-probe-cr-final-2026-07-02/screenshots/` (mobile + desktop per page) |
| **Verdict** | **PASS** |

---

## §5 — Hub admin interfaces (NEW)

**Base:** `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/`  
**Evidence:** `evidence/hub-admin-2026-07-02/hub-admin-summary.json`

| Interface | Verdict | Notes |
|-----------|---------|-------|
| `content-intake.html` | **PASS** | 40 page options in dropdown |
| `media-intake.html` | **PASS** | 38 media cards |
| `materials-intake.html` | **PASS** | 9 groups A–I render |
| `image-picker.html` | **PASS** | `TOTAL=71` in JS; page loads |
| `page-review.html` | **PASS** | 40 `details.pr-sec` sections |
| `meeting-checklist.html` | **PASS** | pending decisions render |
| `tasks.html` | **PASS** | 60 task rows; export buttons present |
| `site-tree.html` | **PASS** | 40 `.site-tree-node` entries |

**Carried finding (non-blocking):** `image-picker.html` — smoke test confirms slot count constant; candidate thumb load + localStorage round-trip not exercised in this run (recommend team_50 spot-check).

---

## §6 — Gate-tool health

**Diff:** `scripts/qa/content-diff.mjs` vs frozen `evidence/content-accuracy-cr-final-2026-06-05/content-diff.mjs` — **46 lines changed** (`evidence/preflight-2026-07-02/content-diff-drift.diff`).

| Change area | Status |
|-------------|--------|
| PAGE_MAP slug updates (`/books/`, `/eyal-amit/`, mokesh path+source) | **DRIFT** — not re-ratified this run |
| docx paragraph extraction fix | **DRIFT** |
| jungle vibes normalization | **DRIFT** |
| blockquote skip scope | **DRIFT** |

**Verdict:** **METHODOLOGY DRIFT** — team_90 does **not** silently re-ratify. team_100 should reconcile drift vs 06-05 §4 ratification before next gate cycle.

Script runs clean (exit 0) against current staging.

---

## §7 — CR-FINAL gate chain

| Leg | Owner | Status (confirmed 2026-07-02) |
|-----|-------|-------------------------------|
| 1 — Content+images+browser+hub re-audit | **team_90** | **FAIL** (this report) |
| 2 — Full-site L-GATE_VALIDATE | team_190 | **PASS** (clean re-confirm 2026-06-05) |
| 3 — E2E | team_50 | **PASS** (clean 2026-06-05) |
| Triple-PASS (June) | team_00 | **CLEAN** 2026-06-06 — [`READY_WP-W2-15-CR1-4_CONTENT_2026-06-06.md`](../team_00/READY_WP-W2-15-CR1-4_CONTENT_2026-06-06.md) |

Legs 2/3 **not re-run** — valid for June baseline; **invalidated for new "ready"** until leg 1 re-run PASS after fixes.

---

## §8 — Evidence index

| Artifact | Path |
|----------|------|
| Content summary | `evidence/content-accuracy-cr-final-2026-07-02/summary.json` |
| Per-page content JSON | `evidence/content-accuracy-cr-final-2026-07-02/*.json` |
| Gate script snapshot | `evidence/content-accuracy-cr-final-2026-07-02/content-diff.mjs` |
| Image audit | `evidence/image-audit-cr-final-2026-07-02/summary.json` |
| qa_probe | `evidence/qa-probe-cr-final-2026-07-02/qa_probe_result.json` |
| qa_probe screenshots | `evidence/qa-probe-cr-final-2026-07-02/screenshots/` |
| Hub admin | `evidence/hub-admin-2026-07-02/hub-admin-summary.json` |
| AOS validate | `evidence/preflight-2026-07-02/validate_aos.txt` |
| content-diff drift | `evidence/preflight-2026-07-02/content-diff-drift.diff` |
| 06-05 baseline | `evidence/content-accuracy-cr-final-2026-06-05/summary.json` |

---

**Signed:** team_90 · CONTENT-ACCURACY gate owner · 2026-07-02 · CR-FINAL leg 1 re-run **FAIL**

**Delivery:** Route to team_100 · blocking: P0-CRF-01 + image audit FAIL
