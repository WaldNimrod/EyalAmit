VERDICT: FAIL

**מאמת:** team_90 · Composer 2.5 (Cursor) · 2026-08-18  
**בנאי:** Cursor Grok 4.6 · Iron Rule #1 (validator ≠ builder; אפס שינוי קוד)  
**בסיס:** http://eyalamit-co-il-2026.s887.upress.link/ · דסקטופ בלבד · `curl -sk`  
**מנדט:** `_COMMUNICATION/team_90/MANDATE-S006-FINAL-SWEEP-2026-08-18.md`  
**היקף:** R1-01 · R1-02 · R1-03 · R1-04 · R1-05 · R1-26

## סיכום מנהלים

חמש עמודי ליבה עברו HTTP, מקור, טרקר, קישורים ו-`qa_probe`. **שני כשלים כרום-צוות:** `<em>` ב-H1 על `/treatment/` ו-`/testimonials/` — אסור במנדט (רק `/contact/` מותר `<em>`). סעיפי «ממתין לאייל» (מדיה, כותרת M-03, דן ארליכמן M-01a) **לא** נספרו כ-FAIL.

**בעלות תיקון:** צוות 10 — הסרת `<em>` מ-H1 ב-`treatment-defaults.php` / `media-defaults.php` (או שכבת תבנית) ללא שינוי נוסח.

---

## טבלה מרכזית

