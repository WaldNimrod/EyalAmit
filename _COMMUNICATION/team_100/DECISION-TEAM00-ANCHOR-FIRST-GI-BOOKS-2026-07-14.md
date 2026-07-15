---
id: DECISION-TEAM00-ANCHOR-FIRST-GI-BOOKS-2026-07-14
from_team: team_100
to_team: team_00
date: 2026-07-14
type: decision-record
source: chat team_00 (Nimrod) — same day as WP-CANON package acceptance
---

# החלטת team_00 — דף עוגן מיידי + סליקת ספרים = חשבונית ירוקה בלבד

## החלטות (מחייבות)

1. **שאלה 4 (עדיפות עוגן לפני סבב QA/SEO רחב)** — לא שאלה לאייל. תשובה: **כן, מייד**. לממש דף עוגן נחירות/דום מהתוכן הקיים **ללא דיחוי**.
2. **סבב QA/SEO מהדוחות** — לא תלוי באייל; ביצוע צוותי (תור אחרי העוגן).
3. **רכישת ספרים** — קנון יחיד: כפתור חשבונית ירוקה / Morning בעמוד הספר. **אין** מנדלי, **אין** חנות אחרת, **אין** הפניה החוצה אחרת. עד URL מדויק לכל ספר — להשתמש בדוגמה המאושרת `https://mrng.to/MTUiO3vkIg` בכל העמודים (כפי שסוכם בסעיף 8 של מכתב העדכון).

## ביצוע (סשן זה)

| פריט | סטטוס |
|------|--------|
| דוח דריפט מנדלי | `_COMMUNICATION/team_100/DRIFT-REPORT-BOOK-PURCHASE-MENDELE-VS-GREEN-INVOICE-2026-07-14.md` |
| CTA ספרים + מוצרים → mrng.to דוגמה | theme defaults + `chapters-commerce.php` |
| דף `/snoring-sleep-apnea/` | defaults + route + mu-plugin seed |
| תיקון מכתב/PDF לאייל | הסרת Q4; תיקון סעיף מנדלי→GI; עדכון שדף העוגן חי |

## בעלות המשך

- **team_110 / deploy:** FTP + seed חי על סטייג'ינג (בוצע בסשן אם shell זמין).
- **team_80/90:** סבב QA/SEO מהדוחות — אחרי smoke לעוגן.
- **אייל:** תמונות מכבי/יוני, אישור יוני, ניסוח רפואי סופי, URL מדויק לכל ספר/מוצר.
