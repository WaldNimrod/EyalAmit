# PROGRAM PLAN — WP-W2-14 Mobile UI + responsive lock + remaining elevated pages

**Date:** 2026-06-03 · **Author:** team_100 · **Package:** `_COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/` (team_35 FINAL, READY_FOR_S2, D-14 zero-drift)

## 1. What the package delivers (process-map input)
- **Mobile drawer** (side-sheet): full approved 11-item menu, 3 inline accordions, sound+EN utilities, footer links; focus-trap/Esc/scrim/body-lock; RTL **and** LTR (`/en`). Spec: `NAV-DRAWER-SPEC.md`.
- **Canonical nav + footer from `site-tree.json`** (Eyal 2026-04-06) — one source, identical on every template (fixes the explicit review blocker "התפריט לא אחיד"). Replaces all per-template hand-written link lists.
- **§4 decisions** (decided): 3-col comparison→3 stacked cards; shop 4-up→2-col; testimonials→1-col stack (Home→rotator); About timeline→vertical. Alternates toggle via `data-*`.
- **Home review-fixes** (DELTA §B): media rows for sparse text + portrait row + auto-rotator + memorial nowrap.
- **4 new elevated pages:** Method, Memorial-Mokesh, Galleries Catalog, Media Catalog.
- **3 additive files** (the entire mobile layer): `ea-mobile-nav.css`, `ea-mobile-nav.js`, `ea-mobile-variants.css` — injected via 3 `<head>` includes; **no desktop markup changed**.
- All 10 templates: 0 horizontal overflow @360/390/414/768; axe target 0/0; D-14 zero new tokens/atoms/keyframes → **no GCR**.

## 2. Implementation principle (team_35 → WP guidance)
The mockups are **design references, not drop-in code**. In WP: (a) **server-render** the canonical nav+footer from the WP menu/`site-tree.json` (delete per-template lists — DELTA §C.1/2); (b) ship **only the drawer-behaviour JS** (drop the client-side menu-builder + harness `postMessage` — DELTA §C.3); (c) port the CSS as additive theme sheets; (d) keep graceful Eyal-gaps (sound asset, social URLs, studio photo).

## 3. WP series (registered in roadmap, LOD400 specs authored)
| WP | Scope | spec_ref | Blocked by |
|---|---|---|---|
| **WP-W2-14-A** | **Mobile Chrome Foundation** — canonical nav+footer (server-side) + drawer (CSS+JS) + variants + enqueues. PATTERN-SETTER. | `_aos/work_packages/S003/WP-W2-14-A/LOD400_spec.md` | — |
| **WP-W2-14-B** | Existing A/B/E/F mobile pass (§4 per-component) | `…/WP-W2-14-B/LOD400_spec.md` | 14-A |
| **WP-W2-14-C** | Home elevation review-fixes (media rows + rotator) | `…/WP-W2-14-C/LOD400_spec.md` | 14-A |
| **WP-W2-14-D** | Method elevated (new) | `…/WP-W2-14-D/LOD400_spec.md` | 14-A |
| **WP-W2-14-E** | New pages: Memorial + Galleries + Media | `…/WP-W2-14-E/LOD400_spec.md` | 14-A |

## 4. Orchestration (phased — proven model)
- **Phase 1 — 14-A SOLO (pattern-setter):** build the canonical chrome + drawer; take through S3→S4→deploy→S5. Proves the server-side nav/footer + drawer + variants pattern once. **Blocks all others.**
- **Phase 2 — 14-B/C/D/E PARALLEL** (only after A's pattern is deployed + pre-flight-clean): 4 build sub-agents in **isolated git worktrees**, each owning **only its own files** (B=cluster page-CSS; C=tpl-home+rotator; D=method; E=memorial+galleries+media). They inherit chrome from 14-A by the 3 enqueues — they must NOT touch `block-topnav`/`block-footer-social`/`ea-mobile-nav.*` (14-A's).
- **Phase 3 — serialize integration** (3 hard conflict points, as before): (1) merge worktrees one-at-a-time; (2) **FTP deploy serialized** (single staging target); (3) **roadmap single-writer = team_100**. Then per WP: S4 token-compliance → **team_100 pre-flight incl. mockup-vs-live screenshot + 0-overflow probe at 360/390/414/768 + mobile axe/LH** → route Cursor (gate-order **team_50 L-GATE_BUILD PASS before team_190 L-GATE_VALIDATE**).

## 5. Gate chain per WP (strict)
S3 (team_10, Claude) → S4 (team_80 tokens, zero D-14 drift) → deploy (serialized) → team_100 pre-flight → S5 team_50 L-GATE_BUILD → **on PASS** → team_190 L-GATE_VALIDATE (Cursor, cross-engine). **NEW mandatory gate dimension: VISUAL fidelity** (mockup-vs-live screenshot, desktop + 390px mobile) + drawer behaviour + RTL/LTR + 0-overflow — the dimensions structural QA missed last round.

## 6. QA / acceptance (every WP)
axe 0 crit/0 serious (mobile+desktop); LH mobile perf median ≥85, a11y 100; 0 horizontal overflow @360/390/414/768; single H1/route; RTL logical props (F=LTR); D-14 zero new tokens/atoms (team_80 S4); `validate_aos .` 0 FAIL; `php -l` clean; per-route HTTP 200; drawer focus-trap/Esc/scrim/`aria-*`; visual parity vs mockup.

## 7. Standing constraints
ADR034 offline-fallback (named branches, never main; merge on team_00 go); cross-engine IR#1/#5 (Claude builds; team_190 validates in Cursor); surgical per-file commits + `Co-Authored-By: Claude Opus 4.8`; team_191 ARCHIVE_MANIFEST + roadmap DONE/LOD500_LOCKED on dual-PASS per WP.

## 8. Open items (carry into build)
- **קורסים external URL** — placeholder `#`; needs canonical Scholar/external URL (team_00/Eyal).
- **Eyal-gaps:** studio/treatment photo, didgeridoo sound asset, social URLs — graceful placeholders kept.
- **Drawer breakpoint — DECIDED `≤1023px`** (package default; drawer through tablet) 2026-06-03, team_00-default-approved during the final design round. A switch to `≤767` remains a one-line change if team_00 directs before Phase 1. (Resolves spec-validation P2.)
