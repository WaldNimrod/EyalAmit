# M2 — שאלות החלטה לסגירת G1 ופתיחת G2

**תאריך:** 2026-03-31  
**מיועד ל:** נימרוד / צוות **100** (אישור תוכנית) + **20** / **10** (ביצוע)  
**מסמכי עוגן:** [`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) · [`M2-WORKPLAN-AND-MANDATES-2026-03-30.md`](./M2-WORKPLAN-AND-MANDATES-2026-03-30.md) · [`06-IMPLEMENTATION-MIGRATION-PACK.md`](../../docs/project/team-100-preplanning/06-IMPLEMENTATION-MIGRATION-PACK.md)

**מטרה:** לסגור פערים שסומנו ב־runbook (☐) ולהתקדם ל־**G2** (יישום צוות 10) בלי הפתעות SEO/תשתית.

---

## 1. גרסת PHP בסטייג'ינג (**20.7** / **F3**)

| | |
|--|--|
| **למה זה חשוב** | תאימות תוספים/תמה; יישור מול Docker מקומי. |
| **אופציות** | **א** — **7.4** (ישן, לא מומלץ לאתר חדש) · **ב** — **8.3** (מומלץ) · **ג** — **8.4** (חדש; לוודא תאימות אחרי התקנת תמה) |
| **המלצה** | **ב — PHP 8.3** בפאנל uPress לסטייג'ינג; עדכון `WORDPRESS_IMAGE` ב־`local/.env` ל־`wordpress:php8.3-apache`. |
| **אחרי החלטה** | ☑ **בוצע** — runbook §2 + `docker-compose` ברירת מחדל **8.3**. |
| **קישורים** | [שינוי גרסת PHP — uPress](https://support.upress.co.il/general/change-version/) · [`docs/project/EYAL_ENV_VARS_REFERENCE.md`](../../docs/project/EYAL_ENV_VARS_REFERENCE.md) §1 |

---

## 2. מבנה Permalink (**20.3a** / **C1**)

| | |
|--|--|
| **למה זה חשוב** | כל עמודי העליה בהמשך; קטלוג **P22** ו־QR. |
| **אופציות** | **א** — `/%postname%/` (**סטנדרט M2**) · **ב** — מבנה אחר **רק** עם waiver מ־100 + תיעוד ב־runbook |
| **המלצה** | **א** — `/%postname%/` — להגדיר עכשיו בסטייג'ינג (**הגדרות → קישורים קבועים**) ולסמן ב־runbook §4. |
| **אחרי החלטה** | ☑ **מדיניות 20 + אימות 10** — runbook §4; 10 מאמת בממשק. |
| **קישורים** | [`M2-WORKPLAN §6 / 10.x`](./M2-WORKPLAN-AND-MANDATES-2026-03-30.md) · [`M2-RUNBOOK-ENV §4`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) |

---

## 3. `noindex` / אי־אינדקס לסטייג'ינג (**20.6**)

| | |
|--|--|
| **למה זה חשוב** | שלא יאונדקס דומיין סטייג'ינג בגוגל (כפול תוכן / זליגת סביבה). |
| **אופציות** | **א** — תוסף SEO (למשל Yoast: *Search appearance* / “הרחקת אתר מהאינדקס” לסטייג'ינג אם קיים) · **ב** — `robots.txt` על הסטייג'ינג (`Disallow: /`) — פשוט אך פחות מדויק מ־meta · **ג** — `mu-plugin` קטן עם `wp_robots` / `noindex` לכל העמודים · **ד** — כלי/הגדרה ספציפית ב־uPress אם מוצע |
| **המלצה** | **א** אם כבר יש/יהיה תוסף SEO מותר ב־[`05-PLATFORM-DECISION`](../../docs/project/team-100-preplanning/05-PLATFORM-DECISION.md); אחרת **ג** (מינימלי, נשלט בקוד). **ב** כגיבוי זמני עד שיש תוסף. |
| **אימות** | `view-source` על דף הבית — חיפוש `noindex` או `robots` content. |
| **אחרי החלטה** | ☑ **mu-plugin במאגר** — `site/wp-content/mu-plugins/ea-staging-noindex.php`; runbook §8; 10 מאמת אחרי FTP. |
| **קישורים** | [`06-IMPLEMENTATION §1`](../../docs/project/team-100-preplanning/06-IMPLEMENTATION-MIGRATION-PACK.md) (סטייג'ינג ללא אינדקס) · [`M2 §5.1 משימה 20.6`](./M2-WORKPLAN-AND-MANDATES-2026-03-30.md) |

---

## 4. `robots.txt` בסטייג'ינג (השלמה לשאלה 3)

| | |
|--|--|
| **אופציות** | **א** — ברירת מחדל של WordPress (`Allow: /`) + **noindex** ב־meta (מספיק אם noindex עובד) · **ב** — קובץ סטטי / תוסף שמחזיר `Disallow: /` לכל הסורקים |
| **המלצה** | אם **noindex** ב־`<head>` מאושר — **א**; אם רוצים “חסימה כפולה”, **ב** במקביל (זהירות: לא לשכוח להסיר בפרודקשן). |
| **קישורים** | צ'קליסט השקה: [`LAUNCH-CHECKLIST-2026.md`](../../docs/project/LAUNCH-CHECKLIST-2026.md) (פרודקשן; לשימוש עתידי) |

---

## 5. גיבוי לפני עבודת G2 מהותית (**20.5a** / **F13**)

| | |
|--|--|
| **למה זה חשוב** | rollback אם משהו בשכבת התמה/תוספים משתבש. |
| **אופציות** | **א** — גיבוי ידני מפאנל uPress עכשיו + רישום תאריך/מזהה ב־runbook §7 · **ב** — גיבוי מתוזמן קיים; לתעד מזהה “נקודת בסיס לפני G2” |
| **המלצה** | **א** — ליצור גיבוי **לפני** התקנת GeneratePress/שינויים גדולים; למלא שדה ב־runbook. |
| **קישורים** | [`M2-RUNBOOK-ENV §7`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) · הערת uPress ב־[`WORDPRESS-DEPLOY`](../../docs/project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md) §8 |

---

## 6. אימות slug קטלוג **P22** מול אתר חי (**20.3b** / **F16**)

| | |
|--|--|
| **למה זה חשוב** | QR ומודפסים; שבירת נתיב = שבירת סריקה. |
| **אופציות** | **א** — לפתוח `https://www.eyalamit.co.il/shop/` (או נתיב הקטלוג בפועל) ולהשוות ל־§7 ב־M2 · **ב** — אם האתר החי לא זמין — להשאיר **UNVERIFIED** + תאריך בדיקה חוזרת (כפי ש־M2 מתיר) |
| **המלצה** | **א** ברגע שהאתר החי זמין; עד אז **ב** — בלי לנחש slug. |
| **אחרי החלטה** | לעדכן טבלה ב־runbook §5 (מ־UNVERIFIED למאומת + ערך סופי). |
| **קישורים** | [`M2-WORKPLAN §7`](./M2-WORKPLAN-AND-MANDATES-2026-03-30.md) · [`QR-URL-POLICY`](../../docs/project/team-100-preplanning/QR-URL-POLICY.md) · [`QR-URL-INVENTORY.csv`](../../docs/project/team-100-preplanning/QR-URL-INVENTORY.csv) |

---

## 7. אישור צוות 10 לקבלת סביבה (**20.10**)

| | |
|--|--|
| **אופציות** | **א** — 10 מסמן ☑ ב־[`M2-HANDOFF-FROM-20-2026-03-31.md`](../team_10/M2-HANDOFF-FROM-20-2026-03-31.md) · **ב** — דחייה + סיבה (חסרה גישה וכו') |
| **המלצה** | **א** — מיד כשיש גישת wp-admin + FTP לכל מי שמיישם. |
| **קישורים** | Handoff · [`onboard_team10.md`](../team_10/onboard_team10.md) |

---

## 8. תמה נעולה + מיקום קוד (**10.2** / **05-PLATFORM**)

| | |
|--|--|
| **החלטה הארכיטקטונית** | כבר נעולה: **GeneratePress** + child **`ea-eyalamit`**. |
| **אופציות מימוש** | **א** — התקנה מממשק WP בסטייג'ינג + העלאת child ב־FTP מ־[`site/wp-content`](../../site/README.md) · **ב** — פיתוח מקומי ב־Docker עם bind-mount ואז FTP |
| **המלצה** | ☑ **א** — שלד child במאגר ב־`site/wp-content/themes/ea-eyalamit/`; **ב** לפיתוח חוזר עם bind-mount ב־Docker. |
| **קישורים** | [`WP-THEME-EVALUATION-HEBREW-SEO-2026-03-29.md`](../../docs/project/team-100-preplanning/WP-THEME-EVALUATION-HEBREW-SEO-2026-03-29.md) §7 · [`05-PLATFORM-DECISION §6`](../../docs/project/team-100-preplanning/05-PLATFORM-DECISION.md) |

---

## 9. פלט סיכום G2 (צוות 10)

| | |
|--|--|
| **חובה** | לאחר יישום: `M2-IMPLEMENTATION-SUMMARY-<תאריך>.md` — גרסאות תמה/תוספים, טבלת §7, תפריט, slugs (כולל P22). |
| **קישורים** | [`M2-WORKPLAN §6`](./M2-WORKPLAN-AND-MANDATES-2026-03-30.md) |

---

## 10. סיכום צ'קליסט “לסגור את השלב”

| # | פריט | סטטוס ב־runbook |
|---|------|-----------------|
| 1 | PHP נבחר ונרשם | ☑ §2 (**8.3**) |
| 2 | Permalink `/%postname%/` | ☑ §4 (מדיניות + אימות 10) |
| 3 | `noindex` (או מקביל) מאומת | ☑ §8 (mu-plugin; אימות 10 אחרי FTP) |
| 4 | גיבוי לפני G2 מתועד | ☑ §7 (**בוצע uPress**, **2026-03-31**) |
| 5 | P22 מאומת או UNVERIFIED+תאריך | §5 (**UNVERIFIED** עד אימות חי) |
| 6 | מנדט 10 / אישור handoff | ☑ **מנדט הועבר** — אישור צ’קליסט §4 ב-handoff על ידי **10** |
| 7 | `CONDITIONS_MET` ב־M2-WORKPLAN | ✓ **2026-03-31** |

---

*מסמך זה משלים את אישור התוכנית; עדכונים בצד 20/10 — לשקף ב־runbook ובסיכום G2.*
