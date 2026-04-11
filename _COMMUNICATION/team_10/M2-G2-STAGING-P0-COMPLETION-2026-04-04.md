# M2 G2 — השלמת סטייג'ינג (P0) אחרי דוח QA צוות 50

**תאריך:** 2026-04-04  
**קהל:** צוות **10** (ביצוע ב־wp-admin / FTP) — **מנדט P0 זה בבעלות 10**; ארטיפקטי מאגר + תיקון תשתית מקומית הושלמו ע״י צוות **100** (ראו [`../team_100/M2-QA-REMEDIATION-AND-RETEST-PLAN-2026-04-04.md`](../team_100/M2-QA-REMEDIATION-AND-RETEST-PLAN-2026-04-04.md)).  
**הקשר:** [`../team_50/M2-G2-QA-REPORT-TEAM50-2026-04-02.md`](../team_50/M2-G2-QA-REPORT-TEAM50-2026-04-02.md) — **BLOCKED** בגלל חוסר ייבוא ותפריטים.

**מקור ארכיטקטורת עמודים:** [`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](./M2-IMPLEMENTATION-SUMMARY-2026-04-01.md) §4 ואילך · Runbook §13.2 ב־[`../team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md).

---

## 0. לפני ייבוא

1. גיבוי בסטייג'ינג (פאנל uPress / ייצוא — לפי נוהל צוות 20).
2. פריסת קבצים מהמאגר (אם לא בוצע):  
   `python3 scripts/ftp_deploy_site_wp_content.py`  
   להעלאת קובץ הייבוא בנוסף:  
   `python3 scripts/ftp_deploy_site_wp_content.py --upload-wxr`  
   (הקובץ יופיע תחת Media Library בנתיב `uploads/ea-m2-seed/m2-pages-seed.wxr`).
3. לוודא ש־child **EA Eyal Amit** פעיל (אחרי ביקור בדף הבית — MU-plugin `ea-m2-auto-activate-child`).

---

## 1. ייבוא עמודים (G4)

1. **כלים → ייבוא → WordPress** — לייבא [`site/exports/m2-pages-seed.wxr`](../../site/exports/m2-pages-seed.wxr) (מהמחשב או מהשרת אחרי `--upload-wxr`).
2. ממליצים למפות מחברים ל־existing או ליצור — לפי תוכן ה־WXR והנחיות המייבא.
3. אופציונלי: להסיר או לבטל «Sample Page» אם מבלבל.

---

## 2. הגדרות קריאה

**הגדרות → קריאה**

- **דף ראשי:** עמוד סטטי — **בית** (slug יעד `home`).
- **עמוד פוסטים:** **בלוג** (slug יעד `blog`).

---

## 3. תפריטים (T1–T6)

לפי הסיכום והבריף ל־QA: להקים / לעדכן תפריט ראשי עברית, תפריט משני לפי הצורך, פריט **English** המוביל ל־`/en/`, וקישור ל־`courses-soon` אם נדרש במטריצה.

אמת בחזית: אין רק «Sample Page»; הניווט משקף את עץ M2.

---

## 4. צור קשר + Fluent (P16)

1. לוודא שקיים עמוד **צור קשר** עם slug **`contact`**.
2. ליצור טופס ב־**Fluent Forms** ולשבץ shortcode בדף.
3. בדיקה: שליחת טופס + בדיקת **WP Mail Logging** (אם מותקן).

---

## 5. עמוד אנגלית (EN LTR)

1. עמוד עם slug **`en`** (או **`english`** אם כך סוכם) עם תוכן placeholder לפחות.
2. לוודא שבמקור ה־HTML מופיעה מחלקת גוף **`ea-lang-en`** (מהתמה child).

---

## 6. Yoast — P15

עמוד **`therapist-training`:** להגדיר **noindex** ברמת העמוד ב־Yoast (אחרי שהעמוד קיים ואינו 404).

---

## 7. אימות מהיר לפני החזרה ל־50

| בדיקה | צפוי |
|--------|------|
| `/` | דף בית סטטי, לא ברירת מחדל של פוסט יחיד |
| `/contact/`, `/en/`, `/home/`, `/blog/`, `/services/` | 200 |
| תפריט | מבנה M2 |
| `therapist-training` | noindex (Yoast) + 200 |

---

## 8. עדכון מסמכים פנימיים

לאחר ביצוע: לעדכן ב־[`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](./M2-IMPLEMENTATION-SUMMARY-2026-04-01.md) טבלאות §4 (מזהי WP אם נדרש) וסטטוס G2 — או דוח קצר חדש ב־`team_10/`.
