# דוח QA — מוכנות תשתית (מילוי צוות **50**)

**תאריך ביצוע:** 2026-04-02  
**שעת ביצוע:** 17:28 IDT  
**מבקר/ת:** Codex (בשם צוות 50)
**סטטוס מסכם:** **PASS**

**מקור צ'קליסט:** [`M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md`](./M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md)

> **ממצא מקדים (ביצוע סוכן — לא מחליף חתימת 50):** לאחר `ftp_deploy_site_wp_content.py` (2026-04-03) נבדק `curl -k` לדף הבית בסטייג'ינג — **HTTP 200**, `noindex,nofollow` ב־meta robots, ו־`wp-child-theme-ea-eyalamit` בפלט HTML. צוות 50 מאמת עצמאית.

**סיכום קצר:** ריטסט Q3 לפי מנדט 100 עבר. `bash scripts/verify_local_wp_cli.sh` בנה את התמונה `eyalamit-local-wp:xdebug-wpcli-v3`, אימת `WP-CLI version 2.12.0`, ולאחר `docker compose up -d --force-recreate wordpress` גם `docker compose exec wordpress /usr/bin/wp --path=/var/www/html --allow-root cli info` החזיר יציאה `0`. שאר בדיקות התשתית נשארו תקינות, ולכן דוח התשתית משתדרג ל־`PASS`.

**ריטסט בעקבות מסמכי תיקון מ־2026-04-04/2026-04-06 (בוצע בפועל ב־2026-04-02 17:28 IDT):** נבדקו מחדש [`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md), [`M2-G2-STAGING-P0-DONE-2026-04-04.md`](../team_10/M2-G2-STAGING-P0-DONE-2026-04-04.md), [`site/README.md`](../../site/README.md), וכן המנדט [`../team_100/M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md`](../team_100/M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md).

---

| # | בדיקה | תוצאה (☑ / ✗) | הערות / ראיה |
|---|--------|---------------|----------------|
| Q1 | `verify_m2_g2_repo_artifacts.sh` | ☑ | `OK: M2 G2 repo artifacts verified under site/`; אומתו child, mu-plugins, WXR ו־PHP lint. |
| Q2 | Docker bind-mount `site/wp-content` | ☑ | `local/docker-compose.yml` ממפה `../site/wp-content:/var/www/html/wp-content`; `docker compose ps` הראה `local-db-1` ו־`local-wordpress-1` רצים. בריטסט הקונטיינר רץ מתמונה מעודכנת `eyalamit-local-wp:xdebug-wpcli-v3`. `WORDPRESS_PORT` בדוח המקורי היה `8080` (לא קאנוני); **קאנון מאגר:** `8088` ב־`local/.env` + `docker-compose` default. |
| Q3 | WP-CLI בקונטיינר | ☑ | `bash scripts/verify_local_wp_cli.sh` עבר והחזיר `WP-CLI version: 2.12.0`; לאחר `docker compose up -d --force-recreate wordpress` גם `docker compose exec wordpress /usr/bin/wp --path=/var/www/html --allow-root cli info` עבר ביציאה `0`. |
| Q4 | Xdebug טעון | ☑ | `docker compose exec wordpress php -m | grep -i xdebug` החזיר `xdebug` ו־`Xdebug`. |
| Q5 | Runbook §14 | ☑ | `M2-RUNBOOK-ENV-2026-03-31.md` כולל סעיף §14 "סביבה מקומית (Docker) — יישור טכני (2026-04-03)" עם bind-mount, WP-CLI, Xdebug ו־MariaDB. הערת QA: בבקשת הבקרה נכתב `§11.1`, אך התיעוד המקומי בפועל הוא §14. |
| Q6 | סיכום 10 §3.2 מדיה | ☑ | `M2-IMPLEMENTATION-SUMMARY-2026-04-01.md` §3.2 נועל את מדיניות המדיה ל־M2 בתאריך 2026-04-03, כולל חלופה היברידית ו־TinyPNG מחוץ ל־Git. |
| Q7 | סטייג'ינג (FTP / תמה / noindex) | ☑ | `curl -k -sI` ל־`https://eyalamit-co-il-2026.s887.upress.link` החזיר `HTTP/2 200` ו־`x-robots-tag: noindex, nofollow`; `curl -k -s /` הראה `wp-child-theme-ea-eyalamit`, טעינת `generate-child-css`, ו־meta robots `noindex, nofollow`. |
| Q8 | תבנית קליטת תוכן | ☑ | `M2-CONTENT-INTAKE-FROM-EYAL-2026-04-03.md` קיים ומכסה מיפוי עץ, WXR מחדש, וקריאת QA חוזרת לצוות 50 אחרי הזנה. |

---

**המלצת צוות 50:** Q3 נסגר. כדי לשמר את התוצאה גם אצל בודקים נוספים, יש לבצע אחרי `pull` את `bash scripts/verify_local_wp_cli.sh`, ואז `docker compose up -d --force-recreate wordpress` מתוך `local/`.

**חתימת צוות 50:** Codex (צוות 50) + 2026-04-02
