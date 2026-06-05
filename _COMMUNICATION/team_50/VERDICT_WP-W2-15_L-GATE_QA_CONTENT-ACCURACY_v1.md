---
id: VERDICT_WP-W2-15_L-GATE_QA_CONTENT-ACCURACY_v1
title: team_50 L-GATE_QA_CONTENT-ACCURACY Verdict — WP-W2-15 CR1–CR4
date: 2026-06-05
from_team: team_50 (QA / L-GATE_QA_CONTENT-ACCURACY)
to_team: team_100 → team_190 (on PASS)
wp: WP-W2-15
scope: CR1–CR4 (16 sourced pages; CR5 excluded)
gate: L-GATE_QA_CONTENT-ACCURACY
engine_builder: claude-code (team_100)
engine_validator: cursor-composer (team_50)   # IR#1 compliant
branch: wp-w2-15-cr1
head_commit: ba3a5d5
staging: http://eyalamit-co-il-2026.s887.upress.link
mandate: _COMMUNICATION/team_50/MANDATE_WP-W2-15_CONTENT-ACCURACY_v1.0.0.md
evidence: _COMMUNICATION/team_50/evidence/content-accuracy-2026-06-05/
status: ISSUED
delivery: file-based (ADR043 §4 fallback — Hub API unreachable this session)
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-15 — Content reconciliation CR1–CR4 |
| Gate | L-GATE_QA_CONTENT-ACCURACY (team_50 independent re-run) |
| Verdict | **PASS_WITH_FINDINGS** |
| In-scope pages | **16 / 16 gatePass** (CR1–CR4 sourced pages) |
| Out of scope | `/mokesh-dahiman` (CR5 — BLOCKED on Eyal, expected FAIL) |
| Blocking AC | **None** for CR1–CR4 batch |
| One-line next step | Route to **team_190** L-GATE_VALIDATE for CR1–CR4; carry findings §6–§8 to Principal / team_90 for ratification & URL decisions |

---

# §1 Engine Declaration (IR#1 / IR#5)

| Field | Value |
|-------|-------|
| Builder | **Claude Code** (team_100) — built reconciliation + self-measured gate |
| Validator | **Cursor Composer** (team_50) — this verdict; did **not** trust team_100 numbers |
| Attestation | All gate commands re-run independently on live staging 2026-06-05 |
| Repo @ QA time | branch `wp-w2-15-cr1` · HEAD `ba3a5d5` |

---

# §2 Commands Run + Exit Codes

| Command | Exit | Evidence |
|---------|------|----------|
| `node scripts/qa/content-diff.mjs --out _COMMUNICATION/team_50/evidence/content-accuracy-2026-06-05/` | **0** | `summary.json` + per-page JSON |
| `node scripts/qa/http-qa-axe.cjs` (17 CR routes incl. `/muzza/` + `/books/`) | **0** | `scripts/qa/reports/axe-http-2026-06-05.json` |
| `node _aos/lean-kit/.../qa_probe.mjs --config .../qa_probe_config.json` (17 pages × 4 vp) | **0** | `qa_probe/qa_probe_result.json` — **68/68** no overflow |
| H1 + RTL + HTTP probe (puppeteer, 17 routes) | **0** | inline run — all **200**, **H1=1**, **`dir=rtl`** |
| Verbatim spot-check (3 pages × 3 phrases) | **pass** | `/treatment/`, `/repair/`, `/books/vekatavta/` — all phrases found in `innerText` |
| `git diff main...HEAD -- ea-tokens.css` | **empty** | no token drift on branch |

---

# §3 CONTENT-ACCURACY — Reproduced Numbers (team_50 live run)

**Generated:** 2026-06-05T08:55:00Z · **Base:** staging · **Script:** `scripts/qa/content-diff.mjs`

**Site rollup (team_50):** simple avg **95.87%** · weighted **97.55%** · **16/17 gatePass** (identical to team_100 self-measure)

