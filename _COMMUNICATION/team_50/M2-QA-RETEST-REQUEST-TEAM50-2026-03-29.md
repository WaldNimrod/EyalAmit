# M2 — בקשת ריטסט QA (צוות **50**) — סגירת פערי דוח FINAL 2026-04-06

**תאריך:** 2026-03-29  
**מוציא:** צוות **10** (יישום טכני במאגר) · תיאום **100**  
**אל:** צוות **50** (QA)  
**מנדט:** [`M2-QA-CONSOLIDATED-MANDATE-TEAM50-2026-04-10.md`](./M2-QA-CONSOLIDATED-MANDATE-TEAM50-2026-04-10.md)  
**דוח כשל קודם (הקשר):** [`M2-SMOKE-REPORT-FINAL-2026-04-06.md`](./M2-SMOKE-REPORT-FINAL-2026-04-06.md) (FAIL — S5–S10, F-01–F-05)

---

## 1. מה השתנה במאגר (לפני שמריצים QA)

| אזור | קבצים / התנהגות |
|------|------------------|
| סנכרון עץ נעול | [`site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php`](../../site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php) — עמודים + **M2 Primary EA** + **M2 Footer EA** (מיקום `ea_footer_legal`); מפתח אופציה **`ea_m2_site_tree_lock_sync_v2`** (ריצה חד־פעמית אוטומטית בטעינה ראשונה אחרי פריסה אם לא קיים `done`) |
| הפניות 301 | אותו MU — `template_redirect`: legacy → קנוני (`/shop/` → `/tools-and-accessories/`, `/courses-soon/` → `/learning/courses-external/`, `/hashita/` → `/method/`, `/books/` → `/muzeh/`, `/testimonials-media/` → `/media/`, נתיבי `services/…`, וכו׳) + `/courses-external/` בשורש + `/accessibility-statement/` |
| זריעה ישנה | [`site/wp-content/mu-plugins/ea-m2-seed-shell-once.php`](../../site/wp-content/mu-plugins/ea-m2-seed-shell-once.php) v1.1 — **אין** יצירת עמודים/תפריט §7; IA מסתמך על סנכרון העץ (init 28) |
| Child theme | [`site/wp-content/themes/ea-eyalamit/functions.php`](../../site/wp-content/themes/ea-eyalamit/functions.php) — רישום `ea_footer_legal`, רינדור פוטר ב־`generate_before_footer`, קישור **EN** ב־`generate_inside_navigation` (לא ב-primary) |
| Child theme | [`template-home-dashboard.php`](../../site/wp-content/themes/ea-eyalamit/page-templates/template-home-dashboard.php) — קישור טיפול ל־`/treatment/` (לא legacy) |
| Child theme | [`style.css`](../../site/wp-content/themes/ea-eyalamit/style.css) v1.1.2 — סגנון EN + פוטר |

**מקור אמת IA:** [`hub/data/site-tree.json`](../../hub/data/site-tree.json)

---

## 2. פריסה לסטייג’ינג + ראיות

**בוצע מהמאגר (סוכן):** `python3 scripts/ftp_deploy_site_wp_content.py` — כולל כעת גם `ea-m2-site-tree-lock-sync-once.php` (תוקן הסקריפט).  
**אימות אוטומטי:** [`../team_10/M2-STAGING-DEPLOY-VERIFY-ARTIFACT-2026-04-06.md`](../team_10/M2-STAGING-DEPLOY-VERIFY-ARTIFACT-2026-04-06.md) — קודי HTTP, דוגמת `Location` ל־301, דגימות HTML (EN, פוטר, `/treatment/`), `lang="en"` ב־`/en/`.

להמשך / חריגים: [`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md), [`site/README.md`](../../site/README.md).  
**איפוס סנכרון (רק אם נדרש ריצה מחדש):** `delete_option('ea_m2_site_tree_lock_sync_v2')`.

---

## 3. תוצר מבוקש מצוות 50

קובץ דוח **`STATUS: FINAL`** עם **PASS** / **PASS WITH NOTES** (F2 בלבד) / **FAIL**, לפי המנדט המרוכז, כולל §8 + HOME + T-en + A11y + Fluent.

**דוח שהתקבל:** [`M2-SMOKE-REPORT-FINAL-2026-04-06-v2.md`](./M2-SMOKE-REPORT-FINAL-2026-04-06-v2.md) (**PASS WITH NOTES**, F2).

---

## 4. צ׳ק־ליסט שער פנימי (צוות 10)

לאחר פריסה — ראו [`M2-INTERNAL-STAGING-GATE-2026-03-29.md`](../team_10/M2-INTERNAL-STAGING-GATE-2026-03-29.md).
