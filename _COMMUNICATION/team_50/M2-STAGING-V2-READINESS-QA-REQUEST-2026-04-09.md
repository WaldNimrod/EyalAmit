# בקשת QA — מוכנות סטייג'ינג אחרי **UPRESS_WORDPRESS_STANDARD v2** (צוות **50**)

**תאריך:** 2026-04-09  
**מוציא:** צוות **10** / תשתית (מאגר `EyalAmit.co.il-2026`)  
**אל:** צוות **50** (QA, בקרה)

---

## 1. הקשר

המאגר עבר לנוהל ארגוני קנוני: [`docs/project/UPRESS_WORDPRESS_STANDARD_v2.md`](../../docs/project/UPRESS_WORDPRESS_STANDARD_v2.md).  
סודות סטייג'ינג/FTP/REST נשמרים ב־**`local/.env.upress`** (לא ב־Git); ייחוס שדות: [`docs/project/EYAL_ENV_VARS_REFERENCE.md`](../../docs/project/EYAL_ENV_VARS_REFERENCE.md) §2.

**מטרה:** לאשר **מוכנות מפורשת לקליטת תוכן** אחרי שהפריסה, ה־hub, ה־REST והדפדפן עומדים בצ'קליסט למטה.

**הרצת סקריפטים:** מחזיק המאגר (רשת מקומית מותרת ל־uPress). לפני כל פריסה: `pip install -r scripts/requirements-upress.txt`.

---

## 2. פריסת `site/wp-content` (FTP / FTPS)

| # | בדיקה | איך לאמת | תוצאה |
|---|--------|-----------|--------|
| D1 | **`--dry-run`** | משורש המאגר: `python3 scripts/ftp_deploy_site_wp_content.py --dry-run` — לוודא רשימת קבצים סבירה | |
| D2 | העלאה אמיתית | `python3 scripts/ftp_deploy_site_wp_content.py` (ללא dry-run) | |
| D3 | **TLS** | `UPRESS_FTP_USE_TLS` ב־`.env.upress`: `true` = FTPS (ברירת מחדל v2); אם סטייג'ינג דורש חריג — `false` **רק** אם מתועד ב־runbook ([`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md)) | |
| D4 | קבצים קריטיים בשרת | דרך FTP/SFTP או פאנל: child `ea-eyalamit`, `mu-plugins` צפויים קיימים תחת `wp-content` | |

---

## 3. Hub סטטי (`ea-eyal-hub`)

**גלישה בסטייג'ינג:** אין SSL ציבורי תקין על sandbox — בדיקות דפדפן/MCP ב־**`http://<staging-host>/ea-eyal-hub/…`**. בפרודקשן — רק HTTPS. ראו [`docs/CLIENT_HUB_APPENDIX_EYAL.md`](../../docs/CLIENT_HUB_APPENDIX_EYAL.md).

| # | בדיקה | איך לאמת | תוצאה |
|---|--------|-----------|--------|
| H1 | בנייה | `python3 scripts/build_eyal_client_hub.py` | |
| H2 | פריסה | `python3 scripts/ftp_publish_eyal_client_hub.py --dry-run` ואז בלי dry-run | |
| H3 | דפדפן | `index.html`, `tasks.html`, `roadmap.html` (`pending.html` מפנה ל־`tasks.html`) — URL תחת `UPRESS_EYAL_HUB_PATH` (ברירת מחדל `ea-eyal-hub`) | |
| H4 | צפיית Hub | לפי נוהל Hub v1.1 — **ללא** דרישת Basic Auth לצפייה בתוכן ה־Hub; לאמת שהעמודים נטענים ישירות | |

---

## 4. REST API (Application Password — v2 §7)

| # | בדיקה | איך לאמת | תוצאה |
|---|--------|-----------|--------|
| R1 | משתני סביבה | `UPRESS_WP_REST_BASE`, `UPRESS_WP_APP_USER`, `UPRESS_WP_APP_PASS` מלאים ב־`.env.upress` (ללא הנחת `www` על דומיין סטייג'ינג אם כך מתועד) | |
| R2 | Smoke | `python3 scripts/verify_upress_rest.py` — אמור להדפיס OK עבור `users/me?context=edit` | |
| R3 | חלופה ידנית | `curl` עם Basic Auth ל־`/wp-json/wp/v2/users/me?context=edit` או ל־`/wp-json/wp/v2/pages` | |

---

## 5. דפדפן — דפים לקליטת תוכן

| # | בדיקה | הערות | תוצאה |
|---|--------|--------|--------|
| B1 | דף בית, בלוג | לפי מטריצת M2 / אפיון צוות 10 | |
| B2 | עמודי מעטפת | תבניות/מבנה לפי תכנון נוכחי | |
| B3 | טופס צור קשר / Fluent Forms | אם בתוך ההיקף המאושר — שליחה/ולידציה בסיסית | |

---

## 6. מטמון (v2 §13 + מדיניות קיימת)

| # | בדיקה | איך לאמת | תוצאה |
|---|--------|-----------|--------|
| C1 | ניקוי מטמון | לפי v2 §13: EzCache אם מותקן, או פאנל uPress / תוסף מטמון — אחרי פריסה משמעותית | |
| C2 | רענון צפייה | רענון קשיח / חלון פרטי אחרי purge | |

---

## 7. TLS סטייג'ינג

**כלל:** אזהרת דפדפן על תעודה בסטייג'ינג **בלבד** — **לא** לחסום GO לבד מכך; עקביות עם [`STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md) ו־[`STAGING-CHANNEL-STATUS-2026-03-31.md`](../team_20/STAGING-CHANNEL-STATUS-2026-03-31.md). לתעד התנהגות בדוח.

---

## 8. תוצאה נדרשת

דוח **PASS / ממצאים** עם:

1. טבלאות למעלה ממולאות (☑ / ✗ + הערות).  
2. משפט מפורש: **«מוכנים לקליטת תוכן»** או רשימת חסמים עם בעלים.

**המלצה לשם קובץ דוח:** `M2-STAGING-V2-READINESS-QA-REPORT-TEAM50-2026-04-09.md` (או תאריך ביצוע עדכני).

---

## 9. קישורים

- נוהל קנוני: [`UPRESS_WORDPRESS_STANDARD_v2.md`](../../docs/project/UPRESS_WORDPRESS_STANDARD_v2.md)  
- פריסת אתר: [`site/README.md`](../../site/README.md)  
- Hub: [`hub/README.md`](../../hub/README.md) · נוהל SSOT: [`hub/EYAL-HUB-SSOT-WORKFLOW.md`](../../hub/EYAL-HUB-SSOT-WORKFLOW.md)  
- בקשת QA תשתית קודמת (השלימו אם עדיין פתוח): [`M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md`](./M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md)
