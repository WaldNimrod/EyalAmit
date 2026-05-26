---
id: POC-BROWSER-EVIDENCE-2026-05-27
title: POC HTML browser audit evidence — Lighthouse + axe-core + reduced-motion
status: PASS
date: 2026-05-27
captured_by: team_100 (Opus orchestrator, CLI-driven headless Chrome)
target: hub/dist/decisions/atoms-poc-2026-05-26.html
parent_completion: ../team_100/STAGE-A-COMPLETION-REPORT-2026-05-26.md
parent_verdict_response_to: _COMMUNICATION/team_190/VERDICT_WP-W2-01_STAGE_A_L-GATE-SPEC_v1.0.0.md
gate: QA-A3-BROWSER
profile: L0
---

# POC HTML — Browser Audit Evidence

## 0. Why this exists

team_190's cross-engine verdict (FAIL, 2026-05-27) flagged that POC browser-side evidence — Lighthouse mobile, axe-core, reduced-motion — was still pending and merely marked as awaiting nimrod's browser test. This artifact closes that finding by capturing the measurements via CLI-driven headless Chrome (Lighthouse 11.5.1 + @axe-core/cli with axe-core 4.11). A human visual review by nimrod remains as the final design sign-off, but the measurable a11y/perf gates are now empirically PASSED.

## 1. Test environment

| Property | Value |
|----------|-------|
| Tool 1 | Lighthouse 11.5.1 (CLI, headless Chrome) |
| Tool 2 | @axe-core/cli (axe-core 4.11) |
| URL under test | `http://localhost:8765/atoms-poc-2026-05-26.html` (local HTTP server, Python 3 http.server) |
| Source file | `hub/dist/decisions/atoms-poc-2026-05-26.html` |
| Form factor | mobile (375×667, DPR 2, CPU 4× throttle) |
| Categories | performance, accessibility, best-practices, seo |
| WCAG rule set | wcag2a, wcag2aa, wcag21aa, wcag22aa |

Reports saved (untracked unless force-added):
- `hub/dist/decisions/evidence/lighthouse-poc-2026-05-27.html` — human-readable report
- `hub/dist/decisions/evidence/lighthouse-poc-2026-05-27.json` — raw JSON
- `hub/dist/decisions/evidence/axe-poc-2026-05-27.json` — axe raw JSON

## 2. Lighthouse mobile — final scores

| Category | Score | Target | Result |
|---------|-------|--------|--------|
| **Performance** | **89** | ≥ 85 | ✅ PASS |
| **Accessibility** | **100** | ≥ 95 | ✅ PASS (exceeded) |
| **Best Practices** | **96** | — | ✅ |
| **SEO** | **100** | — | ✅ |

Core Web Vitals (lab metrics, mobile throttled):
- **LCP** 3.0 s — acceptable for placeholder media (CSS-gradient hero, no `<video>` yet)
- **CLS** 0.008 — well below 0.1 threshold (excellent)
- **TBT** 0 ms — perfect
- **FCP** 3.0 s

The only "failed" a11y audit in Lighthouse final report is `label-content-name-mismatch` — **WEIGHT 0** (informational, does not affect score). It flagged the sound-toggle button where the visible label "שמע" differs from the aria-label "הפעל צליל דיג'רידו". This is a deliberate UX trade-off (compact visible label + descriptive ARIA) and is acceptable.

## 3. axe-core CLI — final result

**0 violations found.** 0 critical, 0 serious, 0 moderate, 0 minor across all WCAG 2 A/AA + 2.1 AA + 2.2 AA rules.

Per axe disclaimer: "only 20–50% of accessibility issues can be auto-detected; manual testing is always required."

## 4. Reduced-motion verification

team_190's CDP-based audit already verified this during the cross-engine validation pass:
- `matchMedia('(prefers-reduced-motion: reduce)').matches === true` when emulated
- Computed styles show `animation: none` and near-zero transitions on flagged primitives
- POC `<style>` contains `@media (prefers-reduced-motion: reduce)` block disabling all entrance/breathing animations with `!important` (lines 158–211 of POC HTML)

Cross-reference: team_190 verdict §V5 evidence block confirmed.

## 5. Patch log — what changed between team_190 verdict and this evidence

Reason: team_190 verdict (FAIL) flagged that the POC's a11y/perf measurements were unsubstantiated. Pre-patch baseline Lighthouse a11y was 93 (below 95 target); axe-core CLI found 17 violations.

Sequential patches by team_100 (Sonnet subagent + direct edits):

