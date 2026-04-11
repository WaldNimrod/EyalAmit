# M3 — דוח QA-2 **ריטסט** (Q1-6 + Q2-2…Q2-6) — סטייג’ינג

**סטטוס:** `FINAL`  
**תוצאה:** `PASS WITH NOTES`  
**תאריך דוח:** 2026-04-08  
**מבצע:** צוות **50** (QA)  
**בקשת מוכנות:** [`../team_10/M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md`](../team_10/M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md)  
**מנדט:** [`M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md`](./M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md)  
**דוח בסיס (2026-04-07):** [`M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](./M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md)  
**סטייג’ינג:** `https://eyalamit-co-il-2026.s887.upress.link` · `curl -k` / `curl -kL` · TLS לפי [`../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md)

---

## שורת שער (מנדט QA-2)

| שדה | ערך |
|-----|-----|
| **Q1-6 — אימות טכני בסטייג’ינג (ריטסט)** | **התקיים** — ראו טבלה **Q1-6** למטה (REST באורך 1 + `publish`; 301 לנתיבי `learning`). |
| **Q1-6 / waiver — מעקב יומן 100** | **waiver מוגבל פורסם** — [`../team_100/M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md`](../team_100/M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md) (**W-Q1-6-2026-04-08**) — מקביל **M4**; **אינו** מבטל דוח QA-2 ואינו **אישור GO מלא** לפרודקשן (לפי ניסוח ה־waiver). |
| **אישור מעבר מלא ל־M3-M4 מטעם 50** | **לא מאושר** — נשאר לפי נוהל 100 + דוחות/שערים נוספים; הריטסט מאשר עמידה טכנית בסקופ הבקשה בלבד. |

---

## סיכום מנהלים

- **Q1-6:** כפילויות `pages` לפי slug — **נסגרו בסטייג’ינג** לפי קריטריוני [`M3-G5G7-STAGING-VERIFY-TEAM10-2026-04-08.md`](../team_10/M3-G5G7-STAGING-VERIFY-TEAM10-2026-04-08.md) (מערך REST באורך 1, `status: publish`, הורה לפי עץ; 301 מ־`/lectures/` ו־`/workshops/`).
- **Q2-2…Q2-6:** טבלת מיפוי במפרט הגלריות — כל שורה `OK` או `DEFERRED` עם בעלים; קטלוג `/galleries/` חי; שתי גלריות זריעה עם `featured_media` + **alt** + קובץ **≤150KB** (דגימה); `/media/` **200**; `/testimonials-media/` מסתיים ב־`/media/`; שיבוץ מדף הבית ל־`/faq/`, `/galleries/`, `/media/` — **200**.

---

## טבלת תוצאות

| ID בדיקה | תוצאה | הערה | בעלים (10/100) |
|----------|--------|------|----------------|
| **Q1-6** | **PASS** | `GET …/pages?slug=lectures|workshops|sound-healing&_fields=id,slug,parent,status` — כל אחד **מערך באורך 1**, `publish`; `lectures`/`workshops` `parent: 58` (learning); `sound-healing` `parent: 0`. `HEAD /lectures/` · `/workshops/` — **301** ל־`/learning/lectures/`, `/learning/workshops/`. | — |
| Q2-2 | **PASS** | [`M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md`](../team_10/M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md) — שורות: legacy Envira **DEFERRED** (**100**); זריעה 1–2 **OK**. `/galleries/` — רשימה מאוכלסת (~49KB HTML). | 100 (legacy) |
| Q2-3 | **PASS WITH NOTES** | שתי גלריות `ea_gallery` בלבד מאוכלסות — דגימת משקל **לכל אחת** (מנדט: «או כל המאוכלסות אם פחות מ־3»): מדיה **121**/**122** — `filesize` **3553** בתים (HEAD תואם) **<150KB**. | — |
| Q2-4 | **PASS** | `/media/` **200**; `/testimonials-media/` עם `-L` — יעד סופי `/media/` (**200**). | — |
| Q2-5 | **PASS** | מדף הבית: קישורים ל־`/faq/`, `/galleries/`, `/media/` — כולם **200**. | — |
| Q2-6 | **PASS** | `ea_gallery` זריעה: `featured_media` 121, 122; REST מדיה — `alt_text` בעברית מלא; בדף `/gallery-item/ea-m3-seed-gallery-1/` נמצא `alt` תואם בדגימה. | — |
| Q2-7 (מידע) | **PASS** | `/faq/`, `/galleries/` — `<html dir="rtl" lang="he-IL">` (מחוץ לסקופ הבקשה המפורש אך תואם מנדט QA-2). | — |

---

## ראיות טכניות (תמצית)

- REST: `curl -ksS` ל־`/wp-json/wp/v2/pages?slug=…` ו־`/wp-json/wp/v2/ea_gallery?…` ו־`/wp-json/wp/v2/media/121|122`.
- HTTP: `curl -kI` ל־`/lectures/`, `/workshops/` (ללא `-L` לצורך 301); `curl -kL -w '%{http_code}'` לנתיבי שיבוץ.

---

## המשך מומלץ לצוות **100**

לעדכן יומן [`M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md): **סגירה טכנית Q1-6** (G5–G7) **אומתה ב־50** לפי ריטסט זה — בנוסף ל־**waiver** הקיים (**W-Q1-6-2026-04-08**).

---

**צוות 50** — ריטסט QA-2 (2026-04-08)
