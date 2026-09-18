Measured live on 2026-09-18 against [http://eyalamit-co-il-2026.s887.upress.link](http://eyalamit-co-il-2026.s887.upress.link). Chrome + puppeteer-core, **1440×900 asserted non-zero** before any count. Pages probed **serially** (2.5 s pause). No keyboard, no zoom, no text-size change, no scanner. All 12 pages **HTTP 200 on attempt 1**, `outerHTML` 46 628–158 867 bytes (the 150-byte trap did not fire), non-empty `<title>`, and a known element (`h1` / `main` / `.ea-skiplink`). Raw JSON: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/c1-structure-live.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/c1-structure-live.json).

Every cell below is **measured** unless marked inferred.

## Table (one row per page)

| Page | bytes / title | `<h1>` | headings (DOM `h1–h6`) | skip? | `<main>` | `<nav>` / unnamed | dup `id` | broken aria-* | `html` lang/dir | skip link in DOM |
|---|---:|---:|---|---|---:|---|---|---|---|---|
| `/` | 78 210 · בית - eyal amit | **1** | 13: H1→H2×10→H3×2 | **no** | 1 (`#main`) | 1 / **0** | none | 0 | `he-IL` / `rtl` | yes · `a.ea-skiplink` → `#main` · «דלג לתוכן» |
| `/contact/` | 50 619 · צור קשר - eyal amit | **1** | 4: H1→H2×2→H3 | **no** | 1 | 1 / **0** | none | 0 | `he-IL` / `rtl` | yes · same |
| `/treatment/` | 86 601 · טיפול בדיג'רידו… | **1** | **34**: H1→H2×11→H3×22 | **no** | 1 | 1 / **0** | none | 0 | `he-IL` / `rtl` | yes · same |
| `/accessibility/` | 51 984 · הצהרת נגישות - eyal amit | **1** | 7: H1→H2×6 | **no** | 1 | 1 / **0** | none | 0 | `he-IL` / `rtl` | yes · same |
| `/faq/` | 158 867 · שאלות נפוצות - eyal amit | **1** | **150**: H1→H2×16→H3×133 | **no** | 1 | **2** / **0** | none | 0 | `he-IL` / `rtl` | yes · same |
| `/shop/` | 50 494 · עמוד קטלוג ראשי - eyal amit | **1** | **6**: H1→H2×5 | **no** | 1 | 1 / **0** | none | 0 | `he-IL` / `rtl` | yes · same |
| `/blog/` | 66 546 · בלוג - eyal amit | **1** | 13: H1→H2×12 | **no** | 1 | **3** / **0** | none | 0 | `he-IL` / `rtl` | yes · same |
| `/en/` | 46 628 · English - eyal amit | **1** | 5: H1→H2×4 | **no** | 1 | **0** / n/a | none | 0 | **`en` / `ltr`** | yes · `a.ea-skiplink` · «Skip to content» |
| `/qr/` | 69 915 · QR - eyal amit | **1** | **49**: H1→H2×48 | **no** | 1 | 1 / **0** | none | 0 | `he-IL` / `rtl` | yes · «דלג לתוכן» |
| `/books/vekatavta/` | 89 999 · וכתבת - eyal amit | **1** | 11: H1→H2×10 | **no** | 1 | 1 / **0** | none | 0 | `he-IL` / `rtl` | yes · same |
| `/books/tsva-bekahol/` | 72 992 · צבע בכחול וזרוק לים - eyal amit | **1** | 10: H1→H2×8→H3×1 | **no** | 1 | 1 / **0** | none | 0 | `he-IL` / `rtl` | yes · same |
| `/books/kushi-blantis/` | 69 374 · כושי בלאנטיס - eyal amit | **1** | 9: H1→H2×8 | **no** | 1 | 1 / **0** | none | 0 | `he-IL` / `rtl` | yes · same |

Skip-level rule used: a heading whose level is more than one deeper than the previous heading in document order. First heading was `<h1>` on every page. No `h4–h6` on any page.

**Unnamed `<nav>`:** counted three ways because `innerText` and `textContent` disagree on the primary menu. All three are **0**.

| Page | `aria-label` (measured) | `textContent` len | `innerText` len | unnamed if `innerText` alone (no aria) | unnamed if `textContent` (no aria) | unnamed accName (`aria-label` first) |
|---|---|---:|---:|---:|---:|---:|
| Hebrew pages, `#nav.nav` | «תפריט ראשי» | 408 | 138–142 | 0 (innerText still non-empty) | 0 | 0 |
| `/faq/` 2nd `nav.ea-faq-toc` | «ניווט נושאי שאלות נפוצות» | 268 | 268 | 0 | 0 | 0 |
| `/blog/` 2nd `nav.ea-blog-filter` | «סינון לפי קטגוריה» | 140 | 140 | 0 | 0 | 0 |
| `/blog/` 3rd `nav.ea-blog-pagination` | «ניווט עמודים» | 11 | 11 | 0 | 0 | 0 |
| `/en/` | no `<nav>` | — | — | — | — | — |

The `#nav` innerText/textContent split is the closed-dropdown trap: hidden submenu copy is in `textContent` and missing from `innerText`. It does **not** produce an unnamed-nav false positive here, because `aria-label` is set **and** visible `innerText` is still non-empty. Skip-link `innerText` and `textContent` both equal the visible label (the skip is off-viewport via `position`, not `display:none`).

Broken `aria-labelledby` / `aria-controls` / `aria-describedby`: **0** tokens pointed at a missing `id` (`document.getElementById`). Duplicate non-empty `id`s: **none**. Empty `id=""`: **0**. `.ea-skip-link` (hyphenated): **absent**. One skip link per page.

## Full heading sequences (document order, measured)

**`/`**  
1 המרכז לטיפול בנשימה באמצעות דיג'רידו – שיטת cbDIDG של אייל עמית  
2 מה זה טיפול בנשימה באמצעות דיג'רידו · 2 וידאו · 2 טיפול בדיג'רידו או סאונד הילינג – מה ההבדל? · **3** טיפול בדיג'רידו · **3** סאונד הילינג · 2 למי מתאים התהליך · 2 איך מתחילים · 2 מה קורה במפגש טיפול בדיג'רידו · 2 הסטודיו והמרחב · 2 הצצה נוספת לחוויה · 2 עדויות והמלצות · 2 אייל עמית

**`/contact/`**  
1 צור קשר · 2 השאירו פנייה · 2 מעדיפים לכתוב ישירות? · 3 המרכז לטיפול בנשימה באמצעות דיג'רידו

**`/treatment/`**  
1 טיפול בדיג׳רידו · 2 משהו בנשימה שלך מבקש תשומת לב · 2 מה זה טיפול בדיג׳רידו · 2 למי זה מתאים · 2 איך עובד הטיפול בדיג׳רידו · 2 איך נראה מפגש · 2 מה ההבדל בין טיפול, סאונד הילינג ושיעורים · 2 עדויות והמלצות · 2 שאלות נפוצות · **3×22** (class `ea-faq-item__question-h`, questions listed in the JSON) · 2 מי זה אייל עמית · 2 דיסקליימר · 2 סיום והזמנה לתהליך

**`/accessibility/`**  
1 הצהרת נגישות · 2 המחויבות שלנו · 2 ההתאמות שבוצעו בפועל · 2 מגבלות ידועות · 2 וידאו ואודיו · 2 פנייה בנושא נגישות · 2 עדכון ההצהרה

**`/faq/`** — 150 headings, no skip. H2 categories in order: טיפול בדיג'רידו (22 H3) · שיעורי נגינה בדיג'רידו (8) · סאונד הילינג בדיג'רידו (8) · השיטה — cbDIDG (9) · רכישת דיג'רידו (5) · תיקים לדיג'רידו (7) · סטנדים לאחסון דיג'רידו (5) · סטנד רצפתי לנגינה (4) · תיקון וחידוש דיג'רידו (6) · שאלות כלליות (18) · וכתבת (7) · כושי בלאנטיס (6) · צבע בכחול (5) · הרצאות (6) · סדנאות דיג'רידו (11) · טיפול בנחירות ודום נשימה (6). Full H3 strings are in the JSON.

**`/shop/`**  
1 כלים בעבודת יד ואביזרים · 2 כלי דיג'רידו למכירה · 2 תיקון וחידוש כלים · 2 תיקים לדיג'רידו · 2 סטנדים לאחסון דיג'רידו · 2 סטנד רצפתי לנגינה  
(all five H2 are `h2.bookcard__t`)

**`/blog/`**  
1 בלוג · then 12 `h2.ea-blog-card__title` (post titles; full strings in the JSON)

**`/en/`**  
1 Eyal Amit · 2 Working with breath through the didgeridoo · 2 Mukesh Dahiman · 2 Ways to work together · 2 Get in touch

**`/qr/`**  
1 דפי ה-QR · then **48** `h2.bookcard__t` (qr1…qr48; full strings in the JSON)

**`/books/vekatavta/`**  
1 וכתבת · 2 תקציר הספר · 2 קטע מתוך הספר · 2 על הספר · 2 גלריה · 2 רכישת הספר · 2 למי הספר מתאים · 2 על אייל עמית · 2 שאלות ותשובות · 2 כתבות מהעיתונות · 2 עוד רגעים מהדרך

**`/books/tsva-bekahol/`**  
1 צבע בכחול וזרוק לים · 2 תקציר הספר · **3 נפגעי פסיכומטרי** · 2 על הספר · 2 גלריה · 2 רכישת הספר · 2 למי הספר מתאים · 2 על אייל עמית · 2 רוצה להתחיל כבר עכשיו? · 2 שאלות ותשובות

**`/books/kushi-blantis/`**  
1 כושי בלאנטיס · 2 תקציר הספר · 2 על הספר · 2 גלריה · 2 רכישת הספר · 2 למי הספר מתאים · 2 על אייל עמית · 2 רוצה להתחיל לקרוא כבר עכשיו? · 2 שאלות ותשובות

## Claims in the repo this measurement falsifies

I did not adopt repo numbers. These are false **on this host, this date, these 12 URLs**:

1. [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/04-DONE-HEADING-STRUCTURE.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/04-DONE-HEADING-STRUCTURE.md) §7: *«The live site is not fixed… `/shop/`, `/qr/`, `/books/`, `/treatment/` still serve the pre-fix markup (1, 1, 4, 12 headings)»*. Live now: **`/shop/` = 6, `/qr/` = 49, `/treatment/` = 34**. I did not fetch `/books/` (not in this 12).

2. Same file’s STRUCT-era baseline, and [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/A11Y-AUDIT-2026-09-17/01-STRUCTURE-SEMANTICS-AUDIT.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/A11Y-AUDIT-2026-09-17/01-STRUCTURE-SEMANTICS-AUDIT.md) **A11Y-STRUCT-02**: `/shop/` and `/qr/` have **exactly one heading**. False today. Card titles are live `<h2 class="bookcard__t">`.

3. **A11Y-STRUCT-03**: `/treatment/` has **zero H3** under «שאלות נפוצות». False today. **22** `h3.ea-faq-item__question-h` sit between that H2 and «מי זה אייל עמית».

4. STRUCT §3: `/faq/` is *H1→H2×24→H3×126*. False. Measured **16 H2 / 133 H3**. (The 16/133 figure in 04-DONE matches; the 24/126 figure does not.)

5. [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/A11Y-AUDIT-2026-09-17/04-LIVE-BROWSER-VERIFICATION.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/A11Y-AUDIT-2026-09-17/04-LIVE-BROWSER-VERIFICATION.md) home AX tree: *1×H1 → 11×H2 → 2×H3*. Live **DOM** is **10 H2**, not 11. Different method (AX vs `h1–h6`); I am not merging toward their 11.

## Claims that survived this pass (not a pass verdict)

I could not falsify: one `<h1>` per page; no heading-level skip in the DOM sequence; one `<main id="main">`; skip link present; zero duplicate ids; zero dangling aria idrefs on the three attributes named; Hebrew `lang="he-IL" dir="rtl"`; `/en/` `lang="en" dir="ltr"` and **zero** `<nav>`; `/faq/` two named navs; `/blog/` three named navs. Charter §8א: this is not evidence of correctness beyond what was counted.

## Could not measure, and why

- **Skip activation / focus movement** — out of scope by instruction.
- **Mobile viewport / a `display:none` drawer** — only 1440×900 was set. The innerText trap for a fully hidden nav was **not** exercised at 375 px.
- **`[role=heading]` that is not `h1–h6`** — not queried. Sequence is native heading tags only.
- **`/books/` hub** — not in the 12. I will not reuse team_10’s “4 headings” figure for it.
- **Accessible Name from the AX tree** — not requested; nav names are DOM attributes + contents.
- No accessibility scanner was run.
