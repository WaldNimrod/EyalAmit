# DONE — nav tree rebuild (2026-09-24)

## Scope

Implemented `MANDATE-TEAM10-NAV-TREE-2026-09-24.md` plus the same-day amendment
(delivered mid-task, adding testimonials/faq/galleries as children of "אייל עמית").
Single source of truth changed: `site/wp-content/themes/ea-eyalamit/inc/ea-canonical-nav.php`
(`ea_canonical_nav_items()`). No other tree was hand-edited.

## git status — before

```
On branch main
Your branch is ahead of 'origin/main' by 2 commits.
(clean under site/ except the two pre-existing social-footer files)
 M site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-footer-social.php
 M site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-footer.php
```
Recent commits at start: `5b330f0`, `b44e91f`, `31ea7a0`.

## git status — right before deploy

Same two social files still present and byte-identical to their pre-task diff
(re-read in full before committing); my own edits added on top:
`inc/ea-canonical-nav.php`, `style.css`, `template-parts/chapters/section-nav.php`,
`template-parts/nav/nav-drawer.php`. Nothing had been reverted.

## The amendment

Team 00 sent a follow-up mid-task: "אייל עמית" gains **testimonials, faq, galleries**
between מוקש and צור קשר (6 children total). This arrived before any deploy, so it
was folded into the same edit — no rollback was needed. All three new targets were
verified live (200) before implementing, independently of the amendment's own claim.

## What changed

`ea_canonical_nav_items()`: removed the standalone "home" entry; moved "אייל עמית" to
first position as a real link (`/eyal-amit/`) with six children; added a new
"טיפולים בדיג׳רידו" parent (treatment/sound-healing/snoring, relabelled per spec);
merged "שיעורי דיג׳רידו" + "לימוד והכשרה" into "שיעורים והכשרות" (5 children, relabelled);
kept "השיטה" level-1 after the two service buttons; left שop/books/blog unchanged.
"קורסים דיגיטליים" stays in the array (real href) with a new `'hidden' => true` flag.

Three renderers loop over `children` and needed a one-line skip for `hidden` items to
keep that page out of the rendered menu while still resolving directly: the GP-header
filter and Chapters `section-nav.php` (both in this file/theme, per the mandate's
"nowhere else" rule these are the renderers that read the array, not new copies of the
tree) and the shared mobile-drawer template `template-parts/nav/nav-drawer.php`. No
item list was duplicated anywhere.

`style.css` `Version:` bumped **1.5.121 → 1.5.122**.

`assets/css/ea-tokens.css` — untouched, confirmed via `git status --short` (clean).

## Rendered-page verification (live staging, redirects NOT followed)

**Level-1 items on `/eyal-amit/`, in order (7):**
1. אייל עמית
2. טיפולים בדיג׳רידו
3. שיעורים והכשרות
4. השיטה
5. כלים ואביזרים
6. ספרים
7. בלוג דיג׳רידו

No "בית". No "קורסים דיגיטליים" anywhere in the rendered menu.

**"אייל עמית" children, in order (6):** אודות אייל → `/eyal-amit/`, מוקש דהימן — לזכרו →
`/eyal-amit/mokesh-dahiman/`, המלצות → `/testimonials/`, שאלות ותשובות → `/faq/`, גלריה →
`/galleries/`, צור קשר → `/contact/`.

**Every remaining menu target — status code, redirects not followed:**

| URL | Status |
|---|---|
| /eyal-amit/ | 200 |
| /eyal-amit/mokesh-dahiman/ | 200 |
| /testimonials/ | 200 |
| /faq/ | 200 |
| /galleries/ | 200 |
| /contact/ | 200 |
| /treatment/ | 200 |
| /sound-healing/ | 200 |
| /snoring-sleep-apnea/ | 200 |
| /lessons/ | 200 |
| /learning/therapist-training/ | 200 |
| /learning/lectures/ | 200 |
| /learning/workshops/ | 200 |
| /method/ | 200 |
| /shop/ | 200 |
| /repair/, /didgeridoos/, /bags/, /stands-storage/, /stand-floor/ | 200 |
| /books/, /books/tsva-bekahol/, /books/kushi-blantis/, /books/vekatavta/ | 200 |
| /blog/ | 200 |
| /learning/courses-external/ (hidden, direct URL only) | 200 |

