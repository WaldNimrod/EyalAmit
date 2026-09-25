# Mandate — Wave 1 — the ten decided board items — 2026-09-25

**Approved by team_00. The site is close to go-live.** Ten items in the «ממתין לנימרוד» section were
decided verbally; this wave executes them. **Team 90 re-measures every one and closes a card only on
its own measurement, never on your report.**

- **Repo:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026` — branch `main`
- **Live staging:** `http://eyalamit-co-il-2026.s887.upress.link` — plain HTTP on purpose; the
  certificate is invalid **by design** and is never a defect
- **Live theme:** read `Version:` in `site/wp-content/themes/ea-eyalamit/style.css` before bumping —
  it is a shared counter that moved a dozen times yesterday
- **Language:** Hebrew to Nimrod. Code comments and your report in English

**Run `git status` and `git log --oneline -3` before you start and again before you deploy, and
record both.** Several sessions worked in this checkout and one silently reverted another's edits.
**Five commits are sitting locally unpushed because the environment blocked the push — do not
attempt to push and do not rewrite history.** Build on top of them.

## Four rules that override your judgement

**1 — Content law.** You may move or restore text that already exists. **You may not write new
copy** — not a question, not an answer, not a caption, not a description. **Two tasks below put you
face to face with this**, and one of them exists *because* the rule was broken before.

**2 — The canons are locked, with one authorised exception.** Task A8 adds a new typography rung
**deliberately and with documentation**. Everything else: no colour token, no font-size token.

**3 — Verify on the rendered page.** A lint is not a render, a diff is not a render, and counting
elements in HTML is not a render. Fetch the real URL with its status code, **do not follow
redirects**, and read a box only after layout settles.

**4 — Report a gap, never fill it silently.** A gap that goes to Nimrod or Eyal must be recorded, or
it looks exactly like a gap that never existed.

## Practical constraints

- **Never open or commit anything under `local/`.** **`_aos/` is a read-only snapshot.**
- **Never `git add -A` or `git add .`** — explicit paths only.
- **Deploy:** `python3 scripts/ftp_deploy_site_wp_content.py` ships the working tree and **refuses a
  dirty `site/`. Never force past that refusal** — stop and report.
- Leave the untracked `scripts/save_legacy_wp_app_password.py` alone. **Do not open it.**
- **⚠ Do NOT run `scripts/s007_render_work_ssot.py`.** It is three rounds stale and **would overwrite
  both Eyal's live form and Nimrod's board** with an outdated version. Edit those files directly.

---

## Order of execution — visible and blocking first

### 1 · A7 — one string, two pages

The file `mokesh-eyal.jpg` carries two different `alt` values. **Measured: it is `alt` only** — zero
occurrences in visible body text on either page, and no `title` attribute.

    /eyal-amit/mokesh-dahiman/   alt="מוקש דהימן עם אייל עמית ברישיקש, הודו"     ← keep this one
    /eyal-amit/                  alt="אייל עמית עם המאסטר מוקש דהימן ברישיקש, הודו"  ← replace

**team_00's rule: if it is meta, make it uniform.** Both pages carry the memorial page's wording.
**Do not invent a third wording.**

### 2 · A5 — twelve live pages still link to the old site. **This blocks the old-site deletion.**

Measured across all 137 live pages: **twelve carry links to `eyalamit.co.il`**, and **two of them
pull an image from there** (`.../wp-content/uploads/2014/07/צוותא-אייל-עמית...`).

**When the old site is deleted those twelve break, and the two images vanish from the page.**

**Find each one and repoint it at the equivalent on the new site.** Where no equivalent exists,
**leave the link and report it** — do not point it somewhere plausible. **For the two images: the
file must be served from the new domain**, not hot-linked.

This is note #8 of the seventeen Eyal sent on 18.9 — **asked three times, never tasked.**

### 3 · A9 — one nav row, and one leak

**Add a row under «ספרים» titled «מוזה הוצאה לאור»** pointing at `/books/`, in
`inc/ea-canonical-nav.php`.

**Why:** in the mobile drawer a parent with children renders as a `<button>` with no `href`, so the
parent's own page is unreachable. Four of five sections are rescued by a named child pointing at the
parent's URL. **«ספרים» is the only page in the whole tree without one** — it is reached only via the
fragment `/books/#books-bundle` on the «מבצעים» row.

**The mechanism already works at three levels** — the renderers recurse, the JS selects by attribute
not by depth, the CSS reveals at both depths. **Only this convention was missing. One data row.**

