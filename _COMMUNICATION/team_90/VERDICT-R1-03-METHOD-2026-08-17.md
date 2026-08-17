VERDICT: PASS

## חוזה (ארבעה סעיפים)

| סעיף | תוצאה | ראיה |
|------|--------|------|
| 1. התאמת מקור | **CONFIRMED** | טקסטים עיקריים ב־`method-defaults.php` מופיעים ב־`method.md` (13.8.26): «שיטת cbDIDG של אייל עמית» (§01) · «ולמי שמחפש תהליך אישי עמוק, ולא פתרון קסם מהיר.» (§09) · «סטודיו נשימה מעגלית בפרדס חנה» (§08). הוסרו המצאות ישנות (`circular-breathing`, `ea-pending-approval`). קישור מוקש: md `/mokesh-dahiman` → קוד `/eyal-amit/mokesh-dahiman/` — ניתוב קנוני (לא טקסט חדש). |
| 2. האנק לא ממופה | **CONFIRMED** | `git diff --name-only HEAD` בערכת הנושא = 3 קבצים בלבד: `method-defaults.php`, `tpl-chapters-method.php`, `chapters-render.php`. |
| 3. Provenance | **CONFIRMED** | כל 16 בלוקי תוכן (§01–§14, כולל `SECTION 12 (media link)` שורה 200) נושאים `/* S006 · מקור: content 13.8.26/השיטה/method.md · SECTION … */`. |
| 4. פלט ריק | **CONFIRMED** | `curl -sk` → 85,660 בתים; `<main>` באורך 21,816 תווים. |

## בדיקות HTML חיות (`<main>`, דסקטופ)

| # | בדיקה | תוצאה | ראיה |
|---|--------|--------|------|
| 1 | הירו + CTA → `/contact/` | **CONFIRMED** | `<h1 class="phero__h">שיטת cbDIDG של אייל עמית</h1>` · `<a class="btn btn--gw" href="/contact/">לתיאום שיחת היכרות</a>` |
| 2 | אין `circular-breathing` / `.ea-pending-approval` ב־`<main>` | **CONFIRMED** | שני המחרוזות absent ב־`<main>` (JSON-LD ב־`<head>` בלבד — מותר) |
| 3 | אין `<section class="bleed">` | **CONFIRMED** | `section class="bleed"` absent ב־`<main>` |
| 4 | «למי השיטה מתאימה» — אין `.rcard`, יש המשפט הנדרש | **CONFIRMED** | `rcard` count: 0 · «ולמי שמחפש תהליך אישי עמוק, ולא פתרון קסם מהיר.» present |
| 5 | «סטודיו נשימה מעגלית» באודות | **CONFIRMED** | בסקשן «אודות אייל עמית»: «את המרכז לטיפול בדיג'רידו - סטודיו נשימה מעגלית בפרדס חנה…» |
| 6 | `לימוד והכשרה` → `/learning/` | **CONFIRMED** | `<a class="tlink" href="/learning/">לימוד והכשרה</a>` |
| 7 | בדיוק 7 `<details>` (§11) | **CONFIRMED** | `details count: 7` — שאלות מ־`faq-inline` בלבד; אין שאלות CPT נוספות |
| 8 | 8 ממליצים + Facebook; קרין `18Ks7D2HQD` | **CONFIRMED** | 8 שמות ייחודיים עם `href` ל־Facebook · קרין: `https://www.facebook.com/share/p/18Ks7D2HQD/` |
| 9 | «לעוד המלצות ועדויות» → `/media` | **CONFIRMED** | `<a class="tlink" href="/media/">לעוד המלצות ועדויות</a>` |
| 10 | CTA סיום §14 → `/contact/` | **CONFIRMED** | `<a class="btn btn--terra" href="/contact/">לתיאום שיחת היכרות</a>` בסקשן «אם הגעתם עד לכאן…» |

## qa_probe (משלים, דסקטופ)

**CONFIRMED** — `overflow: false`, `forbiddenFound: []`, `verdict: PASS` (1440×, `/method/`).

---

**מאמת:** Composer (team_90) · **בנאי:** Grok 4.6 · Iron Rule #1 נשמר. כל עשר בדיקות החוזה + ארבעת סעיפי המסגרת עברו; אין חסימה ל־R1-03.
