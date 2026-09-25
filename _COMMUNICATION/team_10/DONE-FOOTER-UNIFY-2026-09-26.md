# DONE — one unified footer, from one source — 2026-09-26

Mandate: `_COMMUNICATION/team_90/AUDIT-2026-09-26/MANDATE-FOOTER-UNIFY-2026-09-26.md`
Staging: `http://eyalamit-co-il-2026.s887.upress.link`
Theme version deployed: **1.5.132** (was 1.5.128; four intermediate deploys during
this round — see "Deploy history" below, each one a real defect found live and
fixed, not a cosmetic bump).

## Two mid-task rulings from team_00, applied

1. **Layout** (resolves the mandate's own open question): «השיטה ובלוג - שבלוג
   יהיה בפוטר ילד של השיטה». "בלוג דיג׳רידו" is nested under "השיטה" in the
   footer only, instead of standing as a seventh, single-link column. Six
   columns, none of them a bare single link:
   `אייל עמית · טיפולים בדיג׳רידו · שיעורים והכשרות · השיטה (+ בלוג) · כלים ואביזרים · ספרים`
2. **Headings are links**: «הכותרות בפוטר כולן גם עם קישור עליהן». Every column
   heading is an `<a>` to that item's own tree href.

Both overrides live in `ea_footer_unified_columns()`
(`site/wp-content/themes/ea-eyalamit/inc/ea-canonical-nav.php`), documented in
place as owner decisions, applied only at render time — `ea_canonical_nav_items()`
itself is unchanged (verified: `git diff` on that function is empty).

## Correction to the mandate itself

The mandate states "ספרים... is a child of «כלים ואביזרים»." Measured against
the actual tree in `inc/ea-canonical-nav.php`: **it is not** — "books" is
nested under **"אייל עמית"** ("eyal-amit"), between "galleries" and "contact".
"כלים ואביזרים" ("shop")'s own children are shop/repair/didgeridoos/bags/
stands-storage/stand-floor — no books entry. This did not change what I built
(promote "books" to its own column, regardless of which parent it comes from),
but the mandate's stated reason was wrong, so I did not implement it as
written — I implemented the correct, measured structure instead, and the
override is commented accordingly in the code.

## Success criteria — measured

**Exactly one footer element per page, on all 136 live pages, including
/press/.** Enumerated the REST API (`/wp-json/wp/v2/pages` + `/posts`,
`per_page=100&status=publish`, paginated): 153 objects (101 pages + 52 posts).
Fetched every URL with redirects NOT followed (custom Python handler verified
against `curl -sI` first, byte-identical results on 3 test URLs including two
known 301s). Result: **136 return 200, 17 redirect** — matches the mandate's
own stated split exactly. Regex-counted `<footer` on all 136 200-status
bodies: **136/136 have exactly 1**, zero have 0, zero have more than 1. Zero
PHP error strings (`Fatal error`, `Parse error`, `Warning:.*on line`,
`Notice:.*on line`, `Deprecated:.*on line`) on any of the 136.

`/press/` specifically: was 7 `<footer>` elements (5 testimonial-card
citations + Wave2's own footer + GeneratePress's site-info bar) →
**verified 1** in a rendered browser (`document.querySelectorAll('footer').length`).
Three separate defects, not one — see "What actually caused /press/'s seven
footers" below.

**Exactly one rendering of the menu in the footer. Zero duplicated links
between one footer region and another.** Extracted the `.ea-ftr` block from
all 136 pages and diffed its link set: **33 unique links, identical on every
page** (28 internal + 4 social + 1 tel), which is exactly what the tree
produces (26 unique internal hrefs after de-duplicating shared parent/first-
child hrefs, + accessibility + privacy = 28). Found and closed a **fifth**
footer content source not named in the mandate — see below.

**The item set in the footer menu equals the visible item set of
`ea_canonical_nav_items()` exactly, compared in both directions**,
`html.unescape`'d. Walked the tree by hand against the 33-link audit above:
every tree leaf (with `'hidden'` skipped and `courses-external` confirmed
absent) has exactly one corresponding footer link, and every footer link
traces to exactly one tree leaf or the two named legal-strip exceptions
(accessibility, privacy — explicitly sanctioned by the mandate's content
law). No extra items, nothing dropped. Not concluded from a count alone —
the actual href/label pairs were compared.

**«ספרים» renders as its own column, with its five children under it.**
Live DOM dump on `/press/`: heading "ספרים" → `/books/`, children "מוזה הוצאה
לאור" → `/books/`, "מבצעים" → `/books/#books-bundle`, "צבע בכחול וזרוק לים" →
`/books/tsva-bekahol/`, "כושי בלאנטיס" → `/books/kushi-blantis/`, "וכתבת" →
`/books/vekatavta/`. Five children, exactly the tree's five.

**`courses-external` appears zero times.** Regex-searched the `.ea-ftr` block
of all 136 pages: 0 occurrences. (It appears, expectedly, in the unrelated
`.ea-ftr`-independent page content of `/learning/courses-external/` itself —
its own URL/canonical tag — never in any footer.)

**Every footer link returns 200 with redirects NOT followed — zero 301s,
including on /press/.** Checked all 28 unique internal footer hrefs
individually (same verified no-redirect handler): **28/28 return 200**, zero
redirects. This includes `/eyal-amit/mokesh-dahiman/`, all five `/books/...`
routes, and every `/learning/...` child — all real trailing-slash URLs
straight from `home_url()` in the tree, which is why "14 of 16 missing a
trailing slash" cannot recur: there is no second, hand-typed copy of these
hrefs left anywhere in the footer to drift.

**The legal strip is last, centred, and the only light-toned region** —
verified in a rendered browser, not markup. On `/treatment/` (a Chapters
page, so the sticky-reveal wrapper is in play — see below): scrolled with a
real wheel event (not `window.scrollTo`, which silently no-ops in this
browser tool — see "Tooling note"), then confirmed with
`document.elementFromPoint()` at the legal strip's own centre that the
topmost painted element there is inside `.ea-ftr__legal` (`legalIsTopmost:
true`) — the exact trap the mandate warned about, hit and handled. Computed
style: `background-color: rgb(250, 248, 245)` (`--ea-bg`), `text-align:
center`, and it is `.ea-ftr`'s `lastElementChild` on every render path
checked (Wave2 `/press/`, Chapters `/treatment/`, EN `/en/`, GP-fallback
`/historical-articles/`).

**Contrast, as a number, per text level** (measured live on `/press/`,
`getComputedStyle` + WCAG relative-luminance formula, alpha-composited
against the actual painted background — the naive version of this
calculation silently ignores `rgba()` alpha and reports a false "19.8:1"
for everything; caught and fixed before trusting the numbers):

| Element | Color | Effective bg | Size | Contrast | Floor |
|---|---|---|---|---|---|
| Column heading (`.ea-ftr__col-title`) | rgba(255,255,255,.92) | `--ea-ink` #2E2B28 | 11.05px / 500 | **12.14:1** | 4.5:1 |
| Column link (`.ea-ftr__col-list a`) | rgba(255,255,255,.68) | `--ea-ink` | 13.6px / 300 | **7.35:1** | 4.5:1 |
| Contact name | rgb(255,255,255) | `--ea-ink` | 21.25px / 500 | **14.07:1** | 3:1 (large) |
| Legal disclaimer | `--ea-text-body` #5A3826 | `--ea-bg` #FAF8F5 | 12.24px | **9.77:1** | 4.5:1 |
| Legal copyright line | `--ea-muted` #6F635A | `--ea-bg` | 12.24px | **5.49:1** | 4.5:1 |
| Legal strip links | `--ea-accent-strong` #AB3A2B | `--ea-bg` | 12.24px | **5.88:1** | 4.5:1 |

All six clear their threshold with margin.

**Zero horizontal overflow at 390px on all four render paths** — measured
`document.documentElement.scrollWidth - window.innerWidth` at an emulated
390×844 viewport: `/press/` (Wave2) = 0, `/treatment/` (Chapters) = 0, `/en/`
= 0, `/historical-articles/` (GP-fallback) = 0.

**`ea-tokens.css` and the canon are untouched.**
`git diff d5c99e6 HEAD -- .../ea-tokens.css _COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md`
is empty (`d5c99e6` = the commit at session start). No new `--fs-*`/`--fw-*`
rung, no new colour token — `ea-footer-unified.css` uses only `--ea-ink`,
`--ea-bg`, `--ea-text-body`, `--ea-muted`, `--ea-accent`, `--ea-accent-strong`,
`--ea-line`, `--ea-font`, plus `rgba(255,255,255,N)` opacity layers on top of
those (same convention the sitemap row's own CSS used before it was deleted).

## What actually caused /press/'s seven footers (three separate defects)

1. **Three copies of the testimonial-citation markup**, all using a literal
   `<footer class="ea-testimonial-card__footer">` for a quote's attribution
   (valid HTML5, but it made the page's `<footer>` count ambiguous against
   this project's own gate). Two were named findable by file name
   (`template-parts/blocks/block-testimonials-row.php`,
   `block-testimonials-carousel.php`) — fixed first, then measured live and
   found **`/press/` uses neither of those**; the real one is
   `ea_w2_07_render_testimonials_accordion()` in `inc/wave2-w2-07.php`, a
   third, previously undocumented copy. All three changed `<footer>` → `<div>`
   (same class, same CSS, same visual result — verified: `/press/` screenshot
   unchanged).
2. **GeneratePress's own "site-info" credit bar** rendered alongside Wave2's
   footer. `generate_show_footer` and `generate_show_credits` filters (both
   set false in `functions.php`, documented as GP's own extension points) did
   **not** suppress it — measured live, the bar still rendered after that
   deploy. Since the parent theme's `footer.php` is not vendored in this
   repo (installed on the server only), there is no source to fix or a
   confirmed hook name to trust. Fixed at this theme's own delegation point
   instead: `footer.php` now buffers its `load_template()` call to the
   parent and regex-strips just the `<footer class="site-info">` element
   before echoing the rest — `ea_render_unified_footer()`'s own `wp_footer`
   hook still fires inside that same buffer and is re-emitted untouched.
3. A **fifth, previously unnamed footer content source**: a WP-admin nav
   menu at the `ea_footer_legal` location, unconditionally hooked to
   GeneratePress's `generate_before_footer` action on every page — meaning
   it fired regardless of which of the mandate's four named render paths
   also ran. It duplicated five of the six links now in the unified footer
   (FAQ, galleries, testimonials, privacy, accessibility). Unhooked (function
   left in place, menu location still registered) — its one non-duplicate
   item, "תקנון" (terms), now has no footer link. Not silently patched with
   an invented legal-strip link, since the mandate's content law names only
   accessibility + privacy for that strip: **flagging this for team_00/
   team_90 to decide**, not deciding it myself.

## Layout decision (superseded by team_00's own ruling, recorded above)

Before team_00's live ruling arrived, my own plan for the mandate's "seven
columns, two of them single-link" problem was a CSS `repeat(auto-fit,
minmax(150px,1fr))` grid, letting short columns sit naturally among the full
ones rather than forcing a fixed 7-wide grid. That question was overtaken by
team_00's own instruction (blog nests under method) before I built it, so the
actual shipped grid is a plain `repeat(N,1fr)` at four breakpoints (1 col
<480px, 2 cols ≥480px, 3 cols ≥768px, 6 cols ≥1024px — same buckets the now-
deleted sitemap row already used and had verified at 390px), which is simpler
because there is no longer a short column to route around.

**Contact block placement**: a distinct block below the nav grid (not a
sidebar column), full width, flex-wrapping brand/tagline/address/phone on one
side and the social icons on the other. Chosen over a sidebar-next-to-the-
grid layout to remove a whole class of mid-width overflow risk (a 6-column
grid plus a fixed sidebar competing for space between ~900–1199px) — given
"zero overflow at 390px" is a hard gate, I prioritised the simpler, more
predictable stacking over a closer visual match to the original 3-column
brand-as-a-column layout.

**Social icons**: standardised on Wave2's fuller/more-detailed SVG icon set
(`block-footer-social.php`'s previous markup) over Chapters' simpler generic
circles — both existed already; this is a choice of which existing
implementation becomes canonical, not new artwork.

## Content decisions inside "content law"

- Legal strip copy = Chapters' `section-footer.php` version (disclaimer +
  copyright + both legal links), not Wave2's shorter copyright-only line —
  chosen because it is the one that already carries the two links the
  mandate explicitly names for that strip.
- `tpl-chapters-en.php`'s footer now calls the same unified function (same
  Hebrew content, `lang="he" dir="rtl"`) rather than keeping separate English
  copy — same precedent the sitemap row it replaces already set on this
  exact page. Its old "לאתר העברי / Hebrew site" toggle link is kept as a
  small separate line above the footer (existing content, not dropped, not
  duplicated into the tree-driven part).

## Tooling note (not a site defect)

`window.scrollTo()` silently no-ops in this session's headless-browser tool
on this site (confirmed: `scrollY` stayed `0` after the call, with no error).
A real wheel-scroll action (`computer` tool's `scroll`) works normally. Flagged
since it produced one false reading (`legalIsTopmostAtCenter: false`) before
I identified it — re-measured with a real scroll and got the correct `true`.

## Deploy history this round

| Theme ver | What it fixed |
|---|---|
| 1.5.129 | Initial unified-footer implementation, all four render paths wired, sitemap row removed |
| 1.5.130 | Testimonial `<footer>`→`<div>` fix targeted the wrong 2 of 3 files; `generate_show_credits` added alongside `generate_show_footer`; unhooked the 5th duplicate nav source |
| 1.5.131 | Found the real 3rd testimonial-citation copy (`inc/wave2-w2-07.php`); GP filters still didn't suppress site-info → added the `footer.php` buffer/regex-strip |
| 1.5.132 | Fixed a `*/` inside `--fs-*/--fw-*` in the new CSS's header comment, which prematurely closed the comment block and silently dropped the base `.ea-ftr{background;color;overflow}` rule — footer was rendering with a transparent background before this fix |

Each row above is a real defect measured live after the previous deploy, not
a precautionary bump — team_90 will find all four in `git log`.

## Practical constraints

- `_aos/` not touched. `local/` not opened. `scripts/save_legacy_wp_app_password.py`
  not opened. `scripts/s007_render_work_ssot.py` not run (its pre-existing
  modified state from another concurrent session was left alone).
- Deploy: `python3 scripts/ftp_deploy_site_wp_content.py`, no `--allow-dirty`
  ever used — `site/` was committed before every deploy.
- **Concurrent session note**: this repo had other commits land on `main`
  mid-task from a different session (team_10 "A14"/"B13" work, an unrelated
  Yoast XML-sitemap item and an accessibility draft — confirmed unrelated by
  reading their diffs). No file overlap with this mandate's changes.

### git status — at session start
```
M scripts/s007_render_work_ssot.py
?? _COMMUNICATION/team_90/AUDIT-2026-09-26/MANDATE-FOOTER-UNIFY-2026-09-26.md
?? scripts/save_legacy_wp_app_password.py
```

### git status — now
```
 M _COMMUNICATION/team_100/S006/DEPLOY-LOG.md
 M scripts/s007_render_work_ssot.py
?? scripts/save_legacy_wp_app_password.py
```
(`DEPLOY-LOG.md` changed only because `ftp_deploy_site_wp_content.py` appends
one line per deploy; `scripts/s007_render_work_ssot.py`'s modification and
`save_legacy_wp_app_password.py` are pre-existing, not mine, both left alone
per the mandate's own instruction.)

## Files changed

- `site/wp-content/themes/ea-eyalamit/inc/ea-canonical-nav.php` — the unified
  footer: `ea_footer_unified_columns()`, `ea_render_unified_footer_column()`,
  `ea_render_unified_footer()`, replacing the sitemap-row functions.
- `site/wp-content/themes/ea-eyalamit/assets/css/ea-footer-unified.css` (new) /
  `ea-footer-sitemap.css` (deleted).
- `site/wp-content/themes/ea-eyalamit/functions.php` — enqueue swap,
  `generate_show_footer`/`generate_show_credits` filters, unhooked the 5th
  duplicate nav source.
- `site/wp-content/themes/ea-eyalamit/footer.php` — GP site-info strip.
- `site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-footer.php`,
  `template-parts/blocks/block-footer-social.php`,
  `page-templates/tpl-chapters-en.php` — now call the one function.
- `site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-testimonials-row.php`,
  `block-testimonials-carousel.php`, `inc/wave2-w2-07.php` — `<footer>`→`<div>`
  citation fix.
- `site/wp-content/themes/ea-eyalamit/style.css` — version 1.5.128 → 1.5.132.

## Open item for team_00 / team_90

"תקנון" (terms) has no footer link after unhooking the duplicate
`ea_footer_legal` menu (see above). It is not in `ea_canonical_nav_items()`,
so I did not invent a link for it under the mandate's content law. Options:
add it to the tree (changes the main menu/drawer too — outside this
mandate), add it to the legal strip alongside accessibility/privacy (a
content decision the mandate didn't make), or leave it unlinked from the
footer. Flagging rather than deciding.
