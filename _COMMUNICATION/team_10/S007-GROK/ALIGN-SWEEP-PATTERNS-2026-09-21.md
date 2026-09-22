---
id: ALIGN-SWEEP-PATTERNS-2026-09-21
schema_version: aos_v1_team_messaging
type: PATTERN-LIST (team_10)
from: team_10
to: [team_100, team_110]
date: 2026-09-22
status: SUBMITTED-FOR-VALIDATE
engine_builder: cursor-grok-4.6
map: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-MAP-2026-09-21.md
raw: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/tmp/qa/align-sweep/raw.json
---

# Align-sweep patterns — submitted for cross-engine VALIDATE

Builder ≠ validator. This list is written by the mapping engine. Implement **only** rows with `implement: yes` after VALIDATE PASS.

Canon (live `/snoring-sleep-apnea/` this run): `main` 1440 max none · `.wrap` 1200 pad-inline 48 · `.intro-body` 82ch = 775.3 · H2 `.h2` 1104 start offset 164.4 · `--sec` 88@1440 / 40@390 · split 516/516 legal.

Home `/` is **not** in any pattern. L1 / QR permalinks / `_aos` / `local/` / SSOT: not in any pattern.

---

## Implement after PASS

### P-BLOG-SINGLE

| field | value |
|---|---|
| id | P-BLOG-SINGLE |
| family | F-BLOG-SINGLE |
| N URL | 52 live singles (TSV `posts` minus two 301→`/blog/`) |
| suspected class | `ea-wave2-blog-single` on `<main class="chapters-main ea-wave2-blog-single">` |
| PHP | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-blog-single.php` line 25 |
| CSS | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/site/wp-content/themes/ea-eyalamit/assets/css/ea-blog.css` `.ea-wave2-blog-single { max-width: var(--ea-prose-width); }` = 960px |
| home risk | 0 — home is `tpl-chapters-home.php`, no this class |
| implement | **yes** |

**Cage proof** (CDP 1440, `/2228-2/`, no reload):

| metric | before | after `classList.remove('ea-wave2-blog-single')` | canon |
|---|---:|---:|---:|
| mainW / max | 960 / 960px | 1440 / none | 1440 / none |
| wrapW | 896 | 1200 | 1200 |
| pheroW | 896 | 1440 | 1440 |
| postW | 624 (66ch) | 624 (still) | 775.3 (82ch) — see P-POST-66CH |

Same dual class on all 52. Representative + second URL (`/100-100-100-תודה/` or any other TSV post) after FTP.

**Fix (no third wrapper):**
1. CSS: drop `max-width` / centering padding on `.ea-wave2-blog-single` (the cage). Nested `.ea-wave2-blog-single .ea-page-title` is unused on Chapters phero; leave or dead-code after grep.
2. PHP: `<main class="chapters-main">` only.
3. Grep leftover `.ea-wave2-blog-single` — live Chapters consumer is this template; legacy `tpl-blog-single.php` is not winning (router priority 105).

**Not invented:** restoring Chapters chrome already on the page. Split/H2-offset for related-card row is a card grid, not a reading row — do not force 1104 on card titles.

---

### P-POST-66CH

| field | value |
|---|---|
| id | P-POST-66CH |
| family | F-BLOG-SINGLE (same 52) |
| suspected class | `.ea-post-content { max-width: 66ch }` — **not** a dual-on-main class |
| CSS | `ea-blog.css` lines 262–268 |
| PHP | `tpl-chapters-blog-single.php` `.ea-post-content` wrapping `the_content()` |
| home risk | 0 — selector unused on `/` |
| implement | **yes** (after P-BLOG-SINGLE) |

**Proof that this is a second cage:** after `remove('ea-wave2-blog-single')`, wrap/phero jump to canon; `postW` stays **624 / 66ch**. So deleting the dual class is not enough.

**Fix:** point `.ea-post-content` at the Chapters reading measure already locked: `max-width: 82ch; margin-inline: auto` (same as `.intro-body` / `.prose` in `chapters.css`). Do not add a new class. Do not add a new max-width token. Do not change `--fs-*`.

Target after both P-BLOG-SINGLE + P-POST-66CH on `/2228-2/` @1440: main 1440 none, wrap 1200 pad 48, `.ea-post-content` ≈775.3, phero 1440, H1 32ch start (already 786.6 / start before the fix).

---

### P-BLOG-ARCHIVE

| field | value |
|---|---|
| id | P-BLOG-ARCHIVE |
| family | F-BLOG-ARCHIVE |
| N URL | 1 live (`/blog/`). Two TSV posts 301 here — same template. |
| suspected class | `ea-wave2-blog-archive` on `<main class="chapters-main ea-wave2-blog-archive">` |
| PHP | `tpl-chapters-blog-archive.php` line 48 |
| CSS | `ea-blog.css` `.ea-wave2-blog-archive { max-width: var(--ea-content-width); }` = 1200px |
| home risk | 0 |
| implement | **yes** |

