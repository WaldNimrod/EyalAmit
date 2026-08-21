# MANDATE — team_90 · Composer · גל 1 · טיפול

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6. פלט ריק = FAIL. אל תשנה קבצים מלבד הפסק.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`  
כתוב אל: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-W1-TREATMENT-2026-08-21.md`

חי: `http://eyalamit-co-il-2026.s887.upress.link/treatment/` · `curl -sk`.

מקור: `טיפול בדיג_רידו.xlsx` עמודה 5 + `treatment.md` SECTION 07/10.

## בדיקות

1. בלוק «מה ההבדל בין טיפול, סאונד הילינג ושיעורים»: מתחת לכותרת מופיע הטקסט המלא כולל «ההבדל המרכזי הוא פשוט» ו«ובשיעורים מתמקדים».
2. FAQ: כל השאלות החיות נשארו. בשאלת «במה זה שונה מטיפולי נשימה אחרים?» מופיע גם «טכניקת הנשימה המעגלית בדיג'רידו מחייבת דיוק».
3. CTA «לתיאום שיחת היכרות» יושב **בתוך** בלוק הסיום, לא בפס `cta-band` נפרד אחריו.
4. אין `.chap` מעל H2 של פרקי הטיפול (כולל הירו).
5. `?compare=eyal` עדיין כבוי. `treatment-eyal-defaults.php` לא נמחק. T-02 פלייסהולדר נשאר.
6. 13 המלצות בעמוד. קרוסלת JS לא נפתחה.

אסור: `videoblk.php` · `block-faq-list.php` · ACF.
