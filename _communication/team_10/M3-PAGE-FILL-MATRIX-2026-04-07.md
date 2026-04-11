# M3 — מטריצת מילוי עמודים (v2 — מסגרת M3-M2)

**תאריך יצירת שלד:** 2026-04-07  
**מילוי v1:** 2026-04-07 · **צוות 10**  
**מסגרת v2 (מאגר):** 2026-04-01 — חבילת ביצוע M3-M2: [`M3-M2-STAGING-EXECUTION-CHECKLIST-TEAM10-2026-04-01.md`](./M3-M2-STAGING-EXECUTION-CHECKLIST-TEAM10-2026-04-01.md) · תיק **100:** [`M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md`](./M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md) · בקשת **QA-1** (טיוטה): [`M3-QA-1-READINESS-REQUEST-TEAM10-2026-04-01.md`](./M3-QA-1-READINESS-REQUEST-TEAM10-2026-04-01.md)  
**מקור מבנה:** [`hub/data/site-tree.json`](../../hub/data/site-tree.json)  
**אימות סטייג'ינג:** `https://eyalamit-co-il-2026.s887.upress.link` (REST `wp/v2/pages`, `curl -kL` לפי מדיניות TLS סטייג'ינג) · עדכון מצב M2: [`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](./M2-IMPLEMENTATION-SUMMARY-2026-04-01.md) §4  

**גרסת מטריצה:** **v2** — **v1** נשמר כבסיס שורות; **QA-1** סגור ב־50 (2026-04-07) — [`../team_50/M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md) · **`PASS WITH NOTES`**. **QA-2** סגור ב־50 (2026-04-07) — [`../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md) · **`PASS WITH NOTES`** · **M3-M4 לא מאושר** (שער **Q1-6**). **עמודות סטטוס** בשורות 12–48 — לעדכן לפי מצב סטייג’ינג סופי. נספח **C** — מעקב **Q1-6**. נספח **E** — מעקב **M3-M3** + תיקונים נדרשים ([`M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md)).

הוראות מקור: מילוי עמודות **סטטוס WP**, **מקור legacy**, **סטטוס תוכן**. צומת שאינו עמוד ציבורי יחיד — `N/A` בעמודת סטטוס WP + נימוק ב**הערות**. טקסטים חסרים: `PLACEHOLDER` + **R#** מ־[`M3-TEXT-PLACEHOLDER-REQUIREMENTS-FOR-RESEARCH-2026-04-07.md`](../team_100/M3-TEXT-PLACEHOLDER-REQUIREMENTS-FOR-RESEARCH-2026-04-07.md).