**Mobile drawer** (`<dialog id="ea-nav-drawer">`, shared server-rendered markup):
same 7 top-level items, same order; "אייל עמית" shows all 6 children in order;
"קורסים דיגיטליים" correctly absent.

**Breadcrumb** — checked on the three pages the mandate names:
`/books/tsva-bekahol/`, `/learning/lectures/`, `/repair/` — all three render
`<nav class="ea-crumb">` with "בית" as the first link, unchanged markup/logic
(`ea_breadcrumb_trail()` was not touched; it hardcodes "בית" as its own first crumb).

**Nav count (exactly one primary nav) — checked on 8 pages:**
`/` (1), `/shop/` (1), `/blog/` (1), `/qr/` (1), `/thank-you/` (1),
`/books/tsva-bekahol/` (1), `/learning/lectures/` (1), `/repair/` (1).

**Footer social links** — confirmed live and unaffected by this deploy: the four
icons in `section-footer.php` point at the real Facebook/Instagram/YouTube/TikTok
profiles, not `/contact/`. That work belongs to another session
(`DONE-SOCIAL-LINKS-2026-09-24.md`); it was bundled into my commit only because
`ftp_deploy_site_wp_content.py` refuses to ship a dirty `site/` tree, and it was
already dirty with that finished work when I started. Nothing in those two files
was edited by me.

## Two things found during verification that are outside this mandate's scope

**1 — `template-parts/blocks/block-topnav.php` (Wave2's own header block) carries its
own separate, hardcoded `$ea_topnav_items` array — a second, stale copy of the nav
tree that does *not* read `ea_canonical_nav_items()`,** contrary to this file's own
docblock claim that "the Wave2 header" is one of the renderers reading the single
source. I did not edit it (the mandate says "nowhere else," and hand-syncing a second
array under time pressure is exactly the kind of edit that has broken this site
before). **It is currently dead code on every published URL I could find that calls
it** — I checked `/blog/` (archive), a live blog single post, and `/qr/`, and all
three render only the Chapters nav (`id="nav"`), not `class="ea-topnav"`, both before
and after this deploy — so nothing regresses today. Flagging it because if that block
is ever wired back onto a live template, it will silently serve the *pre-2026-09-24*
eleven-item tree with the old labels.

**2 — Pre-existing, not introduced by this deploy: `/press/`, `/shows-heritage/` and
`/historical-articles/` each render *two* visible primary navs** — the Chapters bar
(`id="nav"`, injected by `inc/ea-open-round.php`'s `ea_open_round_inject_chapters_nav()`
on `wp_body_open`) *and* GeneratePress's own `#site-navigation` menu (fed by this
file's `wp_nav_menu_items` filter). Only the GP mobile `.menu-toggle` button is hidden
by CSS for these "orphan" pages (`ea-nav-drawer.css`), not the GP menu bar itself, so
both are visible at desktop width. Both now correctly show the new 7-item tree — the
*content* is right — but there are two of them, which is a live violation of "exactly
one primary nav per page" that predates this mandate (I did not touch
`ea-open-round.php` or GP's menu registration). Not fixed here: it's a template/hook
change, not a tree change, and out of the "change it in ea-canonical-nav.php and
nowhere else" instruction. Recommend a follow-up ticket.

## Deploy

- Theme version deployed: **1.5.122**
- Commit pushed: **`79bb680`** (`S007 M-14: rebuild the primary nav tree at theme 1.5.122.`)
- `python3 scripts/ftp_deploy_site_wp_content.py` ran clean (site/ was committed first
  so the script's dirty-tree guard did not need `--allow-dirty`)
- `git push`: `31ea7a0..79bb680 main -> main`

## git status — after

`site/` is clean (`git status --short site/` empty). Branch `main` up to date with
`origin/main`. `git log --oneline -3`: `79bb680`, `5b330f0`, `b44e91f`.
