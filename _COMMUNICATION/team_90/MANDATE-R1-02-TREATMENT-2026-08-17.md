# MANDATE — team_90 · Composer · R1-02 /treatment/ two versions

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 (הסשן הזה) · Iron Rule #1.
**היקף:** דסקטופ בלבד. מובייל = מחוץ להיקף.
**עמודים:**
- מוצע: `http://eyalamit-co-il-2026.s887.upress.link/treatment/`
- מסמך: `http://eyalamit-co-il-2026.s887.upress.link/treatment/?compare=eyal`

TLS פג בכוונה — `curl -sk` מותר כאן בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL.

## ארבעת סעיפי החוזה (חובה)

1. **התאמת מקור** — כל מחרוזת תוכן חדשה חייבת להימצא במקור המצוטט. אחרת FAIL.
2. **האנק לא ממופה** — שינוי קוד שאינו ממופה לסעיף למטה → FAIL.
3. **Provenance** — מחרוזת שהשתנתה בלי הערת מקור בקוד → FAIL.
4. **פלט ריק = FAIL.**

מקור הבייטים: `content 13.8.26/טיפול בדיג'רידו/treatment.md` (גם בנתיב Drive וגם זהה ל-`docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/טיפול בדיג'רידו/treatment.md`).
תווית קופסת הווידאו `כאן ייכנס סרטון מפגש` — הוראת team_00 לשיטת הפלייסהולדר, לא תוכן אייל.

## סעיפים ממופים (רק אלה מותרים ב-diff)

- `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/treatment-defaults.php`
- `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/treatment-eyal-defaults.php` (חדש)
- `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` (מתג `?compare=eyal` + דילוג ACF ב-`/treatment/` כדי ששתי הגרסאות יישלטו מקבצי ה-PHP)
- `site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/videoblk-placeholder.php` (חדש)
- `site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/faq-inline.php` (חדש)

`git diff --name-only HEAD` חייב להיות תת-קבוצה של הרשימה הזו **בתוך ערכת הנושא**. קבצי טרקר / `_COMMUNICATION` / `tmp/` אינם FAIL.

## מה לבדוק ב-HTML החי (דסקטופ)

**שתיהן:**
1. כפתור ההירו `לתיאום שיחת היכרות` מצביע ל-`/contact/` (לא `#what`).
2. אין תג «עובדת הוותק» ואין הפסקה «שעוסק בתחום מאז 1999 בשיטת» בסקשן «מה זה».
3. «למי זה מתאים» כולל את הסעיפים «עייפות או חוסר יציבות אנרגטית» ו«מתמודד עם מחלה». אין כרטיסי `.rcard`.
4. אין סרטון `ea-home-hero-720`. יש קופסה `כאן ייכנס סרטון מפגש`.
5. שם «שירי אלקבץ» הוא קישור ל-`facebook.com/share/p/1E7ndvYyrp`.
6. «סטודיו נשימה מעגלית» מופיע בסקשן «מי זה אייל עמית».
7. אפס כרטיסי המלצה ריקים.

**רק המוצעת (`/treatment/`):**
8. קיים `<section class="bleed">` עם «הנשימה היא לכולם.»
9. האקורדיון הנראה (לא JSON-LD) כולל שאלה על CPAP / נחירות מעבר ל-15 של המסמך. סימן: `data-faq-category="treatment"` או יותר מ-15 `<details class="ea-faq-item">` גלויים. (JSON-LD של התוסף עשוי להכיל את אותן שאלות גם בגרסת המסמך — זה לא FAIL אם האקורדיון עצמו בגרסת המסמך הוא 15.)

**רק גרסת המסמך (`?compare=eyal`):**
10. אין `<section class="bleed">`.
11. אין `data-faq-category="treatment"`. מספר `<details class="ea-faq-item">` הנראים הוא 15 (ייתכנו 3 `<details class="dd__item">` נוספים להבחנה — לא לספור אותם כ-FAQ).

## מלכודות מדידה

- הקרוסלה עשויה לשכפל כרטיסי המלצה ב-DOM — סופרים שמות ייחודיים.
- `-k` רק מול הסטייג'ינג.
- אל תבדקו מובייל.
- JSON-LD `FAQPage` עלול לכלול את בנק ה-CPT המלא גם ב-`?compare=eyal`. בדקו את האקורדיון הנראה, לא את ה-JSON-LD.

## פלט חובה

שורה ראשונה בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`
אחר כך רשימת בדיקות קצרה עם CONFIRMED/FAIL + ציטוט ראיה.
ריק = FAIL.
