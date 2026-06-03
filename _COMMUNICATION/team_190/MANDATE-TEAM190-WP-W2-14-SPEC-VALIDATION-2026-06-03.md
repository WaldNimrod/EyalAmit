# MANDATE — External (cross-engine) SPEC validation — WP-W2-14 — team_100 → team_190 — v1.0

**Date:** 2026-06-03 · **From:** team_100 · **To:** team_190 (independent validation) · **ENGINE: Cursor** (cross-engine vs Claude authoring — IR#1/#5) · **Type:** pre-build LOD400/orchestration validation (GATE_2-style)

## What to validate
The WP-W2-14 mobile program **before build** — confirm the specs + orchestration are complete, accurate, implementable by a fresh builder without gaps, and faithful to the team_35 package + the approved IA.

## Inputs (read)
- Package (SSoT): `_COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/` (`README-MOBILE.md`, `NAV-DRAWER-SPEC.md`, `BREAKPOINT-NOTES.md`, `DELTA-AND-FIXES.md`, `mockups/`, `assets/ea-mobile-nav.{css,js}`, `ea-mobile-variants.css`).
- Program plan: `_COMMUNICATION/team_100/WP-W2-14-MOBILE-PROGRAM-PLAN-2026-06-03.md`.
- LOD400 specs: `_aos/work_packages/S003/WP-W2-14-{A,B,C,D,E}/LOD400_spec.md`.
- Approved IA: `hub/data/site-tree.json` (Eyal 2026-04-06) + `_COMMUNICATION/team_10/M2-MENU-PRIMARY-LOCKED-FROM-SITE-TREE-2026-03-29.md`.
- Roadmap entries: `_aos/roadmap.yaml` (WP-W2-14 + A–E).

## Checks (8-point spec validation)
1. **Completeness** — each LOD400 detailed enough for a junior/fresh builder to implement without guessing (files, behaviour, AC, gate chain).
2. **IA fidelity** — the canonical nav (10+3 dropdowns+EN) + footer (19 links) match `site-tree.json` exactly; no page orphaned ("all pages clickable").
3. **Coverage** — all 10 package templates + the §4 decisions + Home fixes + 4 new pages are accounted for across A–E; nothing dropped.
4. **Orchestration soundness** — dependency graph correct (14-A blocks B/C/D/E); parallel WPs own disjoint files (no merge collisions); serialize points (deploy/roadmap/Cursor) identified.
5. **D-14 / a11y / responsive ACs** — zero new tokens/atoms; RTL+LTR; drawer a11y; 0-overflow @360/390/414/768; **visual-fidelity gate present** (the dimension that was missing).
6. **Cross-engine + gate order** — team_50 before team_190; Claude builds, Cursor validates.
7. **Risk/Eyal-gaps** — external courses URL placeholder, sound asset, social URLs, studio photo flagged.
8. **Consistency** — specs ↔ roadmap ↔ program plan agree (paths, blocked_by, spec_ref).

## Output
`_COMMUNICATION/team_190/VERDICT-WP-W2-14-SPEC-VALIDATION-2026-06-03.md` — PASS / PASS_WITH_FINDINGS / FAIL, with any gaps to fix before build. On PASS → team_100 records S2 sign-off and proceeds to the orchestration handoff.
