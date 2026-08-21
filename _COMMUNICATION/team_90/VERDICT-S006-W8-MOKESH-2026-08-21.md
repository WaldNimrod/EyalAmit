VERDICT: PASS

**מאמת:** team_90 · Composer (`composer-2.5`) · 2026-08-21  
**בנאי הגל:** Cursor Grok 4.6 · Iron Rule #1 (validator ≠ builder)  
**בסיס:** `curl` · http:// בלבד · דסקטופ · סטייג'ינג חי  
**מנדט:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-W8-MOKESH-2026-08-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-W8-MOKESH-2026-08-21.md)

**HTTP:** `http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/` **200** · **81,537** bytes (לא ריק).

## בדיקות

| # | בדיקה | תוצאה | ראיה |
|---|--------|--------|------|
| **1** | בתת-הירו מופיע `Mukesh Dhiman` (שם באנגלית ליד מוקש דהימן) | **CONFIRMED** | `<p class="phero__s">מוקש דהימן (Mukesh Dhiman) היה אמן-נגר…` · JSON-LD `"alternateName":"Mukesh Dhiman"` |
| **2** | בפסקה הראשונה אחרי ההירו, המשפט שמתחיל `ומכאן, במילותיי` עטוף ב-`<strong>` | **CONFIRMED** | `<p><strong>ומכאן, במילותיי, הסיפור האישי שלי עם מוקש…</strong></p>` |
| **3** | בהירו יש `kf4NKSdYi9E` (וידאו בהתחלה, לא בתחתית אחרי הגלריה) | **CONFIRMED** | `<div class="mokesh-hero__yt">` + `<div id="ea-mokesh-trailer" data-ytid="kf4NKSdYi9E">` בתוך ההירו (לפני סוף `<section>` הראשון) · אין `iframe`/`kf4NKSdYi9E` אחרי גלריה |
| **4** | ציר «תחנות בדרכו של מוקש»: תחנה `24.3.2020` + `פורצת מגפת הקורונה`; אחרונה `11.10.2020` | **CONFIRMED** | H2 «תחנות בדרכו של מוקש» · `<span class="tl__y">24.3.2020</span><p class="tl__l">פורצת מגפת הקורונה…` · תחנה אחרונה `<span class="tl__y">11.10.2020</span>` (סדר תאריכים: 24.3.2020 → 11.10.2020) |
| **5** | בלוק הציר **אינו** `sec--dark` | **CONFIRMED** | `<section class="sec">` עוטף את הציר · `sec--dark`: 0 בהקשר הציר |
| **6** | סוף עמוד: `דברי הספד` → `מתוך הפייסבוק` → גלריה `מוקש, רישיקש והדרך` | **CONFIRMED** | H2 «דברי הספד» (61850) → H2 «מתוך הפייסבוק» (62996) → H2 «מוקש, רישיקש והדרך» (65419) |
| **7** | גלריה ≥15 תמונות תחת `chapters/mokesh-gallery/` | **CONFIRMED** | **18** נתיבי תמונה ייחודיים (`mokesh-01.jpg` … `mokesh-18.jpg`) · לא רק `assets/images/mokesh/` הישן |
| **8** | תמונות split/הירו נשארו; אין `via.placeholder`; רצועת bleed `shanti play mantra` | **CONFIRMED** | `mokesh-hero` / `mokesh-eyal.jpg` בהירו · `via.placeholder`: 0 · `<p class="bleed__q r">shanti play mantra inside – shanti coming home</p>` |

## היקף בנאי (לא נבדק כ-FAIL)

| פריט | הערה |
|------|------|
| `videoblk.php` · `block-faq-list.php` | מנדט: אסור — לא מופיעים ב-HTML (0) |
| קבצים dirty מלפני הגל | מוחרגים במנדט |

## סיכום

שמונה בדיקות החיות של גל 8 · מוקש עברו על הסטייג'ינג: שם אנגלי בתת-הירו, bold בפתיחה, וידאו YouTube בהירו, ציר זמן עם תחנת קורונה וסיום 11.10.2020 על רקע בהיר, סדר סוף-עמוד תקין, 18 תמונות גלריה חדשות, והירו/bleed ללא placeholder.
