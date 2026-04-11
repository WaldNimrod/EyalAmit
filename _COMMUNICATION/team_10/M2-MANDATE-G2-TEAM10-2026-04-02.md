# מנדט M2 — צוות **10** (יישום G2 על סטייג'ינג)

**מוציא:** צוות **100**  
**תאריך:** 2026-04-02 · **עדכון 100 (TLS / שער 20-A):** **2026-04-02**  
**נמען:** צוות **10** בלבד  
**מטרה:** השלמת **G2** על סטייג'ינג uPress: תמה נעולה, תוספים, עמודי מעטפת, תפריטים, אימותים, סיכום יישום.

**אישור המשך מ־100:** [`../team_100/M2-GATE-20A-AMENDMENT-AND-GO-TEAM10-2026-04-02.md`](../team_100/M2-GATE-20A-AMENDMENT-AND-GO-TEAM10-2026-04-02.md) — **GO** לביצוע מנדט זה (אין המתנה ל־`curl` בלי `-k` תקין על סטייג'ינג).

---

## תנאי התחלה (חוסמים / לא חוסמים)

**מסלול מחייב — סטייג'ינג מול פרודקשן (TLS):** [`../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md)

| נושא | דרישה |
|------|--------|
| **G2 על סטייג'ינג** | **מותר** אחרי **GO** מ־100; **אין** דרישת TLS מחמירה (`curl` בלי `-k`) על URL הסטייג'ינג |
| **M10-0** | דפדפן / smoke לסטייג'ינג; אזהרת אמון **מותרת** לפי מדיניות uPress; אופציונלי: `curl -I -k` |
| **סיכום יישום** | לתעד במפורש: **HTTPS בסטייג'ינג ≠ פרודקשן** |
| **אתר סופי / cutover** | **חובה** SSL תקין בפרודקשן — `curl` **בלי** `-k` בשלב M7 / לפני השקה (לא חלק מ־G2 סטייג'ינג) |

**דוח תשתית 20 (לידיעה):** [`../team_20/M2-INFRA-COMPLETION-REPORT-TO-TEAM100-2026-04-01.md`](../team_20/M2-INFRA-COMPLETION-REPORT-TO-TEAM100-2026-04-01.md) · ראיות: [`../team_20/M2-GATE-20A-TLS-VERIFICATION-2026-04-02.md`](../team_20/M2-GATE-20A-TLS-VERIFICATION-2026-04-02.md)

---

## מקורות מחייבים

- [`M2-WORKPLAN-AND-MANDATES-2026-03-30.md`](../team_100/M2-WORKPLAN-AND-MANDATES-2026-03-30.md) §6–§7  
- [`M2-HANDOFF-FROM-20-2026-03-31.md`](./M2-HANDOFF-FROM-20-2026-03-31.md)  
- [`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md)  
- [`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](./M2-IMPLEMENTATION-SUMMARY-2026-04-01.md)  
- [`site/README.md`](../../site/README.md)  
- אפיון תבנית: [`SITE-SPECIFICATION-FINAL-2026-03-30.md`](../../docs/project/team-100-preplanning/SITE-SPECIFICATION-FINAL-2026-03-30.md) §1.2.1

---

## רשימת משימות (בסדר)

| # | משימה | פעולות | DoD |
|---|--------|--------|-----|
| **M10-0** | אימות גישה לסטייג'ינג | דפדפן (אזהרת אמון מותרת לפי מדיניות uPress); אופציונלי: `curl -I -k` | עדכון §1.1 ב־`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md` — **הבהרה: סטייג'ינג ≠ TLS פרודקשן** |
| **M10-1** | גיבוי | גיבוי uPress לפני שינוי מהותי; מזהה אצל מחזיק סודות / runbook §7 אם נדרש | גיבוי לפני שינויים אם חלף זמן מהגיבוי הקודם |
| **M10-2** | GeneratePress | תבניות → הוסף חדש (קטלוג); **לא** מהמאגר | Parent מותקן; גרסה ב§3 בסיכום |
| **M10-3** | FTP child + mu | [`site/wp-content/themes/ea-eyalamit/`](../../site/wp-content/themes/ea-eyalamit/) → `wp-content/themes/ea-eyalamit/`; [`ea-staging-noindex.php`](../../site/wp-content/mu-plugins/ea-staging-noindex.php) → `mu-plugins/` | על השרת; child ≥ **1.0.1** |
| **M10-4** | הפעלת child | תבנית **EA Eyal Amit** פעילה | לא TT5 כברירת מחדל בפלט |
| **M10-5** | Permalink | `/%postname%/` | מתועד ב§7 בסיכום |
| **M10-6** | ייבוא עמודים | כלים → ייבוא → [`site/exports/m2-pages-seed.wxr`](../../site/exports/m2-pages-seed.wxr); מחבר `admin` או מיפוי — ראו [`M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md`](../team_20/M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md) §1 | עמודי §7 + היררכיה |
| **M10-7** | קריאה | בית סטטי «בית» (`home`); פוסטים «בלוג» (`blog`) | בית/בלוג תקינים |
| **M10-8** | Yoast | התקנה + בסיס; **P15** noindex (**F10**) | תוסף SEO יחיד; גרסה בסיכום |
| **M10-9** | Fluent Forms | טופס ב־צור קשר (P16); honeypot/לוג | בדיקת שליחה או לוג |
| **M10-9a** | תוספי עזר (100/uPress) | **WP Mail Logging**, **LTR RTL Admin**, **Validator.pizza** — ראו [`M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md`](../team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md) §3 | מותקנים; **§3.1** ב־`M2-IMPLEMENTATION-SUMMARY` מעודכן |
| **M10-10** | קאש / מטמון | לפי **תיעוד uPress** (Varnish בפאנל + אופציונלי EzCache) — ראו [`M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md`](../team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md) **§0–§5**; **לא** תוסף קאש צד שלישי נוסף בלי waiver | מתועד בסיכום + runbook |
| **M10-11** | תפריטים | T1–T6 לפי סיכום §5; **F11-b** ל־T3 | עברית + EN; בלי 404 פנימיים |
| **M10-12** | noindex סטייג'ינג | `view-source` — mu-plugin | מתועד; תואם runbook §8 |
| **M10-13** | מזהי WP | מילוי עמודת §4 בסיכום; **P22** UNVERIFIED מול חי עד אימות | בלי `_למלא_` |
| **M10-14** | גרסאות | השלמת §§2–3 בסיכום (GP, Yoast, Fluent, תוספי §3.1) | F5/F6 + §6.3 |
| **M10-15** | Handoff §4 | [`M2-HANDOFF-FROM-20-2026-03-31.md`](./M2-HANDOFF-FROM-20-2026-03-31.md) — צ'קבוקסים + חתימה | חתום |
| **M10-16** | סטטוס סיכום | כותרת/סעיף: **הושלם על הסטייג'ינג** (או מוסכם) | סיכום סופי |

---

## איסורים

חוזר על **M2-WORKPLAN §6.2:** אין שינוי slug ל-QR; אין Woo/סל פנימי; אין Elementor כבד בלי **waiver 100**.

---

## הפניות נוספות

| נושא | מסמך |
|------|------|
| אימות Git + הערות ייבוא | [`M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md`](../team_20/M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md) |
| תוספי uPress, מדיה, מטמון | [`M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md`](../team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md) |
| סדר כולל + אינדקס | [`M2-G2-MANDATE-SEQUENCE-INDEX-2026-04-02.md`](../team_100/M2-G2-MANDATE-SEQUENCE-INDEX-2026-04-02.md) |

---

*מסמך זה אינו מבטל את M2-WORKPLAN §6.*
