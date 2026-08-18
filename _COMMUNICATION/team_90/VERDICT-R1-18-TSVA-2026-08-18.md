VERDICT: PASS

**מנדט:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-R1-18-TSVA-2026-08-18.md`
**מאמת:** `composer-2.5` (team_90) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1
**עמוד:** http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/ · דסקטופ · `curl -sk` (66543 bytes, HTTP 200)

---

**חוזה (קוד + מקור)**

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| Diff ממופה בלבד | **CONFIRMED** | `git diff`: `tsva-bekahol-defaults.php` + `chapters-render.php` (הוספת `tsva-bekahol` ל-ACF-skip — מותר במנדט). **לא** נגעו: `muzza-defaults.php` · `videoblk.php` · `block-faq-list.php` · `tpl-chapters-page.php` |
| Provenance | **CONFIRMED** | `grep` ב-`tsva-bekahol-defaults.php`: 36 שורות `מקור:`; כל בלוקי TSV-04/05/06 מתועדים עם `content 13.8.26/צבע בכחול וזרוק לים/eyal_tsva_FINAL.md` |
| התאמת מקור | **CONFIRMED** | H1, תת-הירו, תקציר, אקורדיון «נפגעי פסיכומטרי», «על הספר», רכישה מודפסת, «למי הספר מתאים», «על אייל עמית», 5×FAQ, CTA סופי — תואמים `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/צבע בכחול וזרוק לים/eyal_tsva_FINAL.md` (מקביל לנתיב המנדט) |
| ACF skip `tsva-bekahol` | **CONFIRMED** | `chapters-render.php`: `'tsva-bekahol'` ב-`phero overlay` + `page_sections` — מותר במנדט |

**HTML חי — `<main>` בלבד** (`curl -sk`)

| # | בדיקה (מנדט) | תוצאה | ראיה |
|---|--------|--------|------|
| 1 | H1 `צבע בכחול וזרוק לים` בלי `<em>`; אין 59 ₪; אין `mrng.to` | **CONFIRMED** | `<h1 class="phero__h">צבע בכחול וזרוק לים</h1>`; `grep` `<em>` / `59` / `mrng.to` ב-`<main>` — 0 |
| 2 | רכישה מודפסת → `/contact/`; אין כפתור מנדלי | **CONFIRMED** | `<a class="tlink" href="/contact/">לרכישת עותק מודפס – צרו קשר</a>`; `grep mendele` ב-`<main>` — 0 (TSV-07 ממתין — לא FAIL) |
| 3 | בדיוק 5 FAQ inline; סדר המסמך; «להינות» / «ימכר» | **CONFIRMED** | 5×`ea-faq-item__question`: מוצ'ילרים → אמיתיות → זמן → עותקים → סגנון; תשובות כוללות «להינות» ו«ימכר» |
| 4 | אין `temp_note` / חשבונית ירוקה / `garden.jpg` | **CONFIRMED** | `grep` ב-`<main>` — 0 |
| 5 | סדר סקשנים (01→02→03→04→06→07→08→10→12) | **CONFIRMED** | הירו → תקציר → קטע (אקורדיון) → על הספר → רכישה → למי → על אייל → FAQ → CTA סופי. גלריות/עיתונות (TSV-02/03) חסרות — מותר |
| 6 | TSV-01 מדיה | **CONFIRMED (N/A לא FAIL)** | `tsva-bechol-cover.jpg` בהירו — נשמר per TSV-01 |

**`qa_probe` דסקטופ** (`qa_probe.mjs`, ללא `-fast`)

```json
{ "verdict": "PASS", "failures": 0, "results": [
  { "viewport": "desktop", "page": "_books_tsva_bekahol_", "overflow": false, "forbiddenFound": [], "pass": true }
]}
```

נתיב: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/r1-18-tsva-desktop.json`

**הערות מחוץ לחוזה (לא FAIL):** ניסוח «ניתן לרכוש את הספר בשתי גרסאות» נשאר מ-SECTION 06 אך גרסה דיגיטלית לא מרונדרת (TSV-07). סדר FAQ ב-JSON-LD Yoast שונה מהעמוד — מחוץ ל-`<main>`. TLS סטייג'ינג — צפוי.
