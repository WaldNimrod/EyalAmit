# סטייג'ינג — סטטוס ערוצים

**URL:** `https://eyalamit-co-il-2026.s887.upress.link`  
**עדכון אחרון:** 2026-03-31 (גיבוי לפני G2 בוצע; מנדט G2 הועבר לצוות 10)

| ערוץ | סטטוס |
|------|--------|
| **HTTPS / אתר** | ✅ WordPress נטען (דף בית RTL, כותרת אתר) |
| **FTP (פורט 21)** | ✅ התחברות תקינה (אחרי עדכון סיסמה בפאנל וב־`staging.credentials.md`) |
| **wp-admin** | ✅ לבדיקה ידנית: `/wp-admin` / `wp-login.php` |
| **phpMyAdmin** | לא אומת אוטומטית — להוסיף URL ב־`staging.credentials.md` כשצריך |
| **G1 → G2** | ☑ גיבוי uPress לפני G2 · ☑ מנדט הועבר ל־10 — [`../team_10/M2-HANDOFF-FROM-20-2026-03-31.md`](../team_10/M2-HANDOFF-FROM-20-2026-03-31.md) |
| **G2 ארטיפקטי Git** | סיכום 10: [`../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md) · אימות 20/100: [`M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md`](./M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md) |
| **סטייג'ינג חי (2026-04-01)** | דיווח 10: תמה עדיין **Twenty Twenty-Five**; **noindex** אחרי העלאת mu-plugin; **SSL** — תעודה שפגה (טיפול 20) |

## מה תוקן בדרך

1. **סיסמת FTP** — עודכנה ב־uPress ובקובץ המקומי.  
2. **באג בסקריפט סנכרון:** גרסה קודמת ניסתה לקרוא `password:` מהקובץ ותפסה בטעות את `**` מ־`**Password:**` (FTP), והחליפה את `DB_PASSWORD` ב־`**`.  
3. **סקריפט מעודכן:** קריאת DB רק משורת `DB: … user: … password: …` + סנכרון `DB_NAME` / `DB_USER` / `DB_PASSWORD`.  
   פקודה: `python3 scripts/ftp_sync_wp_config_db_password.py`

## קישורים

- סקריפט: [`scripts/ftp_sync_wp_config_db_password.py`](../../scripts/ftp_sync_wp_config_db_password.py)  
- סודות: `local/staging.credentials.md` (לא ב־Git)