| Page | section | sentence | invented | gate | team_100 |
|------|---------|----------|----------|------|----------|
| `/` | 100% | 100% | 0 | **PASS** | match |
| `/method/` | 100% | 100% | 0 | **PASS** | match |
| `/treatment/` | 100% | 100% | 0 | **PASS** | match |
| `/sound-healing/` | 100% | 92.73% | 0 | **PASS** | match |
| `/lessons/` | 100% | 100% | 0 | **PASS** | match |
| `/faq/` | 100% | 98.15% | 0 | **PASS** | match |
| `/muzza` → `/books/` | 100% | 100% | 0 | **PASS** | match |
| `/eyal-amit` (`/about/`) | 100% | 100% | 0 | **PASS** | match |
| `/books/vekatavta/` | 100% | 98.28% | 0 | **PASS** | match |
| `/books/kushi-blantis/` | 100% | 95.24% | 0 | **PASS** | match |
| `/books/tsva-bekahol/` | 100% | 96.67% | 0 | **PASS** | match |
| `/didgeridoos/` | 100% | 100% | 0 | **PASS** | match |
| `/bags/` | 100% | 100% | 0 | **PASS** | match |
| `/stands-storage/` | 100% | 92.86% | 0 | **PASS** | match |
| `/stand-floor/` | 100% | 100% | 0 | **PASS** | match |
| `/repair/` | 100% | 100% | 0 | **PASS** | match |
| `/mokesh-dahiman` | 100% | 9.09% | 0 | **FAIL** | match — **CR5, out of scope** |

**CR1–CR4 in-scope conclusion:** **16/16 PASS** — team_100 numbers **confirmed**, not assumed.

Per-page detail: `_COMMUNICATION/team_50/evidence/content-accuracy-2026-06-05/*.json`

---

# §4 Verbatim Spot-Check (eye-level)

Three pages sampled against source files under `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/`:

| Page | Source | Sample phrases checked | Result |
|------|--------|------------------------|--------|
| `/treatment/` | `טיפול בדיג'רידו/treatment.md` | Hero H1 body; §03 opening sentence; §02 poetic opener "משהו בנשימה שלך…" | **VERBATIM** — exact `innerText` substring match, no paraphrase detected |
| `/repair/` | `תיקון כלי דיג'רידו/build didg.md` | Hero subhead; "מעל שני עשורים"; "כל תיקון מתחיל בבדיקה…" | **VERBATIM** |
| `/books/vekatavta/` | `וכתבת/vekatavta.md` | "46 סיפורים אמיתיים…"; "ספר אישי מאוד, חי מאוד…"; QR sentence | **VERBATIM** |

No invented marketing copy observed in sampled hero/body blocks. DEV NOTES / CTA scaffolding from source correctly absent on live render.

---

# §5 Layout / a11y / Structure

## Horizontal overflow (@360 / @390 / @414 / /768)

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
| HTTP 200 (final document) | **17/17** ( `/muzza/` follows 302 → `/books/` then 200 ) |
| Single H1 | **17/17** |
| RTL (`html[dir=rtl]`, `lang=he-IL`) | **17/17** |

## D-14 / tokens

| Check | Result |
|-------|--------|
| `ea-tokens.css` changed on `wp-w2-15-cr1` vs `main` | **No diff** — structure/atoms constraint satisfied |

---

# §6 Gate-Tool Ratification Opinion (§4 mandate items)

team_50 reviewed `scripts/qa/content-diff.mjs` against the team_90 baseline snapshot at `_COMMUNICATION/team_90/evidence/content-accuracy-2026-06-04/content-diff.mjs`.

**Recommendation:** **RATIFY WITH FINDINGS** — pending formal team_90 ownership stamp + team_190 final authority per program §4.

| # | Change | team_50 opinion |
|---|--------|-----------------|
| 1 | HTML-entity decode before `#`-strip | **RATIFY** — fixes false negatives on apostrophe-heavy Hebrew (`&#039;` → `'`) without lowering bar |
| 2 | Section-coverage calibration (title OR empty OR all sentences) | **RATIFY** — Principal-approved 2026-06-05; removes false misses on structural labels (Hero/Intro/CTA) while still requiring sentence presence for content-bearing sections |
| 3 | Sentence-fusion fix (per-line split + paragraph fallback) | **RATIFY** — aligns units with PHP render granularity; verified on `/treatment/` poetic opener |
| 4 | Strip dev scaffolding (`~~strikethrough~~`, `**DEV NOTES:**`, `(להשלמה)`, `> DEV NOTE:` blockquotes, FAQ Category / `(חלק N)`) | **RATIFY** — excludes author-only scaffolding never intended for publish; spot-check confirms live pages omit these |
| 5 | Display-only glyph unification (dash, ellipsis, maqaf spacing) | **RATIFY** — normalizes WordPress `wptexturize` / tag-stripping artifacts, not content edits |

