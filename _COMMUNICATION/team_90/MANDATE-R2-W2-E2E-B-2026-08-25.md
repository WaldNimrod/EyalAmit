# MANDATE — team_90 · Composer ב׳ · S006 R2 W2 E2E + qa_probe

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. אסוף ראיות בעצמך. פלט ריק = FAIL. `-fast` אסור.
**אל תשנה** PHP / טרקר / Git. רק פסק דין.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`

בסיס: `http://eyalamit-co-il-2026.s887.upress.link`
איסוף: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/COLLECT-S006-R2-W2-QR-2026-08-25.md`

## הצלחה

- **ילדים מודפסים** (`/qr/qr1/` … `/qr/qr48/` כולל qr4–qr9 שאינם רציפים ב-CSV): HEAD+GET **200**, בלי `Location` שמוציא מהנתיב המודפס. גוף אינו כרטיס ריק.
- **שער `/qr/`:** בסטייג'ינג 200 מותר (אינדקס). בפרודקשן 308/302 לספר מתועד בהיסטוריה — **לא FAIL** כל עוד הילדים 200. אסור 301 ילד החוצה.
- `curl` לבד אינו E2E. נדרש `qa_probe` דסקטופ לכל הנתיבים **וגם** HEAD+GET. דגימת דפדפן (navigate → lock → snapshot) לפחות על `/qr/qr1/` ו-`/qr/qr48/`.

## 49 הנתיבים

`/qr/`, `/qr/qr1/`, `/qr/qr10/`, `/qr/qr11/`, `/qr/qr12/`, `/qr/qr13/`, `/qr/qr14/`, `/qr/qr15/`, `/qr/qr16/`, `/qr/qr17/`, `/qr/qr18/`, `/qr/qr19/`, `/qr/qr2/`, `/qr/qr20/`, `/qr/qr21/`, `/qr/qr22/`, `/qr/qr23/`, `/qr/qr24/`, `/qr/qr25/`, `/qr/qr26/`, `/qr/qr27/`, `/qr/qr28/`, `/qr/qr29/`, `/qr/qr3/`, `/qr/qr30/`, `/qr/qr31/`, `/qr/qr32/`, `/qr/qr33/`, `/qr/qr34/`, `/qr/qr35/`, `/qr/qr36/`, `/qr/qr37/`, `/qr/qr38/`, `/qr/qr39/`, `/qr/qr4/`, `/qr/qr40/`, `/qr/qr41/`, `/qr/qr42/`, `/qr/qr43/`, `/qr/qr44/`, `/qr/qr45/`, `/qr/qr46/`, `/qr/qr47/`, `/qr/qr48/`, `/qr/qr5/`, `/qr/qr6/`, `/qr/qr7/`, `/qr/qr8/`, `/qr/qr9/`

## qa_probe

הרץ בשני אצוות אם צריך (timeout). PASS רק אם לכל path בדסקטופ: `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף.

```
node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /qr/,/qr/qr1/,/qr/qr10/,/qr/qr11/,/qr/qr12/,/qr/qr13/,/qr/qr14/,/qr/qr15/,/qr/qr16/,/qr/qr17/,/qr/qr18/,/qr/qr19/,/qr/qr2/,/qr/qr20/,/qr/qr21/,/qr/qr22/,/qr/qr23/,/qr/qr24/,/qr/qr25/
```

```
node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /qr/qr26/,/qr/qr27/,/qr/qr28/,/qr/qr29/,/qr/qr3/,/qr/qr30/,/qr/qr31/,/qr/qr32/,/qr/qr33/,/qr/qr34/,/qr/qr35/,/qr/qr36/,/qr/qr37/,/qr/qr38/,/qr/qr39/,/qr/qr4/,/qr/qr40/,/qr/qr41/,/qr/qr42/,/qr/qr43/,/qr/qr44/,/qr/qr45/,/qr/qr46/,/qr/qr47/,/qr/qr48/,/qr/qr5/,/qr/qr6/,/qr/qr7/,/qr/qr8/,/qr/qr9/
```

## עדשת אקסל (חלק מב׳)

SSoT = xlsx. אל תשנה את האקסל.
49 השורות R2-081…129 קיימות, טאב לכל אחת, סוכן לא כתב עמודות אנוש. CSV מיושן אינו FAIL.

כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R2-W2-E2E-B-2026-08-25.md`
