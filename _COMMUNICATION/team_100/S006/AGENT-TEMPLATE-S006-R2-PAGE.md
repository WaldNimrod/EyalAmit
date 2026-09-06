# תבנית סוכן משנה — סבב 2 · עמוד אחד

**מנהל:** team_100 · **חוק:** אמנה §3א / §3ג / §8ד · **תוכנית גלים:** [`WAVE-PLAN-S006-R2-2026-08-24.md`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/WAVE-PLAN-S006-R2-2026-08-24.md)

סוכן משנה מקבל **שורת טרקר אחת** + סוג גל. לא פותח שורה שנייה. לא כותב עמודות אנוש.

במחלוקת: אמנה › GO רציף › תוכנית הגלים › התבנית הזו › זיכרון סשן.  
[`HANDOFF-TEMPLATE-GENERIC.md`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/HANDOFF-TEMPLATE-GENERIC.md) §0/§2 **אינם** דורשים סקואופ לכל שורה בסשן הביצוע הזה.

---

## 0. זהות

```
שורה: R2-xxx
עמוד (שם אנושי): …
נתיב: /…/
גל: W1 | W2 | W3 | W4 | W5
סוג: 301-אימות | 301-חדש | QR-העתקה | פוסט-העתקה | ליגל-מחקר | ארכיון-חי
מקור הבייטים (ציטוט): …
מחוץ לסקואופ: 23 עמודי סבב 1 · טופס סבב 1 · videoblk.php · block-faq-list.php · wp-admin · מובייל
```

ששת הגלים נעולים ב-[`GO-S006-R2-CONTINUOUS-RUN-2026-08-24.md`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/GO-S006-R2-CONTINUOUS-RUN-2026-08-24.md). team_100 מחלק שורות. סוכן משנה לא פותח גל חדש לבד ולא מבקש סקואופ. `לא ברור` לנימרוד → **חסימה**, לא ניחוש.

---

## 1. טרקר — לפני קוד

```bash
python3 scripts/tracker_guard.py --mode ingest
python3 scripts/tracker_update.py --row R2-xxx --set "סטטוס מכונה=בעבודה" --actor team_100 --reason "S006 R2 W#"
python3 scripts/tracker_page_tab.py --create R2-xxx --items _COMMUNICATION/team_100/S006/tracker/r2-xxx-items.json
```

`r2-xxx-items.json`: סעיפים לפי `ITEM_HEADERS`.  
`ברור` = לביצוע. `לא ברור` לאייל = `מה נדרש ממך` משפט אחד + `_picks` + `קישור` חי.  
כל `ממתין לאייל` מועתק גם ל-[`QUESTIONS-S006-R2-EYAL-REGISTER.md`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/QUESTIONS-S006-R2-EYAL-REGISTER.md).  
`לא ברור` לנימרוד → **עצירה.** לא מנחשים.

---

## 2. בנייה — לפי סוג

| סוג | מותר | אסור |
|---|---|---|
| 301-אימות | HEAD+GET, תיעוד יעד בטרקר. בלי PHP אם היעד לא זז | לשנות את עמוד היעד |
| 301-חדש | הפניה מהנתיב הישן ליעד שננעל בגל 1 | למזג טקסט; לגעת ב-defaults של סבב 1 |
| QR / פוסט | להעתיק מהאתר הישן/חי מילה-במילה. כתובת מדויקת | ניסוח, קיצור, «שיפור» |
| ליגל | טיוטה ממחקר מצוטט — **לא הדבקה** עד שנימרוד ראה את הטיוטות (חסימת גל 4) | המצאת סעיפים משפטיים |
| ארכיון-חי | להשאיר את החי; לתעד; לסמן על העץ | להמציא חבילה |

ערוץ כתיבה אם יש PHP: `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/<page>-defaults.php`  
אין קובץ defaults → אסקלציה ל-100, לא ממציאים נתיב.  
מחרוזת שהשתנתה: הערת `/* S006 · מקור: … */`.

**אין FTP בשורת העמוד.** team_100 פורס פעם אחת בסוף הגל.

---

## 3. עדשה א׳ — חוזה (מנוע ≠ בנאי)

מנדט ב-`_COMMUNICATION/team_90/MANDATE-R2-xxx-…`. ארבעה סעיפים חובה באמנה §8ד:

1. כל מחרוזת חדשה במקור המצוטט  
2. שינוי קוד בלי סעיף בטאב = FAIL  
3. Provenance  
4. פלט ריק = FAIL  

`-fast` אסור.

---

## 4. עדשה ב׳ — E2E דפדפן + אקסל (מנוע ≠ בנאי, מנדט חדש)

לכל נתיב של השורה:

1. דפדפן: navigate → lock → snapshot → תרחיש משתמש (קישורים ב-`<main>`, אין כרטיס ריק) → unlock  
2. `qa_probe` דסקטופ לאותו path: overflow false, forbiddenFound ריק  
3. טרקר: שורה קיימת, טאב, סוכן לא כתב אנוש, `ממתין ל` נכון  

TLS סטייג'ינג: `http://eyalamit-co-il-2026.s887.upress.link`  
`curl` לבד אינו E2E.

---

## 5. סגירת שורה

```bash
python3 scripts/tracker_page_tab.py --update R2-xxx <ITEM> --set "סטטוס סעיף=בוצע"
python3 scripts/tracker_update.py --row R2-xxx \
  --set "סטטוס מכונה=הוגש לבדיקה" --set "ראיות QA=<verdict path>"
python3 scripts/tracker_update.py --refresh-waiting
python3 scripts/tracker_guard.py --mode verify
```

`הוגש לבדיקה` רק אחרי א׳+ב׳ PASS.  
אייל חותם בטופס סבב 2 / עמודת אנוש — לא הסוכן.

---

## 6. דיווח ל-100 (סוף סוכן המשנה)

- שם העמוד + נתיב  
- PASS/FAIL א׳ ו-ב׳ + נתיבי verdict  
- סעיפים חדשים לאייל (ניסוח אנושי)  
- מה לא נגע (במיוחד 23 הליבה)
