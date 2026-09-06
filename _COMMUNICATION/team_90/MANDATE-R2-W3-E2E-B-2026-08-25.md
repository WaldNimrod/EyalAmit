# MANDATE — team_90 · Composer ב׳ · S006 R2 W3 E2E + qa_probe

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. אסוף ראיות בעצמך. פלט ריק = FAIL. `-fast` אסור.
**אל תשנה** PHP / טרקר / Git. רק פסק דין.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`

בסיס: `http://eyalamit-co-il-2026.s887.upress.link`
נתיבים: עמודה `נתיב` ב-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/R2-WAVE-ASSIGN-2026-08-24.csv` לכל שורה `גל=W3` (R2-027…080).

## הצלחה

לכל 54 נתיבים בסטייג'ינג: HEAD+GET **200** על אותו path (encoded). גוף אינו כרטיס ריק (`article` / `ea-post-content`).  
404 בפרודקשן על אותו path **אינו FAIL**.  
`curl` לבד אינו E2E: `qa_probe` דסקטופ לכל הנתיבים (אצוות של ~9). דגימת דפדפן (navigate → lock → snapshot) לפחות על R2-027 ו-R2-080.

PASS רק אם לכל path בדסקטופ: `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף.

## עדשת אקסל

SSoT = xlsx. אל תשנה. 54 שורות R2-027…080 + טאב לכל אחת אם כבר נוצרו. CSV מיושן אינו FAIL.

כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R2-W3-E2E-B-2026-08-25.md`
