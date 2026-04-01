---
name: eyalamit-staging-ftp
description: "Use when editing Eyal Amit staging on uPress via SFTP/FTP from Cursor — extension setup, safe config (no secrets in Git), and when to use scripts vs GUI sync."
---

# סטייג'ינג uPress — עבודה מ־Cursor (FTP/SFTP)

## מתי להשתמש

עריכת קבצים על **סטייג'ינג** (`eyalamit-co-il-2026.s887.upress.link`): תבניות, `wp-config.php`, `mu-plugins`, וכו' — ישירות מהעורך.

## תוסף מומלץ (Cursor = VS Code)

התקנה מ־**Extensions**:

- **[SFTP](https://marketplace.visualstudio.com/items?itemName=Natizyskunk.sftp)** (מפרסם: Natizyskunk) — תומך ב־**SFTP** וגם ב־**FTP** (מתאים ל־uPress כשמוגדר פורט 21).

**למה תוסף ולא "סקיל בלבד":** סקיל לא מחליף לקוח קבצים; התוסף נותן עריכה, השוואה, העלאה/הורדה, ומפה מקומית↔מרוחק בצורה נוחה.

## הגדרה בטוחה (חובה)

1. קובץ קונפיג: **`.vscode/sftp.json`** (או פרופיל שהתוסף תומך בו) — **עם סיסמאות**.
2. הקובץ **ב־`.gitignore`** — כבר מוגדר בפרויקט (`sftp.json`).
3. פרטים מפורטים גם ב־`local/staging.credentials.md` (gitignored) — לשמור עקביות עם מה שהזנת ב־`sftp.json`.

דוגמת מבנה (ערכים אמיתיים **רק** אצלך מקומית):

```json
{
  "name": "Eyal staging uPress",
  "host": "ftp.s887.upress.link",
  "protocol": "ftp",
  "port": 21,
  "username": "…",
  "password": "…",
  "remotePath": "/",
  "uploadOnSave": false
}
```

מומלץ **`uploadOnSave": false`** בתחילה — מעלה רק כשמפעילים פקודה בכוונה (פחות טעויות).

## מתי להשתמש בסקריפט במקום התוסף

- עדכון אוטומטי של **`DB_PASSWORD`** ב־`wp-config.php` לפי `local/staging.credentials.md`:  
  `python3 scripts/ftp_sync_wp_config_db_password.py`

## אימות

- לאחר שמירת `sftp.json`: **Remote Explorer** / פקודת התוסף — חיבור ובדיקת רשימת קבצים.
- אם **530** — לעדכן סיסמת FTP בפאנל uPress ובקונפיג.

## כשלים

| תסמין | פעולה |
|--------|--------|
| 530 Login incorrect | סנכרון סיסמה מול פאנל uPress + `staging.credentials.md` |
| timeout | חסימת רשת; לנסות מרשת אחרת או VPN |

## קישורי פרויקט

- `local/README.md` — Docker + סקריפט FTP  
- `_communication/team_20/CREDENTIALS-HANDOFF-SECURE-2026-03-31.md` — העברת סודות  
- `_communication/team_20/DB-AND-PHPMYADMIN-WORKFLOW-2026-03-31.md` — DB / wp-config
