# M3 — בקשת **QA-2** — **מסירה סופית לבדיקה** (צוות **10** → צוות **50**)

**תאריך מסמך:** 2026-04-01  
**עדכון מסירה סופית:** 2026-04-01 (אחרי **פריסת FTP מלאה** + אימות `curl` בסטייג’ינג)  
**מוציא:** צוות **10**  
**אל:** צוות **50** (QA) — **נא לפתוח דוח FINAL** לפי המנדט  
**מנדט ביצוע קנוני ל־50:** [`../team_50/M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md`](../team_50/M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md)

> **עדכון 2026-04-08 (צוות 10):** התקבל דוח **QA-2 FINAL** — [`../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md) · **`PASS WITH NOTES`** · **Q1-6 / waiver: לא התקיים** · **אישור מעבר ל־M3-M4: לא מאושר עדיין**. קליטה ותוכנית תיקון: [`M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md).  
> **ריטסט מוכנות (אותו יום):** [`M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md) · אימות סטייג’ינג G5–G7: [`M3-G5G7-STAGING-VERIFY-TEAM10-2026-04-08.md`](./M3-G5G7-STAGING-VERIFY-TEAM10-2026-04-08.md).  
> **DOC-SYNC (50):** [`../team_50/M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md`](../team_50/M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md) — **`PASS`** (תיעוד בלבד על מסמך ההגשה החוזרת).

**סטטוס מסירה (היסטורי 2026-04-01):** **הוגש לבדיקת QA-2** — הפריסה לסטייג’ינג בוצעה; ראו ארטיפקט אימות: [`M3-QA-2-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md`](./M3-QA-2-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md).

---

## הקשר מנדט M3-M3

- מנדט ביצוע: [`M3-M3-INSTANCES-MANDATE-TEAM10-2026-04-08.md`](./M3-M3-INSTANCES-MANDATE-TEAM10-2026-04-08.md)  
- checklist סטייג’ינג: [`M3-M3-STAGING-INSTANCES-CHECKLIST-TEAM10-2026-04-01.md`](./M3-M3-STAGING-INSTANCES-CHECKLIST-TEAM10-2026-04-01.md)  
- מפרט גלריות: [`M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md`](./M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md)  
- מטריצה (v2 + נספח **E**): [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md)  
- תיק **100** (שער **Q1-6**): [`M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md`](./M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md) נספח שער QA-2

**סביבת אימות:** `https://eyalamit-co-il-2026.s887.upress.link` · מדיניות TLS: [`../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md) · runbook: [`../team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) — לבדיקות HTTP מומלץ `curl -kL`.

---

## בדיקת עצמית צוות 10 (מול **Q2-1–Q2-7**) — לאחר פריסה

| מזהה | תיאור | תוצאה | הערה |
|------|--------|--------|------|
| **Q2-1** | FAQ — `st-faq` מציג אינסטנסים | **PASS** | `/faq/` — רשימת `ea_faq` (2 פריטי זריעה) + **200**; דוגמה יחידה `/faq-item/ea-m3-seed-faq-1/` **200** |
| **Q2-2** | גלריות — כיסוי מול מלאי | **PASS WITH NOTES** | קטלוג מאוכלס בזריעה (2 גלריות); **טבלת מיפוי מלא מול GALLERY-INVENTORY** — להשלים באכלוס legacy; ראו המפרט |
| **Q2-3** | גלריות — תמונות / 150KB למחיצה | **PASS WITH NOTES** | זריעה ללא תמונות כבדות; **תקרת 150KB** — לאימות כשמעלים מדיה אמיתית לפי המפרט (דגימה בדוח 50) |
| **Q2-4** | מדיה / המלצות — מודל + כפילויות | **PASS WITH NOTES** | `/media/` — `ea_testimonial` (2 פריטים); **`testimonials-media`** — **פתוח מול 100** (נספח C במטריצה) |
| **Q2-5** | שיבוץ ב־≥3 עמודים | **PASS** | מ־`/home/` — קישורים ל־`/faq/`, `/galleries/`, `/media/` (**200**) |
| **Q2-6** | alt בסיסי | **PASS WITH NOTES** | בזריעה אין featured images לכל הפריטים; תבנית משתמשת ב־alt ממטא או בכותרת כשיש תמונה — דגימה מורחבת בדוח 50 |
| **Q2-7** | RTL בדפי שער | **PASS** | רשימות קטלוג ב־עברית; `/en/` מחוץ לטווח בדיקה זו |

---

## תנאי שער (מנדט QA-2): **Q1-6** / **waiver**

| נושא | סטטוס נכון למסירה סופית זו |
|------|------------------------------|
| **Q1-6** (כפילויות REST) או **waiver** ביומן **100** | **לא התקיים עדיין במאגר** — לפי מנדט **QA-2**, **צוות 50** יציין בדוח **FINAL** אם התנאי התקיים; **ללא** עמידה בכך — אין **FINAL** המאשר **M3-M4** (או **FAIL** / **PASS WITH NOTES** לפי נוהל **100**) |

---

## דגימות URL (סטייג’ינג — מאומתות 2026-04-01)

| נושא | URL מלא |
|------|---------|
| FAQ | `https://eyalamit-co-il-2026.s887.upress.link/faq/` |
| קטלוג גלריות | `https://eyalamit-co-il-2026.s887.upress.link/galleries/` |
| מדיה / המלצות | `https://eyalamit-co-il-2026.s887.upress.link/media/` |
| דוגמת יחידת FAQ | `https://eyalamit-co-il-2026.s887.upress.link/faq-item/ea-m3-seed-faq-1/` |
| דוגמת גלריה | `https://eyalamit-co-il-2026.s887.upress.link/gallery-item/ea-m3-seed-gallery-1/` |

REST (עריכה): `wp/v2/ea_faq`, `wp/v2/ea_gallery`, `wp/v2/ea_testimonial`

---

## פלט מצוות **50** (התקבל)

**דוח בפועל:** [`../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md) — **`FINAL`** · **`PASS WITH NOTES`** · שורת שער **Q1-6 / waiver** + **אישור M3-M4** כמפורט בדוח.

**המשך צוות 10:** ראו [`M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md).

---

## עדכון לצוות **100**

יומן: [`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md) — דוח **QA-2** סגור ב־50 (**2026-04-07**); **Q1-6 / waiver** — **לא התקיים**; **אישור M3-M4** — **לא** מטעם 50 בשלב זה. פירוט בקליטת יומן וב־[`M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md).

---

*בקשת בדיקה סופית QA-2 — צוות 10 (מסירה ראשונה 2026-04-01; דוח 50 התקבל 2026-04-07).*
