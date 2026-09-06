# MANDATE — team_90 · Composer ב׳ · S006 R2 W1 E2E + qa_probe

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. אסוף ראיות בעצמך. פלט ריק = FAIL. `-fast` אסור.
**אל תשנה** PHP / טרקר / Git. רק פסק דין.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`

בסיס: `http://eyalamit-co-il-2026.s887.upress.link`
מפה: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/MAP-S006-R2-W1-301-2026-08-25.md`

## הצלחה

לכל מקור: אחרי מעקב הפניות, ה-URL הסופי הוא היעד הנעול (200). **אל תדרג את גוף עמוד סבב 1.** אין כרטיס ריק ב-`<main>` של היעד הוא בדיקת ריק-רכיב בלבד — ממצא תוכן סבב 1 אינו FAIL של הגל הזה.

`curl` לבד אינו E2E. נדרש דפדפן (navigate → lock → snapshot) **או** `qa_probe` דסקטופ לאותם נתיבים **וגם** HEAD+GET שמאשרים Location.

## 16 הנתיבים

| מקור | יעד סופי |
|---|---|
| `/about/moksha/` | `/eyal-amit/mokesh-dahiman/` |
| `/courses-soon/` | `/learning/courses-external/` |
| `/hashita/` | `/method/` |
| `/muzeh/` | `/books/` |
| `/muzeh/kushi-blantis/` | `/books/kushi-blantis/` |
| `/muzeh/tsva-bechol-ve-zorek-layam/` | `/books/tsva-bekahol/` |
| `/muzeh/vekatavt/` | `/books/vekatavta/` |
| `/muzza/` | `/books/` |
| `/muzza/tsva-bechol-ve-zorek-layam/` | `/books/tsva-bekahol/` |
| `/muzza/vekatavt/` | `/books/vekatavta/` |
| `/services/didgeridoo-lessons/` | `/lessons/` |
| `/services/didgeridoo-treatment-breath/` | `/treatment/` |
| `/services/handmade-instruments/` | `/didgeridoos/` |
| `/tools-and-accessories/` | `/shop/` |
| `/tools-and-accessories/instruments/` | `/didgeridoos/` |
| `/tools-and-accessories/repair/` | `/repair/` |

## qa_probe

```
node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /about/moksha/,/courses-soon/,/hashita/,/muzeh/,/muzeh/kushi-blantis/,/muzeh/tsva-bechol-ve-zorek-layam/,/muzeh/vekatavt/,/muzza/,/muzza/tsva-bechol-ve-zorek-layam/,/muzza/vekatavt/,/services/didgeridoo-lessons/,/services/didgeridoo-treatment-breath/,/services/handmade-instruments/,/tools-and-accessories/,/tools-and-accessories/instruments/,/tools-and-accessories/repair/
```

PASS רק אם לכל path בדסקטופ: `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף.

## עדשת אקסל (חלק מב׳)

SSoT = xlsx. אל תשנה את האקסל.
16 השורות R2-002/004/005/008–014/018–020/024–026 קיימות, טאב לכל אחת, סוכן לא כתב עמודות אנוש.

כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R2-W1-E2E-B-2026-08-25.md`
