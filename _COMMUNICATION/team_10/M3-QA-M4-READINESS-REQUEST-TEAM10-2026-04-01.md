# M3 — בקשת **מוכנות QA-M4** — ליטוש ויזואלי מבני (צוות **10** → צוות **50**)

**תאריך מסמך:** 2026-04-01  
**מוציא:** צוות **10**  
**אל:** צוות **50** (QA) — **נא לפתוח דוח** לפי מנדט **QA-M4** רק לאחר קליטת מסמך זה במאגר  
**מנדט ביצוע קנוני ל־50:** [`../team_50/M3-QA-M4-VISUAL-NOTE-MANDATE-TEAM50-2026-04-08.md`](../team_50/M3-QA-M4-VISUAL-NOTE-MANDATE-TEAM50-2026-04-08.md)

> **עדכון 2026-04-07 (צוות 10):** התקבל דוח **QA-M4** ראשון — [`../team_50/M3-QA-M4-VISUAL-NOTE-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-M4-VISUAL-NOTE-REPORT-TEAM50-2026-04-07.md) · **PASS WITH NOTES**. תיקוני הערות + **הגשה חוזרת:** [`M3-QA-M4-READINESS-RESUBMISSION-TEAM10-2026-04-07.md`](./M3-QA-M4-READINESS-RESUBMISSION-TEAM10-2026-04-07.md) · ארטיפקט פריסה: [`M3-M4-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-07.md`](./M3-M4-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-07.md).

> **עדכון 2026-04-07 (צוות 50):** **ריטסט קנוני** — [`../team_50/M3-QA-M4-VISUAL-NOTE-RETEST-TEAM50-2026-04-07.md`](../team_50/M3-QA-M4-VISUAL-NOTE-RETEST-TEAM50-2026-04-07.md) · **FINAL** · **PASS**; הערת audit לא־חוסמת על מחרוזת GP במקור HTML בלבד.

---

## הקשר מנדט M3-M4

- מנדט ביצוע צוות **10:** [`M3-M4-VISUAL-POLISH-MANDATE-TEAM10-2026-04-08.md`](./M3-M4-VISUAL-POLISH-MANDATE-TEAM10-2026-04-08.md)  
- רצף חבילה 4: [`../team_100/M3-PACKAGE4-TEAM100-DIRECT-IMPLEMENTATION-AND-SEQUENCE-2026-03-29.md`](../team_100/M3-PACKAGE4-TEAM100-DIRECT-IMPLEMENTATION-AND-SEQUENCE-2026-03-29.md)  
- פלטת צבעים: [`../../docs/project/EYAL-SITE-COLOR-PALETTE.md`](../../docs/project/EYAL-SITE-COLOR-PALETTE.md)

**סביבת אימות:** `https://eyalamit-co-il-2026.s887.upress.link` · מדיניות TLS: [`../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md) · runbook: [`../team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md)

**ארטיפקט פריסה + `curl`:** [`M3-M4-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md`](./M3-M4-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md)

---

## רשימת שינויים (תמצית טכנית)

| # | נושא | פירוט |
|---|------|--------|
| 1 | טיפוגרפיה חזית | טעינת **Rubik** לכל דפי החזית (לא רק דף הבית); `preconnect` ל־Google Fonts |
| 2 | היקף ליטוש | מחלקת גוף **`ea-m4-polish`** לעמודים שאינם דף הבית dashboard; דף בית נשאר תחת **`ea-home-dashboard`** |
| 3 | טוקני CSS | משתני `--eyal-*` ב־`style.css` לפי פלטה מאושרת; כותרות, קישורים, גוף טקסט, רשימות |
| 4 | קטלוגי אינסטנסים | מסגרות/מרווחים/צבעי כותרת ותקציר תחת `body.ea-m4-polish` |
| 5 | פוטר משפטי | רקע עדין + צבעי קישור מיושרים לפלטה |
| 6 | גרסת תמה | **1.3.0** ב־`style.css` |

**מחוץ להיקף M3-M4:** מנוע גלריה כבד; שינוי slug/עץ; שינוי תבנית נעולה — **לא בוצע**.

---

## דגימות URL (סטייג’ינג — 5 עמודים למנדט QA-M4)

| # | נושא | URL מלא |
|---|------|---------|
| 1 | בית | `https://eyalamit-co-il-2026.s887.upress.link/` |
| 2 | שירות (דוגמה) | `https://eyalamit-co-il-2026.s887.upress.link/sound-healing/` |
| 3 | קטלוג | `https://eyalamit-co-il-2026.s887.upress.link/galleries/` |
| 4 | עמוד משפטי | `https://eyalamit-co-il-2026.s887.upress.link/privacy/` |
| 5 | קטלוג FAQ (תוכן מובנה) | `https://eyalamit-co-il-2026.s887.upress.link/faq/` |

---

## מקבילות (אינה חוסמת QA-M4)

- **G5–G7** (כפילויות REST) — במעקב; ראו [`M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md`](./M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md).  
- **R1–R4** (הגשה חוזרת QA-2) — חיתוך 2026-04-01 ב־[`M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md).

---

## עדכון לצוות **100**

יומן: [`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md) — §**4** מקושר למסמך זה.

---

*בקשת מוכנות QA-M4 — צוות 10 (2026-04-01).*
