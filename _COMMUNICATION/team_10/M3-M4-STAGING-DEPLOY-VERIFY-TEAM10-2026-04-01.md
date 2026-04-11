# M3-M4 — ארטיפקט **פריסה** + אימות סטייג’ינג (צוות **10**)

**תאריך ביצוע:** 2026-04-01  
**בסיס סטייג’ינג:** `https://eyalamit-co-il-2026.s887.upress.link`  
**TLS:** בדיקות עם `curl -kL` / `curl -sk` לפי [`../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md)

---

## 1. פריסה (FTP — מאגר קנוני)

פקודה (משורש המאגר, עם `local/.env.upress`):

```bash
pip install -r scripts/requirements-upress.txt
python3 scripts/ftp_deploy_site_wp_content.py
```

**פלט מוצלח (תמצית):** `OK:` לכל קבצי child `ea-eyalamit` (כולל `style.css` גרסה **1.3.0**, `functions.php`) + MU-plugins — ואז `Done: FTP deploy...`.

---

## 2. קודי HTTP — דגימות **QA-M4** (5 עמודים)

| נתיב | קוד (`curl -sk -o /dev/null -w "%{http_code}"`) |
|------|--------------------------------------------------|
| `/` | 200 |
| `/sound-healing/` | 200 |
| `/galleries/` | 200 |
| `/privacy/` | 200 |
| `/faq/` | 200 |

---

## 3. אימות מחלקת גוף (M3-M4)

| עמוד | ממצא |
|------|------|
| `/privacy/` | מופיעה מחלקת גוף `ea-m4-polish` (ליטוש תוכן פנימי) |
| `/` (דף בית dashboard) | `ea-home-dashboard` — **ללא** `ea-m4-polish` (הפרדה מכוונת מול סגנון הבית) |

---

## 4. קישורים

- מנדט ביצוע: [`M3-M4-VISUAL-POLISH-MANDATE-TEAM10-2026-04-08.md`](./M3-M4-VISUAL-POLISH-MANDATE-TEAM10-2026-04-08.md)  
- בקשת מוכנות ל־50: [`M3-QA-M4-READINESS-REQUEST-TEAM10-2026-04-01.md`](./M3-QA-M4-READINESS-REQUEST-TEAM10-2026-04-01.md)  
- Runbook סביבה: [`../team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md)

---

*צוות 10 — ארטיפקט פריסה M3-M4 (2026-04-01).*
