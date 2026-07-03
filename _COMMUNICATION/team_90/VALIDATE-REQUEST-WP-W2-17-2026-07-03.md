# VALIDATE-REQUEST — WP-W2-17 — team_110 → team_90 — v1.0.0

**Date:** 2026-07-03
**From:** team_110 (execution mandate, ADR045 — engine: claude-code)
**To:** team_90 (L-GATE_VALIDATE — CR-FINAL leg-1 re-audit)
**WP:** WP-W2-17 — CR-FINAL remediation + SEO/GEO ratified execution
**Type:** VALIDATE-REQUEST (cross-engine, Iron Rule #1: builder=claude-code, validator=cursor)

## Request

T1–T9 executed, self-verified, and closed. Full detail: `_COMMUNICATION/team_110/WP-W2-17/COMPLETION_REPORT_WP-W2-17_v1.0.0.md`. Requesting the CR-FINAL leg-1 re-audit against this build:

1. **Content-diff** (T1) — brand-string normalization ratification. Re-run `content-diff.mjs`; expect `/eyal-amit/` at 100%/100%, 17/17 measured gate-pass.
2. **Image re-audit** (T2) — classification table in the report; only 3 mapping-gap + 2 content-gap items remain (routed to team_100, not fixed on-page). Re-running `image-audit.cjs` should now show the 19 broken-img findings resolved; the 9 missing-slot findings should still show (expected — they're routed to team_100 for a content decision, not silently closed).
3. **seo_probe.mjs ratification** (T7) — new file, implements Appendix B's 12 checks with 2 ratified supersessions (10-UA list, no-Service on `/method/`) plus 2 bugs found+fixed during this WP's own live testing (hreflang over-scoping, og:image dup on `/books/kushi-blantis/`). **Please re-run it against staging** — this builder could not get a single clean exit-0 run due to persistent host connectivity flakiness (see report §0/§7); if the host is stable during your re-audit it should complete cleanly.
4. **Image-picker thumb-load/localStorage spot-check** — the prior report's carried finding; not touched by this WP, please re-confirm as part of the standard re-audit sweep.

## Known host condition (please account for it in your own verification)

The uPress staging host showed intermittent connectivity throughout this build (FTP timeouts requiring retry; single-shot HTTP requests to the same URL alternating between 200/404/timeout, stabilizing only after 3–6 retries with cache-busting). Recommend retry-tolerant verification rather than single-shot checks where results look surprising.

## Not requested

No "ready" signal to Eyal — per AC-011, that only follows the full triple-PASS chain (this leg → team_190/50 → team_00).
