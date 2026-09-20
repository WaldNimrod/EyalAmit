---
id: MANDATE_S007_M13_ONE_NAVIGATION_2026-09-20
schema_version: aos_v1_team_messaging
type: MANDATE (team_100 → team_10)
from: team_100
to: team_10
cc: [team_00]
date: 2026-09-20
supersedes_scope_of: M-12 Phase B
ruling: _COMMUNICATION/team_00/DECIDE-S007-TWO-NAVIGATIONS-2026-09-20.md
---

# M-13 — one navigation, every published URL, desktop and mobile

## The ruling this implements

team_00, 2026-09-20: «כל העמודים ללא יוצא מהכלל חייבים להציג אותו תפריט מדוייק ונכון.
בכל סביבה ובכל מסך.»

**Canonical:** ONE navigation — identical item set, identical labels, identical targets — on
every published URL, desktop and mobile alike. A shared mobile drawer sitting over two
different desktop navs does not satisfy this. **This replaces the scope of M-12 Phase B.**
Do not rebuild the GeneratePress masthead on six pages; that framing was wrong.

## What is actually true, measured live against 1.5.88 on 2026-09-20

Re-measure before you act. These are team_100's numbers, given so you do not start from the
old assumption — not so you can skip your own measurement.

**279 published URLs across all five sitemaps** (page 87 · post 55 · ea_faq 133 ·
ea_gallery 2 · ea_testimonial 2):

- **135 render the Chapters nav** (`<nav class="nav" id="nav">`, 28 links). Canonical.
- **143 render the WordPress menu** (`<nav id="site-navigation">`, 21 links). Wrong.
- **1 renders no navigation at all:** `/en/`.

**The 143 are not the six orphan pages.** Six real pages — `/historical-articles/`,
`/learning/courses-external/`, `/press/`, `/services/`, `/shows-heritage/`, `/thank-you/` —
plus **133 `faq-item`, 2 `gallery-item` and 2 `testimonial-item` singles**. Every earlier
sweep, mine included, read `page-sitemap.xml` only and therefore could not see the 137 CPT
singles. 24 of 24 randomly sampled `faq-item` URLs render the WP menu; verify the rest.

Two pages we previously called orphans are NOT in this set: `/courses-soon/` 301s away, and
`/learning/therapist-training/` renders the Chapters nav normally.

## Where the wrong nav comes from

`site/wp-content/themes/ea-eyalamit/header.php` **delegates to GeneratePress's header.php
whenever the parent theme is present**, which it is on staging — lines 10–14. Everything
below that `return` is a dev-only shell and is dead on staging. So the WP menu is rendered by
**GeneratePress's own header**, from the menu assigned to its `primary` location. That is the
single mechanism behind all 143 URLs.

## The trap to avoid

There are already **three independently-maintained copies of the site tree**:
`template-parts/chapters/section-nav.php`, `template-parts/blocks/block-topnav.php`, and
`ea_nav_drawer_items()` in `inc/ea-nav-drawer.php` — whose own docblock admits it is "a third,
independently-maintained copy". They have already drifted apart; that drift is the defect this
mandate exists to end.

**A fourth copy is not a fix.** «אותו תפריט מדוייק ונכון» cannot be maintained across four
hand-edited lists. Required shape: **one data source, every renderer reads it.** Promote the
nav tree to a single function and have the Chapters nav, the drawer and the
GeneratePress-header path all render from it. A renderer may differ in markup and styling; it
may not differ in items, labels or targets.

## Correctness defects inside the wrong menu

- It links to `/tools-and-accessories/`, `/tools-and-accessories/instruments/` and
  `/tools-and-accessories/repair/`. **All three are 301s** to `/shop/`, `/didgeridoos/` and
  `/repair/`. Those 143 URLs currently offer visitors menu links that bounce.
- Labels disagree with the canonical list for the same page — for example «שיטת cbDIDG של
  אייל עמית» against «השיטה», and «מוזה הוצאה לאור» against «ספרים».
- `/press/` is the last page still carrying Wave2's `ea-mnav` markup. Remove it as you go.

## Scope

**IN:** every published URL renders the canonical nav, desktop and mobile. The three
renderers read one source. The drawer keeps the behaviour M-13 does not touch — your Phase A
verification stands and must still pass at the end.

**OUT — do not do these, they are team_00's:**

- `/en/` has no nav at all. The canonical list is Hebrew; `/en/` is an LTR English landing.
  **Do not invent an English menu and do not paste the Hebrew one in.** Report it; team_00
  decides.
- Whether the 133 `faq-item` singles should be public URLs at all, given `/faq/` already
  serves the same content. Report only.
- The four CPT seed singles (`ea-m3-seed-gallery-1|2`, `ea-m3-seed-testimonial-1|2`) are
  published placeholders whose visible body is our own internal build notes. **Deleting them
  is not yours.** Make them render the right nav like everything else; flag the rest.
- Removing the three redirecting `/tools-and-accessories/*` URLs from `page-sitemap.xml`.
  Report it.
- Which pages JOIN the menu. Seven are in front of Eyal now, in part ה׳ of
  `_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html`. **Until he answers,
  the canonical item set does not change** — M-13 makes every page show the list we already
  have, and nothing more.

## Acceptance

Measured live, after deploy, by a validator engine that is not the builder (Iron Rule #1):

1. Every published URL in all five sitemaps renders the canonical nav. Not a sample of the
   pages you know — the sitemaps, all of them, including the 133 `faq-item` singles.
2. On every one of them the rendered item set is **byte-identical in labels and targets** to
   the canonical source. Diff it; do not eyeball it.
3. **Zero menu links resolve to a 301 or a 404.** Check the status of every target, and do
   not follow redirects while checking — `urlopen` follows them silently and will report a
   bouncing link as healthy.
4. Mobile behaviour from M-12 Phase A still passes unchanged on the four pages you verified.
5. No page renders two navigations, and none renders zero — except `/en/`, which stays as it
   is until team_00 rules.

Report to team_100 with the live evidence, not with a summary of the diff.
