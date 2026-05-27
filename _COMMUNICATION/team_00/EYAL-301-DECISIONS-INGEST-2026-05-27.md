---
id: EYAL-301-DECISIONS-INGEST-2026-05-27
title: קליטת החלטות 301 מאייל — סגירת חוסם cutover
status: INGESTED · 4 פריטים דורשים תיאום המשך
date: 2026-05-27
from: nimrod (CEO transfer from Eyal)
to: team_00 (Principal) + team_20 (htaccess implementer) + team_100 (Architect)
parent_decision: ./DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md
canonical_source: ../../hub/data/decisions/redirects-301-eyal-final-2026-05-27.json
tool_origin: hub/dist/decisions/redirects-301.html (delivered via Drive 2026-05-26)
profile: L0
---

# קליטת 301 מאייל — סגירת חוסם cutover

## 0. הקשר

ב-2026-05-26 קובץ ה-301 decisions עלה ל-Drive המשותף ([301 - החלטות על כתובות מהאתר הישן.html](../..//Users/nimrod/Documents/Google%20Drive/Eyal%20Amit/החלטות%20לאייל%20-%2026.5.26/)) לטיפול אסינכרוני של אייל.

ב-2026-05-27 (~07:47 UTC) אייל סיים והחזיר JSON ([Downloads/redirects-301-decisions-2026-05-27.json](file:///Users/nimrod/Downloads/redirects-301-decisions-2026-05-27.json)).

ה-JSON נקלט ל-canonical path: [`hub/data/decisions/redirects-301-eyal-final-2026-05-27.json`](../../hub/data/decisions/redirects-301-eyal-final-2026-05-27.json).

---

## 1. סטטיסטיקות קליטה

| קטגוריה | כמות | טיפול |
|---------|------|--------|
| **Total decisions** | **135 / 135** | 134 הוחלטו + 1 ריק |
| 🔴 QR mandatory keep | 49 | אומת live ב-2026-05-26 — חובה לשמור slug |
| 🟢 non-QR keep | 54 | URLs שלא משתנים (חלקם redirected אוטומטית בפועל באתר הישן) |
| 🔵 301 redirect | 27 | מועברים לעמודי Wave2 — `team_20` ימפה ל-`.htaccess` |
| 🟠 410 gone | 1 | "פרק א" — להגיד לגוגל "נמחק לתמיד" |
| ⚠ Manual review | 3 | דורש תיאום נוסף עם אייל (ראו §2) |
| ⬜ Empty (no decision) | 1 | דף הבית הישן — נדרשת התייחסות (ראו §2) |

**אומדן זמן יישום .htaccess** (team_20): ~30-45 דק'.

---

## 2. 4 פריטים שדורשים תיאום המשך (לא חוסם cutover, אבל פתוח)

### 2.1 `/thankyou` (manual)
- **כותרת:** הרשמתך נקלטה בהצלחה
- **הערת אייל:** "לא יודע מה לעשות עם זה. נראה לי שזה הדף שעולה אחרי שנרשמים לאתר כמשתמש"
- **המלצת team_100:**
  - באתר החדש אין רישום משתמשים (לפי DECISION RECORD).
  - **פעולה:** 410 GONE (גוגל יסיר מהאינדקס). אם בעתיד יתווסף רישום — לשחזר.
  - **Confidence:** גבוה — לא בשימוש בWave2.

### 2.2 `/מפת-אתר-site-map` (manual)
- **כותרת:** מפת אתר - site map
- **הערת אייל:** "לא יודע לאן להפנות"
- **המלצת team_100:**
  - באתר החדש WP יציר אוטומטית `/sitemap.xml` (Yoast SEO / WP core 5.5+).
  - העמוד הישן היה HTML map, לא XML.
  - **פעולה:** 301 → `/sitemap.xml` (אם XML accept) **או** 301 → `/` (דף הבית, ה-XML linkable מה-footer).
  - **Confidence:** בינוני — עדיף לקבל אישור אייל בין השתיים.

### 2.3 `/תקנון` (manual)
- **כותרת:** תקנון
- **הערת אייל:** "העמוד כרגע ריק, אבל חשוב שיהיה בו תוכן"
- **המלצת team_100:**
  - תקנון נדרש משפטית בישראל לאתרים שאוספים נתונים (CF7 form → אישור פרטיות).
  - **פעולה — 2 שלבים:**
    1. **קצר טווח (cutover-time):** 301 → `/contact` כתוצרת זמנית.
    2. **טווח קצר אחרי cutover:** team_100 לכתוב מנדט לתוכן תקנון/פרטיות מינימלי (~1 עמוד), אייל לאשר תוכן.
  - **Confidence:** חובה לסגור לפני go-live (לפי LEGAL-ACCESSIBILITY-ISRAEL-SPEC).

### 2.4 (Empty) דף הבית הישן `/דיגרידו-המרכז...`
- **כותרת:** דיג'רידו - המרכז לטיפול בדיג'רידו - סטודיו נשימה מעגלית - אי...
- **הערת אייל:** ריק (לא נבחרה החלטה)
- **המלצת team_100:**
  - זה ה-slug הישן של דף הבית.
  - **פעולה:** 301 → `/` (דף הבית החדש). default obvious.
  - **Confidence:** גבוה. אין סיבה לדף ישן ארוך-slug להישאר.

---

## 3. סיכום החלטות team_100 לפריטים הפתוחים (לאישור nimrod)

| # | פריט | החלטה מוצעת | אם nimrod מאשר |
|---|------|---------------|------------------|
| 2.1 | `/thankyou` | 410 GONE | team_20 מוסיף `Redirect gone /thankyou` ל-.htaccess |
| 2.2 | `/מפת-אתר` | 301 → `/sitemap.xml` (preferred) או `/` | nimrod בוחר; team_20 ממפה |
| 2.3 | `/תקנון` | 301 → `/contact` (טווח קצר) + תוכן חדש לטווח-בינוני | team_100 ייצר WP-W2-LATE-1 לכתיבת תקנון |
| 2.4 | דף הבית הישן | 301 → `/` | team_20 ממפה |

**אם nimrod מאשר את כל ההמלצות** → team_20 ממפה את כל 135 הפריטים ל-`.htaccess` ב-W2-09 (cutover prep). אין חוסם נוסף מצד אייל.

---

## 4. עדכון tasks

- ✅ **301 חוסם פתוח** ← **closed by Eyal ingest 2026-05-27**
- ✅ **TikTok URL pending** ← **closed by Eyal ingest 2026-05-27** (`https://www.tiktok.com/@didgeridoo_therapy?_r=1&_t=ZS-96hl39iCAIG` — verified HTTP 200)
- ⚪ נשארו 4 פריטים פתוחים — לפי §2-§3 לעיל; להחלטת nimrod.

---

## 5. השפעה על roadmap

`WP-W2-09` (cutover prep) — חוסם cutover, חלקו תלוי ב-301. **כעת ה-JSON מוכן** → team_20 יכול להתחיל לתכנן `.htaccess` mapping אחרי שWave2 implementation מתקדם.

`Eyal — 3 human gates` (Task #16) — TikTok נסגר. נותרו 3 (SMTP App Password + GA4 + Clarity).

---

## 6. קבצים שעודכנו (commit הבא)

| קובץ | פעולה |
|------|--------|
| `hub/data/decisions/redirects-301-eyal-final-2026-05-27.json` | חדש (canonical 301 JSON) |
| `hub/data/social-channels.json` | TikTok → status:active + URL |
| `hub/data/links.json` | TikTok href + note |
| `site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-footer-social.php` | הוספת TikTok SVG icon + link |
| `hub/dist/decisions/hero-c-fbw-sketch.html` | פוטר עם TikTok link |
| `_COMMUNICATION/team_00/EYAL-301-DECISIONS-INGEST-2026-05-27.md` | מסמך זה |
