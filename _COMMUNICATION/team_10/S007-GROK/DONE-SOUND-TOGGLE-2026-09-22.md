# DONE — sound toggle on the video, never in the nav

**Team:** 10 (builder, this Grok line) · **Date measured:** 2026-09-20 · **Theme:** 1.5.93 · **Commit:** `69dea0a` · **Staging:** http://eyalamit-co-il-2026.s887.upress.link (HTTP)

**team_00 ruling (verbatim, 2026-09-20):** «לא תקין - צריך להופיע רק כשיש סרט ותמיד על הסרט או צמוד אליו.»

**Nimrod's approval of the home-page fix (verbatim, 2026-09-20):** «שמע בדף הבית נראה סבבה, יש לוודא שהוא מופיע רק היכן שיש וידאו או סאונד.»

Re-measured 2026-09-20 after that ruling, GET no-follow, 156 sitemap URLs all HTTP 200: `<video>` and `#soundtg` / `.hero__sound` only on `/`. `.nav__tg` `.ea-nd__sound` `.ea-sound-toggle` = 0. `.mokesh-hero__unmute` only on `/about/moksha/` and `/eyal-amit/mokesh-dahiman/` (YouTube on the hero). QR pages have YouTube iframes with the player’s own controls — not our שמע button. No `<audio>`. Wave2 ambient file is absent from the theme, so that nav pill is not live.

---

## 1. What changed

The control `id="soundtg"` was removed from Chapters nav and from the mobile drawer. It now renders only inside the home hero, and only when that hero has a real `<video>` (`section-hero.php`, `if ( $video )`).

| File | Change |
|---|---|
| `site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-nav.php` | Button removed. EN stays in `.nav__r`. |
| `site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-hero.php` | Button rendered on the video, same accessible name and `aria-pressed`. |
| `site/wp-content/themes/ea-eyalamit/assets/css/chapters.css` | `.hero__sound`: min 44×44, corner of the hero, `--fs-2xs` token. Dead `.nav__tg` rules removed. |
| `site/wp-content/themes/ea-eyalamit/assets/js/ea-chapters.js` | Still mutes/unmutes `.hero__media` VIDEO. The `[hidden]` branch that CSS `display` was overriding is gone. |
| `site/wp-content/themes/ea-eyalamit/template-parts/nav/nav-drawer.php` | Visual-only `.ea-nd__sound` pill removed. EN stays. |
| `site/wp-content/themes/ea-eyalamit/inc/ea-nav-drawer.php` | `show_sound` argument removed. |
| `site/wp-content/themes/ea-eyalamit/assets/js/ea-nav-drawer.js` | Fake sound-pill handler removed. |
| `site/wp-content/themes/ea-eyalamit/style.css` | `Version: 1.5.92` → `1.5.93` (read first). |

The mandate named `phero.php` as the hero that holds the video. That file holds an **image**. The live `<video>` is in `section-hero.php` on the home template. That is where the button went.

---

## 2. Live evidence, measured by this session (not from the diff)

Staging is HTTP on purpose. GETs did not follow redirects.

### Before (2026-09-20, theme 1.5.92)

32 URLs sampled. `<video>` on **one** page: `/`. `#soundtg` and `.ea-nd__sound` on **27** pages. `.ea-sound-toggle` (the old Wave2 ambient-audio pill in `block-topnav.php`) on **zero** live pages sampled — left untouched.

### After FTP of commit `69dea0a` (theme 1.5.93)

HTML GET, no redirect-follow:

| URL | status | `<video>` | `#soundtg` | `.hero__sound` | `.nav__tg` | `.ea-nd__sound` | JS ver |
|---|---|---|---|---|---|---|---|
| http://eyalamit-co-il-2026.s887.upress.link/ | 200 | 1 | 1 | 1 | 0 | 0 | 1.5.93 |
| http://eyalamit-co-il-2026.s887.upress.link/method/ | 200 | 0 | 0 | 0 | 0 | 0 | 1.5.93 |
| http://eyalamit-co-il-2026.s887.upress.link/accessibility/ | 200 | 0 | 0 | 0 | 0 | 0 | 1.5.93 |
| http://eyalamit-co-il-2026.s887.upress.link/privacy/ | 200 | 0 | 0 | 0 | 0 | 0 | 1.5.93 |
| http://eyalamit-co-il-2026.s887.upress.link/terms/ | 200 | 0 | 0 | 0 | 0 | 0 | 1.5.93 |

Full sitemap TSV (157 paths, GET, no follow): `<video>` only on `/`; `#soundtg` only on `/`. 141 paths returned 200. 16 returned **301** (legacy aliases already in the TSV: `/muzza/`, `/muzeh/`, `/hashita/`, `/tools-and-accessories/`, `/about/moksha/`, `/courses-soon/`, and similar). Those 301s were not introduced by this change; they were recorded as 301, not as 200.

### Rendered box model (CDP, after two `requestAnimationFrame`s — not a pre-layout zero)

**Desktop ~2074×1167**

- Button 74.57 × **44** px, inside the video box, not in `nav`.
- Does not overlap H1 or CTA. Does not overlap the two cue chevron *spans* (the cues *container* is full-width, which would look like an overlap if you measure the container — the actual 11px chevrons sit in the centre).
- Accessible name: `הפעלת קול בסרטון`. `aria-pressed` starts `false`.

**Phone 375×812** (Emulation.setDeviceMetricsOverride)

- Button 74.57 × **44** px, inside the video, bottom-inline-start (right in RTL).
- No overlap with H1, CTA, or cue spans. `overflowX` false.
- Nav shows EN + burger. No «שמע» in the bar.

**Behaviour**

- Click: `aria-pressed` → `true`; `video.muted` → `false`.
- Tab from `.nav__en`: focus lands on the button; a white `:focus-visible` ring is visible on the rendered page.

---

## 3. What was deliberately not done

- Did **not** touch `.ea-sound-toggle` in `block-topnav.php` (didgeridoo ambient `<audio>`, not video unmute). It was **not** in the live nav on the pages sampled.
- Did **not** touch `.mokesh-hero__unmute` — already on that page's media.
- Did **not** add native `controls` on the hero video.
- Did **not** force `--allow-dirty`. `site/` was committed first.
- Did **not** claim the 16 sitemap 301s are a regression of this change.
- Extra `<nav>` counts on a handful of pages (`/press/` 5, `/about/` 5, `/faq/` 2, several GeneratePress orphans 3) are **pre-existing** M-13 leftovers. This change did not add a navigation.

---

## 4. Deploy

`python3 scripts/ftp_deploy_site_wp_content.py` · 2026-09-20T18:38:11+03:00 · `69dea0a` · main · theme 1.5.93 · 522 files · recorded in `_COMMUNICATION/team_100/S006/DEPLOY-LOG.md`.
