# M3 — חבילת **מנדטים להשלמה מלאה** + חובות **צוות 100** (מימוש ישיר)

**תאריך:** 2026-04-07  
**מוציא:** צוות **100** (אורקסטרציה)  
**נמענים:** נימרוד (בעל מוצר), צוותי **10, 20, 50, 80** (מחקר)  
**הקשר:** שער **QA-M4** סגור (**ריטסט `PASS`**) — [`M3-QA-M4-RETEST-ACCEPTANCE-AND-NEXT-PHASE-TEAM100-2026-04-07.md`](./M3-QA-M4-RETEST-ACCEPTANCE-AND-NEXT-PHASE-TEAM100-2026-04-07.md). **סגירת אבן דרך M3 במלואה** — רק לפי §**סגירת M3** ב־[`M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](./M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md).

**נוהל (מעודכן):** מסמך זה הוא **צילום מצב + רשימת מנדטים/חובות** — **המעקב החי** נשאר ב־[`M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](./M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md) (**§0**, יומן, §4). **אין** לפתוח חבילות handoff נוספות שמכפילות את אותו יומן. **Hub:** ראו **§0** בתוכנית הביצוע — רולאפ אחד לשלב משמעותי, לא פר־צעד.

---

## חלק א׳ — **צוות 100**: מה **חייב** להתממש **ישירות** במאגר (לא רק הנחיה)

| # | משימה | פלט צפוי במאגר |
|---|--------|----------------|
| H1 | **החלטות governance** לפריטים **ממתין 100** בתיק [`../team_10/M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md`](../team_10/M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md) — **G1–G4, G8** (וגם יישור כללי ל־**G9** אם נדרש לפני ביצוע 10) | מסמכי החלטה ב־`_communication/team_100/` ו/או עדכון טבלת התיק + יומן [`M3-EXECUTION-PLAN...`](./M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md) |
| H2 | **סגירת M3** כשמתקיימים כל קריטריוני §**סגירת M3** | עדכון [`docs/project/ROADMAP-2026.md`](../../docs/project/ROADMAP-2026.md) (**M3 = COMPLETED**); סנכרון [`hub/data/roadmap.json`](../../hub/data/roadmap.json), [`hub/data/tasks.json`](../../hub/data/tasks.json); **`updates.json` — פריט אחד (רולאפ)** לסגירת השלב, לא רשימת עדכונים לכל תת־צעד; הרצת `python3 scripts/build_eyal_client_hub.py`; יומן §4 מלא |
| H3 | **מנדטי QA / אורקסטרציה** כשיש צורך בריטסט או שער חדש אחרי מסירת **10** (למשל אימות פונקציונלי אחרי **R1–R4**) | קבצים תחת `_communication/team_100/` + `_communication/team_50/` לפי נוהל קיים |
| H4 | **M3-M1** — הרחבה/יישור [`M3-TEXT-PLACEHOLDER-REQUIREMENTS-FOR-RESEARCH-2026-04-07.md`](./M3-TEXT-PLACEHOLDER-REQUIREMENTS-FOR-RESEARCH-2026-04-07.md) מול מטריצה ומחקר | גרסה מאושרת במאגר; מעקב החזרות ב־`_communication/` |
| H5 | **פיקוח ויומן** — עדכון שוטף של [`M3-EXECUTION-PLAN...`](./M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md) אחרי כל שער ומסירה | יומן + §4 תמיד מסונכרנים לדוחות **50** וארטיפקטי **10** |

**כלל:** אין להסתפק ב«הנחיה לצוות» על נושאים שמסומנים כאחריות **100** בתיקים או בתוכנית — **יישום מסמכים/יומן/רודמאפ/Hub** בידי **100**.

---

## חלק ב׳ — **צוות 10**: מנדטים להעברה (ביצוע עד סגירת יתרות M3)

