# M3 — בקשת **ריטסט QA-2** (G5–G7 + R1–R4) — צוות **10** → צוות **50**

**תאריך מסמך:** 2026-04-08  
**מוציא:** צוות **10**  
**אל:** צוות **50** (QA) — **נא דוח מעודכן** לפי המנדט  
**מנדט ביצוע 10:** [`M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md`](./M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md)  
**מנדט QA (50):** [`../team_50/M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md`](../team_50/M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md)

**סביבה:** `https://eyalamit-co-il-2026.s887.upress.link` · `curl -kL` · runbook: [`../team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md)

---

## סקופ הריטסט (משולב)

| ציר | בדיקות |
|-----|--------|
| **Q1-6 / G5–G7** | `wp/v2/pages?slug=lectures|workshops|sound-healing` — **רשומת publish אחת** לכל slug; כפילויות בטיוטה או 301 תואם [`M3-G5G7-STAGING-VERIFY-TEAM10-2026-04-08.md`](./M3-G5G7-STAGING-VERIFY-TEAM10-2026-04-08.md) |
| **Q2-2 … Q2-6** | טבלת מיפוי במפרט גלריות; `/galleries/`; `ea_gallery` עם `featured_media` ו־**alt**; משקל קובץ דגימה ≤ **150KB** למחיצה |

---

## URLים לדגימה

| נושא | URL |
|------|-----|
| קטלוג גלריות | `https://eyalamit-co-il-2026.s887.upress.link/galleries/` |
| מדיה / המלצות | `https://eyalamit-co-il-2026.s887.upress.link/media/` |
| גלריה 1 (זריעה) | `https://eyalamit-co-il-2026.s887.upress.link/gallery-item/ea-m3-seed-gallery-1/` |
| הרצאות (קנוני) | `https://eyalamit-co-il-2026.s887.upress.link/learning/lectures/` |

REST: `wp/v2/ea_gallery`, `wp/v2/pages?slug=lectures`

---

## פלט מבוקש מצוות **50**

1. דוח **FINAL** מעודכן (או ריטסט ייעודי) המציין במפורש **Q1-6 / G5–G7** (עמידה או הערה) וסטטוס **Q2-2…Q2-6** מול המפרט והמדיה.  
2. **100** עדכן יומן [`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md) — **סגירה טכנית Q1-6** נקלטה לפי דוח הריטסט והנרטיב ב־§2.3.

---

## פלט מצוות **50** (התקבל)

**דוח:** [`../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-RETEST-TEAM50-2026-04-08.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-RETEST-TEAM50-2026-04-08.md)

| תוצאה | תוכן |
|--------|------|
| **סטטוס / תוצאה** | **`FINAL`** · **`PASS WITH NOTES`** |
| **Q1-6 טכני** | **PASS** — לכל אחד מ־`lectures`, `workshops`, `sound-healing` מערך REST באורך 1, `publish`, הורה כמצופה; **301** מ־`/lectures/`, `/workshops/` ל־`/learning/…` |
| **Q2-2** | **PASS** — טבלת מיפוי במפרט: **DEFERRED** (legacy, **100**) + **OK** לזריעות; `/galleries/` מאוכלס |
| **Q2-3** | **PASS WITH NOTES** — רק **2** גלריות מאוכלסות; מדיה **121**/**122**, **3553** בתים (<150KB); עומד במנדט «כל המאוכלסות אם פחות מ־3» |
| **Q2-4…Q2-6** | **PASS** — `/media/` **200**; `/testimonials-media/` → `/media/`; שיבוץ מבית ל־faq/galleries/media; `featured_media` + **alt** ב־REST ובדף גלריה |
| **שורת שער** | אימות **Q1-6** בסטייג’ינג — **התקיים**; **waiver** [`M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md`](../team_100/M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md) — **פורסם** (מקביל M4, לא GO מלא); **אישור M3-M4 מלא מטעם 50** — **לא מאושר** |

---

## הקשר מסמכים

- הגשה חוזרת (רקע): [`M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md)  
- דוח קודם: [`../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md)  
- תיק governance: [`M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md`](./M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md)

---

*בקשת מוכנות — ריטסט QA-2 אחרי G5–G7 + R1–R4 במאגר; דוח ריטסט 50 התקבל 2026-04-08.*
