---
id: VERDICT_WP-S004-P001-WP000-WAVE1_FINAL_v1
title: team_190 L-GATE_VALIDATE — Wave-1 SEO/GEO FINAL
date: 2026-06-20
from_team: team_190 (constitutional final validator)
to_team: team_00, team_100, Nimrod
wp: S004-P001-WP000
gate: L-GATE_VALIDATE (final)
engine_builder: claude-code (team_100)
engine_validator: cursor-composer (team_190 session)   # IR#1 — different engine than builder
predecessor: _COMMUNICATION/team_50/VERDICT_WP-S004-P001-WP000-WAVE1_v1.md
branch: wave1-seo-geo @ 95b3f45
staging: http://eyalamit-co-il-2026.s887.upress.link
theme_ver: 1.4.14
mandate: _COMMUNICATION/team_100/MANDATE-VALIDATE-WAVE1-SEO-GEO-2026-06-20.md
evidence: _COMMUNICATION/team_190/evidence/wp-s004-wave1-2026-06-20/
status: ISSUED
delivery: file-based
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | S004-P001-WP000 — Wave-1 SEO/GEO |
| Gate | L-GATE_VALIDATE (team_190 final) |
| Predecessor | team_50 `VERDICT_WP-S004-P001-WP000-WAVE1_v1` — **PASS_WITH_FINDINGS** (on disk ✓) |
| **Final Verdict** | **PASS_WITH_FINDINGS** |
| Dual-PASS | **YES** — team_50 PASS + team_190 PASS (same bar, independent re-run) |
| Blocking findings | **None** |
| Merge gate | `wave1-seo-geo` → `main` **only on Nimrod's explicit approval** (separate from Track B cutover) |

---

# §1 Engine Declaration (IR#1 / IR#5)

| Field | Value |
|-------|-------|
| Builder | Claude Code (team_100) |
| team_50 validator | Cursor Composer — independent BUILD gate |
| team_190 validator | Cursor Composer — **independent re-run** of all gates (did not trust team_50 numbers) |
| Predecessor-present | Confirmed — team_50 verdict existed before this final validation |

---

# §2 Independent Re-run Summary (2026-06-20)

| Gate | team_190 result | Exit / metric |
|------|-----------------|---------------|
| content-diff | **PASS** | 16/16 `gatePass` |
| axe a11y | **PASS** | 14/14 · 0 crit · 0 serious |
| overflow | **PASS** | 36/36 · 0 overflow |
| Schema | **PASS_WITH_FINDINGS** | 1 JSON-LD block/page · Person+ProfessionalService+Service · Schema.org 0 errors · Product node absent (numeric-price rule) |
| Analytics | **PASS** | GA4 in head · Clarity absent · `generate_lead` wired |
| Redirects | **PASS** | `/Blog/` 3/3 · 10/10 mu-plugin spot probes |
| WhatsApp | **PASS** | 4/4 pre-fill URLs |
| Regression | **PASS** | No content regression · no PHP fatals |

---

# §3 Wave-1 Specific Confirmations

## W1-02 / W1-08 — Single Yoast `@graph` extension

- **Confirmed:** one `application/ld+json` block per page; `ea-w2-seo-schema.php` appends `Person`, `ProfessionalService`, route `Service` via `wpseo_schema_graph` filter.
- **Confirmed:** `@id` cross-refs (`Person.worksFor` → business; `Service.provider` → business).
- **Confirmed:** `Product`/`Offer` emitted only when `ea_product_price` is `is_numeric()` — staging shop pages correctly omit Product node (all meta empty → "מחיר לפי התאמה" fallback).

## W1-01 / W1-13 — Analytics + lead events

- **Confirmed:** GA4 `G-MRXESK7QJF` loads without Clarity (`__PENDING_EYAL__`).
- **Confirmed:** `display = 'dual'` in `ea-ab-testing.js` — both channels visible.
- **Confirmed:** `generate_lead` on WhatsApp click (runtime) + `wpcf7mailsent` listener (static).

## W1-06 — `/Blog/` → `/blog/` 301

- **Confirmed:** `preg_match('#^/Blog/(.+)$#')` in live `ea-w209-legacy-301-redirects.php`; verify script 3/3 PASS.

## W1-01t — WhatsApp pre-fill

- **Confirmed:** `ea_wave2_wa_url()` on `/`, `/treatment/`, `/shop/`, `/en/` (English on EN).

---

# §4 Findings Carried Forward (non-blocking)

Same as team_50 §4: F-01 Product node not observable until numeric price meta set; F-02 mokesh PAGE_MAP N/A; F-03 `/shop/cart/` 404 on staging; F-04 Rich Results URL-fetch blocked for staging.

---

# §5 Evidence Index

| Artifact | Path |
|----------|------|
| team_50 predecessor | `_COMMUNICATION/team_50/VERDICT_WP-S004-P001-WP000-WAVE1_v1.md` |
| Content-diff | `_COMMUNICATION/team_190/evidence/wp-s004-wave1-2026-06-20/content-diff/summary.json` |
| Axe | `…/axe-http-2026-06-20.json` |
| Overflow | `…/qa_probe/qa_probe_result.json` |
| Schema | `…/schema/extract.json`, `…/schema/validator-schema-org-html.json` |
| Analytics | `…/analytics-summary.json` |
| Redirects | `…/redirect-probes.json`, `…/blog-301-verify.txt` |

---

# §6 Closure

**L-GATE_VALIDATE: PASS_WITH_FINDINGS.**

Wave-1 SEO/GEO batch on `wave1-seo-geo` (theme 1.4.14, staging deployed) meets all mandate §2 gates with no blocking defects. team_100 may request merge to `main` after **Nimrod explicit approval**. Production cutover items (W1-04 robots, W1-05 WebP, GSC, lead-deliverability inbox) remain on Track B / deferred scope per mandate.
