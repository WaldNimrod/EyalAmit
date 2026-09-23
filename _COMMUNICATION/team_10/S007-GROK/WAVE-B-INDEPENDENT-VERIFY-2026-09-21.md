# גל ב — אימות נפרד · 2026-09-21

**מאמת:** מנוע אחר מהבונה (Iron Rule #1).  
**בונה:** צוות 10 Composer · תמה חיה **1.5.98** · HEAD `d0c5de1` (`d3d82b9` + `5e0017b`).  
**סטייג'ינג:** http://eyalamit-co-il-2026.s887.upress.link (HTTP, בלי follow).  
**מדידה:** GET + CDP 390/1440. JSON: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-b-retest/cdp-retest.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-b-retest/cdp-retest.json)

| סעיף | חוזה | תוצאה | פסק |
|---|---|---|---|
| גרסה | `style.css?ver=1.5.98` | חי בכל עמודי 200 שנבדקו | PASS |
| WB-02 | פירורים מעל H1 ב־`/method/` `/lessons/` | «בית / השיטה», «בית / שיעורי דיג׳רידו»; `crumbAboveH1` true | PASS |
| WB-02 | נעדר ב־`/` וב־`/qr/qr1/` | crumb=false בשניהם | PASS |
| WB-02 עומק 3 | `/learning/therapist-training/` `/books/tsva-bekahol/` | בית / לימוד והכשרה / הכשרות למטפלים · בית / ספרים / צבע בכחול וזרוק לים | PASS |
| WB-03a | 32px שנהב מעל `.foot` ב־`/contact/` | `gapH=32`, `gapAboveFoot=true`. CTA נשאר `--dark-grad` | PASS |
| WB-04a | nowrap על «שיטת cbDIDG» לא על כל H1 | span חי ב־`/method/` `/lessons/` `/learning/therapist-training/` `/`. `tokenLines=1` ב־390. overflow=false | PASS |
| WB-17 | nav 88→56; `--fs-nav` נעול | מנוחה 88.0, גלילה `data-s=1` גובה 56.0. `--fs-nav` חי 1.1475rem → **18.36px** על `.nav__l a` | PASS |
| WB-17 | `/lessons/` 390 H1 לא מאחורי הסרגל | overlap false, gapH1 **50.2** (≥16) | PASS |
| WB-07 | כניסה ראשונה: דיאלוג, בלי gtag | dialogOpen true, `typeof gtag==='undefined'`, אין `gtag/js` | PASS |
| WB-07 | דחייה: אין gtag/fonts אחרי רענון | GET `-b ea_cookie_cmp=reject`: gtag false, fonts false. CDP אחרי קליק: dialog סגור, gtag undefined | PASS |
| WB-07 | אישור: gtag+fonts | GET accept + CDP אחרי קליק: `gtag=function`, `gtagSrc` true, fonts true | PASS |
| WB-07 | נוסח פרטיות | «ניתן לאשר או לדחות מדידה»; 0 «אין חסימת מדידה». כפתור «הבנתי» נעלם | PASS |
| WB-08 FAQ | 0 `www.eyalamit.co.il` בששת קישורי הכלים/תיקון/בלוג | `/didgeridoos/` `/bags/` `/stand-floor/` `/stands-storage/` `/repair/` + `/blog/נשים-מנגנות…` | PASS |
| WB-08 חניה | `courses-external` נשאר `https://www.eyalamit.co.il/` | 2× href לייצור — לא הוחלף | PASS |
| אסור | לא `--terra-dk` על `.cta-band` | `.cta-band{background:var(--dark-grad)}` חי | PASS |
| overflow | 390/1440 בעמודי החוזה | 0 overflow ב־CDP | PASS |

## לא חוזה / נשאר

- **תוכן פוסטים ב־DB** (לא תמה): טור 49 עדיין `https://www.eyalamit.co.il/צור-קשר/` · טור 40 עדיין מוזה לגסי · פוסט ריברסינג עדיין hrefs לגסי (כולל מוקש + `/` ייצור). לא נגענו בזה באימות.
- **`/learning/courses-external/`** בלי פירורים — העמוד מחוץ ל־phero של Chapters; החוזה דרש method/lessons + חריגי בית/QR בלבד.
- **טינט באמצע עמוד:** לא מומש (נדחה / ממתין לסקיצה).

## צילומים

[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-b-retest/shots/](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-b-retest/shots/)
