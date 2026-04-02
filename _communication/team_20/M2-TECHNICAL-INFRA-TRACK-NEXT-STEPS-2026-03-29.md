# נטיב טכני — צעדים הבאים ומשימות תשתית (M2 / G1)

**תאריך:** 2026-03-29 · **עדכון סגירת G1 (סטייג'ינג):** 2026-03-31 · **עדכון מקומי (bind-mount + WP-CLI):** 2026-04-03 — ראו [`M2-RUNBOOK-ENV-2026-03-31.md`](./M2-RUNBOOK-ENV-2026-03-31.md) §14 · [`local/README.md`](../../local/README.md)

**סטטוס G1 (סטייג'ינג):** WordPress + FTP + DB תקינים; **runbook רשמי:** [`M2-RUNBOOK-ENV-2026-03-31.md`](./M2-RUNBOOK-ENV-2026-03-31.md) · **משוב ל־10:** [`../team_10/M2-HANDOFF-FROM-20-2026-03-31.md`](../team_10/M2-HANDOFF-FROM-20-2026-03-31.md). ☑ **גיבוי uPress לפני G2 בוצע** · ☑ **מנדט G2 הועבר לצוות 10** (**2026-03-31**).

**G2 (בעלות צוות 10):** פריסת GeneratePress + child/mu מהמאגר, permalink באימות ממשק, תוספים, ייבוא WXR, עמודים §7, תפריטים, `M2-IMPLEMENTATION-SUMMARY` — לפי M2-WORKPLAN §6. **אימות P22** מול אתר חי — **UNVERIFIED** עד בדיקה. **אימות 20/100 + המשך:** [`M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md`](./M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md).

**בעלות:** צוות **20** — פלט runbook: [`M2-RUNBOOK-ENV-2026-03-31.md`](./M2-RUNBOOK-ENV-2026-03-31.md).  
**מדיניות מקור:** [`docs/project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md`](../../docs/project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md) · [`M2-WORKPLAN-AND-MANDATES-2026-03-30.md`](../team_100/M2-WORKPLAN-AND-MANDATES-2026-03-30.md) §5.  
**uPress — נתונים לחיבור ובדיקות פאנל:** [`UPRESS-CONNECTION-DATA-CHECKLIST-2026-03-29.md`](./UPRESS-CONNECTION-DATA-CHECKLIST-2026-03-29.md).  
**סטייג'ינג פעיל + מדריך Git:** [`UPRESS-STAGING-SITE-RECORD-2026-03-31.md`](./UPRESS-STAGING-SITE-RECORD-2026-03-31.md) — `https://eyalamit-co-il-2026.s887.upress.link`

**סדר מחייב:** מקומי (Docker) **לפני** פתיחת סטייג'ינג ייעודי ב־**uPress**. **Docker** על מכונת הפיתוח — **קיים ומאושר**; אין להניח התקנה מאפס אלא אם נכשל הרצה.

---

## שלב א׳ — סביבה מקומית: מסד נתונים + WordPress עובדים

| # | משימה | תוצאה מדידה |
|---|--------|-------------|
| A1 | Docker קיים ופעיל (מאושר לפרויקט) — שימוש ב־`local/docker-compose.yml` | `docker compose version` עובד; מיכלים עולים |
| A2 | יצירת `local/.env` מ־`local/.env.example` + סיסמאות חזקות (לא ב־Git) | קובץ קיים; `.env` ב־`.gitignore` |
| A3 | הרצת `docker compose` מתיקיית `local/` | שירותי `db` + `wordpress` ב־`running` |
| A4 | השלמת אשף התקנת WordPress בדפדפן (שפה, כותרת אתר, משתמש מנהל) | כניסה ל־`wp-admin` מקומית עובדת |
| A5 | אימות חיבור DB מתוך הקונטיינר (אופציונלי: `wp-cli` אם מותקן בקונטיינר) | אתר טוען; אין שגיאת DB ב־`debug.log` אם הופעל דיבוג |
| A6 | תיעוד ב־runbook: URL מקומי, גרסת WP ראשונית, גרסת MariaDB | שורות ב־`M2-RUNBOOK-ENV-*.md` |

**מסד נתונים מקומי:** מוגדר ב־`local/docker-compose.yml` (שירות `db`). משתמש/סיסמה/שם בסיס — מ־`.env`. **הערה:** DB מקומי הוא לפיתוח; אינו מקור אמת לפרודקשן.

---

## שלב ב׳ — יישור גרסת PHP: מקומי ↔ uPress

| # | משימה | תוצאה מדידה |
|---|--------|-------------|
| B1 | בדיקה בפאנל **uPress** (או תמיכה): אילו גרסאות PHP זמינות לחשבון | רשימה ב־runbook |
| B2 | בחירת **גרסה אחת** לסטייג'ינג ולפרודקשן | החלטה בכתב ב־runbook |
| B3 | עדכון `WORDPRESS_IMAGE` ב־`local/.env` (תג תואם PHP) + `docker compose up -d` מחדש אם נדרש | `phpinfo()` או Site Health מקומי תואם לרשום ב־runbook |
| B4 | רישום מקור האימות (צילום מסך / מזהה טיקט תמיכה) | עמידה ב־**F3** / **20.7** במסמך M2 |

---

## שלב ג׳ — עץ פריסה במאגר (`site/`) וחיבור למקומי

| # | משימה | תוצאה מדידה |
|---|--------|-------------|
| G1 | יצירת מבנה `site/wp-content/` לפי [`site/README.md`](../../site/README.md) (לפחות מקום ל־child `ea-eyalamit`) | תיקיות ב־Git |
| G2 | התקנת **GeneratePress** (parent) + יצירת/שכפול **child `ea-eyalamit`** — לפי [`05-PLATFORM-DECISION.md`](../../docs/project/team-100-preplanning/05-PLATFORM-DECISION.md) §6 | תמה פעילה מקומית |
| G3 | הפעלת bind-mount ב־`local/docker-compose.yml` מ־`../site/wp-content` ל־`/var/www/html/wp-content` (במקום נפח anonymous בלבד) | שינוי ב־`style.css` של child נראה מיד |
| G4 | תיעוד ב־runbook: נתיבי תמה, קידומת `ea_`, האם יש `mu-plugins` | טבלת "מיקום קוד" (**20.9**) |

---

## שלב ד׳ — סטייג'ינג uPress (רק אחרי א׳–ג׳ יציבים)

| # | משימה | תוצאה מדידה |
|---|--------|-------------|
| S1 | פתיחת **סביבת סטייג'ינג** ייעודית ב־uPress (תת־דומיין / התקנה נפרדת — לפי מה שהחשבון מאפשר) | URL סטייג'ינג ב־runbook |
| S2 | התקנת WordPress נקייה (או תהליך שכפול מאושר), שפה עברית אם רלוונטי | מסך התקנה הושלם (**20.3**) |
| S3 | **Permalink** — `/%postname%/` מיד לאחר התקנה (**20.3a**) | עמוד בדיקה נפתח ב־URL נקי |
| S4 | **HTTPS** + ללא mixed-content בדף ברירת מחדל (**20.4**) | מנעול תקין |
| S5 | יצירת DB + משתמש DB ב־uPress; רישום credentials **מחוץ ל־Git** (**20.2**) | התחברות `wp-admin` סטייג'ינג |
| S6 | **noindex** / חסימת אינדקס לסטייג'ינג (**20.6**) | אימות ב־`<head>` או תוסף SEO |
| S7 | פריסת קבצים: העלאת `site/wp-content` (או תת־קבוצה) ב־SFTP / כלי uPress / Git אם קיים — כפי שייקבע ב־runbook (**20.8**) | תמה child נראית בסטייג'ינג כמו במקומי (גרסאות מתועדות) |
| S8 | גיבוי מובנה uPress לפני שינויים מהותיים של צוות 10 (**20.5**, **20.5a**) | תאריך/מזהה ב־runbook |
| S9 | פרטי תמיכה + נוהל rollback (**20.11**) | סעיפים ב־runbook |

---

## שלב ה׳ — מסירה לצוות 10 (G1 → G2)

| # | משימה | תוצאה מדידה |
|---|--------|-------------|
| H1 | השלמת טבלת **slugs קריטיים** כולל **P22** / קטלוג — **UNVERIFIED** עד אימות מול אתר חי (**20.3b**, **C1**) | טבלה ב־runbook |
| H2 | העברת גישה (מנהל WP או מסלול deploy) (**20.10**) | אישור קצר מ־10 ב־`team_10/M2-HANDOFF-FROM-20.md` (מומלץ) |

---

## סיכום תלויות (DAG קצר)

```text
A (מקומי WP+DB) → B (PHP נעול מול uPress) → G (site/ + תמה במאגר)
G → S (סטייג'ינג uPress)
S + runbook מלא → H (handoff ל־10)
```

---

## מה לא בשלב זה (מפורש)

- **דוא"ל (SMTP):** לא במקומי; בשרת — כשהסביבה באוויר (ראו מדיניות §5 במסמך הפריסה).
- **רוטציית סיסמאות סופית:** אחרי go-live — צ'קליסט M7 / צוות 20.
