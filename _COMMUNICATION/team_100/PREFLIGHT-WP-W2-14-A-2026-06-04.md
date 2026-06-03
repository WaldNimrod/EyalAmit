# team_100 PRE-FLIGHT — WP-W2-14-A (Mobile Chrome Foundation)

**Date:** 2026-06-04 · **Author:** team_100 (build-orchestration session) · **WP:** WP-W2-14-A (Phase 1, SOLO pattern-setter)
**Branch:** `wp-w2-14-a-mobile-chrome` · **Staging:** http://eyalamit-co-il-2026.s887.upress.link (uPress, HTTP by design)
**Verdict:** ✅ **PRE-FLIGHT CLEAN** — ready for S5 cross-engine routing (team_50 L-GATE_BUILD → team_190 L-GATE_VALIDATE). **HELD at user instruction: do not route to Cursor until go.**

---

## 1. What was built (S3 → S4)
Canonical site chrome + mobile drawer, server-rendered from the locked site-tree SSoT. 7 files (6 planned + 1 pre-existing-overflow remediation):

| File | Change |
|---|---|
| `template-parts/blocks/block-topnav.php` | + `.ea-mnav-*` closed-bar cluster (burger·sound·EN, `≤1023`) + server-rendered side-sheet drawer (home + 10 items + 3 accordions + 7 sub-links + foot utils/6 links), built from the same `$ea_topnav_items` model. Desktop nav unchanged. Drawer carries explicit `בית` #1; desktop home stays logo-only (LOD400 §6 P3). |
| `template-parts/blocks/block-footer-social.php` | Rewritten to the canonical `.ea-cfoot` 4-col grid (brand+location · ניווט(10) · מידע ותקנון(6) · עקבו(4)) + divider + copy. |
| `assets/css/ea-mobile-nav.css` | **NEW** — ported drawer/controls/scrim/accordion/foot (`≤1023`) + `.ea-cfoot`. Desktop-dropdown block intentionally omitted (see §3.1). + per-dir slide-sign default (see §3.3). |
| `assets/css/ea-mobile-variants.css` | **NEW** — §4 decisions ported verbatim (comparison→cards, shop→2col, testimonials→stack). |
| `assets/js/ea-mobile-nav.js` | **NEW** — drawer behaviour only (open/close, burger morph, accordion `aria-expanded`, focus-trap, Esc, scrim/outside-tap, focus restore, body-lock, dir-aware slide sign, resize auto-close, sound pills). Menu-builder + postMessage harness dropped (DELTA §C.3). |
| `inc/wave2-stage-b.php` | Enqueue the 3 assets (CSS after `ea-atoms`; JS deferred). **14-A-owned block** — children must not edit (LOD400 §6 P3). |
| `assets/css/ea-atoms.css` | **breath-divider overflow remediation** — `overflow:hidden` on `.ea-breath-divider` (see §3.4). **team_80 to ratify at S4.** |

Per-file surgical commits on the named branch (`Co-Authored-By: Claude Opus 4.8`). ADR034 offline-fallback: branch held, merge to main on team_00 go.

## 2. Gate results (all green)
| Check | Result |
|---|---|
| `php -l` (3 PHP) | ✅ no syntax errors |
| `validate_aos .` | ✅ 30 PASS / 18 SKIP / **0 FAIL** |
| D-14 token drift | ✅ `ea-tokens.css` untouched; 0 new tokens; 0 new `@keyframes`; all `--ea-*` references resolve |
| HTTP per-route | ✅ 200 on `/`, `/treatment`, `/method` |
| **axe (mobile+desktop)** | ✅ **0 critical / 0 serious** on `/`, `/treatment`, `/method` (report `scripts/qa/reports/axe-http-2026-06-03.json`) |
| **0 horizontal overflow** @360/390/414/768 + desktop | ✅ **15/15 pass** (`scrollWidth===clientWidth`) after the breath-divider fix |
| **Drawer behaviour** | ✅ open/close · burger morph · focus→close · focus-trap · body-scroll-lock · accordion toggle · Esc close + focus restore · scrim-tap close · `aria-current` active marker |
| **Visual fidelity** (mockup vs live) | ✅ desktop nav uniform + dropdowns work; mobile bar `[☰][♪שמע][EN]·brand`; drawer high-fidelity to NAV-DRAWER-SPEC (incl. `קורסים חיצוני ↗`); canonical 4-col footer. Evidence: `evidence/wp-w2-14-a/screenshots/` |
| RTL | ✅ verified live (HE pages, `dir=rtl`) |
| LTR | Code-path dir-agnostic (logical props + per-dir slide sign). EN-PAGE wiring is 14-B (see §3.5). |

