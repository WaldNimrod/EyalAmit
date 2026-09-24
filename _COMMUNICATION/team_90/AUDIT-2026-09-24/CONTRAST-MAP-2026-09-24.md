# Contrast Map — EyalAmit.co.il-2026 (2026-09-24)

Prepared for owner approval. This map supersedes the earlier line-item that conflated the breadcrumb and the eyebrow into one finding. Every ratio below was measured against the actual painted pixels behind the text (photo + scrim + gradient composited, not the raw CSS token), sampled at 5–15 points across each element's box, worst point reported per page.

Repo: `EyalAmit.co.il-2026`. Live staging: http://eyalamit-co-il-2026.s887.upress.link (HTTP is intentional; the staging TLS cert is invalid by design and is not a finding here).

## Population and methodology

- Enumerated the live population from the REST API (`/wp-json/wp/v2/pages` + `/wp-json/wp/v2/posts`, `status=publish`, paginated): **153 published URLs** (101 pages + 52 posts). All 153 fetches returned HTTP 200 with a substantive body (no silent failures — this was checked explicitly before counting anything as clean).
- Cross-check: `page-sitemap.xml` lists 83 URLs and `post-sitemap.xml` lists 53 (136 total) — fewer than the REST count, which supports the mandate's own caution against using the sitemap for this. **However, the mandate's working figure of "~279 published URLs" does not match anything measured on this staging instance either** (REST: 153, sitemap: 136). Flagging the mismatch rather than silently reconciling it, per the standing instruction to verify a spec's numbers against live code before acting on them. The population used throughout this map is the 153 REST-enumerated URLs.
- For every one of the 153 URLs, fetched the rendered HTML and recorded which of ~45 candidate text-bearing CSS classes are actually present, using word-boundary-safe matching with `<style>`/`<script>` stripped first. (A naive plain-substring match falsely matched every `phero__h` as an instance of `hero__h` on the first pass — `phero__h` contains `hero__h` as a literal substring — and was corrected before any count was trusted.)
- For pixel measurement: loaded each URL in a same-origin iframe at 1440×900 (desktop only — see Section 4), waited two animation frames plus a settle timeout, then for every matched element sampled 5 points (single-line text) or 15 points (multi-line: 3 rows × 5 columns) across its rendered box. For each point, walked the real paint stack (`elementsFromPoint`, topmost to bottommost, including the element's own box), compositing in order: photograph pixels (canvas-sampled from the actual `<img>`/`<video>` frame, `object-fit` accounted for), CSS gradient scrims (evaluated analytically from the browser's own resolved gradient stops at that point — not assumed from source), and solid colours, alpha-composited bottom-up. This is the actual painted result, not the source photo and not the design token.
- Threshold applied per element: **3.0:1** for large text (≥24px, or ≥18.66px at bold/600-weight), **4.5:1** otherwise. Stated on every row below.
- Worst-of-N is reported per page; the range across pages is reported per element type.

### Three measurement bugs found and fixed while building this map

Disclosed in full because the brief specifically warns that a rule producing a wave of failures is usually the rule's fault, not the site's — three different bugs in this method produced exactly that pattern before being caught:

