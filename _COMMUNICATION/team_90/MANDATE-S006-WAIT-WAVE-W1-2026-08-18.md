# MANDATE — team_90 · Composer · S006 WAIT-WAVE W1 · היגיינה + FTP glob

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
דסקטופ. `curl -sk` לסטייג'ינג. פלט ריק = FAIL. `-fast` אסור. **אל תשנה קבצים** מלבד קובץ הפסק שלך.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`

כתוב אל: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-WAIT-WAVE-W1-2026-08-18.md`

## חוזה (שלושתם חייבים CONFIRMED)

1. **אין חבילת קורסים בדרייב.** ב-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content%2013.8.26/` אין תיקייה ששמה מכיל «קורס» / `course`. רשימת 20 התיקיות הקיימות = ראיה. סיבת הקפאת R1-29 חייבת להתאים: אין מקור, התפריט `#`, לא הומצא יעד. R2-007 `/learning/courses-external/` נשאר סבב 2.

2. **סבב 1 במכונה: 21 הוגש + 8 הוקפא + 0 טרם-נבדק.** גזרו מ-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/latest.csv` (שורות `סבב-1-ליבה` בלבד). שמונת המוקפאים חייבים לכלול R1-06/07/08/09/20/24/27/**29**. Hub חי: `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s006-review.html` מציג `מוקפאים (8)` ואת המילה «קורסים».

3. **glob FTP = דיסק.** הריצו `python3 scripts/ftp_deploy_site_wp_content.py --dry-run` משורש הריפו. ודאו: כל `site/wp-content/mu-plugins/*.php` מופיע בשורת upload **או** ב-`MU_PLUGIN_DENYLIST` עם סיבה. יעד: `40 upload · 0 denylist · 0 orphan`. אל תריצו העלאה חיה.

## אסור לפסול בגלל

- C-07 / C-08 פתוחים אצל אייל/נימרוד (לא בוצעו בגל).
- C-01 חלקי (`whom_items[].text` עדיין `esc_html`).
- ציוני Lighthouse / מובייל / `chapters.css`.
- תאריך עוגן Hub `2026-07-25`.

## פלט

טבלה: בדיקה · סיווג · תוצאה · ראיה (פקודה + פלט קצר או נתיב `file://`).
אל תשנה PHP, טרקר, או Hub.
