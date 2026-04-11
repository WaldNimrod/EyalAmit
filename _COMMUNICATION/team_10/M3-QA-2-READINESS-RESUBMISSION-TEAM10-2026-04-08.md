# M3 — **הגשה חוזרת** לאחר דוח **QA-2 FINAL** (צוות **10**)

**תאריך:** 2026-04-08  
**מוציא:** צוות **10**  
**אל:** צוות **50** (QA) · צוות **100** (אורקסטרציה — שער **Q1-6**)  
**הקשר:** קליטת משוב קנוני מ־[`../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md)

---

## פסק הדין בדוח 50 (מסונכרן למאגר צוות 10)

| שדה בדוח | ערך |
|-----------|-----|
| **סטטוס** | `FINAL` |
| **תוצאה** | `PASS WITH NOTES` |
| **Q1-6 / waiver** | `לא התקיים` |
| **אישור מעבר ל־M3-M4** | `לא מאושר עדיין` |

**מסקנה קנונית (תמצית):** פונקציונלית חבילת **M3-M3** חיה בסטייג’ינג; הדוח נסגר **PASS WITH NOTES** משום (א) כיסוי מלאי/מיפוי גלריות ומדיה אמיתית לבדיקת משקל/**alt** טרם סגורים קנונית; (ב) שער **Q1-6 / waiver** לא התקיים ביומן **100**.

---

## קליטת checklist M3-M3 (תואם דוח 50)

| פריט | סטטוס לפי 50 |
|------|----------------|
| **A–C** | **נקלט** — תואם למסירה (פריסה, עמודי שער, REST) |
| **D3** | **נקלט** — בקשת QA-2 פורסמה |
| **D1** (מטריצה נספח E) | **עודכן** (2026-04-08) — ראו [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md) נספח E |
| **D2** (טבלת מיפוי גלריות) | **מולא** (2026-04-08) — זריעה `OK` + legacy **DEFERRED 100** · [`M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md`](./M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md) |

---

## הוכחות שצוות 50 תיעד (לא חוזרים על הבדיקה כאן)

- `GET /faq/`, `/galleries/`, `/media/`, `/faq-item/ea-m3-seed-faq-1/` → **200**
- `GET /testimonials-media/` → **301** ל־`/media/`
- `wp/v2/ea_faq`, `ea_gallery`, `ea_testimonial` — פעילים; פריטי seed; `featured_media: 0` בגלריות/המלצות בדגימה

---

## תיקונים נדרשים בצוות **10** (לפני בקשת אימות חוזר / סגירת הערות)

| # | משימה | בעלים | הערה |
|---|--------|--------|------|
| R1 | **מילוי טבלת המיפוי** ב־[`M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md`](./M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md) מול [`GALLERY-INVENTORY-REPORT-DRAFT-2026-03-31.md`](../../docs/project/team-100-preplanning/GALLERY-INVENTORY-REPORT-DRAFT-2026-03-31.md) — לכל שורה: `OK` / `DEFERRED` + בעלים | **10** / **100** אם נדרש החלטת סקופ | עד אז **Q2-2** נשאר עם הערה בדוח |
| R2 | **אכלוס מדיה אמיתית** (לפחות לדגימת **Q2-3**/**Q2-6**): `featured_media` או תוכן תמונה, משקל למחיצה מול **150KB**, **alt** | **10** | ללא זה אין הוכחת משקל/**alt** סופית |
| R3 | עדכון **מטריצה** נספח **E** + שורות `st-galleries-catalog` לאחר R1–R2 | **10** | |
| R4 | פריסת FTP חוזרת לסטייג’ינג לאחר שינויי קוד/תוכן (אם רלוונטי) | **10** | [`scripts/ftp_deploy_site_wp_content.py`](../../scripts/ftp_deploy_site_wp_content.py) |

---

## פעולה נדרשת בצוות **100** (חוסמת אישור **M3-M4**)

| # | משימה |
|---|--------|
| G1 | **סגירת Q1-6** (כפילויות REST `lectures`, `sound-healing`, `workshops`) — החלטה + תיעוד ביומן [`M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md) **או** |
| G2 | **waiver** מפורש באותו יומן עם נימוק ובעלים |

