# M2 — תפריט ראשי נעול מול `site-tree.json` (מקור אמת)

**תאריך:** 2026-03-29  
**מוציא:** צוות 10 · יישור ל־[`hub/data/site-tree.json`](../../hub/data/site-tree.json) (אישור אייל 2026-04-06)  
**מטרה:** סגירת **M2-T-EYAL-MENU-SLUG** + **M2-T-MENUS-T1T6** — טבלת יעד לביצוע ב־WordPress (**M2 Primary EA** → מיקום `primary`).

**הערות כלליות**

- **EN (`/en/`):** לפי העץ — **איקון בהדר בלבד**, לא פריט בשורת התפריט הראשית.  
- **קורסים (`st-courses`):** **קישור מותאם (חיצוני)** — אין עמוד WP מלא; `slug` ב־JSON הוא `courses-external` (תווית תפריט: «קורסים (סקולר / חיצוני)»). עד URL סופי מ־100/אייל — מותר placeholder מתועד (למשל מוקאף Hub או «בקרוב») **בלי 404 שקט** — ראו F11 ב־M2-WORKPLAN.  
- **פער ידוע מול זריעת MU ישנה:** `ea-m2-seed-shell-once.php` עדיין משתמש בחלק משמות/slugים מסעיף §7 ישן (למשל `hashita`, `services`, `courses-soon`). **הטבלה למטה היא היעד הנעול**; לאחר פריסה יש לעדכן עמודים/תפריט בסטייג’ינג בהתאם או להריץ תיקון MU/ידני — לא לסמן «הושלם» בלי אימות חי.

---

## טבלה — סדר ראשי (מקומות 1–11)

| מקום | `pageId` | כותרת עברית (תפריט) | Slug יעד (נתיב יחסי) | הערה |
|------|-----------|------------------------|----------------------|------|
| 1 | `st-home` | *(לוגו בלבד — ללא טקסט «בית»)* | `home` (דף בית סטטי) | Reading: `page_on_front` |
| 2 | `st-svc-treatment` | טיפול בדיג'רידו | `treatment` | |
| 3 | `st-method` | השיטה | `method` | לא `hashita` ביעד סופי |
| 4 | `st-svc-lessons` | שיעורי דיג'רידו | `lessons` | |
| 5 | `st-svc-sound` | סאונד הילינג | `sound-healing` | |
| 6 | `st-learning-hub` | לימוד והכשרה | `learning` | עמוד שער |
| 6a | `st-trainings` | הכשרות למטפלים | `therapist-training` | תת־תפריט; **noindex** (Yoast) |
| 6b | `st-courses` | קורסים (סקולר / חיצוני) | — | **Custom URL** חיצוני |
| 6c | `st-svc-lectures` | הרצאות | `lectures` | |
| 6d | `st-svc-workshops` | סדנאות | `workshops` | |
| 7 | `st-didg-gear-hub` | כלים ואביזרים | `tools-and-accessories` | עמוד שער |
| 7a | `st-svc-handmade` | כלים בעבודת יד ואביזרים | `instruments` | |
| 7b | `st-svc-repair` | תיקון וחידוש כלים | `repair` | |
| 8 | `st-books` | מוזה הוצאה לאור | `muzza` | שער; תתי־ספרים לפי עץ |
| 9 | `st-blog` | בלוג דיג'רידו | `blog` | `page_for_posts` |
| 10 | `st-eyal-hub` | אייל עמית | `eyal-amit` | |
| 10a | `st-mokesh` | מוקש דהימן — לזכרו | `mokesh-dahiman` | תת־עמוד; slug נעול מול עץ |
| 11 | `st-contact` | צור קשר | `contact` | Fluent shortcode |

---

## פוטר — קישורים חובה (לא בשורת התפריט הראשית)

| `pageId` | כותרת | Slug |
|----------|--------|------|
| `st-faq` | שאלות נפוצות (FAQ) | `faq` |
| `st-galleries-catalog` | גלריות — קטלוג מרכזי | `galleries` |
| `st-media` | המלצות — קטלוג מרכזי | `media` |
| `st-privacy` | מדיניות פרטיות | `privacy` |
| `st-legal-access` | הצהרת נגישות | `accessibility` |
| `st-legal-terms` | תקנון | `terms` |

---

## הפניות

- מנדט QA (כולל S7 קורסים חיצוני): [`../team_50/M2-QA-CONSOLIDATED-MANDATE-TEAM50-2026-04-10.md`](../team_50/M2-QA-CONSOLIDATED-MANDATE-TEAM50-2026-04-10.md)  
- סיכום יישום §4.1: [`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](./M2-IMPLEMENTATION-SUMMARY-2026-04-01.md)