**Caveat for team_90:** Builder (team_100) modified the measuring tool — IR#1 requires this ratification trail. team_50 confirms the **live re-run with the modified tool** still yields **16/16 in-scope PASS** and spot-checks show **verbatim** Eyal copy, not relaxed matching of paraphrased text.

**Not ratified by team_50 (out of scope here):** whether `content-selfcheck.mjs` local proxy should become CI-default — live `content-diff.mjs` remains authoritative per mandate.

---

# §7 Findings (non-blocking for CR1–CR4)

| ID | Severity | Finding |
|----|----------|---------|
| F-W2-15-CA-01 | **P2 — Principal** | `/muzza/` → `/books/` **302** interim (`Location: …/books/`). Gate correctly fetches MUZZA content at `/books/`. Needs canonical URL + permanent 301 + nav alignment. |
| F-W2-15-CA-02 | **P2 — Eyal** | Source ambiguities flagged in mandate §5 (book slugs `/muzeh/…` vs `/books/…`, vekatavta spelling variant, internal slug normalizations, `/repair` testimonials `(להשלמה)`, FAQ `/contact` literal vs humanized anchor) — content is Eyal-verbatim where rendered; routing/link decisions remain open. |
| F-W2-15-CA-03 | **P2 — content** | Sentence gaps **below gate threshold** but documented: `/sound-healing/` 4 sentences in "איך זה עובד" (92.73%); `/faq/` 1 sentence in workshops category (98.15%); `/stands-storage/` 1 FAQ sentence with `/contact` literal (92.86%); book pages minor gallery/dev-note lines. All remain **≥90% sentence / 100% section**. Recommend Eyal eyeball on sound-healing "איך זה עובד" block. |
| F-W2-15-CA-04 | **INFO** | `/mokesh-dahiman` **FAIL** (9.09% sentence) — **CR5, BLOCKED on Eyal** — correctly excluded from this mandate. |
| F-W2-15-CA-05 | **INFO** | Gate-tool ratification trail open — team_90 + team_190 per §6 above. |

---

# §8 Route Back to team_100

| Action | Owner |
|--------|-------|
| Advance CR1–CR4 to **team_190 L-GATE_VALIDATE** | team_100 → team_190 |
| Open team_90 ticket to **formally ratify** `content-diff.mjs` §4 changes (team_50 pre-ratifies — §6) | team_90 |
| Escalate **F-W2-15-CA-01** `/muzza` canonical URL to Principal | team_100 → team_00 |
| Keep **CR5** blocked until Eyal supplies mokesh/galleries/media source | team_100 |
| Optional: Eyal review **F-W2-15-CA-03** sound-healing § "איך זה עובד" missing sentences | team_00 |

---

# §9 Evidence Index

| Artifact | Path |
|----------|------|
| Content-diff summary | `_COMMUNICATION/team_50/evidence/content-accuracy-2026-06-05/summary.json` |
| Per-page content-diff | `_COMMUNICATION/team_50/evidence/content-accuracy-2026-06-05/*.json` |
| Overflow probe config | `_COMMUNICATION/team_50/evidence/content-accuracy-2026-06-05/qa_probe_config.json` |
| Overflow results | `_COMMUNICATION/team_50/evidence/content-accuracy-2026-06-05/qa_probe/qa_probe_result.json` |
| axe report | `scripts/qa/reports/axe-http-2026-06-05.json` |
| team_100 baseline (comparison) | `_COMMUNICATION/team_90/evidence/content-accuracy-2026-06-04/summary.json` |

---

**Signed:** team_50 · Cursor Composer · 2026-06-05 · IR#1 compliant independent validation
