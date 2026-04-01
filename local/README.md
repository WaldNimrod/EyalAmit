# סביבה מקומית — Docker

**סדר עבודה (צוות 100):** קודם **מקומי תחת Docker**; **סטייג'ינג ייעודי ב־uPress** נפתח **אחרי** שיש בסיס מקומי יציב לדחיפה / שכפול ארטיפקטים.

## קבצים

| קובץ | תיאור |
|------|--------|
| `docker-compose.yml` | WordPress + MariaDB; נפחים לפיתוח |
| `.env.example` | דוגמה — **העתק ל־`.env`** (לא ב־commit) |

## גרסת PHP — חובה ליישר ל־uPress

תג התמונה ב־`WORDPRESS_IMAGE` חייב להתאים לגרסת PHP שצוות **20** מתעד ב־runbook מול **uPress**. דוגמה ב־`.env.example`: `wordpress:php8.3-apache` (בפאנל זמינות לפחות 7.4 / 8.3 / 8.4 — ראו [`UPRESS-STAGING-SITE-RECORD-2026-03-31.md`](../_communication/team_20/UPRESS-STAGING-SITE-RECORD-2026-03-31.md)).

## דוא"ל

**אין** הגדרת SMTP/דוא"ל במקומי לפרויקט זה — נדחה לשלב שבו יש שרת; ראו [`docs/project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md`](../docs/project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md) §5.

## סודות

- `.env` — ב־`.gitignore`; אל תכניסו סיסמאות למאגר.  
- **סטייג'ינג (FTP / wp-admin):** תבנית [`staging.credentials.example.md`](./staging.credentials.example.md) → העתק ל־`staging.credentials.md` (ב־`.gitignore`). מדריך העברה מאובטחת: [`_communication/team_20/CREDENTIALS-HANDOFF-SECURE-2026-03-31.md`](../_communication/team_20/CREDENTIALS-HANDOFF-SECURE-2026-03-31.md).  
- רישום גישות — [`_communication/team_20/`](../_communication/team_20/).

## עריכת קבצים על הסטייג'ינג מ־Cursor (מומלץ)

1. התקן תוסף **[SFTP](https://marketplace.visualstudio.com/items?itemName=Natizyskunk.sftp)** (תומך גם ב־FTP לפורט 21, כמו אצל uPress).
2. צור **`.vscode/sftp.json`** לפי הדוגמה ב־[`.cursor/skills/eyalamit-staging-ftp/SKILL.md`](../.cursor/skills/eyalamit-staging-ftp/SKILL.md) — הקובץ **ב־`.gitignore`** (לא עולה ל-Git).
3. פירוט סקיל: `eyalamit-staging-ftp`.

## סנכרון `wp-config.php` (סיסמת DB) לסטייג'ינג ב־FTP

אם שינית סיסמת MySQL בפאנל — לעדכן גם ב־`wp-config.php` בשרת. מהשורש של המאגר (אחרי ש־`local/staging.credentials.md` מעודכן ו־FTP עובד):

`python3 scripts/ftp_sync_wp_config_db_password.py`

## הרצה

```bash
cd local
cp .env.example .env
# ערוך .env — סיסמאות DB וכו'
docker compose up -d
```

כתובת ברירת מחדל: `http://localhost:8080` (ניתן לשנות ב־`.env`).