עד **G1 או G2** — לפי מנדט **QA-2**, **אין** אישור מעבר ל־**M3-M4** מטעם צוות **50**.

---

## מסמכי בסיס (ללא שינוי בתוכן המקורי של בקשת 2026-04-01)

- בקשה ראשונה: [`M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-01.md`](./M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-01.md)  
- ארטיפקט פריסה: [`M3-QA-2-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md`](./M3-QA-2-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md)

---

## פלט צוות **50** — אימות תיעוד (DOC-SYNC)

**התקבל:** [`../team_50/M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md`](../team_50/M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md) — **`FINAL`** · **`PASS`** (אימות תיעודי בלבד; **ללא** ריטסט פונקציונלי).

**מסקנת 50:** מסמך זה מיושר לדוח [`M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md) וליומן **100**; **אין שינוי** בפסק הדין הפונקציונלי של **QA-2** (**`PASS WITH NOTES`**, **Q1-6 / waiver: לא התקיים**, **M3-M4: לא מאושר עדיין**).

**דוח השלמה ל־100:** לאחר אישור DOC-SYNC — [`M3-M3-COMPLETION-HANDOFF-TEAM10-TO-TEAM100-2026-04-08.md`](./M3-M3-COMPLETION-HANDOFF-TEAM10-TO-TEAM100-2026-04-08.md).

---

## ביצוע צוות 10 (2026-04-08) — מול מנדט [`M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md`](./M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md)

| # | משימה | סטטוס | ארטיפקט |
|---|--------|--------|---------|
| G5–G7 | כפילויות REST + 301 שורש | **מומש במאגר** | [`ea-m3-g5g7-q16-rest-dedupe-once.php`](../../site/wp-content/mu-plugins/ea-m3-g5g7-q16-rest-dedupe-once.php) · [`ea-m2-site-tree-lock-sync-once.php`](../../site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php) · [`M3-G5G7-STAGING-VERIFY-TEAM10-2026-04-08.md`](./M3-G5G7-STAGING-VERIFY-TEAM10-2026-04-08.md) |
| R1 | טבלת מיפוי | **מולא** (זריעה `OK`; legacy **DEFERRED 100**) | [`M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md`](./M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md) |
| R2 | מדיה / alt / 150KB | **מומש במאגר** (דגימה) | [`ea-m3-r2-featured-sample-once.php`](../../site/wp-content/mu-plugins/ea-m3-r2-featured-sample-once.php) |
| R3 | מטריצה נספח E | **עודכן** | [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md) |
| R4 | FTP + verify | **לפי פריסה** | [`scripts/ftp_deploy_site_wp_content.py`](../../scripts/ftp_deploy_site_wp_content.py) + verify |

**בקשת ריטסט ל־50:** [`M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md).

---

## פלט צפוי לאחר השלמת תיקונים

1. עדכון מסמכי **10** (מפרט גלריות, מטריצה, checklist סעיף תיקונים).  
2. בקשה ל־**50** ל־**אימות חוזר פונקציונלי** כאשר **R1–R4** ו־**G1/G2** מכוסים או מתועדים.  
3. דוח **50** חדש לפי מנדט — או **DOC-SYNC** נוסף — לפי נוהל **100**.

---

## מקביל חבילה 4 — חיתוך 2026-04-01 (צוות 10)

| # | משימה | סטטוס |
|---|--------|--------|
| **R1** | מילוי טבלת המיפוי בגלריות | **בוצע (2026-04-08)** — ראו מפרט גלריות |
| **R2** | אכלוס מדיה אמיתית / alt / 150KB | **בוצע (2026-04-08)** — MU דגימה |
| **R3** | עדכון מטריצה נספח E | **בוצע (2026-04-08)** |
| **R4** | פריסת FTP לאחר שינויי תמה M4 | **בוצע** — [`M3-M4-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md`](./M3-M4-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md) |

---

*צוות 10 — הגשה חוזרת: קליטת QA-2 FINAL ותוכנית תיקון; DOC-SYNC על מסמך זה — PASS (50).*
