# M2 — Runbook סביבה (G1) — uPress סטייג'ינג

**תאריך:** 2026-03-31  
**ספק:** **uPress**  
**סביבה:** **סטייג'ינג בלבד** (לא פרודקשן חי)

---

## 1. כתובות

| סביבה | URL / הערה |
|--------|------------|
| **סטייג'ינג (בסיס)** | `https://eyalamit-co-il-2026.s887.upress.link` |
| **wp-admin** | `https://eyalamit-co-il-2026.s887.upress.link/wp-admin` |
| **פאנל uPress** | `my.upress.co.il` → אתר הסטייג'ינג |
| **אתר חי (אימות slug)** | `https://www.eyalamit.co.il/` — לאימות **P22** כשזמין |

---

## 2. PHP (**F3** / **20.7**)

בפאנל הוצגו גרסאות: **7.4**, **8.3**, **8.4**.  
**המלצה לפרויקט:** **8.3** לסטייג'ינג (ליישר מול Docker מקומי: `wordpress:php8.3-apache`).  
**נעול בפאנל (אושר):** **PHP 8.3** — **2026-03-31** (יישור מול `wordpress:php8.3-apache` ב־Docker / [`local/.env.example`](../../local/.env.example)).

---

## 3. WordPress (**20.3**)

- התקנה פעילה; חיבור DB תקין (אחרי סנכרון `wp-config.php`).
- **שפה:** עברית (RTL) — מתאים.

---

## 4. Permalink (**20.3a** / **C1**)

- **יעד:** `/%postname%/` (או שקול מתועד).
- **סטטוס:** **מדיניות M2:** `/%postname%/` — ☑ **אושר על ידי 20 (מדיניות + תיעוד)**; צוות **10** מאמת ב־**הגדרות → קישורים קבועים** בסטייג'ינג בפתיחת G2 ומתעד בסיכום יישום.

---

## 5. טבלת slugs קריטיים (**20.3b** / **C1**)

מקור ארכיטקטוני: [`M2-WORKPLAN-AND-MANDATES-2026-03-30.md`](../team_100/M2-WORKPLAN-AND-MANDATES-2026-03-30.md) §7.  
QR: [`QR-URL-INVENTORY.csv`](../../docs/project/team-100-preplanning/QR-URL-INVENTORY.csv) — הפניה בלבד.

| מזהה עמוד | תיאור | slug / נתיב יעד ארכיטקטוני | אימות מול אתר חי |
|------------|--------|----------------------------|-------------------|
| **P22** | קטלוג ראשי | **`/shop/`** (slug צפוי: `shop`) — ראו §7 במסמך M2 | **UNVERIFIED** עד אימות מול `eyalamit.co.il` חי |

---

## 6. HTTPS (**20.4**)

תעודה על דומיין הסטייג'ינג; לבדוק מנעול בדפדפן בדף הבית.

**ממצא 2026-04-01 (בדיקת רשת צוות 10):** אימות TLS מחמיר (`curl` בלי `-k`) דיווח על **תעודה שפגה** — **לטיפול צוות 20:** חידוש/יישור ב־uPress; לאחר תיקון לעדכן כאן: _תוקף תעודה אומת — תאריך _______. ראו [`M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md`](./M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md).

---

## 7. גיבוי (**20.5**, **20.5a** / **F13**)

- **uPress:** גיבוי מובנה בפאנל — לתעד לפני שינויים מהותיים של צוות 10.
- **תאריך/מזהה עדכני לפני G2:** ☑ **בוצע** — גיבוי ידני בפאנל uPress לפני העברת G2 (**דיווח נימרוד**, **2026-03-31**). **מזהה גיבוי ספציפי בפאנל** (ל־rollback) — לרשום אצל מחזיק הסודות / בפאנל; **לא** במאגר.

---

## 8. `noindex` סטייג'ינג (**20.6**)

