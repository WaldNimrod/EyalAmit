# REMEDIATION MATRIX — WP-W2-14 spec-validation findings (Phase 3.5) — team_100 — v1.0

**Date:** 2026-06-03 · **Against:** `_COMMUNICATION/team_190/VERDICT-WP-W2-14-SPEC-VALIDATION-2026-06-03.md` (PASS_WITH_FINDINGS, 0 blocking) · **Goal:** team_00 requires **full GREEN (clean PASS)** before client submission → all findings FIXED, re-submitted.

| # | Sev | Finding | Status | Fix location |
|---|---|---|---|---|
| F1 | **P2** | Drawer breakpoint — confirm ≤1023 vs ≤767 before Phase 1 | **FIXED (DECIDED ≤1023)** | WP-W2-14-A §6 + program-plan §8: pinned `≤1023px` (package default), team_00-default-approved; one-line switch documented |
| F2 | P3 | 14-B: add explicit route/CSS table for cluster pages | **FIXED** | WP-W2-14-B §5: route ↔ CSS-sheet ownership table added |
| F3 | P3 | 14-D: pin method → tpl-service via wave2-w2-02.php (remove OR-ambiguity) | **FIXED** | WP-W2-14-D §5: method routing pinned to existing `wave2-w2-02.php` template_include; no new template |
| F4 | P3 | Harmonize QA AC text across child specs | **FIXED** | Uniform QA AC block added to WP-W2-14-B/C/D/E §5 (validate_aos 0 FAIL · php -l · HTTP 200 · axe 0/0 · LH mobile median ≥85 / a11y 100 · 0-overflow @360/390/414/768 · single H1 · RTL/LTR · D-14 zero-drift · visual screenshot gate) |
| F5 | P3 | wave2-stage-b.php merge rule for Phase 2 (C must not touch enqueues) | **FIXED** | WP-W2-14-A §6 (14-A owns the 3 enqueues) + WP-W2-14-C §5 (C edits only home render fn/blocks; never the enqueue lines) |
| F6 | P3 | Desktop "בית" vs drawer home — one-line implementation guard | **FIXED** | WP-W2-14-A §6: desktop home = logo-only (no "בית" text item); drawer home = explicit labelled link #1 (intentional, per NAV-DRAWER-SPEC §3) |

**OPEN:** none. **WAIVED:** none. All 6 findings FIXED. No scope change (breakpoint = package default; courses URL remains a flagged Eyal-gap, not a spec defect).

## Re-submission
Per GATE_MANDATE Phase 3.5 (no validator routing while OPEN findings exist — none remain), re-submitting to **team_190 (Cursor)** for a clean re-validation verdict. Mandate: `_COMMUNICATION/team_190/MANDATE-TEAM190-WP-W2-14-SPEC-VALIDATION-2026-06-03.md` (same checks); expect **PASS** (no findings). On clean PASS → team_100 records S2 + activates the orchestration handoff.

Updated tree to validate against: `<post-remediation commit>` (see push). Files changed: `_aos/work_packages/S003/WP-W2-14-{A,B,C,D,E}/LOD400_spec.md`, `_COMMUNICATION/team_100/WP-W2-14-MOBILE-PROGRAM-PLAN-2026-06-03.md`.
