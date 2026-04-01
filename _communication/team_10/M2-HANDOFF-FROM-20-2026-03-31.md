# M2 — קבלת סביבה מצוות 20 (G1 → G2)

**תאריך:** 2026-03-31  
**מאת:** צוות **20** (תשתית / G1)  
**אל:** צוות **10** (יישום / G2)

**סטטוס מסירה (עדכון):** ☑ גיבוי **uPress** בוצע לפני G2 (**2026-03-31**, דיווח נימרוד). ☑ **מנדט G2 הועבר לצוות 10** — הפריסה (GeneratePress, FTP child/mu-plugin), התוספים, כל עמודי §7, תפריטים, ו־`M2-IMPLEMENTATION-SUMMARY` הם **באחריות צוות 10** לפי **M2-WORKPLAN §6**; צוות 100/20 לא ממשיכים ביצוע מוצר על הסטייג'ינג.

---

## 1. סיכום למיישם

סביבת **סטייג'ינג** על **uPress** פעילה: **WordPress** עובד, **FTP** תקין, חיבור **DB** תקין אחרי סנכרון `wp-config.php`. **PHP נעול ל־8.3** (תיעוד ב־runbook §2).

**מסמך מלא (runbook):** [`../team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md)

**ארטיפקטים ב־Git לפריסה:** תחת [`site/wp-content/`](../../site/wp-content/) — child **`ea-eyalamit`** + mu-plugin **`ea-staging-noindex.php`** (ראו §5).

---

## 2. מנדט צוות 10 — מקור מחייב

המנדט המלא ל־**G2** מופיע ב־[`M2-WORKPLAN-AND-MANDATES-2026-03-30.md`](../team_100/M2-WORKPLAN-AND-MANDATES-2026-03-30.md) **§6** (משימות **10.1–10.11**), כולל **§6.2 איסורים** ו־**§6.3 קריטריוני בחירה** (תמה, SEO, טפסים).

**פלט חובה:** `_communication/team_10/M2-IMPLEMENTATION-SUMMARY-<תאריך>.md` — גרסאות **GeneratePress** + child, תוספים, טבלת עמודים מ־**§7**, תפריטים, slugs (כולל **P22**), קישורים ל־`style.css` של parent/child, סעיפים **F5/F6/F9/F10/F11/F15/F16** לפי המסמך.

**אפיון קנוני לתבנית (נעילה):**

- [`SITE-SPECIFICATION-FINAL-2026-03-30.md`](../../docs/project/team-100-preplanning/SITE-SPECIFICATION-FINAL-2026-03-30.md) **§1.2.1**
- [`SPEC-V1.2-DECISIONS-LOCK-2026-03-30.md`](../../docs/project/team-100-preplanning/SPEC-V1.2-DECISIONS-LOCK-2026-03-30.md) **§14**
- [`05-PLATFORM-DECISION.md`](../../docs/project/team-100-preplanning/05-PLATFORM-DECISION.md) **§6** (+ §3 תוספים מותרים)
- [`WP-THEME-EVALUATION-HEBREW-SEO-2026-03-29.md`](../../docs/project/team-100-preplanning/WP-THEME-EVALUATION-HEBREW-SEO-2026-03-29.md) **§5–7** (כולל צ’קליסט יישום: עברית, Lighthouse, SEO אחד, EN LTR)
- עמודים לפי אפיון: [`PAGE-SPECS-TEMPLATE.md`](../../docs/project/team-100-preplanning/PAGE-SPECS-TEMPLATE.md)

---

## 3. סדר פריסה מומלץ (אחרי גיבוי — runbook §7)

1. **גיבוי uPress** — ☑ **בוצע** (runbook §7); מזהה גיבוי בפאנל — אצל מחזיק הסודות.
2. **התקנת GeneratePress (parent)** — מממשק WP (**תבניות → הוסף חדש**) או מ־[קטלוג WordPress](https://wordpress.org/themes/generatepress/) — **לא** מהמאגר.
3. **FTP:** להעלות את תיקיית **`ea-eyalamit`** ל־`wp-content/themes/ea-eyalamit/` (מ־[`site/wp-content/themes/ea-eyalamit/`](../../site/wp-content/themes/ea-eyalamit/) במאגר).
4. **FTP:** להעלות **`ea-staging-noindex.php`** ל־`wp-content/mu-plugins/ea-staging-noindex.php`.
5. **WP Admin:** להפעיל תבנית **EA Eyal Amit** (child). לוודא ש־parent פעיל/זמין.
6. **Permalink:** לוודא **`/%postname%/`** ב־**הגדרות → קישורים קבועים** ולתעד בסיכום.
7. **noindex סטייג'ינג:** `view-source` — לוודא `noindex` / robots (mu-plugin).
8. **להמשיך לפי §6.1** — SEO אחד, טפסים, עמודים §7, תפריטים, P22, QR — כמפורט ב־M2-WORKPLAN.

**הערת 10.3 (child):** שלד ה־child **`ea-eyalamit`** כבר קיים במאגר (style + enqueue + `ea_`). **כל הרחבה** (מותג, תבניות, PHP נוסף) — **רק** בתוך ה־child; אין לערוך קבצי GeneratePress על השרת.

---

## 4. אישור קבלה (צוות 10)

**מסירה מצד 100/20:** גיבוי uPress בוצע; מנדט G2 הועבר — **2026-03-31** (דיווח נימרוד).

- [ ] קראנו את [`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md)  
- [ ] קראנו את [`M2-WORKPLAN-AND-MANDATES-2026-03-30.md`](../team_100/M2-WORKPLAN-AND-MANDATES-2026-03-30.md) §6 (מנדט G2)  
- [ ] יש לנו גישה ל־wp-admin + FTP (או מסלול deploy מתועד)  
- [ ] מתחילים G2 לפי סדר משימות §6.1 במסמך M2

**חתימה / תאריך / אחראי 10:** ___________________ _(למלא על ידי צוות 10)_

---

## 5. הערות מ־20

- **מאגר פריסה:** רק תוכן תחת [`site/`](../../site/README.md) — לא שורש המונוריפו.
- **סקריפט DB:** `scripts/ftp_sync_wp_config_db_password.py` — רק אם משנים סיסמת MySQL בפאנל; לשמור תאימות עם `staging.credentials.md`.