**And close a leak:** `/learning/courses-external/` is hidden in the Hebrew nav (`'hidden' => true`,
Eyal's instruction) **but the English page still links to it.** Make `/en/` honour the same
exclusion.

### 4 · A8 — a dedicated token for form fields

**iPhone zooms the page when a focused input is under 16px.** The fields currently use the shared
`--fs-xs` rung.

**Do NOT change `--fs-xs`.** It is used in **52 places across 8 stylesheets** — labels, footer links,
FAQ, shop, books — **and none of those cause zoom.**

**Add a new rung for form controls only, at 16px**, and use it on the CF7 text, select and textarea
controls. The canon's own comment already describes `--fs-xs` as «labels, form controls, footer
links» — **splitting form controls out is a distinction the canon already draws.**

**This is an authorised, documented canon change:** add the rung to `assets/css/ea-tokens.css` **and
update `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md` in the same commit.** A token change
without the canon updated is a violation; this one is not, because it is recorded.

### 5 · A1 — `/shows-heritage/` becomes a 301 to the home page

**Measured:** zero inbound links from any of the 137 live pages. The entire visible body is the
three-word internal phrase «ניווט משני.». **And the URL does not exist on production at all** — it
404s there; the production equivalent is a different URL.

**Do:** 301 `/shows-heritage/` → the home page. Remove its `page-sitemap.xml` entry, the synthetic
description at `inc/seo-head-fallbacks.php:136`, and the `CollectionPage` schema node at
`mu-plugins/ea-w2-seo-schema.php:333`. **All three were written to paper over an empty body.**

**Do not touch the old production site.** Its `/הופעות/` is a separate board item.

### 6 · A2 — the six-question FAQ block on the home page. **The largest task, and the riskiest.**

**The component already exists and was built for this exact purpose:**
`template-parts/blocks/block-faq-mini.php`. Its CSS is already live in `ea-atoms.css`. **Extend it.
Do not build a fourth FAQ renderer — three already exist in this theme.**

**Two defects in it you must fix, not work around:**

1. **It contains invented content.** Of its four fallback questions, **two exist nowhere in the
   133-question corpus**: «האם טיפול בדיג׳רידו מתאים גם למי שאין לו ידע מוזיקלי?» and
   «כמה מפגשים נדרשים כדי לראות שינוי?». Team 90 verified this directly against the corpus.
   **Remove them.** This is live invented content in the theme and it is very likely where an earlier
   incident came from.
2. **It prints answers through `esc_html()` inside a hard-coded `<p>`.** Corpus answers contain
   `<p>`, `<ul>` and `<a>`. **Use `wp_kses_post()` as `block-faq-list.php` does**, and drop the
   wrapper — otherwise literal tags appear on screen.

**Read from the CPT, not the JSON.** `ea_faq_query_items()` in `functions.php:462`. The JSON is the
canonical text in the repo, but rendering from it would drift the moment someone edits a question in
wp-admin.

**The six questions, by seed key — verbatim, question and answer both:**

    treatment-01   מה זה בעצם טיפול בדיג'רידו?
    treatment-02   מה ההבדל בין טיפול בדיג'רידו לסאונד הילינג?
    treatment-03   האם צריך ניסיון קודם בנגינה?
    general-01     איפה מתקיימים המפגשים?
    general-05     כמה זה עולה?
    general-17     איך קובעים שיחת היכרות?

**Placement:** between `section-home-09-peek` and `section-05-testimonials` in
`page-templates/tpl-chapters-home.php`. **The build spec §7 puts the short FAQ exactly there**, right
before the testimonials. Note the home page has no sections array — it is a hardcoded sequence, so
this is a template edit.

**⚠ Emit NO `FAQPage` schema on the home page.** The spec (§15.3) restricts it to the dedicated page,
and the home page currently emits zero. **Leave a comment at the block saying so**, so a future wave
does not "fix" it into a duplicate entity on the site's highest-authority URL.

### 7 · A3, A4, A6 — registration, not building

**A3** — `/stand-floor/` and `/books/` have no work item. Both live, both 200. **Add a tracking item
for each** in `_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json`.

**A4** — **Do not start a governance project.** We are at the end of a phase and the AOS environment
is due to change. **A short procedure in the file's own comments only**: how Eyal's form and Nimrod's
board complement each other, and that a gap on neither is an open gap. **No new document, no process.**

**A6** — the old Mukesh page **stays untouched**. **Add a card to Eyal's form** with options and a
reasoned recommendation of what to do with it and why.

### 8 · A10 — nothing to build

`/en/` without breadcrumbs is **approved** — it is a root like `/`. **Mark the board card closed.**

---

## Cards to add to Eyal's form

Three, in the live form and its tracked source — **each with a heading naming its page, the live URL,
an «אחר» option with a free-text field, and at least one option that hands something over:**

1. **The six FAQ questions** — explain that we chose them, show all six, ask him to approve or say
   which to swap.
2. **The old Mukesh page** — options plus our reasoned recommendation.
3. **A map of the 48 printed-code pages.** team_00: the QR island is intentional — entry is by
   scanning — **but Eyal needs a convenient way to reach them all.** One card listing every
   `/qr/qrN/` page with a live link each. **Not a menu item.**

---

## Success criteria — Team 90 measures these, and they were written before you started

- **Full regression across every published URL:** 200, **exactly one primary nav per page**, zero PHP
  error strings. **A template change took this whole site down once already in this project.**
- **A2:** all six questions and answers **exist verbatim in the corpus** · **zero `FAQPage` on the
  home page** · **zero literal tags visible** · the two invented fallback questions are gone.
- **A5:** **zero links to `eyalamit.co.il`** across all live pages, and both images served from the
  new domain.
- **A7:** both pages carry the identical `alt`.
- **A8:** fields render at 16px · **no zoom on focus at iPhone width** · **all 52 other `--fs-xs`
  usages unchanged** · the canon document updated in the same commit.
- **A9:** «מוזה הוצאה לאור» appears on desktop and in the drawer and returns 200 · `/books/` has a
  plain link of its own in the drawer · the English page no longer links the hidden courses page.
- **A1:** `/shows-heritage/` returns **301** to the home page and is gone from the sitemap.
- **`assets/css/ea-tokens.css`** changed **only** by the new rung — Team 90 diffs it.

## Report

`_COMMUNICATION/team_10/DONE-WAVE1-2026-09-25.md`. Per item: **the live URL, the status code, and the
measurement that proves it** — not a description of what you changed. Include both `git status`
readings, the theme version deployed, and the three form cards with their live URLs.

**If any item turns out to be wrong, say so and do not implement it.** Refusals with a measurement
behind them have saved this project repeatedly, including one that caught Team 90's own error.
