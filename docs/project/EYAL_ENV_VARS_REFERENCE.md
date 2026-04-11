# Eyal 2026 — משתני סביבה (ייחוס בלבד)

**אין במאגר קובץ `.env.example`.** מסמך זה הוא מקור הקנוני לשמות משתנים ולערכי placeholder.  
הקבצים האמיתיים נוצרים **מקומית בלבד**: `local/.env` (Docker) ו־`local/.env.upress` (uPress) — שניהם ב־`.gitignore`.

- שמות שדות uPress הקנוניים: [`UPRESS_WORDPRESS_STANDARD_v2.md`](UPRESS_WORDPRESS_STANDARD_v2.md) §12  
- הרחבות פרויקט (FTP, hub): הערות בסעיף 2 למטה

---

## 1. סביבה מקומית (`local/.env`)

העתיקו את הבלוק הבא ל־`local/.env` והתאימו ערכים. **לא לקומיט.**

```dotenv
# Base image for Dockerfile.wordpress (Xdebug layer). MUST match PHP on uPress — team 20 runbook.
WORDPRESS_IMAGE=wordpress:php8.3-apache
# After changing WORDPRESS_IMAGE: docker compose build --no-cache wordpress

# Canonical local bind for this repo: 8088 (see docs/sop/SSOT.md). Do not use ad-hoc ports (e.g. 8080).
WORDPRESS_PORT=8088

MYSQL_DATABASE=wordpress
MYSQL_USER=wordpress
MYSQL_PASSWORD=change-me
MYSQL_ROOT_PASSWORD=change-me-root

# Optional: map repo site/ into container (uncomment in docker-compose when site/wp-content exists)
# SITE_WP_CONTENT_PATH=../site/wp-content
```

---

## 2. uPress (`local/.env.upress`)

העתיקו את הבלוק הבא ל־`local/.env.upress` והשלימו ערכים. **לא לקומיט.**

```dotenv
# Eyal repo extensions (לא כפולים בקובץ v2):
#   UPRESS_FTP_REMOTE_ROOT — מנתיב שורש חשבון FTP לשורש WordPress (שם נמצא wp-config.php). ריק או / אם כבר ב־WP root.
#   UPRESS_FTP_USE_TLS — true ל־FTPS (ברירת מחדל v2 §2.1). בסטייג'ינג אם FTPS נכשל: false + תיעוד ברנבוק.
#   UPRESS_EYAL_HUB_PATH — נתיב יחסי להעלאות hub סטטי (ברירת מחדל ea-eyal-hub).
#
# סטייג'ינג uPress: לבדיקות השתמשו ב־http:// על אותו hostname (אין תעודת SSL ציבורית תקינה כמו בפרודקשן).
# פירוט: docs/CLIENT_HUB_APPENDIX_EYAL.md · _communication/team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md

# ── FTPS / FTP (שמות לפי v2 §12 — SFTP_* היסטורי) ──
UPRESS_SFTP_HOST=ftp.s887.upress.link
UPRESS_SFTP_PORT=21
UPRESS_SFTP_USER=user@example.com
UPRESS_SFTP_PASS=

# ── Eyal: פריסת FTP + TLS ──
UPRESS_FTP_REMOTE_ROOT=
UPRESS_FTP_USE_TLS=true
UPRESS_EYAL_HUB_PATH=ea-eyal-hub

# ── URLs (דוגמת סטייג'ינג) ──
UPRESS_PUBLIC_BASE=http://eyalamit-co-il-2026.s887.upress.link
UPRESS_WP_ADMIN=http://eyalamit-co-il-2026.s887.upress.link/wp-admin
UPRESS_WP_REST_BASE=http://eyalamit-co-il-2026.s887.upress.link/wp-json
UPRESS_PAGE_SLUG=/
UPRESS_UPLOAD_PATH=wp-content/uploads/ea-m2-seed

# ── phpMyAdmin + MySQL (תיעוד / סקריפט סנכרון wp-config) ──
UPRESS_PHPMYADMIN_URL=
UPRESS_DB_NAME=
UPRESS_DB_USER=
UPRESS_DB_PASS=
UPRESS_DB_TABLE_PREFIX=wp_

# ── wp-config.php: WP_ENVIRONMENT_TYPE (WordPress 5.5+) — ברירת מחדל staging לסנדבוקס uPress ──
# https://developer.wordpress.org/apis/wp-config-php/#wp-environment-type
# Allowed: local | development | staging | production
# UPRESS_WP_ENVIRONMENT_TYPE=staging

# ── WordPress admin (אופציונלי) ──
UPRESS_WP_ADMIN_USER=
UPRESS_WP_ADMIN_PASS=

# ── REST API — Application Password (v2 §7) ──
UPRESS_WP_APP_USER=
UPRESS_WP_APP_PASS=
```

