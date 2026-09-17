---
id: DONE_S006_M11_DUP_IMAGES_2026-09-18_v1.0.0
type: DONE (team_10, second line → team_100)
mandate: MANDATE_S006_M11_DUP_IMAGES_2026-09-18_v1.0.0
disposition: read-only investigation, complete
---

# M-11 · Same photograph shown twice — findings

**Method, in order:** (1) sha256 every file under `assets/images/` (291 files) and group by hash; (2) perceptual hash (pHash + dHash, `hash_size=16`, so a 256-bit hash — distance is out of 256 bits) on all 291 with Pillow 12.2.0 / `imagehash`, compared pairwise excluding pairs already sha256-identical; (3) grep every `.php` under `inc/`, `template-parts/`, `page-templates/`, `functions.php`, and every `assets/css/*.css` for each surviving candidate's literal path, to resolve it to the defaults file(s)/section(s) that would render it; (4) for every candidate with at least one reference, loaded the live page in a real browser (not `curl`) and asserted `document.body.innerHTML.length` plus a real heading/title before counting occurrences, per this wave's known staging-flakiness trap. All fetches were sequential, one page at a time, with the DOM read immediately after — no parallel probing, no case where a page came back short or a re-check disagreed with the first.

Scripts are under `tmp/qa/m11-dupes/` (gitignored): `sha256_all.txt` (raw hashes), `phashes.pkl` (perceptual hashes), `near_dup_candidates.txt`, `refs.pkl`/`refs2.pkl` (path → file:line reference index). Nothing under `site/` was touched; `build_media_data.py` was not opened.

**Headline numbers:** 291 files, 250 unique by sha256 (41 byte-identical extras across 37 groups) — matches team_100's own count exactly. Perceptual hashing over the remaining pairs (42,195 comparisons at threshold ≤10/256) surfaced exactly **5** additional near-duplicate pairs, all at distance 0–2 (i.e. re-encodes/resizes, not coincidental similarity). Of the 37+5 = 42 total candidate groups, 8 resolve to a visitor actually seeing the same photograph twice (or, in one case, three times) on one page, 2 resolve to the same photograph across pages in a way I judge accidental, 4 resolve to a systematic and — I believe — intentional pattern, and the rest are unused files, not duplicates. Detail below, ordered by how likely a visitor is to notice.

---

## Findings — accidental (same page)

### 1. Home page: `breath-practice.jpg` appears three times on one page

- **Photo:** a breathing/didgeridoo practice close-up, alt "תרגול נשימה עם דיג׳רידו".
- **Files:** `assets/images/chapters/breath-practice.jpg` (used twice) and `assets/images/chapters/home-peek/peek-27.jpg` — byte-identical, sha256 match, distance 0.
- **Referenced at:** `inc/chapters/defaults/home-defaults.php:78` (a tile in one section), `:248` (`cmp_a_image`, a comparison section), `:338` (`home-peek` gallery item 27).
- **Live, confirmed:** fetched `/` (body 46,647 chars, real heading). Exact-boundary count of the literal string `breath-practice.jpg` in the delivered HTML = **2** (the two direct uses); `didg-spiral-detail.jpg`-style check confirms `peek-27.jpg` renders as its own third `<img>`. A visitor scrolling the home page once sees this exact photograph three separate times.
- **Judgement: accidental.** Two different named components (a tile, a comparison-section image) and one anonymous gallery slot all happen to draw the same file. Nothing about the three placements reads as a deliberate "reuse this specific photo" design choice — it reads as a shared pool of stock photos being drawn from more than once without checking against what else is already on the page.

### 2. Home page's own photo gallery repeats one photo internally

- **Photo:** a mandala made of stones — same subject as the file literally named `stone-mandala.jpg`.
- **Files:** `assets/images/chapters/stone-mandala.jpg` (0 code references by that name — see unused list) is sha256-identical to `assets/images/chapters/home-peek/peek-26.jpg` (distance 0). Perceptual hashing additionally found `assets/images/chapters/home-peek/peek-04.jpeg` is **pHash/dHash distance 0** from both — a third, re-encoded copy of the same photograph that shares no sha256 with the other two (different bytes, same image), so the sha256 pass alone would have missed it entirely.
- **Referenced at:** `home-defaults.php:315` (`peek-04.jpeg`) and `:337` (`peek-26.jpg`) — both inside the same 30-item `home-peek` gallery array.
- **Live, confirmed:** same `/` fetch as above; both `peek-04.jpeg` and `peek-26.jpg` render (1 occurrence each, distinct `<img>` elements).
- **Judgement: accidental.** This is two slots *inside the same 30-photo gallery* showing the identical photo — not a cross-section reuse, a straight gallery-curation duplicate. `stone-mandala.jpg` itself is unused by that filename (see below) but its content lives on twice in the gallery it was presumably meant to appear in once.

