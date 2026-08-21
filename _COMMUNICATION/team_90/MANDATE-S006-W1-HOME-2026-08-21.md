# MANDATE — team_90 · Composer · גל 1 · בית

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6. פלט ריק = FAIL. אל תשנה קבצים מלבד הפסק.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`  
כתוב אל: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-W1-HOME-2026-08-21.md`

חי: `http://eyalamit-co-il-2026.s887.upress.link/` · `curl -sk` · דסקטופ.

מקור: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/הערות%20של%20אייל%20לאחר%20סבב%20שלב%201%20-%2019.8.26/דף%20הבית.xlsx` + `homepage1-3 v2.md`.

## בדיקות

1. אין תווית `פרק 02`…`פרק 11` (`.chap` ריק בפרקים הממוספרים). כותרות H2 נשארות.
2. פרק 2 (`#what`): מופיעה הפסקה «יש דרכים שונות לעבוד עם הנשימה…».
3. פרק 4 (`#compare`): אין את אותה פסקה מתחת לכותרת (`cmp_lead` ריק). כרטיסי ההשוואה נשארים.
4. פרק 5 (`#whom`): אין משפט `whom_lead` מעל הרשימה.
5. פרק 11 (`#about`): קישור `לקריאה נוספת אודות אייל עמית` → `/eyal-amit/`. אין `לעמוד אייל עמית`. אין `.tl`.
6. פרק 9 (`#peek`): גלריית תמונות מנכסי תמה (`home-peek/`), לא הוטלינק ל-eyalamit.co.il. H-06 פלייסהולדר וידאו **נשאר**.
7. פרק 10: CTA `לכל ההמלצות` → `/testimonials/` לא `/media/`. 15 עדויות מה-md (לא להמציא 16).

אסור: `ea-testimonials.js` · `videoblk.php`. קבצים dirty מלפני הגל אינם FAIL.
