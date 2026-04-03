# M2 G2 — אימות ביצוע P0 (צוות 10) מול מאגר וסטייג'ינג

**תאריך בדיקה:** 2026-04-04  
**מבצע בדיקה:** צוות **100** (ארכיטקטורה)  
**מקור דיווח 10:** סיכום P0 + [`M2-G2-STAGING-P0-DONE-2026-04-04.md`](../team_10/M2-G2-STAGING-P0-DONE-2026-04-04.md) · [`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md)

---

## 1. מה נבדק במאגר

| בדיקה | תוצאה |
|--------|--------|
| קיים [`site/wp-content/mu-plugins/ea-m2-seed-shell-once.php`](../../site/wp-content/mu-plugins/ea-m2-seed-shell-once.php) | ☑ |
| [`scripts/ftp_deploy_site_wp_content.py`](../../scripts/ftp_deploy_site_wp_content.py) מעלה את ארבעת רכיבי ה־MU (כולל זריעה) | ☑ |
| `php -l` על קובץ הזריעה | ☑ |
| [`scripts/verify_m2_g2_repo_artifacts.sh`](../../scripts/verify_m2_g2_repo_artifacts.sh) — עודכן לכלול את כל ה־MU + lint | ☑ (אחרי עדכון 100) |

**לוגיקת זריעה (סקירה):** עמודים ותפריט `M2 Primary EA` + מיקום `primary`; קריאה `page` + `page_on_front` / `page_for_posts`; Yoast meta `_yoast_wpseo_meta-robots-noindex` ל־`therapist-training`; נעילה חד־פעמית `ea_m2_shell_seed_v1`; תיקון קריאה חוזר ב־`ea_m2_ensure_reading_settings`.

---

## 2. בדיקת סטייג'ינג חיצונית (`curl -k`)

מול `https://eyalamit-co-il-2026.s887.upress.link` (כמתועד):

| נתיב | HTTP |
|------|------|
| `/`, `/shop/`, `/contact/`, `/en/`, `/blog/`, `/services/`, `/therapist-training/` | **200** ☑ |

| בדיקה | תוצאה |
|--------|--------|
| `/en/` — מחלקת גוף `ea-lang-en` (child `functions.php`) | ☑ |
| `/contact/` — טופס Fluent בפועל | ✗ → **תוקן במאגר** (ראו §3) |

**הערת Yoast P15:** בדף `therapist-training` מופיע `meta robots noindex` — בסטייג'ינג קיים גם `noindex` גלובלי מ־`ea-staging-noindex`, ולכן **אי אפשר להפריד בין noindex של האתר לבין noindex ברמת העמוד** מתוך ה־HTML בלבד. צוות 50 או 10 יכולים לאמת ב־wp-admin / מטא Yoast.

---

## 3. ממצא קריטי — shortcode Fluent ב־`/contact/` (תוקן)

בבדיקה הופיע ב־HTML טקסט גלוי `[fluentform id=&quot;1&quot;]` (ללא `<form`), כלומר ה־shortcode לא רץ — כנראה שמירה עם ישויות HTML בתוכן העמוד.

**פעולת 100 במאגר (גרסת MU 1.0.2):**

- זריעה משתמשת ב־`[fluentform id=1]` (ללא מרכאות בתוך התג).
- נוספה `ea_m2_repair_contact_fluent_shortcode` ב־`init` שמחליפה ישויות / מרכאות כפולות בגרסה התקינה.

**נדרש מ־10:** להריץ שוב `ftp_deploy_site_wp_content.py` (או להעלות ידנית את `ea-m2-seed-shell-once.php` המעודכן) ולגלוש פעם אחת לסטייג'ינג כדי שהתיקון ירוץ; אחר כך לוודא שמזהה טופס **1** קיים ב־Fluent או לעדכן את ה־shortcode בהתאם.

---

## 4. גיבוי uPress

בדוח P0-DONE מסומן גיבוי ☑ (אישור מחזיק). אם בפועל לא בוצע גיבוי אוטומטי מהסביבה שבה רצה הסקריפט — **ליישר קו עם נוהל צוות 20** ולתעד; אין סתירה בין «אישור מחזיק» לבין המלצת אבטחה על סיבוב סיסמאות אם **`local/.env.upress`** נחשף.

---

## 5. מה נשאר לצוות 50 / 10

| נושא | אחריות |
|------|--------|
| פריסת `ea-m2-seed-shell-once.php` **v1.0.2** לסטייג'ינג + אימות טופס ב־`/contact/` | 10 |
| ריטסט QA מלא (G2 brief + תשתית אם נדרש) | 50 |
| M10-15 / חתימות handoff | 10 (ידני) |
| וידוא Fluent id=1 + שליחה + WP Mail Logging | 10 |

---

## 6. מסקנה

**P0 מבחינת מבנה עמודים, קריאה, תפריט, EN, נתיבי 200 — מאושר כפי שנבדק.**  
**תנאי סגור ל־G2 בנושא טפסים:** יש לאמת מחדש אחרי פריסת תיקון ה־MU (§3).

**חתימת צוות 100:** אימות זה — 2026-04-04
