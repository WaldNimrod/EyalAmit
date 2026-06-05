---
id: VERDICT_WP-W2-15_L-GATE_VALIDATE_v1
title: team_190 L-GATE_VALIDATE Verdict — WP-W2-15 CR1–CR4
date: 2026-06-05
from_team: team_190 (L-GATE_VALIDATE — constitutional cross-engine, IR#5)
to_team: team_100 → merge CR1–CR4; team_50 (dual-PASS ack); team_90 (gate-tool co-sign)
wp: WP-W2-15
scope: CR1–CR4 (16 sourced pages; CR5 excluded)
gate: L-GATE_VALIDATE
engine_builder: claude-code (team_100)
engine_validator: cursor-composer (team_190)
branch: wp-w2-15-cr1
head_commit: 8e9cca7
staging: http://eyalamit-co-il-2026.s887.upress.link
mandate: _COMMUNICATION/team_190/MANDATE_WP-W2-15_L-GATE_VALIDATE_v1.0.0.md
predecessor: _COMMUNICATION/team_50/VERDICT_WP-W2-15_L-GATE_QA_CONTENT-ACCURACY_v1.md (PASS_WITH_FINDINGS)
findings_resolution: _COMMUNICATION/team_100/FINDINGS-RESOLUTION_WP-W2-15_team50_2026-06-05.md
evidence: _COMMUNICATION/team_190/evidence/content-accuracy-2026-06-05/
status: ISSUED
delivery: file-based (ADR043 §4 fallback — Hub API unreachable this session)
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-15 — Content reconciliation CR1–CR4 |
| Gate | L-GATE_VALIDATE (team_190 constitutional cross-engine) |
| Predecessor | team_50 L-GATE_QA_CONTENT-ACCURACY **PASS_WITH_FINDINGS** (16/16 in-scope) |
| Verdict | **PASS** |
| In-scope pages | **16 / 16 gatePass** |
| Out of scope | `/mokesh-dahiman` (CR5 — BLOCKED on Eyal, expected FAIL) |
| Gate-tool ratification | **RATIFY-WITH-FINDINGS** (team_190 + team_90 co-sign — §6) |
| Blocking AC | **0** |
| One-line next step | **Dual-PASS achieved** — team_100 may merge `wp-w2-15-cr1` → `main` and lock CR1–CR4 roadmap; CR5 remains blocked |

---

# §1 Engine Declaration (IR#1 / IR#5)

| Field | Value |
|-------|-------|
| Builder | **Claude Code** (team_100) — reconciliation + gate-tool refinements |
| QA validator | **Cursor Composer** (team_50) — independent L-GATE_QA re-run 2026-06-05 |
| Constitutional validator | **Cursor Composer** (team_190) — this verdict; did **not** trust team_50/team_100 numbers |
| Attestation | All mandate commands re-run independently on live staging 2026-06-05T16:41–16:48Z |
| Repo @ validate time | branch `wp-w2-15-cr1` · HEAD `8e9cca7` |

---

# §2 Commands Run + Exit Codes

| Command | Exit | Evidence |
|---------|------|----------|
| `node scripts/qa/content-diff.mjs --out _COMMUNICATION/team_190/evidence/content-accuracy-2026-06-05/` | **0** | `summary.json` + per-page JSON |
| `node scripts/qa/http-qa-axe.cjs` (17 CR routes incl. `/muzza/` + `/books/`) | **0** | `scripts/qa/reports/axe-http-2026-06-05.json` |
| `node _aos/lean-kit/.../qa_probe.mjs` (17 pages × 4 vp) | **0** | `qa_probe_result.json` — **68/68** no overflow |
| H1 + RTL + HTTP probe (puppeteer, 17 routes) | **0** | `h1-rtl-http-probe.json` — all **200**, **H1=1**, **`dir=rtl`** |
| Verbatim spot-check (3 pages × 3 phrases) | **0** | `verbatim-spotcheck.json` |
| `git diff main...HEAD -- ea-tokens.css` | **empty** | no token drift on branch |
| `curl -sI /muzza/` | **301** | permanent redirect → `/books/` (team_100 F-W2-15-CA-01 fix confirmed) |

---

# §3 CONTENT-ACCURACY — Reproduced Numbers (team_190 live run)

**Generated:** 2026-06-05T16:41:42Z · **Base:** staging · **Script:** `scripts/qa/content-diff.mjs` (post team_100 gate-tool changes)

**Site rollup (team_190):** simple avg **96.51%** · weighted **98.21%** · **16/17 gatePass** — **matches team_100 post-resolution numbers exactly**; team_50 pre-resolution numbers superseded where findings were fixed (e.g. `/sound-healing/` → 100% sentence).

| Page | section | sentence | invented | gate | team_50 @ QA | team_190 |
|------|---------|----------|----------|------|--------------|----------|
| `/` | 100% | 100% | 0 | **PASS** | match | **match** |
| `/method/` | 100% | 100% | 0 | **PASS** | match | **match** |
| `/treatment/` | 100% | 100% | 0 | **PASS** | match | **match** |
| `/sound-healing/` | 100% | **100%** | 0 | **PASS** | was 92.73% | **100%** (steps.intro fix) |
| `/lessons/` | 100% | 100% | 0 | **PASS** | match | **match** |
| `/faq/` | 100% | **100%** | 0 | **PASS** | was 98.15% | **100%** (space-before-punct norm) |
| `/muzza` → `/books/` | 100% | 100% | 0 | **PASS** | match | **match** |
| `/eyal-amit` (`/about/`) | 100% | 100% | 0 | **PASS** | match | **match** |
| `/books/vekatavta/` | 100% | 98.28% | 0 | **PASS** | match | **match** |
| `/books/kushi-blantis/` | 100% | 95.24% | 0 | **PASS** | match | **match** |
| `/books/tsva-bekahol/` | 100% | 96.67% | 0 | **PASS** | match | **match** |
| `/didgeridoos/` | 100% | 100% | 0 | **PASS** | match | **match** |
| `/bags/` | 100% | 100% | 0 | **PASS** | match | **match** |
| `/stands-storage/` | 100% | 92.86% | 0 | **PASS** | match | **match** |
| `/stand-floor/` | 100% | 100% | 0 | **PASS** | match | **match** |
| `/repair/` | 100% | 100% | 0 | **PASS** | match | **match** |
| `/mokesh-dahiman` | 100% | 18.18% | 0 | **FAIL** | match — **CR5, out of scope** | match |

**CR1–CR4 in-scope conclusion:** **16/16 PASS** — team_100 and team_50 numbers **confirmed independently**, not assumed.

Per-page detail: `_COMMUNICATION/team_190/evidence/content-accuracy-2026-06-05/*.json`

---

# §4 Verbatim Spot-Check (eye-level)

Three pages sampled against source files under `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/`:

| Page | Source | Sample phrases checked | Result |
|------|--------|------------------------|--------|
| `/treatment/` | `טיפול בדיג'רידו/treatment.md` | §02 opener "משהו בנשימה שלך מבקש תשומת לב"; §03 lead "טיפול בדיג'רידו הוא תהליך אישי…"; §03 close "משהו בנשימה היומיומית מתחיל להשתנות" | **VERBATIM** — exact `main` `innerText` substring match |
| `/repair/` | `תיקון כלי דיג'רידו/build didg.md` | "מעל שני עשורים"; "כל תיקון מתחיל בבדיקה"; "בהתאם לסטנדרט העבודה ולרמת הדיוק הנדרשת בכל תיקון" | **VERBATIM** |
| `/books/vekatavta/` | `וכתבת/vekatavta.md` | "46 סיפורים אמיתיים…"; "ספר אישי מאוד, חי מאוד…"; QR sentence | **VERBATIM** |

No invented marketing copy observed in sampled hero/body blocks. DEV NOTES / CTA scaffolding from source correctly absent on live render.

Evidence: `_COMMUNICATION/team_190/evidence/content-accuracy-2026-06-05/verbatim-spotcheck.json`

---

# §5 No-Regression (layout / a11y / structure)

## Horizontal overflow (@360 / @390 / @414 / @768)

| Metric | Result |
|--------|--------|
| Pages × viewports | 17 × 4 = **68** |
| Overflow failures | **0** |
| Tool | `qa_probe.mjs` CDP scrollWidth vs clientWidth |

## axe-core (WCAG 2A/2AA)

| Metric | Result |
|--------|--------|
| Routes probed | 17 (incl. `/muzza/` and `/books/`) |
| critical / serious | **0 / 0** on all routes |
| Report | `scripts/qa/reports/axe-http-2026-06-05.json` |

## HTTP / H1 / RTL

| Check | Result |
|-------|--------|
| HTTP 200 (final document) | **17/17** ( `/muzza/` follows **301** → `/books/` then 200 ) |
| Single H1 | **17/17** |
| RTL (`html[dir=rtl]`, `lang=he-IL`) | **17/17** |

## D-14 / tokens

| Check | Result |
|-------|--------|
| `ea-tokens.css` changed on `wp-w2-15-cr1` vs `main` | **No diff** — structure/atoms constraint satisfied |

---

# §6 Gate-Tool Ratification (constitutional — team_190 + team_90 co-sign)

team_190 independently reviewed every change in `scripts/qa/content-diff.mjs` against the team_90 baseline snapshot at `_COMMUNICATION/team_90/evidence/content-accuracy-2026-06-04/content-diff.mjs`. team_50 pre-ratification (§6 of QA verdict) was used as a cross-check only — not as authority.

**Joint opinion (team_190 + team_90 gate owner):** **RATIFY-WITH-FINDINGS**

| # | Change | team_190 opinion | Bar-lowering? |
|---|--------|------------------|---------------|
| 1 | HTML-entity decode **before** markdown `#`-strip (`&#039;`, `&quot;`, numeric entities) | **RATIFY** — fixes false negatives from `esc_html()` without relaxing substring match | **No** |
| 2 | Section-coverage calibration (title OR zero sentences OR all sentences present) | **RATIFY** — Principal-approved 2026-06-05; structural labels (Hero/Intro/CTA) are authoring scaffolding; content-bearing sections still require sentence presence | **No** |
| 3 | Sentence split: per-line primary + blank-line paragraph fallback | **RATIFY** — aligns gate units with PHP block render granularity; verified on `/treatment/` poetic opener | **No** |
| 4 | Dev scaffolding exclusion: `~~strikethrough~~`, bold `**DEV NOTES:**`, `isDevSectionTitle` (DEV/QA/להשלמה), `> DEV NOTE` blockquotes, paragraph-break sentinels | **RATIFY** — excludes author-only copy never intended for publish; spot-check confirms live omission | **No** |
| 5 | Title strips: `FAQ Category:` prefix, `(חלק N)` / `(part N)` suffix | **RATIFY** — source annotation vs published heading normalization | **No** |
| 6 | Display-only glyph unification: dash variants, ellipsis `…`→`...`, maqaf-space collapse, space-before-punctuation after tag-strip | **RATIFY** — normalizes `wptexturize()` / HTML-stripping artifacts, not paraphrase tolerance | **No** |
| 7 | Module exports (`export` on `normalize`, `PAGE_MAP`, `analyzePage`, etc.) | **RATIFY** — testability only; no scoring change | **No** |

### Findings carried with ratification (non-blocking)

| ID | Severity | Finding |
|----|----------|---------|
| G-W2-15-GT-01 | **INFO** | `inventedBlocks` heuristic still flags fused UI chrome inside `<main>` (nav CTAs, cross-links). **gatePass** uses `inventedSections` (H2/H3 headings only) — unaffected; consider future `<main>` scrape scoping in team_90 backlog. |
| G-W2-15-GT-02 | **INFO** | Section calibration allows pass on title-less structural sections when all sentences present — documented in `summary.json` formula metadata; acceptable per Principal approval. |
| G-W2-15-GT-03 | **P2 — Eyal** | Residual sentence gaps below 100% but above gate bar on `/stands-storage/` (92.86% — `/contact`-in-prose slug) and book pages (gallery/dev-note lines) — carried from team_50 F-W2-15-CA-03. |

**team_90 gate-owner stamp:** Co-signed in this document per WP-W2-15 program §4 / IR#1 builder-modified-tool trail. Baseline canon remains `scripts/qa/content-diff.mjs`; frozen reference copy at team_90 evidence path retained for diff audit.

---

# §7 Carried Items (out of scope — not blocking CR1–CR4 close)

| Item | Status |
|------|--------|
| CR5 `/mokesh-dahiman`, `/galleries/`, `/media/` | **BLOCKED** on Eyal source / H1 decisions |
| `/muzza` vs `/books` brand canonical | Interim **301→/books** + nav repoint — Principal may flip; one-line revert documented in findings resolution |
| `hikikomori` spelling inconsistency in source | Eyal verbatim — zero-invention rule |
| `/contact` literal in FAQ prose vs humanized anchor | Eyal to reword source if literal slug required |

---

# §8 Gate Chain + Routing

| Step | Artifact | Status |
|------|----------|--------|
| team_90 baseline audit | `CONTENT-ACCURACY-REPORT-2026-06-04.md` (0/17 PASS pre-reconciliation) | Historical |
| team_100 build + self-measure | branch `wp-w2-15-cr1` | Complete |
| team_50 L-GATE_QA | `VERDICT_WP-W2-15_L-GATE_QA_CONTENT-ACCURACY_v1.md` | **PASS_WITH_FINDINGS** |
| team_100 findings resolution | `FINDINGS-RESOLUTION_WP-W2-15_team50_2026-06-05.md` | Complete |
| team_190 L-GATE_VALIDATE | this document | **PASS** |

| Verdict | Route |
|---------|-------|
| **PASS** | **CR1–CR4 CLOSE** → team_100 merge `wp-w2-15-cr1` → `main` + lock roadmap |
| Carried | CR5 remains blocked; G-W2-15-GT-* + F-W2-15-CA-* to Principal / Eyal |

---

# §9 Evidence Index

| Artifact | Path |
|----------|------|
| Content-diff summary | `_COMMUNICATION/team_190/evidence/content-accuracy-2026-06-05/summary.json` |
| Per-page content-diff | `_COMMUNICATION/team_190/evidence/content-accuracy-2026-06-05/*.json` |
| Overflow probe results | `_COMMUNICATION/team_190/evidence/content-accuracy-2026-06-05/qa_probe_result.json` |
| H1 / RTL / HTTP probe | `_COMMUNICATION/team_190/evidence/content-accuracy-2026-06-05/h1-rtl-http-probe.json` |
| Verbatim spot-check | `_COMMUNICATION/team_190/evidence/content-accuracy-2026-06-05/verbatim-spotcheck.json` |
| axe report | `scripts/qa/reports/axe-http-2026-06-05.json` |
| Gate-tool baseline (team_90) | `_COMMUNICATION/team_90/evidence/content-accuracy-2026-06-04/content-diff.mjs` |
| team_50 QA verdict | `_COMMUNICATION/team_50/VERDICT_WP-W2-15_L-GATE_QA_CONTENT-ACCURACY_v1.md` |

---

**Signed:** team_190 · Cursor Composer · 2026-06-05 · IR#5 constitutional cross-engine validation

**Co-signed (gate owner):** team_90 · CONTENT-ACCURACY gate · RATIFY-WITH-FINDINGS per §6
