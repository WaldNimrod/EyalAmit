---
id: VERDICT-WP-W2-14-BCDE-L-GATE-VALIDATE-2026-06-04
from: team_190 (L-GATE_VALIDATE)
to: team_100, team_50, team_10, team_191
type: QA_VERDICT
gate: L-GATE_VALIDATE
date: 2026-06-04
round: 1
engine: cursor-composer (cross-engine; IR#1 + IR#5)
verdict: PASS
blocking_findings: 0
wp: WP-W2-14-B, WP-W2-14-C, WP-W2-14-D, WP-W2-14-E (S003 · Phase 2 build lock)
branch: wp-w2-14-phase2
build_commit: 415a64c284540768b53a90c4349b599b4a44f6d6
staging: http://eyalamit-co-il-2026.s887.upress.link
spec_ref:
  - _aos/work_packages/S003/WP-W2-14-B/LOD400_spec.md
  - _aos/work_packages/S003/WP-W2-14-C/LOD400_spec.md
  - _aos/work_packages/S003/WP-W2-14-D/LOD400_spec.md
  - _aos/work_packages/S003/WP-W2-14-E/LOD400_spec.md
visual_ssot: _COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/
predecessor_flags:
  - _COMMUNICATION/team_100/QA-DISPOSITION-FULL-E2E-2026-06-04.md (team_50 PASS_WITH_FINDINGS · 0 P0 — flag only)
  - team_00 2026-06-04: Eyal-dependent content deferred; not blocking build lock
content_deferred_ref:
  - _COMMUNICATION/team_100/CONTENT-AUDIT-WP-W2-14-VS-EYAL-2026-06-04.md (F1–F9)
  - hub/data/materials-needed.json group H (H1–H9)
---

# VERDICT — WP-W2-14-B/C/D/E Phase 2 build lock | L-GATE_VALIDATE

## §0 Verdict box

| Field | Value |
|-------|-------|
| WP | **WP-W2-14-B, C, D, E** — mobile clusters · Home · Method · Memorial/Galleries/Media |
| Gate | **L-GATE_VALIDATE** (final, constitutional) |
| Scope | **Build / structure / visual / a11y / RTL-LTR** — **not** Eyal content-final |
| Predecessors | team_100 pre-flight **CLEAN** (flag) · team_50 full-site E2E **PASS_WITH_FINDINGS · 0 P0** (flag only; no rationale read pre-verdict) |
| Verdict | **PASS** |
| Blocking (P0/P1) | **0** |
| Cross-engine | Builder Claude Code · Validator Cursor Composer — **satisfied** (IR#1, IR#5) |
| Next | **team_100:** merge `wp-w2-14-phase2` → `main` · mark B/C/D/E **DONE / LOD500_LOCKED** · team_191 archive · keep group **H** + F1–F9 as open Eyal follow-up |

---

## §1 Gate chain

| Step | Artifact / evidence | Status |
|------|---------------------|--------|
| S3 build | branch `wp-w2-14-phase2` · HEAD `415a64c` (theme CSS/JS/compositions for B/C/D/E) | Verified |
| team_00 framing | Content-dependent Eyal items **deferred** — do not block build lock (2026-06-04) | Applied |
| team_50 S5 | Full-site E2E PASS_WITH_FINDINGS · 0 P0 | Flag acknowledged |
| team_100 disposition | Blog 404 false positive · EN footer HE **fixed** · F1–F9 routed group H | Acknowledged |
| S5 validate (this doc) | Independent cross-engine reproduction | **PASS** |
| D-14 | `ea-tokens.css` diff vs `main` | **0 lines** |

---

## §2 Findings (P0 / P1 / non-blocking)

| ID | Severity | Topic | Ruling |
|----|----------|-------|--------|
| — | — | — | **No P0/P1 blocking findings for build lock** |
| F-14BCDE-01 | **Deferred (content)** | Memorial F1–F5 (source, bio lead, edits, dates, IA canonical) | **Not blocking** — sample/scaffold renders; 301 chain → 200; documented H1–H6 |
| F-14BCDE-02 | **Deferred (content)** | `/method` vs `method.md` (F8) | **Not blocking** — elevated composition renders; axe/overflow/H1 pass |
| F-14BCDE-03 | **Deferred (content)** | `/galleries` `/media` mockup samples (F6/F7) | **Not blocking** — honest catalog scaffolding; press `href="#"` in main documented (6/4) |
| F-14BCDE-04 | **Deferred (content)** | Home F9 placeholders (studio figure, sound, hero video) | **Not blocking** — labelled graceful placeholders per `wave2-stage-b.php` |
| F-14BCDE-05 | Non-blocking | Memorial URL chain `/mokesh-dahiman/` → `/about/moksha/` (301×2) | **ACCEPTABLE for build** — both routes 200 · identical title; IA dedup = H6 follow-up |
| F-14BCDE-06 | Non-blocking | Drawer «קורסים» → `#` | **ACCEPTABLE** — documented H9 external URL pending; not broken nav |
| F-14BCDE-07 | Non-blocking | `/en/` uses EN landing template (GP mobile toggle, not full `.ea-mnav` chrome) | **ACCEPTABLE** — inherits 14-A/14-B known pattern; LTR `dir=ltr` · axe 0/0 · overflow 0 · footer HE legal nav **absent** post team_100 fix |
| F-14BCDE-08 | Non-blocking | `validate_aos.sh` Check 32 (_aos/ uncommitted drift) | **Environmental** — local worktree state; **not** a staging deliverable defect |
| F-14BCDE-09 | Non-blocking | Blog permalink P1 (QA-50-F006) | **CLOSED per team_100** — false positive / transient staging |
| F-14BCDE-10 | Non-blocking | Visual mockup delta | Screenshots captured @390+1280; team_35 SSoT spot-check via evidence paths — no structural P0 |

---

## §3 Acceptance criteria (per WP)

### WP-W2-14-B — Mobile clusters (service / editorial / commerce / EN)

| AC | Verdict | Independent evidence |
|----|---------|----------------------|
| Mobile @360/390/414/768 0 overflow | **PASS** | qa_probe 70/70 `overflow:false` on cluster routes |
| Mockup-aligned mobile layout | **PASS** | Screenshots `evidence/wp-w2-14-bcde/screenshots/*` |
| axe 0 crit / 0 serious | **PASS** | 14/14 routes `http-qa-axe.cjs` exit 0 |
| RTL / EN LTR | **PASS** | RTL routes `dir=rtl`; `/en/` `dir=ltr` structural probe |
| D-14 · tokens unchanged | **PASS** | `git diff main...HEAD -- ea-tokens.css` → 0 lines |
| Regression (prior signed routes) | **PASS** | `/treatment/` `/lessons/` `/shop/` `/muzza/` — HTTP 200 · H1=1 · console 0 |

### WP-W2-14-C — Home elevation

| AC | Verdict | Independent evidence |
|----|---------|----------------------|
| Media rows + portrait + rotator present | **PASS** | DOM: `.ea-testimonials-section--rotator` · 5 cards; intro/portrait blocks in theme |
| axe clean (post aria remediation) | **PASS** | `/` crit=0 serious=0 |
| reduced-motion | **PASS** | CSS `@media (prefers-reduced-motion)` in `home-front.css` + `ea-testimonials.js` pattern |
| 0 overflow mobile | **PASS** | `/` all viewports in probe matrix |
| Placeholders honest | **PASS** | Labelled studio placeholder per spec; F9 documented |

### WP-W2-14-D — Method elevated

| AC | Verdict | Independent evidence |
|----|---------|----------------------|
| `/method/` elevated composition (no bare fallback) | **PASS** | HTTP 200 · H1=1 · non-empty service render |
| Mobile 2→1 grid / overflow | **PASS** | probe @390/768 |
| Content vs `method.md` | **DEFERRED** | F8 — not build-blocking per team_00 |
| axe / D-14 | **PASS** | axe 0/0 · tokens unchanged |

### WP-W2-14-E — Memorial + Galleries + Media

| AC | Verdict | Independent evidence |
|----|---------|----------------------|
| Three routes HTTP 200 | **PASS** | `/mokesh-dahiman/` (final 200 via chain) · `/galleries/` · `/media/` · `/about/moksha/` |
| Elevated layout / dignified scaffold | **PASS** | Memorial H1 «מוקש דהימן — על השם»; catalog titles render; no TBD/CDIP in probe |
| Sample placeholders documented | **PASS** | F6/F7 + hub H7/H8; press `#` counted, not broken 404 |
| axe / overflow / H1 | **PASS** | All E routes in axe + probe matrices |
| Content-final (Eyal) | **DEFERRED** | F1–F5 group H — not this gate |

---

## §4 Validator reproduction (2026-06-04)

```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026"

# A11y — B/C/D/E scope (14 routes)
node scripts/qa/http-qa-axe.cjs --base http://eyalamit-co-il-2026.s887.upress.link \
  / /treatment/ /method/ /sound-healing/ /lessons/ /eyal-amit/ \
  /muzza/ /muzza/kushi-blantis/ /shop/ /en/ /galleries/ /media/ \
  /mokesh-dahiman/ /about/moksha/

# Overflow + screenshots (14 pages × 5 viewports = 70)
node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs \
  --config _COMMUNICATION/team_190/evidence/wp-w2-14-bcde/qa_probe_config.json \
  --out _COMMUNICATION/team_190/evidence/wp-w2-14-bcde --shots

# Structural spot (H1, console, dir) — from scripts/qa (puppeteer-core)
# → _COMMUNICATION/team_190/evidence/wp-w2-14-bcde/structural-check.txt

# D-14
git rev-parse HEAD
git diff main...HEAD -- site/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css

# Governance (advisory)
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .

# Memorial chain
curl -sI -L "http://eyalamit-co-il-2026.s887.upress.link/mokesh-dahiman/"
```

| Command | Exit | Result |
|---------|------|--------|
| `http-qa-axe.cjs` (14 routes) | **0** | 14/14 crit=0 serious=0 |
| `qa_probe.mjs` | **0** | 70/70 failures=0 |
| Structural probe (8 routes) | **0** | H1=1 · console errors=0 on all |
| `ea-tokens.css` diff | — | **0 lines** |
| `validate_aos.sh` | **1** | Check 32 only — uncommitted `_aos/` local drift (F-14BCDE-08) |
| MCP `cursor-ide-browser` @390 | — | `/` drawer open/close **PASS**; `/en/` LTR footer EN-only (no HE legal strip) |
| Memorial `curl -sI -L` | — | 301×2 → `/about/moksha/` **200** |

**Evidence paths:** `_COMMUNICATION/team_190/evidence/wp-w2-14-bcde/` (axe JSON, probe stdout, screenshots, structural-check.txt).

---

## §5 Routing

| Verdict | Route |
|---------|-------|
| **PASS** | **team_100:** merge `wp-w2-14-phase2` → `main` · WP-W2-14-B/C/D/E → **DONE / LOD500_LOCKED** · team_191 **ARCHIVE_MANIFEST** |
| **PASS** | **Do not** hold merge for F1–F9 / group H — remain open Eyal content follow-up |
| Carry-forward | team_00/Eyal: H1–H9 answers · team_10: F8 `method.md` reconcile · IA: memorial canonical URL (H6) · team_10: drawer H9 URL when known |

---

## Identity header

| Field | Value |
|-------|-------|
| team_id | team_190 |
| role | Senior Constitutional Validator |
| gate | L-GATE_VALIDATE |
| wp_id | WP-W2-14-B, WP-W2-14-C, WP-W2-14-D, WP-W2-14-E |
| engine | cursor-composer |
| date | 2026-06-04 |

*Issued by team_190 · L-GATE_VALIDATE · WP-W2-14-B/C/D/E build lock · 2026-06-04 · independent cross-engine validation.*
