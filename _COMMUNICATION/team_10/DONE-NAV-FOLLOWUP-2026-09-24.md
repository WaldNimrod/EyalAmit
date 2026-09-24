# DONE — nav tree follow-up (Task A + Task B), 2026-09-24

Team 10 (builder). Two follow-ups to the S007 M-14 nav-tree rebuild, dictated by team_00
while Eyal was in a live meeting. Both implemented, deployed to staging, committed, pushed.

## Pre-work: git state (per instruction, recorded before touching anything)

**`git status` at session start:**
```
On branch main
Your branch is up to date with 'origin/main'.
Changes not staged for commit:
  M _COMMUNICATION/team_10/DONE-PRE-MEETING-FIXES-2026-09-24.md
  M _COMMUNICATION/team_100/S006/DEPLOY-LOG.md
  M _COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html
  M _COMMUNICATION/team_100/S007/S007-WORK-SSOT.json
  M _COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html
  M _COMMUNICATION/team_90/AUDIT-2026-09-24/ACCEPTANCE-CRITERIA-2026-09-24.md
  M _COMMUNICATION/team_90/AUDIT-2026-09-24/MASTER-PRE-MEETING-AUDIT-2026-09-24.md
  M _COMMUNICATION/team_90/AUDIT-2026-09-24/README.md
  M _COMMUNICATION/team_90/AUDIT-2026-09-24/SESSION-STATE-2026-09-24.md
  M scripts/s007_render_work_ssot.py
Untracked: DONE-MEETING-ANSWERS-2026-09-24.md, DONE-SOCIAL-LINKS-2026-09-24.md,
  DONE-URGENT-PRE-MEETING-2026-09-24.md, several team_90/AUDIT-2026-09-24/* files,
  scripts/save_legacy_wp_app_password.py
```
`git log --oneline -3`: `f7e8bac` (M-14 report, 1.5.122) → `79bb680` (M-14 rebuild) → `5b330f0`.

None of the above were touched by this session — not committed, not opened for
`save_legacy_wp_app_password.py`, nothing under `local/` or `_aos/`. `git status` after
this session's commit shows the identical set of pre-existing modified/untracked files,
confirming nothing else was picked up.

