# סביבה מקומית — Docker

**סדר עבודה (צוות 100):** קודם **מקומי תחת Docker**; **סטייג'ינג ייעודי ב־uPress** נפתח **אחרי** שיש בסיס מקומי יציב לדחיפה / שכפול ארטיפקטים.

## קבצים

| קובץ | תיאור |
|------|--------|
| `docker-compose.yml` | WordPress + MariaDB; בנייה מ־`Dockerfile.wordpress` |
| `Dockerfile.wordpress` | שכבת **Xdebug 3** + **WP-CLI** מעל `WORDPRESS_IMAGE` (ברירת מחדל PHP 8.3) |
| `xdebug.ini` | הגדרות Xdebug לדיבוג מקומי בלבד |
| (אין `.env.example`) | משתני סביבה מתועדים ב־[`docs/project/EYAL_ENV_VARS_REFERENCE.md`](../docs/project/EYAL_ENV_VARS_REFERENCE.md): **§1** → `local/.env`, **§2** → `local/.env.upress`, **§2.1** → FTP פרודקשן legacy (`EYAL_LEGACY_*`). ראו גם [`UPRESS_WORDPRESS_STANDARD_v2.md`](../docs/project/UPRESS_WORDPRESS_STANDARD_v2.md) |

## גרסת PHP — חובה ליישר ל־uPress

תג התמונה ב־`WORDPRESS_IMAGE` חייב להתאים לגרסת PHP שצוות **20** מתעד ב־runbook מול **uPress**. דוגמה: `wordpress:php8.3-apache` (ב־[`EYAL_ENV_VARS_REFERENCE.md`](../docs/project/EYAL_ENV_VARS_REFERENCE.md) §1; בפאנל זמינות לפחות 7.4 / 8.3 / 8.4 — ראו [`UPRESS-STAGING-SITE-RECORD-2026-03-31.md`](../_communication/team_20/UPRESS-STAGING-SITE-RECORD-2026-03-31.md)).

## דוא"ל

**אין** הגדרת SMTP/דוא"ל במקומי לפרויקט זה — נדחה לשלב שבו יש שרת; ראו [`docs/project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md`](../docs/project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md) §5.

## סודות

- `.env` (דוקר) — ב־`.gitignore`; אל תכניסו סיסמאות למאגר.
- **סטייג'ינג uPress / FTP / REST:** הנוהל הארגוני המחייב — [`docs/project/UPRESS_WORDPRESS_STANDARD_v2.md`](../docs/project/UPRESS_WORDPRESS_STANDARD_v2.md).  
  - **גלישה בסטייג'ינג:** אין SSL ציבורי תקין כמו בפרודקשן — בדפדפן וב־`curl` העדיפו **`http://`** לפי [`docs/project/EYAL_ENV_VARS_REFERENCE.md`](../docs/project/EYAL_ENV_VARS_REFERENCE.md) §2 ו־[`docs/CLIENT_HUB_APPENDIX_EYAL.md`](../docs/CLIENT_HUB_APPENDIX_EYAL.md).  
  - צור **`local/.env.upress`** לפי §2 ב־[`EYAL_ENV_VARS_REFERENCE.md`](../docs/project/EYAL_ENV_VARS_REFERENCE.md) (ב־`.gitignore`).  
  - סקריפטי FTP דורשים: `pip install -r scripts/requirements-upress.txt`.  
- מדריך העברת סודות מאובטחת (עקרונות): [`_communication/team_20/CREDENTIALS-HANDOFF-SECURE-2026-03-31.md`](../_communication/team_20/CREDENTIALS-HANDOFF-SECURE-2026-03-31.md).  
- רישום גישות — [`_communication/team_20/`](../_communication/team_20/).

## עריכת קבצים על הסטייג'ינג מ־Cursor (מומלץ)

