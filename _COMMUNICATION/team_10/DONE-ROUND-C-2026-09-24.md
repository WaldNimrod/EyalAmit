# DONE — Round C — nav depth, spotlight cards, classic breadcrumb — 2026-09-24

Mandate: `_COMMUNICATION/team_90/AUDIT-2026-09-24/MANDATE-ROUND-C-2026-09-24.md`
Team: team_10 (Builder). Repo: `EyalAmit.co.il-2026`, branch `main`.
Live staging: `http://eyalamit-co-il-2026.s887.upress.link`.

**Two mid-round corrections from the coordinator were addressed before completion:**
1. Task 2 is NOT a new build. The `«חדש באתר»` card element already exists
   (`section-home-spotlight.php` / T-IA-SPOTLIGHT, `status: closed` in the work SSOT). The
   work became: re-point the four home cards, and reuse the same component on the books
   page. See Task 2 below.
2. "מוקש דהימן - המורה שלי" — team_00 first asked for a rendered A/B (xlight vs thin),
   then made a final ruling: `--fw-thin` (100), no italic. Implemented as ruled. See the
   note under Task 1.

---

## git status — both readings

**Before starting** (session start, recorded verbatim):
```
On branch main. Up to date with origin/main.
Modified: 9 files under _COMMUNICATION/, scripts/s007_render_work_ssot.py
Untracked: 3 files under _COMMUNICATION/team_10/, 10 files under
  _COMMUNICATION/team_90/AUDIT-2026-09-24/, scripts/save_legacy_wp_app_password.py
```
None of those paths are under `site/`; `site/` was clean at session start.

