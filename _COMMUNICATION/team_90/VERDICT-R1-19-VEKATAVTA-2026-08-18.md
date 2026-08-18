VERDICT: PASS

**מנדט:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-R1-19-VEKATAVTA-2026-08-18.md`
**מאמת:** `composer-2.5` (team_90) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1
**עמוד:** http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ · דסקטופ · `curl -sk` (72301 bytes, HTTP 200)

---

**חוזה (קוד + מקור)**

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| Diff ממופה בלבד | **CONFIRMED** | `git diff --name-only`: `vekatavta-defaults.php` · `chapters-render.php` (+ גל 3 מותר: `kushi-blantis-defaults.php` · `tsva-bekahol-defaults.php` · `faq-defaults.php` · `snoring-sleep-apnea-defaults.php` · `ea-faq-seed.json` · `scripts/ftp_deploy_site_wp_content.py`). **לא** נגעו: `muzza-defaults.php` · `videoblk.php` · `block-faq-list.php` · `tpl-chapters-page.php` |
| Provenance | **CONFIRMED** | `vekatavta-defaults.php`: 60 הערות `מקור:`; סריקה אוטומטית — 0 מחרוזות תוכן ללא הערת מקור בשלוש השורות שמעליהן |
| התאמת מקור | **CONFIRMED** | גופי VKT-03/04/05, כתיב `היקוקומורי`/`היקוקמורי`, CTA מנדלה, 7 FAQ, וסדר סקשנים תואמים `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/וכתבת/vekatavta.md` |
| ACF skip `vekatavta` | **CONFIRMED** | `chapters-render.php`: `'vekatavta'` (עם `kushi-blantis` · `tsva-bekahol` · `faq` · `snoring-sleep-apnea`) נוסף ל-`in_array(...)` ב-`phero overlay` + `page_sections` — מותר במנדט |

**HTML חי — `<main>` בלבד** (`curl -sk`)

| # | בדיקה (מנדט) | תוצאה | ראיה |
|---|--------|--------|------|
| 1 | H1 `וכתבת` בלי `<em>`; אין `79 ₪`; אין `mrng.to` | **CONFIRMED** | `<h1>…וכתבת</h1>` ללא `<em>`; `grep` `79 ₪` / `mrng.to` — 0 |
| 2 | `https://www.mendele.co.il/product/vekatavta/` מופיע; כתיב `היקוקומורי`/`היקוקמורי` (לא `היקיקומורי`) | **CONFIRMED** | `mendele.co.il/product/vekatavta` ×4; `היקוקומורי` ×5 · `היקוקמורי` ×1; `היקיקומורי` — 0 |
| 3 | בדיוק 7 FAQ inline בסדר המסמך | **CONFIRMED** | `<details>` ×7: «האם צריך לקרוא…» → «יש גם תוכן נוסף…» — תואם SECTION 10 שורות 281–300 |
| 4 | אין `temp_note` / חשבונית ירוקה | **CONFIRMED** | `grep` — 0 לשניהם |
| 5 | VKT-01/02 מדיה ממתינים | **N/A (לא FAIL)** | כריכת הירו קיימת; גלריה = פרוזה טקסט בלבד (SECTION 05) — לפי מנדט |

**סדר H2 (דסקטופ):** תקציר הספר → קטע מתוך הספר → על הספר → גלריה → רכישת הספר → למי הספר מתאים → על אייל עמית (בהקשר הספר) → שאלות ותשובות → כתבות מהעיתונות → עוד רגעים מהדרך. סקשנים 09/12 ללא H2 (כמסמך). אין `reveals` · `collapsible` · `faqblock` · `pending-approval` · `/press/`.

**`qa_probe` דסקטופ** (`qa_probe.mjs`, ללא `-fast`)

```json
{ "verdict": "PASS", "failures": 0, "results": [
  { "viewport": "desktop", "page": "_books_vekatavta_", "url": "/books/vekatavta/", "overflow": false, "forbiddenFound": [], "pass": true }
]}
```

נתיב: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/r1-19-vekatavta/qa_probe_result.json/qa_probe_result.json` · `ts`: 2026-08-18T12:09:10.244Z

**הערות מחוץ לחוזה (לא FAIL):** שינויי גל 3 באחים (`kushi`/`tsva`/`faq`/`snoring`) ו-`ea-faq-seed.json` — מותר במנדט. `qa_probe` רץ גם מובייל (מחוץ להיקף מנדט). TLS סטייג'ינג — צפוי.
