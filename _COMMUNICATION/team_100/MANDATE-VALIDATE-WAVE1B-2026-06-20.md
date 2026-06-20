# MANDATE — Wave-1b validation (team_100 → team_50 + team_190)

**Issued:** 2026-06-20 · **From:** team_100 (builder) · **To:** team_50 (BUILD gate, cross-engine) + team_190 (final). **Iron Rule #1:** builder ≠ validator.
**WP:** `S004-P001-WP000` (SEO/GEO) — Wave-1b additive batch. **Branch:** `wave1b-seo-geo`. **Env:** staging `http://eyalamit-co-il-2026.s887.upress.link` (theme `1.4.14`).
**Context:** Wave-1 already dual-PASSed + merged to `main` (817e05b). This is the follow-on non-blocked batch (small, additive).

## 1. What changed (Wave-1b)
| Item | Change | Commit |
|---|---|---|
| Redirect | `/shop/cart` + `/shop/checkout` + `/shop/my-account` → **301 → /shop/** (were 404) | `41917bb` |
| Meta | per-route `<meta name="description">` for the 9 previously-bare routes (eyal-amit, shop, books, faq, blog, contact, repair, bags, +didgeridoos/stands/stand-floor/muzza) | `f480c02` |
| BLD-4 | contact page: **visible NAP block** (המרכז…, רח' עמל 8 ב' פרדס חנה, tel, hours Su–Th 9–19/Fr 9–14/Sat closed) + wa.me pre-fill | `5aae5e6` |
| W1-05a | `fetchpriority="high"` on the /eyal-amit editorial-hero portrait (LCP) | `5aae5e6` |

(Deferred, NOT in this batch — documented in the completion register: full WebP `<picture>`, the cutover QR-assertion harness fix, hub `materials-needed` refresh.)

**Pre-deploy local checks (team_100):** `php -l` clean on all touched PHP. QA vs staging in §3.

## 2. Gates to run (cross-engine, independent)
1. **content-diff** — `node scripts/qa/content-diff.mjs`: 16/16 sourced routes still ACCURATE (additive batch — no content regression).
2. **axe a11y** — incl. `/contact/` (new NAP block) + the meta layer: 0 serious/critical.
3. **overflow** — `qa_probe.mjs` @360/390/414/768, esp. `/contact/` (the NAP block uses inline spacing) + `/eyal-amit/`: 0 horizontal overflow.
4. **Redirects** — `curl -I`: `/shop/cart/` `/shop/checkout/` `/shop/my-account/` → 301 → `/shop/`; regression on `/Blog/<slug>` → `/blog/<slug>` + `/מוזה-הוצאה-לאור/` → `/books/`.
5. **Meta** — every route in §1 now emits exactly ONE `<meta name="description">` (no Yoast duplicate); content accurate.
6. **Contact NAP** — `/contact/` shows the name + address + tel (`tel:+972524822842`) + hours; the LocalBusiness JSON-LD NAP (from Wave-1) matches.
7. **LCP** — `/eyal-amit/` portrait has `fetchpriority="high"` + width/height (no CLS).
8. **Regression** — no PHP notices/fatals; theme `1.4.14`.

## 3. Local QA vs staging (team_100, post-deploy 2026-06-20) — GREEN
- **/shop redirects:** `/shop/cart/` → 301 → `/shop/` ✓ (same for checkout/my-account).
- **Contact NAP (BLD-4):** `/contact/` shows "המרכז לטיפול בנשימה…", "עמל 8…", "052‑4822842", "שעות פעילות…" ✓.
- **Meta:** the 9 previously-bare routes now emit 1 `meta description` each ✓ (sampled eyal-amit/shop/faq/contact/repair).
- **LCP:** `/eyal-amit/` portrait `fetchpriority="high"` present ✓.
- `php -l` clean on all touched PHP. _(team_50 re-runs content-diff/axe/overflow independently per §2.)_

## 4. Sequence
team_50 verdict (`VERDICT_…WAVE1B_v1.md` in `_COMMUNICATION/team_50/`) → team_190 final → on dual-PASS, merge `wave1b-seo-geo` → `main` (on Nimrod's explicit go).

### Activation prompt (paste to start team_50)
> You are **team_50**, cross-engine BUILD-gate validator for EyalAmit.co.il-2026 (`/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026`). team_100 built the **Wave-1b** additive batch on `wave1b-seo-geo`, deployed to staging (theme 1.4.14). Read `_COMMUNICATION/team_100/MANDATE-VALIDATE-WAVE1B-2026-06-20.md` and run every gate in §2 (content-diff, axe, overflow, /shop/* + regression redirects, per-route meta, contact NAP, LCP, regression) independently — do not trust team_100's self-QA. Record `VERDICT_WP-S004-P001-WP000-WAVE1B_v1.md` in `_COMMUNICATION/team_50/` with PASS/FAIL + evidence; on PASS hand to team_190 for the final gate.
