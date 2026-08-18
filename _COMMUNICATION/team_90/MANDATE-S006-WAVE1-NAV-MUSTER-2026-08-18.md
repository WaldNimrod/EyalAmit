# MANDATE — team_90 · Composer · מפקד ניווט גל רמה-ראשונה

**מאמת:** `composer-2.5` (Cursor) · **בנאי הגל:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. TLS סטייג'ינג פג בכוונה — `curl -sk` מותר כאן בלבד. פלט ריק = FAIL.
אל תשנה קבצים מלבד פסק הדין.

שורה ראשונה חייבת להיות בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`

כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-WAVE1-NAV-MUSTER-2026-08-18.md`

בסיס: `http://eyalamit-co-il-2026.s887.upress.link/`

**אל תפתחו מחדש** סעיפי אייל על R1-01…R1-05 / R1-26 (H-01/H-06/H-07, T-01/T-02, MTH-01, LSN-01/LSN-02/LSN-09, SH-01/SH-02, M-01a/M-03/M-04/M-05). רגרסיה = H1/קישור ניווט שבור, לא מדיה ממתינה.

---

## 1. קישורים ברמה הראשונה מ-`#nav`

מ-`/` קראו את `#nav` (`ul.nav__l` + `nav__en`). לכל `href` ברמה הראשונה (לא ילדי דרופדאון):

HEAD/GET עם `-sk -o /dev/null -w '%{http_code} %{url_effective}'`. PASS = 200 או 301 לאותו אתר. 404/000 = FAIL.

צפויים לפחות: `/` · `/treatment/` · `/method/` · `/lessons/` · `/sound-healing/` · `/books/` · `/blog/` · `/contact/` · `/en/`

כפתורי דרופדאון בלי href: «לימוד והכשרה» · «כלים ואביזרים» · «אייל עמית» — חייבים להיות קיימים (לא FAIL אם אין href).

`קורסים` → `#` (R1-29) — **הערה**, לא FAIL.

---

## 2. ילדים שננעלו בגל (לא 404)

בדרופדאון, href חי (200/301) ל:

- `/shop/`
- `/eyal-amit/`
- `/eyal-amit/mokesh-dahiman/` — **חובה** תחת «אייל עמית»

אל תדרשו 200 על ילדים מחוץ לגל (הכשרות / הרצאות / סדנאות / תיקון / תיקים / סטנדים / מוצרי ילד). אם הם 200 זה הערה, לא FAIL.

---

## 3. H1 חי על עמודי הגל + עמודים שכבר הוגשו

`curl -sk` לכל נתיב; ציטוט H1 מ-`<main>`. HTTP 200.

| נתיב | H1 צפוי (דסקטופ) | דין |
|---|---|---|
| `/` | דף הבית החי (לא לפתוח H-01) | רגרסיה רק אם 404 / main ריק |
| `/treatment/` | טיפול (גרסה קנונית, לא `?compare=eyal`) | רגרסיה = 404 |
| `/method/` | השיטה | רגרסיה = 404 |
| `/lessons/` | שיעורי נגינה… | רגרסיה = 404 |
| `/sound-healing/` | סאונד הילינג… | רגרסיה = 404 |
| `/shop/` | `כלי דיג'רידו למכירה - כלים בעבודת יד` בלי em | FAIL אם לא |
| `/books/` | `מוזה הוצאה לאור` | FAIL אם לא |
| `/eyal-amit/` | `אייל עמית` בלי em; תוויות גרסה א׳/ב׳ | FAIL אם לא |
| `/eyal-amit/mokesh-dahiman/` | `מי היה מוקש דהימן?` בלי em | FAIL אם לא |
| `/contact/` | צור קשר (em מותר) | FAIL אם 404 |
| `/learning/` | הקפאה — HTTP 200 מספיק | לא FAIL על טיוטת צוות |
| `/blog/` | הקפאה — HTTP 200 מספיק | לא FAIL על ארכיון |
| `/en/` | הקפאה — HTTP 200 מספיק | לא FAIL על חסר EN |

---

## 4. `qa_probe` דסקטופ על הסט הבנוי/מוקפא

```
node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /shop/,/books/,/eyal-amit/,/eyal-amit/mokesh-dahiman/,/contact/,/learning/,/blog/,/en/
```

PASS רק אם לכל path בדסקטופ: `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף.

אופציונלי (רגרסיה, לא חובה אם הזמן קצר): אותה פקודה על `/`,`/treatment/`,`/method/`,`/lessons/`,`/sound-healing/`.

---

## 5. טרקר — גל מול גיליון

SSoT: `_COMMUNICATION/team_100/S006/tracker/latest.csv`

| שורה | סטטוס מכונה | ממתין ל |
|---|---|---|
| R1-10 · R1-16 · R1-21 · R1-22 | `הוגש לבדיקה` | `אייל` |
| R1-23 | `הוגש לבדיקה` | `נימרוד` |
| R1-06 · R1-20 · R1-24 | `הוקפא` | `נימרוד` |

סוכן לא נגע בעמודות אנוש. אל תשנה את האקסל.

---

## פלט

`VERDICT: PASS` או `VERDICT: FAIL` בשורה הראשונה.
טבלה: בדיקה · CONFIRMED/FAIL · HTTP/H1/overflow.
ריק = FAIL.
