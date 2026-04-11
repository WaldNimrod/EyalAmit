# M3-M3 — רשימת ביצוע סטייג’ינג: אינסטנסים (צוות **10**)

**תאריך:** 2026-04-01  
**מנדט:** [`M3-M3-INSTANCES-MANDATE-TEAM10-2026-04-08.md`](./M3-M3-INSTANCES-MANDATE-TEAM10-2026-04-08.md)  
**סביבה:** [`../team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) · TLS: [`../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md)

**סטטוס ביצוע (2026-04-01):** שורות **A–C** ו־**D3** — בוצעו (FTP מלא + אימות HTTP/HTML); ראו [`M3-QA-2-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md`](./M3-QA-2-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md). **D1–D2** — מטריצה ומיפוי גלריות להמשך אכלוס legacy.

### קליטת דוח **QA-2 FINAL** (צוות **50**, 2026-04-07)

**מקור:** [`../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md) · **`PASS WITH NOTES`** · **Q1-6 / waiver: לא התקיים** · **אישור M3-M4: לא מאושר עדיין**.

| פריט checklist | קליטה ב־50 | הערה |
|----------------|------------|------|
| **A–C** | **תואם למסירה** | `/faq/`, `/galleries/`, `/media/`, `/faq-item/ea-m3-seed-faq-1/` **200**; REST ל־`ea_*` פעיל |
| **D3** | **נקלט** | בקשת QA-2 פורסמה |
| **D1–D2** | **פתוח להמשך** | טבלת מיפוי גלריות ריקה; מלאי **DRAFT**; אין מדיה אמיתית לדגימת משקל/**alt** |
| שער **Q1-6** | **לא הושלם** | יומן **100** ללא סגירה או **waiver** — חוסם אישור **M3-M4** |

**תיקון והגשה חוזרת (צוות 10):** [`M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md).

**DOC-SYNC (צוות 50):** [`../team_50/M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md`](../team_50/M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md) — **`PASS`** (אימות תיעודי בלבד; ללא שינוי בפסק דין **QA-2** הפונקציונלי).

---

## A — פריסת קוד

| # | פעולה | ✓ |
|---|--------|---|
| A1 | Deploy מאגר — child theme `ea-eyalamit` (גרסה ≥ **1.2.0**) | |
| A2 | וידוא MU פעיל: `ea-m3-seed-instances-once.php` | |
| A3 | אם הזריעה לא רצה: מחיקת אופציה `ea_m3_instances_seed_v1` וטעינת דף חזית אחת **או** `wp rewrite flush` | |

---

## B — עמודי שער

| # | צומת | נתיב | ציפייה |
|---|------|------|--------|
| B1 | `st-faq` | `/faq/` | מבוא + רשימת `ea_faq` (או ריק + תיעוד חריג) |
| B2 | `st-galleries-catalog` | `/galleries/` | מבוא + רשימת `ea_gallery` |
| B3 | `st-media` | `/media/` | מבוא + רשימת `ea_testimonial` |

**בדיקה:** `curl -kL -o /dev/null -w "%{http_code}" <BASE>/faq/` (וחוזר ל־`/galleries/`, `/media/`) — **200**.

---

## C — REST / עורך

| # | פעולה | ✓ |
|---|--------|---|
| C1 | `wp/v2/ea_faq`, `ea_gallery`, `ea_testimonial` — זמינים לעריכה בבלוק | |
| C2 | אין שינוי slug עץ בלי אישור **100** | |

---

## D — מסירה ל־50

| # | פעולה | ✓ |
|---|--------|---|
| D1 | עדכון מטריצה נספח **E** | |
| D2 | מילוי טבלת מיפוי ב־[`M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md`](./M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md) לפי אכלוס | |
| D3 | פרסום [`M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-01.md`](./M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-01.md) | |

---

*צוות 10 — checklist ביצוע M3-M3.*