**Cage proof** (`/blog/` @1440):

| metric | before | after `classList.remove('ea-wave2-blog-archive')` | canon |
|---|---:|---:|---:|
| mainW / max | 1200 / 1200px | 1440 / none | 1440 / none |
| wrapW | 1136 | 1200 | 1200 |
| pheroW | 1136 | 1440 | 1440 |

**Fix:** drop max-width/padding cage on `.ea-wave2-blog-archive`; PHP main = `chapters-main` only. Card grid (`.ea-blog-grid` / `.ea-blog-card`) is already unscoped — removing the dual class does not invent a catalog layout.

---

## Do not implement (measured; not a dual-class cage)

These stay on the list so VALIDATE can confirm they are **not** silent skips. `implement: no`.

### P-PRESS

| field | value |
|---|---|
| id | P-PRESS |
| family | F-PRESS-W2 |
| N | 1 — `/press/` |
| suspected class | `ea-wave2-editorial` on main (no `chapters-main`, no `.wrap`) |
| implement | **no** |

**Proof:** `classList.remove('ea-wave2-editorial')` → mainW 1440, wrap still missing, H1 still 596. Geometry unchanged. Deleting the class would not yield snoring canon. Migrating `/press/` onto Chapters templates would invent layout. Out of this sweep.

### P-GP

| field | value |
|---|---|
| id | P-GP |
| family | F-GP |
| N | 3 — `/historical-articles/` `site-main` 820; `/shows-heritage/` 820; `/services/` HTTP **404** |
| suspected class | none dual — GeneratePress `site-main` |
| implement | **no** |

No `ea-wave2-*` on main. `classList.remove` of a Wave2 class is N/A. Do not invent Chapters chrome.

### P-FAQ-820

| field | value |
|---|---|
| id | P-FAQ-820 |
| family | F-CHAP-OTHER |
| N | 1 — `/faq/` |
| suspected class | none dual. Local `.ea-faq-list { max-width: 820px }` in `chapters.css` |
| implement | **no** |

`main` is already `chapters-main` full 1440, max none. This is a third measure on a FAQ list, not a Wave2 class wrapping hero+body. Changing 820→82ch would invent a reading column the page does not have. Leave.

### P-60CH-LEAD

| field | value |
|---|---|
| id | P-60CH-LEAD |
| family | F-CHAP-82CH / F-CHAP-SPECIAL (also on canon page) |
| CSS | `.center .lead { max-width: 60ch }` and `.phero__lede { max-width: 60ch }` in `chapters.css` |
| implement | **no** |

Present on the locked snoring page. Not a Wave2 dual class. Editing it would change the canon page and likely `/` hero lede. Home risk would not be zero.

### P-ORPHAN-PROSE

| field | value |
|---|---|
| id | P-ORPHAN-PROSE |
| family | leftover CSS |
| token | `--ea-prose-width: 960px` in `ea-tokens.css`; 65ch in `ea-atoms.css` / `w2-*.css` / editorial |
| implement | **no** this sweep |

After P-BLOG-SINGLE the live Chapters consumer of `--ea-prose-width` on `main` is gone. Remaining consumers are unused Wave2 templates (`w2-04`, `w2-05`, `tpl-content` editorial 65ch). Deleting the token now would be an unused-CSS cleanup, not an align proof, and could hit `/press/` (65ch intro). Leave token; do not invent.

### P-TYPE-BLOG-H3

| field | value |
|---|---|
| id | P-TYPE-BLOG-H3 |
| family | F-BLOG-SINGLE |
| note | computed h3 15.3px via `font: var(--ea-type-h3)` (= `--fs-sm`), not `--fs-h3` 18.7 |
| implement | **no** |

Not a width cage. Changing `--ea-type-h3` retunes Wave2 composites sitewide. Typography canon: change a token, but this token is an intentional historical mapping. Out of align-sweep.

---

## Explicitly not patterns

| item | why |
|---|---|
| `/` home | excluded by mandate |
| F-CHAP-82CH (36) + F-QR-CHAP (48) | already wrap 1200 + 82ch=775.3. QR permalinks locked |
| F-CHAP-SPECIAL split 516 | legal second atom (canon §8) |
| L1 / `ea-canonical-nav.php` | T-NAV-HOLD |
| new post template / Gutenberg | `POST-TEMPLATE-SETTINGS.md` waiting team_00 |

---

## Implementation order (if VALIDATE PASS)

1. P-BLOG-SINGLE (CSS cage + PHP class)
2. P-POST-66CH (82ch on `.ea-post-content`)
3. P-BLOG-ARCHIVE (CSS cage + PHP class)
4. bump `Version` in `style.css` after reading (from 1.5.105)
5. FTP from worktree `--allow-dirty`
6. CDP after on `/2228-2/` + one more post + `/blog/` + GET `/` regression
7. `qa_probe` 390+1440 overflow on those URLs

N total unique live URLs fixed: **53** (52 singles + `/blog/`).
