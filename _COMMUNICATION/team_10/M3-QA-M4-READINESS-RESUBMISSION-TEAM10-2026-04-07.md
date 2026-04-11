# M3 — **הגשה חוזרת** לאחר דוח **QA-M4** (צוות **10** → צוות **50**)

**תאריך:** 2026-04-07  
**מוציא:** צוות **10**  
**אל:** צוות **50** (QA) · צוות **100** (אורקסטרציה)  
**דוח קנוני שקיבלנו:** [`../team_50/M3-QA-M4-VISUAL-NOTE-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-M4-VISUAL-NOTE-REPORT-TEAM50-2026-04-07.md) — **`FINAL`** · **`PASS WITH NOTES`**

---

## סקופ בדיקה חוזרת (מלא, מיושר ל־READINESS המקורי + השלמת QM4-3)

| # | נתיב | נושא |
|---|------|------|
| 1 | `/` | בית — `ea-home-dashboard`, Rubik, פלטה |
| 2 | `/sound-healing/` | שירות — `ea-m4-polish` |
| 3 | `/galleries/` | קטלוג |
| 4 | `/privacy/` | משפטי |
| 5 | `/faq/` | קטלוג FAQ |
| 6 | `/en/` | **השלמה** — LTR, ללא `body.rtl`, דליפת צבע GP |

**סביבה:** `https://eyalamit-co-il-2026.s887.upress.link` · `curl -skL` לפי runbook · TLS: [`../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md)

**ארטיפקט פריסה לאחר תיקון:** [`M3-M4-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-07.md`](./M3-M4-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-07.md)

---

## פסק דין שנקלט (ללא שינוי)

| שדה | ערך |
|-----|-----|
| **תוצאה** | `PASS WITH NOTES` |
| **QM4-2** | פלטה ב־child; הערה: שכבת GP עם `--accent:#1e73be` ב־HTML |
| **QM4-3** | `/en/` עם `html dir="ltr"` אך `body` עם מחלקת `rtl` |

---

## תיקונים שבוצעו בצוות **10** (גרסת תמה **1.3.1**)

| # | הערת QA | תיקון |
|---|---------|--------|
| **T1** | דליפת צבע מ־GeneratePress | נוסף `wp_add_inline_style` על `ea-eyalamit-style` (עדיפות `100`) עם בלוק `:root` שמגדיר `--eyal-*` וממפה `--accent`, `--accent-hover`, `--contrast`, `--contrast-2`, `--contrast-3` לפלטה המאושרת — **אחרי** ה־CSS הדינמי של GP, כך שב־cascade הערכים היעדיים נשארים בתוקף |
| **T2** | `body.rtl` ב־`/en/` | `body_class` בעדיפות **99**: הסרת `rtl` והוספת `ltr` בעמודי `en` / `english`; CSS ל־`body.ea-lang-en.ltr` נשאר עקבי |

**קבצים:** `site/wp-content/themes/ea-eyalamit/functions.php`, `style.css` (`Version: 1.3.1`).

**הערת שקיפות:** בלוק ה־cached של GeneratePress עדיין **מכיל מחרוזת** `--accent:#1e73be`; בלוק `:root` הנוסף של ה־child **שוכב מאוחר יותר** ב־HTML ולכן **ערך מחושב** של `--accent` לרכיבים שמסתמכים על `var(--accent)` הוא לפי הפלטה. אם נדרש «ניקוי» חזותי של המקור בלבד — אפשר שלב Customizer / פילטר GP בנפרד (מחוץ לתיקון זה).

---

## מסמכי בסיס (ללא ביטול)

- בקשה ראשונה: [`M3-QA-M4-READINESS-REQUEST-TEAM10-2026-04-01.md`](./M3-QA-M4-READINESS-REQUEST-TEAM10-2026-04-01.md)  
- מנדט QA-M4: [`../team_50/M3-QA-M4-VISUAL-NOTE-MANDATE-TEAM50-2026-04-08.md`](../team_50/M3-QA-M4-VISUAL-NOTE-MANDATE-TEAM50-2026-04-08.md)  
- מנדט M3-M4: [`M3-M4-VISUAL-POLISH-MANDATE-TEAM10-2026-04-08.md`](./M3-M4-VISUAL-POLISH-MANDATE-TEAM10-2026-04-08.md)

---

## פלט מ־**50** (התקבל)

- **ריטסט קנוני:** [`../team_50/M3-QA-M4-VISUAL-NOTE-RETEST-TEAM50-2026-04-07.md`](../team_50/M3-QA-M4-VISUAL-NOTE-RETEST-TEAM50-2026-04-07.md) — `**FINAL**` · **`PASS`** (2026-04-07). הערות QM4-2 / QM4-3 נסגרו; נותרה **הערת audit לא־חוסמת** על מחרוזת GP במקור.

---

*צוות 10 — הגשה חוזרת QA-M4 (תיקוני הערות + סקופ מלא).*