1. **Scroll-reveal animation caught mid-fade.** Every `.r` element on this theme fades in over 1.4s via an IntersectionObserver-triggered `.in` class (`ea-entrance.js`, `chapters.css:378`). Sampling before that settles understates contrast against elements still partway to their final opacity (the home page's `.studio__h` first measured 1.12:1 fully transparent-adjacent; forcing the settled state gives 19.81:1). Fixed by forcing `.r{opacity:1;transform:none}` and adding the `.in` class before sampling.
2. **A `position:fixed` reveal-footer was measured against what was behind it.** The footer (`.foot.uncover`) is pinned to the viewport and only becomes the topmost paint once the document is scrolled near its end; `scrollIntoView()` is a no-op for `position:fixed` elements, so an early pass sampled footer links while the page's own hero section was still on top at that screen point (footer links first read 1.0–2.4:1 against a false white background instead of the real dark footer). Fixed by detecting a `position:fixed` ancestor, checking whether the target is genuinely the topmost paint at its own centre-point, and force-scrolling to the document's end when it isn't — then restoring scroll position before moving to the next element (an earlier version of this fix omitted the restore step and corrupted the *next* element sampled on the same page, which is bug 3).
3. **An element's own background-colour was excluded from itself.** For a self-contained badge like `.dd__tag` (a step-number pill with `background: var(--terra)` declared on the pill itself), the rule "exclude the target element and composite what's behind it" wrongly discarded the pill's own paint, leaving only the page background behind the whole widget — a false ~1.0:1 reading on every step number. Fixed by compositing the target's own declared background as the base layer before falling through to ancestors. Corrected reading: 4.63–5.50:1, which lines up with an existing in-code audit comment at `chapters.css:23–28` recording 4.59:1 / 5.50:1 for this exact pair from a prior review.

## Section 1 — Approval list: elements that genuinely still need improvement

Ordered worst-first, weighted by how many pages carry the element. One row per element type — the owner approves a fix *pattern*, not per-page repairs. In every row below the only in-scope direction is a background/scrim change (or, for item 2, restoring a missing function argument); no colour token or type-scale value is touched, per the locked canons.

### 1. `.ea-crumb__link` — קישור "בית" בתוך פירורי הלחם (הקישור הכתום, לא הטקסט הלבן)

- **What it is:** the clickable "Home" segment inside the breadcrumb trail. Same terracotta colour token as the eyebrow (item 2) — a different element from the plain white breadcrumb text the owner already checked (see Section 2).
- **Style:** colour rgb(208, 138, 94), font-size 15.30px, weight 300
- **Threshold applied:** 4.5:1 (normal text)
- **Worst measured ratio:** 1.41:1 — **range across sampled pages:** 1.41–7.12:1
- **Population:** appears on **100 of the 153 published URLs**. Directly pixel-measured on 58 of them (not inferred); **36 of those 58 failed** the 4.5:1 threshold.
- **Note:** Styled `color:var(--terra-lt)` at `ea-breadcrumbs.css:11` for the on-dark variant. Placed over the same photo-backed heroes as the eyebrow, it inherits the eyebrow's core problem: terracotta does not separate enough, in luminance, from typical warm photo mid-tones.
- **Representative URL to open:** [/sound-healing/](http://eyalamit-co-il-2026.s887.upress.link/sound-healing/) — סאונד הילינג
- **Pages measured and confirmed failing (36):**
  - [/32-הטור-של-אייל-עמית-אם-אין-אני-לי-מי-לי/](http://eyalamit-co-il-2026.s887.upress.link/32-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%9d-%d7%90%d7%99%d7%9f-%d7%90%d7%a0%d7%99-%d7%9c%d7%99-%d7%9e%d7%99-%d7%9c%d7%99/) — (32) הטור של אייל עמית: אם אין אני לי – מי לי
  - [/47-הטור-של-אייל-עמית-זמן-חלום/](http://eyalamit-co-il-2026.s887.upress.link/47-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%96%d7%9e%d7%9f-%d7%97%d7%9c%d7%95%d7%9d/) — זמן חלום (וידאו בלוג) – השקת הספר 'כושי בלאנטיס' גג מסעדת הטאלי 24 רופי | אוגוסט 2004
  - [/60-הטור-של-אייל-עמית-איי-אם-בק/](http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/) — פרוייקט "מטיילים מצטלמים" עם הספרים של מוזה הוצאה לאור
  - [/about/moksha/](http://eyalamit-co-il-2026.s887.upress.link/about/moksha/) — מוקש דהימן — לזכרו
  - [/accessibility/](http://eyalamit-co-il-2026.s887.upress.link/accessibility/) — הצהרת נגישות
  - [/blog/](http://eyalamit-co-il-2026.s887.upress.link/blog/) — בלוג
  - [/books/](http://eyalamit-co-il-2026.s887.upress.link/books/) — ספרים
  - [/books/kushi-blantis/](http://eyalamit-co-il-2026.s887.upress.link/books/kushi-blantis/) — כושי בלאנטיס
  - [/books/tsva-bekahol/](http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/) — צבע בכחול וזרוק לים
  - [/contact/](http://eyalamit-co-il-2026.s887.upress.link/contact/) — צור קשר
  - [/eyal-amit/mokesh-dahiman/](http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/) — מוקש דהימן — לזכרו
  - [/faq/](http://eyalamit-co-il-2026.s887.upress.link/faq/) — שאלות נפוצות
  - [/galleries/](http://eyalamit-co-il-2026.s887.upress.link/galleries/) — גלריות — קטלוג מרכזי
  - [/learning/](http://eyalamit-co-il-2026.s887.upress.link/learning/) — לימוד והכשרה
  - [/learning/lectures/](http://eyalamit-co-il-2026.s887.upress.link/learning/lectures/) — הרצאות
  - [/learning/therapist-training/](http://eyalamit-co-il-2026.s887.upress.link/learning/therapist-training/) — הכשרות למטפלים
  - [/learning/workshops/](http://eyalamit-co-il-2026.s887.upress.link/learning/workshops/) — סדנאות
  - [/lessons/](http://eyalamit-co-il-2026.s887.upress.link/lessons/) — שיעורי דיג'רידו
  - [/muzeh/](http://eyalamit-co-il-2026.s887.upress.link/muzeh/) — מוזה הוצאה לאור
  - [/muzeh/kushi-blantis/](http://eyalamit-co-il-2026.s887.upress.link/muzeh/kushi-blantis/) — כושי בלאנטיס
  - [/muzeh/tsva-bechol-ve-zorek-layam/](http://eyalamit-co-il-2026.s887.upress.link/muzeh/tsva-bechol-ve-zorek-layam/) — צבע בכחול וזרוק לים
  - [/muzza/](http://eyalamit-co-il-2026.s887.upress.link/muzza/) — מוזה הוצאה לאור
  - [/muzza/tsva-bechol-ve-zorek-layam/](http://eyalamit-co-il-2026.s887.upress.link/muzza/tsva-bechol-ve-zorek-layam/) — צבע בכחול וזרוק לים
  - [/privacy/](http://eyalamit-co-il-2026.s887.upress.link/privacy/) — מדיניות פרטיות
  - [/repair/](http://eyalamit-co-il-2026.s887.upress.link/repair/) — תיקון וחידוש דיג'רידו
  - [/services/didgeridoo-lessons/](http://eyalamit-co-il-2026.s887.upress.link/services/didgeridoo-lessons/) — שיעורי דיג'רידו / נגינה
  - [/sound-healing/](http://eyalamit-co-il-2026.s887.upress.link/sound-healing/) — סאונד הילינג
  - [/terms/](http://eyalamit-co-il-2026.s887.upress.link/terms/) — תקנון
  - [/tools-and-accessories/repair/](http://eyalamit-co-il-2026.s887.upress.link/tools-and-accessories/repair/) — תיקון וחידוש כלים
  - [/ביקורות-גולשים-אודות-עכשיו-מופע-הסיפ/](http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/) — ביקורות גולשים אודות: עכשיו!!!!! – מופע הסיפורים של אייל עמית – תופעת יחיד
  - [/דף-פייסבוק-חדש-למופע-הזמנה-לשני-המופעי/](http://eyalamit-co-il-2026.s887.upress.link/%d7%93%d7%a3-%d7%a4%d7%99%d7%99%d7%a1%d7%91%d7%95%d7%a7-%d7%97%d7%93%d7%a9-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%96%d7%9e%d7%a0%d7%94-%d7%9c%d7%a9%d7%a0%d7%99-%d7%94%d7%9e%d7%95%d7%a4%d7%a2%d7%99/) — דף פייסבוק חדש למופע + הזמנה לשני המופעים הקרובים בת"א ובפרדס חנה
  - [/כתבה-אודות-אייל-עמית-מורה-ומטפל-בדיגרי/](http://eyalamit-co-il-2026.s887.upress.link/%d7%9b%d7%aa%d7%91%d7%94-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%9e%d7%95%d7%a8%d7%94-%d7%95%d7%9e%d7%98%d7%a4%d7%9c-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99/) — שליחות חיי – כתבה אודות המרכז לטיפול בדיג'רידו פרדס חנה – אייל עמית
  - [/מופע-הסיפורים-של-אייל-עמית-כתבה-מאת-רו/](http://eyalamit-co-il-2026.s887.upress.link/%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%9b%d7%aa%d7%91%d7%94-%d7%9e%d7%90%d7%aa-%d7%a8%d7%95/) — מופע הסיפורים של אייל עמית / כתבה מאת רואי פרסול – מעריב תרבות 21.7.15
  - [/מוקש-דהימן-מאסטר-דיגרידו-ציור-מקורי-ח/](http://eyalamit-co-il-2026.s887.upress.link/%d7%9e%d7%95%d7%a7%d7%a9-%d7%93%d7%94%d7%99%d7%9e%d7%9f-%d7%9e%d7%90%d7%a1%d7%98%d7%a8-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a6%d7%99%d7%95%d7%a8-%d7%9e%d7%a7%d7%95%d7%a8%d7%99-%d7%97/) — מוקש דהימן – מאסטר דיג'רידו – ציור מקורי חדש במרכז לטיפול בדיג'רידו (שמן על קנבס)
  - [/עמית-ביָדִית-מופע-הסיפורים-של-אייל-עמי/](http://eyalamit-co-il-2026.s887.upress.link/%d7%a2%d7%9e%d7%99%d7%aa-%d7%91%d7%99%d6%b8%d7%93%d6%b4%d7%99%d7%aa-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99/) — הופעת בכורה בתל אביב!!! 3/12/13  'סרטים מהחיים' – מופע הסיפורים של אייל עמית
  - [/ריברסינג-נשימה-מעגלית-דיגרידו/](http://eyalamit-co-il-2026.s887.upress.link/%d7%a8%d7%99%d7%91%d7%a8%d7%a1%d7%99%d7%a0%d7%92-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%9e%d7%a2%d7%92%d7%9c%d7%99%d7%aa-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95/) — הכל אודות ריברסינג, נשימה מעגלית ו- דיג'רידו. האם נשימה מעגלית בדיג'רידו היא אותה נשימה מעגלית משיטת הטיפול ריברסינג? התשובה היא לא. הנה ההסבר המלא:

### 2. `.chap` — התג הקטן מעל הכותרת (eyebrow) — הממצא שגרם לדחיפה חזרה של אייל

- **What it is:** the small uppercase label above a page's H1 (e.g. "סאונד הילינג"). This is the exact element the owner's original pushback was about.
- **Style:** colour rgb(208, 138, 94), font-size 11.05px, weight 500
- **Threshold applied:** 4.5:1 (normal text)
- **Worst measured ratio:** 1.04:1 — **range across sampled pages:** 1.04–6.31:1
- **Population:** appears on **116 of the 153 published URLs**. Directly pixel-measured on 31 of them (not inferred); **29 of those 31 failed** the 4.5:1 threshold.
- **Note:** Population breakdown (exhaustive, from the 153-page crawl): of 116 pages carrying `.chap`, **64 sit over a photograph** (`.phero--media`) and **52 sit over the flat dark gradient** with no photo. The flat-gradient case is fine on its own — theoretical 5.98–7.15:1 from the token pair alone (computed from the gradient's own colour stops), confirmed by direct measurement on `/qr/` (6.31:1) and on one blog post (4.58:1). The failure concentrates entirely in the 64 photo-backed pages: terracotta lacks enough luminance range to clear 4.5:1 against either a dark crop (near the gradient's own floor) or a bright, washed-out crop (only ~3.9:1 even against a near-white patch, because the text itself is only a mid-tone colour — there is no bright enough version of this text colour to fall back on). Sampled 31 of the 116 population; 29 failed.
- **Representative URL to open:** [/contact/](http://eyalamit-co-il-2026.s887.upress.link/contact/) — צור קשר
- **Pages measured and confirmed failing (29):**
  - [/32-הטור-של-אייל-עמית-אם-אין-אני-לי-מי-לי/](http://eyalamit-co-il-2026.s887.upress.link/32-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%9d-%d7%90%d7%99%d7%9f-%d7%90%d7%a0%d7%99-%d7%9c%d7%99-%d7%9e%d7%99-%d7%9c%d7%99/) — (32) הטור של אייל עמית: אם אין אני לי – מי לי
  - [/43-הטור-של-אייל-עמית-אדון-סליחות/](http://eyalamit-co-il-2026.s887.upress.link/43-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%93%d7%95%d7%9f-%d7%a1%d7%9c%d7%99%d7%97%d7%95%d7%aa/) — (43) הטור של אייל עמית: אדון סליחות
  - [/47-הטור-של-אייל-עמית-זמן-חלום/](http://eyalamit-co-il-2026.s887.upress.link/47-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%96%d7%9e%d7%9f-%d7%97%d7%9c%d7%95%d7%9d/) — זמן חלום (וידאו בלוג) – השקת הספר 'כושי בלאנטיס' גג מסעדת הטאלי 24 רופי | אוגוסט 2004
  - [/60-הטור-של-אייל-עמית-איי-אם-בק/](http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/) — פרוייקט "מטיילים מצטלמים" עם הספרים של מוזה הוצאה לאור
  - [/about/moksha/](http://eyalamit-co-il-2026.s887.upress.link/about/moksha/) — מוקש דהימן — לזכרו
  - [/accessibility/](http://eyalamit-co-il-2026.s887.upress.link/accessibility/) — הצהרת נגישות
  - [/blog/](http://eyalamit-co-il-2026.s887.upress.link/blog/) — בלוג
  - [/contact/](http://eyalamit-co-il-2026.s887.upress.link/contact/) — צור קשר
  - [/en/](http://eyalamit-co-il-2026.s887.upress.link/en/) — English
  - [/eyal-amit/mokesh-dahiman/](http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/) — מוקש דהימן — לזכרו
  - [/galleries/](http://eyalamit-co-il-2026.s887.upress.link/galleries/) — גלריות — קטלוג מרכזי
  - [/learning/](http://eyalamit-co-il-2026.s887.upress.link/learning/) — לימוד והכשרה
  - [/learning/therapist-training/](http://eyalamit-co-il-2026.s887.upress.link/learning/therapist-training/) — הכשרות למטפלים
  - [/privacy/](http://eyalamit-co-il-2026.s887.upress.link/privacy/) — מדיניות פרטיות
  - [/sound-healing/](http://eyalamit-co-il-2026.s887.upress.link/sound-healing/) — סאונד הילינג
  - [/terms/](http://eyalamit-co-il-2026.s887.upress.link/terms/) — תקנון
  - [/testimonials/](http://eyalamit-co-il-2026.s887.upress.link/testimonials/) — המלצות — קטלוג מרכזי (ומדיה)
  - [/ביקורות-גולשים-אודות-עכשיו-מופע-הסיפ/](http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/) — ביקורות גולשים אודות: עכשיו!!!!! – מופע הסיפורים של אייל עמית – תופעת יחיד
  - [/דף-פייסבוק-חדש-למופע-הזמנה-לשני-המופעי/](http://eyalamit-co-il-2026.s887.upress.link/%d7%93%d7%a3-%d7%a4%d7%99%d7%99%d7%a1%d7%91%d7%95%d7%a7-%d7%97%d7%93%d7%a9-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%96%d7%9e%d7%a0%d7%94-%d7%9c%d7%a9%d7%a0%d7%99-%d7%94%d7%9e%d7%95%d7%a4%d7%a2%d7%99/) — דף פייסבוק חדש למופע + הזמנה לשני המופעים הקרובים בת"א ובפרדס חנה
  - [/הטור-של-אייל-עמית-איך-התחלתי-לכתוב-ולספ/](http://eyalamit-co-il-2026.s887.upress.link/%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%9a-%d7%94%d7%aa%d7%97%d7%9c%d7%aa%d7%99-%d7%9c%d7%9b%d7%aa%d7%95%d7%91-%d7%95%d7%9c%d7%a1%d7%a4/) — אקדח לתוך הראש – כתבה על אייל עמית בקול הפרדס
  - [/וסיפרתָּ-מופע-הספוקן-סטוריז-של-אייל-עמ/](http://eyalamit-co-il-2026.s887.upress.link/%d7%95%d7%a1%d7%99%d7%a4%d7%a8%d7%aa%d6%b8%d6%bc-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%a4%d7%95%d7%a7%d7%9f-%d7%a1%d7%98%d7%95%d7%a8%d7%99%d7%96-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e/) — וסיפרתָּ – מופע פרידה!!! 14.10.17 מועדון היוניקורן פרדס חנה | מופע הספוקן סטוריז של אייל עמית
  - [/טיפול-בנשימה-באמצעות-דיגרידו-ללמוד-ל/](http://eyalamit-co-il-2026.s887.upress.link/%d7%98%d7%99%d7%a4%d7%95%d7%9c-%d7%91%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%91%d7%90%d7%9e%d7%a6%d7%a2%d7%95%d7%aa-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%9c%d7%9c%d7%9e%d7%95%d7%93-%d7%9c/) — טיפול בנשימה באמצעות דיג'רידו – ללמוד לנשום נכון ביומיום וגם בלילה
  - [/כתבה-אודות-אייל-עמית-מורה-ומטפל-בדיגרי/](http://eyalamit-co-il-2026.s887.upress.link/%d7%9b%d7%aa%d7%91%d7%94-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%9e%d7%95%d7%a8%d7%94-%d7%95%d7%9e%d7%98%d7%a4%d7%9c-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99/) — שליחות חיי – כתבה אודות המרכז לטיפול בדיג'רידו פרדס חנה – אייל עמית
  - [/מופע-הסיפורים-של-אייל-עמית-כתבה-מאת-רו/](http://eyalamit-co-il-2026.s887.upress.link/%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%9b%d7%aa%d7%91%d7%94-%d7%9e%d7%90%d7%aa-%d7%a8%d7%95/) — מופע הסיפורים של אייל עמית / כתבה מאת רואי פרסול – מעריב תרבות 21.7.15
  - [/מופע-הסיפורים-של-אייל-עמית-שישי-23-10-15-בתיא/](http://eyalamit-co-il-2026.s887.upress.link/%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%a9%d7%99%d7%a9%d7%99-23-10-15-%d7%91%d7%aa%d7%99%d7%90/) — מופע הסיפורים של אייל עמית מגיע לתיאטרון הקאמרי!
  - [/מוקש-דהימן-מאסטר-דיגרידו-ציור-מקורי-ח/](http://eyalamit-co-il-2026.s887.upress.link/%d7%9e%d7%95%d7%a7%d7%a9-%d7%93%d7%94%d7%99%d7%9e%d7%9f-%d7%9e%d7%90%d7%a1%d7%98%d7%a8-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a6%d7%99%d7%95%d7%a8-%d7%9e%d7%a7%d7%95%d7%a8%d7%99-%d7%97/) — מוקש דהימן – מאסטר דיג'רידו – ציור מקורי חדש במרכז לטיפול בדיג'רידו (שמן על קנבס)
  - [/עמית-ביָדִית-מופע-הסיפורים-של-אייל-עמי/](http://eyalamit-co-il-2026.s887.upress.link/%d7%a2%d7%9e%d7%99%d7%aa-%d7%91%d7%99%d6%b8%d7%93%d6%b4%d7%99%d7%aa-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99/) — הופעת בכורה בתל אביב!!! 3/12/13  'סרטים מהחיים' – מופע הסיפורים של אייל עמית
  - [/פודקאסט-דיגרידו-ו-נשימה-אייל-עמית-2/](http://eyalamit-co-il-2026.s887.upress.link/%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-2/) — צלילים מרפאים, תדרים מרפאים, סאונד הילינג דיג'רידו – אייל עמית
  - [/ריברסינג-נשימה-מעגלית-דיגרידו/](http://eyalamit-co-il-2026.s887.upress.link/%d7%a8%d7%99%d7%91%d7%a8%d7%a1%d7%99%d7%a0%d7%92-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%9e%d7%a2%d7%92%d7%9c%d7%99%d7%aa-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95/) — הכל אודות ריברסינג, נשימה מעגלית ו- דיג'רידו. האם נשימה מעגלית בדיג'רידו היא אותה נשימה מעגלית משיטת הטיפול ריברסינג? התשובה היא לא. הנה ההסבר המלא:

### 3. `.ea-crumb` (all three segments) on `/press/` — a different, more severe bug: dark text on a dark background

- **What it is:** the entire breadcrumb trail ("בית" link, "עיתונות" current-page label, and every separator) on the single `/press/` page. This page renders on the legacy **Wave2 editorial hero** (`.ea-edhero`, `ea-blog.css:389`), not the Chapters `.phero` used by the other 99 breadcrumb-bearing pages.
- **Style:** colour rgb(47, 32, 19) (dark ink) on background rgb(46, 43, 40) (`var(--ea-ink)`, i.e. almost the identical colour) — font-size 15.30px, weight 300
- **Threshold applied:** 4.5:1 (normal text)
- **Measured ratio: 1.12:1** for all three breadcrumb pieces — the text is essentially unreadable against its own background, not merely low-contrast.
- **Population:** 1 page.
- **Root cause found in code, not just in the render:** `ea_breadcrumbs_render()` (`inc/ea-breadcrumbs.php:213`) takes a `dark` argument that switches in the `.ea-crumb--on-dark` modifier class. All three Chapters call sites pass `array('dark' => true)` (`parts/phero.php:44`, `parts/mokesh-hero.php:30`, `section-hero.php:38`). The Wave2 call site does not: **`inc/wave2-w2-07.php:940` calls `ea_breadcrumbs_render();` with no arguments**, so it silently renders the light-background variant inside a component whose own background is `var(--ea-ink)` (dark). This is why it is listed as its own row rather than folded into item 1: the fix here is a one-argument code change (`array('dark' => true)`), not a scrim/background tune.
- **Representative URL to open:** [/press/](http://eyalamit-co-il-2026.s887.upress.link/press/) — עיתונות

### 4. `.bleed__a` — שורת הייחוס מתחת לציטוט על גבי תמונה מלאה

- **What it is:** the small attribution line under a full-bleed pull-quote photo (e.g. "אייל עמית").
- **Style:** colour rgb(208, 138, 94), font-size 12.24px, weight 300
- **Threshold applied:** 4.5:1 (normal text)
- **Worst measured ratio:** 1.06:1 — **range across sampled pages:** 1.06–3.66:1
- **Population:** appears on **6 of the 153 published URLs**. Directly pixel-measured on 5 of them (not inferred); **5 of those 5 failed** the 4.5:1 threshold.
- **Note:** Same root cause and same colour token as the eyebrow — `color:var(--terra-lt)` (`chapters.css:289`) over a photo behind only a thin, one-directional scrim (`.bleed__sc`, `chapters.css:285`). Small population (6 pages total) but failed on all 5 sampled.
- **Representative URL to open:** [/services/didgeridoo-treatment-breath/](http://eyalamit-co-il-2026.s887.upress.link/services/didgeridoo-treatment-breath/) — טיפול בדיג'רידו / נשימה
- **Pages measured and confirmed failing (5):**
  - [/about/moksha/](http://eyalamit-co-il-2026.s887.upress.link/about/moksha/) — מוקש דהימן — לזכרו
  - [/bags/](http://eyalamit-co-il-2026.s887.upress.link/bags/) — תיקים לדיג'רידו
  - [/eyal-amit/mokesh-dahiman/](http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/) — מוקש דהימן — לזכרו
  - [/services/didgeridoo-treatment-breath/](http://eyalamit-co-il-2026.s887.upress.link/services/didgeridoo-treatment-breath/) — טיפול בדיג'רידו / נשימה
  - [/treatment/](http://eyalamit-co-il-2026.s887.upress.link/treatment/) — טיפול בדיג'רידו

### 5. `.ea-crumb__item` / `.ea-crumb__current` — the plain white breadcrumb text, occasional hot-spot dips

- **What it is:** the non-link breadcrumb words (e.g. "בית", "סאונד הילינג"). This is the element the owner said measures 15.91:1 on `/sound-healing/`, and **that specific claim is confirmed** — see Section 2. The finding here is narrower and about *other* pages, and other points along the *same* breadcrumb: on a minority of pages, the identical white-at-82%-opacity text lands over a brighter patch of that page's own photograph and drops below threshold.
- **Style:** colour rgba(255, 255, 255, 0.82), font-size 15.30px, weight 300
- **Threshold applied:** 4.5:1
- **Worst measured ratio:** `.ea-crumb__item` 2.38–12.63:1, `.ea-crumb__current` 2.43–12.71:1
- **Population:** breadcrumb present on 100 of 153 pages (99 on-dark over a Chapters hero, 1 on a dark-but-wrongly-light-styled Wave2 hero — item 3 above). Of the 58 on-dark pages sampled here (excluding `/press/`, tracked separately as item 3), `.ea-crumb__item` failed on 22, `.ea-crumb__current` on 20.
- **Note:** genuinely different failure mode from items 1/2/4 above. It is not the colour token — white at .82 opacity is a reasonable choice — it is that one fixed 4-stop scrim (`.phero__sc`) cannot guarantee coverage of every photograph's brightest region at every breadcrumb position. Worst points cluster where the breadcrumb sits high in the hero, where the scrim is thinnest (~0.5 opacity at its top stop), over a light sky/wall/fabric crop.
- **Representative URL to open:** [/eyal-amit/](http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/) — אייל עמית
- **Pages measured and confirmed failing on at least one segment (22):**
  - [/60-הטור-של-אייל-עמית-איי-אם-בק/](http://eyalamit-co-il-2026.s887.upress.link/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/) — פרוייקט "מטיילים מצטלמים" עם הספרים של מוזה הוצאה לאור
  - [/books/](http://eyalamit-co-il-2026.s887.upress.link/books/) — ספרים
  - [/books/kushi-blantis/](http://eyalamit-co-il-2026.s887.upress.link/books/kushi-blantis/) — כושי בלאנטיס
  - [/contact/](http://eyalamit-co-il-2026.s887.upress.link/contact/) — צור קשר
  - [/eyal-amit/](http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/) — אייל עמית
  - [/learning/therapist-training/](http://eyalamit-co-il-2026.s887.upress.link/learning/therapist-training/) — הכשרות למטפלים
  - [/learning/workshops/](http://eyalamit-co-il-2026.s887.upress.link/learning/workshops/) — סדנאות
  - [/lessons/](http://eyalamit-co-il-2026.s887.upress.link/lessons/) — שיעורי דיג'רידו
  - [/muzeh/](http://eyalamit-co-il-2026.s887.upress.link/muzeh/) — מוזה הוצאה לאור
  - [/muzeh/kushi-blantis/](http://eyalamit-co-il-2026.s887.upress.link/muzeh/kushi-blantis/) — כושי בלאנטיס
  - [/muzza/](http://eyalamit-co-il-2026.s887.upress.link/muzza/) — מוזה הוצאה לאור
  - [/repair/](http://eyalamit-co-il-2026.s887.upress.link/repair/) — תיקון וחידוש דיג'רידו
  - [/services/didgeridoo-lessons/](http://eyalamit-co-il-2026.s887.upress.link/services/didgeridoo-lessons/) — שיעורי דיג'רידו / נגינה
  - [/sound-healing/](http://eyalamit-co-il-2026.s887.upress.link/sound-healing/) — סאונד הילינג
  - [/tools-and-accessories/repair/](http://eyalamit-co-il-2026.s887.upress.link/tools-and-accessories/repair/) — תיקון וחידוש כלים
  - [/ביקורות-גולשים-אודות-עכשיו-מופע-הסיפ/](http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/) — ביקורות גולשים אודות: עכשיו!!!!! – מופע הסיפורים של אייל עמית – תופעת יחיד
  - [/דף-פייסבוק-חדש-למופע-הזמנה-לשני-המופעי/](http://eyalamit-co-il-2026.s887.upress.link/%d7%93%d7%a3-%d7%a4%d7%99%d7%99%d7%a1%d7%91%d7%95%d7%a7-%d7%97%d7%93%d7%a9-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%96%d7%9e%d7%a0%d7%94-%d7%9c%d7%a9%d7%a0%d7%99-%d7%94%d7%9e%d7%95%d7%a4%d7%a2%d7%99/) — דף פייסבוק חדש למופע + הזמנה לשני המופעים הקרובים בת"א ובפרדס חנה
  - [/הטור-של-אייל-עמית-24-ילד-אסור-ילד-מותר/](http://eyalamit-co-il-2026.s887.upress.link/%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-24-%d7%99%d7%9c%d7%93-%d7%90%d7%a1%d7%95%d7%a8-%d7%99%d7%9c%d7%93-%d7%9e%d7%95%d7%aa%d7%a8/) — (24) הטור של אייל עמית: ילד אסור ילד מותר
  - [/טיפול-בנשימה-באמצעות-דיגרידו-ללמוד-ל/](http://eyalamit-co-il-2026.s887.upress.link/%d7%98%d7%99%d7%a4%d7%95%d7%9c-%d7%91%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%91%d7%90%d7%9e%d7%a6%d7%a2%d7%95%d7%aa-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%9c%d7%9c%d7%9e%d7%95%d7%93-%d7%9c/) — טיפול בנשימה באמצעות דיג'רידו – ללמוד לנשום נכון ביומיום וגם בלילה
  - [/כתבה-אודות-אייל-עמית-מורה-ומטפל-בדיגרי/](http://eyalamit-co-il-2026.s887.upress.link/%d7%9b%d7%aa%d7%91%d7%94-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%9e%d7%95%d7%a8%d7%94-%d7%95%d7%9e%d7%98%d7%a4%d7%9c-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99/) — שליחות חיי – כתבה אודות המרכז לטיפול בדיג'רידו פרדס חנה – אייל עמית
  - [/מופע-הסיפורים-של-אייל-עמית-כתבה-מאת-רו/](http://eyalamit-co-il-2026.s887.upress.link/%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%9b%d7%aa%d7%91%d7%94-%d7%9e%d7%90%d7%aa-%d7%a8%d7%95/) — מופע הסיפורים של אייל עמית / כתבה מאת רואי פרסול – מעריב תרבות 21.7.15
  - [/עמית-ביָדִית-מופע-הסיפורים-של-אייל-עמי/](http://eyalamit-co-il-2026.s887.upress.link/%d7%a2%d7%9e%d7%99%d7%aa-%d7%91%d7%99%d6%b8%d7%93%d6%b4%d7%99%d7%aa-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99/) — הופעת בכורה בתל אביב!!! 3/12/13  'סרטים מהחיים' – מופע הסיפורים של אייל עמית

### 6. `.phero__h` — כותרת H1 בהירו הפנימי — נכשל רק בקצה של מיעוט קטן מהתמונות

- **What it is:** the page-hero H1 title (white, large text).
- **Style:** colour rgb(255, 255, 255), font-size 44.20px, weight 300
- **Threshold applied:** 3:1 (large text)
- **Worst measured ratio:** 2.02:1 — **range across sampled pages:** 2.02–18.35:1
- **Population:** appears on **149 of the 153 published URLs**. Directly pixel-measured on 60 of them (not inferred); **3 of those 60 failed** the 3:1 threshold.
- **Note:** White at full opacity, large text (44px → 3.0:1 threshold) is the right choice and clears the bar comfortably on the large majority of the 87 photo-backed pages (best observed 18.35:1). The 3 failures are pages where the worst sampled point landed on an unusually bright, thin-scrim crop.
- **Representative URL to open:** [/lessons/](http://eyalamit-co-il-2026.s887.upress.link/lessons/) — שיעורי דיג'רידו
- **Pages measured and confirmed failing (3):**
  - [/lessons/](http://eyalamit-co-il-2026.s887.upress.link/lessons/) — שיעורי דיג'רידו
  - [/services/didgeridoo-lessons/](http://eyalamit-co-il-2026.s887.upress.link/services/didgeridoo-lessons/) — שיעורי דיג'רידו / נגינה
  - [/sound-healing/](http://eyalamit-co-il-2026.s887.upress.link/sound-healing/) — סאונד הילינג

### 7. `.phero__s` — כותרת המשנה בהירו הפנימי

- **What it is:** the page-hero subtitle/lede paragraph (white at 86% opacity).
- **Style:** colour rgba(255, 255, 255, 0.86), font-size 19.55px, weight 300
- **Threshold applied:** 4.5:1 (normal text)
- **Worst measured ratio:** 3.10:1 — **range across sampled pages:** 3.10–13.81:1
- **Population:** appears on **99 of the 153 published URLs**. Directly pixel-measured on 59 of them (not inferred); **4 of those 59 failed** the 4.5:1 threshold.
- **Note:** Same pattern as the H1 above, smaller text so the stricter 4.5:1 threshold applies — fails only where the same bright-crop points are hit.
- **Representative URL to open:** [/lessons/](http://eyalamit-co-il-2026.s887.upress.link/lessons/) — שיעורי דיג'רידו
- **Pages measured and confirmed failing (4):**
  - [/lessons/](http://eyalamit-co-il-2026.s887.upress.link/lessons/) — שיעורי דיג'רידו
  - [/repair/](http://eyalamit-co-il-2026.s887.upress.link/repair/) — תיקון וחידוש דיג'רידו
  - [/services/didgeridoo-lessons/](http://eyalamit-co-il-2026.s887.upress.link/services/didgeridoo-lessons/) — שיעורי דיג'רידו / נגינה
  - [/tools-and-accessories/repair/](http://eyalamit-co-il-2026.s887.upress.link/tools-and-accessories/repair/) — תיקון וחידוש כלים

### 8. `.hero__trust` — שורת האמון מעל הכותרת בדף הבית (הירו וידאו)

- **What it is:** the small trust line above the home page's video-hero title ("אייל עמית · פועל מאז 1999 …"). Home page only — but the home page is the single most-visited URL on the site.
- **Style:** colour rgba(255, 255, 255, 0.93), font-size 13.60px, weight 500
- **Threshold applied:** 4.5:1 (normal text)
- **Worst measured ratio:** 3.15:1 — **range across sampled pages:** 3.15–3.15:1
- **Population:** appears on **1 of the 153 published URLs**. Directly pixel-measured on 1 of them (not inferred); **1 of those 1 failed** the 4.5:1 threshold.
- **Note:** The one background-video hero on the site. The worst point lands over a bright orange/yellow fruit-and-foliage frame near the top of the loop (confirmed visually with a screenshot) — no single scrim tuned for this video's average frame can guarantee the small white trust line stays legible for the whole loop. See Section 3 for the two related borderline readings on the same hero.
- **Representative URL to open:** [/](http://eyalamit-co-il-2026.s887.upress.link/) — בית
- **Pages measured and confirmed failing (1):**
  - [/](http://eyalamit-co-il-2026.s887.upress.link/) — בית

### 9. `.cmpc__p` — טקסט הגוף בכרטיס ההשוואה בדף הבית

- **What it is:** body copy inside the home page's comparison card (single instance, over a photo).
- **Style:** colour rgba(255, 255, 255, 0.85), font-size 15.30px, weight 300
- **Threshold applied:** 4.5:1 (normal text)
- **Worst measured ratio:** 4.22:1 — **range across sampled pages:** 4.22–4.22:1
- **Population:** appears on **1 of the 153 published URLs**. Directly pixel-measured on 1 of them (not inferred); **1 of those 1 failed** the 4.5:1 threshold.
- **Note:** Single instance, single page, and only just under threshold (4.22 vs 4.5). Lowest-priority item on this list by visibility — included for completeness.
- **Representative URL to open:** [/](http://eyalamit-co-il-2026.s887.upress.link/) — בית
- **Pages measured and confirmed failing (1):**
  - [/](http://eyalamit-co-il-2026.s887.upress.link/) — בית

## Section 2 — What passes (confirmed fine, please don't re-open)

Checked with the same worst-of-N, real-paint methodology as Section 1. Listed so a solved problem doesn't get re-litigated.

- **`.ea-crumb__item` / `.ea-crumb__current` on `/sound-healing/` specifically** — the exact claim under dispute. Re-measured with 15 sample points instead of one: worst-of-15 on this page is well clear of threshold, consistent with the owner's 15.91:1. **Confirmed fixed, on this page.** (The rest of the breadcrumb population is covered in Section 1 item 5, and the one page that is genuinely broken — for an unrelated reason — is Section 1 item 3.)
- **`.sec--dark .tlink`** — text link inside a full-dark section. Threshold 4.5:1, measured 5.77.
- **`.bookcard__cta`** — the "read more" affordance on a book card. Threshold 4.5:1, measured 5.94–5.95.
- **`.tmq__n`** — testimonial author name. Threshold 4.5:1, measured 5.95.
- **`.foot a`** — footer navigation links (solid `var(--dark)` background — deterministic, same value on every page). Threshold 4.5:1, measured 6.26.
- **`.toc-inline__h`** — in-page table-of-contents heading. Threshold 4.5:1, measured 6.89.
- **`.photo-band__in p`** — body copy inside the photo-band component (2 pages: `/repair/`, `/tools-and-accessories/repair/`). Threshold 4.5:1, measured 6.98.
- **`.foot__col-title`** — footer column headings. Threshold 4.5:1, measured 7.06.
- **`.foot__disc / .foot__base`** — footer disclaimer / base legal line. Threshold 4.5:1, measured 7.74.
- **`.nav__en`** — the "EN" language-switch link in the main nav. Threshold 4.5:1, measured 7.86–14.22.
- **`.cta-band__p`** — CTA band body copy. Threshold 4.5:1, measured 8.76–11.34.
- **`.cta-band__h`** — CTA band heading (large text). Threshold 3.0:1, measured 10.00–16.35.
- **`.nav__b`** — main nav links. Threshold 4.5:1, measured 10.12–19.63.
- **`.photo-band .h2`** — photo-band heading (large text). Threshold 3.0:1, measured 10.61.
- **`.sec--dark .lead`** — lede paragraph inside a full-dark section. Threshold 4.5:1, measured 12.19.
- **`.ea-faq-item__question`** — FAQ accordion question (the visible, always-shown text). Threshold 4.5:1, measured 13.11–15.66.
- **`.studio__p`** — home-page studio-section body copy. Threshold 4.5:1, measured 13.22.
- **`.dd__t`** — step-list title text. Threshold 4.5:1, measured 15.66.
- **`.bookcard__t`** — book card title. Threshold 4.5:1, measured 15.66–15.71.
- **`.ea-faq-category__heading`** — FAQ category heading. Threshold 4.5:1, measured 15.66.
- **`.sec--dark .h2`** — section heading inside a full-dark section (large text). Threshold 3.0:1, measured 17.08–17.84.
- **`.start__h`** — home-page "start" section heading (large text). Threshold 3.0:1, measured 19.56.
- **`.studio__h`** — home-page studio-section heading (large text). Threshold 3.0:1, measured 19.81.

## Section 3 — Borderline (within 1.2× the threshold; flagged, not judged)

- **`.dd__tag`** — step-number pill on the lessons step-list. Threshold 4.5:1, worst measured 4.63:1 (2 pages). Passes, but only 2.9% above the 4.5 floor. This is the pill from measurement bug 3 above; an existing in-code audit comment already on record for this pair (`chapters.css:23–28`) puts it at 4.59–5.50:1, consistent with this reading.
- **`.cmpc__t`** — home-page comparison-card heading. Threshold 4.5:1, worst measured 5.26:1 (1 page). Single instance, single page — comfortably inside the flag zone rather than a real risk.
- **`.bleed__q`** — the large pull-quote text over the same full-bleed photo as `.bleed__a` (Section 1 item 4). Threshold 3.0:1, worst measured 3.25:1 (5 pages). Large text (34px) gets the easier 3.0:1 threshold and a text-shadow the attribution line underneath doesn't have — worst page sits at 3.25:1 against the very photo where `.bleed__a` already fails outright. Best page in the same set reaches 6.96:1, confirming this is photo-dependent, not a token problem.
- **`.hero__h`** — home page video-hero H1 (large text). Threshold 3.0:1, worst measured 3.28:1 (1 page). Same video frame that fails `.hero__trust` outright (Section 1 item 8) leaves the large title only just inside its easier threshold.
- **`.hero__s`** — home page video-hero subtitle. Threshold 4.5:1, worst measured 4.71:1 (1 page). Same video-hero context as the two rows above.

All four home-page video-hero readings (`.hero__h`, `.hero__s`, `.hero__trust` in Section 1, and the borderline pass here) share one root cause: a single scrim gradient tuned for one "typical" video frame cannot guarantee coverage across a whole autoplaying loop. That is one fix surface (the scrim), not four.

## Section 4 — What could not be measured, and why

- **Book-detail single pages.** `page-templates/template-book-detail.php` exists in the theme and `.ea-book-hero__title`/`.ea-book-hero__subtitle` are defined in `ea-atoms.css`, but none of the 153 published URLs render that template or contain those classes — the six `.bookcard` teasers on `/books/`, `/muzza/`, `/muzeh/`, `/tools-and-accessories/`, `/shop/`, `/qr/` are the only live surface for book content found. Not measured because no live instance exists in the current published population.
- **Closed accordion / collapsed-state content.** `.dd__body` (the answer text under a step's `<details>`), `.rcard__more`, `.sc__more`, and the `.nav__sub` dropdown panel are all hidden (`max-height:0` / `opacity:0`) until an interaction opens them. A point-sample against a collapsed element correctly reads whatever is genuinely painted there — which is not the hidden content — so these were excluded rather than reported as a false pass or fail.
- **Hover-only content and interaction states.** `.sc__hint` (`opacity:0` until `:hover`) and `:hover`/`:focus-visible` colour variants generally (e.g. `.foot a:hover{color:#fff}`) were not sampled — the default/rest state is what a visitor sees on load, and that's what this map targets.
- **Two video-hero frames.** `/about/moksha/` and `/eyal-amit/mokesh-dahiman/` (the `.mokesh-hero` modifier) embed a YouTube trailer over the `.phero__media` still image; only the still image was sampled, not the video once playing. The home page's own background video (`.hero`) was sampled at one seeked frame (~30% into the loop) — the failing/borderline readings for that hero in Sections 1 and 3 describe that specific frame; a different point in the loop could read better or worse.
- **Mobile breakpoint CSS.** Everything above was measured at a 1440×900 desktop viewport only. The theme carries a documented sub-680px override that both shrinks `.hero__title`/`.ea-hero__title` and adds a `text-shadow` at that breakpoint specifically because of a past contrast concern (`ea-atoms.css:531`) — that override was not independently re-verified here and could shift the large/small-text threshold classification for some rows above.
- **Selectors defined in CSS with zero live matches anywhere in the 153-page population** — almost certainly the dead Wave2/Chapters code the project's own history already flags: `.mag-list__t/__p/__n`, `.fstep__t/__p/__num`, `.shstep__t/__p`, `.rcard__t/__hint`, `.cmp3__t/__p/__tag`, `.btile__t/__tag/__meta`, `.feat__t/__tag`, `.post__t/__tag`, `.videoblk__cap`, `.gfig__cap`. Not measured because there is nothing live to measure; listed so they aren't mistaken for an oversight.
- **`.dd__tag`'s real population is smaller than the class name count suggests.** It exists on 4 pages total; only 2 (`/lessons/`, `/services/didgeridoo-lessons/`) actually render the numbered pill checked in Section 3. Of the other pages carrying the related `.dd__t` step title (`/snoring-sleep-apnea/`, `/treatment/`, `/services/didgeridoo-treatment-breath/`), none use the coloured pill.

## Appendix — exhaustive population reference

From the word-boundary-matched crawl of all 153 published URLs (not the sampled subset), for reference against the sample sizes quoted in Sections 1–3:

| Element | Total pages | Photo-backed | Flat-gradient / other |
|---|---|---|---|
| `.chap` (eyebrow) | 116 | 64 | 52 |
| `.ea-crumb` (breadcrumb, either segment) | 100 | 86 | 13 dark-gradient, 1 mis-styled light (`/press/`) |
| `.phero__h` (page-hero title) | 149 | 87 | 62 |
| `.phero__s` (page-hero subtitle) | 99 | 86 | 13 |
| `.phero--media` (any photo-backed page hero) | 87 | — | — |
| `.ea-faq-item__question` | 26 | — | — |
| `.cta-band__h` | 16 | — | — |
| `.tmq__n` (testimonial name) | 9 | — | — |
| `.bleed__q` / `.bleed__a` | 6 | 6 | 0 |
| `.bookcard__t` | 6 | — | — |
| `.dd__t` | 5 | — | — |
| `.dd__tag` | 4 | — | — |
| `.sec--dark` | 4 | — | — |
| `.chap--c` (centred eyebrow variant) | 4 | — | — |
| `.photo-band` | 2 | 2 | 0 |
| `.mokesh-hero` | 2 | 2 | 0 |
| `.toc-inline` | 1 | — | — |
| `.phero--half` | 1 | — | — |
| video `.hero` / `.cmpc` (home page) | 1 | 1 | 0 |

Note on the (deliberately) uneven sample coverage: the two systemic, colour-token-driven findings (`.chap`, `.ea-crumb__link`) were sampled at roughly half their population (31/116 and 58/100) because the failure is a property of the colour-against-photo pairing, confirmed consistent across every photo-backed page tried; the near-universal elements with only edge-case failures (`.phero__h` at 60/149, `.phero__s` at 59/99) were sampled at a similar rate and show a low, stable failure rate rather than a systemic one. No conclusion above rests on a single page's photo unless the row says so explicitly.

---

*Compiled by team_90 (Validation/QA) per the R3 contrast-audit mandate. No colour tokens or typography rules were changed or recommended for change, per the locked palette/type canons (`S007-TYPOGRAPHY-CANON.md`); every direction above is either a background/scrim change or, for the one code-level bug found (Section 1 item 3), a missing function argument.*