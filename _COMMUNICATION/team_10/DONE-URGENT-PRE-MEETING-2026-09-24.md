# DONE / BLOCKED — Urgent pre-meeting fixes, 2026-09-24

Builder session. Repo `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026`, branch `main`.
Staging `http://eyalamit-co-il-2026.s887.upress.link`.

**Headline: Tasks 2 and 3 are live (they only touch `_COMMUNICATION/` files, no deploy
needed). Tasks 1 and 4 are coded and lint-clean but NOT LIVE — the FTP deploy's
dirty-tree guard refused, correctly, because `site/` already carried uncommitted edits
from what looks like another session before this one started. Per the mandate's Rule 4
I did not pass `--allow-dirty` and did not commit anything. This is the one thing Team 90
needs to know before re-measuring: /shop/ and /contact/ will still show the bug live
until that block clears.**

---

## Task 1 — /shop/ and /contact/ og:description leak

### Code (not yet live)

Extended `ea_w2_09_filter_yoast_chrome_desc()` in
`site/wp-content/themes/ea-eyalamit/inc/seo-head-fallbacks.php`, same shape as the
existing `/shows-heritage/` block: detect the exact known leaked string for `is_page(
array( 'shop', 'contact' ) )`, and on a match fall back to that page's own
`_yoast_wpseo_metadesc` post meta (the string already live in `<meta
name="description">`) — never new copy. `php -l` clean on the file.

### Live measurement (BEFORE fix, still current — deploy blocked, see below)

`/shop/`:
```
curl -s --max-time 15 "http://eyalamit-co-il-2026.s887.upress.link/shop/" | grep -oE '<meta[^>]*name="description"[^>]*>|<meta[^>]*property="og:description"[^>]*>'
```
```
<meta property="og:description" content="קטלוג ראשי — שימור slug shop לפי §7 M2." />
<meta name="description" content="כל מה שצריך לדיג׳רידו, במקום אחד" />
```

`/contact/`:
```
<meta property="og:description" content="טופס צור קשר — Fluent Forms." />
<meta name="description" content="ניתן ליצור קשר לתיאום שיחת היכרות, שאלות כלליות או כל פנייה אחרת." />
```

Both fetched live, no redirects followed, immediately before writing this report — the
bug is still shipping right now because the fix could not be deployed (see Deploy
section).

### Site-wide sweep for the same bug

Enumerated the WP REST API exactly as instructed:
`/wp-json/wp/v2/pages?per_page=100&status=publish&page=N` and the same for `posts`.
Result: **153 objects** (101 pages + 52 posts), **137 return 200** without following
redirects, 16 return 301 — matches the counts given in the brief exactly.

For each of the 137 live-200 URLs, fetched the rendered page and compared `<meta
name="description">` against `<meta property="og:description">`.

- **89 of 137 differ at all.** The overwhelming majority (79) are pure truncation —
  the og:description is the longer, un-trimmed version of the same sentence the meta
  description trims to ~157 chars. Harmless, not touched.
- Ran a second pass isolating everything that was NOT a simple truncation. **10 URLs**
  came out:
  - `/shop/` and `/contact/` — the two already reported. **Fixed** (pending deploy).
  - `/en/` — meta: *"Didgeridoo-based breath work, sound healing and lessons — Pardes
    Hanna, Israel."* vs og: *"Didgeridoo-based breath work, sound healing, learning and
    training in Pardes Hanna, Israel"*. Both are legitimate marketing sentences in
    English, not an internal marker/plugin name/spec reference/slug note. **Not
    touched** — does not match the bug this task targets. Flagging for awareness only.
  - Seven `/qr/qrNN/` pages (`qr37`, `qr35`, `qr31`, `qr30`, `qr23`, `qr18`, `qr13`) —
    the og and meta text differ only by an emoji rendering as `;-)`/`😉`, or a missing
    space after a line break in the archived source copy. Same copy, same author,
    trivial encoding variance — not an internal marker. **Not touched.**
