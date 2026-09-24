# DONE — Task 0 / Task A / Task B (Eyal's rebuilt form) — 2026-09-24

Builder: Team 10. Mandate: `_COMMUNICATION/team_90/AUDIT-2026-09-24/MANDATE-FINAL-FORM-2026-09-24.md`,
plus four live coordinator additions folded in during the session (home icon, legal-docs cards,
form refinements, contrast approval).

## git status / git log — both readings

**Before starting**, `site/` was clean; only `_COMMUNICATION/`, `scripts/` (untracked/modified by
earlier sessions today) showed changes. `git log --oneline -3`:

    7423724 S007 Round C: team_10 report — nav depth, spotlight cards, classic breadcrumb
    eb99422 Round C: nav depth (ספרים→level3), spotlight cards reuse, classic breadcrumb
    99b956d S007 M-14 follow-up: team_10 report

**Before deploying**, `site/` had my own 8 edits and nothing else — no other session's theme edits
were present (`git status --porcelain site/` matched exactly the files below, and `git log` head
was still `7423724`, i.e. nothing landed on `main` from elsewhere while this session ran).

**After my commits**, `git log --oneline -4`:

    4a7fb69 Bump theme to 1.5.126 for the home-hero scrim fix
    0986042 Fix contrast scrim on the LIVE home hero (.hero__scrim), not block-hero.php
    b8f44ec S007 closing round: drawer dedupe, home icon, books placeholder CTA, contrast
    7423724 S007 Round C: team_10 report — nav depth, spotlight cards, classic breadcrumb

Plus `ef41d2d` (the form rebuild, committed separately — `_COMMUNICATION/` only, not `site/`).

**Deploy:** `python3 scripts/ftp_deploy_site_wp_content.py` refused once on a dirty `site/` — per
the mandate, this was **not** forced past with `--allow-dirty`. `site/` was committed first
(`b8f44ec`), then the deploy ran clean. A second, smaller fix (the home-hero scrim landed on the
wrong file the first time — see Contrast below) was committed (`0986042`, `4a7fb69`) and deployed
the same way a second time. Both deploys returned exit 0, full `wp-content` upload OK.

**Push:** attempted (`git push`) and was **blocked by the platform's own auto-mode safety
classifier** ("Out-of-Place Publication") — not a decision I made, and not something I tried to
work around. **Six commits are sitting locally on `main`, ahead of `origin/main`, not yet
pushed.** Nimrod, you'll need to run `git push` yourself (or explicitly tell me to retry it) —
I did not bypass the platform's own gate.

**Theme version deployed:** `1.5.124` → **`1.5.126`** (one bump for Task 0/A/contrast, a second
small bump when the home-hero scrim fix moved to the correct file).

**`assets/css/ea-tokens.css`:** untouched. `sha256` before and after:
`e2319b564c941517813c3c699d5847c82038e1b71c381a792ab1029a0f748f98` — byte-identical.

---

## Task 0 — drawer dedupe, footer redirects, home icon

**Verified before touching anything**, per the mandate's own instruction: the drawer's section
header is a `<button>` (accordion toggle), never a link — removing both the generated
"— עמוד ראשי" row and the named child would have made four pages unreachable from the drawer.
Confirmed live and in `inc/ea-nav-drawer.php` before editing.

- **Removed the generated `"{label} — עמוד ראשי"` row** as a renderer-level rule (one `if` block
  deleted in `ea_nav_drawer_render_item()`), not five hand-fixed rows — it fires at every depth,
  so it also silently caught the same pattern one level deeper, under "ספרים" (which the mandate's
  own five-row list already implied). Verified live: **zero** occurrences of "עמוד ראשי" in the
  homepage HTML after deploy (previously non-zero). Every affected parent's own page stays
  reachable — four via their already-existing named child, "ספרים" via its "מבצעים" child's
  `/books/#books-bundle` (loads the same document).
- **Six footer links, trailing slash added** (`/faq/`, `/galleries/`, `/testimonials/`,
  `/privacy/`, `/accessibility/`, `/terms/`). Measured live after deploy, redirects **not**
  followed:

      /faq/           200
      /galleries/     200
      /testimonials/  200
      /privacy/       200
      /accessibility/ 200
      /terms/         200

  (The bare, un-slashed paths still 301 — that's correct; the drawer's own `href`s now point at
  the slashed, 200 targets directly, which is what "a menu link that redirects is a failure"
  asked for.)

