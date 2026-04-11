# M3-M3 — מנדט: אינסטנסים — FAQ, גלריות, המלצות (צוות **10**)

**תאריך:** 2026-04-08  
**מוציא:** צוות **100** (אורקסטרציה)  
**אל:** צוות **10**  
**תוכנית מסגרת:** [`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md)  
**תלות:** **QA-1 סגור** — דוח **FINAL** [`../team_50/M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md) · **`PASS WITH NOTES`**.  
**שער הבא:** [`../team_50/M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md`](../team_50/M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md) (**QA-2**)

**תנאי מקביל (מדיניות שער):** סגירת **Q1-6** (כפילויות REST / יישור slug) או **waiver** מתועד מ־**צוות 100** — **לפני** שצוות **50** מוציא דוח **QA-2 FINAL** שמאשר מעבר ל־**M3-M4**; אין לחסום **הכנת** אינסטנסים ב־10 אם התיעוד במטריצה משקף מצב זמני, אך **מסירה סופית** ל־QA-2 תואמת החלטות **100**.

---

## מטרה

ליישם ב־**WordPress (סטייג’ינג)** מודל **אינסטנסים** ל־**FAQ**, **גלריות** ו־**המלצות/מדיה** — CPT / בלוקים / כלי קיים לפי המאגר — ולאכלס מ־**legacy** + טקסטים זמניים ממחקר לפי [`M3-TEXT-PLACEHOLDER-REQUIREMENTS-FOR-RESEARCH-2026-04-07.md`](../team_100/M3-TEXT-PLACEHOLDER-REQUIREMENTS-FOR-RESEARCH-2026-04-07.md) ומטריצת המילוי.

**עמודי שער וקטלוגים (לפי עץ):** לפחות `st-faq` (`tpl-entity-catalog`), `st-galleries-catalog` (`tpl-entity-catalog`), `st-media` (`tpl-media`) — בהתאם ל־[`hub/data/site-tree.json`](../../hub/data/site-tree.json) ול־[`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md).

---

## קלטים חובה

| # | מקור |
|---|------|
| 1 | [`hub/data/site-tree.json`](../../hub/data/site-tree.json) · [`hub/data/page-templates.json`](../../hub/data/page-templates.json) |
| 2 | [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md) |
| 3 | סקופ גלריות: [`GALLERY-DECISION-SCOPE-v1.2.md`](../../docs/project/team-100-preplanning/GALLERY-DECISION-SCOPE-v1.2.md) · דוח מלאי: [`GALLERY-INVENTORY-REPORT-DRAFT-2026-03-31.md`](../../docs/project/team-100-preplanning/GALLERY-INVENTORY-REPORT-DRAFT-2026-03-31.md) |
| 4 | מודל תוכן: [`CANONICAL-CONTENT-SUBMISSION-FROM-EYAL.md`](../../docs/project/eyal-ceo-submissions-and-responses/from-eyal/CANONICAL-CONTENT-SUBMISSION-FROM-EYAL.md) §6 (אינסטנסים) |
| 5 | אתר **legacy** + SSOT · סטייג’ינג — [`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) |
| 6 | תיק החלטות (אם רלוונטי): [`M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md`](./M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md) |

---

## כללים

- **גלריות:** מיגרציה לפי המלאי; **אין** קבצי upload «מתים»; lightbox / רשת — **פשוט, WP בלבד** (לפי SPEC; ללא מנוע כבד בלי waiver **100**).  
- **תמונות:** נוהל Drive + תקרת **150KB** למחיצה.  
- **שינוי slug / הורה / מבנה עץ** — רק באישור **צוות 100**.  
- סמנו **`PLACEHOLDER_COPY`** / **R#** היכן שחסר עד החלפה.

---

## פלט חובה

1. **ב־WP:** אינסטנסים מקושרים לעמודי השער והקטלוגים; רינדור ברור בחזית (רשימות, כרטיסים, מעבר לעמודי משנה אם קיימים).  
2. **מטריצה / מסמך מעקב:** עדכון סטטוס תוכן לאחר אכלוס (או נספח לפי נוהל **100**).  
3. **בקשת מוכנות ל־QA-2** — מסמך תחת `team_10/` (שם מוצע: `M3-QA-2-READINESS-REQUEST-TEAM10-YYYY-MM-DD.md`) עם עצמי מול **Q2-*** במנדט QA-2, דגימות URL, בסיס סטייג’ינג.

---

## סיום

כשהמסירה **מוכנה לבדיקת QA-2**, עדכנו **צוות 100** ופתחו קו מול **צוות 50** לפי [`../team_50/M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md`](../team_50/M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md).

---

## ביצוע ומסירה (עדכון צוות **10**, 2026-04-01)

| # | מסמך / רכיב |
|---|-------------|
| 1 | קוד: CPT + תבניות — [`../../site/wp-content/themes/ea-eyalamit/functions.php`](../../site/wp-content/themes/ea-eyalamit/functions.php) · [`template-faq-catalog.php`](../../site/wp-content/themes/ea-eyalamit/page-templates/template-faq-catalog.php) · [`template-galleries-catalog.php`](../../site/wp-content/themes/ea-eyalamit/page-templates/template-galleries-catalog.php) · [`template-media-catalog.php`](../../site/wp-content/themes/ea-eyalamit/page-templates/template-media-catalog.php) |
| 2 | זריעה חד־פעמית: [`../../site/wp-content/mu-plugins/ea-m3-seed-instances-once.php`](../../site/wp-content/mu-plugins/ea-m3-seed-instances-once.php) |
| 3 | מפרט גלריות: [`M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md`](./M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md) |
| 4 | checklist סטייג’ינג: [`M3-M3-STAGING-INSTANCES-CHECKLIST-TEAM10-2026-04-01.md`](./M3-M3-STAGING-INSTANCES-CHECKLIST-TEAM10-2026-04-01.md) |
| 5 | מטריצה (נספח **E**): [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md) |
| 6 | בקשת **QA-2**: [`M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-01.md`](./M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-01.md) |
| 7 | דוח **QA-2 FINAL** (50): [`../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md) |
| 8 | **הגשה חוזרת** / תוכנית תיקון: [`M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md) |
| 9 | **DOC-SYNC** על ההגשה החוזרת (50): [`../team_50/M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md`](../team_50/M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md) — **`PASS`** |
| 10 | **דוח השלמה ל־100:** [`M3-M3-COMPLETION-HANDOFF-TEAM10-TO-TEAM100-2026-04-08.md`](./M3-M3-COMPLETION-HANDOFF-TEAM10-TO-TEAM100-2026-04-08.md) |

**סטטוס מנדט M3-M3:** **QA-2 FINAL התקבל** (**2026-04-07**) — **`PASS WITH NOTES`**; **Q1-6 / waiver: לא התקיים**; **אישור מעבר ל־M3-M4: לא מאושר עדיין** (מפורש בדוח 50). **פריסה ראשונה:** [`M3-QA-2-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md`](./M3-QA-2-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md). **תיקונים נדרשים ב־10:** מיפוי גלריות קנוני (**D2**), מדיה אמיתית למשקל/**alt**, עדכון מטריצה; **ב־100:** סגירת **Q1-6** או **waiver** ביומן — ראו [`M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md).

---

**צוות 100** — אורקסטרציה M3
