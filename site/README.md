# עץ פריסה קנוני — WordPress (מה שעולה לשרת)

תיקייה זו היא **שורש הארטיפקטים** שמיועדים לפריסה ל־**uPress** (או סביבה מקבילה): תוכן שמגיע מ־**Git** כחלק מהאתר הסופי.

## מה שייך לכאן

- `wp-content/themes/ea-eyalamit/` — **child** נעול לאפיון ([`SITE-SPECIFICATION-FINAL`](../docs/project/team-100-preplanning/SITE-SPECIFICATION-FINAL-2026-03-30.md) §1.2.1); כל התאמה מותגית/PHP נוסף — כאן בלבד, קידומת **`ea_`** · **דף בית:** `style.css` (טיפוגרפיה/טוקנים) + `assets/css/home-front.css` (פריסה) + `page-templates/template-home-dashboard.php` (ללא inline CSS); **Hero:** רקע גרדיאנט במוקאפ — תמונת מותג תישב ב־`.ea-home-hero-backdrop` כשתסופק; מסמך סטטוס: [`../_communication/team_10/M2-HOME-DASHBOARD-IMPLEMENTATION-STATUS-2026-04-08.md`](../_communication/team_10/M2-HOME-DASHBOARD-IMPLEMENTATION-STATUS-2026-04-08.md) · **נגישות (שרת):** תוסף **WP Accessibility** מ־wordpress.org — הגדרות ו־QA: [`../_communication/team_10/M2-WP-ACCESSIBILITY-CONFIG-AND-QA-2026-04-09.md`](../_communication/team_10/M2-WP-ACCESSIBILITY-CONFIG-AND-QA-2026-04-09.md)
- `wp-content/mu-plugins/ea-staging-noindex.php` — `noindex` לסטייג'ינג **uPress** (`*.upress.link`) + **v1.0.2** `nocache_headers` + `DONOTCACHEPAGE`; ראו runbook §8
- `wp-content/mu-plugins/ea-m2-auto-activate-child.php` — מחליף ל־child **ea-eyalamit** בבקשה הראשונה (אופציונלי להסיר אחרי ייצוב)
- `wp-content/mu-plugins/ea-m2-ensure-fluent-active.php` — **v1.0.1** — על סטייג'ינג uPress מפעיל את **Fluent Forms** אם מותקן וכבוי (עם הוקי activation מלאים)
- `wp-content/mu-plugins/ea-m2-seed-shell-once.php` — **זריעת מעטפת M2 פעם אחת** (מצומצם — IA מסנכרון העץ); ראו [`M2-G2-STAGING-P0-DONE-2026-04-04.md`](../_communication/team_10/M2-G2-STAGING-P0-DONE-2026-04-04.md)
- `wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php` — **סנכרון עץ נעול** (עמודים + תפריט primary + תפריט פוטר + 301 legacy); נכלל ב־`ftp_deploy_site_wp_content.py`
- `wp-content/mu-plugins/ea-m3-team80-placeholder-content-once.php` — **M3** תוכן זמני מצוות 80 (FAQ/גלריות/מדיה/משפטי/EN/שיטה/בלוג + Yoast לשירותים); פעם אחת — איפוס: `delete_option('ea_m3_team80_placeholder_content_v1')`; מקור: [`../_communication/team_80/M3-TEXT-PLACEHOLDER-RETURN-TEAM80-2026-04-06.md`](../_communication/team_80/M3-TEXT-PLACEHOLDER-RETURN-TEAM80-2026-04-06.md)
- `exports/m2-pages-seed.wxr` — **ייבוא עמודי מעטפת M2** (§7); נוצר מ־[`scripts/m2_emit_pages_wxr.py`](../scripts/m2_emit_pages_wxr.py) — אחרי ייבוא: **הגדרות → קריאה** (דף בית סטטי = «בית», עמוד פוסטים = «בלוג»)
- **GeneratePress (parent)** — **לא** נשמר במאגר; התקנה בשרת מממשק WP או מ־[wordpress.org/themes/generatepress](https://wordpress.org/themes/generatepress/)

## פריסה ראשונה לסטייג'ינג (תמצית)

**הלקוח אינו מעלה קבצים ב-FTP** — צוות הפיתוח מריץ את הסקריפטים למטה (או SFTP מקומי) עם **`local/.env.upress`** (שדות: [`docs/project/EYAL_ENV_VARS_REFERENCE.md`](../docs/project/EYAL_ENV_VARS_REFERENCE.md) §2; נוהל: [`docs/project/UPRESS_WORDPRESS_STANDARD_v2.md`](../docs/project/UPRESS_WORDPRESS_STANDARD_v2.md)).

1. התקנת **GeneratePress** ב־wp-admin.  
2. **FTP (מומלץ — סקריפט מהמאגר):** משורש המאגר, עם `local/.env.upress` ו־`pip install -r scripts/requirements-upress.txt` — `python3 scripts/ftp_deploy_site_wp_content.py` (child + mu-plugins). להעלאת קובץ הייבוא לשרת: `python3 scripts/ftp_deploy_site_wp_content.py --upload-wxr` (בשרת: `wp-content/uploads/ea-m2-seed/m2-pages-seed.wxr`).  
3. **FTP ידני (חלופה):** `themes/ea-eyalamit/` → `wp-content/themes/ea-eyalamit/`; ב־`mu-plugins/`: `ea-staging-noindex.php`, `ea-m2-auto-activate-child.php`, `ea-m2-ensure-fluent-active.php`, `ea-m2-seed-shell-once.php`, `ea-m2-site-tree-lock-sync-once.php`, `ea-m3-team80-placeholder-content-once.php`.  
4. להפעיל את תבנית **EA Eyal Amit**; לוודא permalink `/%postname%/`.  
5. **ייבוא:** כלים → ייבוא → `exports/m2-pages-seed.wxr` (מהמחשב או מהמדיה אחרי `--upload-wxr`) — אחר כך **הגדרות → קריאה** (בית סטטי, בלוג). פירוט P0: [`_communication/team_10/M2-G2-STAGING-P0-COMPLETION-2026-04-04.md`](../_communication/team_10/M2-G2-STAGING-P0-COMPLETION-2026-04-04.md).  
6. מסירה / סיכום G2: [`_communication/team_10/M2-HANDOFF-FROM-20-2026-03-31.md`](../_communication/team_10/M2-HANDOFF-FROM-20-2026-03-31.md) · [`_communication/team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](../_communication/team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md).  
7. אימות קבצים במאגר (לפני/אחרי deploy): `scripts/verify_m2_g2_repo_artifacts.sh` · בדיקות סטייג'ינג: [`_communication/team_50/M2-G2-QA-BRIEF-FOR-TEAM50-2026-03-29.md`](../_communication/team_50/M2-G2-QA-BRIEF-FOR-TEAM50-2026-03-29.md) · תיקון QA תשתית (100): [`_communication/team_100/M2-QA-REMEDIATION-AND-RETEST-PLAN-2026-04-04.md`](../_communication/team_100/M2-QA-REMEDIATION-AND-RETEST-PLAN-2026-04-04.md).

## פיתוח מקומי (Docker)

ב־[`local/docker-compose.yml`](../local/docker-compose.yml) מוגדר כברירת מחדל **bind-mount** של `site/wp-content` ל־`/var/www/html/wp-content` (ליבת WP ו־DB בנפחים נפרדים). פירוט, WP-CLI ו־Xdebug: [`local/README.md`](../local/README.md) · runbook §14.

## מה לא שייך לכאן

- `_communication/`, `docs/`, `scripts/`, `.cursor/` — נשארים בשורש המאגר ו־**לא** מועלים לשרת.

## ליבת WordPress

לרוב ב־uPress ליבת WP מנוהלת ע"י האחסון או מתעדכנת דרך הממשק. אם יוחלט אחרת (למשל ליבה ב־Git), יתועד ב־`_communication/team_20/M2-RUNBOOK-ENV-*.md`.

**מדיניות מלאה:** [`docs/project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md`](../docs/project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md).
