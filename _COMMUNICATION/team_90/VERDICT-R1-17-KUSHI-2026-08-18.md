VERDICT: PASS

**מנדט:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-R1-17-KUSHI-2026-08-18.md`
**מאמת:** `composer-2.5` (team_90) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1
**עמוד:** http://eyalamit-co-il-2026.s887.upress.link/books/kushi-blantis/ · דסקטופ · `curl -sk` (71057 bytes, HTTP 200)

---

**חוזה (קוד + מקור)**

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| Diff ממופה בלבד | **CONFIRMED** | `git diff --name-only` בערכת נושא: `kushi-blantis-defaults.php` + `chapters-render.php` (+ גל 3 מותר: `tsva-bekahol-defaults.php` · `vekatavta-defaults.php` · `faq-defaults.php` · `snoring-sleep-apnea-defaults.php` · `inc/data/ea-faq-seed.json`). **לא** נגעו: `muzza-defaults.php` · `videoblk.php` · `block-faq-list.php` · `tpl-chapters-page.php` |
| Provenance | **CONFIRMED** | `grep`/קריאה ב-`kushi-blantis-defaults.php`: כל מחרוזות התוכן (H1, גופים, FAQ, CTA, כותרות H2) עם `/* S006 · מקור: content 13.8.26/כושי בלאנטיס/kushi_full.md · … */`. נתיבי גלריה/מדיה — הערת בלוק KSH-01/KSH-02 (שמירת קיימים עד אייל); `media_alt` — בתוך בלוק phero KSH-01 (לא מחרוזת md חדשה) |
| התאמת מקור | **CONFIRMED** | גופי 02/03/04/06/07/08/09/10/12, ניסוחי רכישה, FAQ, ו-CTA תואמים `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/כושי בלאנטיס/kushi_full.md` (spot-check + `FAQ_ORDER_MATCH True`) |
| ACF skip `kushi-blantis` | **CONFIRMED** | `chapters-render.php`: `'kushi-blantis'` (עם wave3 siblings) נוסף ל-`in_array(...)` ב-`phero overlay` + `page_sections` — מותר במנדט |

**HTML חי — `<main>` בלבד** (`curl -sk`)

| # | בדיקה (מנדט) | תוצאה | ראיה |
|---|--------|--------|------|
| 1 | H1 `כושי בלאנטיס` בלי `<em>`; אין תג `הספר`; אין 69 ₪; אין `mrng.to` | **CONFIRMED** | `<h1 class="phero__h">כושי בלאנטיס</h1>`; `H1_HAS_EM False`; `phero__chap` — 0; `69`/`mrng.to` — 0 ב-`<main>` |
| 2 | קישור מנדלי + מודפס «קישור יתווסף בהמשך» | **CONFIRMED** | `https://www.mendele.co.il/product/kushibelantis/` ×3; טקסט «קישור יתווסף בהמשך»; «לרכישה דרך מנדלי»; אין URL מודפס מומצא |
| 3 | בדיוק 6 `<details class="ea-faq-item">` (faq-inline), סדר המסמך | **CONFIRMED** | `.ea-faq-list` ×1; `ea-faq-item` ×6 (בנוסף ל-`prose-acc` ×1). סדר: סיפור אמיתי → פנטזיה → למי → 236 עמודים → כבד/קל → קשר לעבודה |
| 4 | אין `.reveals` + 9 תמונות chapters; אין `temp_note` / חשבונית ירוקה | **CONFIRMED** | `reveals` — 0; `temp_note`/`חשבונית ירוקה` — 0; `/press/` — 0 |
| 5 | KSH-01–05 מדיה/אודות | **N/A (לא FAIL)** | הירו+גלריה 5 תמונות קיימות נשמרו; «לעמוד אייל עמית» טקסט בלבד (בלי href) — KSH-05 ממתין; SECTION 11/14 לא רונדרו |

**סדר H2 ב-`<main>`:** תקציר → על הספר → גלריה → רכישה → למי → על אייל → CTA ביניים → FAQ → (CTA סופי ללא H2) — תואם סדר md (05 לפני 06; FAQ לפני 12).

**`qa_probe` דסקטופ** (`qa_probe.mjs`, ללא `-fast`)

```json
{ "verdict": "PASS", "failures": 0, "results": [
  { "viewport": "desktop", "page": "_books_kushi_blantis_", "overflow": false,
    "forbiddenFound": [], "pass": true }
]}
```

נתיב: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/r1-17-kushi/qa_probe_result.json`

**הערות מחוץ לחוזה (לא FAIL):** `chapters-render.php`/`defaults` siblings עודכנו לגל 3 (מותר). שינויי tracker — מחוץ PHP. TLS/`noindex` סטייג'ינג — צפוי. JSON-LD FAQ order ≠ DOM — מחוץ `<main>`.