### Home icon (coordinator addition, mid-task)

Added a small monochrome home icon, first item (right-most in RTL), before "אייל עמית", in
**every** nav renderer this theme has: the Chapters desktop nav (`section-nav.php`), the mobile
drawer (`nav-drawer.php`), and the GeneratePress header (`ea_canonical_nav_gp_header_items()` in
`ea-canonical-nav.php`, for the pages that still render GP's own header — `about`/`services`/shop
family/singles — since Chapters nav isn't injected there). One shared function,
`ea_canonical_nav_home_link()`, builds the markup once; each renderer passes its own link class so
it inherits that renderer's existing colour via `currentColor` — no new CSS, no colour or
font-size token touched.

    <a class="nav__home" href="https://…/" aria-label="דף הבית">
      <svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" width="18" height="18">
        <path fill="currentColor" d="M12 3l8 7h-2v8h-5v-5h-2v5H6v-8H4l8-7z"/>
      </svg>
    </a>

- **Accessible name:** `aria-label="דף הבית"` on the `<a>`; `aria-hidden="true"` on the `<svg>`.
- **Desktop, live:** confirmed present (`nav__home`, `href="/"`, correct `aria-label`).
- **Mobile drawer, live at 375×812:** confirmed present and visually rendered as the first row,
  right-most, before "אייל עמית" — screenshot taken.
- **GP header:** confirmed present in the rendered menu markup on a GP-header page (`/services/`,
  which 404s for an unrelated, pre-existing reason but still renders `header.php` → the filter
  fired and `ea-gp-home__link` is in the output).
- **Level-1 count/order:** the six existing top-level items (אייל עמית, טיפולים בדיג׳רידו, שיעורים
  והכשרות, השיטה, כלים ואביזרים, בלוג דיג׳רידו) are unchanged in count and order; the icon is
  prepended, making seven total, matching the coordinator's own framing.
- **Links to `/` and returns 200:** confirmed.

---

## Task A — books-page offer, placeholder purchase button

**Content law:** the only existing offer text on `/books/` is the 3-book bundle — "חבילת 3 הספרים
של אייל עמית", 150 ₪ במקום 207 ₪ (`inc/chapters/defaults/muzza-defaults.php`). No second bundle
text exists on the new site (the old site's "2 books" bundle is dead — see the old-site card in
the form). One offer, one button; nothing invented.

**The July Green-Invoice sample URL (`mrng.to/MTUiO3vkIg`, belongs to `kushi-blantis`) was being
reused as this offer's own purchase link before this change** — exactly the mistake the mandate
warned against. Fixed:

- `cta_url` now points at `#books-bundle` (the section's own anchor — a no-op, never leaves the
  page, never reaches a checkout).
- Button style changed from the filled primary (`btn--terra`) to the ghost/outline style
  (`btn--gw`), so it doesn't read as a live purchase control.
- A visible pending-link note was added under the button, reusing the theme's own established
  `.ea-pending-inline` pattern (same component `product-cta.php` already uses for shop pages
  waiting on a real Green-Invoice URL): **"קישור רכישה זמני — ממתין לקישור חשבונית ירוקה מאייל."**
- `cta_label` ("לרכישת חבילת 3 הספרים") is untouched — Eyal's own approved copy.

Verified live: `<a class="btn btn--gw" href="#books-bundle">` with the pending note rendered
directly underneath.

**Not touched:** the three book pages' own purchase arrangements (per the mandate).

---

## Contrast (team_00-approved, folded in after the form)

### 1 — `.chap` eyebrow colour

`.phero .chap` (the eyebrow inside a page's photo hero — the dominant instance across pages, since
almost every inner page has a `.phero`) was resolving to `--terra-lt` (`#D08A5E`, 2.80:1 against
the measured near-white background). Changed to a **`.chap`-only** value, not a token edit:

    .phero .chap{color:#9A572D}   /* rgb(154,87,45), 5.55:1 against rgb(255,255,250) */

Same hue/saturation as `--terra-lt`, darker only. `--terra-lt` itself is untouched and still used
by `.sec--dark .chap` / `.studio__t .chap` / `.start .chap` (genuinely solid near-black fills,
where it already passes) and by unrelated elements (`.nav__l a::after`, `.tlink`, `.phero__h em`).

**Honest caveat, measured, not glossed over:** this fix is correct against a *flat* near-white
background, matching how it was approved. But `.phero .chap` sits on a *photo*, and the new bottom-
up scrim (below) is intentionally weakest near the top of the hero — exactly where the eyebrow
sits, above the H1. Live pixel-sampling on `/learning/` (compositing the actual photo pixel with
the scrim's true alpha at the eyebrow's position) found a worst-case contrast around **1.9:1** at
one bright spot (a light-coloured door in the background photo), well under 4.5:1. The fix is a
real improvement over the previous 2.80:1-against-white-only measurement and passes on most
photos, but it is **not guaranteed on every photo** — this is a genuine residual gap, not one I'm
claiming closed. Worth a follow-up round with per-photo spot checks if team_00 wants it fully
closed.

### 2 — bottom-up scrim on text-over-photo elements

One shared gradient, applied identically everywhere (not four separate treatments):

    linear-gradient(180deg, rgba(11,7,3,.22) 0%, rgba(11,7,3,.42) 50%, rgba(11,7,3,.72) 100%)

Applied to the four real scrim elements already in the markup (no new DOM):

| Element (text) | Scrim element | File |
|---|---|---|
| `.phero__h` / `.phero__s` | `.phero--media .phero__sc` | `assets/css/chapters.css` |
| `.phero__h` / `.phero__s` (compact variant) | `.phero--compact .phero__sc` | `assets/css/chapters.css` |
| `.bleed__a` | `.bleed__sc` | `assets/css/chapters.css` |
| `.hero__trust` | `.hero__scrim` | `assets/css/chapters.css` |

**One real mistake caught and fixed within this same round:** the first pass changed
`.ea-hero__overlay` in `assets/css/ea-atoms.css` (the Wave2 `block-hero.php` component) — but the
**live home page** renders `template-parts/chapters/section-hero.php` (`.hero` / `.hero__scrim` /
`.hero__trust`), a completely different component. Caught by checking `document.querySelector`
live before declaring done; fixed in a second commit (`0986042`) that targets the real element.
The `ea-atoms.css` edit was left in place too (harmless — same approved formula, in case that
component is ever used elsewhere) but the **live** fix is the `chapters.css` one.

**Verified live, before/after:**

- `.chap` inside `.phero`: computed colour `rgb(154, 87, 45)` (was `rgb(208,138,94)`).
- `.phero__sc` background: `linear-gradient(rgba(11,7,3,.22) 0%, rgba(11,7,3,.42) 50%, rgba(11,7,3,.72) 100%)` — confirmed via `getComputedStyle` on `/learning/`.
- `.hero__scrim` background: same gradient, confirmed via `getComputedStyle` on `/` (theme
  `ver=1.5.126` on the loaded stylesheet).
- `.phero__h` (large text, floor 3:1) on `/learning/`: worst sampled painted-pixel contrast
  **4.09:1** — passes. `.phero__s` (large text) on the same page: **4.86:1** — passes.
- Visual check (screenshots, desktop and phone): trust line on `/`, H1/eyebrow on `/learning/`,
  home icon in the drawer at 375×812 — all clearly legible.
- **Not touched:** the breadcrumb rows (left alone per the instruction), `.cmpc__p` (reported here
  only, not fixed, per the instruction — still 4.22:1 on the home page, 0.28 short of 4.5).

**`ea-tokens.css`:** unchanged (see hash above). No text colour or font-size token touched anywhere
in this round.

---

## Task B — Eyal's rebuilt form

**Read first, as instructed:** `MEETING-ANSWERS-EYAL-2026-09-24.md` and
`DECISIONS-LIVE-MEETING-2026-09-24.md`, plus `OLD-SITE-MIGRATION-AUDIT-2026-09-24.md` for Task B3.

**Deployed to the same live URL Eyal already has** (same file, same FTP path — no new link to
send):

    http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html

Confirmed live: HTTP 200, 21 `.item` cards, correct title.

### The rebuild, in order

The previous form (`FORM-EYAL-CONTENT-GAPS-2026-09-20.html`) is the same tracked file, rewritten
by hand (not through `scripts/s007_render_work_ssot.py` — that generator's data model doesn't
cover old-site-decision cards, Green-Invoice-link cards, or legal-sign-off cards, and retrofitting
it under time pressure risked breaking the 129-item content-gaps pipeline it also feeds). The
**status board at the top was removed** per the coordinator's live refinement ("no more מצב נגזר
noise") — the form now opens straight at the first real question.

**Persistence — same mechanism as before:** `localStorage`, key `'ea-s007-form-' + <content
signature>` (was `ssotSha12`, now a signature computed from this form's own 21 card ids —
`0547ed400c77`). Same pattern, new key, because the content genuinely changed — exactly how the
old form's own `ssotSha12`-keyed draft already behaved on every content change. The **notes
table's rows are folded into the same draft object** (`notesTable` array alongside `answers`), so
it saves and loads with everything else, not as a separate mechanism. Verified functionally in the
browser: "+ הוספת שורה" adds a 4-field row (עמוד / נושא / פרטים / קובץ מצורף או קישור), the ✕
button removes it, and the JSON export (`שמירת JSON`) includes `notesTable`. The file-attach field
says explicitly, in its own label, that only a link is accepted ("אין אפשרות לצרף קובץ בעמוד סטטי
זה — הדביקו קישור").

**Every card:** heading names the page, `<p class="path">` carries that page's live URL (old-site
cards say so explicitly — "אתר ישן" tag), and every card has an "אחר — פירטתי למטה" (or
equivalent) option with a free-text field — added even to the two cards whose meeting-answer text
said "two answers close this, no third" (`HW-2012-PHOTO`) and to the three multi-image/legal
cards that didn't have one in the first draft, per the coordinator's explicit "every card, no
exceptions."

### Card list — page and URL

**חלק א · שיעורי בית — 8**

| Card | Page | URL |
|---|---|---|
| לימוד והכשרה | /learning/ | http://eyalamit-co-il-2026.s887.upress.link/learning/ |
| העמוד באנגלית | /en/ | http://eyalamit-co-il-2026.s887.upress.link/en/ |
| תמונות לעמודי הקודים המודפסים | /qr/qr1/ (משפחה qr1–qr48) | http://eyalamit-co-il-2026.s887.upress.link/qr/qr1/ |
| כיתוב לחמש תמונות בעמוד התיקון | /repair/ | http://eyalamit-co-il-2026.s887.upress.link/repair/ |
| קרוסלת סרטונים | / | http://eyalamit-co-il-2026.s887.upress.link/ |
| מוזיקת רקע להירו | / | http://eyalamit-co-il-2026.s887.upress.link/ |
| תמונת הפוסט מ־2012 | פוסט קיים באתר החדש | http://eyalamit-co-il-2026.s887.upress.link/דיגרידו-פרדס-חנה-סטודיו-לבנייה-ונגינ/ |
| עמוד הגלריות — כפילות שאלה | /galleries/ | http://eyalamit-co-il-2026.s887.upress.link/galleries/ |

**חלק ב · קישורי רכישה — 4**

| Card | Page | URL |
|---|---|---|
| GI — צבע בכחול וזרוק לים | /books/tsva-bekahol/ | http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/ |
| GI — כושי בלאנטיס | /books/kushi-blantis/ | http://eyalamit-co-il-2026.s887.upress.link/books/kushi-blantis/ |
| GI — וכתבת | /books/vekatavta/ | http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ |
| GI — חבילת 3 הספרים | /books/#books-bundle | http://eyalamit-co-il-2026.s887.upress.link/books/#books-bundle |

**חלק ג · תוכן חסר — 1**

| Card | Page | URL |
|---|---|---|
| טור 41, חארטה בארטה | /blog/ (הטור עצמו חסר) | http://eyalamit-co-il-2026.s887.upress.link/blog/ |

**חלק ד · האתר הישן — 5** (each with 2–4 sample live links, old-site domain, all measured 200)

| Card | Sample URLs |
|---|---|
| עמודי תיק עבודות (25) | eyalamit.co.il/Blog/portfolio_page/{art-week-2014-malmo, superdollz-showroom, der-spiegel-cover-art}/ |
| מופע לדוגמה ×2 + מופע מתוארך | eyalamit.co.il/Blog/shows/{מופע-לדוגמה-4, מופע-לדוגמה-2, 11-7}/ |
| גלריות ספרים + אלבום | eyalamit.co.il/Gallery/{כושי-בלאנטיס-אייל-עמית, מטיילים-מצטלמים-צבע-בכחול, וכתבת}/ + eyalamit.co.il/album/16883/ |
| סיפורים מהנייר עם אייל עמית | eyalamit.co.il/Blog/סיפורים-מהנייר-עם-אייל-עמית/ |
| ארכיון (85 עמודים, כרטיס אחד) | eyalamit.co.il/Blog/tag/אייל-עמית/ (דוגמה מייצגת) |

**Measured discrepancy flagged on the card, not silently corrected:** the migration audit said
"four book galleries." Live re-measurement against the old site's own `envira-sitemap.xml` found
only **three** galleries with an explicit book name (כושי בלאנטיס, צבע בכחול, וכתבת) plus one
unrelated general-studio gallery and one Envira "album" CPT — three, not four, book galleries. The
card states this plainly and asks Eyal, rather than silently reconciling it.

**חלק ה · לאשרר משפטית — 3** (coordinator addendum: Nimrod said "two," three publish)

| Card | Page | URL |
|---|---|---|
| הצהרת נגישות | /accessibility/ | http://eyalamit-co-il-2026.s887.upress.link/accessibility/ |
| מדיניות פרטיות | /privacy/ | http://eyalamit-co-il-2026.s887.upress.link/privacy/ |
| תקנון | /terms/ | http://eyalamit-co-il-2026.s887.upress.link/terms/ |

The accessibility card states plainly that the wording is expected to change (the published
statement's own "known limitations" section currently discloses a focus-indicator prominence
issue that — per Team 90's record — was already fixed at theme 1.5.115, and the statement is also
waiting on the contrast decision) and that this confirmation is about legal substance, not final
text. All three cards carry a third option beyond approve/correct: "צריך שעורך הדין / רואה החשבון
שלי יעיף מבט" — the realistic answer for a legal sign-off.

All 21 cards' URLs measured **200**, redirects not followed (new-site URLs against staging; old-
site URLs against the live old site).

### Row-by-row mapping — nothing lost

| Row removed from the form | Where it lives now | Status in `S007-WORK-SSOT.json` |
|---|---|---|
| A3 — כתבות היסטוריות | Board (GALLERY.html) + SSOT | `waiting` / `answered` — content already transferred today (Task 2/3 of the meeting-answers dispatch); nothing further for Eyal to hand over |
| A5 — קורסים (סקולר וחיצוני) | Board + SSOT | `waiting` / `answered` — already executed (menu item removed today); nothing further for Eyal |
| B3 — בחירת תמונות לגלריה הראשית | Board + SSOT | `waiting` / `answered` — already executed today (149 images imported from the old homepage gallery) |

**B2 and P037 were not removed** — both are the coordinator's named exceptions (blocked pending
the meeting) and both stay on the form: B2 reframed as a closure-check ("does your answer on the
duplicate question already cover this one"), P037 reframed as the clean binary question
MEETING-ANSWERS itself proposed (photo or no photo). **Zero rows marked closed** — every row above
is still `waiting` in the SSOT, not `closed`; none of my edits touched that file.

---

## What was not implemented, and why

- **`--terra-lt` token itself:** not touched, per instruction — `.chap` got its own literal
  colour instead.
- **`.cmpc__p` (home page, 4.22:1):** reported, not fixed, per explicit instruction.
- **Breadcrumb `dark` argument at `inc/wave2-w2-07.php:940`:** not restored, per explicit
  instruction — that item is closed.
- **`.phero .chap` worst-case on bright photos:** see the honest caveat above — a real residual
  gap on some photos, not claimed as fully closed.
- **4th book gallery:** not found live; reported as a discrepancy on the form's own card rather
  than invented or silently dropped.

## Live URL — the rebuilt form

http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html
