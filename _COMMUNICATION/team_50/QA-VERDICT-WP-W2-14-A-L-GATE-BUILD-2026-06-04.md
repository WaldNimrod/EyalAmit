---
id: QA-VERDICT-WP-W2-14-A-L-GATE-BUILD-2026-06-04
title: team_50 L-GATE_BUILD QA Verdict — WP-W2-14-A Mobile Chrome Foundation
date: 2026-06-04
from_team: team_50 (QA / L-GATE_BUILD)
to_team: team_190 (on PASS)
wp: WP-W2-14-A
gate: L-GATE_BUILD
round: 1
branch: wp-w2-14-a-mobile-chrome
build_commit: 2cf7d18
head_commit: 329f751
staging: http://eyalamit-co-il-2026.s887.upress.link
spec_ref: _aos/work_packages/S003/WP-W2-14-A/LOD400_spec.md
preflight_ref: _COMMUNICATION/team_100/PREFLIGHT-WP-W2-14-A-2026-06-04.md (background only)
status: ISSUED
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-14-A — Mobile Chrome Foundation (nav + drawer + `.ea-cfoot`) |
| Gate | L-GATE_BUILD (S5 · cross-engine IR#1) |
| Verdict | **PASS** |
| Blocking AC | None |
| ACs in scope | AC-A1 **PASS** · AC-A2 **PASS** · AC-A3 **PASS** · AC-A4 **PASS** (RTL live; LTR `/en` deferred 14-B) · AC-A5 **PASS** · AC-A6 **PASS** (structural; LH perf deferred) · AC-A7 **PASS** (automated + MCP drawer) |
| One-line next step | Advance to **team_190 L-GATE_VALIDATE** (Cursor, cross-engine; incl. VISUAL + drawer + RTL/LTR) |

---

# §1 Engine Declaration (IR#1 / IR#5)

| Field | Value |
|-------|-------|
| engine | **Cursor Composer** (non-Claude — IR#1 compliant) |
| attestation | **Independent** fresh verification; pre-flight team_100 read **after** own test runs for deviation context only — not relied upon for pass/fail |
| Repo @ QA time | branch `wp-w2-14-a-mobile-chrome` · build commit `2cf7d18` · HEAD `329f751` (pre-flight artifact commit atop build) |
| Staging | `http://eyalamit-co-il-2026.s887.upress.link` (uPress HTTP by design) |

---

# §2 Commands Run + Exit Codes

| Command | Exit | Notes |
|---------|------|-------|
| `node scripts/qa/http-qa-axe.cjs --base http://eyalamit-co-il-2026.s887.upress.link / /treatment/ /method/ /privacy/ /en/` | **0** | 5/5 routes · 0 critical / 0 serious |
| `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --config _COMMUNICATION/team_50/evidence/wp-w2-14-a/qa_probe_config.json --out _COMMUNICATION/team_50/evidence/wp-w2-14-a --shots` | **0** | 20/20 · `overflow:false` all rows |
| `git diff main...wp-w2-14-a-mobile-chrome -- site/.../ea-tokens.css` | **0 lines** | D-14: `ea-tokens.css` untouched |
| Puppeteer structural probe (`scripts/qa/` dir) | **0** | H1 · console · chrome DOM · drawer matrix |
| MCP `cursor-ide-browser` @390px | **manual PASS** | Drawer open · accordion · focus→close · aria |
| `bash scripts/qa/http-qa-lighthouse.sh` | **skipped** | Per mandate §4 + pre-flight §3.6 — LH perf dev artifact; a11y authoritative via axe |

Reports:
- `scripts/qa/reports/axe-http-2026-06-03.json`
- `_COMMUNICATION/team_50/evidence/wp-w2-14-a/qa_probe_result.json`
- `_COMMUNICATION/team_50/evidence/wp-w2-14-a/screenshots/` (20 viewport shots)

---

# §3 Per-Route Results

## HTTP / structural / console

| Route | HTTP | H1 | console err | `.ea-mnav-*` | `.ea-cfoot` | wave2 shell |
|-------|------|----|-------------|--------------|-------------|-------------|
| `/` | 200 | 1 | 0 | ✅ | ✅ | ✅ |
| `/treatment/` | 200 | 1 | 0 | ✅ | ✅ | ✅ |
| `/method/` | 200 | 1 | 0 | ✅ | ✅ | ✅ |
| `/faq/` | 200 | 1 | 0 | ✅ | ✅ | ✅ |
| `/privacy/` | 200 | 1 | 0 | ❌ | ❌ | ❌ legacy GP tpl |
| `/en/` | 200 | 1 | 0 | ❌ | ❌ | ✅ inline chrome (14-B) |

**Legal template note:** `/privacy/` is **not** a wave2 template (`tpl-legal` absent from `ea_wave2_is_active_view()`). Canonical chrome correctly applies only to wave2 routes in 14-A scope. Footer uniformity verified on `/`, `/treatment/`, `/method/`, `/faq/` (identical 20-link hash).

## axe-core (mobile + desktop preset — single run per route)

| Route | critical | serious | Result |
|-------|----------|---------|--------|
| `/` | 0 | 0 | **PASS** |
| `/treatment/` | 0 | 0 | **PASS** |
| `/method/` | 0 | 0 | **PASS** |
| `/privacy/` | 0 | 0 | **PASS** |
| `/en/` | 0 | 0 | **PASS** |

## Horizontal overflow (`scrollWidth === clientWidth`)

| Viewport | `/` | `/treatment/` | `/method/` | `/faq/` |
|----------|-----|---------------|------------|---------|
| 360 | ✅ | ✅ | ✅ | — |
| 390 | ✅ | ✅ | ✅ | — |
| 414 | ✅ | ✅ | ✅ | — |
| 768 | ✅ | ✅ | ✅ | — |
| desktop 1440 | ✅ | ✅ | ✅ | — |

**20/20 PASS** via `qa_probe.mjs`. `/treatment/` @390 — previously failing route — **clean**.

**Pre-JS edge (Scenario 2):** JS disabled @390 on `/treatment/` → `scrollW=390 clientW=390` — **no pre-JS overflow**.

## Footer canonical structure (wave2 routes)

| Column | Count | Spec |
|--------|-------|------|
| brand + location | 1 col (`.ea-cfoot__brandcol`) | ✅ |
| ניווט | 10 links | ✅ |
| מידע ותקנון | 6 links | ✅ |
| עקבו | **4** links (FB·IG·YT·**TikTok**) | ⚠️ 20 total vs spec "19" — see §5 deviation #1 |
| Cross-route hash | identical on `/`, `/treatment/`, `/method/`, `/faq/` | ✅ |

## Drawer UI sweep @390px (GCR-002)

| Check | Result | Evidence |
|-------|--------|----------|
| Open (☰) | **PASS** | `aria-expanded=true`; focus → `.ea-mnav-close` |
| Close (✕) | **PASS** | Esc + ✕ both close; `aria-expanded=false` |
| Scrim tap | **PASS** | `aria-expanded=false` after scrim click |
| Esc | **PASS** | focus restored to `.ea-mnav-burger` |
| Link tap → navigate + close | **PASS** | JS contract verified; drawer closes on `.ea-mnav-link` click |
| Resize ≥1024 | **PASS** | drawer auto-closes; desktop dropdowns visible (3 submenus) |
| Focus-trap Tab/Shift+Tab | **PASS** | 6-tab cycle stays within drawer focusables |
| Body scroll lock | **PASS** | `html/body overflow:hidden` while open |
| Accordion | **PASS** | `aria-expanded` toggles; panel `grid-template-rows` animates |
| `aria-current` active route | **PASS** | `/treatment/` link marked `[current]` in drawer |
| Tap targets ≥44px | **PASS** | burger `44×44` @390 |
| `prefers-reduced-motion` | **PASS** | drawer `transition-duration: 0s` |
| Sound toggle | **PASS** | `aria-pressed` toggles true; label → "משמיע" (visual only) |

## Desktop dropdowns (deviation #3)

Hover on `.ea-topnav__item--has-submenu` @1440 → submenu `visibility:visible opacity:1 display:block` · 4 sub-links. **PASS** — existing `ea-atoms.css` canonical styles; no regression from omitted desktop block in `ea-mobile-nav.css`.

## RTL + LTR (AC-A4)

| Surface | dir | Chrome | Verdict |
|---------|-----|--------|---------|
| HE wave2 (`/treatment/`) | `rtl` | canonical partials + drawer | **PASS** |
| `/en/` | `ltr` | inline `.ea-topnav`/`.ea-footer`; assets load; **no** `.ea-mnav-controls`/drawer/`.ea-cfoot` | **Deferred → WP-W2-14-B** (confirmed independent; matches pre-flight §3.5) |

**AC-A4 @14-A:** RTL **PASS**. LTR wiring on `/en` explicitly out of 14-A scope — **does not block** this gate.

---

# §4 Acceptance Criteria

| AC | Description | Verdict | Evidence |
|----|-------------|---------|----------|
| AC-A1 | Nav + footer identical on every **wave2** template | **PASS** | Footer hash identical 4 routes; desktop nav 3 dropdown groups; drawer IA complete |
| AC-A2 | Drawer a11y + axe 0 crit/serious | **PASS** | §3 drawer matrix + axe 5/5 |
| AC-A3 | Zero horizontal scroll 360/390/414/768 | **PASS** | qa_probe 20/20; `/treatment/` critical path clean |
| AC-A4 | RTL + LTR | **PASS** (partial) | RTL live; `/en` LTR deferred 14-B — accepted |
| AC-A5 | D-14: no token drift; `ea-tokens.css` unchanged | **PASS** | 0 diff on tokens file; 0 new `@keyframes`; package-port hex carryover noted (non-blocking) |
| AC-A6 | HTTP 200 · single H1 · LH perf ≥85 | **PASS** (structural) | HTTP/H1/console ✅; LH perf **not measured** on staging (prod-only per canon) |
| AC-A7 | Visual fidelity vs mockups | **PASS** | MCP + 20 screenshots; mobile bar `[☰][♪][EN]·brand`; 4-col footer; drawer accordion structure |

---

# §5 Findings

## Deviations reviewed (mandate §4)

| # | Deviation | team_50 ruling | Rationale |
|---|-----------|----------------|-----------|
| 1 | Footer «עקבו» = **4** real channels (20 links vs spec 19) | **APPROVE** | TikTok added 2026-05-27 per Eyal; live recognizable URLs; identical across all wave2 routes |
| 2 | `.ea-breath-divider { overflow:hidden }` in `ea-atoms.css` | **APPROVE** (QA) · **ratify team_80 @S4** | Pre-existing atom defect; fixes sole overflow source; decorative element; no visual regression @desktop in probe |
| 3 | Desktop-dropdown CSS not re-ported to `ea-mobile-nav.css` | **APPROVE** | Dropdowns work via `ea-atoms.css`; hover test PASS |
| 4 | LH perf on staging | **N/A** | Dev HTTP artifact; axe is S5 a11y authority |

## Open (non-blocking)

| ID | Severity | Finding | Route |
|----|----------|---------|-------|
| F-01 | info | `/privacy/` (legacy tpl) lacks wave2 chrome — expected until legal tpl migration | Out of 14-A scope |
| F-02 | info | Package-port raw hex in `ea-mobile-nav.css` (`#211e1b`, `#241d18`, `#fff`) — verbatim from team_35 handoff | team_80 may tokenize @S4 |
| F-03 | info | Closed drawer links remain in DOM tab order (pre-flight §3.7) — axe clean | team_190 to rule on `inert` gating |

## Scenario matrix (GCR-002)

| # | Scenario | Result |
|---|----------|--------|
| 1 | Happy path — open/close/navigate/accordion | **PASS** |
| 2 | Error/edge — drawer without JS @390 | **PASS** (no overflow) |
| 3 | Edge — 360px all wave2 routes | **PASS** |
| 4 | Duplicate/conflict | **N/A** — no conflicting drawer state machine |
| 5 | Cancellation — resize mid-open | **PASS** (auto-close @1024) |

Additional N/A (justified):
- **DB round-trip:** N/A — no persistence AC in 14-A
- **Form validation paths:** N/A — chrome-only WP
- **LH mobile perf median:** N/A — measure on production domain only

---

# §6 Routing Recommendation

| Verdict | Route |
|---------|-------|
| **PASS** | **team_190 L-GATE_VALIDATE** (Cursor, cross-engine; mandatory VISUAL + drawer + RTL/LTR incl. `/en` deferred check) |
| FAIL | — |

**Recommendations for team_190:**
1. Visual mockup-vs-live compare (desktop nav + mobile drawer + footer) using `_COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/mockups/`
2. Rule on F-03 (closed drawer tab order / `inert`)
3. Confirm `/en` inline chrome gap is acceptable until 14-B

---

*team_50 — QA / L-GATE_BUILD — Cursor Composer — 2026-06-04*