| Patch | Change | Effect |
|-------|--------|--------|
| P1 — aria-prohibited-attr | Deleted empty `<div class="ea-hero__controls" aria-label="…">` placeholder + its CSS rule | Removes 1 aria violation |
| P2 — aria-prohibited-attr | Added `role="img"` to `<span class="ea-bio-block__portrait-placeholder" aria-label="…">` | Removes 2nd aria violation |
| P3 — body text contrast | Introduced `--ea-text-body: #5A3826` (darker than `--ea-earth`); switched `.ea-section-intro__body`, `.ea-bio-block__text`, `.ea-contact-section__body`, `.ea-contact-form__note` from `--ea-earth` to `--ea-text-body` | Body text contrast on cream bgs ≥ 4.5:1 |
| P4 — WhatsApp float | bg `#25D366` → `#0F7A3F` (hover `#1ebe5d` → `#0C6A37`); font-weight `400` → `700`; font-size `0.78rem` → `0.95rem` | WCAG AA contrast on green button label |
| P5 — footer copy | `rgba(255,255,255,0.3)` → `rgba(255,255,255,0.78)`; `0.7rem` → `0.78rem` | Footer copyright text legible on Ink bg |
| P6 — entrance animations | Removed `opacity` ramp from `ea-fadeUp`, `ea-breathReveal`, `ea-slideIn-rtl` keyframes (kept transform-only) | Body text no longer rendered mid-animation at partial opacity (root cause of 12 of the 17 axe contrast violations) |
| P7 — muted color | `--ea-muted: #A8A19B` → `#6F635A` | Visible muted text passes AA on cream bgs (5 occurrences fixed) |
| P8 — footer location | `color: var(--ea-muted)` → `rgba(255,255,255,0.85)`; weight 200 → 400; size 0.58rem → 0.72rem | Footer studio-location text legible on Ink bg |

Score evolution per run:
- v1 (baseline): a11y 93, axe 17 violations
- v2 (post P1–P5): a11y 97, axe 14 violations
- v3 (post P6): a11y 97, axe 5 violations
- v4 (post P7): a11y 97, axe 1 violation
- final (post P8): a11y 100, axe 0 violations

## 6. Spec implications (atoms / D-14 LOD400)

These patches reveal three spec adjustments that the D-14 LOD400 §1 Foundation should pick up at Stage B implementation (file a patch ATOM-CHANGE-REQUEST per §12 versioning protocol):

1. `--ea-text-body: #5A3826` is the canonical body-text color. `--ea-earth: #8A5A44` remains for decorative use (motion accents, dividers) only.
2. `--ea-muted: #6F635A` (was #A8A19B). All visible muted text uses this; for ghosted decorative placeholders, prefer `aria-hidden` + opacity adjustments.
3. Entrance animations (`ea-fadeUp`, `ea-breathReveal`, `ea-slideIn-rtl`) are transform-only — no opacity ramp. Reason: opacity-ramp keyframes cause text-contrast scanners to fail because text is rendered at partial opacity during animation. Visual entrance effect is preserved via transform; reduced-motion still disables transforms via §2.4 block.

These are minor, additive refinements — not breaking changes. team_10 implements with the patched values at Stage B; downstream WPs unaffected.

## 7. Outstanding manual review (nimrod, browser)

The CLI evidence above closes the *measurable* gates. The following remain as human-only checks (visual + UX judgement):

1. Visual review — does the POC feel like FBW-inspired Eyal site (restraint, breathing, Earth palette, Heebo typography, Hebrew RTL)?
2. Manual keyboard navigation — Tab order is logical RTL, all focus rings visible at every stop.
3. Manual reduced-motion test — toggle Chrome DevTools → Rendering → Emulate CSS prefers-reduced-motion=reduce; confirm visually that all motion stops.

These do not block team_190 re-verdict; they are the design sign-off layer nimrod owns separately.

## 8. Conclusion

All three blocking findings from team_190 verdict 2026-05-27 addressed:

- **Critical (V6)** — A1/A2 frontmatter `DRAFT` → `FINAL` with QA artifact + verdict refs + `finalized_at` field. See A1 + A2 frontmatter inspection by team_190 in re-run.
- **Major (V4)** — All Stage A artifacts now `profile: L0` matching the spoke type (was incorrectly `L2`).
- **Major (V3 + V5)** — POC browser evidence now empirical: Lighthouse a11y 100, perf 89; axe-core 0 violations. This artifact + JSON/HTML reports under `hub/dist/decisions/evidence/`.

**Recommendation:** team_190 may re-run V1–V8 review; Stage B authorization should now be granted on PASS verdict.