1. התקן תוסף **[SFTP](https://marketplace.visualstudio.com/items?itemName=Natizyskunk.sftp)** (תומך גם ב־FTP לפורט 21, כמו אצל uPress).
2. צור **`.vscode/sftp.json`** לפי הדוגמה ב־[`.cursor/skills/eyalamit-staging-ftp/SKILL.md`](../.cursor/skills/eyalamit-staging-ftp/SKILL.md) — הקובץ **ב־`.gitignore`** (לא עולה ל-Git).
3. פירוט סקיל: `eyalamit-staging-ftp`.

## סנכרון `wp-config.php` (סיסמת DB) לסטייג'ינג ב־FTP

אם שינית סיסמת MySQL בפאנל — לעדכן גם ב־`wp-config.php` בשרת. מהשורש של המאגר (אחרי ש־`local/.env.upress` מעודכן ו־FTP עובד):

`python3 scripts/ftp_sync_wp_config_db_password.py`

## REST API — אימות Application Password (v2 §7)

אחרי מילוי `UPRESS_WP_REST_BASE`, `UPRESS_WP_APP_USER`, `UPRESS_WP_APP_PASS` ב־`.env.upress`:

`pip install -r scripts/requirements-upress.txt && python3 scripts/verify_upress_rest.py`

## הרצה

```bash
cd local
# צור .env — העתק מ־docs/project/EYAL_ENV_VARS_REFERENCE.md §1 והתאם סיסמאות DB
docker compose build --no-cache wordpress
docker compose up -d --force-recreate wordpress
```

**אחרי `git pull` שמשנה `Dockerfile.wordpress` או תג `image` ב־`docker-compose.yml`:** חובה `docker compose build --no-cache wordpress` ואז `docker compose up -d --force-recreate wordpress` — אחרת עשוי להישאר **קונטיינר ישן** על תמונה בלי WP-CLI. **אימות Q3 (צוות 50):** משורש המאגר — `bash scripts/verify_local_wp_cli.sh` (בונה תמונה ובודק `wp --info` בלי DB). בתוך `local/` אחרי `up`: `docker compose exec wordpress /usr/bin/wp --path=/var/www/html --allow-root cli info` (גם `/usr/local/bin/wp` קיים).

כתובת ברירת מחדל: `http://localhost:8088` (מיושר ל־SSOT ולהקצאת הפורטים של הפרויקט; ניתן לשנות `WORDPRESS_PORT` ב־`.env` רק אם הפורט תפוס — לא לבחור פורט שרירותי).

**מיפוי `wp-content`:** ב־`docker-compose.yml` מופעל כברירת מחדל **`../site/wp-content` → `/var/www/html/wp-content`** — עריכה ב־מאגר משתקפת מיד בקונטיינר (תמה child, mu-plugins). אחרי שינוי ב־compose: `docker compose up -d`.

**שינוי `WORDPRESS_IMAGE` ב־`.env`:** להריץ מחדש `docker compose build --no-cache wordpress` כדי לבנות שכבת Xdebug + WP-CLI על בסיס התמונה החדשה. **בניית התמונה נכשלת** אם הורדת ה־phar של WP-CLI נכשלה — בשלב ה־`RUN` ב־Dockerfile מופעל `wp --info` לאימות.

## WP-CLI (בתוך הקונטיינר)

WP-CLI מותקן ב־`/usr/local/bin/wp` **ובקישור** ל־`/usr/bin/wp` (חלק מסביבות `exec` עם `PATH` מצומצם לא מוצאים את `local`).

דוגמאות (אחרי `docker compose up -d`; מהתיקייה `local/`):

```bash
docker compose exec wordpress /usr/bin/wp --path=/var/www/html --allow-root core version
docker compose exec wordpress /usr/bin/wp --path=/var/www/html --allow-root plugin list
```

ייבוא WXR מקומי (אחרי העתקת הקובץ לקונטיינר או mount נתיב):

```bash
docker compose exec wordpress /usr/bin/wp --path=/var/www/html --allow-root import /path/to/file.wxr --authors=create
```

(הנתיב לקובץ חייב להיות נגיש מתוך הקונטיינר — למשל העתקה ל־`/tmp` או volume.)

## PHP Debug (Cursor / VS Code) + Xdebug

1. **הרחבה:** PHP Debug (מותקנת לפי `.vscode/extensions.json`).  
2. **הקונטיינר** כולל Xdebug (פורט **9003**, `client_host=host.docker.internal`; ב־Compose מוגדר `extra_hosts: host-gateway`).  
3. **מיפוי קבצים:** ברירת המחדל במאגר — bind-mount ל־`site/wp-content`; ב־Cursor: **Run and Debug** → **Listen for Xdebug (PHP)** (מ־[`.vscode/launch.json`](../.vscode/launch.json)).  
4. לפתוח דף ב־`http://localhost:8088` — נקודות עצירה ב־PHP תחת `wp-content` אמורות להתאים לקבצי המאגר.  
5. אם הוסר ה־bind-mount — להשתמש בתצורה **Listen for Xdebug (PHP, no path map)**.

פירוט תקן עורך: [`docs/sop/AGENT-WORKSPACE-STANDARD.md`](../docs/sop/AGENT-WORKSPACE-STANDARD.md) §3.5.

## Cursor — הרחבות מומלצות (לא Docker)

רשימת ההרחבות לעורך נמצאת ב־**`../.vscode/extensions.json`** (שורש המאגר). הוראות התקנה צעד־אחר־צעד: [`docs/sop/AGENT-WORKSPACE-STANDARD.md`](../docs/sop/AGENT-WORKSPACE-STANDARD.md) §3.1–3.2.