---

## 2.1 פרודקשן — אתר legacy ‎`www.eyalamit.co.il`‎ (FTP לשורש WordPress)

**אותו קובץ:** `local/.env.upress` (נשאר ב־`.gitignore` — לא לקומיט).  
**מטרה:** חיבור נפרד מהסטייג'ינג כדי לאפשר סקריפטים / סוכן להעלות תיקוני ליבה, קבצים ב־`wp-includes`, וכו' — בלי לדרוס את פרטי ה־FTP של הסנדבוקס.

### צעדים (בדיוק)

1. פתחו (או צרו) את הקובץ:  
   `EyalAmit.co.il-2026/local/.env.upress`
2. **השאירו** את כל בלוק הסטייג'ינג (`UPRESS_SFTP_*`, …) כפי שהוא.
3. **הדביקו בתחתית הקובץ** את הבלוק הבא, והחליפו ערכים לפי פרטי ה־FTP של **חשבון הפרודקשן** (מסך uPress / מייל אחסון — לא מצ'אט ולא ב־Git):

```dotenv
# ── Eyal: FTP פרודקשן — אתר legacy (eyalamit.co.il) ──
# מנוע הסקריפטים: scripts/upress_ftp_env.py → connect_ftp_legacy_production()
# דוגמה לפריסת תיקון ליבה: python3 scripts/ftp_legacy_deploy_hotfix.py [--dry-run]

EYAL_LEGACY_FTP_HOST=ftp.example.upress.link
EYAL_LEGACY_FTP_PORT=21
EYAL_LEGACY_FTP_USER=
EYAL_LEGACY_FTP_PASS=

# כמו UPRESS_FTP_USE_TLS: true = FTPS (מומלץ uPress); אם חיבור נכשל — false + תיעוד
EYAL_LEGACY_FTP_USE_TLS=true

# מנתיב שורש אחרי התחברות FTP ועד שורש WordPress (שם נמצא wp-config.php).
# אם ההתחברות כבר נכנסת ישירות ל-public_html של האתר — השאירו ריק.
# דוגמאות נפוצות: ריק | public_html | domains/eyalamit.co.il/public_html
EYAL_LEGACY_FTP_REMOTE_ROOT=

# אופציונלי — לאימות HTTP אחרי העלאה
# EYAL_LEGACY_PUBLIC_BASE=https://www.eyalamit.co.il
```

4. שמרו את הקובץ. אימות יבש:  
   `cd EyalAmit.co.il-2026 && pip install -r scripts/requirements-upress.txt && python3 scripts/ftp_legacy_deploy_hotfix.py --dry-run`  
   (אמור להדפיס נתיבים מרוחקים בלי להעלות.)

### הערות

- **שורש מרוחק:** אחרי התחברות ב־FileZilla, בדקו באיזו תיקייה אתם רואים `wp-config.php`. כל השלבים מתחת לנקודה הזו ב־`EYAL_LEGACY_FTP_REMOTE_ROOT` (או ריק אם כבר שם).
- **סטייג'ינג מול פרודקשן:** אל תשתמשו ב־`UPRESS_SFTP_*` לפרודקשן — שני הסטים חייבים להיות עצמאיים כדי למנוע פריסה בטעות לסנדבוקס או להפך.
