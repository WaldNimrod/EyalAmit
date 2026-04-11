# M3-M4 — ארטיפקט **פריסה** + אימות אחרי תיקוני QA-M4 (צוות **10**)

**תאריך ביצוע:** 2026-04-07  
**גרסת תמה:** `ea-eyalamit` **1.3.1**  
**בסיס סטייג’ינג:** `https://eyalamit-co-il-2026.s887.upress.link`

---

## 1. פריסה

```bash
python3 scripts/ftp_deploy_site_wp_content.py
```

**תוצאה:** `Done: FTP deploy...` (child + MU לפי סקריפט).

---

## 2. קודי HTTP — סקופ READINESS + `/en/`

| נתיב | קוד (`curl -sk -o /dev/null -w "%{http_code}"`) |
|------|--------------------------------------------------|
| `/` | 200 |
| `/sound-healing/` | 200 |
| `/galleries/` | 200 |
| `/privacy/` | 200 |
| `/faq/` | 200 |
| `/en/` | 200 |

---

## 3. אימות HTML (דגימה)

| בדיקה | ממצא |
|--------|------|
| `/en/` — `body` | מחלקות כוללות `ea-lang-en`, `ltr`, `ea-m4-polish` — **ללא** `rtl` |
| `/en/` — `html` | `lang="en"` `dir="ltr"` (ללא שינוי) |
| `:root` כפול | בלוק GP cached מכיל `--accent:#1e73be`; בלוק inline של child **אחריו** מגדיר `--accent:var(--eyal-terracotta)` וכו׳ |

---

## 4. קישורים

- הגשה חוזרת: [`M3-QA-M4-READINESS-RESUBMISSION-TEAM10-2026-04-07.md`](./M3-QA-M4-READINESS-RESUBMISSION-TEAM10-2026-04-07.md)  
- דוח QA-M4: [`../team_50/M3-QA-M4-VISUAL-NOTE-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-M4-VISUAL-NOTE-REPORT-TEAM50-2026-04-07.md)

---

*צוות 10 — אימות פריסה אחרי 1.3.1.*
