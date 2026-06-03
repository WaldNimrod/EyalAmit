# HANDOFF → team_100 (next session) — WP-W2-14 Mobile orchestration

**Date:** 2026-06-03 · **From:** team_100 (this session) · **To:** team_100 (build-orchestration session) · **Gate state:** specs authored + registered; pending external (Cursor) spec-validation + S2.

## Mission
Implement the team_35 mobile package end-to-end via the **phased orchestration**, per the program plan and the 5 LOD400 specs. Same model proven on WP-W2-10 (foundation → parallel fan-out → serialized integration → cross-engine validate → close).

## Preconditions (verify at startup)
1. `_aos/roadmap.yaml` WP-W2-14 + A–E present; DB probe; `validate_aos .` 0 FAIL.
2. **External spec-validation PASS** — `_COMMUNICATION/team_190/VERDICT-WP-W2-14-SPEC-VALIDATION-2026-06-03.md` (team_190/Cursor). If FAIL/findings → remediate specs first.
3. Confirm **S2 sign-off** for the mobile tier (team_00 proxy ok — package READY_FOR_S2).
4. Resolve **drawer breakpoint** (≤1023 vs ≤767 — DELTA §C.7) and **קורסים external URL** with team_00 (or proceed with documented defaults: ≤1023 + `#` placeholder).

## Execution (phased)
- **Phase 1 — WP-W2-14-A SOLO (pattern-setter):** build canonical server-side nav+footer (delete per-template lists) + port `ea-mobile-nav.css` + drawer-behaviour JS (NOT client menu-builder / NOT harness postMessage) + `ea-mobile-variants.css` + enqueues. S3→S4→deploy→team_100 pre-flight (axe http + LH https + **mockup-vs-live screenshot desktop+390px** + 0-overflow probe + drawer focus-trap/Esc/scrim + RTL/LTR)→route Cursor (team_50→team_190). **Do not start Phase 2 until 14-A is deployed + pre-flight-clean.**
- **Phase 2 — WP-W2-14-B/C/D/E PARALLEL:** 4 team_10 build sub-agents, **isolation: worktree**, each owning only its files (B=cluster page-CSS; C=tpl-home+rotator JS; D=method; E=memorial+galleries+media). Inherit chrome from 14-A. Must NOT touch `block-topnav`/`block-footer-social`/`ea-mobile-nav.*`.
- **Phase 3 — serialize:** merge worktrees one-at-a-time → **deploy serialized** (one cluster at a time) → S4 per WP → team_100 pre-flight per WP (incl. mobile screenshots) → route Cursor gate-order team_50→team_190 (incl. **VISUAL + mobile + RTL/LTR**). Close each WP on dual-PASS (team_191 ARCHIVE_MANIFEST → roadmap DONE/LOD500_LOCKED) → merge to main on team_00 go.

## Hard rules
- D-14 zero new tokens/atoms (team_80 S4); RTL logical props (F=LTR); `validate_aos .` 0 FAIL + `php -l` clean each step; surgical per-file commits (`Co-Authored-By: Claude Opus 4.8 <noreply@anthropic.com>`); ADR034 offline-fallback (named branches; merge on team_00 go); roadmap single-writer = team_100.
- **VISUAL fidelity is a gate now** (lesson WP-W2-10): every page gets a mockup-vs-live screenshot compare (desktop + 390px) + 0-overflow probe before it can pass.

## Key refs
Program plan `_COMMUNICATION/team_100/WP-W2-14-MOBILE-PROGRAM-PLAN-2026-06-03.md` · specs `_aos/work_packages/S003/WP-W2-14-{A..E}/LOD400_spec.md` · package `_COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/` · IA `hub/data/site-tree.json` · prior chrome remediation `_COMMUNICATION/team_100/CHROME-NAV-REMEDIATION-DONE-2026-06-03.md` (14-A supersedes the interim nav).
