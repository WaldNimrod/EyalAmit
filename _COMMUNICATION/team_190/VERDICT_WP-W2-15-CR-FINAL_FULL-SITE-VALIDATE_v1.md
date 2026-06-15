---
id: VERDICT_WP-W2-15-CR-FINAL_FULL-SITE-VALIDATE_v1
title: team_190 CR-FINAL FULL-SITE L-GATE_VALIDATE Verdict — WP-W2-15 (leg 2 of 3)
date: 2026-06-05
from_team: team_190 (L-GATE_VALIDATE — constitutional cross-engine, IR#5)
to_team: team_100 → activate team_50 E2E (leg 3); team_90 (gate-tool final stamp ack)
wp: WP-W2-15-CR-FINAL
scope: Full-site no-regression + content-accuracy hold on merged main (CR1–CR4); CR5 excluded
gate: CR-FINAL_FULL-SITE_L-GATE_VALIDATE
engine_builder: claude-code (team_100)
engine_validator: cursor-composer (team_190)
branch: main
head_commit: 74bb457 (CR1–4 content @ d267b15+; mandate ref 9c48714)
staging: http://eyalamit-co-il-2026.s887.upress.link
mandate: _COMMUNICATION/team_190/MANDATE_WP-W2-15-CR-FINAL_FULL-SITE-VALIDATE_v1.0.0.md
predecessor: _COMMUNICATION/team_90/CONTENT-ACCURACY-REPORT-CR-FINAL-2026-06-05.md (PASS · 16/16)
build_leg: _COMMUNICATION/team_190/VERDICT_WP-W2-15_L-GATE_VALIDATE_v1.md (PASS)
evidence: _COMMUNICATION/team_190/evidence/cr-final-full-site-2026-06-05/
status: ISSUED
delivery: file-based (ADR043 §4 fallback — Hub API unreachable this session)
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-15-CR-FINAL — post-merge full-site constitutional validation |
| Gate | CR-FINAL_FULL-SITE_L-GATE_VALIDATE (team_190 leg **2 / 3**) |
| Predecessor | team_90 CR-FINAL re-audit **PASS** (16/16 · 96.51%/98.21%) |
| Verdict | **PASS_WITH_FINDINGS** |
| Blocking AC | **0** |
| In-scope content | **16 / 16 gatePass** (reproduced independently) |
| Full-site technical | **38 routes** · overflow **152/152** · axe **38/38** · H1/RTL **38/38** · `ea-tokens.css` **0 diff** |
| Out of scope | CR5 `/mokesh-dahiman`, `/galleries/`, `/media/` — BLOCKED on Eyal |
| Gate-tool (IR#5) | **RATIFY-WITH-FINDINGS** — final cross-engine stamp **confirmed** (§6) |
| One-line next step | **team_100:** activate **team_50** CR-FINAL full-site E2E (leg 3); triple-PASS remains open until leg 3 closes |

---

# §1 Engine Declaration (IR#1 / IR#5)

| Field | Value |
|-------|-------|
| Builder | **Claude Code** (team_100) — CR1–CR4 merged `main` |
| Gate owner | **team_90** — `content-diff.mjs` owner; leg 1 PASS 2026-06-05 |
| Constitutional validator | **Cursor Composer** (team_190) — this verdict; **did not** trust team_90/team_100 numbers |
| Attestation | All mandate checks re-run independently on live staging 2026-06-05T20:23–20:38Z |
| Repo @ validate time | branch `main` · HEAD `74bb457` (includes CR-FINAL activation commits; CR content @ `d267b15`+) |

---

# §2 Commands Run + Exit Codes

| Command | Exit | Evidence |
|---------|------|----------|
| `node scripts/qa/content-diff.mjs --out …/content-accuracy/` | **0** | `content-accuracy/summary.json` + per-page JSON |
| `node …/qa_probe.mjs --config qa_probe_config.json` (38 pages × 4 vp) | **0** | `qa_probe_result.json` — **152/152** no overflow |
| `node scripts/qa/http-qa-axe.cjs` (38 full-site routes) | **0** | `axe-http-2026-06-05.json` |
| `node scripts/qa/h1-rtl-http-probe.cjs` (38 routes) | **0** | `h1-rtl-http-probe.json` — **38/38** pass |
| `curl -sI /muzza/` · `/muzeh/` + `-L` chain trace | **301** | redirect probe (§5) |
| Cross-link puppeteer probe (7 surfaces + legacy paths) | **0** | `cross-link-probe.json` |
| `git diff 415a64c..HEAD -- ea-tokens.css` | **0 lines** | WP-W2-14 lock baseline unchanged |
| `git diff 1515887..HEAD -- ea-tokens.css` | **0 lines** | post Phase-2 merge unchanged |

---

# §3 CONTENT-ACCURACY — Reproduced on `main` (team_190 live run)

**Generated:** 2026-06-05T20:23:28Z · **Base:** staging · **Script:** `scripts/qa/content-diff.mjs`

**Site rollup (team_190):** simple avg **96.51%** · weighted **98.21%** · **16/16 in-scope gatePass** — **matches team_90 CR-FINAL report exactly**.

| Page | section | sentence | gate | team_90 @ CR-FINAL | team_190 |
|------|---------|----------|------|-------------------|----------|
| `/` | 100% | 100% | **PASS** | match | **match** |
| `/method/` | 100% | 100% | **PASS** | match | **match** |
| `/treatment/` | 100% | 100% | **PASS** | match | **match** |
| `/sound-healing/` | 100% | 100% | **PASS** | match | **match** |
| `/lessons/` | 100% | 100% | **PASS** | match | **match** |
| `/faq/` | 100% | 100% | **PASS** | match | **match** |
| `/muzza` → `/books/` | 100% | 100% | **PASS** | match | **match** |
| `/eyal-amit` → `/about/` | 100% | 100% | **PASS** | match | **match** |
| `/books/vekatavta/` | 100% | 98.28% | **PASS** | match | **match** |
| `/books/kushi-blantis/` | 100% | 95.24% | **PASS** | match | **match** |
| `/books/tsva-bekahol/` | 100% | 96.67% | **PASS** | match | **match** |
| `/didgeridoos/` | 100% | 100% | **PASS** | match | **match** |
| `/bags/` | 100% | 100% | **PASS** | match | **match** |
| `/stands-storage/` | 100% | 92.86% | **PASS** | match | **match** |
| `/stand-floor/` | 100% | 100% | **PASS** | match | **match** |
| `/repair/` | 100% | 100% | **PASS** | match | **match** |
| `/mokesh-dahiman` | 100% | 18.18% | **FAIL** | match — **CR5** | match |

**CR1–CR4 conclusion:** Content-accuracy **holds on merged `main`** — 16/16 PASS reproduced, not assumed from team_90.

Per-page detail: `_COMMUNICATION/team_190/evidence/cr-final-full-site-2026-06-05/content-accuracy/*.json`

---

# §4 No-Regression — WHOLE SITE (38 live routes)

## Horizontal overflow (@360 / @390 / @414 / @768)

| Metric | Result |
|--------|--------|
| Pages × viewports | 38 × 4 = **152** |
| Overflow failures | **0** |
| Tool | `qa_probe.mjs` CDP scrollWidth vs clientWidth |

Routes include elevated chrome surfaces: `/`, `/blog/`, `/contact/`, `/en/`, `/press/`, `/shop/`, learning/commerce clusters, legal pages, memorial chain, and CR book routes under `/books/<slug>`.

## axe-core (WCAG 2A/2AA)

| Metric | Result |
|--------|--------|
| Routes probed | **38** |
| critical / serious | **0 / 0** on all routes |
| Report | `axe-http-2026-06-05.json` |

## HTTP / H1 / RTL

| Check | Result |
|-------|--------|
| HTTP 200 (final document, incl. redirect followers) | **38/38** |
| Single H1 | **38/38** |
| RTL (`html[dir=rtl]`, `lang=he-IL`) on HE routes | **37/37** |
| LTR (`dir=ltr`) on `/en/` | **1/1** |

Evidence: `h1-rtl-http-probe.json`

## D-14 / tokens (WP-W2-14 locked baseline)

| Check | Result |
|-------|--------|
| `ea-tokens.css` diff vs WP-W2-14 Phase-2 lock (`415a64c`) | **0 lines** |
| `ea-tokens.css` diff vs WP-W2-14 merge (`1515887`) | **0 lines** |
| SHA-256 @ `main` HEAD | `2e7ff9f85189cb72fb98486761799823fce3cfde7fb87edafd698e2eb564f7d7` |

---

# §5 Cross-Link / Redirect Integrity

| Check | Expected | team_190 verification | Status |
|-------|----------|------------------------|--------|
| `/muzza/` | **301 → `/books/`** | `Location: …/books/` · final **200** | **PASS** |
| `/muzeh/` | **301 → `/books/`** (mandate) | **301 → `/muzza/` → 301 → `/books/`** · final **200** | **PASS_WITH_FINDING** (2-hop; see F-CRF-02) |
| Nav «מוזה הוצאה לאור» | → `/books` | Primary nav anchor `href=…/books` confirmed on `/` | **PASS** |
| `/books/` book cards | → `/books/<slug>` **200** | `kushi-blantis`, `tsva-bekahol`, `vekatavta` all **200** | **PASS** |
| Live `/muzeh` internal hrefs (main surfaces) | **0 dead** | Sample `/`, `/books/`, `/about/`, `/contact/`, `/blog/`, `/faq/`, `/shop/`: **0** `muzeh` hrefs in rendered HTML | **PASS** |
| Legacy `/muzza/<book>/` paths | resolve, not 404 | `/muzza/kushi-blantis/` etc. → **200** (canonical URL still under `/muzeh/…` namespace) | **PASS_WITH_FINDING** (see F-CRF-03) |

Evidence: `cross-link-probe.json` · inline `curl -sI` traces

---

# §6 Gate-Tool Ratification — Final Cross-Engine Stamp (IR#5)

team_190 independently confirms the calibrated gate stands as canonical **CONTENT-ACCURACY** gate on merged `main`:

| Artifact | Status |
|----------|--------|
| Canon path | `scripts/qa/content-diff.mjs` |
| team_90 frozen CR-FINAL copy | `_COMMUNICATION/team_90/evidence/content-accuracy-cr-final-2026-06-05/content-diff.mjs` |
| Identity vs canon @ validate time | **Identical** (`diff -q` clean) |
| team_90 leg 1 opinion | **RATIFY-WITH-FINDINGS** |
| team_190 build-leg opinion | **RATIFY-WITH-FINDINGS** (`VERDICT_WP-W2-15_L-GATE_VALIDATE_v1.md` §6) |
| **team_190 CR-FINAL leg 2 opinion** | **RATIFY-WITH-FINDINGS — CONFIRMED** |

**Joint constitutional stamp (team_190 + team_90):** No dissent. Seven change groups from 2026-06-04 baseline remain ratified; bar-lowering **none**. Gate owner backlog items (GT-CR-FINAL-01/02) carried as INFO — do not affect `gatePass`.

---

# §7 Findings

## Blocking (P0/P1)

| ID | Severity | Finding | Ruling |
|----|----------|---------|--------|
| — | — | — | **None** |

## Non-blocking (carried / hygiene)

| ID | Severity | Finding | Ruling |
|----|----------|---------|--------|
| F-CRF-01 | **INFO** | Chrome still exposes **duplicate** «מוזה הוצאה לאור» hrefs: primary `…/books` (correct) plus legacy `…/muzza` in footer/drawer cluster. Redirect chain resolves; not a dead link. | **ACCEPTABLE** — Principal one-line revert path documented in findings resolution |
| F-CRF-02 | **INFO** | `/muzeh/` uses **2-hop** 301 (`/muzeh/` → `/muzza/` → `/books/`) vs mandate shorthand “301→/books”. Final document **200** at `/books/`. | **ACCEPTABLE** — functional; optional MU-plugin direct hop in backlog |
| F-CRF-03 | **INFO** | Legacy child URLs `/muzza/<book>/` resolve **200** at `/muzeh/<book>/` namespace; `/books/` cards correctly use `/books/<slug>`. Old namespace coexists, not 404. | **ACCEPTABLE for CR-FINAL** — IA cleanup deferred |
| F-CRF-04 | **P2 — Eyal** | Residual sentence gaps &lt;100% on book pages + `/stands-storage/` (92.86%) — above gate bar; carried from G-W2-15-GT-03 | **Not blocking CR1–CR4** |
| F-CRF-05 | **Deferred** | CR5 `/mokesh-dahiman` content FAIL (18.18% sentence) — BLOCKED on Eyal | **Out of scope** |

---

# §8 Gate Chain + Routing

| Step | Artifact | Status |
|------|----------|--------|
| team_100 merge CR1–CR4 → `main` | `d267b15`+ | Complete |
| team_50 + team_190 dual-PASS (build leg) | L-GATE_QA + L-GATE_VALIDATE | Complete |
| team_90 CR-FINAL leg 1 | `CONTENT-ACCURACY-REPORT-CR-FINAL-2026-06-05.md` | **PASS** |
| team_190 CR-FINAL leg 2 | this document | **PASS_WITH_FINDINGS · 0 blocking** |
| team_50 CR-FINAL E2E leg 3 | pending mandate | **OPEN** |

| Verdict | Route |
|---------|-------|
| **PASS_WITH_FINDINGS** | team_100 → **activate team_50** CR-FINAL full-site E2E (leg 3) |
| Carried | F-CRF-* + GT-CR-FINAL-* → Principal / Eyal / IA backlog |
| HARD RULE | No team_00/Eyal “ready” until **triple-PASS** (team_90 ✓ · team_190 ✓ · team_50 E2E pending) |

---

# §9 Evidence Index

| Artifact | Path |
|----------|------|
| Content-diff summary | `…/content-accuracy/summary.json` |
| Per-page content-diff | `…/content-accuracy/*.json` |
| Overflow probe config | `…/qa_probe_config.json` |
| Overflow probe results | `…/qa_probe_result.json` |
| axe report (38 routes) | `…/axe-http-2026-06-05.json` |
| H1 / RTL / HTTP probe | `…/h1-rtl-http-probe.json` |
| Cross-link / redirect probe | `…/cross-link-probe.json` |
| Gate-tool baseline (team_90) | `_COMMUNICATION/team_90/evidence/content-accuracy-2026-06-04/content-diff.mjs` |
| Gate-tool CR-FINAL freeze | `_COMMUNICATION/team_90/evidence/content-accuracy-cr-final-2026-06-05/content-diff.mjs` |
| team_90 CR-FINAL report | `_COMMUNICATION/team_90/CONTENT-ACCURACY-REPORT-CR-FINAL-2026-06-05.md` |
| H1 probe runner (reusable) | `scripts/qa/h1-rtl-http-probe.cjs` |

---

**Signed:** team_190 · Cursor Composer · 2026-06-05 · IR#5 constitutional cross-engine validation

**Co-signed (gate owner ack):** team_90 · CONTENT-ACCURACY gate · RATIFY-WITH-FINDINGS confirmed per §6