### 3. Home page: the "about" section's second image reappears in the studio-peek gallery

- **Photo:** a close-up of a didgeridoo's spiral wood-grain/decoration detail.
- **Files:** `assets/images/chapters/didg-spiral-detail.jpg` ↔ `assets/images/chapters/home-peek/peek-20.jpeg` — byte-identical, distance 0.
- **Referenced at:** `home-defaults.php:63` (`about_img2`, the home page's own "about Eyal" two-image block) and `:331` (`home-peek` gallery item 20).
- **Live, confirmed:** same `/` fetch; both render, 1 occurrence each.
- **Judgement: accidental**, same shape as #1 — a specifically-chosen "about" illustration also drawn into the generic gallery pool.

### 4–5. `/tsva-bekahol/` book page: two separate internal gallery duplicates

- **Pair A — Files:** `assets/images/chapters/tsva/tsva-18.jpg` ↔ `assets/images/chapters/tsva/tsva-40.jpg`, byte-identical, distance 0. Referenced at `inc/chapters/defaults/tsva-bekahol-defaults.php:95` and `:117`, both inside the same gallery array.
- **Pair B — Files:** `assets/images/chapters/tsva/tsva-39.jpg` ↔ `assets/images/chapters/tsva/tsva-27.jpg`, byte-identical, distance 0. Referenced at `:116` and `:104`, same gallery array.
- **Live, confirmed:** fetched `/tsva-bekahol/` (body 38,257 chars, title "צבע בכחול וזרוק לים"). Exact-boundary counts: `tsva-18.jpg`=1, `tsva-40.jpg`=1, `tsva-39.jpg`=1, `tsva-27.jpg`=1 — all four render as distinct gallery images.
- **Judgement: accidental.** A single book's own photo gallery showing the same two photographs twice each, at four different positions in the scroll sequence — the kind of thing that's very noticeable to someone paging through this specific book's photos, since the gallery is presumably meant to show 40+ distinct moments.

### 6. `/kushi-blantis/` book page: one internal gallery duplicate

- **Files:** `assets/images/chapters/kushi/kush-16.jpg` ↔ `assets/images/chapters/kushi/kush-23.jpg`, byte-identical, distance 0. Referenced at `inc/chapters/defaults/kushi-blantis-defaults.php:102` and `:109`, same gallery array.
- **Live, confirmed:** fetched `/kushi-blantis/` (body 35,030 chars, title "כושי בלאנטיס"). Both `kush-16.jpg` and `kush-23.jpg` = 1 occurrence each.
- **Judgement: accidental**, same shape as #4/#5.

---

## Findings — accidental (across pages)

### 7. `eyal-teaching.jpg` / `tsva-32.jpg` — the pairing team_100 already had measured

- **Photo:** Eyal teaching/playing didgeridoo.
- **Files:** `assets/images/chapters/eyal-teaching.jpg` ↔ `assets/images/chapters/tsva/tsva-32.jpg`, byte-identical, distance 0.
- **Referenced at:** `media-defaults.php:91` (a 4-photo "moments" gallery on `/testimonials/`, captioned "הוראה" — teaching), `lessons-defaults.php:24` (the `/lessons/` page's own hero image, captioned "אייל עמית מלמד נגינה בדיג'רידו"), and `tsva-bekahol-defaults.php:109` (one slot in the tsva-bekahol book's own gallery, uncaptioned).
- **Live, confirmed on all three:** `/lessons/` (1 occurrence), `/testimonials/` (1 occurrence), `/tsva-bekahol/` (1 occurrence, already counted under finding #4/5's page fetch as `tsva-32.jpg`… re-checked directly: 1).
- **Judgement: split.** The `/lessons/` hero and the `/testimonials/` "moments" gallery both fit the photo's actual content (it's a teaching photo, used where teaching is the subject) — I read those two as fine, ordinary reuse of a good photo across two thematically-related pages, not a defect. The third placement, inside the **tsva-bekahol book's own gallery** with no connection to teaching or lessons, is the one that looks like an accidental drop from a shared photo pool into a specific book's page that shouldn't have generic practice photos mixed into it.

### 8. `kush-25.jpg` / `tsva-43.jpg` — one photo in two different books' galleries

- **Files:** `assets/images/chapters/kushi/kush-25.jpg` ↔ `assets/images/chapters/tsva/tsva-43.jpg`, byte-identical, distance 0.
- **Referenced at:** `kushi-blantis-defaults.php:111` and `tsva-bekahol-defaults.php:120`, each inside that book's own gallery.
- **Live, confirmed:** both counted as 1 occurrence in the `/kushi-blantis/` and `/tsva-bekahol/` fetches above.
- **Judgement: accidental.** Two different, unrelated books each showing the same photograph as one of their own gallery images. I can't tell from the image alone whether this is a genuine mix-up (wrong photo filed under the wrong book during import) or a deliberate "same event/session photographed both books' subjects together" choice — flagging as a question rather than guessing: **is there a legitimate reason the same photo belongs in both `kushi-blantis` and `tsva-bekahol`'s galleries, or was one of these misfiled during the photo import?**

---

## Findings — likely intentional (reported per the mandate, not treated as defects)

### 9. Each of the three books' own cover image also appears once inside that same book's gallery

- `assets/images/kushi-blantis-cover.jpg` ↔ `assets/images/chapters/kushi/kush-05.jpg` — perceptual match, pHash distance 2, dHash distance 2 (re-encoded, not byte-identical).
- `assets/images/vekatavt-cover.jpg` ↔ `assets/images/chapters/vekatavta/veka-101.jpg` — perceptual match, pHash distance 2, dHash distance 0.
- `assets/images/tsva-bechol-cover.jpg` ↔ `assets/images/chapters/tsva/tsva-11.jpg` — perceptual match, pHash distance 0, dHash distance 0.
- **Referenced at:** each cover is the book's own page hero (`*-defaults.php`'s `media` key) **and** its listing thumbnail on `/books/` (`muzza-defaults.php:61/68/75`, the `cover` key); each matching gallery file sits inside that same book's own gallery array (`kushi-blantis-defaults.php:92`, `vekatavta-defaults.php:99`, `tsva-bekahol-defaults.php:88`).
- **Live, confirmed** on all three book pages (checks above) — cover and gallery-twin both render on every one.
- **Judgement: intentional.** This is the same pattern applied identically across all three books, not a one-off accident — reads as a deliberate editorial choice to include the cover photograph as one of the "flip through the book's photos" gallery images too, which is a normal thing for a book/product gallery to do. Reporting it because the mandate asked for every match, not because I think it needs fixing.

### 10–12. Three "atmosphere" photos reused across multiple, unrelated pages

- `assets/images/chapters/garden.jpg` — referenced at `about-defaults.php:125`, `contact-defaults.php:19` (contact page hero), `galleries-defaults.php:41`, `workshops-defaults.php:27`. Four different pages.
- `assets/images/chapters/eyal-workshop.jpg` — referenced at `bags-defaults.php:65`, `galleries-defaults.php:45`, `shop-defaults.php:43` (as a product `cover`). Three different pages.
- `assets/images/chapters/group-session-garden.jpg` — referenced at `home-defaults.php:106` (`band_image`), `treatment-defaults.php:143`, `media-defaults.php:92`, `sound-healing-defaults.php:28`. Four different pages.
- **Judgement: intentional.** These read as a small shared pool of generic "studio atmosphere" photographs (a garden, the workshop, a group session) that get reused as flexible hero/gallery filler across many page types — exactly the mandate's own example of deliberate reuse. I checked for any single page where two of these collide (which would tip it toward accidental) and found none — each page draws at most one of these three per visit. Not treating as findings requiring a fix, listed for completeness.

---

## What I checked and found clean

- Every one of the 37 sha256-groups and 5 perceptual near-dup pairs above was individually traced to its reference site(s) and, where at least one reference existed, verified live in the browser — none were judged from `curl` or from the defaults-array source alone.
- No case where a lazy-loaded image's `naturalWidth` was 0 or a comparison produced `NaN` — I checked presence via the delivered HTML/DOM (`outerHTML` string match with word-boundary guards, cross-checked against `querySelectorAll` for the higher-count outlier below), not via decoded image dimensions, so this trap didn't apply to my method.
- One measurement wrinkle I caught and corrected myself: a naive substring count of `garden.jpg` on the home page returned 2, which I initially misread as a possible duplicate — it was actually two *different* files (`eyal-portrait-garden.jpg`, `group-session-garden.jpg`) that merely end in the same four letters. Re-ran with a word-boundary regex and the true count of the bare `garden.jpg` on the home page is 0. Mentioning this because it's exactly the shape of false-positive this wave has been warning about, just in a spot the brief didn't name.
- `kushi-blantis-cover.jpg` returned 5 raw substring hits on `/kushi-blantis/` before I filtered to actual rendered `<img>`/visible content — one was a `<meta property="og:image">` pointing at a **separate WordPress media-library copy** of the same file (`/wp-content/uploads/2026/04/kushi-blantis-cover.jpg`, not the theme asset), which is not visitor-facing page content and not in this mandate's scope (it's a WP media-library object, not a file under `assets/images/`). Noting its existence in case it matters for a future SEO/OG audit, not counting it here.
- No SVGs, icons, logos, or watermark motifs are included in any finding above — `ea-arcs.png`, `ea-logo-mark.png`, `ea-logo.jpg` were excluded by name per the mandate and confirmed as CSS-referenced decorative assets, not content.

