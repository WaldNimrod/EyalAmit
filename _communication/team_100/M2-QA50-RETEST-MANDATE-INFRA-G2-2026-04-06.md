# מנדט לצוות 50 — ריטסט ממוקד (תשתית Q3 + G2: contact + מטמון `/`)

**תאריך:** 2026-04-06  
**מוציא:** צוות **100**  
**נמען:** צוות **50** (QA)

**רקע:** דוחות ריטסט — [`../team_50/M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md`](../team_50/M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md) (Q3 FAIL), [`../team_50/M2-G2-QA-RETEST-TEAM50-2026-04-02.md`](../team_50/M2-G2-QA-RETEST-TEAM50-2026-04-02.md) (FAIL — BUG-06, BUG-07, BUG-08).

---

## 1. מה תוקן במאגר (יישום 100 + ארטיפקטים לפריסה)

| נושא | פעולה |
|------|--------|
| **Q3 WP-CLI** | `Dockerfile.wordpress`: קישור `ln -sf` ל־`/usr/bin/wp`; אימות `wp --info` דרך הנתיב הזה. `docker-compose`: תג תמונה `eyalamit-local-wp:xdebug-wpcli-v3`. סקריפט: [`scripts/verify_local_wp_cli.sh`](../../scripts/verify_local_wp_cli.sh). תיעוד: [`local/README.md`](../../local/README.md), [`M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md`](../team_50/M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md) Q3, runbook §14. |
| **BUG-06 Fluent** | [`site/wp-content/mu-plugins/ea-m2-ensure-fluent-active.php`](../../site/wp-content/mu-plugins/ea-m2-ensure-fluent-active.php) **v1.0.1** — על `*.upress.link`: גילוי תיקיית Fluent, עדכון `active_plugins`, `require_once`, והוק `activate_{$plugin}` (לא `silent` — נדרש ל־Fluent). בנוסף: [`ea-m2-seed-shell-once.php`](../../site/wp-content/mu-plugins/ea-m2-seed-shell-once.php) **v1.0.4**. אם אין טופס **id=1** — ליצור ב־wp-admin או לעדכן shortcode. |
| **BUG-07 מטמון `/`** | [`site/wp-content/mu-plugins/ea-staging-noindex.php`](../../site/wp-content/mu-plugins/ea-staging-noindex.php) **v1.0.2** — `nocache_headers()` + `DONOTCACHEPAGE` על `*.upress.link` (חזית), כדי לצמצם HTML stale בקצה; אם נשאר stale — purge ב־uPress. |

**פריסה לסטייג'ינג (10):** `python3 scripts/ftp_deploy_site_wp_content.py` (מעלה את כל ה־MU כולל `ea-staging-noindex` ו־`ea-m2-seed-shell-once`).

---

## 2. צ'קליסט ריטסט ממוקד לצוות 50

### 2.1 תשתית (Q3)

1. `git pull` · משורש המאגר: `bash scripts/verify_local_wp_cli.sh` — צפוי `OK` ופלט `WP-CLI version`.
2. מתוך `local/`: `docker compose up -d --force-recreate wordpress` (אם כבר בניתם).
3. `docker compose exec wordpress /usr/bin/wp --path=/var/www/html --allow-root cli info` — יציאה 0.

### 2.2 G2 (סטייג'ינג)

1. `curl -k -s` ל־`/contact/` — אימות **מרנדר טופס** Fluent (אלמנטי טופס), לא טקסט גולמי של shortcode. **אם** מופיע `[fluentform` גולמי **בלי** query אבל `curl -k -s '/contact/?cb=<timestamp>'` מציג `ff-el-form` / שדות — זו **תוצאת מטמון דף מלא** (EzCache/Varnish); לבצע **purge** לפי runbook P4 ולא לסגור כ־«תוסף כבוי».
2. `curl -k -sI` ל־`/` — לוודא כותרות `Cache-Control` / `no-cache` או דומה (אם uPress מתעלם — לתעד).
3. `curl -k -s` ל־`/` **בלי** `qa_retest` — גוף הדף: `page-id` של עמוד **בית** (לא `home blog` + Hello world).

אם **2.2(3)** עדיין stale אחרי פריסת MU — **BUG יתועד לצוות 20 / uPress**: ניקוי מטמון שכבת רשת; ה־MU מצמצם אך לא מבטיח Varnish חיצוני.

---

## 3. פלט צפוי

- עדכון דוח תשתית (Q3 ☑ אם עבר) ודוח G2 ריטסט (או דוח קצר חדש) — ב־`team_50/`.

**חתימת צוות 100:** 2026-04-06
