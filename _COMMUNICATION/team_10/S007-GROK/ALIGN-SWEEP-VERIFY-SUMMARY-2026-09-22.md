---
id: ALIGN-SWEEP-VERIFY-SUMMARY-2026-09-22
schema_version: aos_v1_team_messaging
type: REPORT
from: team_10
to: [team_110, team_00]
cc: [team_100]
date: 2026-09-22
phase: verify-closed
theme_measured: 1.5.106
theme_on_main: 1.5.108
---

# Align-sweep — סיכום אימות

שתי בדיקות נפרדות, שני מנועים שאינם הבונה (Grok):

| בדיקה | מנוע | תוצאה |
|---|---|---|
| מדידה חיה CDP, 5 כתובות × 1440 ו-390 | Composer 2.5 | **9/10 PASS.** כישלון יחיד: H2 של 34px בתוך גוף הפוסט «תודה» |
| שאלה אם שתי מערכות רוחב חיות יחד | Composer 2.5, קריאה בלבד | כלוב ה-`<main>` של Wave2 **לא** חי. נשארת דליפה אחת: `.ea-related` על **960px** בפוסט בלוג |

בית `/` לא זז. L1 ו-permalink של QR לא נגענו.

## מה הוכח על הסטייג'ינג (תמה 1.5.106)

קאנון מדום נשימה: wrap **1200** / padding **48**, גוף קריאה **82ch ≈ 775.3**, הירו מלא, H1 על טוקן.

- `/2228-2/` ו-`/blog/`: `chapters-main` בלבד, בלי `ea-wave2-blog-*`.
- `/snoring-sleep-apnea/`: wrap 1200, `.intro-body` 775.3.
- `/`: wrap 1200, intro 775.3, H1 **716.5** ממורכז ב-1440.

פירוט המספרים:  
[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/EVIDENCE-COMPOSER-LIVE-VERIFY-2026-09-22.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/EVIDENCE-COMPOSER-LIVE-VERIFY-2026-09-22.md)

צילומי המסך נכתבו לתוך העץ `EyalAmit.co.il-2026-align-sweep` ואחר כך העץ חדל להיות worktree. **ה-PNG לא על הדיסק.** המספרים למעלה הם הראיה.

## שתי מערכות רוחב

[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/EVIDENCE-COMPOSER-CSS-DUAL-2026-09-22.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/EVIDENCE-COMPOSER-CSS-DUAL-2026-09-22.md)

- על כתובות Chapters שפורסמו, `<main>` הוא `chapters-main`. המחלקות `ea-wave2-blog-single` / `ea-wave2-blog-archive` נשארו רק ב-`tpl-blog-*.php`, והראוטר ב-priority 105 לא בוחר אותן.
- גוף הפוסט: `.ea-post-content` = **82ch**. 66ch לא פעיל (הערה בלבד).
- **חי על אותו פוסט:** `.ea-related { max-width: var(--ea-prose-width) }` = **960px**, בזמן שהגוף הוא 82ch בתוך wrap של 1200.
- בשאר הגיליונות `--ea-prose-width: 960` ו-65ch נשארים בקוד Wave2 (חנות, שירות, 14e, אטומים). הם לא חלים על מרקאפ Chapters אלא אם מישהו מחזיר את המחלקות.

## המלצות — לא מומש

1. ב-wp-admin, להסיר את ה-H2 המוטמע (34px) בפוסט «תודה» (`/100-100-100-toda/`). זה תוכן, לא CSS של התמה.
2. להוריד את `max-width: var(--ea-prose-width)` מ-`.ea-related` בפוסט Chapters, כדי שהרשת תשב על ה-wrap של 1200.
3. לפצל את מקבץ ה-editorial מתוך `ea-blog.css` לגיליון שנטען רק על `tpl-content.php`.
4. בדיקת CI: `tpl-chapters-*.php` נכשל אם `<main>` מכיל `ea-wave2-blog-single` או `ea-wave2-blog-archive`.
5. לא לגעת בבית `/`, לא ב-FAQ ‎820px, לא ב-60ch של לידים — אלה לא חלק מהסוויפ.
6. אם צריך פיקסלים לתיק: לצלם מחדש תחת עץ יציב. העץ `align-sweep` לא שמיש (`git checkout` שם נכשל: אין `.git`).

## ארטיפקטים

| מה | נתיב |
|---|---|
| הדוח הזה | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-VERIFY-SUMMARY-2026-09-22.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-VERIFY-SUMMARY-2026-09-22.md) |
| מדידה חיה | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/EVIDENCE-COMPOSER-LIVE-VERIFY-2026-09-22.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/EVIDENCE-COMPOSER-LIVE-VERIFY-2026-09-22.md) |
| שתי מערכות רוחב | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/EVIDENCE-COMPOSER-CSS-DUAL-2026-09-22.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/EVIDENCE-COMPOSER-CSS-DUAL-2026-09-22.md) |
| DONE מימוש | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-DONE-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-DONE-2026-09-21.md) |
| מפה | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-MAP-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-MAP-2026-09-21.md) |
| תבניות | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-PATTERNS-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-PATTERNS-2026-09-21.md) |
| ולידציה (gpt-5.2) | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-PATTERNS-VALIDATE-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-PATTERNS-VALIDATE-2026-09-21.md) |

פינג: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/TO-TEAM110-ALIGN-SWEEP-VERIFY-2026-09-22.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/TO-TEAM110-ALIGN-SWEEP-VERIFY-2026-09-22.md)
