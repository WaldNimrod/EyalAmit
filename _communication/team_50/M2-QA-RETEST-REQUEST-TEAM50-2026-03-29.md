# בקשת בדיקה חוזרת (ריטסט) — צוות **50** (תשתית Q3 + G2)

**תאריך:** 2026-03-29  
**מוציא:** צוות **100** (יישום מאגר + פריסה)  
**נמען:** צוות **50** (QA)

---

## 1. סטטוס סביבה — מוכנות לריטסט

| פריט | סטטוס |
|------|--------|
| **מאגר** | עדכני; MU ב־`site/wp-content/mu-plugins/` כמתועד במנדט 100. |
| **פריסת FTP לסטייג'ינג** | **בוצעה** (`python3 scripts/ftp_deploy_site_wp_content.py`) — child `ea-eyalamit`, `ea-staging-noindex.php` **v1.0.2**, `ea-m2-ensure-fluent-active.php` **v1.0.1**, `ea-m2-seed-shell-once.php` **v1.0.4**, `ea-m2-auto-activate-child.php`. |
| **מטמון דף הבית `/`** | ייתכן **HTML ישן** בקצה (EzCache / שכבת רשת): בקשה ל־`/` ללא query עדיין עלולה להחזיר `body` מסוג `home blog`, בעוד `/?cb=<timestamp>` מחזיר נכון `page-id-16`. ב־MU v1.0.2 נוסף `DONOTCACHEPAGE` על סטייג'ינג כדי למנוע שמירת דפים חדשים במטמון מלא — **מומלץ purge חד-פעמי** בפאנל uPress אם `/` נשאר stale. |
| **דף `/contact/` (Fluent)** | MU `ea-m2-ensure-fluent-active` מפעיל את התוסף על סטייג'ינג אם היה כבוי. אם עדיין גולמי — לוודא שהתוסף **מותקן**, ושקיים טופס **id=1** ב־wp-admin (או לעדכן shortcode). |

**מסקנה:** הסביבה **מוכנה לבדיקה חוזרת** של צוות 50; יש לתעד במפורש אם נדרש purge או הפעלת תוסף כדי לסגור F1/Q2.

---

## 2. מנדט מלא וצ'קליסט

להמשיך לפי המנדט המפורט (טבלאות, פקודות, פלט צפוי):

- [`../team_100/M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md`](../team_100/M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md)

דוחות קודמים לרפרנס:

- [`M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md`](./M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md)  
- [`M2-G2-QA-RETEST-TEAM50-2026-04-02.md`](./M2-G2-QA-RETEST-TEAM50-2026-04-02.md)

---

## 3. טקסט העברה (העתקה לצוות 50)

> ריטסט תשתית Q3 + G2: פריסת FTP לסטייג'ינג **הושלמה** (2026-03-29). MU: `ea-staging-noindex` **v1.0.2** (כולל `DONOTCACHEPAGE` + `nocache_headers`), `ea-m2-seed-shell-once` **v1.0.4**.  
> **לפני סגירת בדיקות חזית:** אם `/` עדיין `home blog` — בצעו purge מטמון uPress או אמתו עם `/?cb=…`; אם `/contact/` לא מרנדר Fluent — ודאו תוסף פעיל וטופס id=1 ב־wp-admin.  
> מנדט וצ'קליסט מלאים: `_communication/team_100/M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md` ובקשה קצרה: `_communication/team_50/M2-QA-RETEST-REQUEST-TEAM50-2026-03-29.md`.

---

**חתימת מוציא (100):** 2026-03-29
