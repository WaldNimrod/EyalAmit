# MANDATE — team_90 · Composer · גל 5 · המלצות + קרוסלה

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6. פלט ריק = FAIL. אל תשנה קבצים מלבד הפסק.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`  
כתוב אל: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-W5-TESTIMONIALS-2026-08-21.md`

חי (HTTP, בלי `https://`, בלי `curl -k`), cache-bust `?ea=w5-validate-20260821`:

- http://eyalamit-co-il-2026.s887.upress.link/testimonials/
- http://eyalamit-co-il-2026.s887.upress.link/sound-healing/
- http://eyalamit-co-il-2026.s887.upress.link/method/

מקור: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/הערות%20של%20אייל%20לאחר%20סבב%20שלב%201%20-%2019.8.26/המלצות.xlsx`

## בדיקות

1. ב-`/testimonials/` ה-H1 הוא `עדויות והמלצות` (לא `מדיה ווידאו`).
2. ב-`/testimonials/` מופיע **דן ארליכמן** עם הטקסט שמתחיל `משתף אתכם בכתבה` וקישור פייסבוק `1DKp5Coss8`.
3. ב-`/sound-healing/` (או `/method/`) לקרוסלת העדויות יש כפתור שמאלה וכפתור ימינה. אין אנימציית `testi-scroll` / `animation: … infinite` על ה-track.
4. אין תמונות פרופיל מומצאות (אין `via.placeholder` / `ui-avatars` / hotlink חדש לפרופיל). כפילויות שם בריכוז **נשארות**.
5. קישור «לכל ההמלצות» בעמודי השיטה/סאונד → `/testimonials/` (לא `/media/`).
6. **לא** נדרש בגל זה: שכתוב ציטוטים ל-50 מילים (הכרעת נימרוד), סרטונים/כתבות (M-04).

אסור: `videoblk.php` · `block-faq-list.php`. קבצים dirty מלפני הגל אינם FAIL.
