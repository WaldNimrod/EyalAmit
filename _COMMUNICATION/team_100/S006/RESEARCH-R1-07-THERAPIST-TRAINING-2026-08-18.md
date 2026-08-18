RECOMMEND: FREEZE אין תיקיית חומר להכשרות למטפלים, אין «סקירה הכשרה», החי הוא טיוטת צוות — אין בייטים מאייל להדביק. בלי סקירה אין «אין הערה = מאושר».

**עמוד:** R1-07 `/learning/therapist-training/` · http://eyalamit-co-il-2026.s887.upress.link/learning/therapist-training/
**שערים:** 1–2 בלבד (קליטה + סיווג). לא נבנה PHP.
**ספירות:** ברור **0** · לא-ברור נימרוד **0** · לא-ברור אייל **0**
**סעיף טרקר:** TT-01 (הוקפא) — `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/r1-07-items.json`

---

## 1. חומר שנמצא — אין חבילה ייעודית

**SSOT שנסרק:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/`

| חיפוש | תוצאה |
|---|---|
| תיקייה ייעודית ל-`/learning/therapist-training/` / «הכשרות למטפלים» / therapist-training | **אין.** 20 תיקיות תוכן — אף אחת אינה חבילת הכשרה למטפלים. |
| `סקירה הכשרה.xlsx` / `סקירה הכשרות.xlsx` / `סקירה therapist` (או כל «סקירה …» מלבד דף הבית) | **אין.** קובץ הסקירה היחיד ליד החבילה: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/סקירה דף הבית.xlsx` |
| md/docx/xlsx בשם therapist / therapy-training / הכשרה / הכשרות / מטפלים | **אין** תחת החבילה. `find` על כל `EyalAmit_Site_GoogleDrive_Sync` ל-*therapist* / *הכשר* / *מטפל* — אפס קבצים. |
| `דפים שלא אונדקסו/` | 9 קבצי GSC (noindex / 404 / soft 404 וכו') מ-4.6.26. **אין** URL ל-`/learning/therapist-training/` או `/cbDidg-therapy-training`. אזכורי «סדנאות» הם בלוג/404 ישנים — שייכים ל-R1-09, לא עותק לעמוד הזה. |

**לא נפתח ולא נכתב מ:** `docs/project/eyal-ceo-submissions-and-responses/from-eyal/` (גיבוי בלבד, אמנה §2).

אב `/learning/` (R1-06) ואחים R1-08/R1-09 **מחוץ לסקואופ** — לא נערכו.

### אזכורים בעמודי אייל *אחרים* — אינם מקור לעמוד הזה

קישורים/פסקאות על «הכשרת מטפלים» מופיעים במסמכי עמוד אחר. זה מוכיח שאייל מצפה ליעד בשם הזה; זה **אינו** (א) תא/שורה מצוטטת לעותק `/learning/therapist-training/`, ואין (ב) בייטים של חבילה ייעודית להדביק כאן. מנדט R1-07: FAQ / אודות **אינם** מקור (שייכים ל-R1-25 / R1-21).

- `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/אודות - אייל עמית/אודות - אייל עמית.md` שורות 166, 221, 228 — `[הכשרת מטפלים ומנחים בשיטת cbDIDG](/learning)` + DEV NOTE «קישור לעמוד לימוד והכשרה». §10 «הדור הבא של התחום» הוא עותק **אודות**. שייך ל-R1-21, לא לכתיבת R1-07. (ה-defaults מודים ששאבו «verbatim-ish» משם — זו טיוטת צוות, לא חבילת עמוד.)
- `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/השיטה/method.md` שורות 404, 415 — `[לימוד והכשרה](/learning)`. כבר טופל ב-R1-03 (MTH-07). לא עותק הכשרות.
- FAQ (`/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/דף FAQ/FAQ FINAL.md` שורות 564, 582–589) — «האם יש קורס להכשרת מטפלים?» + קישור `/cbDidg-therapy-training`. R1-25. **לא** מקור לעמוד הזה (גם לא לפרמלינק הישן — מחוץ לשערים 1–2).

קיום תיקיית חומר בכלל, או קישור מעמוד אחר, **אינו מקור** (אמנה §3א: «קיומה של תיקיית חומר אינו מקור»).

---

## 2. חי מול defaults — אין פער תוכן; הפער הוא מול אייל

**HTTP:** `curl -sk` → **200** · `X-Robots-Tag: noindex, nofollow` (סטייג'ינג). TLS פג בכוונה.

**ערוץ החי:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/therapist-training-defaults.php`

הקובץ עצמו מצהיר: «Chapters /learning/therapist-training/ (הכשרות למטפלים) — **team draft**. Vision copy sourced verbatim-ish from about-defaults §10/§7 (real Eyal content). Program structure / dates / pricing = ea-pending-approval (genuinely missing).» — כלומר **טיוטת צוות**, לא ציטוט מחבילת עמוד מאייל.

| בלוק חי (דסקטופ) | ב-defaults | מול אייל |
|---|---|---|
| H1 «הכשרת *מטפלים ומנחים* בשיטת cbDIDG» + תת «להעביר את הידע הלאה…» + CTA `/contact/` | `phero` זהה (כולל `<em>`) | אין מקור ייעודי. `em` הומצא. כותרת/תת אינם מחבילת עמוד. |
| תמונת הירו `studio-interior.jpg` alt «פנים הסטודיו בפרדס חנה» | `phero.media` | מדיה בלי קובץ מאייל לעמוד הזה. לא נפתח סעיף לאייל — אין מסמך שמבקש תמונה כאן. |
| «הדור הבא של התחום» + 2 פסקאות + קישור `/method/` | `sections[0]` prose | אין חבילה. קרבה לאודות §10 אינה היתר להדביק כאן (R1-21). |
| «למי מתאים המסלול» | `sections[1]` | אין מקור. פסקה הומצאה. |
| «תוכנית ההכשרה» + `ea-pending-approval` (מבנה/קבלה/מועדים/עלות) | `sections[2]` | אין מקור. הזוהר «ממתין לאישור» הוא המצאת צוות, לא רצוי מאייל. |
| CTA «רוצים להיות בין הראשונים?» | `sections[3]` cta | אין מקור. כותרת הומצאה. |

**מסקנת פער:** החי = ה-defaults. אין מה «לתקן מול המסמך». אין מסמך.

**תפריט חי (אומת ב-HTML):** קישור «הכשרות למטפלים» → `/learning/therapist-training/`. תתי-אחים `/learning/lectures/` · `/learning/workshops/` מופיעים באותו נאב. זה תבנית משותפת `section-nav.php` — **מחוץ לשער 4** (אמנה §8ד / §6). לא נפתח סעיף תוכן ולא נרשם ל-CODE-BLOCKED במנדט הזה.

**מחוץ להיקף S006 סבב 1:** `og:description` = «PLACEHOLDER — v1 — צוות 80 עמוד הכשרות למטפלים יעלה בהמשך…» (Yoast/meta → S007).

---

## 3. טבלת סיווג (אמנה §3א)

`ברור` רק אם (א) מקור מצוטט **ו** (ב) בייטים מילה-במילה **ו** (ג) פעולה אחת. חסר ולו אחד → `לא ברור`. בלי קובץ סקירה, «אין הערה = מאושר» **אינו חל**.

| # | הסעיף | (א) מקור מצוטט | (ב) בייטים | (ג) פעולה אחת | סיווג | סטטוס |
|---|---|---|---|---|---|---|
| TT-01 | כל עותק העמוד (`phero` + 3 סקשנים + CTA, כולל pending-approval) | אין תא/שורה. אין «סקירה הכשרה». FAQ/אודות/שיטה אינם מקור לעותק הזה. | אין מה להדביק. אסור להמציא. | אין תיקון מותר בלי מקור | לא ברור | **הוקפא** |

אין סעיפים `ברור`. אין סעיפים שממתינים לנימרוד או לאייל עם בחירה — ההקפאה היא הדין (אמנה §2: חסר חומר → `הוקפא` עם סיבה, לא ממציאים).

לא נפתחו שאלות מדיה/FAQ/ניסוח לאייל: בלי מסמך ייעודי אין «מצוי≠רצוי» לעמוד הזה, ופנייה אליו לאשר טיוטת צוות (או להעתיק אודות §10 לכאן) תהיה הנגשת המצאה.

---

## 4. שאלות לנימרוד

**אין.** ההמלצה היא הקפאה לפי האמנה, לא הכרעת מבנה/ניסוח.

אם אחרי ההקפאה תרצה לבקש מאייל חבילת md לעמוד ההכשרות — זו הכרעה שלך, לא שער בנייה. עד אז: לא לגעת ב-`therapist-training-defaults.php`, לא לרנדר מחדש, לא להגיש לאייל.
