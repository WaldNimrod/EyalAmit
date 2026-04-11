---
id: BOOKS-V2-IMPL-ENTRY-2026-04-10
title: חבילת יישום — פרק הספרים V2 | נקודת כניסה
status: ACTIVE
date: 2026-04-10
from: team_100 (אדריכל פרויקט)
to: team_10 (יישום WordPress) · team_30 (תוכן) · team_40 (מדיה)
deadline: לפגישה 2026-04-11
---

# נקודת כניסה — חבילת יישום פרק הספרים V2

## מטרה

יישום מלא של עיצוב V2 (D-EYAL-DESIGN-STYLE-13) לפרק הספרים של אייל עמית:

| עמוד | URL | מצב |
|------|-----|-----|
| מוזה הוצאה לאור (hub) | `/muzza/` | תוכן + עיצוב |
| כושי בלאנטיס | `/muzza/kushi-blantis/` | תוכן + עיצוב |
| צבע בכחול וזרוק לים | `/muzza/tsva-bechol-ve-zorek-layam/` | תוכן + עיצוב |
| וכתבת | `/muzza/vekatavt/` | תוכן + עיצוב |

**יעד:** ארבעת העמודים מוכנים, עיצוב מלא, תוכן מוזן — **לפגישה מחר (2026-04-11).**

---

## סדר קריאה מחייב

```
00-ENTRY-README.md          ← אתה כאן
01-AUDIT-GAPS.md            ← למה Wave1 פסול, מה V2 מתקן
02-CSS-V2-ANNOTATED.md      ← CSS מלא עם הסברים (team_10 + team_40)
03-PHP-CHANGES.md           ← שינויי PHP (team_10 בלבד)
04-WP-ADMIN-CONTENT-GUIDE.md← הזנת תוכן WP Admin (team_30 בלבד)
05-MEDIA-ASSETS-GUIDE.md    ← מדריך מדיה (team_40 בלבד)
06-QA-CHECKLIST.md          ← בדיקות קבלה (כולם — לבדוק בסוף)
```

**team_10:** קרא 00 → 01 → 02 → 03 → 06
**team_30:** קרא 00 → 04 → 06 (חלק תוכן)
**team_40:** קרא 00 → 05 → 06 (חלק מדיה)

---

## מפת אחריות

| מה | מי | מסמך |
|----|----|----|
| CSS + PHP + JS | team_10 | 01, 02, 03 |
| הזנת תוכן WP | team_30 | 04 |
| כריכות + גלריות | team_40 | 05 |
| QA סופי | team_10 + team_50 | 06 |

---

## קבצי קוד שהשתנו (כבר בוצע על ידי team_100)

| קובץ | שינוי |
|------|-------|
| `assets/css/books-v2.css` | **חדש** — CSS V2 מלא |
| `assets/js/books-reveal.js` | **חדש** — scroll-reveal JS |
| `functions.php` | עדכון slugs + החלפת font enqueues + rename |
| `page-templates/template-books-hub.php` | bundle section + reveal classes |
| `page-templates/template-book-detail.php` | reveal classes |

**`books-wave1.css` נשמר לגיבוי — לא למחוק.**

---

## מקורות אמת

- **עיצוב (נעול):** `_communication/team_80/D-EYAL-DESIGN-STYLE-13-DECISION-PACKAGE-2026-04-07.md`
- **HANDOFF מלא:** `_communication/team_80/HANDOFF-DESIGN-SYSTEM-TO-TEAM100-2026-04-10.md`
- **פלטת צבעים:** `docs/project/EYAL-SITE-COLOR-PALETTE.md`
- **תוכן מאושר:** `docs/project/eyal-ceo-submissions-and-responses/from-eyal/CONTENT/`

---

## הגדרת הצלחה

✅ כל 4 עמודים עם HTTP 200  
✅ אפס הפרות מ-6 כללי העיצוב הנעולים (ראה 06-QA-CHECKLIST.md)  
✅ תוכן מוזן בכל 4 עמודים  
✅ כריכות כ-Featured Image  
✅ Scroll reveal עובד  
