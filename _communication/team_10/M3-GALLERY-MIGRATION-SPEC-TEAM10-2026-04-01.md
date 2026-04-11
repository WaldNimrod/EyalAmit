# M3-M3 — מפרט מיגרציית גלריות (צוות **10**)

**תאריך:** 2026-04-01  
**מנדט:** [`M3-M3-INSTANCES-MANDATE-TEAM10-2026-04-08.md`](./M3-M3-INSTANCES-MANDATE-TEAM10-2026-04-08.md)  
**סקופ מאושר:** [`../../docs/project/team-100-preplanning/GALLERY-DECISION-SCOPE-v1.2.md`](../../docs/project/team-100-preplanning/GALLERY-DECISION-SCOPE-v1.2.md)  
**מלאי:** [`../../docs/project/team-100-preplanning/GALLERY-INVENTORY-REPORT-DRAFT-2026-03-31.md`](../../docs/project/team-100-preplanning/GALLERY-INVENTORY-REPORT-DRAFT-2026-03-31.md)

**עדכון R1 (2026-04-08):** טבלת המיפוי למטה **מולאה** לפי מנדט [`M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md`](./M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md) — זריעת סטייג’ינג כ־`OK`; מלאי legacy Envira ב־[`GALLERY-INVENTORY-REPORT-DRAFT-2026-03-31.md`](../../docs/project/team-100-preplanning/GALLERY-INVENTORY-REPORT-DRAFT-2026-03-31.md) עדיין **DRAFT** (§2.4 ריק) — שורה אחת **DEFERRED** עם בעלים **100** עד השלמת CSV/DB.

---

## עקרונות (חובה)

| עקרון | יישום |
|--------|--------|
| **אין upload «מתים»** | כל קובץ ב־WP Media Library חייב מופע בשימוש (גלריה / featured / תוכן); לפני העלאה — מחיקת כפילים ותכנון שמות. |
| **תקרת 150KB למחיצה** | דחיסה/ייעול לפני העלאה; אם חריגה — אישור נפרד מ־**100** או פיצול מחיצות. |
| **מנוע גלריה** | רשת / lightbox **פשוטים ב־WP בלבד** (בלוק גלריה / תמונות) — ללא Envira או מנוע כבד בלי **waiver 100**. |
| **מיפוי מלאי** | לכל שורה רלוונטית במלאי — ישות `ea_gallery` בסטייג’ינג או סטטוס **DEFERRED** עם בעלים והערה במטריצה. |

---

## מודל טכני במאגר (2026-04-01)

- **CPT:** `ea_gallery` — רישום ב־[`site/wp-content/themes/ea-eyalamit/functions.php`](../../site/wp-content/themes/ea-eyalamit/functions.php).  
- **עמוד שער:** `st-galleries-catalog` — slug `galleries`, תבנית [`template-galleries-catalog.php`](../../site/wp-content/themes/ea-eyalamit/page-templates/template-galleries-catalog.php) (כפיית `template_include` כשהעמוד קיים).  
- **זריעת דוגמה (אופציונלי):** MU [`site/wp-content/mu-plugins/ea-m3-seed-instances-once.php`](../../site/wp-content/mu-plugins/ea-m3-seed-instances-once.php) — איפוס: `delete_option('ea_m3_instances_seed_v1')`.

---

## טבלת מיפוי (מלאי → סטייג’ינג)

**הוראה:** למלא בעת האכלוס — עמודה **סטטוס** אחת מ: `OK` · `DEFERRED` · `N/A` (מחוץ לסקופ).

| מזהה במלאי / שם בדוח | כותרת `ea_gallery` (יעד) | סטטוס | הערה |
|----------------------|---------------------------|--------|------|
| מלאי legacy Envira (§2.4 בדוח המלאי — טרם מולא) | — | **DEFERRED** | **100** — השלמת `GALLERY-INVENTORY-TEMPLATE.csv` / יצוא WXR + ספירת תמונות; אז עדכון שורות נפרדות ל־`OK` לפי גלריה |
| זריעה `ea-m3-seed-gallery-1` | גלריית דוגמה — PLACEHOLDER R3 | **OK** | סטייג’ינג; MU [`ea-m3-seed-instances-once.php`](../../site/wp-content/mu-plugins/ea-m3-seed-instances-once.php) |
| זריעה `ea-m3-seed-gallery-2` | גלריית דוגמה שנייה — PLACEHOLDER R4 | **OK** | סטייג’ינג; כנ״ל |

---

## בדיקות לפני סגירת שורה ב־QA-2

1. דף `/galleries/` מציג רשימה לא ריקה או **DEFERRED** מתועד.  
2. לפחות **3** גלריות מאוכלסות — דגימת משקל תמונה **למחיצה** מול **150KB** (לוג / צילום מסך בדוח 50).  
3. **alt** על תמונות הדגימה או ממצא עם בעלים.

---

*צוות 10 — מפרט מיגרציה לחבילה 3.*
