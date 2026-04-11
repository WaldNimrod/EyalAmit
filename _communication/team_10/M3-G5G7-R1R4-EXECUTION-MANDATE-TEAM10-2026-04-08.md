# M3 — מנדט ביצוע: **G5–G7** (כפילויות REST) + **R1–R4** (גלריות/מדיה QA-2)

**תאריך:** 2026-04-08  
**מוציא:** צוות **10**  
**אל:** צוות **50** (QA) · צוות **100** (אורקסטרציה)  
**תיק governance:** [`M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md`](./M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md)  
**הגשה חוזרת QA-2:** [`M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md)  
**Waiver Q1-6:** [`../team_100/M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md`](../team_100/M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md) (**W-Q1-6-2026-04-08**)

---

## מטרה

1. **G5–G7:** עמוד **`page` קנוני יחיד** לכל slug מבין `lectures`, `sound-healing`, `workshops` — תואם [`hub/data/site-tree.json`](../../hub/data/site-tree.json) (`lectures` / `workshops` תחת `learning`; `sound-healing` ברמה עליונה).  
2. **R1–R4:** השלמת מיפוי גלריות במפרט, דגימת מדיה (משקל / **alt**), עדכון מטריצה נספח **E**, פריסה ואימות.

**מחוץ לסקופ:** **G1–G4**, **G8–G9** — ממתין **100**; אין שינוי slug/הורה לצמתים נעולים אחרים בלי אישור.

---

## קריטריוני סיום (מדידים)

### G5–G7

| Slug | קנוני (נתיב) | בדיקה |
|------|---------------|--------|
| `lectures` | `/learning/lectures/` | `GET /wp-json/wp/v2/pages?slug=lectures&_fields=id,link,parent` — **רשומה אחת** בפרסום; כפילויות — **טיוטה** או **301** |
| `workshops` | `/learning/workshops/` | כנ״ל |
| `sound-healing` | `/sound-healing/` | הורה **0**; כנ״ל |

**הוכחה:** [`M3-G5G7-STAGING-VERIFY-TEAM10-2026-04-08.md`](./M3-G5G7-STAGING-VERIFY-TEAM10-2026-04-08.md) + MU [`ea-m3-g5g7-q16-rest-dedupe-once.php`](../../site/wp-content/mu-plugins/ea-m3-g5g7-q16-rest-dedupe-once.php) · הפניות ב־[`ea-m2-site-tree-lock-sync-once.php`](../../site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php).

### R1–R4

| # | קריטריון | הוכחה |
|---|-----------|--------|
| R1 | טבלת מיפוי ב־[`M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md`](./M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md) — שורות `OK` / `DEFERRED` + בעלים | המפרט בעצמו |
| R2 | לפחות **2** `ea_gallery` עם `featured_media` + **alt**; קבצים ≤ **150KB** (דגימה) | MU [`ea-m3-r2-featured-sample-once.php`](../../site/wp-content/mu-plugins/ea-m3-r2-featured-sample-once.php) |
| R3 | נספח **E** + שורת `st-galleries-catalog` ב־[`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md) | עדכון במאגר |
| R4 | פריסת FTP + `curl` | ארטיפקט READINESS / verify |

---

## שער QA

**מנדט 50:** [`../team_50/M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md`](../team_50/M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md)  
**בקשת מוכנות:** [`M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md) (ריטסט פונקציונלי — **Q1-6** + **Q2-2…Q2-6**).

לאחר דוח **50** מעודכן — **100** ירשום ביומן **סגירת Q1-6** טכנית (בהתאם לפסק הדין).

---

## סטטוס מנדט

**ביצוע צוות 10:** ראו מסמכי verify + READINESS (2026-04-08).  
**אימות 50:** ממתין ריצה לפי [`M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md).

---

*צוות 10 — מנדט G5–G7 + R1–R4*
