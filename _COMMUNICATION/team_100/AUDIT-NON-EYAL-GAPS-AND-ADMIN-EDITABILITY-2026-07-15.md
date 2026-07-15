---
id: AUDIT-NON-EYAL-GAPS-AND-ADMIN-EDITABILITY-2026-07-15
from_team: team_100
to_team: team_00
date: 2026-07-15
type: audit-status
---

# ביקורת: פערים צוותיים + שלמות עמודים + עריכה ב־wp-admin

## 0. קובץ עוגן — נשמר (בלי לבקש ממך)

מקור: קאש Claude MCP `download_file_content` מסשן 2026-07-12.

נתיב:
`docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-07-12--snoring-sleep-apnea-didgeridoo-CHECKED.md`
(~41KB, 18 סקשנים, כולל יוני/מכבי בטקסט).

**עדיין לא מוחלף ב־defaults verbatim** — השמירה סוגרת את השער; יישום מלא = משימת המשך מיידית.

---

## 1. מה קיבלנו / מאושר צוותית — ולא מומש עד הסוף (בלי לחכות לאייל)

| עדיפות | פריט | מצב |
|--------|------|-----|
| P0 | סבב Content-QA 12.7 (Trust Line, nav learning, metadesc, וכו') | **בקוד** — **אין** סגירת browser/staging ייעודית |
| P0 | `/learning/{therapist-training,lectures,workshops}/` | ניווט תוקן → **גופי placeholder** בלבד |
| P0 | דף עוגן verbatim מ־MD שנשמר עכשיו | **stub CP-01** חי; MD במאגר — **טרם שילוב עד הפסיק** |
| P1 | AF-01…04 + כותרות BN-03 + FAQ-02/03 + BLOG spokes | טיוטות ב־Hub — **לא נבנו** (צוותי לפי החלטת 14.7) |
| P1 | גלריות וכתבת/צבע | כריכה + סלוטי «ממתין» — אין בינארי מקומי (Drive refs) |
| P1 | `/method` — שמות ממליצים לחיצים | חלקי מול דף הבית |
| P2 | ACF לכל עמודי הפנים (החלטת team_00 22.6) | **לא נבנה** — רק בית |
| P2 | meta-box מחיר מוצר ב־wp-admin | לא נבנה |
| P2 | עמודים משפטיים | placeholder |
| P3 | `/press` | Wave2 בכוונה — לא Chapters |

**לא ברשימה:** URL GI מדויק, קבצי מכבי/יוני (בינארי), ניסוח רפואי סופי מאייל — אלה תלויי אייל.

---

## 2. האם כל העמודים זמינים / תקינים / תוכן מדויק?

| שאלה | תשובה |
|------|--------|
| זמינים בסטייג׳ינג? | **רוב עמודי Chapters המרכזיים — כן** (WP-CANON E2E PASS 14.7 + smoke ספרים/עוגן 15.7). `/learning/*` קיימים כ־placeholder. |
| תקינים עיצובית? | מערכת Chapters אחרי CSS-enqueue fix — **כן** למוצרים/ספרים שנבדקו. לא כל פריט DETAILED-DIFF קיבל browser QA חוזר. |
| תוכן מדויק עד הפסיק? | **עמודי ליבה מ־May 25.5.26** — content-diff historically 100% משפטים. **עוגן** — **לא** (stub ≠ MD מלא). **learning / legal / press** — לא verbatim מלא. גלריות ספרים (חוץ מכושי) — לא מלאות. |

---

## 3. ממשקי עריכה לאייל מול התבניות — האם תואמים ומאפשרים עריכת הכול ב־wp-admin?

**לא.**

| מה ניתן לערוך ב־wp-admin | מה לא |
|---------------------------|--------|
| **דף הבית** — ACF מלא (`acf-fields-home.php`) | כמעט כל שאר Chapters: `tpl-chapters-page.php` קורא **רק** `*-defaults.php` — מתעלם מ־`post_content` ומ־ACF |
| גופי QR (`/qr/qrN/`) — עורך רגיל | method — accessors מוכנים ל־ACF אבל **אין** field group רשום |
| פוסטים בבלוג | EN — מחרוזות hardcoded בתבנית |
| שאלות FAQ (CPT `ea_faq`) | Hero/intro של `/faq` — defaults |
| | מחיר מוצר — postmeta בלי meta-box |

החלטת team_00 מ־22.6 (`DECISION_CHAPTERS_INNER_ACF`) — **Option B לכל העמודים** — **טרם יושמה** (רק בית).

Hub (`page-review` / `media-intake`) = localStorage + ייצוא JSON — **לא כותב לוורדפרס**.

---

## המלצת סדר המשך (צוות 100)

1. שילוב עוגן verbatim מה־MD שנשמר עכשיו + סלוטי מדיה ממתין.  
2. Browser QA לסגירת Content-QA 12.7.  
3. תוכן אמיתי ל־`/learning/*` או הסתרה מהניווט עד שיש.  
4. בניית ACF פנימי לפי ההחלטה מ־22.6 (אחרת אייל לא יכול לערוך את האתר ב־wp-admin).  
5. AF/SEO drafts כסבב תוכן צוותי.