`section-footer.php` and `block-footer-social.php` (the other team's social-link work) were
already clean/committed at session start — nothing to preserve mid-flight.

## Task A — level-1 parents now link to their first child

`site/wp-content/themes/ea-eyalamit/inc/ea-canonical-nav.php`: the two parent items that had
`'href' => null` ("טיפולים בדיג׳רידו", "שיעורים והכשרות") now carry their first child's own
href (`/treatment/`, `/lessons/`) — same rule "אייל עמית" already followed. No renderer
markup/JS changed: all three consumers of `ea_canonical_nav_items()` (Chapters
`section-nav.php`, the GeneratePress-header filter, the mobile drawer's accordion) already
branch on whether `href` is set, so they picked the change up automatically.

**Measured live on `/eyal-amit/` (Chapters template) after deploy — five parents, tag +
href:**

| Label | Tag | href | HTTP (no redirect follow) |
|---|---|---|---|
| אייל עמית | `<a>` | `/eyal-amit/` | 200 |
| טיפולים בדיג׳רידו | `<a>` | `/treatment/` | 200 |
| שיעורים והכשרות | `<a>` | `/lessons/` | 200 |
| כלים ואביזרים | `<a>` | `/shop/` | 200 |
| ספרים | `<a>` | `/books/` | 200 |

All five verified `curl -o /dev/null -w '%{http_code}'` → 200, no `--location`.

**`aria-haspopup` / `aria-expanded` toggle — measured on the rendered page** (not from
source), via the live DOM at 1440px width: all five still carry `aria-haspopup="true"`.
Focusing each toggle (the same interaction `ea-chapters.js`'s `focusin`/`focusout` listeners
react to, and equivalent to what hover does through `mouseenter`/`mouseleave`) flips
`aria-expanded` `false → true`; blurring flips it back `true → false`. Measured on all five
in one pass:

```
אייל עמית          false → true → false
טיפולים בדיג׳רידו   false → true → false
שיעורים והכשרות     false → true → false
כלים ואביזרים       false → true → false
ספרים              false → true → false
```

No regression on the previously-known accessibility defect.

Note on the GeneratePress-header pages (the ~6 orphan pages, e.g. `/press/`): there, none of
the five parents carry `aria-haspopup`/`aria-expanded` at all — including the three that were
already links before this change (אייל עמית, כלים ואביזרים, ספרים). That is pre-existing,
unrelated to this edit: that renderer only wires `aria-haspopup`/`aria-expanded` onto its
`<button>` branch (`ea-canonical-nav-gp-dropdown.js`), never onto its `<a>` branch, and it
already worked that way for the three link-items before today. The accessibility requirement
in the mandate is scoped to the Chapters `.nav__dd` mechanism, which is unaffected.

**Mobile drawer:** its parent row is a `<button class="ea-nd__acc-btn">` accordion regardless
of `href` — unaffected by tag choice. Because `href` is now set for these two, the drawer's
existing pattern (an extra "{label} — עמוד ראשי" row at the top of the submenu, already
present for the three original link-parents) now also appears for these two, consistent with
existing behaviour — not a new code path.

**Flag, not fixed — touch-tap defect risk:** `ea-chapters.js`'s submenu-disclosure block
(the `.nav__dd[aria-haspopup="true"]` listeners) wires **only** `mouseenter` / `mouseleave` /
`focusin` / `focusout`. There is no `click`/`touchstart` handler anywhere in that file that
intercepts a first tap to reveal the submenu before navigating. That means on a touch device,
a first tap on any of the five level-1 parents — now all five, not just the original three —
will navigate straight to the parent's own page; the submenu is not reachable by tap at all.
This was already true for the three existing link-parents before today; today's change
extends the same behaviour to two more items rather than introducing it. Per instruction,
this was flagged, not fixed — it is a separate decision for team_00/team_90.

## Task B — Mukesh menu label

`ea-canonical-nav.php`: the `mokesh-dahiman` item's `label` changed from
`'מוקש דהימן — לזכרו'` (em dash) to `'מוקש דהימן -'` (plain hyphen, as dictated), with a new
`'label_emph' => 'המורה שלי'` field. `label_emph` is not HTML inside `label` — it is a
separate array key. Every one of the three renderers (`section-nav.php`, the GP-header
filter, `template-parts/nav/nav-drawer.php`) now emits it as `<em>` + its own `esc_html()`
call, so both pieces of text stay individually escaped; nothing was placed in `label` that
could be shown as literal tag text.

Also fixed `ea_breadcrumbs_find_nav_chain()` in `inc/ea-breadcrumbs.php`: it built its crumb
text straight from `label`, which — unaddressed — would have shown the breadcrumb on
`/eyal-amit/mokesh-dahiman/` as the truncated "מוקש דהימן -" with a dangling hyphen. Added
`ea_breadcrumbs_full_label()`, folding `label_emph` back in (plain text, no `<em>` — a
breadcrumb crumb has no italic treatment of its own) so the crumb reads the full sentence.

**Scope respected:** the page's own title/H1 is untouched — still "מוקש דהימן — לזכרו" (em
dash). Only the menu label (and, as a side-effect fix, the breadcrumb crumb) changed. No
color or font-size token was touched; `ea-tokens.css` is byte-identical (`git diff` against
the previous commit is empty for that file).

**Rendered appearance — measured live, not from source:**
`outerHTML` on the live page: `<a href="…/mokesh-dahiman/">מוקש דהימן - <em>המורה שלי</em></a>`
— text content is exactly `מוקש דהימן - המורה שלי`, no literal `<em>`/`<span>` text visible.
`getComputedStyle(em).fontStyle` → `"italic"`. Same markup confirmed in the mobile drawer.

**Honest visual read:** Heebo has no real italic face here (`family=Heebo:wght@100;200;300;
400;500;600`, no `ital` axis, confirmed unchanged), so this is the browser's synthetic
(faux/oblique) slant on the Hebrew glyphs. At the submenu's actual size it is legible and not
badly distorted — Heebo's fairly geometric letterforms shear cleanly rather than smearing —
but it does have the mild "fake italic" look synthetic Hebrew slant usually has: slightly
uneven stroke weight on a few letters (מ, ה) compared to the upright text next to it. It
reads fine as a visual distinguisher; it does not read as a designed italic. team_00's call
on whether to keep it.

## Deploy

- Theme version bumped `1.5.122 → 1.5.123` (`style.css`, only shared counter touched).
- `python3 scripts/ftp_deploy_site_wp_content.py` run from the committed tree (see below) —
  completed successfully, `exit 0`, "Done: FTP deploy site/wp-content (child theme +
  mu-plugins)." No `--allow-dirty` used at any point.
- `_COMMUNICATION/team_100/S006/DEPLOY-LOG.md` new line: `2026-09-24T22:14:43+03:00 ·
  c8f06fbd6885 · main · theme 1.5.123 · 723 files` — clean (not `DIRTY`).

## Commit / push

Commit `c8f06fb` on `main`, explicit paths only (`inc/ea-canonical-nav.php`,
`inc/ea-breadcrumbs.php`, `template-parts/chapters/section-nav.php`,
`template-parts/nav/nav-drawer.php`, `style.css`) — no `git add -A`/`git add .` used. Pushed:
`f7e8bac..c8f06fb main -> main`.

## Post-deploy live verification summary

- All 5 level-1 parents: `<a>`, correct hrefs, all 200, no redirect.
- `aria-haspopup`/`aria-expanded` intact on all 5, toggling confirmed on the rendered page.
- Exactly one `nav.nav#nav` element per page (checked on `/eyal-amit/`).
- Mobile drawer: 7 top-level items, same labels as desktop; Mukesh label renders identically
  with `<em>`.
- `ea-tokens.css`: byte-identical (no diff in the commit).
