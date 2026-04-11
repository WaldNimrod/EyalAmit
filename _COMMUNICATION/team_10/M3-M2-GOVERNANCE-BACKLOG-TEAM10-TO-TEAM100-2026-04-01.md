# M3-M2 — תיק החלטות **צוות 100** (מצוות **10**)

**תאריך:** 2026-04-01  
**מוציא:** צוות **10**  
**אל:** צוות **100** (אורקסטרציה)  
**הקשר:** [M3-M2-PAGES-CONTENT-MANDATE-TEAM10-2026-03-29.md](./M3-M2-PAGES-CONTENT-MANDATE-TEAM10-2026-03-29.md) · שינוי **slug / הורה** וסגירת **הערות QA-0** — לפי מנדט רק באישור **100** (QR / P22).

---

## מטרה

לרכז פריטים שחוסמים או מסכנים יישור **עץ נעול** ↔ **סטייג’ינג** ללא החלטת **100**. עד למענה רשמי — צוות **10** **לא** משנה slug/הורה ומשאיר כפילויות REST מתועדות (מעקב **Q1-6**).

---

## טבלת פריטים (ממתין החלטה / אישור)

| # | נושא | pageId / מזהים | תיאור קצר | המלצת צוות 10 (לא מחייבת) | סטטוס |
|---|------|----------------|-----------|---------------------------|--------|
| G1 | כפילות slug «השיטה» | `st-method` | סטייג’ינג: `method` (id 55) מול `hashita` (id 17) — איחוד תוכן ו/או 301 ו/או השבתת כפיל | לאחד ל־**`method`** לפי עץ; תוכן מ־legacy לפי SSOT | **DEFERRED מאושר** — **נימרוד מאשר** (2026-04-07) לשמור DEFER ל־**M4/M5** — [`../team_100/M3-GOVERNANCE-G1G4G8-DECISIONS-TEAM100-2026-04-07.md`](../team_100/M3-GOVERNANCE-G1G4G8-DECISIONS-TEAM100-2026-04-07.md) §7 |
| G2 | כפילות תיקון כלים | `st-svc-repair` | `repair` מול `instrument-repair` | עמוד קנוני **`repair`** — ניסוח «תיקון כלים» מדויק | **טופל במאגר (2026-04-07)** — MU [`ea-m4-g2348-governance-once.php`](../../site/wp-content/mu-plugins/ea-m4-g2348-governance-once.php) + 301 `/instrument-repair/` → `/tools-and-accessories/repair/` ב־[`ea-m2-site-tree-lock-sync-once.php`](../../site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php) **v1.2** |
| G3 | קורסים חיצוניים | `st-courses` | T3 `courses-soon` מול `courses-external` | עמוד **פנימי** + קישורים **החוצה** לרכישה ולקורס | **טופל במאגר (2026-04-07)** — `learning/courses-external` + פילטרים `ea_m4_courses_purchase_url` / `ea_m4_courses_learn_url` + T3 עמוד פנימי (**v3**) |
| G4 | ספר צבע | `st-book-tsva` | DEFERRED אימות URL legacy מלא במטריצה | שלד כמו ספר אחר + placeholders אם אין לייב | **שלד במאגר (2026-04-07)** — MU §8 G4; אימות לייב — **M5/cutover** |
| G5 | כפילויות REST — הרצאות | `st-svc-lectures` | מספר רשומות `wp/v2/pages` לאותו slug `lectures` | לבחור **עמוד קנוני** אחד; טיוטה/מחיקה/301 לשאר | **מימוש במאגר** + **אושר 50** (ריטסט 2026-04-08) — [`M3-QA-INSTANCES-GALLERIES-REPORT-RETEST-TEAM50-2026-04-08.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-RETEST-TEAM50-2026-04-08.md) · [`M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md`](./M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md) · [`M3-G5G7-STAGING-VERIFY-TEAM10-2026-04-08.md`](./M3-G5G7-STAGING-VERIFY-TEAM10-2026-04-08.md) |
| G6 | כפילויות REST — סאונד | `st-svc-sound` | slug `sound-healing` | כמו G5 | **מימוש במאגר** + **אושר 50** — כנ״ל |
| G7 | כפילויות REST — סדנאות | `st-svc-workshops` | slug `workshops` | כמו G5 | **מימוש במאגר** + **אושר 50** — כנ״ל |
| G8 | איחוד המלצות/מדיה | `st-media` | `media` מול `testimonials-media` (id 19) | **מדיה אחת**; **המלצות** = קטגוריה בקטלוג | **טופל במאגר (2026-04-07)** — `ea_testimonial_cat` + מונח **recommendations** + טיוטת `testimonials-media` + `template-media-catalog.php` + קטלוג |
| G9 | איחודי M2 נוספים (תוכן) | שונים | למשל `handmade-instruments` → `instruments`; `books` ↔ `muzeh`; שירותים כפולים תחת מרכז | לאחד לפי עמודת legacy במטריצה לאחר G5–G7 | **ממתין תוכן** — G8 טכני סגור במאגר; איחודי תוכן לפי מטריצה |

---

## קישורים

- מטריצה: [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md) (v2 — נספח מעקב QA-0)  
- דוח QA-0: [`../team_50/M3-QA-0-BASELINE-MATRIX-REPORT-2026-04-07.md`](../team_50/M3-QA-0-BASELINE-MATRIX-REPORT-2026-04-07.md)  
- רשימת ביצוע סטייג’ינג: [`M3-M2-STAGING-EXECUTION-CHECKLIST-TEAM10-2026-04-01.md`](./M3-M2-STAGING-EXECUTION-CHECKLIST-TEAM10-2026-04-01.md)

---

## נספח — שער **QA-2** ו־**Q1-6** (מסירת צוות **10**, 2026-04-01)

**בקשה לצוות 100:** לפני שצוות **50** מוציא דוח **QA-2 FINAL** המאשר מעבר ל־**M3-M4**, נדרש אחד מהבאים:

1. **סגירת Q1-6** — החלטה ויישום/תיעוד יישור כפילויות REST (`lectures`, `sound-healing`, `workshops`) לפי מנדט **QA-2** ומסמכי **QA-1**; או  
2. **waiver** מפורש ב־[`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md) (יומן / סעיף ייעודי) עם נימוק ובעלים.

