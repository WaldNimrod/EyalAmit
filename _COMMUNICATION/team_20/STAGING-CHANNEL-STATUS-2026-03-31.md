# סטייג'ינג — סטטוס ערוצים

**URL:** `https://eyalamit-co-il-2026.s887.upress.link`  
**עדכון אחרון:** 2026-04-02 (מדיניות TLS סטייג'ינג מול פרודקשן)

**כלל מחייב:** בסטייג'ינג — SSL תקין **לא מותקן**. **באתר הסופי** (אחרי סטייג'ינג) — עבודה **רק** עם SSL תקין — [`STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](./STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md).

| ערוץ | סטטוס |
|------|--------|
| **TLS סטייג'ינג** | לפי פאנל: **אין** SSL תקין ציבורי כמו בפרודקשן — עבודה לפי [`STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](./STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md); אימות טכני ישן: [`M2-GATE-20A-TLS-VERIFICATION-2026-04-02.md`](./M2-GATE-20A-TLS-VERIFICATION-2026-04-02.md) |
| **HTTPS / אתר (סטייג'ינג)** | ⚠️ צפוי אי-התאמת תעודה / אזהרת דפדפן — **מקובל** למסלול זה; **לא** מייצג את פרודקשן |
| **FTP (פורט 21)** | ✅ התחברות תקינה (אחרי עדכון סיסמה בפאנל וב־**`local/.env.upress`**) |
| **wp-admin** | ✅ לבדיקה ידנית: `/wp-admin` / `wp-login.php` |
| **phpMyAdmin** | לא אומת אוטומטית — להוסיף `UPRESS_PHPMYADMIN_URL` ב־**`.env.upress`** כשצריך |
| **G1 → G2** | ☑ גיבוי uPress לפני G2 · ☑ מנדט הועבר ל־10 — [`../team_10/M2-HANDOFF-FROM-20-2026-03-31.md`](../team_10/M2-HANDOFF-FROM-20-2026-03-31.md) |
| **G2 ארטיפקטי Git** | סיכום 10: [`../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md) · אימות 20/100: [`M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md`](./M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md) |
| **סטייג'ינג חי (2026-04-01)** | דיווח 10: תמה עדיין **Twenty Twenty-Five**; **noindex** אחרי העלאת mu-plugin; **HTTPS** — מסלול סטייג'ינג לפי מדיניות חשבון (לא כמו פרודקשן) |

## מה תוקן בדרך

1. **סיסמת FTP** — עודכנה ב־uPress ובקובץ המקומי.  
2. **באג בסקריפט סנכרון:** גרסה קודמת ניסתה לקרוא `password:` מהקובץ ותפסה בטעות את `**` מ־`**Password:**` (FTP), והחליפה את `DB_PASSWORD` ב־`**`.  
3. **סקריפט מעודכן:** קריאת DB רק משורת `DB: … user: … password: …` + סנכרון `DB_NAME` / `DB_USER` / `DB_PASSWORD`.  
   פקודה: `pip install -r scripts/requirements-upress.txt && python3 scripts/ftp_sync_wp_config_db_password.py`

## קישורים

- סקריפט: [`scripts/ftp_sync_wp_config_db_password.py`](../../scripts/ftp_sync_wp_config_db_password.py)  
- סודות: **`local/.env.upress`** (לא ב־Git) · [`UPRESS_WORDPRESS_STANDARD_v2.md`](../../docs/project/UPRESS_WORDPRESS_STANDARD_v2.md)
