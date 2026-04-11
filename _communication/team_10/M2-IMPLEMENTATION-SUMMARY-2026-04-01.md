# M2 — סיכום יישום G2 (צוות 10)

**תאריך:** 2026-04-01 · **עדכון מנדט / TLS:** 2026-04-02 · **עדכון סטטוס פאנל / בסיס:** 2026-03-29 (נימרוד) · **תשתית מקומית + מדיה §3.2:** 2026-04-03 · **נגישות — WP Accessibility + מסמך הגדרות/QA:** 2026-04-09 · **QA FINAL צוות 50 (ריטסט IA):** 2026-04-06 · **§11 / סגירת M2 (צוות 100):** 2026-04-06 — [`M2-G4-ACCEPTANCE-M2-CLOSEOUT-TEAM100-2026-04-06.md`](../team_100/M2-G4-ACCEPTANCE-M2-CLOSEOUT-TEAM100-2026-04-06.md)  
**מאגר ארטיפקטים:** [`site/`](../../site/README.md)  
**מקורות מנדט:** [`M2-HANDOFF-FROM-20-2026-03-31.md`](./M2-HANDOFF-FROM-20-2026-03-31.md) · [`M2-WORKPLAN-AND-MANDATES-2026-03-30.md`](../team_100/M2-WORKPLAN-AND-MANDATES-2026-03-30.md) §6–§7 · **[`M2-MANDATE-G2-TEAM10-2026-04-02.md`](./M2-MANDATE-G2-TEAM10-2026-04-02.md)**  
**GO מ־100 (שער 20-A / TLS):** [`M2-GATE-20A-AMENDMENT-AND-GO-TEAM10-2026-04-02.md`](../team_100/M2-GATE-20A-AMENDMENT-AND-GO-TEAM10-2026-04-02.md) — **מותר להמשיך G2** ללא המתנה ל־`curl` בלי `-k` תקין על סטייג'ינג.  
**מסלול TLS (חובה לקריאה):** [`STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md)  
**סטטוס G2 (סטייג'ינג):** **P0 הושלם (2026-04-04)** — עמודים, קריאה, תפריט **M2 Primary EA** (מיקום `primary`), Fluent ב־`/contact/`, `noindex` meta ל־**P15** — ראו [`M2-G2-STAGING-P0-DONE-2026-04-04.md`](./M2-G2-STAGING-P0-DONE-2026-04-04.md). **QA צוות 50 (FINAL ריטסט 2026-04-06):** [`M2-SMOKE-REPORT-FINAL-2026-04-06-v2.md`](../team_50/M2-SMOKE-REPORT-FINAL-2026-04-06-v2.md) — **PASS WITH NOTES** (NOTE **F2** — mailbox / `WP Mail Logging` מ־wp-admin). דוח FAIL קודם כנספח audit: [`M2-SMOKE-REPORT-FINAL-2026-04-06.md`](../team_50/M2-SMOKE-REPORT-FINAL-2026-04-06.md). **G2 מוקדם:** [`M2-QA-CANONICAL-FEEDBACK-TEAM50-STAGING-TLS-G2-2026-04-02.md`](../team_50/M2-QA-CANONICAL-FEEDBACK-TEAM50-STAGING-TLS-G2-2026-04-02.md). **תשתית לקליטת תוכן:** **GO** — [`../team_100/M2-CONTENT-INTAKE-INFRASTRUCTURE-GO-TEAM100-2026-04-08.md`](../team_100/M2-CONTENT-INTAKE-INFRASTRUCTURE-GO-TEAM100-2026-04-08.md). **גיבוי uPress:** ☑ · **מקומי:** Docker + WP-CLI (runbook §14) · תשתית Q3: [`M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md`](../team_50/M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md) **PASS**.

---

## 1. קבלת G1 (10.1)

| בדיקה | סטטוס |
|--------|--------|
| קריאת [`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) (כולל **§13** צ׳ק־ליסט פאנל + wp-admin לסביבת פיתוח) | בוצע במסגרת מימוש מסמך זה |
| קריאת M2-WORKPLAN §6 (מנדט G2) | בוצע |
| גישה wp-admin + FTP | **בשימוש** — FTP פריסה מ־[`scripts/ftp_deploy_site_wp_content.py`](../../scripts/ftp_deploy_site_wp_content.py) בוצע (2026-04-04); MU זריעה — ראו §4 |
| URL סטייג'ינג | `https://eyalamit-co-il-2026.s887.upress.link` (מ־runbook) |

