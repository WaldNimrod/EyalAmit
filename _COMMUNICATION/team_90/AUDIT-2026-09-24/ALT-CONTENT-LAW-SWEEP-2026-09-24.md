# ALT Content-Law Sweep — 2026-09-24

Evidence-gathering sweep only. No fixes, edits, deploys or commits were made. Findings below are for another session to act on.

## Method

- Live population enumerated from `{base}/wp-json/wp/v2/pages` and `/posts`, `per_page=100&status=publish`, paged to exhaustion (not from `page-sitemap.xml`).
- WP REST API reported **101 pages + 52 posts = 153** published objects.
- Each object's `link` was fetched directly (no redirect-following, per the health-check discipline) and every `<img>` tag's own `src`/`alt` extracted with regex + `html.unescape`.
- **16 of the 153 listed links returned HTTP 301** (stale REST `link` field — old category-prefixed slugs such as `/muzeh/...`, `/services/...`, `/tools-and-accessories/...`). Each was individually confirmed to redirect to a canonical URL that was **already present among the 137 directly-fetched pages** (e.g. `/muzeh/vekatavt/` → `/books/vekatavta/`), so no image content was missed — see the "Pages not fetched directly" section below for the full old→new map. Net unique pages with content actually read: **137**.
- Matching a live `<img>`'s filename to an export record: matched on the **stem** (basename, extension stripped, WordPress `-WxHpx`/`-scaled`/dedup-suffix stripped) of the live `src`, checked against the stem of **both** the export record's `filename` field and its `src` field (the export's `src` field frequently carries the *live* theme filename, e.g. `EA-000250.jpeg` in `filename` ships live as `eyal-bright.jpg` via its `src` field) — never on an exact filename-key match alone.
- The export JSON's own `oldSiteAlt` key is `null` on every one of the 851 records; the pre-existing-alt evidence that does exist lives in `oldSiteMetadata.altText` (populated on 41 records). That field was used wherever the task brief refers to "oldSiteAlt".
- `FROM_NOTE` / `FROM_OLD_ALT` were assigned by normalized string match (case/punctuation/whitespace-insensitive equality or substantial substring overlap) between the live alt and that file's `note` / `oldSiteMetadata.altText`. Everything that didn't auto-match was read individually and classified `DESCRIPTIVE` vs `ASSERTS_FACT` by hand.

## Counts

| Metric | Count |
|---|---|
| Pages+posts listed by REST API | 153 (101 pages + 52 posts) |
| Pages fetched directly with content read (200) | 137 |
| Pages resolved only via a 301 redirect (content already covered by the 137 above) | 16 |
| Pages that could not be read at all | 0 |
| Total `<img>` tags found across the 137 pages | 709 |
| Images with non-empty `alt` | 538 |
| Images with empty/missing `alt` | 171 |

### Non-empty `alt` bucket breakdown (538 total)

| Bucket | Count |
|---|---|
| FROM_NOTE | 17 |
| FROM_OLD_ALT | 5 |
| DESCRIPTIVE | 238 |
| **ASSERTS_FACT** | **22** |
| NO_SOURCE_ROW | 256 |

Note: the task brief's figure of "roughly 939 images in the system" is the *media-library* population; only 709 `<img>` tags were found actually rendered in page/post content across the 137 fetched pages (the rest live in unused library items, non-`<img>` CSS backgrounds, or post types outside pages/posts).

## ASSERTS_FACT — full table (the deliverable)

All 22 rows. Every one names a person, a place, a relationship, an event, or a year, and none of them is corroborated by that file's own `note` or `oldSiteMetadata.altText` in the export. 21 of the 22 sit on the two pages `/eyal-amit/mokesh-dahiman/` and `/eyal-amit/` (the "מוקש דהימן — לזכרו" / Mukesh Dahiman memorial material) plus 3 on the `/books/*` pages and 1 on the homepage.

| # | Page | Filename (live) | Live `alt` (verbatim) | `note` (verbatim) | `oldSiteMetadata.altText` (verbatim) |
|---|---|---|---|---|---|
| 1 | http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/ | tsva-bechol-cover.jpg | "אייל עמית, מחבר הספר «צבע בכחול וזרוק לים»" | none | none |
| 2 | http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ | vekatavt-cover.jpg | "אייל עמית — וכתבת" | "לשים בהירו" | none |
| 3 | http://eyalamit-co-il-2026.s887.upress.link/books/kushi-blantis/ | kushi-blantis-cover.jpg | "אייל עמית, מחבר הרומן כושי בלאנטיס" | none | none |
| 4 | http://eyalamit-co-il-2026.s887.upress.link/ | EA-000182.jpg | "צילום מסך של פלייליסט ספוטיפיי בשם Mukesh - The Art of Shanti Living מאת אייל עמית" | "גלריה כללית בתחתית העמוד" | none |
| 5 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | EA-000309.jpeg | "מוקש דהימן עם אייל עמית ברישיקש, הודו" | none | none |
| 6 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-01.jpg | "מוקש דהימן, מאסטר הדיג'רידו מרישיקש" | none | none |
| 7 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-03.jpg | "בית המלאכה של מוקש דהימן סמוך לגדת הגנגס ברישיקש" | "אני , גיא אח שלי ומוקש" | none |
| 8 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-05.jpg | "מוקש דהימן נושם בדיג'רידו בחצר בית המלאכה" | none | none |
| 9 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-07.jpg | "כפר קוטלי למרגלות ההימלאיה, מקום הסטודיו החדש של מוקש" | none | none |
| 10 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-10.jpg | "מוקש דהימן עם משפחתו, תיעוד נדיר מקוטלי" | "מוקש משקיף על הגנגס סמוך לקוטלי" | none |
| 11 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-14.jpg | "גדת נהר הגנגס ברישיקש, מקום טקס הפרידה ממוקש" | "אניטה אשתו של מוקש" | none |
| 12 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-17.jpg | "אייל עמית חוזר לרישיקש לסגור מעגל, 2026" | none | none |
| 13 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-01.jpg | "מוקש דהימן" | none | none |
| 14 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-02.jpg | "מוקש דהימן" | none | none |
| 15 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-05.jpg | "מוקש דהימן" | none | none |
| 16 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-06.jpg | "מוקש דהימן" | none | none |
| 17 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-07.jpg | "מוקש דהימן" | none | none |
| 18 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-12.jpg | "מוקש דהימן" | none | none |
| 19 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-16.jpg | "מוקש דהימן" | none | none |
| 20 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-17.jpg | "מוקש דהימן" | none | none |
| 21 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | mokesh-18.jpg | "מוקש דהימן" | none | none |
| 22 | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/ | EA-000309.jpeg | "אייל עמית עם המאסטר מוקש דהימן ברישיקש, הודו" | none | none |

Context observed but **not** counted as a match per the task's note/oldSiteAlt-only rule: every one of the Mukesh rows carries `assignedPage: "מוקש דהימן — לזכרו"` in the export, i.e. Eyal himself filed these photos under a page dedicated to Mukesh's memory. That confirms the general subject but not the specific claims in each alt (the Rishikesh/Ganges/Kotli locations, "his workshop", "with his family", the 2026 return date, or the described farewell-ceremony event) — those specific facts have no note or oldSiteAlt backing on the individual file records themselves.

## Empty / missing `alt` — full table (171 rows)

Listed for completeness only; no judgment is made on whether empty is correct.

| # | Page | Filename (live) |
|---|---|---|
| 1 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr47/ | hqdefault.jpg |
| 2 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr46/ | hqdefault.jpg |
| 3 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr45/ | hqdefault.jpg |
| 4 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr44/ | hqdefault.jpg |
| 5 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr43/ | hqdefault.jpg |
| 6 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr42/ | hqdefault.jpg |
| 7 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr40/ | hqdefault.jpg |
| 8 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr39/ | hqdefault.jpg |
| 9 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr38/ | hqdefault.jpg |
| 10 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr37/ | hqdefault.jpg |
| 11 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr37/ | hqdefault.jpg |
| 12 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr36/ | hqdefault.jpg |
| 13 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr35/ | hqdefault.jpg |
| 14 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr34/ | hqdefault.jpg |
| 15 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr33/ | hqdefault.jpg |
| 16 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr32/ | hqdefault.jpg |
| 17 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr32/ | hqdefault.jpg |
| 18 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr31/ | hqdefault.jpg |
| 19 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr31/ | hqdefault.jpg |
| 20 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr30/ | hqdefault.jpg |
| 21 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr30/ | hqdefault.jpg |
| 22 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr29/ | hqdefault.jpg |
| 23 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr28/ | eat2-450x297.jpg |
| 24 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr28/ | eat1-450x297.jpg |
| 25 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr28/ | hqdefault.jpg |
| 26 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr28/ | hqdefault.jpg |
| 27 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr27/ | hqdefault.jpg |
| 28 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr27/ | hqdefault.jpg |
| 29 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr26/ | hqdefault.jpg |
| 30 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr25/ | hqdefault.jpg |
| 31 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr24/ | hqdefault.jpg |
| 32 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr23/ | hqdefault.jpg |
| 33 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr23/ | hqdefault.jpg |
| 34 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr22/ | hqdefault.jpg |
| 35 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr22/ | hqdefault.jpg |
| 36 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr21/ | flickr_4030994475.jpg |
| 37 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr21/ | flickr_4030995601.jpg |
| 38 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr21/ | flickr_4030994831.jpg |
| 39 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr21/ | flickr_4030995255.jpg |
| 40 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr21/ | flickr_4030995031.jpg |
| 41 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr21/ | flickr_4031748522.jpg |
| 42 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr20/ | hqdefault.jpg |
| 43 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr19/ | hqdefault.jpg |
| 44 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr18/ | hqdefault.jpg |
| 45 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr18/ | hqdefault.jpg |
| 46 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr17/ | hqdefault.jpg |
| 47 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr17/ | hqdefault.jpg |
| 48 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr17/ | hqdefault.jpg |
| 49 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr16/ | hqdefault.jpg |
| 50 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr16/ | hqdefault.jpg |
| 51 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr15/ | hqdefault.jpg |
| 52 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr15/ | hqdefault.jpg |
| 53 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr14/ | hqdefault.jpg |
| 54 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr14/ | hqdefault.jpg |
| 55 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr14/ | mongabay_braz_defor_88-05.jpg |
| 56 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr12/ | hqdefault.jpg |
| 57 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr11/ | hqdefault.jpg |
| 58 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr11/ | hqdefault.jpg |
| 59 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr10/ | hqdefault.jpg |
| 60 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr10/ | hqdefault.jpg |
| 61 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr10/ | hqdefault.jpg |
| 62 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr9/ | hqdefault.jpg |
| 63 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr9/ | hqdefault.jpg |
| 64 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr9/ | hqdefault.jpg |
| 65 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr8/ | hqdefault.jpg |
| 66 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr7/ | hqdefault.jpg |
| 67 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr6/ | hqdefault.jpg |
| 68 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr5/ | hqdefault.jpg |
| 69 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr3/ | hqdefault.jpg |
| 70 | http://eyalamit-co-il-2026.s887.upress.link/qr/qr2/ | hqdefault.jpg |
| 71 | http://eyalamit-co-il-2026.s887.upress.link/repair/ | EA-000239.jpeg |
| 72 | http://eyalamit-co-il-2026.s887.upress.link/repair/ | EA-000298.jpg |
| 73 | http://eyalamit-co-il-2026.s887.upress.link/repair/ | EA-000214.jpeg |
| 74 | http://eyalamit-co-il-2026.s887.upress.link/repair/ | EA-000238.jpeg |
| 75 | http://eyalamit-co-il-2026.s887.upress.link/repair/ | EA-000220.jpeg |
| 76 | http://eyalamit-co-il-2026.s887.upress.link/repair/ | EA-000268.jpeg |
| 77 | http://eyalamit-co-il-2026.s887.upress.link/repair/ | EA-000161.jpg |
| 78 | http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ | veka-54.jpg |
| 79 | http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ | veka-69.jpg |
| 80 | http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ | veka-76.jpg |
| 81 | http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ | veka-90.jpg |
| 82 | http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ | veka-94.jpg |
| 83 | http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ | veka-99.jpg |
| 84 | http://eyalamit-co-il-2026.s887.upress.link/contact/ | eyal-child-phone.jpg |
| 85 | http://eyalamit-co-il-2026.s887.upress.link/ | studio-interior.jpg |
| 86 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa/ | 371822714_781671903965228_7156812037328721336_n-412x450.jpg |
| 87 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a2%d7%95%d7%93-%d7%a8%d7%92%d7%a2-%d7%9e%d7%97%d7%99%d7%99%d7%95-%d7%a9%d7%9c-%d7%9e%d7%95%d7%a8%d7%94-%d7%9c%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95/ | סופר-450x338.jpg |
| 88 | http://eyalamit-co-il-2026.s887.upress.link/%d7%98%d7%99%d7%a4%d7%95%d7%9c-%d7%91%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%91%d7%90%d7%9e%d7%a6%d7%a2%d7%95%d7%aa-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%9c%d7%9c%d7%9e%d7%95%d7%93-%d7%9c/ | 377997335_789649919834093_2093968922390110774_n-450x343.jpg |
| 89 | http://eyalamit-co-il-2026.s887.upress.link/%d7%9e%d7%95%d7%a7%d7%a9-%d7%93%d7%94%d7%99%d7%9e%d7%9f-%d7%9e%d7%90%d7%a1%d7%98%d7%a8-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a6%d7%99%d7%95%d7%a8-%d7%9e%d7%a7%d7%95%d7%a8%d7%99-%d7%97/ | mukesh-dhiman-מוקש-דהימן-2-256x450.jpg |
| 90 | http://eyalamit-co-il-2026.s887.upress.link/%d7%9e%d7%95%d7%a7%d7%a9-%d7%93%d7%94%d7%99%d7%9e%d7%9f-%d7%9e%d7%90%d7%a1%d7%98%d7%a8-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a6%d7%99%d7%95%d7%a8-%d7%9e%d7%a7%d7%95%d7%a8%d7%99-%d7%97/ | mukesh-dhiman-מוקש-דהימן-5-253x450.jpg |
| 91 | http://eyalamit-co-il-2026.s887.upress.link/%d7%9e%d7%95%d7%a7%d7%a9-%d7%93%d7%94%d7%99%d7%9e%d7%9f-%d7%9e%d7%90%d7%a1%d7%98%d7%a8-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a6%d7%99%d7%95%d7%a8-%d7%9e%d7%a7%d7%95%d7%a8%d7%99-%d7%97/ | mukesh-dhiman-מוקש-דהימן-1-312x450.jpg |
| 92 | http://eyalamit-co-il-2026.s887.upress.link/%d7%95%d7%a1%d7%99%d7%a4%d7%a8%d7%aa%d6%b8%d6%bc-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%a4%d7%95%d7%a7%d7%9f-%d7%a1%d7%98%d7%95%d7%a8%d7%99%d7%96-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e/ | מוקטן.jpg |
| 93 | http://eyalamit-co-il-2026.s887.upress.link/%d7%94%d7%96%d7%9e%d7%a0%d7%94-%d7%9c%d7%94%d7%a9%d7%a7%d7%aa-%d7%94%d7%a1%d7%a4%d7%a8-%d7%94%d7%97%d7%93%d7%a9-%d7%95%d7%9b%d7%aa%d7%91%d7%aa%d6%b8-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e/ | uni.jpg |
| 94 | http://eyalamit-co-il-2026.s887.upress.link/%d7%94%d7%96%d7%9e%d7%a0%d7%94-%d7%9c%d7%94%d7%a9%d7%a7%d7%aa-%d7%94%d7%a1%d7%a4%d7%a8-%d7%94%d7%97%d7%93%d7%a9-%d7%95%d7%9b%d7%aa%d7%91%d7%aa%d6%b8-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e/ | book.jpg |
| 95 | http://eyalamit-co-il-2026.s887.upress.link/%d7%9b%d7%aa%d7%91%d7%94-%d7%a2%d7%9c-%d7%aa%d7%95%d7%a4%d7%a2%d7%aa-%d7%99%d7%97%d7%99%d7%93-%d7%91-%d7%94%d7%9e%d7%a7%d7%95%d7%9e%d7%95%d7%9f-%d7%92%d7%91%d7%a2%d7%aa%d7%99%d7%99%d7%9d-%d7%a8/ | GIVATAIM-300x227.jpg |
| 96 | http://eyalamit-co-il-2026.s887.upress.link/%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%aa%d7%95%d7%a4%d7%a2%d7%aa-%d7%99%d7%97%d7%99%d7%93-%d7%9e%d7%95%d7%a4%d7%a2-%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-spoken-stories-15/ | 11406568_10156001449435206_6177482397757732265_o-300x225.jpg |
| 97 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%aa%d7%95%d7%a4%d7%a2/ | GIVATAIM-300x227.jpg |
| 98 | http://eyalamit-co-il-2026.s887.upress.link/%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%a9%d7%99%d7%a9%d7%99-23-10-15-%d7%91%d7%aa%d7%99%d7%90/ | arm2.jpg |
| 99 | http://eyalamit-co-il-2026.s887.upress.link/%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%a9%d7%99%d7%a9%d7%99-23-10-15-%d7%91%d7%aa%d7%99%d7%90/ | GIVATAIM-300x227.jpg |
| 100 | http://eyalamit-co-il-2026.s887.upress.link/2228-2/ | katava1-225x300.jpg |
| 101 | http://eyalamit-co-il-2026.s887.upress.link/2228-2/ | katava2-125x300.jpg |
| 102 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a9%d7%a0%d7%99-%d7%aa%d7%90%d7%a8%d7%99%d7%9b%d7%99%d7%9d-%d7%a7%d7%a8%d7%95%d7%91%d7%99%d7%9d-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90/ | שי-אביבי-290x300.jpg |
| 103 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a9%d7%a0%d7%99-%d7%aa%d7%90%d7%a8%d7%99%d7%9b%d7%99%d7%9d-%d7%a7%d7%a8%d7%95%d7%91%d7%99%d7%9d-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90/ | AVRAHAM.jpg |
| 104 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a9%d7%a0%d7%99-%d7%aa%d7%90%d7%a8%d7%99%d7%9b%d7%99%d7%9d-%d7%a7%d7%a8%d7%95%d7%91%d7%99%d7%9d-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90/ | ALON.jpg |
| 105 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a9%d7%a0%d7%99-%d7%aa%d7%90%d7%a8%d7%99%d7%9b%d7%99%d7%9d-%d7%a7%d7%a8%d7%95%d7%91%d7%99%d7%9d-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90/ | ruti.jpg |
| 106 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a9%d7%a0%d7%99-%d7%aa%d7%90%d7%a8%d7%99%d7%9b%d7%99%d7%9d-%d7%a7%d7%a8%d7%95%d7%91%d7%99%d7%9d-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90/ | eran.jpg |
| 107 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a9%d7%a0%d7%99-%d7%aa%d7%90%d7%a8%d7%99%d7%9b%d7%99%d7%9d-%d7%a7%d7%a8%d7%95%d7%91%d7%99%d7%9d-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90/ | dorit1.jpg |
| 108 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a9%d7%a0%d7%99-%d7%aa%d7%90%d7%a8%d7%99%d7%9b%d7%99%d7%9d-%d7%a7%d7%a8%d7%95%d7%91%d7%99%d7%9d-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90/ | michal1.jpg |
| 109 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a9%d7%a0%d7%99-%d7%aa%d7%90%d7%a8%d7%99%d7%9b%d7%99%d7%9d-%d7%a7%d7%a8%d7%95%d7%91%d7%99%d7%9d-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90/ | eyaleyal.jpg |
| 110 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a9%d7%a0%d7%94-%d7%9c%d7%97%d7%95%d7%a7-%d7%94%d7%a1%d7%a4%d7%a8%d7%99%d7%9d-%d7%a6%d7%a0%d7%99%d7%97%d7%94-%d7%a9%d7%9c-35-%d7%91%d7%9e%d7%9b%d7%99%d7%a8%d7%95%d7%aa-%d7%a9%d7%9c-%d7%a1%d7%a4/ | books-214x300.png |
| 111 | http://eyalamit-co-il-2026.s887.upress.link/%d7%93%d7%a3-%d7%a4%d7%99%d7%99%d7%a1%d7%91%d7%95%d7%a7-%d7%97%d7%93%d7%a9-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%96%d7%9e%d7%a0%d7%94-%d7%9c%d7%a9%d7%a0%d7%99-%d7%94%d7%9e%d7%95%d7%a4%d7%a2%d7%99/ | DSC_0785-199x300.jpg |
| 112 | http://eyalamit-co-il-2026.s887.upress.link/%d7%93%d7%a3-%d7%a4%d7%99%d7%99%d7%a1%d7%91%d7%95%d7%a7-%d7%97%d7%93%d7%a9-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%96%d7%9e%d7%a0%d7%94-%d7%9c%d7%a9%d7%a0%d7%99-%d7%94%d7%9e%d7%95%d7%a4%d7%a2%d7%99/ | a16f5b3e-3e1a-4c08-a36c-2c1bc8105ec3.png |
| 113 | http://eyalamit-co-il-2026.s887.upress.link/%d7%93%d7%a3-%d7%a4%d7%99%d7%99%d7%a1%d7%91%d7%95%d7%a7-%d7%97%d7%93%d7%a9-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%96%d7%9e%d7%a0%d7%94-%d7%9c%d7%a9%d7%a0%d7%99-%d7%94%d7%9e%d7%95%d7%a4%d7%a2%d7%99/ | 9137f706-23f6-4587-a46e-3ab8cafaf495.png |
| 114 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-15-11-14-%d7%91%d7%aa/ | Screen-Shot-2014-10-28-at-10.06.19-PM.png |
| 115 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-15-11-14-%d7%91%d7%aa/ | Screen-Shot-2014-10-28-at-11.59.23-PM.png |
| 116 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%94%d7%95%d7%a4%d7%a2%d7%94-%d7%91%d7%9e%d7%95%d7%a6%d7%a9-%d7%94%d7%a7%d7%a8%d7%95%d7%91-13-9-14-%d7%91%d7%a4%d7%a8%d7%93%d7%a1-%d7%97%d7%a0%d7%94/ | פרדס-חפלה-אייל-עמית.jpg |
| 117 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%94%d7%95%d7%a4%d7%a2%d7%94-%d7%91%d7%9e%d7%95%d7%a6%d7%a9-%d7%94%d7%a7%d7%a8%d7%95%d7%91-13-9-14-%d7%91%d7%a4%d7%a8%d7%93%d7%a1-%d7%97%d7%a0%d7%94/ | tzavta.jpg |
| 118 | http://eyalamit-co-il-2026.s887.upress.link/2-8-%d7%9e%d7%95%d7%a4%d7%a2-%d7%91%d7%a6%d7%95%d7%95%d7%aa%d7%90-20-%d7%9e%d7%94%d7%9e%d7%a7%d7%95%d7%9e%d7%95%d7%aa-%d7%91%d7%90%d7%95%d7%9c%d7%9d-%d7%97%d7%99%d7%a0%d7%9d-%d7%9c%d7%aa%d7%95%d7%a9/ | צוותא-אייל-עמית-300x296.jpg |
| 119 | http://eyalamit-co-il-2026.s887.upress.link/%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%9a-%d7%94%d7%aa%d7%97%d7%9c%d7%aa%d7%99-%d7%9c%d7%9b%d7%aa%d7%95%d7%91-%d7%95%d7%9c%d7%a1%d7%a4/ | כל-הפרדס-אייל-עמית-257x300.jpg |
| 120 | http://eyalamit-co-il-2026.s887.upress.link/%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%9a-%d7%94%d7%aa%d7%97%d7%9c%d7%aa%d7%99-%d7%9c%d7%9b%d7%aa%d7%95%d7%91-%d7%95%d7%9c%d7%a1%d7%a4/ | 2.jpg |
| 121 | http://eyalamit-co-il-2026.s887.upress.link/%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%9a-%d7%94%d7%aa%d7%97%d7%9c%d7%aa%d7%99-%d7%9c%d7%9b%d7%aa%d7%95%d7%91-%d7%95%d7%9c%d7%a1%d7%a4/ | 31.jpg |
| 122 | http://eyalamit-co-il-2026.s887.upress.link/%d7%9c%d7%90-%d7%91%d7%a2%d7%95%d7%93-%d7%a8%d7%92%d7%a2-%d7%9c%d7%90-%d7%91%d7%a2%d7%95%d7%93-%d7%a9%d7%a0%d7%99%d7%99%d7%94-%d7%a2-%d7%9b-%d7%a9-%d7%99-%d7%95/ | צוותא-אייל-עמית-300x296.jpg |
| 123 | http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/ | קולאז-של-כל-החברים-ממליצים-על-המופע-300x289.jpg |
| 124 | http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/ | אייל-עמית3-300x200.jpg |
| 125 | http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/ | אייל-עמית5-300x200.jpg |
| 126 | http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/ | אייל-עמית-33-200x300.jpg |
| 127 | http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/ | אייל-עמית-89-300x200.jpg |
| 128 | http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/ | אייל-עמית-65-300x200.jpg |
| 129 | http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/ | אייל-עמית-93-300x200.jpg |
| 130 | http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/ | אייל-עמית-92-300x200.jpg |
| 131 | http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/ | אייל-עמית-174-300x280.jpg |
| 132 | http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/ | אייל-עמית11-212x300.jpg |
| 133 | http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/ | אייל-עמית-120-300x200.jpg |
| 134 | http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/ | אייל-עמית3-300x200.jpg |
| 135 | http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/ | אייל-עמית-123-300x200.jpg |
| 136 | http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/ | אייל-עמית-173-300x200.jpg |
| 137 | http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/ | אייל-עמית-63-300x200.jpg |
| 138 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a1%d7%a8%d7%98%d7%99%d7%9d-%d7%9e%d7%94%d7%97%d7%99%d7%99%d7%9d-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99/ | event10april14.jpg |
| 139 | http://eyalamit-co-il-2026.s887.upress.link/100-100-100-%d7%aa%d7%95%d7%93%d7%94/ | thanks.jpg |
| 140 | http://eyalamit-co-il-2026.s887.upress.link/%d7%a2%d7%9e%d7%99%d7%aa-%d7%91%d7%99%d6%b8%d7%93%d6%b4%d7%99%d7%aa-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99/ | אייל-עמית-מופע-סיפורים-במועדון-האזור-תל-אביב.jpg |
| 141 | http://eyalamit-co-il-2026.s887.upress.link/%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%94%d7%a1%d7%a4%d7%a8-%d7%94%d7%97%d7%93%d7%a9-%d7%a9%d7%9c%d7%99-%d7%96%d7%a7%d7%95%d7%a7-%d7%9c/ | headstart.jpg |
| 142 | http://eyalamit-co-il-2026.s887.upress.link/%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%94%d7%a1%d7%a4%d7%a8-%d7%94%d7%97%d7%93%d7%a9-%d7%a9%d7%9c%d7%99-%d7%96%d7%a7%d7%95%d7%a7-%d7%9c/ | AAA.jpg |
| 143 | http://eyalamit-co-il-2026.s887.upress.link/%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a4%d7%a8%d7%93%d7%a1-%d7%97%d7%a0%d7%94-%d7%a1%d7%98%d7%95%d7%93%d7%99%d7%95-%d7%9c%d7%91%d7%a0%d7%99%d7%99%d7%94-%d7%95%d7%a0%d7%92%d7%99%d7%a0/ | e681621f8f-_25D7_2599_25D7_2595_25D7_2590_25D7_2591_2520_25D7_25A7_25D7_259C_25D7_2599_25D7_2599_25D7_259E_25D7_259F.jpg |
| 144 | http://eyalamit-co-il-2026.s887.upress.link/%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a4%d7%a8%d7%93%d7%a1-%d7%97%d7%a0%d7%94-%d7%a1%d7%98%d7%95%d7%93%d7%99%d7%95-%d7%9c%d7%91%d7%a0%d7%99%d7%99%d7%94-%d7%95%d7%a0%d7%92%d7%99%d7%a0/ | 37826df9b5-DSC00864.jpg |
| 145 | http://eyalamit-co-il-2026.s887.upress.link/%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a4%d7%a8%d7%93%d7%a1-%d7%97%d7%a0%d7%94-%d7%a1%d7%98%d7%95%d7%93%d7%99%d7%95-%d7%9c%d7%91%d7%a0%d7%99%d7%99%d7%94-%d7%95%d7%a0%d7%92%d7%99%d7%a0/ | a6294a12b9-_25D7_2599_25D7_2595_25D7_25A8_25D7_259D_2520_25D7_25A1_25D7_2599_25D7_2595_25D7_259F_2520_25D7_2595_25D7_2599_25D7_2590_25D7_2599_25D7_25A8_2520_25D7_2592_25D7_25A4_25D7_25A0_25D7_2599.jpg |
| 146 | http://eyalamit-co-il-2026.s887.upress.link/%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a4%d7%a8%d7%93%d7%a1-%d7%97%d7%a0%d7%94-%d7%a1%d7%98%d7%95%d7%93%d7%99%d7%95-%d7%9c%d7%91%d7%a0%d7%99%d7%99%d7%94-%d7%95%d7%a0%d7%92%d7%99%d7%a0/ | f6f1eb83d1-DSC00871.jpg |
| 147 | http://eyalamit-co-il-2026.s887.upress.link/%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a4%d7%a8%d7%93%d7%a1-%d7%97%d7%a0%d7%94-%d7%a1%d7%98%d7%95%d7%93%d7%99%d7%95-%d7%9c%d7%91%d7%a0%d7%99%d7%99%d7%94-%d7%95%d7%a0%d7%92%d7%99%d7%a0/ | 3d071e7fd0-DSC00869.jpg |
| 148 | http://eyalamit-co-il-2026.s887.upress.link/%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a4%d7%a8%d7%93%d7%a1-%d7%97%d7%a0%d7%94-%d7%a1%d7%98%d7%95%d7%93%d7%99%d7%95-%d7%9c%d7%91%d7%a0%d7%99%d7%99%d7%94-%d7%95%d7%a0%d7%92%d7%99%d7%a0/ | 207900a3c7-DSC00872.jpg |
| 149 | http://eyalamit-co-il-2026.s887.upress.link/%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a4%d7%a8%d7%93%d7%a1-%d7%97%d7%a0%d7%94-%d7%a1%d7%98%d7%95%d7%93%d7%99%d7%95-%d7%9c%d7%91%d7%a0%d7%99%d7%99%d7%94-%d7%95%d7%a0%d7%92%d7%99%d7%a0/ | db3f17081d-DSC05940.jpg |
| 150 | http://eyalamit-co-il-2026.s887.upress.link/%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a4%d7%a8%d7%93%d7%a1-%d7%97%d7%a0%d7%94-%d7%a1%d7%98%d7%95%d7%93%d7%99%d7%95-%d7%9c%d7%91%d7%a0%d7%99%d7%99%d7%94-%d7%95%d7%a0%d7%92%d7%99%d7%a0/ | 552bc17e8d-IMG_1366.jpg |
| 151 | http://eyalamit-co-il-2026.s887.upress.link/%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a4%d7%a8%d7%93%d7%a1-%d7%97%d7%a0%d7%94-%d7%a1%d7%98%d7%95%d7%93%d7%99%d7%95-%d7%9c%d7%91%d7%a0%d7%99%d7%99%d7%94-%d7%95%d7%a0%d7%92%d7%99%d7%a0/ | 45d0419b61-DSC00231.jpg |
| 152 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | idan.jpg |
| 153 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | adi.jpg |
| 154 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | keren-a.jpg |
| 155 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | mukesh.jpg |
| 156 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | בוטאן.jpg |
| 157 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | 202020-2020204.jpg |
| 158 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | 202020-2020203.jpg |
| 159 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | 202020-2020202.jpg |
| 160 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | 2020-.jpg |
| 161 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | 20201.jpg |
| 162 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | niv.jpg |
| 163 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | oren-agiyon-small.jpg |
| 164 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | P1010474.jpg |
| 165 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | Screen20Shot202013-03-1220at208.png |
| 166 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | סיני-יוני-09-285.jpg |
| 167 | http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/ | רותם-כהן-צבע-בכחול-וזרוק-לים-הודו-1.jpg |
| 168 | http://eyalamit-co-il-2026.s887.upress.link/43-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%93%d7%95%d7%9f-%d7%a1%d7%9c%d7%99%d7%97%d7%95%d7%aa/ | סליחות-כותל.jpg |
| 169 | http://eyalamit-co-il-2026.s887.upress.link/40-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%a4%d7%a8%d7%a1%d7%95%d7%9e%d7%aa-%d7%90%d7%97%d7%aa-%d7%95%d7%97%d7%96%d7%a8%d7%a0%d7%95/ | %D7%A8%D7%95%D7%A0%D7%99-%D7%93%D7%9C%D7%95%D7%9E%D7%99.jpg |
| 170 | http://eyalamit-co-il-2026.s887.upress.link/34-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%94%d7%9c%d7%91/ | כושי-בלאנטיס-עטיפה-מלאה.jpg |
| 171 | http://eyalamit-co-il-2026.s887.upress.link/34-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%94%d7%9c%d7%91/ | כושי-בלאנטיס-הגדלה.jpg |

## Pages not fetched directly (16 — all 301, all resolved to already-covered canonical URLs)

| REST-listed link (301) | Redirects to | Already among the 137? |
|---|---|---|
| http://eyalamit-co-il-2026.s887.upress.link/about/moksha/ | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | yes |
| http://eyalamit-co-il-2026.s887.upress.link/muzza/vekatavt/ | http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ | yes |
| http://eyalamit-co-il-2026.s887.upress.link/muzza/tsva-bechol-ve-zorek-layam/ | http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/ | yes |
| http://eyalamit-co-il-2026.s887.upress.link/muzza/ | http://eyalamit-co-il-2026.s887.upress.link/books/ | yes |
| http://eyalamit-co-il-2026.s887.upress.link/muzeh/vekatavt/ | http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ | yes |
| http://eyalamit-co-il-2026.s887.upress.link/muzeh/kushi-blantis/ | http://eyalamit-co-il-2026.s887.upress.link/books/kushi-blantis/ | yes |
| http://eyalamit-co-il-2026.s887.upress.link/muzeh/tsva-bechol-ve-zorek-layam/ | http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/ | yes |
| http://eyalamit-co-il-2026.s887.upress.link/muzeh/ | http://eyalamit-co-il-2026.s887.upress.link/books/ | yes |
| http://eyalamit-co-il-2026.s887.upress.link/tools-and-accessories/repair/ | http://eyalamit-co-il-2026.s887.upress.link/repair/ | yes |
| http://eyalamit-co-il-2026.s887.upress.link/tools-and-accessories/instruments/ | http://eyalamit-co-il-2026.s887.upress.link/didgeridoos/ | yes |
| http://eyalamit-co-il-2026.s887.upress.link/tools-and-accessories/ | http://eyalamit-co-il-2026.s887.upress.link/shop/ | yes |
| http://eyalamit-co-il-2026.s887.upress.link/courses-soon/ | http://eyalamit-co-il-2026.s887.upress.link/learning/courses-external/ | yes |
| http://eyalamit-co-il-2026.s887.upress.link/hashita/ | http://eyalamit-co-il-2026.s887.upress.link/method/ | yes |
| http://eyalamit-co-il-2026.s887.upress.link/services/handmade-instruments/ | http://eyalamit-co-il-2026.s887.upress.link/didgeridoos/ | yes |
| http://eyalamit-co-il-2026.s887.upress.link/services/didgeridoo-treatment-breath/ | http://eyalamit-co-il-2026.s887.upress.link/treatment/ | yes |
| http://eyalamit-co-il-2026.s887.upress.link/services/didgeridoo-lessons/ | http://eyalamit-co-il-2026.s887.upress.link/lessons/ | yes |

No page returned a non-200/non-301 status; no page was entirely unreachable.