**Right before deploy** (after committing this round's own changes, `eb99422`):
```
site/  — clean (git status --porcelain -- site/ → no output)
```
One new untracked file had appeared since session start in `_COMMUNICATION/team_90/`
(`DECISIONS-LIVE-MEETING-2026-09-24.md`) — not touched, not mine, consistent with the
directory-authority table (team_10 writes to `_COMMUNICATION/team_10/` + application
source only). `scripts/save_legacy_wp_app_password.py` was left alone and never opened,
as instructed. `_aos/` was not touched.

## Deploy

- Theme version at start: **1.5.123** (read before bumping, matched the mandate).
- Bumped to **1.5.124** in `style.css`.
- Committed `site/` changes first (explicit paths, no `-A`/`.`) — the deploy script
  refuses a dirty `site/` and I did not want to hit that refusal or force past it.
  Commit: `eb99422`.
- `python3 scripts/ftp_deploy_site_wp_content.py` — ran clean, no refusal, logged to
  `_COMMUNICATION/team_100/S006/DEPLOY-LOG.md`.
- Pushed `main` to origin: `99b956d..eb99422`.
- Verified live: `curl .../wp-content/themes/ea-eyalamit/style.css` → `Version: 1.5.124`;
  enqueued asset URLs on a live page carry `?ver=1.5.124`.
- `assets/css/ea-tokens.css` — **not in the diff, not touched.** Byte-identical.

---

## Task 1 — «ספרים» under «אייל עמית», third nav level

**Live URL:** `/eyal-amit/` (desktop dropdown) and any page's drawer (mobile). Both `200`.

**Rendered level-1 list (measured via JS on the live page, 1440px width):**
```
אייל עמית · טיפולים בדיג׳רידו · שיעורים והכשרות · השיטה · כלים ואביזרים · בלוג דיג׳רידו
```
Six items. «ספרים» is not among them. ✅

**Full «אייל עמית» submenu, in order (measured live):**
```
1. אודות אייל
2. מוקש דהימן - המורה שלי
3. המלצות
4. שאלות ותשובות
5. גלריה
6. ספרים ▾        — aria-haspopup=true, aria-expanded toggles true on real Tab-key focus
     ├─ מבצעים            → /books/#books-bundle
     ├─ צבע בכחול וזרוק לים → /books/tsva-bekahol/
     ├─ כושי בלאנטיס       → /books/kushi-blantis/
     └─ וכתבת              → /books/vekatavta/
7. צור קשר
```
Matches the mandate's dictated order exactly. Seven children, four of them level-3.

**Build, not a reorder** — confirmed by grep before touching anything: the old renderer
was a single flat loop (`section-nav.php`) with no recursion. Fixed with one depth-driven
recursive function per renderer, both guarded `function_exists()` and reused by every
caller (no special case for "ספרים"):
- `ea_render_nav_item_desktop()` — `inc/ea-canonical-nav.php`, called from
  `template-parts/chapters/section-nav.php`.
- `ea_nav_drawer_render_item()` — `inc/ea-nav-drawer.php`, called from
  `template-parts/nav/nav-drawer.php`.

Both walk `'children'` at any depth. A level-2 item with its own children (only «ספרים»
today) renders as its own dropdown/accordion recursively — the exact same
`aria-haspopup="true"` / `aria-expanded` mechanism at every depth, because
`assets/js/ea-chapters.js` (unmodified) selects `.nav__dd[aria-haspopup="true"]` — a
selector, not a depth check — and the mobile drawer's `ea-nav-drawer.js` (unmodified)
wires every `.ea-nd__acc-btn` it finds regardless of nesting.

**CSS extended, not duplicated:**
- `assets/css/chapters.css` — the reveal rule was widened from a descendant selector
  (`.nav__l>li:hover .nav__sub`, which would have popped every nested flyout open at
  once) to a direct-child rule, plus a new rule keyed off the nested `<li>`'s own
  hover/focus-within. A nested `.nav__sub` flies out to the side of its own `<li>`
  instead of stacking a second "drop below" panel.
- `assets/css/ea-nav-drawer.css` — a nested accordion opener reuses `.ea-nd__acc-btn`
  (mechanics) + `.ea-nd__sublink` (size/colour, later in the cascade so it wins) — no new
  font-size or colour declaration. Only addition: one indent rule for the level-3
  sublist (`--ea-space-*` tokens already used elsewhere in the same file).

**Respected `hidden`:** «קורסים דיגיטליים» still absent from the rendered nav (checked
`.nav__l` innerHTML live — does not contain the string), `/learning/courses-external/`
still returns `200`.

**Every menu link returns 200, no redirects** (measured live, `redirect: 'manual'`):
`/eyal-amit/`, `/eyal-amit/mokesh-dahiman/`, `/testimonials/`, `/faq/`, `/galleries/`,
`/books/`, `/contact/`, `/books/#books-bundle`, `/books/tsva-bekahol/`,
`/books/kushi-blantis/`, `/books/vekatavta/`, plus every other level-1/level-2 target —
all `200`.

**Keyboard (measured with real Tab keypresses, not scripted `.focus()` — a scripted
`.focus()` call did not reliably trigger the JS aria-expanded sync in this environment,
but a real Tab keypress did every time; I mention this because it means my *first* pass
of automated checks gave a false negative and I re-measured before trusting it):**
Tab from the logo → `אייל עמית` gets `aria-expanded="true"`, its `:focus-within` panel is
visible → six more Tabs reach `ספרים`, which also gets `aria-haspopup="true"` /
`aria-expanded="true"`, and its own level-3 panel becomes visible
(`visibility:visible; opacity:1`) → Tab again lands inside it, on `מבצעים`, panel stays
open. Screenshot confirms the level-3 panel renders beside (not under) the level-2
panel, no overlap.

**Mobile drawer — all three levels, verified functionally (state inspected via JS; the
native `<dialog>` did not visibly paint in this automation pane's screenshot despite
`dialog.open === true` and correct DOM/ARIA state — I do not trust that screenshot gap
as a real defect, since every DOM/ARIA/CSS check passed and the same `<dialog>` markup
and JS are unmodified from the working two-level version):**
Clicking the burger sets `dialog.open = true`. Clicking the `אייל עמית` accordion sets
its `aria-expanded="true"` and reveals a panel with all seven children including
`ספרים ⌄` (its own nested `.ea-nd__acc-btn`, `aria-haspopup="true"`,
`aria-expanded="false"` until opened). Clicking that opens ITS panel:
`ספרים — עמוד ראשי`, `מבצעים`, `צבע בכחול וזרוק לים`, `כושי בלאנטיס`, `וכתבת` — all
present, all real `<a>` links.

**Touch — measured explicitly, not assumed, per the mandate's own warning:**
`assets/js/ea-chapters.js` is unmodified and still has no first-tap handling for
`.nav__dd` links (I did not add any — instructed not to redesign this). Confirmed by
code inspection: only `mouseenter`/`mouseleave`/`focusin`/`focusout` listeners exist on
the desktop dropdown. Consequence, measured against the actual CSS breakpoint
(`.nav__l{display:none}` below 1181px, verified live): **the desktop `.nav__l` dropdown
— where the "tap navigates instead of opening" gap lives — is only ever shown to a
viewport ≥1181px wide.** Every phone and the overwhelming majority of tablets are
narrower than that and get the drawer, which I verified above to correctly expose all
three levels via tap/click. The at-risk cohort for the pre-existing gap is narrower than
"any touch user": a touchscreen laptop/desktop, or a large tablet in landscape
(≥1181px CSS width — e.g. 12.9" iPad Pro at 1366px, not a standard iPad at 820–1024px).
On such a device, a real tap on `אייל עמית` would navigate to `/eyal-amit/` immediately
instead of opening the panel, so `ספרים` and its four book pages would be unreachable
from that specific device class via the desktop nav (they remain reachable via the
breadcrumb and via the drawer, which some of those devices also show at in-between
widths). **I did not redesign the touch behaviour — reporting this for team_00's call,
exactly as instructed.**

**Note on the label weight** (raised mid-round by team_00, addressed before completion):
the previous round's `<em>` used a synthesized italic (Heebo ships no italic axis).
Rendered a real A/B (`--fw-xlight`/200 vs `--fw-thin`/100) as a local side-by-side
mockup at the nav's own font size before any code change, per the coordinator's
instruction to "render both, look at them, and pick one" — then team_00 made the final
call: `--fw-thin` (100). Implemented as: `.nav__sub em`, `.ea-nd em`, `.sub-menu em`
(all three nav renderers, for consistency) get `font-style:normal;
font-weight:var(--fw-thin)`. No numeric weight, no new token, `ea-tokens.css` untouched
(`--fw-thin` already existed there). No font-size touched — confirmed live via
`getComputedStyle`: desktop `18.36px` (unchanged `--fs-nav` rung), mobile drawer
`15.3px` (unchanged `--fs-sm` rung on `.ea-nd__sublink`). Rendered appearance: on both
desktop and phone, "המורה שלי" now sits at a visibly lighter, upright weight next to the
label's own regular/light weight — no slant, and still legible at the nav's small size
(the concern team_00 raised about 100 possibly reading "fragile" — I looked at it live
on both widths and it reads cleanly, not faint or broken, though it is a genuinely thin
stroke, as ruled).

---

## Task 2 — «חדש באתר» cards (reuse, not build — corrected mid-round)

**Component was reusable as-is with one small change: parameterising it.** It read
`ea_chapters_rows('now_cards')` unconditionally; I added `$args['cards']` as an override
(falls back to the original ACF/default read when omitted), so the home page's own call
is byte-for-byte unchanged in behaviour and the books page can hand it different cards
without a second markup file. No new CSS, no new markup pattern.

### 2a — Home cards re-pointed

**Live URL:** `/` → `200`. Measured live via JS on the rendered page.

| Before (target) | After (target) | Card title | Source |
|---|---|---|---|
| `/shop/` | **`/treatment/`** | טיפול בנשימה | `/treatment/` meta description |
| `/books/kushi-blantis/` | **`/snoring-sleep-apnea/`** | דום נשימה | `/snoring-sleep-apnea/` meta description |
| `/learning/therapist-training/` | **`/lessons/`** | שיעורים | `/lessons/` meta description |
| `/blog/` | **`/repair/`** | תיקון כלים | `/repair/` meta description |

Card text, verbatim source mapping (every trim reported):

- **טיפול בנשימה** (`/treatment/`) — meta: *"תהליך אישי לחיזוק מערכת הנשימה. למדו
  להחזיר שליטה וויסות למערכת הנשימה דרך הדיג'רידו. פתרון מבוסס תרגול לסטרס, נחירות
  ומתח כרוני."* → line1 = 1st sentence verbatim, line2 = 2nd sentence verbatim.
  **Trimmed:** 3rd sentence dropped whole (only two line slots exist in the component).
- **דום נשימה** (`/snoring-sleep-apnea/`) — meta: *"האם דיג'רידו עוזר לנחירות ולדום
  נשימה בשינה? מה מצא מחקר ה-BMJ (Puhan 2006), איך זה עובד ולמי זה מתאים — מאת אייל
  עמית, פרדס חנה."* → line1 = the complete first clause (a question) verbatim, not
  trimmed. **Trimmed:** line2 cut at the em-dash clause boundary, dropping the
  attribution tail "— מאת אייל עמית, פרדס חנה".
- **שיעורים** (`/lessons/`) — meta: *"למדו לנגן בדיג'רידו אחד על אחד בפרדס חנה. שליטה
  בנשימה מעגלית, מקצבים ואפקטים. מתודולוגיה הדרגתית המותאמת לקצב האישי שלכם."* →
  line1/line2 = 1st/2nd sentences verbatim. **Trimmed:** 3rd sentence dropped whole.
- **תיקון כלים** (`/repair/`) — meta: *"שירות תיקון דיג'רידו מקצועי: טיפול בסדקים,
  שברים ושדרוג פיות עץ. עבודה מבוססת הבנה גיאומטרית-פיזיקלית של מבנה הכלי והסאונד."*
  → line1/line2 = both sentences verbatim. **Not trimmed** — both fit as-is.

Card *titles* ("טיפול בנשימה" etc.) are team_00's own dictated labels from the mandate
text itself, not invented and not copied from each page's own H1 (which differ — e.g.
`/repair/`'s H1 is "תיקון וחידוש כלי דיג׳רידו").

Images: reused existing on-theme photos already associated with each target page (from
its own `*-defaults.php` hero media / on-page assets) — `eyal-studio-play.jpg`,
`snoring/maccabi.jpg`, `eyal-teaching.jpg`, `repair/EA-000239.jpeg`. All verified to
exist on disk before use.

### 2b — Books page, same component reused

**Live URL:** `/books/` → `200`. Cards render immediately after the phero hero (measured
live: DOM order is `header.phero` → breadcrumb bar → `#ea-now` cards → rest of the page).

**Card-text source mapping** (measured live via JS):

| Card | Title | line1 | line2 | Source | Trimmed? |
|---|---|---|---|---|---|
| Book 1 | צבע בכחול וזרוק לים | 38 סיפורים קצרים ובועטים על הטיול הגדול לדרום אמריקה | הספר יצא לראשונה בשנת 2001 וכיום נמצא במהדורה העשירית. | `muzza-defaults.php` bookcard blurb | **Yes** — line1 cut at the source's own " - " clause boundary, dropping "על שחרור, בריחה, חופש, בלבול, וכל מה שקורה בדרך החוצה ובדרך חזרה." |
| Book 2 | כושי בלאנטיס | רומן פנטזיה על התעוררות, בחירה, אומץ, והיציאה מהחיים הנוחים מדי | הספר יצא לאור בשנת 2004 ונמצא במהדורה השישית. | same | **Yes** — line1 cut at " - ", dropping "מסע סמלי, צבעוני ומטלטל אל מחוץ לכלוב הזהב." |
| Book 3 | וכתבת | 46 סיפורים אמיתיים מחייו של אייל עמית | הספר ראה אור בשנת 2017 | same | **Yes** — line1 cut at " - ", dropping "ספר אישי, חי ומעורר השראה, על אהבה, מסעות, אובדן, שינוי, צמיחה, והיכולת לקום גם מהמקומות הכי קשים." line2 cut at a comma, dropping ", ובאתר מודגש גם אלמנט ה-QR שמרחיב את חוויית הקריאה מעבר לדף." |
| מבצעים | חבילת 3 הספרים של אייל עמית | שלושת הספרים יחד במחיר מיוחד | 150 ש״ח במקום 207 ש״ח | `muzza-defaults.php` `books-bundle` prose section (title + body) | line1 not trimmed (verbatim first sentence); line2 is the same section's price line with only its `<strong>`/`<del>` tags stripped — word order and numbers untouched, not a rewrite |

All four cover images (`tsva-bechol-cover.jpg`, `kushi-blantis-cover.jpg`,
`vekatavt-cover.jpg`) verified live: `200`, real dimensions, loaded. **The מבצעים card
ships with no image** — no cover file exists for that slot in the theme's own data
(muzza-defaults.php's own comment: "תמונת שלושת הספרים = BK-06, לא רונדר (אין קובץ)").
Per the content-law rule for a missing source, it ships without one rather than
inventing/borrowing an image.

**Every card link returns 200:** `/books/tsva-bekahol/`, `/books/kushi-blantis/`,
`/books/vekatavta/`, `/books/#books-bundle` (and the four home-page targets above) — all
measured `200`.

Card element renders correctly at both desktop and phone width (the component's own
existing responsive grid — `1fr 1fr` at ≤760px — untouched).

**No colour or font-size token changed** for this task — confirmed no diff in
`ea-tokens.css`.

---

## Task 3 — breadcrumb, classic position

**Decision: moved, not kept-both.** Every remaining call site now renders the breadcrumb
outside the hero, so there is exactly one breadcrumb per page, never two, and no
decoration-vs-exposed distinction was needed.

**Where it moved to:** right-aligned, wrapped in a new `.ea-crumb-bar > .wrap` (reusing
the page's own existing content-width container), placed immediately after each
template's hero/header `get_template_part()` call and before the first content section —
same position, same markup helper (`ea_breadcrumbs_render()`), on every call site.

**Call sites touched** (all nine remaining, all verified live — `<nav class="ea-crumb"`
appears exactly once per page):
- `template-parts/chapters/parts/phero.php`, `mokesh-hero.php`, `section-hero.php` — the
  render call was **removed from inside these three headers** (this is what discharges
  "does not discharge the requirement" from the mandate).
- Re-added right after the corresponding `get_template_part()` call in:
  `tpl-chapters-page.php`, `tpl-chapters-method.php`, `tpl-chapters-mokesh.php`,
  `tpl-chapters-blog-archive.php`, `tpl-chapters-blog-single.php` (both its JSON and
  normal-post branches), `tpl-chapters-qr.php`.
- `inc/wave2-w2-07.php`'s `ea_wave2_editorial_render_hero()` (used by `/about/`,
  `/press/`, and the rest of the "editorial" route family) — same move, called right
  after `ea_wave2_editorial_render_hero()` in `ea_wave2_render_editorial_blocks()`.

**Flag per the mandate's own instruction:** the `wave2-w2-07.php` call site was the one
(of four) that shipped without `array('dark'=>true)` — the recorded open bug for a
meeting decision. Moving it here **does not fix that bug**, but removes the reason it
existed: every call site now sits outside its dark hero on a plain content background,
so `dark` is not needed anywhere any more post-move. Left as-is otherwise, as instructed.

**Three measured gaps closed:**
- `/shows-heritage/` and `/historical-articles/` — page-template-default GeneratePress
  pages with no hero/phero partial at all. Added a new `the_content` filter,
  `ea_breadcrumbs_prepend_on_orphan_pages()` (priority 5, before the existing
  placeholder-strip filters at 8/9, purely additive), which prepends the same
  `ea_breadcrumbs_render()` markup right after GP's own `entry-header`/H1. Verified live:
  `200`, breadcrumb present, "בית" first.
- `/qr/qr20/` (the whole printed-code family) — `ea_breadcrumbs_should_show()` used to
  suppress it outright via `ea_breadcrumbs_is_qr_view()`. Removed that suppression, and
  added a real intermediate crumb from the actual `/qr/` hub post (its own title/
  permalink, not invented) so a QR child reads **בית ▸ QR ▸ &lt;page title&gt;** instead
  of jumping straight from בית to the title. Verified live on `/qr/qr20/`:
  `בית → /` , `QR → /qr/`, `qr20 – אבא, אני רעב → (current)`. The `/qr/` hub itself
  reads **בית ▸ דפי ה-QR**.

**«בית» stays the first link everywhere** — verified live on every sampled family
(home excluded, correctly — root page). Not touched at all: `ea_breadcrumb_trail()`
still hardcodes it as the trail's first element, independent of the nav tree (so Task
1's move of «ספרים» could not silently break it).

**Exactly one breadcrumb, exactly one `BreadcrumbList`** — measured live across 17 URLs
spanning every template family this round touched (`/`, `/eyal-amit/`, `/books/`,
`/books/kushi-blantis/`, `/treatment/`, `/repair/`, `/eyal-amit/mokesh-dahiman/`,
`/blog/`, `/method/`, `/qr/qr20/`, `/qr/`, `/shows-heritage/`, `/historical-articles/`,
`/about/`, `/press/`, `/faq/`, `/en/`): exactly one `<nav class="ea-crumb"` per page
(zero on `/` and `/en/`, correctly), and exactly one `"@type":"BreadcrumbList"` JSON-LD
block per page everywhere (Yoast's own schema, unrelated to and unaffected by this
change).

**Not fixed, not touched, per the mandate:** the breadcrumb's contrast/colour is
unchanged everywhere.

---

## Everywhere / site-wide checks

- **`assets/css/ea-tokens.css` byte-identical** — no diff, not in the commit.
- **Footer social links** — verified live: Facebook, Instagram, YouTube, TikTok all
  still point at the real profiles (`facebook.com/didgeridoo.studio.eyal.amit`, etc.),
  not `/contact/`.
- **Exactly one Chapters primary nav per page** — verified live: exactly one
  `id="nav"` across all 16 sampled URLs.
- **No fatals introduced** — spot-checked 34 URLs across every touched template family
  post-deploy: all `200`.
- **`php -l`** clean on all 22 edited PHP files before commit.

## Files changed (23, all under `site/wp-content/themes/ea-eyalamit/`)

`inc/ea-canonical-nav.php`, `inc/ea-nav-drawer.php`, `inc/ea-breadcrumbs.php`,
`inc/wave2-w2-07.php`, `inc/chapters/chapters-render.php`,
`inc/chapters/defaults/home-defaults.php`, `template-parts/chapters/section-nav.php`,
`template-parts/nav/nav-drawer.php`, `template-parts/chapters/section-hero.php`,
`template-parts/chapters/parts/phero.php`, `template-parts/chapters/parts/mokesh-hero.php`,
`template-parts/chapters/section-home-spotlight.php`,
`page-templates/tpl-chapters-page.php`, `tpl-chapters-method.php`, `tpl-chapters-mokesh.php`,
`tpl-chapters-blog-archive.php`, `tpl-chapters-blog-single.php`, `tpl-chapters-qr.php`,
`assets/css/chapters.css`, `assets/css/ea-nav-drawer.css`, `assets/css/ea-breadcrumbs.css`,
`assets/css/ea-canonical-nav-gp-dropdown.css`, `style.css` (version bump only).

**Commit:** `eb99422` — pushed to `origin/main` (`99b956d..eb99422`).
**Theme version deployed:** `1.5.124`, confirmed live.

## Open items for team_00 (not decided by me, per the mandate)

1. **Touch on wide-viewport devices** (touchscreen laptops, large tablets in landscape
   ≥1181px): tapping a top-level nav link with children navigates immediately instead of
   opening its panel — pre-existing, unchanged, now also affects reaching level 3
   («ספרים») from that specific device class. Not redesigned, as instructed. Every phone
   and most tablets are unaffected (they get the drawer, verified working for all three
   levels).
2. **`wave2-w2-07.php:940`'s missing `dark` arg** — the move in this round removes the
   reason the inconsistency existed (no call site needs `dark` any more), but the
   original bug was left as recorded, not actively "fixed."

Refusals: none needed this round — no part of the mandate, after the two mid-round
corrections, asked for anything I judged wrong or unbuildable.
