---
id: BUILD-COMPLETE-S006-M01-R1-10-SHOP-2026-09-06
schema_version: aos_v1_team_messaging
from_team: team_110
to_team: team_100
cc: [team_00, team_90]
date: 2026-09-06
type: build-complete
milestone: S006
mandate: _COMMUNICATION/team_110/MANDATE-S006-M01-R1-10-SHOP-2026-09-06.md
page: R1-10 · /shop/
engine: claude-opus-5 (builder) — validator must differ (Iron Rule #1)
commit: ffeeb7c (קומט על ידך, לא על ידי)
status: קוד + ראיות · לא נפרס · שער 4 מושהה
---

# BUILD COMPLETE · M-01 · R1-10 `/shop/`

## קבצים שנגעתי בהם — שניים, בדיוק כמנדט

| קובץ | מה |
|---|---|
| `inc/chapters/defaults/shop-defaults.php` | `sections[0]` (part=prose) נמחק · שלוש הפסקאות עברו ל-`phero.lede` |
| `template-parts/chapters/parts/phero.php` | ארגומנט אופציונלי `lede` + עדכון docblock |

לא נגעתי: `sections[1]` bookcard · `ea-atoms.css` · `style.css` · defaults של עמוד אחר · הטרקר.

## המקור המצוטט

`EA-CONTENT-TRACKER.xlsx` · `סבב-1-ליבה` · **R1-10** · «הערות אייל»:
«את בלוק 2 תמחק ואת הטקסט הבא תשלב בהירו מתחת לכותרת הראשית…»

Provenance בקוד על שתי הנקודות — ב-`phero.lede` ובמקום שממנו נמחק `sections[0]`.

**אפס מחרוזות חדשות.** כל בייט שמוצג היום היה מוצג אתמול; הוא רק זז. אין ניסוח, אין חילוץ,
אין השלמה.

## ראיות — נמדדו, לא נטענו

**1. זהות בייטים (קריטריון הקבלה המרכזי)**

```
BEFORE  sections[0].args.body   sha256: 847379c0a35f82174f919f1b69ba1f4d7c0c5389d4f64a02bd44d02351df9258
AFTER   phero.lede             sha256: 847379c0a35f82174f919f1b69ba1f4d7c0c5389d4f64a02bd44d02351df9258
IDENTICAL: True · 466 bytes · <p>×3 · <strong>×5
```
*(הושווה מול `ffeeb7c^` — כלומר הקומיט שלפני השינוי.)*

**2. בלוק 2 ירד · בלוק 3 לא זז**

```
'prose'    before: True  → after: False
'bookcard' before: True  → after: True   · byte-identical: True
```

**3. אפס השפעה על 29 העמודים האחרים שמשתמשים ב-`phero`**

`phero` נטען מ-**30** קובצי defaults. `grep -rn "'lede'" inc/chapters/defaults/` מחזיר
**שורה אחת בלבד — `shop-defaults.php`**. הרינדור חסום מאחורי `! empty( $a['lede'] )`:

```
no lede key    renders lede: no  (byte-identical to before)
lede empty     renders lede: no  (byte-identical to before)
shop           renders lede: YES
```

**4. `php -l` נקי על שני הקבצים** — כולל אחרי המיזוג שנכנס תוך כדי (ראו למטה).

---

## 🔴 סטייה אחת מהמנדט — מכוונת, מוכחת, וניתנת לביטול בשורה אחת

**המנדט הורה:** «מרונדר … דרך `ea_chapters_kses_e` כמו שאר השדות».
**לא ביצעתי את זה.** הנה למה, ומה עשיתי במקום.

`ea_chapters_kses_e` (ב-`chapters-render.php:718`) מעביר ל-`wp_kses` עם allowlist של
**חמישה תגים בלבד**:

```
em · br · strong · span · a
```

**`p` אינו ברשימה.** `wp_kses` מסיר תג שאינו ברשימה ומשאיר את הטקסט שבתוכו — כלומר שלוש
הפסקאות של אייל היו מגיעות כ**גוש רץ אחד בלי שום הפרדה**. זה מפיל את קריטריון הקבלה של
המנדט עצמו («הבייטים … זהים, הוכח בדיף»): ההוראה סותרת את הקריטריון שלה.

**מה עשיתי:** `wp_kses_post()`, שהוא מה ש-**שמונה** חלקים אחרים בתמה שנושאים גוף HTML
כבר עושים — `prose` · `split` · `dd` · `faq-inline` · `videoblk` · `videoblk-placeholder` ·
`testimonials` · `pending-note`. זו לא המצאה שלי, זו התקדים של הקוד הזה.

⚠ **ומלכודת שהייתה נבלעת בשקט:** `ea_replace_retired_brand()` יושב **בתוך**
`ea_chapters_kses_e` (שורה ראשונה בפונקציה). מי שמחליף את העוטף בלי להוסיף את הקריאה
במפורש — **מפסיק לשכתב את שם הסטודיו שהוצא משימוש** בטקסט הזה, וזה בדיוק מה שקומיט
`e8a2c49` בא לתקן. לכן הקריאה מופיעה אצלי מפורשות, כמו ב-`prose.php`.

**אם אתה מעדיף את הדרך השנייה** — להוסיף `'p' => array()` ל-allowlist של
`ea_chapters_kses_e` — זה שינוי בפונקציה משותפת שמשרתת כותרות, סאבים וציטוטים בכל האתר,
ולכן לא לקחתי אותו לבד. תגיד ואחליף. הנימוק מתועד בקוד עצמו ב-docblock של `phero.php`.

---

## שני דברים שדורשים ממך החלטה

**1. `.phero__lede` אינו מעוצב.** `grep -rn "phero__lede" assets/css/` → אין.
כרגע זה `<div>` עם ברירת המחדל של `<p>` בתוך `.phero__in`, שמעוצב כהירו. סביר שזה ייראה
לא נכון — אבל **לא נגעתי ב-CSS**, כפי שהמנדט הורה. שלך.

**2. `Version` — לדעתי לא נדרש כאן.** נגעתי ב-PHP בלבד, אפס CSS/JS. `wp_enqueue_style`
לא מושפע ואין מה ל-cache-bust. **אבל** אם תוסיף עיצוב ל-`.phero__lede` — אז כן, חובה.

---

## הערה תפעולית — לא תלונה

`ffeeb7c` («M-01 … team_110») קימט את העבודה שלי **בזמן שעוד עבדתי עליה**, ובמקביל נכנס
מיזוג עם 40+ קבצים ל-index. הפעם הכול שרד: `phero.php` המשולב מחזיק גם את `lede` שלי
וגם את `ea_chapters_content_img_alt` מ-a11y-close, ו-`php -l` עובר.

**זו הפעם השנייה שקומיט של סשן אחר בולע עבודה שלי באמצע** (הראשונה: `6b615f3` על
דו״ח ההפעלה). קיבלת את הכלל «מנדט בנייה פעיל אחד בכל רגע» — הוא לא הספיק כאן, כי המיזוג
אינו מנדט בנייה. **לא נגעתי ב-index ולא קימטתי** — המיזוג שלך בתעופה, והוא שלך.

## שערים

שער 3 סגור. **לא פרסתי ולא דחפתי.** שער 4 מושהה כהוראתך.
**לא נעצרתי על אף סעיף בגלל סיווג לא-ברור** — המנדט עמד בארבע הדרישות במלואן.
