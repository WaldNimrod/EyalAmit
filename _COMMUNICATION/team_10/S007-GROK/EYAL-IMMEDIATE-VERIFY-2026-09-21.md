# אימות מיידי מאייל — 2026-09-21

**סטטוס: PASS** (עם הערה אחת על טופס התודה). מנוע מאמת ≠ צוות 10 Composer ([as-made](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/EYAL-IMMEDIATE-ASMADE-2026-09-21.md)).

צ'קפוינט: [CHECKPOINT-EYAL-IMMEDIATE-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/CHECKPOINT-EYAL-IMMEDIATE-2026-09-21.md)  
ראיות: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/eyal-immediate-verify/get-verify.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/eyal-immediate-verify/get-verify.json) · [cdp-verify.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/eyal-immediate-verify/cdp-verify.json)

תמה חיה **1.5.100**. HEAD עבודה מלוכלכת (לא commit). ניווט קנוני לא ב-diff.

## שער כניסה

- [x] ATTACK נחת
- [x] בסיס GET+CDP ב־`tmp/qa/eyal-immediate-baseline/`
- [x] as-made של צוות 10
- [x] `ver=1.5.100` בסטייג'ינג (לא 1.5.99)
- [x] בונה ≠ מאמת

## רגרסיות חובה

| בדיקה | תוצאה |
|--------|--------|
| 10 כפתורי L1 כמו בבסיס (טיפול, שיטה, שיעורים, סאונד, לימוד▾, כלים, ספרים, בלוג, אייל▾, צור קשר) | **PASS** CDP |
| `/didgeridoos/` בלי «מה אומרים אנשים…» ובלי CTA לכל העדויות | **PASS** GET+CDP |
| `/` iframe `wDQoJauqsRM`, בלי Lorem / פלייסהולדר | **PASS** GET+CDP |
| `/faq/` `/learning/therapist-training/` ; אין `/cbDidg-therapy-training` | **PASS** |
| `/thank-you/` שתי שורות אייל | **PASS** |
| משפטי בלי «ממתין לאישור»; `/en/` עדיין Draft | **PASS** |
| P016 ו־P045 GET בלי follow = 301 אל `/blog/` | **PASS** |
| `אסטמה` לא בבית/שיטה החיים; `אסתמה` כן | **PASS** |
| 15 המלצות בדף הבית נשארו (D2) | **PASS** |
| `/books/kushi-blantis/` 200; P048 מקשר אליו | **PASS** |
| C2 `/learning/therapist-training/` 200 | **PASS** |

## מול JSON אייל (מיידי בלבד)

| id | בחירה | אימות עצמאי | verdict |
|----|--------|-------------|---------|
| A4 | להשתמש ואשלח נוסח | שתי השורות חיות. הפניית CF7 רק ב־JS (`wpcf7mailsent`) — לא נשלח טופס אמיתי במנוע הזה | **PASS** עמוד · **PARTIAL** טופס |
| B1 | אשלח קישור | iframe `youtube.com/embed/wDQoJauqsRM` | **PASS** |
| C2 | מאשר כמו שהוא | עמוד 200; נוסח לא נדרש להשתנות | **PASS** |
| D1 | להסיר את הסקשן | אין כותרת/CTA המלצות בכלים | **PASS** |
| D2 | להשאיר 15 | סקשן עדויות בבית קיים | **PASS** |
| D3 | אשלח כתובת | FAQ → `/learning/therapist-training/` | **PASS** |
| F3 | אסתמה | בית+שיטה | **PASS** |
| L1 | אושר | אין באנר טיוטה | **PASS** |
| L2 | אושר ולהשאיר מדידה | אין טיוטה; מדידה בטקסט/CMP | **PASS** |
| L3 | אושר | אין באנר טיוטה | **PASS** |
| P016 | מחיקה | 301 `/blog/` | **PASS** |
| P045 | תסיר את הפוסט | 301 `/blog/` | **PASS** |
| P008 | הערה | ≥8 `/uploads/2025/02/` | **PASS** |
| P048 | הערה | קישור ASCII לכושי | **PASS** |
| T1/T2/T3 | תפריט | לא נגענו | **PASS** (חרגה) |

אין rollback. כשל יחיד לא נמצא בקבלה.

## הערות

- הפניית טופס צור-קשר ל־`/thank-you/` לא עברה שליחה חיה במנוע הזה.
- WhatsApp float / EN lang / st3 a11y מביקורת העומק — מחוץ לחבילה.
- «עכשיו באתר» ואופציות IA — סקיצה בגלריה בלבד.

צילומים: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/eyal-immediate-verify/shots/](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/eyal-immediate-verify/shots/)