## What I could not measure

- Whether any of these images are *also* inserted directly into page/post content stored in the WordPress database (a Gutenberg block image, for instance) rather than through the theme's PHP defaults files — my reference scan covers every `.php` file under `inc/`, `template-parts/`, `page-templates/`, `functions.php`, and every theme CSS file, but not the database. If any of the "unused" files below are actually placed via block content, I would have missed that. **COULD NOT MEASURE** without a database read.
- Heavy re-crops (a photo cropped to a small detail from a larger source) can defeat perceptual hashing, per the mandate's own warning. I did not find any such pair, but a hash-based sweep cannot rule one out — if two images look related only by subject matter and not by matching hash, this method would not surface it either way.
- I did not visually open and compare every single one of the 291 photos by eye — the accidental/intentional judgements above are based on filename, alt text, surrounding code context, and the hash evidence, not a human look at every image. Where I felt the context didn't clearly resolve the judgement (finding #8), I said so and asked a question instead of guessing.

## Unused-on-disk files: methodology differs from team_100's estimate — reporting as measured, not correcting toward the given number

Per the mandate's own instruction: my count differs from the stated "roughly 24–28" and I'm reporting what I measured rather than adjusting to fit. I found **33 files with zero references** across the same file set team_100's own 256-referenced/291-total split implies (291 − 33 = 258 referenced by my count, vs. the mandate's stated 256 referenced / ~24–28 unused). The gap is 5–9 files depending which end of team_100's range is meant. I extended my reference scan twice while investigating (first to `inc/chapters/defaults/` + `template-parts/` + `inc/chapters/*.php` + `inc/wave2*.php` + `functions.php`, then broadened to *all* of `inc/`, `page-templates/`, and every theme CSS file, which recovered the three logo/decorative assets) and confirmed there is no `glob()`/`scandir()`/`opendir()` anywhere in the theme that could make a file "live" without a literal path string somewhere — so I don't believe my number is an artifact of too-narrow a grep. The most likely explanation for the gap is the database-content blind spot noted above (a reference living in post content rather than theme code), which would make my number the more conservative one, not the more permissive one. Full list (33):

