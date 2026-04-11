# M3-QA-2 — ארטיפקט **פריסה מלאה** + אימות סטייג’ינג (צוות **10**)

**תאריך ביצוע:** 2026-04-01  
**בסיס סטייג’ינג:** `https://eyalamit-co-il-2026.s887.upress.link`  
**TLS:** בדיקות עם `curl -kL` לפי [`../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md)

---

## 1. פריסה (FTP — מאגר קנוני)

פקודה (משורש המאגר, עם `local/.env.upress`):

```bash
pip install -r scripts/requirements-upress.txt
python3 scripts/ftp_deploy_site_wp_content.py
```

**עדכון סקריפט (2026-04-01):** `scripts/ftp_deploy_site_wp_content.py` כולל כעת גם:

- `wp-content/mu-plugins/ea-m3-seed-instances-once.php`
- `wp-content/mu-plugins/ea-m2-ia-slug-fixups-once.php`

בנוסף ל־child theme `ea-eyalamit` ושאר ה־MU שכבר היו ברשימה.

**פלט מוצלח (תמצית):** `OK:` לכל קבצי התמה + MU לרבות **`ea-m3-seed-instances-once.php`** — ואז `Done: FTP deploy...`.

---

## 2. טריגר WordPress / זריעת M3

לאחר ה־FTP בוצעו בקשות HTTP ל־`/`, `/faq/`, `/galleries/`, `/media/` — **200** — כדי לאפשר `init`, זריעת אינסטנסים (אופציה `ea_m3_instances_seed_v1`) ורענון כללי.

---

## 3. קודי HTTP לנתיבי שער M3-M3

| נתיב | קוד סופי (`curl -kL`) |
|------|------------------------|
| `/` (דף הבית) | 200 |
| `/faq/` | 200 |
| `/galleries/` | 200 |
| `/media/` | 200 |
| `/faq-item/ea-m3-seed-faq-1/` | 200 |

---

## 4. אימות תוכן חזית (מחרוזות ב־HTML)

| עמוד | ממצא |
|------|------|
| `/faq/` | מופיע `ea-instance-catalog` + קישורים ל־`שאלת דוגמה (M3) — PLACEHOLDER R1` ו־`שאלת דוגמה שנייה — PLACEHOLDER R2` |
| `/galleries/` | מופיע `ea-instance-catalog` + `גלריית דוגמה — PLACEHOLDER R3` / `R4` ותקצירי כרטיס |
| `/media/` | מופיע `ea-instance-catalog` + `המלצת דוגמה — PLACEHOLDER R5` ופריט שני |

---

## 5. שיבוץ (דגימה **Q2-5**)

מדף `/home/`: קישורים ל־`/faq/`, `/galleries/`, `/media/` (פוטר / אזור קישורים) — **200** ליעדים.

---

## 6. תלות שער **Q1-6** / **waiver**

**לא נסגרה במסגרת פריסה זו** — נשארת דרישת מנדט **QA-2** לפני **FINAL** המאשר **M3-M4**; ראו [`M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-01.md`](./M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-01.md) ו־[`M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md`](./M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md).

---

## 7. קישור לבקשת בדיקה לצוות **50**

[`M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-01.md`](./M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-01.md) — **מסירה סופית לבדיקת QA-2** (עודכן לאחר פריסה).

---

## 8. עדכון אחרי **QA-2 FINAL** (2026-04-07)

דוח צוות **50:** [`../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md) — **`PASS WITH NOTES`**; האימותים בסעיפים 3–5 **תואמים** לממצאי הדוח. **שער Q1-6 / waiver: לא התקיים**; **אישור M3-M4: לא**. המשך: [`M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md).

**DOC-SYNC:** [`../team_50/M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md`](../team_50/M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md) — **`PASS`** על מסמך ההגשה החוזרת (ללא ריטסט סטייג’ינג).

---

*צוות 10 — ארטיפקט פריסה ואימות M3-QA-2.*
