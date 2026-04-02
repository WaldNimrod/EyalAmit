# M2 — Runbook סביבה (G1) — uPress סטייג'ינג

**תאריך:** 2026-03-31 · **עדכון סטטוס פאנל:** 2026-03-29 (דיווח נימרוד — §13.0–§13.3) · **עדכון מקומי Docker:** 2026-04-03 (§14) · **יישור QA תשתית (WP-CLI / rebuild):** 2026-04-04 (§14) · **ריטסט Q3 (PATH + /usr/bin/wp + nocache סטייג'ינג):** 2026-04-06 (§14)  
**ספק:** **uPress**  
**סביבה:** **סטייג'ינג בלבד** (לא פרודקשן חי) — **במונחי uPress: סביבת פיתוח** לפרויקט (אתר עבודה על `*.upress.link`, לא דומיין חי).

---

## 1. כתובות

| סביבה | URL / הערה |
|--------|------------|
| **סטייג'ינג (בסיס)** | `https://eyalamit-co-il-2026.s887.upress.link` |
| **wp-admin** | `https://eyalamit-co-il-2026.s887.upress.link/wp-admin` |
| **פאנל uPress** | `my.upress.co.il` → אתר הסטייג'ינג |
| **אתר חי (אימות slug)** | `https://www.eyalamit.co.il/` — לאימות **P22** כשזמין |

**תיעוד רשמי uPress (חובה לתפעול נכון):** [מרכז התמיכה](https://support.upress.co.il/) — טבלת מאמרים + נתיבי פאנל: [`UPRESS-CONNECTION-DATA-CHECKLIST-2026-03-29.md`](./UPRESS-CONNECTION-DATA-CHECKLIST-2026-03-29.md) (פתיחה); מטמון **Varnish** / **EzCache** / ניקוי: [`M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md`](../team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md) §0–§5.

### 1.1 סיווג סביבה (מוסכם ארגונית)

| מושג | משמעות בפרויקט זה |
|------|-------------------|
| **סטייג'ינג / סביבת פיתוח** | האתר ב־`*.upress.link` — **אין עליו go-live**; כאן בונים, מייבאים תוכן, בודקים תמה ותוספים. |
| **מול uPress KB** | קיים גם מסלול **«סביבת פיתוח»** נפרד (ייבוא מאתר חי לדומיין זמני) — [יצירת סביבת פיתוח מאתר חי](https://support.upress.co.il/dev/import-to-sandbox/). **לפרויקטנו:** העבודה השוטפת היא **על אתר הסטייג'ינג הקיים** ברשימה למעלה; אם בעתיד ייווצר sandbox נוסף — לעדכן טבלה זו + כתובת. |

---

## 2. PHP (**F3** / **20.7**)

בפאנל הוצגו גרסאות: **7.4**, **8.3**, **8.4**.  
**המלצה לפרויקט:** **8.3** לסטייג'ינג (ליישר מול Docker מקומי: `wordpress:php8.3-apache`).  
**נעול בפאנל (אושר):** **PHP 8.3** — **2026-03-31** (יישור מול `wordpress:php8.3-apache` ב־Docker / [`local/.env.example`](../../local/.env.example)) · **אומת מול הפאנל (דיווח 2026-03-29):** **הוגדר 8.3**.

---

## 3. WordPress (**20.3**)

- התקנה פעילה; חיבור DB תקין (אחרי סנכרון `wp-config.php`).
- **שפה:** עברית (RTL) — **אומת ב־wp-admin (דיווח 2026-03-29).**
- **תבנית parent:** **GeneratePress** — **מותקנת (דיווח 2026-03-29).** child **`ea-eyalamit`** + `mu-plugins` — פריסה מ־FTP מהמאגר (ראו §9); **בביצוע צוות פיתוח / 10.**

---

## 4. Permalink (**20.3a** / **C1**)

- **יעד:** `/%postname%/` (או שקול מתועד).
- **סטטוס:** **מדיניות M2:** `/%postname%/` — ☑ **אושר על ידי 20 (מדיניות + תיעוד)** · ☑ **אומת ב־wp-admin (דיווח 2026-03-29):** מבנה **שם הפוסט** (`/%postname%/`).

---

## 5. טבלת slugs קריטיים (**20.3b** / **C1**)

מקור ארכיטקטוני: [`M2-WORKPLAN-AND-MANDATES-2026-03-30.md`](../team_100/M2-WORKPLAN-AND-MANDATES-2026-03-30.md) §7.  
QR: [`QR-URL-INVENTORY.csv`](../../docs/project/team-100-preplanning/QR-URL-INVENTORY.csv) — הפניה בלבד.

| מזהה עמוד | תיאור | slug / נתיב יעד ארכיטקטוני | אימות מול אתר חי |
|------------|--------|----------------------------|-------------------|
| **P22** | קטלוג ראשי | **`/shop/`** (slug צפוי: `shop`) — ראו §7 במסמך M2 | **UNVERIFIED** עד אימות מול `eyalamit.co.il` חי |

---

## 6. HTTPS (**20.4**)

**כלל מחייב:** בסטייג'ינג — **SSL תקין (כמו בפרודקשן) לא מותקן**. **באתר הסופי**, אחרי הסטייג'ינג — חובה לעבוד **רק** עם **HTTPS ותעודה תקינה** (אין go-live בלי SSL תקין על הדומיין האמיתי). פירוט: [`STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](./STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md) — סעיף «כלל מחייב».

**פרודקשן (דומיין אמיתי):** חובה תעודה תקינה, `curl`/דפדפן **ללא** דילוג על אימות — לפני cutover ואחרי השקה (צ'קליסט M7).

**סטייג'ינג (`*.upress.link`):** לפי **מדיניות חשבון uPress** (דיווח מחזיק פאנל, **2026-04-02**): **SSL תקין מוצג רק באתר האמיתי** — **לא** בסטייג'ינג. לכן:

- אימות **מחמיר** (`curl -I` **בלי** `-k`) על URL הסטייג'ינג — **לא** משמש כשער חובה ל־G2; ראו [`STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](./STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md) ו־waiver/עדכון מ־**צוות 100** על מנדט [`M2-MANDATE-G2-PREREQ-TEAM20-2026-04-02.md`](./M2-MANDATE-G2-PREREQ-TEAM20-2026-04-02.md).
- **עבודה יומיומית בסטייג'ינג:** גלישה ל־`https://…` עם אישור אזהרת אמון בדפדפן אם מוצגת; לבדיקות אוטומטיות smoke — `curl -I -k` **רק** כנגד סטייג'ינג.

**אימות טכני (לארכיון):** `curl` בלי `-k` נכשל; פירוט: [`M2-GATE-20A-TLS-VERIFICATION-2026-04-02.md`](./M2-GATE-20A-TLS-VERIFICATION-2026-04-02.md).

---

## 7. גיבוי (**20.5**, **20.5a** / **F13**)

- **uPress:** גיבוי מובנה בפאנל — לתעד לפני שינויים מהותיים של צוות 10.
- **תאריך/מזהה עדכני לפני G2:** ☑ **בוצע** — גיבוי ידני בפאנל uPress לפני העברת G2 (**דיווח נימרוד**, **2026-03-31**). **מזהה גיבוי ספציפי בפאנל** (ל־rollback) — לרשום אצל מחזיק הסודות / בפאנל; **לא** במאגר.
- **גיבוי לפני שינוי מהותי (מחזור נוסף):** ☑ **בוצע** — דיווח **2026-03-29** (נימרוד).

---

## 8. `noindex` סטייג'ינג (**20.6**)

לפי [`06-IMPLEMENTATION-MIGRATION-PACK.md`](../../docs/project/team-100-preplanning/06-IMPLEMENTATION-MIGRATION-PACK.md).  
**מימוש במאגר:** `site/wp-content/mu-plugins/ea-staging-noindex.php` — מפעיל `noindex,nofollow` דרך מסנן `wp_robots` **רק** כש־host מכיל `upress.link` (לא רץ בפרודקשן על `eyalamit.co.il`).  
**אימות:** `view-source` על דף הבית בסטייג'ינג — חיפוש `noindex` / `robots`. ☑ **מסלול mu-plugin מתועד — 10 מאמת אחרי פריסה**

---

## 9. פריסת קבצים (**20.8** / **20.9**)

| נושא | פירוט |
|------|--------|
| **FTP** | Host: `ftp.s887.upress.link`, פורט **21** (פרוטוקול FTP). **סיסמאות ומשתמשים — לא במאגר;** ראו `local/staging.credentials.md` (gitignored) אצל מחזיק הסודות. |
| **סקריפט סנכרון DB → wp-config** | `python3 scripts/ftp_sync_wp_config_db_password.py` (קורא מ־`staging.credentials.md`; תיקן באג שימוש ב־`**Password:**` FTP). |
| **Cursor / SFTP** | תוסף SFTP + `.vscode/sftp.json` (gitignored) — ראו `.cursor/skills/eyalamit-staging-ftp/SKILL.md`. |
| **מיקום קוד במאגר 2026** | [`site/README.md`](../../site/README.md) — **FTP (דוגמה):** `wp-content/themes/ea-eyalamit/` (קבצי child מהמאגר) · `wp-content/mu-plugins/ea-staging-noindex.php`. Parent **GeneratePress** — **לא** מהמאגר; התקנה מממשק WP או מ־wordpress.org ([`WP-THEME-EVALUATION`](../../docs/project/team-100-preplanning/WP-THEME-EVALUATION-HEBREW-SEO-2026-03-29.md) §7). קידומת PHP: **`ea_`**. |
| **Git על השרת** | לא משתמשים במונוריפו המלא; FTP כמסלול ראשי לסטייג'ינג. |

---

## 10. תמיכה ו־rollback (**20.11** / **F12**)

- **תמיכה:** uPress — פתיחת כרטיס דרך הפאנל / אתר התמיכה.
- **Rollback:** שחזור מגיבוי uPress + עצירה עד החלטת 100 אם G2 נכשל באמצע.

---

## 11. גישה לצוות 10 (**20.10**)

- משתמש מנהל WP ופרטי FTP — אצל מחזיק הסודות; צוות 10 מקבל גישה לפי נוהל הארגון (לא לפרסם בצ'אט).
- **קבלת מסירה:** [`../team_10/M2-HANDOFF-FROM-20-2026-03-31.md`](../team_10/M2-HANDOFF-FROM-20-2026-03-31.md) — ☑ **מנדט G2 הועבר לצוות 10** (**2026-03-31**, דיווח נימרוד); יתר הביצוע (תמה, תוספים, עמודים, סיכום M2) — **באחריות צוות 10** לפי M2-WORKPLAN §6.

---

## 12. הפניות למסמכים נלווים

- [`STAGING-CHANNEL-STATUS-2026-03-31.md`](./STAGING-CHANNEL-STATUS-2026-03-31.md)  
- [`UPRESS-STAGING-SITE-RECORD-2026-03-31.md`](./UPRESS-STAGING-SITE-RECORD-2026-03-31.md)  
- [`DB-AND-PHPMYADMIN-WORKFLOW-2026-03-31.md`](./DB-AND-PHPMYADMIN-WORKFLOW-2026-03-31.md)  
- [`M2-TECHNICAL-INFRA-TRACK-NEXT-STEPS-2026-03-29.md`](./M2-TECHNICAL-INFRA-TRACK-NEXT-STEPS-2026-03-29.md)

---

## 13. צ׳ק־ליסט — **ממשק uPress** + **wp-admin** (סביבת פיתוח / סטייג'ינג)

**בעלות ביצוע:** צוות **10** (wp-admin + חבילת תוספים), צוות **20** (PHP / פאנל כשדורש הרשאות חשבון).  
**לאחר מילוי:** לסמן ☑ בטבלאות ולרשום תאריך בסעיף **13.3** (או ב־[`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md) §9).

### 13.0 מדיניות מטמון — **סטייג'ינג** (דיווח מחזיק פאנל + החלטת 100, 2026-03-29)

| נושא | החלטה |
|------|--------|
| **Varnish** (מאמר [KB](https://support.upress.co.il/performance/%d7%94%d7%a4%d7%a2%d7%9c%d7%aa-%d7%95%d7%94%d7%92%d7%93%d7%a8%d7%aa-%d7%9e%d7%98%d7%9e%d7%95%d7%9f-varnish-cache/)) | **נדחה לאתר הסופי בלבד** — לפי דיווח, **הפעלה דורשת SSL** במסלול הנוכחי; בסטייג'ינג (`*.upress.link`) **לא** מפעילים Varnish בשלב זה. |
| **אפשרויות נוספות בפאנל (שמות לפי דיווח)** | **מטמון קבצים סטטיים** · **מטמון אפליקצייתי** · **הגדרות מטמון מותאמות אישית** — אין להן עדיין קישור מאומת למאמר ספציפי ב־KB שנסרק; **לפתוח קריאה לתמיכת uPress או לצרף צילום מסך** ל־runbook כשמזוהה מאמר מתאים. |
| **המלצת צוות 100 לשלב פיתוח** | **מינימום מטמון:** להעדיף **לא** להסתמך על מטמון אגרסיבי שמסתיר שינויי PHP/תבנית. אם **חייבים** לבחור באחת מהאפשרויות: **מטמון קבצים סטטיים** פחות «שובר» דיבוג מול שינויי לוגיקה מאשר **מטמון אפליקצייתי**; **מותאם אישית** רק עם הנחיית תמיכה. בכל מקרה — **ניקוי מטמון** ([KB](https://support.upress.co.il/dev/how-to-clear-cache/)) אחרי deploy. |
| **אופטימיזציה (תמונות, CDN, EzCache, TinyPNG וכו')** | **אחרי עלייה לאוויר** — לא לחסום G2; ראו [`M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE`](../team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md) §4–§5. |
| **SMTP** | ☑ **פעיל** (דיווח 2026-03-29) — תומך ב־Fluent Forms בדיקות שליחה. |

### 13.1 פאנל uPress (`my.upress.co.il` → בחירת אתר הסטייג'ינג)

ביצעו לפי שמות התפריטים בפועל בממשק (אם השם שונה בגרסת פאנל — לתעד צילום).

| # | פעולה | נתיב בפאנל (לפי תיעוד uPress) | ערך / הערה לפרויקט | ☑ |
|---|--------|-------------------------------|---------------------|---|
| P1 | **גרסת PHP** | **הגדרות → ניהול הגדרות PHP** ([KB](https://support.upress.co.il/general/change-version/)) | **8.3** — ☑ הוגדר (2026-03-29) | ☑ |
| P2 | **גיבוי לפני שינוי מהותי** | גיבויים בפאנל (לפי מבנה החשבון) | לפחות אחד לפני G2 — §7; ☑ בוצע גם 2026-03-29 | ☑ |
| P3 | **מטמון Varnish** | **ביצועים → הגדרות מתקדמות → הפעלת Varnish** ([KB](https://support.upress.co.il/performance/%d7%94%d7%a4%d7%a2%d7%9c%d7%aa-%d7%95%d7%94%d7%92%d7%93%d7%a8%d7%aa-%d7%9e%d7%98%d7%9e%d7%95%d7%9f-varnish-cache/)) | **סטייג'ינג:** ☑ **לא מופעל** — נדחה ל**פרודקשן** (דורש SSL). | ☑ |
| P3b | **מטמון (חלופות בפאנל)** | לפי ממשק uPress (שמות לפי דיווח) | **סטטי / אפליקצייתי / מותאם** — ראו **§13.0**; לפרויקט: **מינימום** בפיתוח. | ☐ |
| P4 | **ניקוי מטמון** | **פיתוח → ניהול כלי אחסון → בצע ניקוי מטמון** ([KB](https://support.upress.co.il/dev/how-to-clear-cache/)) | אחרי פריסת FTP, שינוי תמה, **שינוי דף הבית / הגדרות קריאה**, או כשהדף «נתקע». אם `GET /` עדיין מחזיר תוכן ישן (למשל `Hello world`) בעוד `/?cb=…` נכון — **חובה purge מלא**; אם מותקן **EzCache** — גם ניקוי משם לפי [מאמר Varnish](https://support.upress.co.il/performance/%d7%94%d7%a4%d7%a2%d7%9c%d7%aa-%d7%95%d7%94%d7%92%d7%93%d7%a8%d7%aa-%d7%9e%d7%98%d7%9e%d7%95%d7%9f-varnish-cache/). | ☐ |
| P5 | **EzCache (תוסף)** | התקנה מ־**WordPress → ניהול תוספי WordPress** בפאנל ([KB](https://support.upress.co.il/wordpress/manage-wordpress-plugins/)) או מספריית uPress | **סטייג'ינג:** **אופציונלי** — מומלץ אם Varnish פעיל ורוצים **ניקוי מ־WP**; ראו [`M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE`](../team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md) §5.2. לרשום **מותקן / לא**. | ☐ |
| P6 | **CDN** | **ביצועים → ניהול אזור CDN** ([KB](https://support.upress.co.il/performance/create-cdn-zone/)) | **סטייג'ינג:** בדרך כלל **לא חובה**; לפרודקשן לפי החלטה | ☐ |
| P7 | **דוא״ל / SMTP** (אם נדרש לטפסים) | לפי מבנה החשבון uPress (מיילים / WordPress) | ☑ **פעיל** (דיווח 2026-03-29) — Fluent יכול לשלוח בדיקות. | ☑ |

### 13.2 ממשק WordPress (`…/wp-admin`) — הגדרות ותוספים (M2 G2)

| # | פעולה | איפה ב־wp-admin | פירוט / מקור | ☑ |
|---|--------|-----------------|---------------|---|
| W1 | **שפה אתר** | **הגדרות → כללי** (או **הגדרות → שפה** לפי גרסת WP) | עברית (RTL) — ☑ הוגדר (2026-03-29) | ☑ |
| W2 | **קישורים קבועים** | **הגדרות → קישורים קבועים** | **`שם הפוסט`** (`/%postname%/`) — ☑ (2026-03-29) | ☑ |
| W3 | **תבנית parent** | **מראה → תבניות** | **GeneratePress** — ☑ מותקנת (2026-03-29) | ☑ |
| W4 | **תבנית child + mu** | **FTP** (לא רק מסך תבניות) | העלאת `ea-eyalamit` + `mu-plugins/ea-staging-noindex.php` — §9; הפעלת **EA Eyal Amit** — **בביצוע (מאגר מוכן)** | ☐ |
| W5 | **תוסף SEO** | **תוספים** | **Yoast SEO** — ☑ מותקן; לפי דיווח **לא נדרש יותר מזה לשלב זה**; **P15 → noindex** אחרי ייבוא ([סיכום 10 §4](../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md)) | ☑ |
| W6 | **תוסף טפסים** | **תוספים** | **Fluent Forms** — ☑ מותקן; **טופס בדף צור קשר (P16)** — **להשלים** | ☐ |
| W7 | **תוספי עזר מאושרים** | **תוספים** | **WP Mail Logging**, **LTR RTL Admin**, **Validator.pizza** — פעילים ([סיכום §3.1](../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md)) | ☐ |
| W8 | **חבילת uPress (שאר התוספים)** | **תוספים** או קטלוג uPress בחשבון | **לא** להפעיל Elementor / Woo / Gravity / Jetpack כבד וכו' בלי waiver — רשימה מלאה: [`M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE`](../team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md) §2 | ☐ |
| W9 | **ייבוא עמודים** | **כלים → ייבוא** | קובץ [`site/exports/m2-pages-seed.wxr`](../../site/exports/m2-pages-seed.wxr) | ☐ |
| W10 | **דף בית ובלוג** | **הגדרות → קריאה** | דף ראשי סטטי: **בית** (`home`); פוסטים: **בלוג** (`blog`) | ☐ |
| W11 | **תפריטים** | **מראה → תפריטים** | T1–T6 לפי [סיכום 10 §5](../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md) | ☐ |
| W12 | **אימות סטייג'ינג** | דפדפן: `view-source` על דף הבית | חיפוש `noindex` / robots — §8 | ☐ |

### 13.3 רישום ביצוע (לא ב-Git — אצל מחזיק הפרויקט או בסיכום 10)

| שדה | ערך |
|-----|-----|
| תאריך עדכון סטטוס פאנל/wp-admin | **2026-03-29** (נימרוד) |
| Varnish בסטייג'ינג | **כבוי / לא מופעל** — מיועד ל**פרודקשן** (SSL) |
| מצב מטמון חלופי (סטטי/אפליקצייתי/מותאם) | לתעד כשמנוהל בפועל — ראו §13.0 |
| EzCache בסטייג'ינג | **לא** (אופטימיזציה אחרי עליה לאוויר) |
| SMTP | **פעיל** |
| גרסאות: Yoast / Fluent / GeneratePress | _למלא מספרים בסיכום 10 §3 אחרי wp-admin_ |

---

## 14. סביבה מקומית (Docker) — יישור טכני (**2026-04-03**)

| שדה | ערך |
|-----|-----|
| **נתיב מאגר** | `EyalAmit.co.il-2026/local/` |
| **URL** | `http://localhost:9090` (או `WORDPRESS_PORT` מ־`local/.env`) |
| **בסיס תמונה** | `WORDPRESS_IMAGE` + בנייה מ־`Dockerfile.wordpress` (Xdebug 3 + WP-CLI) |
| **מיפוי `wp-content`** | ☑ **`../site/wp-content` → `/var/www/html/wp-content`** ב־`docker-compose.yml` — עריכת child/mu-plugins במאגר משתקפת בקונטיינר |
| **MariaDB** | שירות `db` — גרסה **11** (תמונת `mariadb:11`) |
| **WP-CLI** | מותקן ב־`/usr/local/bin/wp` **וקישור** ל־`/usr/bin/wp` (חובה לבדיקות `exec` עם `PATH` מצומצם). מתוך `local/`: `docker compose exec wordpress /usr/bin/wp --path=/var/www/html --allow-root cli info` — ראו [`local/README.md`](../../local/README.md) · אימות אוטומטי משורש המאגר: `bash scripts/verify_local_wp_cli.sh` |
| **תג תמונה מקומית** | `eyalamit-local-wp:xdebug-wpcli-v3` (ב־`docker-compose.yml`) — שינוי תג אחרי עדכון `Dockerfile.wordpress` כדי שלא ירוצו קונטיינרים מתמונה ישנה **בלי** WP-CLI |
| **בנייה מחדש (חובה אחרי `git pull` שמשנה Docker)** | מתוך `local/`: `docker compose build --no-cache wordpress` ואז `docker compose up -d --force-recreate wordpress` — פירוט ב־`local/README.md`; ב־Dockerfile: `RUN` כולל `wp --info` ו־`ln` ל־`/usr/bin/wp` |
| **דיבוג PHP** | `.vscode/launch.json` — Listen Xdebug פורט **9003** |

**הערה:** התקנת WordPress מקומית (אשף דפדפן) ו־GeneratePress מקומית — באחריות מחזיק המכונה; ניתן לרשום גרסאות בסיכום 10 או כאן לפי בקשה.

**בקרת צוות 50 (תשתית):** [`../team_50/M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md`](../team_50/M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md).  
**תיקון ארכיטקטורה אחרי דוח QA + קריטריונים לבדיקה חוזרת:** [`../team_100/M2-QA-REMEDIATION-AND-RETEST-PLAN-2026-04-04.md`](../team_100/M2-QA-REMEDIATION-AND-RETEST-PLAN-2026-04-04.md).
