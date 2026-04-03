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

# Default 9090 — aligns with docs/sop/SSOT.md (avoids clash with other stacks on 8080)
WORDPRESS_PORT=9090

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