לפי [`06-IMPLEMENTATION-MIGRATION-PACK.md`](../../docs/project/team-100-preplanning/06-IMPLEMENTATION-MIGRATION-PACK.md).  
**מימוש במאגר:** `site/wp-content/mu-plugins/ea-staging-noindex.php` — מפעיל `noindex,nofollow` דרך מסנן `wp_robots` **רק** כש־host מכיל `upress.link` (לא רץ בפרודקשן על `eyalamit.co.il`).  
**אימות:** `view-source` על דף הבית בסטייג'ינג — חיפוש `noindex` / `robots`. ☑ **מסלול mu-plugin מתועד — 10 מאמת אחרי פריסה**

---

## 9. פריסת קבצים (**20.8** / **20.9**)

| נושא | פירוט |
|------|--------|
| **FTP** | Host: `ftp.s887.upress.link`, פורט **21** (פרוטוקול FTP). **סיסמאות ומשתמשים — לא במאגר;** ראו `local/staging.credentials.md` (gitignored) אצל מחזיק הסודות. |
| **סקריפט סנכרון DB → wp-config** | `python3 scripts/ftp_sync_wp_config_db_password.py` (קורא מ־`staging.credentials.md`; תיקן באג שימוש ב־`**Password:**` FTP). |
| **Cursor / SFTP** | תוסף SFTP + `.vscode/sftp.json` (gitignored) — ראו `.cursor/skills/eyalamit-staging-ftp/SKILL.md`. |
| **מיקום קוד במאגר 2026** | [`site/README.md`](../../site/README.md) — **FTP (דוגמה):** `wp-content/themes/ea-eyalamit/` (קבצי child מהמאגר) · `wp-content/mu-plugins/ea-staging-noindex.php`. Parent **GeneratePress** — **לא** מהמאגר; התקנה מממשק WP או מ־wordpress.org ([`WP-THEME-EVALUATION`](../../docs/project/team-100-preplanning/WP-THEME-EVALUATION-HEBREW-SEO-2026-03-29.md) §7). קידומת PHP: **`ea_`**. |
| **Git על השרת** | לא משתמשים במונוריפו המלא; FTP כמסלול ראשי לסטייג'ינג. |

---

## 10. תמיכה ו־rollback (**20.11** / **F12**)

- **תמיכה:** uPress — פתיחת כרטיס דרך הפאנל / אתר התמיכה.
- **Rollback:** שחזור מגיבוי uPress + עצירה עד החלטת 100 אם G2 נכשל באמצע.

---

## 11. גישה לצוות 10 (**20.10**)

- משתמש מנהל WP ופרטי FTP — אצל מחזיק הסודות; צוות 10 מקבל גישה לפי נוהל הארגון (לא לפרסם בצ'אט).
- **קבלת מסירה:** [`../team_10/M2-HANDOFF-FROM-20-2026-03-31.md`](../team_10/M2-HANDOFF-FROM-20-2026-03-31.md) — ☑ **מנדט G2 הועבר לצוות 10** (**2026-03-31**, דיווח נימרוד); יתר הביצוע (תמה, תוספים, עמודים, סיכום M2) — **באחריות צוות 10** לפי M2-WORKPLAN §6.

---

## 12. הפניות למסמכים נלווים

- [`STAGING-CHANNEL-STATUS-2026-03-31.md`](./STAGING-CHANNEL-STATUS-2026-03-31.md)  
- [`UPRESS-STAGING-SITE-RECORD-2026-03-31.md`](./UPRESS-STAGING-SITE-RECORD-2026-03-31.md)  
- [`DB-AND-PHPMYADMIN-WORKFLOW-2026-03-31.md`](./DB-AND-PHPMYADMIN-WORKFLOW-2026-03-31.md)  
- [`M2-TECHNICAL-INFRA-TRACK-NEXT-STEPS-2026-03-29.md`](./M2-TECHNICAL-INFRA-TRACK-NEXT-STEPS-2026-03-29.md)