**סטטוס נכון ל־2026-04-01:** **אין waiver מתועד במאגר**; כפילויות **אומתו** ב־QA-1 — **פתוח מול 100** (ראו נספח **C** ב־[`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md)).

**עדכון אחרי QA-2 FINAL (2026-04-07):** בדוח [`../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md) נרשם במפורש **Q1-6 / waiver: לא התקיים** — **אין אישור M3-M4** מטעם צוות **50** עד תיעוד **סגירה** או **waiver** ביומן [`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md). תוכנית המשך ב־10: [`M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md). **DOC-SYNC** על מסמך ההגשה החוזרת: [`../team_50/M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md`](../team_50/M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md) — **`PASS`** (תיעוד בלבד).

**עדכון צוות 100 (2026-04-08) — waiver מוגבל + מדיניות G5–G7:** פורסם [`../team_100/M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md`](../team_100/M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md) — **W-Q1-6-2026-04-08**. מאפשר **מקביל** ליטוש **M3-M4** + **QA-M4**; **G5–G7** — **מדיניות קנונית** (עמוד `page` יחיד לכל slug) + **ביצוע 10** נמשך במקביל; **G1–G4, G8–G9** — סטטוס טבלה למעלה **ללא שינוי** עד החלטות נוספות.

**עדכון צוות 10 (2026-04-08) — G5–G7 במאגר:** פורסם מנדט [`M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md`](./M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md); MU [`ea-m3-g5g7-q16-rest-dedupe-once.php`](../../site/wp-content/mu-plugins/ea-m3-g5g7-q16-rest-dedupe-once.php) + הפניות `/lectures/`, `/workshops/` ב־[`ea-m2-site-tree-lock-sync-once.php`](../../site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php). **סגירה טכנית ביומן 100** — נקלטה בריטסט [`M3-QA-INSTANCES-GALLERIES-REPORT-RETEST-TEAM50-2026-04-08.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-RETEST-TEAM50-2026-04-08.md) לפי [`M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md).

**עדכון ריטסט QA-2 (2026-04-08):** דוח [`../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-RETEST-TEAM50-2026-04-08.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-RETEST-TEAM50-2026-04-08.md) — **`FINAL`** · **`PASS WITH NOTES`** — **אימות טכני Q1-6 התקיים** (REST + 301); **דוח בסיס** [`M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md) **ללא שינוי**; **waiver** [`../team_100/M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md`](../team_100/M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md) — **פורסם** (מקביל M4); **אישור GO מלא M3-M4 מטעם 50** — **לא מאושר**.

**עדכון צוות 100 (2026-04-07) — G1–G4, G8:** פורסמו החלטות [`../team_100/M3-GOVERNANCE-G1G4G8-DECISIONS-TEAM100-2026-04-07.md`](../team_100/M3-GOVERNANCE-G1G4G8-DECISIONS-TEAM100-2026-04-07.md) (DEFERRED מאושר / אושר מדיניות G3); **G9** — אחרי **G8**.

**עדכון נימרוד (2026-04-07):** §**7–8** באותו מסמך — **G1** מאושר כ־DEFERRED; **G2** איחוד מיידי ל־`repair`; **G3** עמוד פנימי + קישורי חוץ; **G4** שלד ספר + placeholders; **G8** מדיה מאוחדת עם קטגוריית המלצות.

**עדכון צוות 10 (2026-04-07) — מימוש §8 (אושר ביצוע):** MU [`ea-m4-g2348-governance-once.php`](../../site/wp-content/mu-plugins/ea-m4-g2348-governance-once.php); תמה `ea-eyalamit` (טקסונומיה, REST, קטלוג מדיה); [`ea-m2-site-tree-lock-sync-once.php`](../../site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php) **v1.2** — **`ea_m2_site_tree_lock_sync_v3`**. **פריסה:** `scripts/ftp_deploy_site_wp_content.py` כולל MU חדש; איפוס לבדיקה חוזרת: `delete_option('ea_m4_g2348_v1')` · `delete_option('ea_m2_site_tree_lock_sync_v3')`. **קליטת 100:** יומן `M3-EXECUTION-PLAN` §«קליטת משוב צוות 10 — §8».

---

*צוות 10 — בקשת החלטות לאורקסטרציה.*
