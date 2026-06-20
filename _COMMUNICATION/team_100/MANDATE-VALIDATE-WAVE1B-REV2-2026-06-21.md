---
id: MANDATE-VALIDATE-WAVE1B-REV2
title: Re-validation mandate — Wave-1b SEO/GEO (after B-W1B-META-01 remediation)
date: 2026-06-21
from_team: team_100 (Chief Architect / builder — claude-code)
to_team: team_50 (cross-engine BUILD gate) → team_190 (final)
wp: S004-P001-WP000 — Wave-1b additive SEO/GEO batch
gate: L-GATE_BUILD (re-run after fix)
branch: wave1b-seo-geo
staging: http://eyalamit-co-il-2026.s887.upress.link
predecessor: _COMMUNICATION/team_50/VERDICT_WP-S004-P001-WP000-WAVE1B_v1.md (FAIL)
selfqa: _COMMUNICATION/team_100/evidence/wave1b-selfqa-2026-06-21/SELFQA-SUMMARY.md
original_mandate: _COMMUNICATION/team_100/MANDATE-VALIDATE-WAVE1B-2026-06-20.md
delivery: file-based (hub DB offline — ADR043 §4/§5 fallback)
---

# §0 Why this mandate

team_50 v1 returned **FAIL** on Wave-1b with a single blocking finding:
**`B-W1B-META-01`** — `/blog/` emitted **0** `<meta name="description">` tags
(mandate §2.5 requires every §1 route to emit exactly one). 7 of 8 gates PASSED
(content-diff 17/17 @ 99.72%, axe 12/12, overflow 48/48, redirects 5/5, contact
NAP, LCP, regression).

team_100 has remediated and redeployed. This mandate asks team_50 to re-run the
**decisive meta gate** plus the regression-adjacent gates against LIVE staging,
independently (IR#1 — do not trust team_100 self-QA), and file a v2 verdict.

# §1 What changed since 5b0493c (the delta to validate)

- **Fix (`B-W1B-META-01`):** `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-09.php`
  — `ea_w2_09_route_description()` now has an `is_home() && ! is_front_page()`
  branch returning the blog-archive description (single source of truth = the
  `$map['blog']` entry), placed before the `is_page()` guard. Root cause: the
  `/blog/` posts archive is `is_home()`, not `is_page()`, so the prior early-return
  skipped it; the tagline fallback is empty on this install → 0 tags.
- **`F-W1B-META-02` disposition (`/muzza/`):** ACCEPTED `/books/` canonical.
  `/muzza/` is a 301 SOURCE → `/books/` (redirects SSoT); it is never an
  independently observable HTML page. The `'muzza'` map entry is documented as a
  dead entry; NO distinct `/muzza/` landing is authored. **This is closed — not a
  re-validation item.**
- **Deploy:** theme `style.css` Version bumped 1.4.14 → **1.4.15**; shipped via
  `python3 scripts/ftp_deploy_site_wp_content.py`. Only `wave2-w2-09.php` (meta) +
  `style.css` (version) changed in the theme. `php -l` clean.
- **Git posture:** the fix is LIVE on staging (the validation surface) but
  **uncommitted** in git per the standing commit-gating rule — team_100 will commit
  on Nimrod's explicit ask, after dual-PASS. team_50 validates the running staging
  site, so this does not affect validation.

# §2 Re-validation scope (run independently against LIVE staging)

**DECISIVE re-check:**
1. **Meta (gate 5)** — every route below emits **exactly one** `<meta name="description">`,
   no Yoast/theme duplicate (count must be 1, never 0 or 2):
   `/`, `/blog/`, `/blog/page/2/`, `/eyal-amit/`, `/shop/`, `/didgeridoos/`,
   `/bags/`, `/stands-storage/`, `/stand-floor/`, `/repair/`, `/books/`, `/faq/`,
   `/contact/`. Confirm `/blog/` content reads as the blog description.

**REGRESSION confirmation (unchanged code paths — expected to hold):**
2. content-diff (`node scripts/qa/content-diff.mjs`) — no regression (was 17/17).
3. axe a11y (`node scripts/qa/http-qa-axe.cjs` incl `/contact/`) — 0 serious/critical.
4. overflow (`node <qa_probe.mjs> --config … @360/390/414/768`) — 0 horizontal overflow.
5. redirects (`node scripts/qa/wave1-redirect-probes.mjs` / curl -I) — `/shop/cart|checkout|my-account/`→301→`/shop/`; `/Blog/<slug>`→`/blog/<slug>`; `/מוזה-הוצאה-לאור/`→`/books/`.
6. contact NAP — visible name+address+`tel:+972524822842`+hours; ProfessionalService JSON-LD matches.
7. LCP — `/eyal-amit/` portrait `fetchpriority="high"` + width/height.
8. regression — no PHP notices/fatals; theme `1.4.15` live.

Full gate definitions: see `MANDATE-VALIDATE-WAVE1B-2026-06-20.md` §2.

# §3 Known non-blockers (do NOT fail Wave-1b on these — logged for later WPs)

- **Single blog posts emit 0 meta description.** Pre-existing (theme covers Pages +
  the `/blog/` archive only; Yoast emits none here). NOT introduced by this fix and
  NOT in the Wave-1b §1 route list. Carried to **WP-04** (per-route/per-post head
  pack). Verified this session that single posts return HTTP 200 with no duplicate.

# §4 Verdict + sequence

- team_50 files `VERDICT_WP-S004-P001-WP000-WAVE1B_v2.md` in `_COMMUNICATION/team_50/`
  with PASS/FAIL + evidence. **On PASS, hand to team_190** for the final gate.
- team_190 (a DIFFERENT engine from both builder and team_50) files the Wave-1b
  final verdict in `_COMMUNICATION/team_190/`.
- On **dual-PASS**, team_100 commits the fix and merges `wave1b-seo-geo` → `main`
  — **only on Nimrod's explicit "מאשר"** (and a separate explicit "פוש" for any
  origin push). No "ready" signal to Eyal before dual-PASS (team_00 owns Eyal comms).

# §5 team_50 activation prompt (copy-paste; MUST be a non-Claude engine)

> You are **team_50**, the cross-engine BUILD-gate validator for EyalAmit.co.il-2026
> (`/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026`). **You must run on a
> non-Claude engine** (e.g. GPT-5.x in Cursor) — IR#1: builder ≠ validator engine.
> Your prior verdict `VERDICT_WP-S004-P001-WP000-WAVE1B_v1.md` was **FAIL** on
> `B-W1B-META-01` (`/blog/` emitted 0 meta descriptions). team_100 fixed the
> blog-archive meta branch in `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-09.php`
> and redeployed (theme `1.4.15`). Read
> `_COMMUNICATION/team_100/MANDATE-VALIDATE-WAVE1B-REV2-2026-06-21.md`. Re-run the
> **meta gate (decisive)** across the §2 route list and gates 2–8 as regression —
> independently, against LIVE staging `http://eyalamit-co-il-2026.s887.upress.link`,
> do NOT trust team_100's self-QA. Confirm `/blog/` and `/blog/page/2/` now emit
> exactly ONE `<meta name="description">` and no route emits two. Treat the §3
> single-post-meta gap as a known non-blocker (WP-04), not a Wave-1b failure. File
> `VERDICT_WP-S004-P001-WP000-WAVE1B_v2.md` in `_COMMUNICATION/team_50/` with
> PASS/FAIL + evidence. On PASS, hand to team_190 for the final gate.