### 1.1 בדיקת רשת ו־TLS — **סטייג'ינג אינו מייצג HTTPS פרודקשן** (2026-04-02)

**מחייב לפי צוות 100 + צוות 20:** דוח תשתית [`M2-INFRA-COMPLETION-REPORT-TO-TEAM100-2026-04-01.md`](../team_20/M2-INFRA-COMPLETION-REPORT-TO-TEAM100-2026-04-01.md), ראיות TLS [`M2-GATE-20A-TLS-VERIFICATION-2026-04-02.md`](../team_20/M2-GATE-20A-TLS-VERIFICATION-2026-04-02.md), ומסלול [`STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md).

| נושא | מדיניות |
|------|---------|
| **G2 על סטייג'ינג** | **אין חסימה** בגלל כשל `curl` **ללא** `-k` על URL הסטייג'ינג — תיקון שער **20-A** מאושר ב־[`M2-GATE-20A-AMENDMENT-AND-GO-TEAM10-2026-04-02.md`](../team_100/M2-GATE-20A-AMENDMENT-AND-GO-TEAM10-2026-04-02.md). |
| **סטייג'ינג (`*.upress.link`)** | לפי חשבון uPress: **אינו נדרש** כמייצג SSL מלא כמו בפרודקשן; **אזהרת אמון בדפדפן מותרת** לפי מדיניות הספק. |
| **בדיקות אוטומטיות** | אופציונלי: `curl -I -k` לכותרות; **לא** דורשים אימות תעודה מחמיר כתנאי לסיום משימות G2 כאן. |
| **פרודקשן / cutover** | **אימות TLS מלא** (`curl` **בלי** `-k`, תעודה תקפה) — **חובה לפני השקה / M7**; זה **מחוץ** להגדרת «הצלחת G2 על סטייג'ינג». |

### 1.2 סטטוס בסיס — דיווח מחזיק אתר (**2026-03-29**, נימרוד)

| נושא | סטטוס |
|------|--------|
| **PHP** | **8.3** הוגדר בפאנל |
| **גיבוי** לפני שינוי מהותי | **בוצע** |
| **עברית** | הוגדרה ב־WP |
| **Permalink** | **שם הפוסט** (`/%postname%/`) — הוגדר |
| **GeneratePress** | **מותקנת** |
| **Yoast SEO** | **מותקן** — לפי דיווח **לא נדרש יותר מזה** לשלב זה (P15 noindex — **אחרי** ייבוא עמודים) |
| **Fluent Forms** | **מותקן** — shortcode **`[fluentform id=1]`** בדף **צור קשר** (2026-04-04; עדכון MU v1.0.2 — מונע ישויות HTML ששברו shortcode); לוודא ב־wp-admin טופס מזהה **1** + שליחת בדיקה. אימות 100: [`../team_100/M2-G2-P0-TEAM10-VERIFICATION-BY-100-2026-04-04.md`](../team_100/M2-G2-P0-TEAM10-VERIFICATION-BY-100-2026-04-04.md) |
| **SMTP** | **פעיל** |
| **מטמון** | **Varnish** — **לא** בסטייג'ינג (דורש SSL); מיועד **לאתר הסופי**. חלופות בפאנל (סטטי / אפליקצייתי / מותאם): **מינימום** בפיתוח — ראו [`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) **§13.0**. |
| **אופטימיזציה** (תמונות, CDN, EzCache וכו') | **אחרי עליה לאוויר** |

**מצב טכני — סטייג'ינג אחרי P0 (2026-04-04):**

- **תמה:** child **EA Eyal Amit** + GeneratePress פעילים בפלט; `ea-m2-auto-activate-child` + זריעה חד־פעמית — ראו [`site/README.md`](../../site/README.md).
- **`noindex` סטייג'ינג:** ☑ פעיל (`ea-staging-noindex` + כותרות).

---

## 2. תמה (10.2, 10.3) — נעילה וגרסאות

| רכיב | גרסה / מיקום | הערות |
|------|----------------|--------|
| **GeneratePress (parent)** | *לרשום גרסה מדויקת מ־wp-admin* | ☑ **מותקנת** (2026-03-29) — מ־קטלוג WP / [wordpress.org/themes/generatepress](https://wordpress.org/themes/generatepress/) — **לא** מהמאגר |
| **EA Eyal Amit (child)** | **1.1.0** | [`style.css`](../../site/wp-content/themes/ea-eyalamit/style.css) — טיפוגרפיה/טוקנים דף בית (Rubik) · [`home-front.css`](../../site/wp-content/themes/ea-eyalamit/assets/css/home-front.css) — פריסה בלבד · [`template-home-dashboard.php`](../../site/wp-content/themes/ea-eyalamit/page-templates/template-home-dashboard.php) — ללא inline CSS |
| **קישור `style.css` parent** | בשרת בלבד | אחרי התקנת GeneratePress: `{base}/wp-content/themes/generatepress/style.css` — התבנית **לא** במאגר 2026 |
| **קישור `style.css` child** | במאגר | [`site/wp-content/themes/ea-eyalamit/style.css`](../../site/wp-content/themes/ea-eyalamit/style.css) |

### 2.1 נימוק תמה (§6.3 — F5)

- **GeneratePress + child:** תמיכת **RTL** ידועה במערכת הקלאסית; תאימות **PHP 8.x**; תמה פעילה ומעודכנת; **ללא** page builder כבד; בסיס ל־**Lighthouse** על דף רזה לאחר הפעלה — **למדוד אחרי פריסה**.

### 2.2 שינויי child במסגרת G2 (מאגר)

- מחלקת גוף **`ea-lang-en`** לעמודים עם slug **`en`** או **`english`** + כללי LTR ב־CSS — עמידה ב־**EN LTR** ([`WP-THEME-EVALUATION-HEBREW-SEO-2026-03-29.md`](../../docs/project/team-100-preplanning/WP-THEME-EVALUATION-HEBREW-SEO-2026-03-29.md) §§5–7).
- enqueue נשאר תלוי ב־`generate-style` (GeneratePress).
- **דף בית (2026-04-08):** מימוש **מוקאפ דשבורד אופציה ב׳** — פלטת צבעים ומבנה מ־[`to-eyal/_shared-assets/home-dashboard/`](../../docs/project/eyal-ceo-submissions-and-responses/to-eyal/_shared-assets/home-dashboard/); תמונות אמיתיות מ־legacy ב־`ea-eyalamit/assets/home/`; שער אישור אייל — [`M2-HOME-DASHBOARD-IMPLEMENTATION-STATUS-2026-04-08.md`](./M2-HOME-DASHBOARD-IMPLEMENTATION-STATUS-2026-04-08.md).

---

## 3. תוספים (10.4–10.6)

| תפקיד | בחירה | נימוק קצר (§6.3 / F5) |
|--------|--------|-------------------------|
| **SEO (אחד)** | **Yoast SEO** | sitemap + meta, **noindex לעמוד בודד** (חובה ל־**P15**), Schema בסיסי, בשימוש נרחב בסביבה עברית |
| **טפסים (אחד)** | **Fluent Forms** | שליחה לאימייל, לוגים, honeypot מובנה, טפסים נגישים יחסית |
| **נגישות (כלי עזר)** | **WP Accessibility** (Joe Dolson, wordpress.org) | משלים תמה+תוכן; **לא** תחליף לת"י 5568 — ראו [`M2-WP-ACCESSIBILITY-CONFIG-AND-QA-2026-04-09.md`](./M2-WP-ACCESSIBILITY-CONFIG-AND-QA-2026-04-09.md) · **לא** Enable Accessibility (uPress) |
| **קאש** | **סטייג'ינג:** **ללא Varnish** עד פרודקשן (SSL); מצבי מטמון חלופיים בפאנל — **מינימום** בפיתוח ([runbook §13.0](../team_20/M2-RUNBOOK-ENV-2026-03-31.md)). **פרודקשן:** Varnish + לפי KB; EzCache/TinyPNG/CDN — **אחרי עליה לאוויר**. | **10.6** + [ארכיטקטורה §5.2](../team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md) |

### 3.1 תוספי עזר (אושרו ע״י 100 — uPress)

| תוסף | תפקיד | סטטוס סטייג'ינג (2026-03-29) | נימוק קצר |
|------|--------|------------------------------|-----------|
| **WP Mail Logging** | לוג דוא״ל יוצא מ־WP | **מותקן** | אבחון Fluent + SMTP בסטייג'ינג; בפרודקשן — מדיניות שמירה/הסרה. |
| **LTR RTL Admin** | סידור ממשק אדמין לעברית מול תוספי LTR | **מותקן** | שיפור עבודת עורכים; ללא השפעה על גולשים. |
| **Validator.pizza** | חסימת דומייני מייל זמניים בטפסים | **מותקן** | משלים Fluent; לוודא תאימות אחרי עדכונים. |

### 3.2 מדיניות מדיה (תמונות) — **ננעלה ל־M2 (2026-04-03)**

**החלטה (יישום מלא תשתית):** חלופה **ד — היברידי** לפי [`M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md`](../team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md) §4: **שלב 1** — אופטימיזציה/אצווה **מחוץ ל־WordPress** לפני/במקביל למיגרציית ספרייה כבדה; **שלב 2** — **`TinyPNG` (Compress JPEG & PNG)** עם **API key מחוץ ל־Git** לשמירה על גודל בעתיד; **לא** להפעיל במקביל TinyPNG מלא + EzCache WebP אגרסיבי בלי בדיקת כפילות (ראו §4.3 באותו מסמך).  
**נעילת גדלים:** לפני «חידוש תמונות מוקטנות» — לנעול גדלי תמונה בתמה/WP כמתועד ב־§4.1.

**גרסת Yoast (מפלט ציבורי):** **27.3** (נצפה ב־HTML, 2026-04-04). **Fluent:** לרשום מספר גרסה מ־wp-admin אם נדרש לאינבנטורי 30.

**Elementor / Woo / כבדים:** לא מתוכננים ב־M2 ללא waiver מ־100 — **יעד: לא פעילים**.

---

## 4. מלאי עמודים §7 — slug יעד וייבוא

**מימוש בסטייג'ינג (2026-04-04):** MU [`ea-m2-seed-shell-once.php`](../../site/wp-content/mu-plugins/ea-m2-seed-shell-once.php) — זריעה חד־פעמית (אופציה `ea_m2_shell_seed_v1`); שקול לייבוא [`m2-pages-seed.wxr`](../../site/exports/m2-pages-seed.wxr). **מזהי WP** מ־REST ציבורי אחרי הזריעה.  
**דף לדוגמה (Sample Page):** עדיין קיים (מזהה 2) — אופציונלי להסיר/לטיוטה.

| ID | כותרת (תצוגה) | הורה | Slug בפועל (יעד) | מזהה WP | הערות |
|----|----------------|------|-------------------|---------|--------|
| P01 | בית | — | `home` | **16** | דף בית סטטי (קריאה) |
| P02 | השיטה | — | `hashita` | **17** | |
| P03 | שירותים | — | `services` | **6** | |
| P04 | שיעורי דיג'רידו / נגינה | שירותים | `didgeridoo-lessons` | **7** | |
| P05 | טיפול בדיג'רידו / נשימה | שירותים | `didgeridoo-treatment-breath` | **8** | |
| P06 | סאונד הילינג / מדיטציית דיג'רידו | שירותים | `sound-healing` | **9** | |
| P07 | סדנאות | שירותים | `workshops` | **10** | |
| P08 | תיקון וחידוש כלים | שירותים | `instrument-repair` | **11** | |
| P09 | כלים בעבודת יד ואביזרים | שירותים | `handmade-instruments` | **12** | placeholder מספיק |
| P10 | הרצאות | שירותים | `lectures` | **13** | |
| P11 | אייל עמית | — | `eyal-amit` | **14** | |
| P12 | בלוג | — | `blog` | **18** | עמוד פוסטים (קריאה) |
| P13 | המלצות ומדיה | — | `testimonials-media` | **19** | |
| P14 | ספרים | — | `books` | **20** | |
| P15 | הכשרות למטפלים | — | `therapist-training` | **21** | **F10:** `_yoast_wpseo_meta-robots-noindex` = `1` (זריעה) |
| P16 | צור קשר | — | `contact` | **22** | Fluent shortcode id=**1** |
| P17 | הופעות / מורשת מופע | — | `shows-heritage` | **23** | |
| P18 | כתבות היסטוריות | — | `historical-articles` | **24** | אופציונלי |
| P19 | English | — | `en` | **25** | LTR + `ea-lang-en` ☑ |
| P20 | הצהרת נגישות | — | `accessibility-statement` | **26** | |
| P21 | תקנון | — | `terms` | **27** | |
| P22 | עמוד קטלוג ראשי | — | **`shop`** | **28** | **F16:** **UNVERIFIED** מול אתר חי |
| P23 | מוקש דהימן — לזכרו | אייל עמית | `moked-dehiman` | **15** | **F9:** 301 ב־מיגרציה |
| P24 | תודה | — | `thank-you` | **29** | **F9:** לקשר מטפסים אם בשימוש |
| — | קורסים — בקרוב (פנימי) | — | `courses-soon` | **30** | **F11-b** ל־T3 |

### 4.1 יישור לעץ אתר נעול (2026-04-06)

**מקור אמת ל־IA ותפריט:** [`hub/data/site-tree.json`](../../hub/data/site-tree.json) (`treeApprovedDocRef`).  
- **אין חנות** בעץ הנעול — סליקה בכפתורים חיצוניים בלבד. שורת **P22 / shop** בטבלה לעיל משקפת **מצב סטייג’ינג/ייבוא ישן**; לתפריט ול־QA סופי — **לא** נדרש עמוד חנות.  
- **קורסים:** בעץ — **`st-courses`** (`courses-external`, **`tpl-external-menu`**) תחת **לימוד והכשרה**. יש לסנכרן תפריט מ־`courses-soon` פנימי לקישור חיצוני מאושר כשמוגדר URL סופי.  
- **דף בית:** נעול למוקאף **`home-visual-sketch-final-rtl.html`** (**D-EYAL-HOME-01**).

---

## 5. תפריטים (10.8, 10.9)

**מיקום:** מראה → תפריטים — תפריט ראשי עברית + פריט ל־EN.

| מיקום | סוג | יעד מומלץ | הערה |
|-------|-----|-----------|------|
| T1 | פנימי | בית (`home`) | |
| T2 | מבנה | השיטה; שירותים + כל הילדים (P04–P10); אייל עמית (+ אופציונלי תת־פריט מוקש); בלוג; המלצות; ספרים; צור קשר | |
| T3 | פנימי (זמני) | **קורסים — בקרוב** (`courses-soon`) | **F11-b** עד קישור סקולר אמיתי מ־אייל/100 — **לא** לפרסם 404 |
| T4 | פנימי | הכשרות למטפלים | |
| T5 | פנימי | הופעות / מורשת מופע | ניווט משני |
| T6 | פנימי | English (`en`) | **10.9** |

---

## 6. סעיפי מסגרת (F5, F6, F9, F10, F11, F15, F16)

| סעיף | מימוש / סטטוס |
|------|----------------|
| **F5** | נימוקי תמה + Yoast + Fluent — ראו §§2–3 |
| **F6** | Child פעיל עם `Template: generatepress` ב־`style.css` |
| **F9** | P23/P24 קיימים בסטייג'ינג (מזהים 15, 29) — לקשר תודה מטפסים אם נדרש |
| **F10** | P15: **noindex** — `_yoast_wpseo_meta-robots-noindex` הוגדר בזריעה; לוודא ב־Yoast UI |
| **F11** | T3 → `courses-soon` (פנימי) עד URL חיצוני מאושר |
| **F15** | **`GREEN_INVOICE_STATUS`:** `UNVERIFIED` — URL חשבונית ירוקה יתועד ב־M4 כשזמין |
| **F16** | **P22** נשאר **`UNVERIFIED`** מול `https://www.eyalamit.co.il/` עד אימות slug בחיים + אישור 100 אם סטייה |

---

## 7. Permalink (handoff §3.6, 20.3a)

- **יעד:** `/%postname%/`  
- **אימות:** ☑ **הוגדר ב־wp-admin** — מבנה **שם הפוסט** (דיווח 2026-03-29).

---

## 8. אינדקס QR (10.11)

**סטטוס:** `DEFERRED` — מדיניות [`QR-URL-POLICY.md`](../../docs/project/team-100-preplanning/QR-URL-POLICY.md): אין שינוי נתיבי QR; אינדקס ניהולי מלא יתאים ל־M3+ / כלי פנימי — **לא נחסם ע"י היעדר אינדקס ציבורי ב־M2**.

---

## 9. CHANGELOG-G3 (§2.2 — לעדכן אחרי תחילת G3)

| תאריך | שינוי |
|--------|--------|
| **2026-03-29** | **IA:** טבלת תפריט ראשי נעולה מול `site-tree.json` — [`M2-MENU-PRIMARY-LOCKED-FROM-SITE-TREE-2026-03-29.md`](./M2-MENU-PRIMARY-LOCKED-FROM-SITE-TREE-2026-03-29.md). **פיתוח:** תבנית `template-faq-catalog.php` + MU `ea-m2-ia-slug-fixups-once.php` (faq/media/galleries/method); קישורי בית ל־`/method/`. **G3:** מדריך מפעיל §D5.1 (ספאם/טפסים). |
| **2026-04-10** | **G3:** מדריך מפעיל + מלאי תוספים — [`../team_30/M2-OPERATOR-GUIDE-DRAFT-2026-04-10.md`](../team_30/M2-OPERATOR-GUIDE-DRAFT-2026-04-10.md), [`../team_30/M2-PLUGIN-INVENTORY-2026-04-10.md`](../team_30/M2-PLUGIN-INVENTORY-2026-04-10.md). **IA:** §4.1 יישור ל־`site-tree.json` נעול (בלי חנות; קורסים חיצוני). **QA:** מנדט מרוכז ל־50 — [`../team_50/M2-QA-CONSOLIDATED-MANDATE-TEAM50-2026-04-10.md`](../team_50/M2-QA-CONSOLIDATED-MANDATE-TEAM50-2026-04-10.md). |
| **2026-04-04** | **P0 סטייג'ינג:** MU `ea-m2-seed-shell-once` + פריסת FTP; עמודים §7, קריאה, תפריט `primary`, Fluent shortcode, Yoast P15; דוח [`M2-G2-STAGING-P0-DONE-2026-04-04.md`](./M2-G2-STAGING-P0-DONE-2026-04-04.md). |
| **מעודכן** | **גיבוי uPress** — בוצע (אישור מחזיק). **העברה לצוות 50** — חומר לריטסט הועבר; צוות 10: Fluent/handoff/M10-15 + מענה לדוח ריטסט. |
| **2026-04-02** | תיעוד מנדט + TLS: GO מ־100; סטייג'ינג ≠ HTTPS פרודקשן; אימות TLS מלא ל־M7 — ראו §1.1. |
| **2026-03-29** | תוספי עזר (§3.1) + **דיווח נימרוד:** PHP 8.3, גיבוי, עברית, permalinks, GP, Yoast, Fluent, SMTP; Varnish נדחה לפרודקשן; אופטימיזציה אחרי אוויר — §1.2, [runbook §13.0](../team_20/M2-RUNBOOK-ENV-2026-03-31.md); מדיניות מדיה במסמך 100 §4. |
| **2026-03-29** | **QA צוות 50:** [`M2-G2-QA-BRIEF-FOR-TEAM50-2026-03-29.md`](../team_50/M2-G2-QA-BRIEF-FOR-TEAM50-2026-03-29.md); סקריפט אימות מאגר [`scripts/verify_m2_g2_repo_artifacts.sh`](../../scripts/verify_m2_g2_repo_artifacts.sh); §12 — עמודת סטטוס מאגר/סטייג'ינג. |

שינויי אתר מ־**2026-04-04** — ראו שורת **2026-04-04** בטבלה לעיל (לפני G3 רשמי).

---

## 10. סדר פריסה מומלץ (סיכום handoff §3)

1. גיבוי uPress + תיעוד ב־runbook §7.  
2. התקנת GeneratePress.  
3. FTP: `ea-eyalamit` + `ea-staging-noindex.php`.  
4. הפעלת child **EA Eyal Amit**.  
5. Permalink `/%postname%/` + תיעוד.  
6. ייבוא `m2-pages-seed.wxr` + הגדרות קריאה (בית / בלוג).  
7. התקנת **Yoast** + **Fluent Forms** + טופס בסיסי ב־צור קשר.  
8. בניית תפריטים לפי §5.  
9. `view-source` — אימות `noindex` בסטייג'ינג.  
10. מילוי עמודת **מזהה WP** בטבלה §4 בסיכום זה לאחר פריסה.

---

## 11. אימות 100 / 20 (מסמך מקביל)

תגובה רשמית, פערי סטייג'ינג והוראות המשך: [`../team_20/M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md`](../team_20/M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md).

---

## 12. צעדים הבאים — סגירת **M10** / G2 (אחרי עדכון נימרוד 2026-03-29)

**משוב צוות 10 (מסמך זה):** §1.1 עודכן ל־**M10-0** + מסלול TLS; **M10-15** (צ'קבוקסים וחתימה ב־handoff) — **לביצוע ידני** אצל אחראי צוות 10.

**מימוש במאגר (2026-03-29):** ארטיפקטי `site/` אומתו; נוסף [`scripts/verify_m2_g2_repo_artifacts.sh`](../../scripts/verify_m2_g2_repo_artifacts.sh); **הודעת QA לצוות 50:** [`../team_50/M2-G2-QA-BRIEF-FOR-TEAM50-2026-03-29.md`](../team_50/M2-G2-QA-BRIEF-FOR-TEAM50-2026-03-29.md).

**פריסה לסטייג'ינג (FTP):** **צוות פיתוח / סוכן** מריץ מהמאגר `pip install -r scripts/requirements-upress.txt` ואז `python3 scripts/ftp_deploy_site_wp_content.py` (קורא **`local/.env.upress`** במחשב המקומי; נוהל: [`docs/project/UPRESS_WORDPRESS_STANDARD_v2.md`](../../docs/project/UPRESS_WORDPRESS_STANDARD_v2.md)) — מעלה child `ea-eyalamit` + MU; **הלקוח אינו אחראי להעלאת קבצים ב-FTP**. לאחר מכן **צוות 50** מריץ את מטריצת §3 בבריף QA. (מסיבות רשת/אבטחה, סביבת סוכן בענן לעיתים לא תתחבר ל-uPress — אז אותו סקריפט רץ **אצל מחזיק המאגר**.)

| סדר | פעולה | DoD קצר | סטטוס (מאגר / סטייג'ינג) |
|-----|--------|---------|---------------------------|
| 1 | **FTP:** `ea-eyalamit` + MU (כולל `ea-m2-seed-shell-once`) | קבצים על השרת | **מאגר:** ☑ · **סטייג'ינג:** ☑ (2026-04-04) |
| 2 | **Child EA Eyal Amit** פעיל | פלט HTML עם GP+child | ☑ |
| 3 | **עמודי §7** (זריעה MU או WXR) | כל שורות §4 קיימות | ☑ (MU) |
| 4 | **קריאה:** בית סטטי + בלוג | **W10** | ☑ |
| 5 | **Yoast:** **P15** → `noindex` (**F10**) | post meta | ☑ (זריעה) |
| 6 | **Fluent:** shortcode ב־**צור קשר** + בדיקת שליחה | מייל בדיקה / לוג | ☑ submit אפליקטיבי בדוח v2 (`insert_id: 3`); **F2** — אימות mailbox / WP Mail Logging → M7 / פרודקשן |
| 7 | **תפריטים** T1–T6 (**§5**) | ללא 404 פנימיים; **יישור לעץ נעול** — [`M2-MENU-PRIMARY-LOCKED-FROM-SITE-TREE-2026-03-29.md`](./M2-MENU-PRIMARY-LOCKED-FROM-SITE-TREE-2026-03-29.md) | ☑ — אומת ב־[`M2-SMOKE-REPORT-FINAL-2026-04-06-v2.md`](../team_50/M2-SMOKE-REPORT-FINAL-2026-04-06-v2.md) (PASS WITH NOTES) |
| 8 | **`view-source`:** `noindex` לסטייג'ינג (**M10-12**) | מילולי בסיכום | ☑ (דוח QA קודם + אימות) |
| 9 | **מזהה WP** בטבלה §4 | מספרים | ☑ |
| 10 | **M10-15:** [`M2-HANDOFF-FROM-20-2026-03-31.md`](./M2-HANDOFF-FROM-20-2026-03-31.md) — צ'קבוקסים + חתימה | חתום ידנית | _למלא_ |
| 11 | **צוות 50:** דוח QA FINAL (סגירת פערי IA) | [`M2-SMOKE-REPORT-FINAL-2026-04-06-v2.md`](../team_50/M2-SMOKE-REPORT-FINAL-2026-04-06-v2.md) | ☑ **PASS WITH NOTES** (F2 בלבד) |
| 12 | **צוות 100:** סגירת M2 לפי **M2-WORKPLAN §11** DoD | אחרי PASS / PASS WITH NOTES (F2) מ־50 | **בתהליך** — קליטת §11 G4 |

**אחרי G2:** מעבר ל־**M3** (תוכן/מיגרציה) לפי [`ROADMAP-2026.md`](../../docs/project/ROADMAP-2026.md) — לא לפני סימון **M2 COMPLETED** ע"י 100.

---

## עדכון 2026-03-29 — חבילת סגירה מול `site-tree.json` (דוח 50 FINAL 2026-04-06)

**מטרה:** לסגור פערי IA (תפריט, עמודים, פוטר, EN בהדר, קישורי בית, הפניות legacy) לפי [`hub/data/site-tree.json`](../../hub/data/site-tree.json).

| רכיב | פירוט |
|------|--------|
| **MU סנכרון** | [`site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php`](../../site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php) v1.1 — תפריטים **M2 Primary EA** + **M2 Footer EA** (מיקום `ea_footer_legal`); אופציה **`ea_m2_site_tree_lock_sync_v2`**; `template_redirect` עם מפת 301 לנתיבי legacy |
| **זריעה** | [`ea-m2-seed-shell-once.php`](../../site/wp-content/mu-plugins/ea-m2-seed-shell-once.php) v1.1 — ללא יצירת §7; IA נטען מסנכרון (init 28) |
| **Child** | גרסה **1.1.2** — פוטר משפטי, EN בהדר (`generate_inside_navigation`), תיקון `/treatment/` בדף בית |
| **בקשת QA** | [`../team_50/M2-QA-RETEST-REQUEST-TEAM50-2026-03-29.md`](../team_50/M2-QA-RETEST-REQUEST-TEAM50-2026-03-29.md) |
| **שער פנימי** | [`M2-INTERNAL-STAGING-GATE-2026-03-29.md`](./M2-INTERNAL-STAGING-GATE-2026-03-29.md) |

**סטטוס סטייג’ינג:** נדרשת **פריסת FTP** + טעינה אחת; רק אז אימות מול הטבלה בצ׳ק־ליסט הפנימי וריטסט צוות 50.

---

*סוף סיכום G2 (עודכן 2026-03-29 — child **1.1.0** Rubik אחיד לדף בית; 1.0.9 Hero מכווצת; 1.0.8 טיפוגרפיה; 2026-04-09 נגישות; 2026-04-04 P0 סטייג'ינג).*