- `/tools-and-accessories/` (page id 63) is a **301 redirect to `/shop/`** — it is not
  an independent bug; it inherits whatever `/shop/` serves once `/shop/` is fixed and
  live. Its own page content is itself a placeholder (`שער כלים — placeholder.`) but it
  never resolves with its own head tags because it always redirects, so it was excluded
  from the "137 that return 200" set and needs no separate og:description fix.

**Conclusion: no other page on the site carries this specific bug (internal
marker/plugin name/spec reference/slug leaking as og:description). Only `/shop/` and
`/contact/` needed the fix.**

---

## Task 2 — Q-TALK-8 corrected

Corrected `_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json`, item `Q-TALK-8`. Kept
`"status": "open"`, `"waitingOn": "nimrod"` exactly as they were — not marked resolved.
Reused only existing `titleHe` strings from `M1`–`M9`, no new copy. New `promptHe`:

```
ששת הסעיפים «עץ התפריט הראשי — שיחה אחת», «תבנית פוסט חדש — שיחה», «הסטת הכותרת מול
גוף הטקסט», «מוקש דהימן — עבודה בפגישה», «סטנדים — דוגמה לשילוב תמונות» ו«כותרות ההירו
והכיתוב cbDIDG» עברו מהטופס ללוח בסבב הקודם. בטופס נשארים רק «קרוסלת סרטונים בדף הבית
ובדפים חשובים» ו«מוזיקת רקע להירו, עם השתקה» — לכל אחד מהם תוצר אמיתי לשלוח. לא הוחלט
אם להוריד אותם. ההכרעה אצלך.
```

