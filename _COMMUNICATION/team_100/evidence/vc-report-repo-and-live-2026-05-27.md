# VC Verification Report — Repo + Live Page
**WP:** WP-W2-01-STAGE-B-IMPL
**Round:** 2 (in-process pre-verdict, team_100 orchestration)
**Sub-agent:** A+B (Sonnet)
**Date:** 2026-05-27
**Constraint:** This is NOT a cross-engine verdict; external validation pending.

---

## Summary

| VC | Description | Result | Evidence | Notes |
|----|-------------|--------|----------|-------|
| VC-1 | CSS enqueue: ea-tokens, ea-animations, ea-atoms | **PASS** | `<link id='ea-wave2-tokens-css'>`, `<link id='ea-wave2-animations-css'>`, `<link id='ea-wave2-atoms-css'>` all present in HTML, served from `/assets/css/` | ver=1.3.6 |
| VC-2 | 12 blocks rendered in HTML | **PASS** | 12 distinct `data-block="..."` markers: hero, topnav, intro, treatment-overview, method-pillars, breath-divider-1, testimonials-row, books-row, services-row, faq-mini, contact-cta, footer-social | Exact 1:1 match with 12 block-*.php files |
| VC-3 | block-*.php count = 12 | **PASS** | `ls site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-*.php \| wc -l` → 12 | Repo-side |
| VC-4 | page-templates tpl-*.php with "Template Name:" ≥12 | **PASS** | `grep -l "Template Name:" ...tpl-*.php \| wc -l` → 13 | Repo-side; exceeds minimum |
| VC-5 | RTL: `<html dir="rtl">` | **PASS** | `<html dir="rtl" lang="he-IL">` on line 2 of fetched HTML | Live page |
| VC-8 | ea-animations.css has `@media (prefers-reduced-motion: reduce)` | **PASS** | HTTP 200; grep matched `@media (prefers-reduced-motion: reduce) {` | Fetched via HTTP (TLS blocked in runner env) |
| VC-9 | Visual RTL layout | **SKIP-NEEDS-BROWSER** | No headless browser available | Deferred to external R5 visual inspection |
| VC-10 | A/B script: KEY='eyal_cta_variant', variants form_only/dual/wa_only | **PASS** | `var KEY = 'eyal_cta_variant'`; `var variants = ['form_only', 'dual', 'wa_only']`; old `ea_wa_ab_variant` absent | HTTP 200; correct canonical key confirmed |
| VC-11 | Footer 3 social links FB+IG+YT with target="_blank" rel="noopener noreferrer" | **PASS** | All 3 links: `target="_blank" rel="noopener noreferrer"` — FB: `facebook.com/didgeridoo.studio.eyal.amit`, IG: `instagram.com/didgeridoo.therapy.center`, YT: `youtube.com/@אייל עמית` | Live page footer |
| VC-12 | WhatsApp link to wa.me/972524822842 | **PASS** | `<a class="ea-whatsapp-float" href="https://wa.me/972524822842" data-ea-ab="whatsapp">` | Live page |
| VC-13 | books-wave1.css absent from theme | **PASS** | `find ... -name "books-wave1.css"` → empty output | Repo-side |
| VC-14 | validate_aos.sh: 30 PASS / 18 SKIP / 0 FAIL | **PASS** | Output: `RESULT: 30 PASS / 18 SKIP / 0 FAIL` + `L-GATE_BUILD EXIT CRITERION: SATISFIED` | Script at `_aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh` |

---

## Totals

- **PASS:** 11 (VC-1, 2, 3, 4, 5, 8, 10, 11, 12, 13, 14)
- **SKIP-NEEDS-BROWSER:** 1 (VC-9)
- **FAIL:** 0

---

## Notes & Unexpected Findings

1. **HTTPS blocked in runner environment** — `curl` to `https://eyalamit-co-il-2026.s887.upress.link/...` returned exit code 60 (SSL cert verify fail). All live asset checks (VC-8, VC-10) were re-run via HTTP which succeeded. The staging domain appears to serve HTTP correctly; TLS is deferred per mandate.
2. **Block naming convention** — Blocks use `data-block="<name>"` markers (not `class="block-*"`); all 12 are present and match repo PHP files exactly.
3. **VC-4 count is 13** (exceeds ≥12 minimum) — no issue.
4. **validate_aos.sh path** — not in repo root; located at `_aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh`.