**Acceptance:** AC-A1 ✅ · AC-A2 ✅ · AC-A3 ✅ (after §3.4) · AC-A4 ✅ (RTL live; LTR code-path — EN page 14-B) · AC-A5 ✅ · AC-A6 ✅ (LH perf — see §3.6) · AC-A7 ✅.

## 3. Decisions & deviations (for team_50 / team_190 / team_80 / team_00)
**3.1 Desktop-dropdown CSS not re-ported.** The source `ea-mobile-nav.css` re-implemented the desktop dropdowns under alternate classes (`.ea-topnav__has-sub`/`.ea-topnav__sub`). The live theme already renders the canonical, uniform desktop nav server-side (`block-topnav.php`) and styles it in `ea-atoms.css` (`.ea-topnav__item--has-submenu`/`__submenu`). Re-porting would be dead CSS and/or regress the signed-off desktop dropdowns. Verified working (screenshot `zoom_desktop_dropdown.png`).

**3.2 Footer "עקבו" = 4 real channels (FB·IG·YT·TikTok), not the package's 3 placeholder text links → 20 footer links, not the spec's "19".** TikTok was added 2026-05-27 per Eyal, after the team_35 package was authored. Kept the real, recognizable social atoms with live URLs (no regression). Intentional, surfaced for ratification.

**3.3 Pre-JS off-canvas slide-sign fix (my chrome).** The closed drawer used the CSS fallback `--ea-mnav-tx:100%`, which slid a closed RTL drawer toward the viewport (~281px off-screen-right) until the deferred JS computed `-100%`. Added `html[dir="rtl"]{--ea-mnav-tx:-100%}` / `[dir="ltr"]{100%}` so first paint is correct without JS; JS still overrides for dynamic side switching.

**3.4 breath-divider overflow — PRE-EXISTING atom defect, remediated under 14-A; team_80 to ratify.** `.ea-breath-divider__line` animates `breathe-slow scaleX(1.15)`; at `<960px` the line is `width:100%` of the viewport, so the scale bled ~29px past each edge → page-wide horizontal overflow (411px @390) on every divider page. **Sole overflower; NOT introduced by 14-A chrome.** Fix: `overflow:hidden` on `.ea-breath-divider` (decorative `aria-hidden` 1px line; opacity-breathe retained; desktop already fit). Edit lands in the shared atom sheet — **team_80 S4 ratification requested.**

**3.5 EN landing (`tpl-en-landing.php`) chrome wiring → 14-B.** The EN template renders its own inline `.ea-topnav`/`.ea-footer` (not the shared partials). The 3 mobile assets DO load there (enqueue covers it) and the JS/CSS are dir-agnostic, but the EN page has no server-rendered `.ea-mnav-controls`/drawer/`.ea-cfoot` yet. Adding them is in 14-B's scope ("existing A/B/E/F mobile pass"). 14-A establishes the inheritable pattern.

**3.6 LH perf deferred to production.** Dev/staging is HTTP with noindex edge headers + cache misses → LH perf is an artifact (CLAUDE.md dev-QA discipline). a11y=100 corroborated by axe 0/0. Re-measure perf on the production domain.

**3.7 Minor a11y observation (for team_190 to rule).** The closed off-canvas drawer's links remain in the DOM/tab order (focus-trap only engages when open) — matches the team_35 design as-shipped; axe flags nothing crit/serious. Flagged for the cross-engine a11y review to confirm acceptable or request `inert`/`visibility` gating.

## 4. Next (HELD)
Phase 1 build + deploy + pre-flight COMPLETE and CLEAN. **Awaiting go to route Cursor** (gate-order team_50 L-GATE_BUILD → team_190 L-GATE_VALIDATE, incl. VISUAL + mobile-drawer + RTL/LTR). On dual-PASS: team_191 ARCHIVE_MANIFEST → roadmap DONE/LOD500_LOCKED → **then Phase 2 (14-B/C/D/E parallel worktrees) unblocks.**
