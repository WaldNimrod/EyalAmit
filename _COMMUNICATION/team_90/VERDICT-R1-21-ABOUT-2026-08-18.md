VERDICT: PASS

**מאמת:** composer-2.5 (team_90) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1  
**יעד:** http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/ · דסקטופ · ללא `?compare=eyal`  
**ראיות:** `curl -sk` (88026 bytes, HTTP 200) · `qa_probe.mjs` desktop+mobile · `git diff` · מקור md · docx `אייל_עמית_אודות_חדש_מלא_לאתר (נשמר אוטומטית).docx`

## חוזה (קוד + מקור)

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| Diff ממופה | **CONFIRMED** | `git diff --name-only HEAD` בערכת הנושא: `about-defaults.php` + `chapters-render.php` (מורשים); גם `mokesh-defaults.php` / `muzza-defaults.php` / `shop-defaults.php` — מורשים גל מקביל (מנדט) |
| Provenance | **CONFIRMED** | 32 הערות `/* S006 · מקור: … */` ב-`about-defaults.php`; גרסה א׳ → md SECTION 01–13; גרסה ב׳ → docx P010–P113; `chapters-render.php` — `about` ב-`in_array` (דילוג ACF) |
| התאמת מקור א׳ | **CONFIRMED** | טקסט גרסה א׳ תואם `אודות - אייל עמית.md` (SECTION 01–13); ניתוב ABT-06: `/books/` לא `/muzeh`, `/eyal-amit/mokesh-dahiman/` |
| התאמת מקור ב׳ | **CONFIRMED** | `משאפים` (docx P014–P018) · `עוזר נגר` (P030–P034); בלוקים P089 «למה מנועי חיפוש ומנועי AI», P143 Schema, P147 FAQPage — **לא** ב-`<main>` |

## HTML חי — `<main>` בלבד

| # | בדיקה | תוצאה | ראיה |
|---|--------|--------|------|
| 1 | תוויות גרסה א׳/ב׳ · סדר | **CONFIRMED** | `גרסה א׳ — המסמך` (ia=383) לפני `גרסה ב׳ — הצעת SEO` (ib=11469) |
| 2 | H1 גרסה א׳ = `אייל עמית` בלי `<em>` | **CONFIRMED** | `<h1 class="phero__h">אייל עמית</h1>` · 0×`<em>` לפני תווית גרסה ב׳ |
| 3 | גרסה א׳: גבעתיים / שריפה בגיל 12 / 2003 / מורים | **CONFIRMED** | `גבעתיים` · `בגיל 12`+`שריפה` · `בשנת 2003` · שבעת המורים כב-md (מוקש, יורם סיון, תמיר אלוני, טל מידן, אלה טולנאי, לילה וניגם חפר, שיר סופר) + `משנות השבעים` |
| 4 | גרסה ב׳: משאפים / עוזר נגר · בלי Schema/FAQPage/בלוק AI | **CONFIRMED** | `משאפים` · `עוזר נגר`; אין `FAQPage` · אין `הערות Schema` · אין כותרת «למה מנועי חיפוש ומנועי AI»; הערה: פסקה ויקיפדיה מ-docx P87 כוללת «מנועי חיפוש ולמנועי AI» כחלק מגוף הקורא — לא בלוק P089 המודע |
| 5 | `/muzeh` לא ב-href · `/books/` · mokesh נתיב | **CONFIRMED** | 0×`href` עם `/muzeh` ב-`<main>` · `href="/books/"` · `href="/eyal-amit/mokesh-dahiman/"` |
| 6 | ויקיפדיה טקסט בלי href מומצא · תמונות | **CONFIRMED** | 0×`href` עם `wiki` ב-`<main>`; «וויקיפדיה» כטקסט (גרסה א׳ SECTION 09, גרסה ב׳); תמונות קיימות (ABT-02) — לא FAIL |
| 7 | אין ציר זמן עם שנת 2000 | **CONFIRMED** | 0×`2000` ב-`<main>`; אין בלוק timeline/«תחנות» |

## qa_probe (דסקטופ + mobile)

| viewport | overflow | verdict |
|----------|----------|---------|
| desktop 1440 | scrollWidth=clientWidth=1440 | PASS |
| mobile 375 | scrollWidth=clientWidth=375 | PASS |

`node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /eyal-amit/` → `failures: 0`, `verdict: PASS`, ts `2026-08-18T00:08:33.995Z`

## הערות מחוץ לחוזה (לא FAIL)

- Yoast `application/ld+json` ב-`<head>` (מחוץ ל-`<main>`) — לא סעיף 4.
- קישור מוקש ב-nav גלובלי (שורה 141) — מחוץ להיקף סעיף 5 (`<main>`).
- גרסה ב׳ משתמשת ב-`<h2>` לכותרת «אייל עמית» (לא H1 שני) — תואם מבנה chapters, לא נדרש H1 כפול.
