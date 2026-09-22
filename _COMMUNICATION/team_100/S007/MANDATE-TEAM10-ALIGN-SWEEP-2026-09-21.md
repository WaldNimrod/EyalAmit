---
id: MANDATE_TEAM10_ALIGN_SWEEP_2026-09-21
schema_version: aos_v1_team_messaging
type: MANDATE (team_100 → team_10)
from: team_100
to: team_10
cc: [team_00]
date: 2026-09-21
status: DISPATCHED
---

# מנדט — מיפוי יישור לכל האתר, דפוסים, ולידציה, מימוש

**עמוד הבית `/` מוחרג. לא נוגעים בו. יטופל בנפרד.**

קאנון היישור נעול על `/snoring-sleep-apnea/` (מדידה חיה 1440, שני מנועים):

| שכבה | מספר |
|---|---|
| `.wrap` | 1200px, `padding-inline: 48px` |
| גוף קריאה `.intro-body` | **82ch = 775.3px** ממורכז בתוך ה-wrap |
| H2 על ה-wrap | 1104px, `text-align: start`, הסטה 164.4px מול הגוף |
| `--sec` | 88px@1440 / 40px@390 |
| split | 516/516 — אטום שני **חוקי**, לא חריגה |
| הירו פנימי | `.phero` פס מלא; H1 32ch start |

טיפוגרפיה: [S007-TYPOGRAPHY-CANON.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md). לשנות מידה = לשנות טוקן. אסור `font-size` על רכיב.

## השערת team_00 (מחייבת לבדיקה, לא לניחוש)

הסטייה העיקרית היא **שתי מערכות רוחב על אותו עמוד**: כרום Chapters + מחלקת Wave2 ש**פורשת** `max-width` על `main` וכולאת גם את ההירו.

הוכחה חלקית כבר חיה על פוסט `/2228-2/`:

```
main.chapters-main.ea-wave2-blog-single
  computed max-width: 960px   ← .ea-wave2-blog-single { max-width: var(--ea-prose-width) }
.wrap                         ← רוצה 1200, מקבל 896 כי הכלוא ב-960
.ea-post-content              ← 66ch / 624px
```

מקור: `tpl-chapters-blog-single.php` שורה 25 + `ea-blog.css` `.ea-wave2-blog-single`.  
ארכיון: `tpl-chapters-blog-archive.php` — `chapters-main ea-wave2-blog-archive`.  
עיתונות: `tpl-content.php` — `ea-wave2-editorial` בלי Chapters wrap.

**סדר תיקון לדפוס כזה (אחרי הוכחה):**

1. **להוכיח** איזו מחלקה פורשת את הכלוב — CDP: למדוד → `classList.remove` של המועמדת → למדוד שוב. אם wrap/phero קופצים למספרי דום נשימה בלי ריענון CSS, זו המחלקה.
2. **לתקן CSS** של מערכת Chapters (wrap / 82ch / H2 על ה-wrap / `--sec`). לא להוסיף כלובי max-width חדשים.
3. **למחוק את המחלקה הכפולה** מה-HTML (`ea-wave2-blog-single` על `main` וכו') ואת כללי הרוחב שלה אם אין צרכן חי.
4. **להוכיח אחרי:** אותם מספרים כמו דום נשימה; המחלקה שנמחקה לא מופיעה ב-DOM; אין רגרסיית overflow ב-390/1440.

אסור «לתקן» בהוספת מעטפת שלישית מעל שתיהן.

## מה לא

- `/` עמוד הבית — חרג. אפס עריכה ל-`section-home-*`, `tpl-chapters-home.php`, הירו בית.
- L1 / `ea_canonical_nav.php` — T-NAV-HOLD / M1.
- permalink QR `/qr/qrN/`.
- נוסח מומצא. `_aos/`. `local/`. `git add -A`.
- סקיצה חדשה לדפוס ויזואלי **חדש**. יישור לקאנון דום נשימה + מחיקת כלובי Wave2 = יישום קאנון נעול, לא המצאה.

## סדר עבודה

1. מיפוי כל URL במפת 157 **חוץ מ-`/`**.
2. רשימת משימות לפי דפוסים (לא לפי 157 שורות כפולות).
3. ולידציה חוצת מנועים על **הרשימה** (בונה ≠ מאמת) עד PASS.
4. מימוש רק מה שעבר.
5. דוח מסכם לצוות 100.

פרומט להדבקה: [PROMPT-TEAM10-ALIGN-SWEEP-PARALLEL-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/PROMPT-TEAM10-ALIGN-SWEEP-PARALLEL-2026-09-21.md)