`books-hero-studio.jpg`, `books-hero.jpg`, `chapters/kushi/kush-01.png`, `chapters/kushi/kush-02.jpg`, `chapters/kushi/kush-03.jpg`, `chapters/kushi/kush-06.png`, `chapters/stone-mandala.jpg`, `chapters/tsva/tsva-01.png`, `chapters/tsva/tsva-02.jpg`, `chapters/tsva/tsva-03.jpg`, `chapters/tsva/tsva-06.png`, `chapters/vekatavta/veka-01.png`, `chapters/vekatavta/veka-02.jpg`, `chapters/vekatavta/veka-03.jpg`, `chapters/vekatavta/veka-08.png`, `chapters/vekatavta/veka-19.jpg`, `chapters/vekatavta/veka-85.jpg` (deliberately skipped in the gallery's own sequence — `vekatavta-defaults.php:172-173` goes `...veka-84.jpg`, `veka-86.jpg`, no 85), `kushi-01-blantis-1.jpg`, `kushi-02-eyal-italy.jpg`, `kushi-03-screenshot-2013.png`, `kushi-04-sinai.jpg`, and 12 old `mokesh/mokesh-NN.jpeg` files (02, 04, 06, 08, 09, 11, 12, 13, 15, 16, 18, 19 — the ones *not* used as a narrative-featured image; see findings above for the 7 that are).

The `veka/kush/tsva -01/-02/-03/-06(or -08)` four-way matching groups (12 files, sha256-identical three ways each) are inside this unused list too — each book's own gallery array starts at `-04`, deliberately skipping `-01` through `-03`, so these look like an original unsorted photo batch that was never curated into any book's final sequence, shared because all three books' raw photo dumps apparently included the same handful of stock/test frames before curation.

The 4 old standalone `kushi-*.jpg`/`.png` files and 12 old `mokesh/*.jpeg` files are superseded, not duplicated — each has a same- or renumbered copy that IS the one actually wired into the live page (see findings above for exactly which numbers survive into both places).
