# M2 G2 — סגירת P0 סטייג'ינג (צוות 10)

**תאריך:** 2026-04-04  
**מנדט מקור:** [`M2-G2-STAGING-P0-COMPLETION-2026-04-04.md`](./M2-G2-STAGING-P0-COMPLETION-2026-04-04.md)  
**דוח QA קודם (חסום):** [`../team_50/M2-G2-QA-REPORT-TEAM50-2026-04-02.md`](../team_50/M2-G2-QA-REPORT-TEAM50-2026-04-02.md)  
**סיכום יישום מעודכן:** [`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](./M2-IMPLEMENTATION-SUMMARY-2026-04-01.md)

---

## מה בוצע

| תחום | פעולה |
|------|--------|
| **FTP** | [`scripts/ftp_deploy_site_wp_content.py`](../../scripts/ftp_deploy_site_wp_content.py) + `--upload-wxr` — child, MU (כולל זריעה), WXR על השרת |
| **עמודים + קריאה** | MU [`ea-m2-seed-shell-once.php`](../../site/wp-content/mu-plugins/ea-m2-seed-shell-once.php) (v1.0.1) — זריעה חד־פעמית + **`ea_m2_ensure_reading_settings`** מתקן `page_on_front` / `page_for_posts` אם נדרש |
| **תפריט** | נוצר **M2 Primary EA**, שויך ל־**`primary`** (GeneratePress) |
| **Fluent** | תוכן **צור קשר:** `[fluentform id=1]` (ללא מרכאות — מונע שבירת shortcode בישויות HTML). **לוודא** ב־wp-admin טופס מזהה **1** או לעדכן shortcode. אימות 100: ראו [`../team_100/M2-G2-P0-TEAM10-VERIFICATION-BY-100-2026-04-04.md`](../team_100/M2-G2-P0-TEAM10-VERIFICATION-BY-100-2026-04-04.md) §3 — נדרשת פריסת MU **v1.0.2**. |
| **Yoast P15** | `update_post_meta( … '_yoast_wpseo_meta-robots-noindex', '1' )` על `therapist-training` |
| **EN** | `/en/` — מחלקת גוף `ea-lang-en` ☑ (בדיקת מקור) |

**גיבוי uPress:** ☑ **בוצע** — אישור מחזיק הפרויקט (לפני/מקביל לשינויים; נוהל צוות 20).

---

## אימות מהיר (curl `-k`, 2026-04-04)

| נתיב | HTTP |
|------|------|
| `/` | 200 |
| `/contact/`, `/en/`, `/home/`, `/blog/`, `/services/`, `/therapist-training/`, `/shop/` | 200 |

מזהי WP נרשמו ב־[`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](./M2-IMPLEMENTATION-SUMMARY-2026-04-01.md) §4 (מ־`/wp-json/wp/v2/pages`).

---

## צוות 50

**המסמך / החבילה לבדיקה חוזרת הועברו** לצוות 50 (אישור מחזיק).  
צוות 10 ממשיך לאחריות: וידוא **Fluent** (טופס id=1 + שליחת בדיקה), **M10-15** (handoff), ותגובה לממצאי ריטסט כשיפורסמו.

---

## איפוס זריעה (רק אם נדרש מחדש)

ב־wp-admin או ב־phpMyAdmin: `delete_option('ea_m2_shell_seed_v1');` — ואז להסיר זמנית את קובץ ה־MU או לתקן ידנית כדי לא לכפול עמודים (הזריעה לא מנקה תפריט קיים אם כבר נוצר).

---

*צוות 10 — סיום דוח P0.*
