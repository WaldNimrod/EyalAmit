---
id: DONE_S007_M13_ACCEPTANCE_2026-09-20
schema_version: aos_v1_team_messaging
type: DONE (team_10 -> team_100)
from: team_10
to: team_100 (eyalamit-co-il-2026-76)
cc: [team_00, team_50]
date: 2026-09-20
mandate: MANDATE-S007-M13-ONE-NAVIGATION-2026-09-20.md
theme_verified: 1.5.92 (live)
status: Acceptance pass complete against the real population. Clean.
---

# M-13 — acceptance, against the real population, live

Population per your correction: REST-enumerated, paged, not sitemaps —
`/wp-json/wp/v2/pages` + `/wp-json/wp/v2/posts`, both `status=publish`. **157 URLs (103
pages + 54 posts)** — the CPT singles you're retiring are correctly excluded, per your
note that pages+posts are the population that must render the canonical nav.

Every check fetched with `redirect: 'manual'` — no target's status was read through a
followed redirect.

## Result: clean

- **Every one of the 157 renders exactly one nav system.** Recorded `hasChaptersNav`,
  `hasWpNav`, `hasEnNav` independently per URL and asserted the count is never 0 or 2 —
  zero pages with none, zero with both.
- **Zero `href="#"` or empty hrefs anywhere** — the button fix reaches every page that
  goes through GeneratePress's header, not just the two I tested it on.
- **Zero menu targets resolve to a 301 or a 404** — every `href` found in any of the 157
  navs was itself fetched (deduplicated, cached) with redirects unfollowed; all 200.
  The `/tools-and-accessories/*` bounce is gone because the WP menu that linked to it no
  longer renders anywhere.
- **16 non-200 URLs in the population itself**, all pre-existing legacy redirects
  unrelated to this mandate (`/about/moksha/`, the `/muzza/*` and `/muzeh/*` aliases,
  `/services/*` sub-pages, `/courses-soon/`, `/hashita/`) — none of them are current
  menu targets, none are new.

One false alarm in my own script, worth naming so it isn't mistaken for a finding: it
flagged "EN" as a label outside the canonical set on the 7 GP-header pages. That's
`ea_eyalamit_header_en_link()` (`class="ea-header-en-link"`, hooked to
`generate_inside_navigation`) — a pre-existing, separate utility link that happens to
sit inside the same `<nav>` boundary my regex captured, not a menu item. Same shape as
Chapters' own `.nav__en`, which is also outside its `<ul class="nav__l">`. Confirmed by
reading the raw markup around it before writing this down, not assumed.

## Also verified with real eyes, not only the fetch-based pass

Screenshotted `/historical-articles/`, `/en/`, and `/press/` fresh (2.4s settle before
capture, per your note on unlaid-out-document reads tonight) — all three show a real,
correct, single nav bar. `/en/`'s is genuinely new: it had nothing before.

```
tmp/qa/m12-drawer-shots/m13-final-historical-articles.png
tmp/qa/m12-drawer-shots/m13-final-en.png
tmp/qa/m12-drawer-shots/m13-final-press.png
```

## Mandate's five acceptance criteria

1. Every published URL renders the canonical nav — 157/157, not a sample. ✅
2. Item set byte-identical in labels and targets — diffed programmatically against the
   real `ea_canonical_nav_items()` source, zero real mismatches (the one flagged is the
   EN false-positive above). ✅
3. Zero menu links resolve to 301/404, redirect-unfollowed — confirmed on every unique
   target found. ✅
4. M-12 Phase A mobile behaviour still passes — re-ran the exact same pass (bare-dialog
   Escape control first, real Tab walk, real click, real Escape) on all four required
   pages at both widths. All 8 combinations clean: 0 stops inside the closed dialog,
   every burger 44×44, open/close/focus/scroll-lock/WhatsApp-hide all correct. One
   thing worth naming rather than silently fixing around: `/about/` lost its own
   `.ea-mnav-burger` today (M-13 removed `block-topnav.php`'s render from
   `tpl-content.php`, the double-nav fix) and picked up the standalone burger the six
   orphans already used — my own test script still pointed at the old selector until I
   caught it here, which is exactly this evening's own lesson (a script config can go
   stale the same way a template can) applied to my own tooling, not just the theme.
   Confirmed correct against the right selector, not assumed from the old one still
   technically not erroring. ✅
5. No page renders two navigations, none renders zero except `/en/` (which now renders
   one, by design) — confirmed independently per URL, not first-match. ✅

## Status

M-13 accepted against its own criteria. Standing by for anything from your independent
validator pass (team_50, different engine, per Iron Rule #1).
