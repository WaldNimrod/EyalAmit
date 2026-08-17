VERDICT: PASS

**חוזה (קוד + מקור)**

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| Diff ממופה בלבד | **CONFIRMED** | `git diff --name-only HEAD` בערכת הנושא: רק `lessons-defaults.php` + `chapters-render.php` (שינויי `_COMMUNICATION`/`tmp` — לא FAIL לפי המנדט) |
| Provenance | **CONFIRMED** | כל 10 הסעיפים ב-`lessons-defaults.php` עם `/* S006 · מקור: content 13.8.26/שיעורי נגינה/lesons.md · SECTION … */`; FAQ הריון מתועד (LSN-09); `chapters-render.php` — R1-04 / דילוג ACF ל-`lessons` |
| התאמת מקור | **CONFIRMED** | טקסטי תוכן תואמים `lesons.md`; ניתוב `/didgeridoo-treatment` → `/treatment/` מותר במפורש (סעיף 6); הסרת פסקת «אצל אייל עמית הלימוד פרטני» — לא במקור |
| ACF skip `lessons` (C-12) | **CONFIRMED** | `'lessons'` נוסף ל-`in_array(...)` ב-`phero overlay` + `page_sections` |

**HTML חי — `<main>` בלבד** (`curl -sk`, 78190 bytes)

| # | בדיקה | תוצאה | ראיה |
|---|--------|--------|------|
| 1 | H1 + CTA הירו | **CONFIRMED** | `<h1>…שיעורי נגינה בדיג'רידו לפי שיטת cbDIDG של אייל עמית</h1>` — ללא `<em>`; `<a href="/contact/">לתיאום שיעור ראשון</a>` |
| 2 | אין פסקת SECTION 02 מומצאת | **CONFIRMED** | «אצל אייל עמית הלימוד פרטני» — לא ב-`<main>` |
| 3 | סדר כותרות S04 לפני S05 | **CONFIRMED** | h2[2]=«איך נראים השיעורים בפועל», h2[3]=«מה לומדים בפועל» |
| 4 | «למי זה מתאים» — 6 פסקאות, ללא כרטיסים | **CONFIRMED** | 0×`.rcard`/`.reveals`; 6 `<p>` מ-SECTION 06 |
| 5 | מוקש + cbDIDG | **CONFIRMED** | אין `href` ל-`/eyal-amit/mokesh-dahiman/` ב-`<main>`; «מוקש» כטקסט; `שיטת <a href="/method/">cbDIDG</a>` (S01); `שיטת <a href="/method/">שיטת cbDIDG</a>` (S07) |
| 6 | טיפול → `/treatment/` | **CONFIRMED** | אין `/didgeridoo-treatment` ב-`<main>`; `<a href="/treatment/">טיפול בדיג'רידו</a>` ×2 |
| 7 | FAQ — 8 `.ea-faq-item` | **CONFIRMED** | 8 `<details class="ea-faq-item">` בתוך `.ea-faq-list`; 13 `<details>` סה"כ (5×`.dd__item` — לא נספר); שאלות SECTION 09 בלבד |
| 8 | 9 ממליצים + FB | **CONFIRMED** | 9 שמות ייחודיים עם `facebook.com/share/…`; רותי `1E63Lr7iyJ`; אלכס פסטרנק `1PDkhtFZ4t` (קרוסלה משכפלת DOM — נספרו ייחודיים) |
| 9 | CTA סיום | **CONFIRMED** | אין h2 «בואו לנסות»; «אם זה מסקרן אותך…» + `<a href="/contact/">לתיאום שיעור ראשון</a>` |
| 10 | הריון — LSN-09 | **CONFIRMED** | «לא מומלץ» כן; אין `href` ל-`/blog/pregnancy-didgeridoo` (לא FAIL) |

**הערות מחוץ לחוזה (לא FAIL):** תמונות הירו/ספליט קיימות (LSN-01); וידאו S04 לא רונדר (LSN-02); `qa_probe` desktop — ללא overflow אופקי; קישור מוקש ב-nav גלובלי (שורה 140, מחוץ ל-`<main>`) — מחוץ להיקף סעיף 5.