Verified against the SSOT items directly: `M1, M2, M3, M5, M6, M7` all carry
`"form": {"meeting": true}` (moved off Eyal's form to the board) while `M8` and `M9` do
not — `M8` needs the Instagram video files, `M9` needs the music file, both still
`"waitingOn": null`/no answer. This matches the corrected text exactly.

Re-rendered with `python3 scripts/s007_render_work_ssot.py`:
```
board /Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html
form  /Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html
hub   /Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/hub/dist/s007-content-gaps.html
ssotSha12 883167655a0e
```
Confirmed the new `ssotSha12` and the corrected `Q-TALK-8` text both appear in the
regenerated `GALLERY.html`. This board file is a `_COMMUNICATION/` artifact, not part of
`site/`, so it needed no FTP deploy — it is already the current file on disk.

---

## Task 3 — Q-C04 URL corrected

Changed only the `links[0].url` (and its matching `label`, which in this data model is
always just the URL path text, not a separate figure) in `contrastRows` item `Q-C04` of
the same SSOT file:

- Before: `http://eyalamit-co-il-2026.s887.upress.link/services/didgeridoo-treatment-breath/`
- After: `http://eyalamit-co-il-2026.s887.upress.link/treatment/`

`bodyHe`, `directionHe`, and `decisionHe` (the ratio 1.06:1, threshold 4.5:1, range
1.06–3.66:1, "6 of 153", "5 of 5 failed") are byte-identical to before — not
re-derived.

Live measurement, no redirects followed:
```
curl -s -o /dev/null --max-time 15 -w '%{http_code}\n' "http://eyalamit-co-il-2026.s887.upress.link/services/didgeridoo-treatment-breath/"
301
curl -s -o /dev/null --max-time 15 -w '%{http_code}\n' "http://eyalamit-co-il-2026.s887.upress.link/treatment/"
200
```

Re-rendered with the same script run as Task 2 (same invocation, same `ssotSha12
883167655a0e`); the board's `Q-C04` section now links to `/treatment/`.

---

## Task 4 — dead `about` slug removed

Verified first, per the mandate's instruction:
```
curl -s --max-time 15 "http://eyalamit-co-il-2026.s887.upress.link/wp-json/wp/v2/pages?slug=about"
[]
```
Empty array — no published page uses slug `about`. Also confirmed `/about/` itself is
still a live 301 (left untouched, as instructed) and that `courses-soon` is a real
published page (`http://eyalamit-co-il-2026.s887.upress.link/courses-soon/`, status
`publish`) — left untouched, as instructed.

Removed the one token from both lists in `site/wp-content/themes/ea-eyalamit/inc/`.
`php -l` clean on both files. As they now stand:

`ea-nav-drawer.php`:
```php
function ea_nav_drawer_orphan_slugs() {
	return array( 'shows-heritage', 'historical-articles', 'thank-you', 'courses-soon', 'press' );
}
```

`ea-open-round.php`:
```php
function ea_open_round_chrome_slugs() {
	$slugs = array( 'en' );
	if ( function_exists( 'ea_nav_drawer_orphan_slugs' ) ) {
		$slugs = array_merge( ea_nav_drawer_orphan_slugs(), $slugs );
	} else {
		$slugs = array( 'shows-heritage', 'historical-articles', 'thank-you', 'courses-soon', 'press', 'en' );
	}
	return $slugs;
}
```

Note for the record (not touched, out of this task's stated scope): the same file
(`ea-nav-drawer.php`) has two other, independently-hardcoded `is_page( array( 'about',
'press' ) )` checks in `ea_gp_wordmark_body_class()` and
`ea_gp_append_wordmark_to_site_title()` — they don't read from
`ea_nav_drawer_orphan_slugs()`, so removing `about` there didn't touch them. They are
equally inert (`is_page('about')` can never match a real query, same reasoning as the
task gave for the two lists), but the task named only the two functions above, so I left
these two alone.

**Not deployed — see Deploy section.** This code has no observable live effect either
way right now (`is_page('about')` never matched before or after), so there is nothing to
measure live for this task specifically; the fix is correct and lint-clean, just not yet
shipped.

---

## Deploy

- Theme version bumped in `site/wp-content/themes/ea-eyalamit/style.css`: read the
  current value first (**1.5.118**), bumped to **1.5.119**.
- Live theme currently serving is confirmed **1.5.118** (checked via the `?ver=` query
  string on enqueued assets on `/`) — matches the mandate.
- Ran `python3 scripts/ftp_deploy_site_wp_content.py`. It refused before any FTP
  connection was opened:
  ```
  Refusing to deploy: uncommitted changes under site/.
  M site/wp-content/themes/ea-eyalamit/inc/ea-nav-drawer.php
   M site/wp-content/themes/ea-eyalamit/inc/ea-open-round.php
   M site/wp-content/themes/ea-eyalamit/inc/seo-head-fallbacks.php
   M site/wp-content/themes/ea-eyalamit/style.css
   M site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-nav.php

  This script ships the working tree, so these edits would go live while existing in no
  commit — exactly the failure that produced the 887d270 and fabd106 rescue commits.
  Commit them, or re-run with --allow-dirty 'written reason'.
  ```
- Of those five files, **three are this task's Task 1 fix, one is this task's Task 4
  fix, one is the version bump** — all mine, all expected. The fifth,
  `template-parts/chapters/section-nav.php`, was **already modified, uncommitted,
  before this session started** (visible in the git status snapshot at session start) —
  I never opened or touched that file. It is someone else's in-progress work sharing
  this same worktree.
- Per the mandate's Rule 4 I did **not** pass `--allow-dirty` and did **not** commit
  anything (not told to, and committing would bundle an unknown session's unreviewed
  edit into a shared commit). **I stopped instead of forcing it.**

**Net effect: Tasks 1 and 4 are correct, reviewed, and lint-clean on disk, but are not
live.** The `/shop/` and `/contact/` share-card bug will keep shipping to the client's
WhatsApp previews until someone either (a) coordinates with whoever owns the
uncommitted `section-nav.php` change and gets a clean `site/`, or (b) makes an informed
call to deploy anyway with `--allow-dirty` and a written reason — that call is above
this session's authority per the mandate.

---

## Summary for Team 90 to re-measure

| Task | Status | Live? |
|---|---|---|
| 1 — shop/contact og:description | Fixed in code, sweep done (no other pages affected) | **NOT live** — deploy blocked |
| 2 — Q-TALK-8 board row | Fixed, rendered | Live (file-based artifact) |
| 3 — Q-C04 URL | Fixed, rendered | Live (file-based artifact) |
| 4 — dead `about` slug | Fixed in code | **NOT live** — deploy blocked, no observable behavior change either way |

Theme version on disk: **1.5.119** (uncommitted). Theme version actually live: **1.5.118**, unchanged.