| שורה | בדיקה | תוצאה | ציטוט / ראיה |
|------|--------|--------|--------------|
| R1-01 | HTTP 200 | CONFIRMED | `HTTP:200` · `/` |
| R1-01 | H1 `<main>` מול מקור | CONFIRMED | `המרכז לטיפול בנשימה באמצעות דיג'רידו – שיטת cbDIDG של אייל עמית` (מקור: `homepage1-3 v2.md` SECTION 01; מקף/EN-dash) · ללא `<em>` |
| R1-01 | 3–5 ציטוטים מגוף המקור | CONFIRMED | «בטיפול בנשימה באמצעות דיג'רידו, הדיג'רידו הוא כלי עבודה על הנשימה» · «יש דרכים שונות לעבוד עם הנשימה» · «אייל עמית · פועל מאז 1999» |
| R1-01 | אפס מחרוזות פדיחה `<main>` | CONFIRMED | אפס PLACEHOLDER / mrng.to / מחירים מומצאים |
| R1-01 | אפס כרטיס/סקשן ריק | CONFIRMED | פלייסהולדרים מתועדים H-06/H-07 — מותר |
| R1-01 | קישורים פנימיים + ניווט | CONFIRMED | דגימה `<main>` ללא 404 · ניווט רמה ראשונה 200 לכל הנתיבים הנעולים |
| R1-01 | טרקר `latest.csv` | CONFIRMED | `סטטוס מכונה=הוגש לבדיקה` · `ממתין ל=אייל` |
| R1-01 | `qa_probe` דסקטופ overflow | CONFIRMED | `overflow: false` · `forbiddenFound: []` |
| R1-02 | HTTP 200 | CONFIRMED | `HTTP:200` · `/treatment/` |
| R1-02 | H1 `<main>` מול מקור | FAIL | חי: `טיפול ב<em>דיג׳רידו</em>` · מקור `treatment.md` SECTION 01: `טיפול בדיג'רידו` בלי `<em>` |
| R1-02 | 3–5 ציטוטים מגוף המקור | CONFIRMED | «הטיפול בדיג'רידו הוא תהליך שנבנה בהדרגה» · «נשימה מעגלית» · «ריברסינג» · «הנשימה היא לכולם» |
| R1-02 | אפס מחרוזות פדיחה `<main>` | CONFIRMED | אפס PLACEHOLDER / mrng.to / מחירים |
| R1-02 | אפס כרטיס/סקשן ריק | CONFIRMED | T-02 סרטון ממתין לאייל — מותר |
| R1-02 | קישורים פנימיים + ניווט | CONFIRMED | דגימה `<main>` ללא 404 |
| R1-02 | טרקר | CONFIRMED | `הוגש לבדיקה` · `ממתין ל=אייל` |
| R1-02 | `qa_probe` דסקטופ | CONFIRMED | `overflow: false` · `forbiddenFound: []` (לא בודק `<em>` ב-H1) |
| R1-03 | HTTP 200 | CONFIRMED | `HTTP:200` · `/method/` |
| R1-03 | H1 מול מקור | CONFIRMED | `שיטת cbDIDG של אייל עמית` · ללא `<em>` |
| R1-03 | ציטוטים מקור | CONFIRMED | «cbDIDG» · «נשימה מעגלית בדיג'רידו» · «ריברסינג» · «סטודיו נשימה מעגלית» |
| R1-03 | פדיחות / ריקים | CONFIRMED | MTH-01 תמונות ממתין לאייל — מותר |
| R1-03 | קישורים + ניווט | CONFIRMED | ללא 404 בדגימה |
| R1-03 | טרקר | CONFIRMED | `הוגש לבדיקה` · `ממתין ל=אייל` |
| R1-03 | `qa_probe` דסקטופ | CONFIRMED | `overflow: false` |
| R1-04 | HTTP 200 | CONFIRMED | `HTTP:200` · `/lessons/` |
| R1-04 | H1 מול מקור | CONFIRMED | `שיעורי נגינה בדיג'רידו לפי שיטת cbDIDG של אייל עמית` · ללא `<em>` |
| R1-04 | ציטוטים מקור | CONFIRMED | «שיעורי נגינה בדיג'רידו» · «cbDIDG» · «נשימה מעגלית» · «הדיג'רידו הוא כלי נשיפה קדום» (`lesons.md`) |
| R1-04 | פדיחות / ריקים | CONFIRMED | LSN-01/02/09 ממתין לאייל — מותר |
| R1-04 | קישורים + ניווט | CONFIRMED | ללא 404 בדגימה |
| R1-04 | טרקר | CONFIRMED | `הוגש לבדיקה` · `ממתין ל=אייל` |
| R1-04 | `qa_probe` דסקטופ | CONFIRMED | `overflow: false` |
| R1-05 | HTTP 200 | CONFIRMED | `HTTP:200` · `/sound-healing/` |
| R1-05 | H1 מול מקור | CONFIRMED | `סאונד הילינג פרטי בדיג'רידו - מסע אישי בצליל ותדר ליחידים ולזוגות` · ללא `<em>` |
| R1-05 | ציטוטים מקור | CONFIRMED | «סאונד הילינג» · «תדר» · «מסע אישי» · «סאונד הילינג בדיג'רידו הוא מפגש פרטי» (`sound_healing_final.md`) |
| R1-05 | פדיחות / ריקים | CONFIRMED | SH-01/02 ממתין לאייל — מותר |
| R1-05 | קישורים + ניווט | CONFIRMED | ללא 404 בדגימה |
| R1-05 | טרקר | CONFIRMED | `הוגש לבדיקה` · `ממתין ל=אייל` |
| R1-05 | `qa_probe` דסקטופ | CONFIRMED | `overflow: false` |
| R1-26 | HTTP 200 | CONFIRMED | `HTTP:200` · `/testimonials/` (לא `/media/`) |
| R1-26 | H1 `<main>` | FAIL | חי: `מדיה <em>ווידאו</em>` · מקור/מנדט: כותרת קטלוג המלצות · M-03 ממתין לאייל על נוסח — **לא** נספר; `<em>` ב-H1 = כשל כרום |
| R1-26 | ציטוטים תוכן | CONFIRMED | «מעבר לסידור הנשימה…» (שירי אלקבץ) · «ממליץ ממש לכל מי…» (דרור מצליח) · «טיפול בדיג'רידו» / «שיעורי נגינה» בסקשנים |
| R1-26 | פדיחות `<main>` | CONFIRMED | אפס PLACEHOLDER / mrng.to; «ממתין להשלמה» בסקשן מדיה M-04 — מותר |
| R1-26 | כרטיסים ריקים | CONFIRMED | 44+ כרטיסי testimonial עם טקסט; דן ארליכמן חסר — M-01a ממתין לאייל |
| R1-26 | קישורים `/media/` | CONFIRMED | אפס קישורים ל-`/media/` ב-`<main>` |
| R1-26 | קישורים + ניווט | CONFIRMED | דגימה `<main>` ללא 404 |
| R1-26 | טרקר | CONFIRMED | `הוגש לבדיקה` · `ממתין ל=אייל` |
| R1-26 | `qa_probe` דסקטופ | CONFIRMED | `overflow: false` · `forbiddenFound: []` |

---

## `qa_probe` דסקטופ (ששת הנתיבים)

פקודה: `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /,/treatment/,/method/,/lessons/,/sound-healing/,/testimonials/`  
תוצאה: `verdict: PASS` · `failures: 0` · כל ששת הנתיבים דסקטופ `overflow: false` · `forbiddenFound: []` (ראה `tmp/qa/cdp/qa_probe_result.json`).

---

## כשלים לתיקון (צוות 10)

1. **R1-02** — H1: הסר `<em>` סביב «דיג׳רידו»; נשאר `טיפול בדיג'רידו` כמו `treatment.md` SECTION 01.
2. **R1-26** — H1: הסר `<em>` סביב «ווידאו»; כותרת קטלוג (נוסח סופי — M-03 לאייל) בנפרד מהכשל הטכני.

אחרי תיקון — ריצת מאמת מחדש על R1-02 ו-R1-26 לפני הגשה לאייל.
