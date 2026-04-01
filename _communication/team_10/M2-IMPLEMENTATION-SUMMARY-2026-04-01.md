# M2 — סיכום יישום G2 (צוות 10)

**תאריך:** 2026-04-01  
**מאגר ארטיפקטים:** [`site/`](../../site/README.md)  
**מקורות מנדט:** [`M2-HANDOFF-FROM-20-2026-03-31.md`](./M2-HANDOFF-FROM-20-2026-03-31.md) · [`M2-WORKPLAN-AND-MANDATES-2026-03-30.md`](../team_100/M2-WORKPLAN-AND-MANDATES-2026-03-30.md) §6–§7  
**סטטוס G2:** **בביצוע** — ארטיפקטי Git הוכנו; **השלמת סטייג'ינג** (תמה, תוספים, ייבוא, תפריטים, אימותים) דורשת גישת wp-admin/FTP כמתועד.

---

## 1. קבלת G1 (10.1)

| בדיקה | סטטוס |
|--------|--------|
| קריאת [`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) | בוצע במסגרת מימוש מסמך זה |
| קריאת M2-WORKPLAN §6 (מנדט G2) | בוצע |
| גישה wp-admin + FTP | **לא אומת ע"י הסוכן** — אחריות מחזיק גישה (ארגון) |
| URL סטייג'ינג | `https://eyalamit-co-il-2026.s887.upress.link` (מ־runbook) |

### 1.1 בדיקת רשת (2026-04-01, ללא גישת מנהל)

- **HTTP:** 200 עם `curl -k` לדף הבית.
- **SSL:** אימות מחמיר (`curl` רגיל) נכשל ב־**תעודה שפגה** — **המלצה לצוות 20:** חידוש/יישור תעודה ב־uPress כדי ש־S3 בדוח 50 יעבור ללא `-k`.
- **תמה פעילה בפלט HTML:** עדיין **Twenty Twenty-Five** — **GeneratePress + child טרם הופעלו** על הסטייג'ינג.
- **`noindex` ב־`<head>`:** לא זוהה בדף הבית הנוכחי — צפוי **אחרי** העלאת [`site/wp-content/mu-plugins/ea-staging-noindex.php`](../../site/wp-content/mu-plugins/ea-staging-noindex.php) ואימות `view-source` (handoff §3 סעיף 7).

---

## 2. תמה (10.2, 10.3) — נעילה וגרסאות

| רכיב | גרסה / מיקום | הערות |
|------|----------------|--------|
| **GeneratePress (parent)** | *להשלים אחרי התקנה ב־wp-admin* | התקנה מ־[wordpress.org/themes/generatepress](https://wordpress.org/themes/generatepress/) או מממשק WP — **לא** מהמאגר |
| **EA Eyal Amit (child)** | **1.0.1** | [`site/wp-content/themes/ea-eyalamit/style.css`](../../site/wp-content/themes/ea-eyalamit/style.css) — `Template: generatepress` (**F6**) |
| **קישור `style.css` parent** | בשרת בלבד | אחרי התקנת GeneratePress: `{base}/wp-content/themes/generatepress/style.css` — התבנית **לא** במאגר 2026 |
| **קישור `style.css` child** | במאגר | [`site/wp-content/themes/ea-eyalamit/style.css`](../../site/wp-content/themes/ea-eyalamit/style.css) |

### 2.1 נימוק תמה (§6.3 — F5)

- **GeneratePress + child:** תמיכת **RTL** ידועה במערכת הקלאסית; תאימות **PHP 8.x**; תמה פעילה ומעודכנת; **ללא** page builder כבד; בסיס ל־**Lighthouse** על דף רזה לאחר הפעלה — **למדוד אחרי פריסה**.

### 2.2 שינויי child במסגרת G2 (מאגר)

- מחלקת גוף **`ea-lang-en`** לעמודים עם slug **`en`** או **`english`** + כללי LTR ב־CSS — עמידה ב־**EN LTR** ([`WP-THEME-EVALUATION-HEBREW-SEO-2026-03-29.md`](../../docs/project/team-100-preplanning/WP-THEME-EVALUATION-HEBREW-SEO-2026-03-29.md) §§5–7).
- enqueue נשאר תלוי ב־`generate-style` (GeneratePress).

---

## 3. תוספים (10.4–10.6)

| תפקיד | בחירה | נימוק קצר (§6.3 / F5) |
|--------|--------|-------------------------|
| **SEO (אחד)** | **Yoast SEO** | sitemap + meta, **noindex לעמוד בודד** (חובה ל־**P15**), Schema בסיסי, בשימוש נרחב בסביבה עברית |
| **טפסים (אחד)** | **Fluent Forms** | שליחה לאימייל, לוגים, honeypot מובנה, טפסים נגישים יחסית |
| **קאש** | **קאש שרת uPress בלבד** (או תוסף יחיד אם הספק מחייב) | **10.6:** לא לערבב מספר שכבות קאש |

*גרסאות מדויקות — למלא אחרי התקנה ב־wp-admin בטבלה כאן.*

**Elementor / Woo / כבדים:** לא מתוכננים ב־M2 ללא waiver מ־100 — **יעד: לא פעילים**.

---

## 4. מלאי עמודים §7 — slug יעד וייבוא

**מקור עמודים ב־Git:** ייבוא קובץ [`site/exports/m2-pages-seed.wxr`](../../site/exports/m2-pages-seed.wxr) (כלי → ייבוא → WordPress). אופציונלי: מחיקת `sample-page` לפני ייבוא כדי למנוע בלבול.  
**אחרי ייבוא:** **הגדרות → קריאה** — דף ראשי סטטי: **«בית»** (slug `home`); עמוד פוסטים: **«בלוג»** (slug `blog`).

| ID | כותרת (תצוגה) | הורה | Slug בפועל (יעד) | מזהה WP | הערות |
|----|----------------|------|-------------------|---------|--------|
| P01 | בית | — | `home` | _למלא_ | דף בית סטטי |
| P02 | השיטה | — | `hashita` | _למלא_ | |
| P03 | שירותים | — | `services` | _למלא_ | |
| P04 | שיעורי דיג'רידו / נגינה | שירותים | `didgeridoo-lessons` | _למלא_ | |
| P05 | טיפול בדיג'רידו / נשימה | שירותים | `didgeridoo-treatment-breath` | _למלא_ | |
| P06 | סאונד הילינג / מדיטציית דיג'רידו | שירותים | `sound-healing` | _למלא_ | |
| P07 | סדנאות | שירותים | `workshops` | _למלא_ | |
| P08 | תיקון וחידוש כלים | שירותים | `instrument-repair` | _למלא_ | |
| P09 | כלים בעבודת יד ואביזרים | שירותים | `handmade-instruments` | _למלא_ | placeholder מספיק |
| P10 | הרצאות | שירותים | `lectures` | _למלא_ | |
| P11 | אייל עמית | — | `eyal-amit` | _למלא_ | |
| P12 | בלוג | — | `blog` | _למלא_ | מוגדר כעמוד פוסטים |
| P13 | המלצות ומדיה | — | `testimonials-media` | _למלא_ | |
| P14 | ספרים | — | `books` | _למלא_ | |
| P15 | הכשרות למטפלים | — | `therapist-training` | _למלא_ | **F10:** `noindex` ב־Yoast עד תוכן אמיתי |
| P16 | צור קשר | — | `contact` | _למלא_ | טופס Fluent |
| P17 | הופעות / מורשת מופע | — | `shows-heritage` | _למלא_ | |
| P18 | כתבות היסטוריות | — | `historical-articles` | _למלא_ | אופציונלי |
| P19 | English | — | `en` | _למלא_ | LTR + `ea-lang-en` |
| P20 | הצהרת נגישות | — | `accessibility-statement` | _למלא_ | |
| P21 | תקנון | — | `terms` | _למלא_ | |
| P22 | עמוד קטלוג ראשי | — | **`shop`** | _למלא_ | **F16:** יעד ארכיטקטוני `/shop/` — **UNVERIFIED** מול אתר חי (runbook 20.3b) |
| P23 | מוקש דהימן — לזכרו | אייל עמית | `moked-dehiman` | _למלא_ | **F9:** נוצר ב־WXR; 301 מ־legacy במיגרציה |
| P24 | תודה | — | `thank-you` | _למלא_ | **F9:** קיים ב־WXR; אם לא בשימוש — לסמן ולא לקשר |
| — | קורסים — בקרוב (פנימי) | — | `courses-soon` | _למלא_ | **F11-b** ל־T3 עד URL סקולר |

---

## 5. תפריטים (10.8, 10.9)

**מיקום:** מראה → תפריטים — תפריט ראשי עברית + פריט ל־EN.

| מיקום | סוג | יעד מומלץ | הערה |
|-------|-----|-----------|------|
| T1 | פנימי | בית (`home`) | |
| T2 | מבנה | השיטה; שירותים + כל הילדים (P04–P10); אייל עמית (+ אופציונלי תת־פריט מוקש); בלוג; המלצות; ספרים; צור קשר | |
| T3 | פנימי (זמני) | **קורסים — בקרוב** (`courses-soon`) | **F11-b** עד קישור סקולר אמיתי מ־אייל/100 — **לא** לפרסם 404 |
| T4 | פנימי | הכשרות למטפלים | |
| T5 | פנימי | הופעות / מורשת מופע | ניווט משני |
| T6 | פנימי | English (`en`) | **10.9** |

---

## 6. סעיפי מסגרת (F5, F6, F9, F10, F11, F15, F16)

| סעיף | מימוש / סטטוס |
|------|----------------|
| **F5** | נימוקי תמה + Yoast + Fluent — ראו §§2–3 |
| **F6** | Child פעיל עם `Template: generatepress` ב־`style.css` |
| **F9** | P23 ב־WXR; P24 ב־WXR — לאשר שימוש בטפסים בשטח |
| **F10** | P15: להגדיר **noindex** ב־Yoast אחרי הייבוא |
| **F11** | T3 → `courses-soon` (פנימי) עד URL חיצוני מאושר |
| **F15** | **`GREEN_INVOICE_STATUS`:** `UNVERIFIED` — URL חשבונית ירוקה יתועד ב־M4 כשזמין |
| **F16** | **P22** נשאר **`UNVERIFIED`** מול `https://www.eyalamit.co.il/` עד אימות slug בחיים + אישור 100 אם סטייה |

---

## 7. Permalink (handoff §3.6, 20.3a)

- **יעד:** `/%postname%/`  
- **אימות:** ב־wp-admin אחרי פריסה — לרשום כאן: _למלא (צילום מילולי מספיק)_.

---

## 8. אינדקס QR (10.11)

**סטטוס:** `DEFERRED` — מדיניות [`QR-URL-POLICY.md`](../../docs/project/team-100-preplanning/QR-URL-POLICY.md): אין שינוי נתיבי QR; אינדקס ניהולי מלא יתאים ל־M3+ / כלי פנימי — **לא נחסם ע"י היעדר אינדקס ציבורי ב־M2**.

---

## 9. CHANGELOG-G3 (§2.2 — לעדכן אחרי תחילת G3)

_אין עדיין שינויים מהותיים אחרי תחילת G3._

---

## 10. סדר פריסה מומלץ (סיכום handoff §3)

1. גיבוי uPress + תיעוד ב־runbook §7.  
2. התקנת GeneratePress.  
3. FTP: `ea-eyalamit` + `ea-staging-noindex.php`.  
4. הפעלת child **EA Eyal Amit**.  
5. Permalink `/%postname%/` + תיעוד.  
6. ייבוא `m2-pages-seed.wxr` + הגדרות קריאה (בית / בלוג).  
7. התקנת **Yoast** + **Fluent Forms** + טופס בסיסי ב־צור קשר.  
8. בניית תפריטים לפי §5.  
9. `view-source` — אימות `noindex` בסטייג'ינג.  
10. מילוי עמודת **מזהה WP** בטבלה §4 בסיכום זה לאחר פריסה.

---

---

## 11. אימות 100 / 20 (מסמך מקביל)

תגובה רשמית, פערי סטייג'ינג והוראות המשך: [`../team_20/M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md`](../team_20/M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md).

---

*סוף סיכום G2 (טיוטת ביצוע 2026-04-01).*
