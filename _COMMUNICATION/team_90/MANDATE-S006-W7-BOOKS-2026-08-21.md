# MANDATE — team_90 · Composer · גל 7 · ספרים

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6. פלט ריק = FAIL. אל תשנה קבצים מלבד הפסק.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`  
כתוב אל: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-W7-BOOKS-2026-08-21.md`

חי (`http://` בלבד):

- `http://eyalamit-co-il-2026.s887.upress.link/books/`
- `http://eyalamit-co-il-2026.s887.upress.link/books/kushi-blantis/`
- `http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/`
- `http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/`

## בדיקות

1. `/books/` H1 `מוזה הוצאה לאור - ספרים`. תת-כותרת כוללת `הוקמה בשנת 2004`. בלוק ויקיפדיה «לקריאה נוספת על אייל עמית בויקיפדיה» **אינו** מופיע.
2. בסרגל הראשי יש קישור `ספרים` אל `/books/` (לא התווית `מוזה הוצאה לאור` כפריט עליון). בדרופ: `מבצעים`, `צבע בכחול וזרוק לים`, `כושי בלאנטיס`, `וכתבת`.
3. ב«שלושה ספרים, שלושה עולמות» מופיע גם `אין סדר קריאה מחייב`.
4. `/books/kushi-blantis/`: גלריה עם ≥15 תמונות. H2 `על אייל עמית` כולל קישור `/eyal-amit/`. כפתור `לרכישת הספר` מופיע גם אחרי התקציר. `מוקש דהימן` מקשר ל-`/eyal-amit/mokesh-dahiman/`.
5. `/books/tsva-bekahol/`: גלריה עם ≥20 תמונות. קישור אודות אל `/eyal-amit/` (לא `/about/`). מופיע `https://www.mendele.co.il/product/tzvabekahol/`. כפתור `לרכישת הספר המודפס` → `/contact/`.
6. `/books/vekatavta/`: קטע מתוך הספר ב-`<details>`/`<summary>`. גלריה עם ≥20 תמונות. כותרת `על אייל עמית` **בלי** `(בהקשר הספר)`. כפתור `לרכישת הספר` גם אחרי התקציר.
7. תמונות הירו (עטיפות) נשארו. אין `via.placeholder`.

אסור: `videoblk.php` · `block-faq-list.php`. קבצים dirty מלפני הגל אינם FAIL.
