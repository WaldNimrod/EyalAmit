# uPress — רישום סביבת סטייג'ינג, PHP, WordPress, ומדריך Git

**תאריך רישום:** 2026-03-31  
**בעלות עדכון:** צוות **20** (לשלב ב־`M2-RUNBOOK-ENV-<תאריך>.md`).

---

## 1. סטייג'ינג פעיל

| שדה | ערך |
|-----|-----|
| **URL בסיס** | `https://eyalamit-co-il-2026.s887.upress.link` |
| **ממשק ניהול uPress** | `my.upress.co.il` → אתר הסטייג'ינג → הגדרות / מנהל קבצים (לפי הצורך) |
| **מצב WordPress** | **הותקן** (נכון לעדכון 2026-03-31) — ראו §3 לפרמלינקים ופריסה |

צילומי מסך מהפאנל (PHP + Git): נשמרו בפרויקט Cursor לצורך הפניה (`Screenshot_2026-03-31_…`).

---

## 2. גרסאות PHP (מצולם בפאנל)

במסך **הגדרות PHP מתקדמות** הוצגו לפחות:

- **7.4** (מסומן כברירת מחדל בצילום מהאתר `eyalamit.co.il` — ייתכן שונה בסטייג'ינג)
- **8.3**
- **8.4**

**המלצת צוות 20 (טיוטה לאישור 100):**

- ל**סטייג'ינג ואתר רזה חדש:** לבחור **PHP 8.3** (איזון בין יציבות תוספים/תבניות לבין ביצועים ואבטחה). **לא** לבנות אתר חדש על **7.4** (סוף חיים; WordPress דוחף שדרוג).
- **8.4** — אפשרי אם כל התוספים והתמה מאושרים לכך אחרי בדיקה בסטייג'ינג.
- אחרי נעילה בפאנל הסטייג'ינג: לעדכן **`WORDPRESS_IMAGE`** ב־`local/.env` (למשל `wordpress:php8.3-apache`) וליישר Docker מקומי.

תיעוד רשמי: [שינוי גרסת PHP — uPress](https://support.upress.co.il/general/change-version/).

---

## 3. האם להתקין WordPress בסטייג'ינג?

**כן.** מומלץ להתקין WordPress דרך הממשק ב־uPress **לפני** פריסת תמה מ־Git/FTP:

- נוצר **מסד נתונים** ומשתמש DB (כמצופה).
- נוצר מבנה תקין: `wp-admin`, `wp-content`, `wp-includes` וכו'.
- אחרי ההתקנה: כניסה ל־`wp-admin` → **הגדרות → קישורים קבועים** → מבנה `/%postname%/` (**20.3a**).
- רק **אז** מעלים ב־**FTP/SFTP** (מסלול מועדף פשוט) את מה שצריך: **`wp-content`** (תבניות, תוספים, מדיה לפי צורך), ובהרשאות המאפשרות גם עדכונים **מחוץ ל־`wp-content` בלבד** אם נדרש (תלוי חשבון uPress).  
- **מסד נתונים:** לא דרך FTP; עדכונים דרך **ממשק WordPress**, **ייבוא SQL** מבוקר, או **phpMyAdmin** — ראו [`CREDENTIALS-HANDOFF-SECURE-2026-03-31.md`](./CREDENTIALS-HANDOFF-SECURE-2026-03-31.md).

**מסלול פריסה (החלטה):** **FTP/SFTP בלבד** — ללא Git על השרת למונוריפו המלא.

**סודות:** [`CREDENTIALS-HANDOFF-SECURE-2026-03-31.md`](./CREDENTIALS-HANDOFF-SECURE-2026-03-31.md) · תבנית שדות: [`local/staging.credentials.example.md`](../../local/staging.credentials.example.md) → העתק ל־`local/staging.credentials.md` (ב־`.gitignore`).

---

## 4. Git ב־uPress — הדרכה ברורה (איפה ומה)

**תיעוד uPress:** [קישור פרויקט Git למנהל קבצים](https://support.upress.co.il/dev/file-manager-git-project/).

### 4.1 איפה בממשק

1. היכנס ל־**uPress** → בחר את **אתר הסטייג'ינג** (`eyalamit-co-il-2026.s887.upress.link`).
2. פתח **מנהל קבצים** (File manager).
3. בסרגל הצד: **ניהול Git** — נפתח חלון "שכפול פרויקט".

### 4.2 מה לא לעשות (קריטי)

בצילום המצורף הופיע:

- קישור: `https://github.com/WaldNimrod/EyalAmit`
- נתיב: **`/`** (שורש)

**אל תלחץ "שכפול פרויקט" במצב הזה.**

סיבות:

| בעיה | הסבר |
|------|------|
| זה **לא** אתר WordPress | המאגר מכיל `docs/`, `_communication/`, `scripts/`, `.cursor/` — לא ליבת WP. |
| שורש `/` | עלול **לדרוס או לערבב** עם קבצי WordPress אחרי התקנה, או ליצור אתר שאינו WP תקין. |
| מאגר **ציבורי** | כל התוכן כבר גלוי ב-GitHub; עדיין **אין** להעלות מסמכי צוות לשרת — ושכפול לשורש האתר יוצר סיכון בלבול, נתיבים חשופים, וקבצים שלא שייכים ל־`public_html` תקין. |
| "לגסי" / הרבה תיקיות | בדיוק — הפריסה לשרת חייבת **רק** ארטיפקט WordPress (`site/wp-content` לפי מדיניות), לא המונוריפו המלא. |

**מדיניות מאושרת:** מסמכי תיעוד ותקשורת **לא** עולים לשרת — רק במאגר מקומי/Git לצוות ([`WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md`](../../docs/project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md)).

### 4.3 מסלולים תקינים עם Git

**א. מומלץ (נקי): מאגר פריסה נפרד**

1. ב-GitHub ליצור מאגר (או ענף) שבו **שורש המאגר** נראה כמו תוכן `wp-content` לפריסה, למשל:
   - `themes/ea-eyalamit/…`
   - `mu-plugins/…` (אם רלוונטי)
2. ב־uPress, אחרי התקנת WordPress: במנהל הקבצים נווט ל־**`wp-content`** (או תת־תיקייה מתאימה לפי הנחיית תמיכה uPress).
3. לחץ **שינוי** ליד "משתמש ב-Git תחת הנתיב" ובחר את התיקייה הנכונה — כך ש־**Pull** לא ימחק את `uploads` אם כבר קיימים (לתאם עם תמיכה לפני clone ראשון).
4. הזן את URL המאגר **הצר** (לא `WaldNimrod/EyalAmit` המלא) → **שכפול פרויקט**.
5. לאחר מכן: **Pull** לעדכונים; **Status** / **Log** לפי [תיעוד uPress](https://support.upress.co.il/dev/file-manager-git-project/).

**ב. בלי מאגר חדש — FTP/SFTP בלבד**

- להעלות רק את תוכן [`site/wp-content/`](../../site/README.md) (כשמתמלא) דרך FTP — בלי Git בשרת. זה תקין ופשוט.

**ג. מאגר פרטי**

- אם בעתיד המאגר לפריסה יהיה פרטי: לפי uPress נדרש **Personal Access Token** — ראו אותו עמוד תמיכה.

### 4.4 סיכום החלטה

| רוצים… | פעולה |
|--------|--------|
| פשטות מקסימלית | התקנת WP בלחיצה → **FTP** של `site/wp-content` בלבד. |
| Git על השרת | מאגר **נפרד** שמכיל רק `wp-content` לפריסה + נתיב יעד **מתחת ל־`wp-content`**, לא `/` ולא `WaldNimrod/EyalAmit` כמות שהוא. |

---

## 5. קישורים פנימיים

- צ'קליסט כללי uPress: [`UPRESS-CONNECTION-DATA-CHECKLIST-2026-03-29.md`](./UPRESS-CONNECTION-DATA-CHECKLIST-2026-03-29.md)  
- נטיב טכני: [`M2-TECHNICAL-INFRA-TRACK-NEXT-STEPS-2026-03-29.md`](./M2-TECHNICAL-INFRA-TRACK-NEXT-STEPS-2026-03-29.md)  
- מאגר צוות (לא לשכפול לשורש אתר): [github.com/WaldNimrod/EyalAmit](https://github.com/WaldNimrod/EyalAmit)
