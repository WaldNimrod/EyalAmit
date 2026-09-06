VERDICT: FAIL

**מאמת:** team_90 · `composer-2.5` · 2026-08-18  
**בנאי:** Cursor Grok 4.6 · Iron Rule #1 (validator ≠ builder; ללא שינוי קוד)  
**מנדט:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-FINAL-SWEEP-2026-08-18.md`  
**בסיס:** `http://eyalamit-co-il-2026.s887.upress.link` · דסקטופ בלבד · `curl -sk`  
**אקסל:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/EA-CONTENT-TRACKER-2026-08-18.csv`  
**ראיות:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/team90_s006/`

---

## סיכום

| שורה | נתיב | תוצאה |
|------|------|--------|
| R1-07 | `/learning/therapist-training/` | **CONFIRMED** (הוקפא — HTTP בלבד) |
| R1-08 | `/learning/lectures/` | **CONFIRMED** (הוקפא — HTTP בלבד) |
| R1-09 | `/learning/workshops/` | **CONFIRMED** (הוקפא — HTTP בלבד) |
| R1-17 | `/books/kushi-blantis/` | **CONFIRMED** |
| R1-18 | `/books/tsva-bekahol/` | **CONFIRMED** |
| R1-19 | `/books/vekatavta/` | **CONFIRMED** |
| R1-25 | `/faq/` | **FAIL** — 3 קישורים פנימיים ב-`<main>` → HTTP 404 |
| R1-27 | `/galleries/` | **CONFIRMED** (הוקפא — HTTP בלבד) |
| R1-28 | `/snoring-sleep-apnea/` | **CONFIRMED** |

**גורם כשל יחיד:** R1-25 — קישורי `<main>` שבורים (404). כל שאר הסעיפים בהיקף עברו.

---

## טבלת בדיקות