| pageId | כותרת (עץ) | slug | templateId | legacy (URL או הערה מ־עץ) | סטטוס WP (טיוטה/חי/אין) | סטטוס תוכן (legacy/חלקי/PLACEHOLDER) | הערות |
|--------|------------|------|------------|---------------------------|--------------------------|----------------------------------------|--------|
| `st-home` | דף הבית | `home` | `tpl-home` | https://www.eyalamit.co.il/ | חי | חלקי | מזהה WP סטייג'ינג **16**; מוקאף דשבורד (D-EYAL-HOME-01) + תוכן legacy למיגרציה מלאה. |
| `st-svc-treatment` | טיפול בדיג'רידו | `treatment` | `tpl-service` | https://www.eyalamit.co.il/%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%94%d7%9e%d7%a8%d7%9b%d7%96-%d7%9c%d7%98%d7%99%d7%a4%d7%95%d7%9c-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a1%d7%98%d7%95%d7%93%d7%99/%d7%94%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%9b%d7%9b%d7%9c%d7%99-%d7%9c%d7%a8%d7%99%d7%a4%d7%95%d7%99-%d7%a2%d7%a6%d7%9e%d7%99/ (wp_id **18239** SSOT) | חי | legacy | סטייג'ינג slug **`treatment`** תואם עץ; ב-M2 היה גם `didgeridoo-treatment-breath` תחת שירותים — איחוד תוכן ב-M3. |
| `st-method` | השיטה | `method` | `tpl-method` | עמוד מקביל בלגסי דרך מבנה האתר; SSOT — השוואה ל־`hashita` אם נדרש | חי | חלקי + **R8** | סטייג'ינג **`method`** (מזהה **55**); קיים גם **`hashita`** (מזהה **17**) מסידור M2 — יישור תוכן/slug לעץ נעול ב-M3-M2 באישור 100 אם נדרש. |
| `st-svc-lessons` | שיעורי דיג'רידו | `lessons` | `tpl-service` | https://www.eyalamit.co.il/%d7%a9%d7%99%d7%a2%d7%95%d7%a8%d7%99-%d7%a0%d7%92%d7%99%d7%a0%d7%94-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95/ (wp_id **18059** SSOT) | חי | legacy | סטייג'ינג **`lessons`**; ב-M2 גם `didgeridoo-lessons` תחת שירותים. |
| `st-svc-sound` | סאונד הילינג | `sound-healing` | `tpl-service` | מקורות SSOT: wp_id **18063** (טיפולי סאונד), **18236** (כותרת מורחבת) — לאחד לפי החלטת תוכן | חי | חלקי | סטייג'ינג **`sound-healing`**; כפילות שורות ב-REST — לנקות/ליישר ב-M3. |
| `st-learning-hub` | לימוד והכשרה | `learning` | `tpl-nav-hub` | מבנה לימודים בלגסי דרך עמודי משנה (סדנאות, הרצאות וכו') | חי | חלקי | סטייג'ינג **`learning`**; מבוא hub — **PLACEHOLDER** אופציונלי (ללא R# ייעודי בטבלת המחקר — ניתן לבקש ממחקר אם נדרש). |
| `st-trainings` | הכשרות למטפלים | `therapist-training` | `tpl-placeholder` | עמוד יעד בלגסי לפי SSOT / תפריט | חי | legacy | **Yoast noindex** בזריעה M2 (F10); סטייג'ינג **`therapist-training`**. |
| `st-courses` | קורסים (סקולר / חיצוני) | `courses-external` | `tpl-external-menu` | עמוד **פנימי** + קישורים **החוצה** לרכישה ולקורס | חי | חלקי | **G3 — טופל במאגר (2026-04-01):** תוכן נחיתה + שני קישורי חוץ (פילטרים `ea_m4_courses_purchase_url` / `ea_m4_courses_learn_url`); T3 = עמוד פנימי — סנכרון עץ **v3** — [`ea-m2-site-tree-lock-sync-once.php`](../../site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php) · MU — [`ea-m4-g2348-governance-once.php`](../../site/wp-content/mu-plugins/ea-m4-g2348-governance-once.php). |
| `st-svc-lectures` | הרצאות | `lectures` | `tpl-lecture-product` | לפי SSOT / עמוד שירות בלגסי | חי | legacy | סטייג'ינג **`lectures`**; כפילות מזהים ב-REST — לבחור עמוד קנוני. |
| `st-svc-workshops` | סדנאות | `workshops` | `tpl-service` | https://www.eyalamit.co.il/%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%94%d7%9e%d7%a8%d7%9b%d7%96-%d7%9c%d7%98%d7%99%d7%a4%d7%95%d7%9c-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a1%d7%98%d7%95%d7%93%d7%99/%d7%a1%d7%93%d7%a0%d7%90%d7%95%d7%aa-%d7%91%d7%a0%d7%99%d7%99%d7%94-%d7%a2%d7%a6%d7%9e%d7%99%d7%aa-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95/ (wp_id **18061**) | חי | legacy | סטייג'ינג **`workshops`**; כפילות שורות REST — ליישר. |
| `st-didg-gear-hub` | כלים ואביזרים | `tools-and-accessories` | `tpl-nav-hub` | שער כלים בלגסי (מבנה תתי־עמודים) | חי | חלקי | סטייג'ינג **`tools-and-accessories`**. |
| `st-svc-handmade` | כלים בעבודת יד ואביזרים | `instruments` | `tpl-service` | https://www.eyalamit.co.il/%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%94%d7%9e%d7%a8%d7%9b%d7%96-%d7%9c%d7%98%d7%99%d7%a4%d7%95%d7%9c-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a1%d7%98%d7%95%d7%93%d7%99/%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%9c%d7%9e%d7%9b%d7%99%d7%a8%d7%94-%d7%9b%d7%9c%d7%99%d7%9d-%d7%91%d7%a2%d7%91%d7%95%d7%93%d7%aa-%d7%99%d7%93/ (wp_id **18209**) | חי | legacy | סטייג'ינג **`instruments`**; ב-M2 גם **`handmade-instruments`** — איחוד. |
| `st-svc-repair` | תיקון וחידוש כלים | `repair` | `tpl-service` | https://www.eyalamit.co.il/%d7%aa%d7%99%d7%a7%d7%95%d7%9f-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95/ (wp_id **18067** SSOT); מקביל: נתיב ארוך תחת מרכז | חי | legacy | **G2 — טופל במאגר (2026-04-01):** קנוני `repair` תחת `tools-and-accessories`; כפיל `instrument-repair` → טיוטה; 301 — גם `/instrument-repair/` — [`ea-m4-g2348-governance-once.php`](../../site/wp-content/mu-plugins/ea-m4-g2348-governance-once.php) + [`ea-m2-site-tree-lock-sync-once.php`](../../site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php). |
| `st-books` | מוזה הוצאה לאור | `muzeh` | `tpl-books` | https://www.eyalamit.co.il/%d7%9e%d7%95%d7%96%d7%94-%d7%94%d7%95%d7%a6%d7%90%d7%94-%d7%9c%d7%90%d7%95%d7%a8/ (wp_id **14726**) | חי | legacy | סטייג'ינג **`muzeh`**; ב-M2 גם **`books`** — ספרים כפולים; איחוד גריד. |
| `st-book-tsva` | צבע בכחול וזרוק לים | `muzeh/tsva-bechol-ve-zorek-layam` | `tpl-secondary` | לא נמצא בשורת SSOT מלאה — לאמת מול פרודקשן; סטייג'ינג מוכן | חי | חלקי | **G4 — שלד במאגר (2026-04-01):** גוף placeholder לפי דרישות מחקר — [`ea-m4-g2348-governance-once.php`](../../site/wp-content/mu-plugins/ea-m4-g2348-governance-once.php); אימות URL legacy מלא — **M5/cutover**. |
| `st-book-kushi` | כושי בלאנטיס | `muzeh/kushi-blantis` | `tpl-book-detail` | https://www.eyalamit.co.il/%d7%9e%d7%95%d7%96%d7%94-%d7%94%d7%95%d7%a6%d7%90%d7%94-%d7%9c%d7%90%d7%95%d7%a8/%d7%9b%d7%95%d7%a9%d7%99-%d7%91%d7%9c%d7%90%d7%a0%d7%98%d7%99%d7%a1-%d7%90%d7%95%d7%98%d7%95%d7%91%d7%99%d7%95%d7%92%d7%a8%d7%a4%d7%99%d7%94-%d7%91%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d/ (wp_id **15955**) | חי | חלקי | POC Hub: [`hub/...poc-kushi-blantis...`](../../hub/) — תוכן ספר + כפתורי Morning/מנדלי per עץ. |
| `st-book-vekatavt` | וכתבת | `muzeh/vekatavt` | `tpl-secondary` | https://www.eyalamit.co.il/%d7%95%d7%9b%d7%aa%d7%91%d7%aa-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa/ (wp_id **19429**) | חי | legacy | סטייג'ינג **`vekatavt`**. |
| `st-blog` | בלוג דיג'רידו | `blog` | `tpl-blog-archive` | https://www.eyalamit.co.il/%d7%91%d7%9c%d7%95%d7%92-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%94%d7%9e%d7%a8%d7%9b%d7%96-%d7%9c%d7%98%d7%99%d7%a4%d7%95%d7%9c-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%90/ (wp_id **14728**) | חי | legacy + **R9** | מבוא ארכיון — **R9** אם חסר מלל משמעותי לאחר מיגרציה. |
| `st-blog-post` | פוסט בודד בבלוג | `blog/post-slug` | `tpl-secondary` | פוסטים בלגסי (CPT post) | **N/A** | **N/A** | ייצוג סכימתי בלבד — מאות עמודים דינמיים; לא שורת «עמוד WP יחיד». |
| `st-eyal-hub` | אייל עמית | `eyal-amit` | `tpl-about` | https://www.eyalamit.co.il/%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%95%d7%93%d7%95%d7%aa/ (wp_id **19477**) | חי | legacy | סטייג'ינג **`eyal-amit`**. |
| `st-mokesh` | מוקש דהימן — לזכרו | `mokesh-dahiman` | `tpl-memorial` | https://www.eyalamit.co.il/%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%94%d7%9e%d7%a8%d7%9b%d7%96-%d7%9c%d7%98%d7%99%d7%a4%d7%95%d7%9c-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a1%d7%98%d7%95%d7%93%d7%99/%d7%9e%d7%95%d7%a7%d7%a9-%d7%93%d7%94%d7%99%d7%9e%d7%9f-%d7%9e%d7%90%d7%a1%d7%98%d7%a8-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%93%d7%a3-%d7%9c%d7%94%d7%a0%d7%a6%d7%97%d7%aa-%d7%96%d7%9b/ (wp_id **18327** SSOT) | חי | legacy | M2 F9: 301 מ־slug ישן — לוודא במיגרציה. |
| `st-contact` | צור קשר | `contact` | `tpl-contact` | https://www.eyalamit.co.il/%d7%a6%d7%95%d7%a8-%d7%a7%d7%a9%d7%a8/ | חי | legacy | Fluent **`[fluentform id=1]`** — סטייג'ינג **`contact`**. |
| `st-en` | אנגלית (EN) | `en` | `tpl-en-landing` | — | חי | **PLACEHOLDER R14** | סטייג'ינג **`en`** + מחלקת גוף LTR; רודמאפ — טקסט מינימלי per מחקר. |
| `st-media` | המלצות — קטלוג מרכזי (ומדיה) | `media` | `tpl-media` | **מדיה אחת מאוחדת**; **המלצות** = **קטגוריה** בקטלוג | חי | **PLACEHOLDER R5** | **G8 — טופל במאגר (2026-04-01):** טקסונומיה **`ea_testimonial_cat`** (מונח `המלצות` / slug `recommendations`); עמוד `testimonials-media` → טיוטה; 301 ל־`/media/`; שיבוץ טקסונומיה לזריעה — [`ea-m4-g2348-governance-once.php`](../../site/wp-content/mu-plugins/ea-m4-g2348-governance-once.php) + תבנית [`template-media-catalog.php`](../../site/wp-content/themes/ea-eyalamit/page-templates/template-media-catalog.php). |
| `st-extra-pages` | עמודים נוספים | `extra-pages-virtual` | `tpl-secondary` | — | **N/A** | **N/A** | צומת **וירטואלי** ל-IA / פוטר — אין עמוד WP בודד בשם זה. |
| `st-faq` | שאלות נפוצות (FAQ) | `faq` | `tpl-entity-catalog` | שאלות בלגסי / מבנה Toolset (היסטורי) | חי | **PLACEHOLDER R1, R2** | סטייג'ינג **`faq`**; מבוא ו-taxonomy note מהמחקר. **M3-M3:** CPT **`ea_faq`** + [`template-faq-catalog.php`](../../site/wp-content/themes/ea-eyalamit/page-templates/template-faq-catalog.php); זריעה — `ea-m3-seed-instances-once.php`. |
| `st-gallery-cms` | ניהול גלריות (ממשק מערכת) | `gallery-management-internal` | `tpl-secondary` | — | **N/A** | **N/A** | ממשק מערכת — לא עמוד ציבורי; הקטלוג הציבורי: **`st-galleries-catalog`**. |
| `st-galleries-catalog` | גלריות — קטלוג מרכזי | `galleries` | `tpl-entity-catalog` | גלריות בלגסי (Envira וכו') | חי | **R1–R2 מולאו בסטייג’ינג (2026-04-08)**; legacy מלאי — **DEFERRED 100** | סטייג'ינג **`galleries`**; מבוא ומחיצות per מחקר. **M3-M3:** CPT **`ea_gallery`** + [`template-galleries-catalog.php`](../../site/wp-content/themes/ea-eyalamit/page-templates/template-galleries-catalog.php); מפרט מיגרציה — [`M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md`](./M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md) · מנדט [`M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md`](./M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md). |
| `st-404` | עמוד 404 | `404` | `tpl-secondary` | — | **N/A** | **N/A** | תבנית שגיאת תמה — לא רשומת `page` ב-`wp/v2/pages`. |
| `st-privacy` | מדיניות פרטיות | `privacy` | `tpl-legal` | — | חי | **PLACEHOLDER R13** | סטייג'ינג **`privacy`**; טקסט משפטי סופי מחוץ לפרויקט. |
| `st-legal-access` | הצהרת נגישות | `accessibility` | `tpl-legal` | — | חי | **PLACEHOLDER R13** | סטייג'ינג **`accessibility`** (שם M2 היה `accessibility-statement` — יושר לעץ). |
| `st-legal-terms` | תקנון | `terms` | `tpl-legal` | https://www.eyalamit.co.il/%d7%aa%d7%a7%d7%a0%d7%95%d7%9f/ (wp_id **17217** SSOT) | חי | legacy | סטייג'ינג **`terms`**. |
| `st-thankyou` | תודה אחרי טפסים | `thank-you` | `tpl-secondary` | — | חי | חלקי | סטייג'ינג **`thank-you`**; קישור מטפסים Fluent (F9). |
| `st-html-sitemap` | מפת אתר HTML (אופציונלי) | `sitemap` | `tpl-secondary` | — | **אין** | **PLACEHOLDER** | לא נזרע ב-M2; אופציונלי M3+ / SEO. |
| `st-services-hub` | דף מאגר «שירותים» (legacy v2.3) | `services` | `tpl-nav-hub` | מבנה שירותים בלגסי | חי | legacy | סטייג'ינג **`services`**; לא בתפריט החדש (§4.1 M2) — שימור למיגרציה/הפניות. |

---

## נספח A — ספירת כיסוי

- **צמתים ב־`site-tree.json`:** 35  
- **שורות במטריצה:** 35  
- **שורות `N/A` (סטטוס WP):** 4 (`st-blog-post`, `st-extra-pages`, `st-gallery-cms`, `st-404`)  
- **שורות `אין`:** 1 (`st-html-sitemap`)

---

## נספח B — ארטיפקטי M3-M2 במאגר (2026-04-01)

| מסמך | תפקיד |
|------|--------|
| [`M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md`](./M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md) | פריטים לאישור **צוות 100** לפני שינוי slug/הורה וסגירת כפילויות REST |
| [`M3-M2-STAGING-EXECUTION-CHECKLIST-TEAM10-2026-04-01.md`](./M3-M2-STAGING-EXECUTION-CHECKLIST-TEAM10-2026-04-01.md) | רשימת ביצוע סטייג’ינג (שלד · תוכן · ניווט · מסירה) |
| [`M3-QA-1-READINESS-REQUEST-TEAM10-2026-04-01.md`](./M3-QA-1-READINESS-REQUEST-TEAM10-2026-04-01.md) | בקשת מוכנות **QA-1** + **פלט מצוות 50** (דוח FINAL 2026-04-07) |
| [`M3-M3-STAGING-INSTANCES-CHECKLIST-TEAM10-2026-04-01.md`](./M3-M3-STAGING-INSTANCES-CHECKLIST-TEAM10-2026-04-01.md) | רשימת ביצוע סטייג’ינג M3-M3 (אינסטנסים) |
| [`M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md`](./M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md) | מפרט מיגרציית גלריות (מלאי, 150KB, ללא upload מתים) |
| [`M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-01.md`](./M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-01.md) | בקשת **QA-2** — מסירה סופית לצוות **50** (עודכן אחרי פריסה 2026-04-01) |
| [`M3-QA-2-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md`](./M3-QA-2-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md) | ארטיפקט פריסת FTP מלאה + אימות `curl` לשערי M3-M3 |
| [`M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md) | הגשה חוזרת אחרי דוח QA-2 FINAL + תוכנית תיקון (**Q1-6**, מיפוי גלריות, מדיה) |
| [`../team_50/M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md`](../team_50/M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md) | **DOC-SYNC** — **`PASS`** על מסמך ההגשה החוזרת (תיעוד בלבד) |
| [`M3-M3-COMPLETION-HANDOFF-TEAM10-TO-TEAM100-2026-04-08.md`](./M3-M3-COMPLETION-HANDOFF-TEAM10-TO-TEAM100-2026-04-08.md) | דוח **השלמה** לצוות **100** (סיכום לולאת M3-M3 + QA-2 + DOC-SYNC) |
| [`../../site/wp-content/mu-plugins/ea-m4-g2348-governance-once.php`](../../site/wp-content/mu-plugins/ea-m4-g2348-governance-once.php) | **G2/G3/G4/G8** — מנדט §8 (איחוד repair, קורסים, שלד צבע, מדיה+טקסונומיה) |

---

## נספח C — מעקב הערות QA-0 (שער **Q1-6**)

**QA-1 סגור (2026-04-07):** שלושת שורות ה־REST למטה **אומתו** בדוח [`../team_50/M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md) — כפילות נשארת · **סגירה מול 100** לפני **QA-2**.

| נושא | pageId / slug | סטטוס מעקב | בעלים |
|------|----------------|------------|--------|
| כפילויות REST | `st-svc-lectures` / `lectures` | **נסגר טכנית** — ריטסט QA-2 2026-04-08 + G5–G7 | — |
| כפילויות REST | `st-svc-sound` / `sound-healing` | **נסגר טכנית** — כנ״ל | — |
| כפילויות REST | `st-svc-workshops` / `workshops` | **נסגר טכנית** — כנ״ל | — |
| יישור slug / כפיל | `st-method` מול `hashita` | **DEFERRED מאושר (100)** — **M4/M5** | [`M3-GOVERNANCE-G1G4G8-DECISIONS-TEAM100-2026-04-07.md`](../team_100/M3-GOVERNANCE-G1G4G8-DECISIONS-TEAM100-2026-04-07.md) §2 G1 |
| יישור slug / כפיל | `st-svc-repair` מול `instrument-repair` | **טופל במאגר** — MU **G2** + 301 — [`ea-m4-g2348-governance-once.php`](../../site/wp-content/mu-plugins/ea-m4-g2348-governance-once.php) | §8 מסירה ל־10 |
| איחוד מדיה | `st-media` מול `testimonials-media` | **טופל במאגר** — טקסונומיה + טיוטת כפיל + תבנית — MU **G8** (אותו קובץ) | §8 |
| קורסים חיצוניים / T3 | `st-courses` | **טופל במאגר** — תוכן G3 + T3 פנימי (סנכרון **v3**) | §8 **G3** |
| DEFERRED legacy | `st-book-tsva` | **שלד במאגר** — placeholders G4; אימות לייב **M5/cutover** | §8 **G4** |

*לאחר החלטות **100** וביצוע בסטייג’ינג — לעדכן «סטטוס מעקב» ל־**טופל**; לפני **QA-2** — חובה לסגור **Q1-6** (שלושת ה־slugs לעיל) או waiver מתועד.*

**עדכון QA-2 FINAL (2026-04-07):** בדוח [`../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md) — **Q1-6 / waiver: לא התקיים**; **אישור M3-M4: לא מאושר עדיין**. ראו [`M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md).

---

## נספח D — סריקת HTTP לנתיבי צמתים «חי» (טיוטת Q1-1, 2026-04-01)

בסיס: `https://eyalamit-co-il-2026.s887.upress.link` · פקודה: `curl -sS -o /dev/null -w "%{http_code}" -kL <URL>`  
**חרגו מסריקה (לא עמוד ציבורי יחיד / אין):** `st-blog-post`, `st-extra-pages`, `st-gallery-cms`, `st-404`, `st-html-sitemap` (**30** נתיבים).

| pageId | נתיב | קוד HTTP סופי |
|--------|------|----------------|
| `st-home` | `/home/` | 200 |
| `st-svc-treatment` | `/treatment/` | 200 |
| `st-method` | `/method/` | 200 |
| `st-svc-lessons` | `/lessons/` | 200 |
| `st-svc-sound` | `/sound-healing/` | 200 |
| `st-learning-hub` | `/learning/` | 200 |
| `st-trainings` | `/therapist-training/` | 200 |
| `st-courses` | `/learning/courses-external/` | 200 |
| `st-svc-lectures` | `/lectures/` | 200 |
| `st-svc-workshops` | `/workshops/` | 200 |
| `st-didg-gear-hub` | `/tools-and-accessories/` | 200 |
| `st-svc-handmade` | `/instruments/` | 200 |
| `st-svc-repair` | `/repair/` | 200 |
| `st-books` | `/muzeh/` | 200 |
| `st-book-tsva` | `/muzeh/tsva-bechol-ve-zorek-layam/` | 200 |
| `st-book-kushi` | `/muzeh/kushi-blantis/` | 200 |
| `st-book-vekatavt` | `/muzeh/vekatavt/` | 200 |
| `st-blog` | `/blog/` | 200 |
| `st-eyal-hub` | `/eyal-amit/` | 200 |
| `st-mokesh` | `/mokesh-dahiman/` | 200 |
| `st-contact` | `/contact/` | 200 |
| `st-en` | `/en/` | 200 |
| `st-media` | `/media/` | 200 |
| `st-faq` | `/faq/` | 200 |
| `st-galleries-catalog` | `/galleries/` | 200 |
| `st-privacy` | `/privacy/` | 200 |
| `st-legal-access` | `/accessibility/` | 200 |
| `st-legal-terms` | `/terms/` | 200 |
| `st-thankyou` | `/thank-you/` | 200 |
| `st-services-hub` | `/services/` | 200 |

---

## נספח E — מעקב M3-M3 (אינסטנסים, 2026-04-01)

| רכיב | מיקום במאגר | סטטוס מאגר |
|------|-------------|------------|
| CPT **`ea_faq`** | [`site/wp-content/themes/ea-eyalamit/functions.php`](../../site/wp-content/themes/ea-eyalamit/functions.php) | **מומש** |
| CPT **`ea_gallery`** | אותו קובץ | **מומש** |
| CPT **`ea_testimonial`** | אותו קובץ | **מומש** |
| זריעת דוגמה (פעם אחת) | [`site/wp-content/mu-plugins/ea-m3-seed-instances-once.php`](../../site/wp-content/mu-plugins/ea-m3-seed-instances-once.php) | **מומש** |
| מפרט גלריות (טבלת מיפוי) | [`M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md`](./M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md) | **עודכן 2026-04-08** — זריעה `OK`; legacy Envira **DEFERRED** (בעלים **100**) · [`M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md`](./M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md) |
| דגימת מדיה R2 (featured, alt, ≤150KB) | [`ea-m3-r2-featured-sample-once.php`](../../site/wp-content/mu-plugins/ea-m3-r2-featured-sample-once.php) | **מומש במאגר** — ריצה חד־פעמית בסטייג’ינג אחרי פריסה |
| G5–G7 REST dedupe | [`ea-m3-g5g7-q16-rest-dedupe-once.php`](../../site/wp-content/mu-plugins/ea-m3-g5g7-q16-rest-dedupe-once.php) + הפניות ב־[`ea-m2-site-tree-lock-sync-once.php`](../../site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php) | **מומש במאגר** — אימות 50: [`M3-G5G7-STAGING-VERIFY-TEAM10-2026-04-08.md`](./M3-G5G7-STAGING-VERIFY-TEAM10-2026-04-08.md) |
| checklist סטייג’ינג | [`M3-M3-STAGING-INSTANCES-CHECKLIST-TEAM10-2026-04-01.md`](./M3-M3-STAGING-INSTANCES-CHECKLIST-TEAM10-2026-04-01.md) | **עודכן** — קליטת דוח **QA-2 FINAL** |
| דוח **QA-2** (50) | [`../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md) | **`PASS WITH NOTES`** — שער **Q1-6** לא התקיים; **M3-M4** לא מאושר |

**הערת סטייג’ינג (2026-04-01):** **בוצע** — פריסת FTP מלאה + אימות `/faq/`, `/galleries/`, `/media/` (**200**) ותוכן רשימות; ראו [`M3-QA-2-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md`](./M3-QA-2-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md).

**הערת מעקב (2026-04-08):** הגשה חוזרת — [`M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md) · מנדט ביצוע G5–G7 + R1–R4 — [`M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md`](./M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md) · בקשת ריטסט QA-2 — [`M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md`](./M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md).
