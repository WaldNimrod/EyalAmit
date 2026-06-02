# MANDATE — L-GATE_VALIDATE — WP-W2-10 A/B/E/F — team_100 → team_190 — v1.0

**Date:** 2026-06-03
**From:** team_100 (orchestrator) · **To:** team_190 (final validation — constitutional, immutable, IR#5)
**Engine constraint (IR#1/#5):** team_190 ≠ Claude builder. Run in **Cursor** (cross-engine; Codex not used per team_00).
**WP:** WP-W2-10 clusters A (Service), B (Editorial), E (Commerce), F (EN landing). G BLOCKED.
**Source:** `main` @ `d452beb` (local). **Staging:** http://eyalamit-co-il-2026.s887.upress.link

## Gate order (STRICT)
Validate a cluster **only after team_50 L-GATE_BUILD PASS** for that cluster (`_COMMUNICATION/team_50/QA-VERDICT-…`). Your verdict is final and constitutional.

## Validation scope (per cluster — full A/C boundary)
1. **Composition parity** vs the elevated mockup (`_COMMUNICATION/team_35/WP-W2-10-{A,B,E,F}/elevation/`): all blocks present, in order, no stub/`the_content()` fallback.
2. **a11y:** `node scripts/qa/http-qa-axe.cjs <routes>` → 0 critical / 0 serious.
3. **Performance:** `bash scripts/qa/http-qa-lighthouse.sh <primary + sibling>` → mobile perf median ≥ 85; a11y 100.
4. **Structure:** single `<h1>` per route; correct heading order; landmarks.
5. **D-14:** zero new tokens/atoms (confirm `ea-tokens.css` unchanged vs base); no raw hex / inline styles / new keyframes.
6. **RTL/LTR:** Hebrew routes RTL via logical properties; **F (/en):** `dir="ltr" lang="en"` on html+main, logical properties only (no physical left/right), language pill → Hebrew `/`, EN copy verbatim.
7. **Graceful Eyal-gaps** (sand-circle avatars, gradient hero, product-photo placeholders); real assets wired (portrait, 3 covers); no console errors; HTTP 200.

## Cluster-specific checks
- **A:** cbDIDG 4-step + 5-tile pillar grids; service-comparison active state per route; disclaimer verbatim; real portrait in bio-block.
- **B:** memorial section rendered as a dedicated section (NOT a link), copy verbatim; AA contrast on both `--ea-bg` and `--ea-ink`; 6-cell journey timeline.
- **E:** real covers in archive + detail hero; excerpt open by default; FAQ ×4 verbatim; **all purchase CTAs external** (Morning/Mendele), no checkout; 3 detail clones correct.
- **F:** the LTR mirror checklist above; testimonials ×4.

## Output (per cluster)
Write `VERDICT-WP-W2-10-{A|B|E|F}-L-GATE-VALIDATE-2026-06-03.md` → `_COMMUNICATION/team_190/` with PASS / PASS_WITH_FINDINGS / FAIL + evidence. On PASS, return to team_100 for closure (ADR042: team_191 ARCHIVE_MANIFEST → roadmap DONE/LOD500_LOCKED → push main on team_00 go).

## Carry-forward flags (assess; non-blocking)
E — tsva vendor URL (manifest SSoT vs legacy). F — closing CTA `/contact?lang=en` vs mockup `#contact`. A — composition atoms appended to `ea-atoms.css` (existing tokens; relocatable). B — editorial routes not in primary nav by design.