| שורה | בדיקה | תוצאה | ראיה (ציטוט / HTTP / אקסל / מחרוזת) |
|------|--------|--------|--------------------------------------|
| R1-07 | HTTP 200 (הוקפא) | **CONFIRMED** | `curl -sk` → HTTP **200** `/learning/therapist-training/` |
| R1-08 | HTTP 200 (הוקפא) | **CONFIRMED** | `curl -sk` → HTTP **200** `/learning/lectures/` |
| R1-09 | HTTP 200 (הוקפא) | **CONFIRMED** | `curl -sk` → HTTP **200** `/learning/workshops/` |
| R1-27 | HTTP 200 (הוקפא) | **CONFIRMED** | `curl -sk` → HTTP **200** `/galleries/` |
| R1-17 | HTTP 200 | **CONFIRMED** | HTTP **200** |
| R1-17 | H1 = `כושי בלאנטיס` · ללא `<em>` | **CONFIRMED** | `<h1>כושי בלאנטיס</h1>` |
| R1-17 | 3–5 ציטוטי מקור ב-`<main>` | **CONFIRMED** | 5/5: «כושי בלאנטיס הוא רומן פנטזיה» · «על סמטת הדלתות הבוחנות» · «כל אדם הוא אדריכל של גורלו» · «ערום לגמרי» · «מקדונלד» |
| R1-17 | אפס מחרוזות פדיחה | **CONFIRMED** | אין `mrng.to` · אין 69/59/79 ₪ · אין PLACEHOLDER |
| R1-17 | קישורים פנימיים `<main>` | **CONFIRMED** | 0 קישורים פנימיים · אין 404 |
| R1-17 | אקסל `הוגש לבדיקה` · `ממתין ל` = אייל | **CONFIRMED** | `סטטוס מכונה=הוגש לבדיקה` · `ממתין ל=אייל` |
| R1-17 | `qa_probe` דסקטופ · overflow false | **CONFIRMED** | `verdict: PASS` · `overflow: false` · `forbiddenFound: []` |
| R1-18 | HTTP 200 | **CONFIRMED** | HTTP **200** |
| R1-18 | H1 = `צבע בכחול וזרוק לים` | **CONFIRMED** | `<h1>צבע בכחול וזרוק לים</h1>` |
| R1-18 | 3–5 ציטוטי מקור | **CONFIRMED** | 5/5: «38 סיפורים קצרים» · «צ'וליות בבוליביה» · «הזיות בקולומביה» · «שוד עם אקדח לראש בברזיל» · «ספר מתנה לכל מי שמתכנן טיול» |
| R1-18 | אפס מחרוזות פדיחה | **CONFIRMED** | אין `mrng.to` · אין מחירי 69/59/79 ₪ |
| R1-18 | קישורים פנימיים `<main>` | **CONFIRMED** | אין 404 בדגימה |
| R1-18 | אקסל | **CONFIRMED** | `הוגש לבדיקה` · `ממתין ל=אייל` |
| R1-18 | `qa_probe` דסקטופ | **CONFIRMED** | `verdict: PASS` · `overflow: false` |
| R1-19 | HTTP 200 | **CONFIRMED** | HTTP **200** |
| R1-19 | H1 = `וכתבת` | **CONFIRMED** | `<h1>וכתבת</h1>` |
| R1-19 | 3–5 ציטוטי מקור | **CONFIRMED** | 5/5: «46 סיפורים אמיתיים» · «ספוקן סטוריז» · «סריקת ה-QR» · «הפעם הראשונה בחיי שעליתי על מטוס» · «כנופיית שודדים הצמידה לי אקדח» |
| R1-19 | אפס מחרוזות פדיחה | **CONFIRMED** | אין `mrng.to` · אין מחירי 69/59/79 ₪ |
| R1-19 | קישורים פנימיים `<main>` | **CONFIRMED** | אין 404 |
| R1-19 | אקסל | **CONFIRMED** | `הוגש לבדיקה` · `ממתין ל=אייל` |
| R1-19 | `qa_probe` דסקטופ | **CONFIRMED** | `verdict: PASS` · `overflow: false` |
| R1-25 | HTTP 200 | **CONFIRMED** | HTTP **200** · HTML 169854 bytes |
| R1-25 | H1 = `שאלות נפוצות` · ללא `<em>` | **CONFIRMED** | `<h1 class="phero__h">שאלות נפוצות</h1>` |
| R1-25 | 3–5 ציטוטי מקור | **CONFIRMED** | 4+ מ-FAQ FINAL: «לא כל עבודה עם דיג'רידו היא אותו דבר» · «האם צריך ניסיון קודם בנגינה» · «מה זה בעצם טיפול בדיג'רידו» · «סאונד הילינג» |
| R1-25 | אפס PLACEHOLDER / כרטיסי דוגמה | **CONFIRMED** | אין `PLACEHOLDER` · אין `שאלת דוגמה` ב-`<main>` |
| R1-25 | FAQ-01/04 ממתין לאייל | **N/A (לא FAIL)** | `ea-pending-approval` במחיר — מותר לפי מנדט |
| R1-25 | קישורי `<main>` פנימיים — אין 404 | **FAIL** | **`/blog/pregnancy-didgeridoo` → HTTP 404** (טקסט: «קראו עוד על דיג'רידו והריון») · **`/muse` → HTTP 404** (טקסט: «מוזה הוצאה לאור») · **`/cbDidg-therapy-training` → HTTP 404** (טקסט: «קורס הכשרה למטפלים בשיטת cbDIDG») |
| R1-25 | אקסל | **CONFIRMED** | `הוגש לבדיקה` · `ממתין ל=אייל` |
| R1-25 | `qa_probe` דסקטופ | **CONFIRMED** | `verdict: PASS` · `overflow: false` · `forbiddenFound: []` (לא בודק 404 לינקים) |
| R1-28 | HTTP 200 | **CONFIRMED** | HTTP **200** |
| R1-28 | H1 מכיל `נחירות ודום נשימה בשינה` | **CONFIRMED** | `נחירות ודום נשימה בשינה: גישה טיפולית באמצעות דיג'רידו` |
| R1-28 | 3–5 ציטוטי מקור | **CONFIRMED** | 5/5: «רוב הפתרונות פועלים בזמן השינה» · «BMJ» · «הסיפור של יוני» · «דיג'רידו הוא לא מכשיר רפואי» · «נחירות ודום נשימה בשינה» |
| R1-28 | אפס מחרוזות פדיחה | **CONFIRMED** | אין «להשלמה לפני פרסום» · אין PLACEHOLDER |
| R1-28 | יוני + מכבי ממתינים | **N/A (לא FAIL)** | «הסיפור של יוני» בחי · כרטיסי מכבי/יוני ממתינים — מותר |
| R1-28 | קישורי `<main>` פנימיים | **CONFIRMED** | אין 404 בדגימה |
| R1-28 | אקסל | **CONFIRMED** | `הוגש לבדיקה` · `ממתין ל=אייל` |
| R1-28 | `qa_probe` דסקטופ | **CONFIRMED** | `verdict: PASS` · `overflow: false` |

---

## פעולה נדרשת (צוות 10 / 100)

תיקון R1-25 — שלושה קישורים פנימיים שבורים ב-`<main>`:

1. `/blog/pregnancy-didgeridoo` → יעד חי (בלוג/מאמר הריון) או הסרה
2. `/muse` → `/books/` (קנון מוזה)
3. `/cbDidg-therapy-training` → `/learning/therapist-training/` (או יעד קנוני אחר שקיים)

לאחר תיקון — הרצת מנדט R1-25 מחדש.