| סדר | נושא | מנדט / מסמך עיקרי | תוצר סיום |
|-----|------|-------------------|-----------|
| **1** | **G5–G7** — כפילויות REST (`lectures`, `sound-healing`, `workshops`) | תיק [`../team_10/M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md`](../team_10/M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md) + מדיניות [`M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md`](./M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md) | עמוד קנוני יחיד לכל slug; תיעוד במטריצה נספח **C** — [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](../team_10/M3-PAGE-FILL-MATRIX-2026-04-07.md) |
| **2** | **R1–R4** — גלריות / מדיה / מטריצה (המשך מ־**QA-2**) | [`../team_10/M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](../team_10/M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md) · [`M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md`](../team_10/M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md) · מנדט בסיס [`M3-M3-INSTANCES-MANDATE-TEAM10-2026-04-08.md`](../team_10/M3-M3-INSTANCES-MANDATE-TEAM10-2026-04-08.md) | טבלת מיפוי מלאה; מדיה/alt/משקל לפי דוח; נספח **E** מעודכן; פריסת FTP כנדרש |
| **3** | **G9** — איחודי תוכן תלוי **G5–G8** | אותו תיק governance + מטריצה | ביצוע **אחרי** סגירת **G8** או החלטת **100** ל־G8 |
| **4** | **שינוי slug / הורה** | [`M3-M2-PAGES-CONTENT-MANDATE-TEAM10-2026-03-29.md`](../team_10/M3-M2-PAGES-CONTENT-MANDATE-TEAM10-2026-03-29.md) — **רק באישור מפורש מ־100** | ללא שינוי עצמאי בניגוד לתיק |
| **5** | **M5 ליטוש** (לא חוסם סגירת M3 אם הקריטריונים מתקיימים) | [`M3-EXECUTION-PLAN...`](./M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md) §0.1 · [`docs/project/ROADMAP-2026.md`](../../docs/project/ROADMAP-2026.md) | סבבי ליטוש לפי הכוונת נימרוד/100 |

**הערה:** **M3-M4** — [`M3-M4-VISUAL-POLISH-MANDATE-TEAM10-2026-04-08.md`](../team_10/M3-M4-VISUAL-POLISH-MANDATE-TEAM10-2026-04-08.md) — **סגור לשער QA-M4**; אין המשך מנדט זה לפני החלטת מוצר חדשה.

---

## חלק ג׳ — **צוות 50**: מנדטים להעברה (לפי שחרור מ־**10** / **100**)

| סדר | נושא | מנדט / מסמך | תנאי התחלה |
|-----|------|-------------|------------|
| **1** | **ריטסט / אימות פונקציונלי** אחרי סגירת **R1–R4** + פריסה (אם **100** מפרסם מנדט) | ייווצר לפי נוהל — בשורה עם [`M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md`](../team_50/M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md) | בקשת מוכנות מ־**10** + מנדט חדש מ־**100** |
| **2** | **DOC-SYNC** (תיעוד בלבד) | לפי נוהל **100** אחרי עדכוני מסמכים מהותיים | כשמופיע ביומן §4 |

**סגורים (אין מנדט פתוח):** **QA-0, QA-1, QA-2, QA-M4** — דוחות **FINAL** במאגר; **QA-M4** פלט קנוני — [`../team_50/M3-QA-M4-VISUAL-NOTE-RETEST-TEAM50-2026-04-07.md`](../team_50/M3-QA-M4-VISUAL-NOTE-RETEST-TEAM50-2026-04-07.md).

---

## חלק ד׳ — **צוות 20** (תשתית)

| נושא | מקור | הערה |
|------|------|------|
| סביבה, TLS, runbook | [`../team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) · [`../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md) | נשאר בתמיכה; **M4 אינטגרציות** ברודמאפ — נפרד מ־**M3-M4** |

---

## חלק ה׳ — **מחקר / צוות 80** (טקסטים זמניים)

| נושא | מקור |
|------|------|
| טקסטים לפי M3-M1 | [`M3-TEXT-PLACEHOLDER-REQUIREMENTS-FOR-RESEARCH-2026-04-07.md`](./M3-TEXT-PLACEHOLDER-REQUIREMENTS-FOR-RESEARCH-2026-04-07.md) · חבילות [`../team_80/`](../team_80/) לפי נוהל |

---

## מפת Hub (מעקב)

**עודכן (2026-04-07):** G5–G7 + R1–R4 — **הושלמו**; סגירת **M3 טכנית** — [`hub/data/tasks.json`](../../hub/data/tasks.json) **`M3-SEC-TECH-CLOSE-100`**. מיקוד: **`MILESTONE-M4`** ב־[`hub/data/roadmap.json`](../../hub/data/roadmap.json).

---

**צוות 100** — אורקסטרציה M3
