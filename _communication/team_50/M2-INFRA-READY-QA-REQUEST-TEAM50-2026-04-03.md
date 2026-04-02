# בקשת בקרה ו־QA — מוכנות תשתית לפני קליטת תוכן סופי (צוות **50**)

**תאריך:** 2026-04-03  
**מוציא:** צוות **10** / תשתית (מאגר `EyalAmit.co.il-2026`)  
**אל:** צוות **50** (QA, בקרה)

---

## 1. מטרה

לאמת שה**תשתית הטכנית** מוכנה לקליטת **תוכן ועץ אתר סופי** מאייל: מאגר, Docker מקומי, פריסת קבצים לסטייג'ינג (כשבוצעה), ותיעוד — **בלי** להחליף את בריף ה־QA המלא של M2 G2 אם הוא עדיין רלוונטי.

---

## 2. בריף QA משני (תשתית) — צ'קליסט

סמנו ☑ / ✗ וצרפו הערות בקובץ דוח: [`M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md`](./M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md) (או העתיקו לשם תאריך ביצוע אחר).

| # | בדיקה | איך לאמת | תוצאה |
|---|--------|-----------|--------|
| Q1 | **`site/wp-content`** במאגר — child `ea-eyalamit` + mu-plugins מתועדים | `bash scripts/verify_m2_g2_repo_artifacts.sh` משורש המאגר | |
| Q2 | **Docker מקומי** — `docker-compose` כולל bind-mount ל־`site/wp-content` | קריאת `local/docker-compose.yml` + `docker compose ps` | |
| Q3 | **WP-CLI** בתמונת `wordpress` | **לפני הבדיקה:** `docker compose build wordpress` (או `bash scripts/verify_local_wp_cli.sh` משורש המאגר). מתוך `local/`: `docker compose exec wordpress /usr/bin/wp --path=/var/www/html --allow-root cli info` — או `wp` אם ב־`PATH`. אם נכשל — `docker compose up -d --force-recreate wordpress` אחרי build. | |
| Q4 | **Xdebug** | `docker compose exec wordpress php -m \| grep -i xdebug` | |
| Q5 | **תיעוד** — runbook **§14** (סביבה מקומית Docker) מעודכן | [`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) | |
| Q6 | **מדיניות מדיה** ננעלה בסיכום 10 | [`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md) §3.2 | |
| Q7 | **סטייג'ינג** — לאחר `ftp_deploy_site_wp_content.py` (אם רץ): תגובת HTTP, תבנית, noindex | `curl -k -sI` + `view-source` / MCP דפדפן | |
| Q8 | **תבנית קליטת תוכן** קיימת | [`M2-CONTENT-INTAKE-FROM-EYAL-2026-04-03.md`](../team_10/M2-CONTENT-INTAKE-FROM-EYAL-2026-04-03.md) | |

---

## 3. המשך מלא M2 G2 (מוצר)

אם סטייג'ינג עדיין ללא ייבוא/תפריטים — להמשיך גם לפי:

- [`M2-G2-QA-BRIEF-FOR-TEAM50-2026-03-29.md`](./M2-G2-QA-BRIEF-FOR-TEAM50-2026-03-29.md)

---

## 4. סיום

לאחר מילוי הטבלה — **חתימת צוות 50** (שם + תאריך) בדוח ה־QA.
