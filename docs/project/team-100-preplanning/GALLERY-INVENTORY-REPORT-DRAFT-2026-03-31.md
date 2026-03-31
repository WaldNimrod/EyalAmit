# דוח מלאי גלריות (טיוטה) — אתר legacy + Envira Gallery Lite

**תאריך:** 2026-03-31 (עדכון מיפוי: 2026-03-29)  
**סטטוס:** `DRAFT` — **להשלמת מיפוי מדויק** (מספר תמונות + שימוש בכל עמוד) — ראו §2.1–2.3.

**מקור טכני (מאגר):** תוסף **Envira Gallery Lite** באתר הישן — `eyalamit.co.il-legacy/wp-content/plugins/envira-gallery-lite/` (כאשר קיים במאגר).  
**החלטת תוכן:** כל תוכן הגלריות עובר לאתר החדש — תקרה **~150 תמונות למחיצה**; בחינת **SEO** לפני מימוש — ראו [`MEETING-MINUTES-EYAL-2026-03-31.md`](./MEETING-MINUTES-EYAL-2026-03-31.md).

---

## 1. עמודות הדוח

| עמודה | תיאור |
|--------|--------|
| שם גלריה | כותרת ב־WP (post_title) |
| מזהה | `ID` ב־`wp_posts` או slug |
| מספר תמונות | מדויק (ממטא) או הערכה |
| שימוש בעמודים | איפה מוטמעת (shortcode / בלוק / עמוד) |
| הערת SEO | כפל תוכן, טקסט alt, מהירות |
| התאמה לתקרת 150 | כן / לא / צריך פיצול |

---

## 2. השלמת מיפוי מדויק — סדר פעולות מומלץ

### 2.1 שלב א׳ — רשימת גלריות + שימוש (בלי DB)

1. **יצוא WordPress:** `כלים` → `ייצוא` → **כל התוכן** → הורדת קובץ `.xml`.  
2. הרצה:

   `python3 scripts/inventory_legacy_galleries.py --wxr-export /path/to/site.WordPress.xml --csv-out docs/project/team-100-preplanning/galleries-from-wxr.csv`

   התוצאה כוללת: מזהה גלריה, כותרת, slug, סטטוס, **מניין צאצאים מסוג attachment בקובץ היצוא** (אם מופיעים שם), ו־**שימוש בעמודים** מזיהוי קצרקוד `[envira-gallery id="…"]`.

3. **פרשנות:** אם עמודת מספר תמונות יוצאת `0`, Envira עשוי לאחסן תמונות **רק ב־postmeta** — עבור לשלב ב׳.

### 2.2 שלב ב׳ — מספר תמונות מדויק (MySQL / phpMyAdmin)

- שאילתות והרצת הסקריפט עם `--host` … — ראו [`scripts/inventory_legacy_galleries.py`](../../../scripts/inventory_legacy_galleries.py).  
- לאימות סופי: ממשק Envira או ספירה ממוסדת מול המטא.

### 2.3 שלב ג׳ — מיזוג ל־SSOT

- להעתיק עמודות סופיות לטבלה §2.4 או לעדכן [`GALLERY-INVENTORY-TEMPLATE.csv`](./GALLERY-INVENTORY-TEMPLATE.csv).  
- לסמן **התאמה לתקרת 150** ו**הערת SEO** לכל גלריה.

---

## 2.4 טבלה (מילוי אחרי שלב א׳–ב׳)

| שם גלריה | מזהה | מספר תמונות | שימוש בעמודים | הערת SEO | תקרת 150 |
|-----------|------|-------------|----------------|----------|-----------|
| *(מילוי מ־CSV / ידני)* | | | | | |

---

## 3. כשאין גישה לאתר הישן כרגע

- מלאו את [`GALLERY-INVENTORY-TEMPLATE.csv`](./GALLERY-INVENTORY-TEMPLATE.csv) מממשק **Envira** בכל ביקור באתר החי.  
- שמרו עותק עם תאריך עד לאישור אייל.

---

## 4. קישורים

- מפת אתר (גלריות): [`SITEMAP-NEW-SITE-v2-DRAFT.md`](./SITEMAP-NEW-SITE-v2-DRAFT.md) v2.3  
- אפיון גלריות: [`SITE-SPECIFICATION-FINAL-2026-03-30.md`](./SITE-SPECIFICATION-FINAL-2026-03-30.md) §8  
- ניתוח תבנית WP (הקשר ביצועים): [`WP-THEME-EVALUATION-HEBREW-SEO-2026-03-29.md`](./WP-THEME-EVALUATION-HEBREW-SEO-2026-03-29.md)
