VERDICT: PASS

**מנדט:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-R1-22-MOKESH-2026-08-18.md`  
**מאמת:** team_90 · composer-2.5 · **בנאי:** Cursor Grok 4.6 · Iron Rule #1  
**חי:** http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ · HTTP **200** (`curl -sk`, 2026-08-18)  
**מקור SSOT:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/מוקש - דף הנחצחה לזרכו ופועלו/מוקש - דף הנצחה לזיכרו ופועלו.docx`  
**ראיות:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/r1-22-mokesh-2026-08-18/`

---

## חוזה (קוד + מקור)

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| Diff ממופה בלבד | **CONFIRMED** | `git diff --name-only HEAD` בערכת הנושא: `mokesh-defaults.php` + `chapters-render.php` בלבד; **לא** `tpl-chapters-mokesh.php` |
| Provenance MK-01 | **CONFIRMED** | 19 הערות `/* S006 R1-22 MK-01 · מקור: content 13.8.26/…/מוקש - דף הנצחה לזיכרו ופועלו.docx · … */` ב-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/mokesh-defaults.php` |
| ACF skip `mokesh` | **CONFIRMED** | `'mokesh'` ב-`in_array(...)` ב-`ea_chapters_phero_overlay()` + `ea_chapters_page_sections()` — `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` שורות 603, 645 |
| התאמת מקור (10 כותרות + בייטים) | **CONFIRMED** | `textutil -convert txt -stdout` מה-docx: 10 כותרות תואמות; `(jungle vibes)` + `jungel vibes` ב-docx וב-`<main>`; **אין** `Jungle Vibes` ב-docx וב-`<main>` |
| href rId4/rId5 | **CONFIRMED** | ב-`<main>`: `https://www.gofundme.com/f/Roof-For-Mukesh` · `https://www.facebook.com/mukesh.the.art.of.shanti.living.the.movie` |

---

## HTML חי — `<main>` בלבד (`curl -sk`, 49139 bytes → `main.html`)

| # | בדיקה | תוצאה | ראיה |
|---|--------|--------|------|
| 1 | H1 = `מי היה מוקש דהימן?` בלי `<em>` | **CONFIRMED** | `<h1 class="phero__h">מי היה מוקש דהימן?</h1>` — אין `<em>` |
| 2 | אין תג `1950–2020` / `לזכרו · 1950` | **CONFIRMED** | `1950–2020`, `לזכרו · 1950`, `phero__chap` — **לא** ב-`<main>` (קיימים ב-meta/JSON-LD מחוץ ל-`<main>` — מחוץ להיקף סעיף 1) |
| 3 | כותרות המסמך בסדר | **CONFIRMED** | h2[0–11]: היכרותו הראשונה → בית המלאכה → Dream Time → קוטלי → (extras) → הגשמת החלום → (extra) → תפנית חדה → פרידה → ומה היום → (extra) → דברי הספד |
| 4 | אין H2 ממציא | **CONFIRMED** | `צינור האום` · `שפת הלב` · `תם עידן` — בפרוזה בלבד, **לא** כ-H2 |
| 5 | `(jungle vibes)` / `jungel vibes` ככתבם | **CONFIRMED** | שני המופעים ב-`<main>`; `Jungle Vibes` — absent |
| 6 | href Gofundme + Facebook סרט | **CONFIRMED** | `Roof-For-Mukesh` · `mukesh.the.art.of.shanti.living.the.movie` |
| 7 | תת-הירו = פסקה 002 docx | **CONFIRMED** | `<p class="phero__s">מוקש דהימן היה אמן-נגר, בונה דיג'רידו…` — תואם שורה 2 ב-docx |

**H2 נוספים (MK-02…07 — לא FAIL לפי מנדט):** `תחנות בדרכו של מוקש` (timeline) · `מוקש, רישיקש והדרך` (gallery 19) · `מתוך הפייסבוק` (fbembeds).

---

## qa_probe (desktop + mobile)

```json
"verdict": "PASS"
```

| viewport | overflow | forbidden `Jungle Vibes` | pass |
|----------|----------|--------------------------|------|
| desktop 1440×900 | false | [] | true |
| mobile 375×812 | false | [] | true |

פלט מלא: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/r1-22-mokesh-2026-08-18/qa_probe_result.json`

---

## הערות מחוץ לחוזה (לא FAIL)

- **yt_id** `kf4NKSdYi9E` בהירו, **bleed**, **gallery 19**, **4 fbembeds**, **timeline** — נשמרו (MK-02…07; ממתין לאייל/נימרוד).
- **1950–2020** ב-`<title>`, meta description, Yoast JSON-LD — מחוץ ל-`<main>`; לא נכלל בסעיף 1 המנדט.
- **`Jungle Vibes`** ב-schema.org `affiliation` (JSON-LD) — מחוץ ל-`<main>`; qa_probe `--absent "Jungle Vibes"` על DOM רendered — PASS.

---

## סיכום

חוזה MK-01 (הדבקת 10 כותרות + גוף, H1 בלי em, בלי תג 1950 ב-`<main>`, בלי H2 ממציא, jungle/jungel ככתבם, שני href) — **עומד**. ACF skip + provenance — **עומד**. qa_probe desktop — **PASS**.
