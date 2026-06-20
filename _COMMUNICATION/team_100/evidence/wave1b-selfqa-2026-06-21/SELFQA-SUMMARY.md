---
id: SELFQA_WP-S004-P001-WP000-WAVE1B-REV2
title: team_100 builder self-QA — Wave-1b B-W1B-META-01 remediation
date: 2026-06-21
from_team: team_100 (builder / claude-code)
wp: S004-P001-WP000 — Wave-1b additive SEO/GEO batch
branch: wave1b-seo-geo
staging: http://eyalamit-co-il-2026.s887.upress.link
predecessor_verdict: _COMMUNICATION/team_50/VERDICT_WP-S004-P001-WP000-WAVE1B_v1.md (FAIL)
note: Builder self-QA is DIAGNOSTIC ONLY (Iron Rule #1). It does NOT satisfy the
      cross-engine gate. Official re-validation is owned by team_50 (build gate) →
      team_190 (final), on a non-Claude engine.
---

# §0 What changed

**Blocking finding remediated:** `B-W1B-META-01` — `/blog/` emitted **0** `<meta name="description">`.

**Root cause** (`site/wp-content/themes/ea-eyalamit/inc/wave2-w2-09.php`):
`ea_w2_09_route_description()` early-returned `''` unless `is_page()`. The `/blog/`
posts archive is `is_home()` (a separate posts page from the static front page),
so its map entry (`'blog' => …`) was never reached; the tagline fallback is empty
on this install → 0 tags emitted.

**Fix:** moved the `$map` definition to the top of the function and added an
archive branch — `if ( is_home() && ! is_front_page() ) return $map['blog'];` —
*before* the `is_page()` guard. The blog copy now has a single source of truth (the
map), reused by the archive branch. `! is_front_page()` ensures it only applies to
the dedicated posts page, not when the blog is the homepage (handled upstream by the
`is_front_page()` branch in `ea_w2_09_meta_description()`).

Also dispositioned `F-W1B-META-02` (`/muzza/`): documented the dead `'muzza'` map
entry as intentional — `/muzza/` is a 301 SOURCE to canonical `/books/`, never
queried as a Page. Accept the `/books/` canonical; no distinct `/muzza/` landing.

**Deploy:** `python3 scripts/ftp_deploy_site_wp_content.py` — theme + mu-plugins
shipped; `style.css` Version bumped 1.4.14 → 1.4.15 (asset re-cached on deploy,
filemtime-based `?ver` confirmed bumped live). `php -l` clean on the touched file.

# §1 Gate-5 (meta) re-check — the decisive gate

| Route | meta[name=description] count | Verdict |
|-------|------------------------------|---------|
| `/blog/` | **1** (was 0) | PASS — content = "הבלוג של אייל עמית — דיג׳רידו, נשימה, סאונד הילינג…" |
| `/blog/page/2/` | **1** | PASS — pagination archive handled |
| `/` | 1 | PASS |
| `/eyal-amit/` | 1 | PASS |
| `/contact/` | 1 | PASS |
| `/shop/` | 1 | PASS |
| `/faq/` | 1 | PASS |
| `/didgeridoos/` | 1 | PASS |
| `/bags/` | 1 | PASS |
| `/repair/` | 1 | PASS |
| `/books/` | 1 | PASS |
| `/stands-storage/` | 1 | PASS |
| `/stand-floor/` | 1 | PASS |

**No route emits 2** (no theme/Yoast duplicate). All 12 §1 routes + the blog
archive emit exactly one.

# §2 Adversarial checks (tried to refute "fix is clean, no new duplicate")

| Probe | Expectation | Result |
|-------|-------------|--------|
| `/blog/` raw `curl \| grep -c` (independent of any QA script) | exactly 1 | **1** ✓ |
| `/blog/page/2/` (paged archive) | 1, not 0/2 | **1** ✓ |
| Single post (root Hebrew slug, e.g. `…/פודקאסט-דיגרידו…-2/`) | ≤1, never 2 | **0** (HTTP 200) — no duplicate introduced |
| Content of `/blog/` meta | the intended blog copy | matches ✓ |

**Pre-existing gap noted (NOT introduced by this change, OUT of Wave-1b scope):**
single blog posts emit 0 meta description (theme returns '' for `is_single()`, and
Yoast emits none here). Candidate for the WP-04 head-pack (per-route title/meta on
posts) or WP-10 blog cluster. Logged in the roadmap; not a Wave-1b blocker.

# §3 Regression posture (carried-forward from team_50 v1, unchanged code paths)

team_50 v1 PASSED 7/8 gates on `5b0493c`; this fix touches only
`wave2-w2-09.php` (meta) + `style.css` (version string). No redirect/schema/
analytics/contact/LCP code paths changed → those gates expected to hold. team_50
re-validation should confirm gate 5 (decisive) + run 1–4,6–8 as regression.

# §4 Files changed this remediation
- `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-09.php` — blog-archive meta branch + /muzza disposition comment
- `site/wp-content/themes/ea-eyalamit/style.css` — Version 1.4.14 → 1.4.15
