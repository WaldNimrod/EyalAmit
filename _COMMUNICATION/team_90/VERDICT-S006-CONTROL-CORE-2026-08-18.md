VERDICT: PASS

**מאמת:** team_90 · Composer-2.5 (Cursor) · 2026-08-18  
**בנאי:** Cursor Grok 4.6 · Iron Rule #1 (validator ≠ builder; אפס שינוי קוד)  
**בסיס:** http://eyalamit-co-il-2026.s887.upress.link · דסקטופ בלבד · `curl -sk`  
**מנדט:** file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-CONTROL-CONTENT-LENS-2026-08-18.md  
**מקור אייל:** file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content%2013.8.26/  
**טרקר:** file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/latest.csv · file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/latest-items.csv  
**היקף:** R1-01 · R1-02 · R1-03 · R1-04 · R1-05 · R1-26

## סיכום מנהלים

שש עמודי הליבה חזרו HTTP 200; גוף `<main>` מול מקור אייל (3–5 ציטוטים לעמוד) מאומת. **אין פדיחת צוות חדשה** ב-`<main>`: אפס `PLACEHOLDER` / `צוות 80` / `mrng.to` / מחירים מומצאים. סעיפים מתועדים שלא נספרים כ-FAIL — Lorem בדף הבית (H-06), `<em>` ב-H1 של `/treatment/` (הגשה קודמת), H1 «מדיה ווידאו» ב-`/testimonials/` (M-03), קופסת CPAP/WP-S4-07 (T-01), «ממתין להשלמה» (M-04), היעדר דן ארליכמן (M-01a). מטא `og:description` ב-`/testimonials/` נקי (ללא כרום צוות 80).

---

## טבלת בדיקות

| שורה | בדיקה | סיווג | תוצאה | ראיה |
|------|--------|--------|--------|------|
| R1-01 | HTTP 200 | — | CONFIRMED | `curl -sk` → 200 · http://eyalamit-co-il-2026.s887.upress.link/ |
| R1-01 | H1 `<main>` מול מקור | — | CONFIRMED | `המרכז לטיפול בנשימה באמצעות דיג'רידו – שיטת cbDIDG של אייל עמית` · מקור: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content%2013.8.26/דף%20הבית/homepage1-3%20v2.md SECTION 01 |
| R1-01 | 3–5 ציטוטים מגוף המקור | — | CONFIRMED | «הדיג'רידו הוא כלי עבודה על הנשימה» · «יש דרכים שונות לעבוד עם הנשימה» · «אייל עמית · פועל מאז 1999» · «לתיאום שיחת היכרות» |
| R1-01 | `Lorem ipsum` בפרק וידאו | בייטי אייל / ממתין | לא כשל (H-06) | `<main>` מכיל Lorem + פלייסהולדר 16:9 ב-#video — מתועד בטרקר H-06 |
| R1-01 | כרום צוות ב-`<main>` | — | CONFIRMED | אפס PLACEHOLDER / צוות 80 / mrng.to |
| R1-01 | טרקר `latest.csv` | — | CONFIRMED | `סטטוס מכונה=הוגש לבדיקה` · `ממתין ל=אייל` |
| R1-02 | HTTP 200 | — | CONFIRMED | http://eyalamit-co-il-2026.s887.upress.link/treatment/ |
| R1-02 | H1 `<em>` בדיג׳רידו | הגשה שעברה — אל-נפתח | לא כשל | חי: `טיפול ב<em>דיג׳רידו</em>` · מנדט סבב בקרה: הגשת R1-02 E2E PASS — לא נפתח |
| R1-02 | 3–5 ציטוטים מגוף המקור | — | CONFIRMED | «משהו בנשימה שלך מבקש תשומת לב» · «מוקש דהימן» · «הנשימה היא לכולם» · «ריברסינג» · «לתיאום שיחת היכרות» · מקור: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content%2013.8.26/טיפול%20בדיג_רידו/treatment.md |
| R1-02 | קופסת CPAP / WP-S4-07 | בייטי אייל / ממתין | לא כשל (T-01) | `ea-pending-approval__note` — «ממתין לאישור אייל (WP-S4-07 §3.1)» · חמש שאלות CPAP/נחירות ממתינות לבחירת אייל |
| R1-02 | כרום צוות ב-`<main>` | — | CONFIRMED | אפס PLACEHOLDER / צוות 80 / mrng.to |
| R1-02 | טרקר | — | CONFIRMED | `הוגש לבדיקה` · T-01/T-02 ממתין לאייל |
| R1-03 | HTTP 200 | — | CONFIRMED | http://eyalamit-co-il-2026.s887.upress.link/method/ |
| R1-03 | H1 מול מקור | — | CONFIRMED | `שיטת cbDIDG של אייל עמית` · ללא `<em>` · מקור: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content%2013.8.26/השיטה/method.md |
| R1-03 | 3–5 ציטוטים מגוף המקור | — | CONFIRMED | «שיטת cbDIDG» · «סטודיו נשימה מעגלית» · «ריברסינג» · «לתיאום שיחת היכרות» |
| R1-03 | כרום צוות ב-`<main>` | — | CONFIRMED | אפס PLACEHOLDER / צוות 80 · MTH-01 תמונות = ממתין לאייל, לא כשל |
| R1-03 | טרקר | — | CONFIRMED | `הוגש לבדיקה` · MTH-01 ממתין לאייל |
| R1-04 | HTTP 200 | — | CONFIRMED | http://eyalamit-co-il-2026.s887.upress.link/lessons/ |
| R1-04 | H1 מול מקור | — | CONFIRMED | `שיעורי נגינה בדיג'רידו לפי שיטת cbDIDG של אייל עמית` · ללא `<em>` · מקור: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content%2013.8.26/שיעורי%20נגינה/lesons.md |
| R1-04 | 3–5 ציטוטים מגוף המקור | — | CONFIRMED | «שיעורי נגינה בדיג'רידו» · «הדיג'רידו הוא הכלי» · «מוקש» · «לתיאום שיעור ראשון» |
| R1-04 | כרום צוות ב-`<main>` | — | CONFIRMED | אפס PLACEHOLDER / צוות 80 · LSN-01/02/09 ממתין לאייל |
| R1-04 | טרקר | — | CONFIRMED | `הוגש לבדיקה` |
| R1-05 | HTTP 200 | — | CONFIRMED | http://eyalamit-co-il-2026.s887.upress.link/sound-healing/ |
| R1-05 | H1 מול מקור | — | CONFIRMED | `סאונד הילינג פרטי בדיג'רידו - מסע אישי בצליל ותדר ליחידים ולזוגות` · ללא `<em>` · מקור: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content%2013.8.26/סאונדהילינג/sound_healing_final.md |
| R1-05 | 3–5 ציטוטים מגוף המקור | — | CONFIRMED | «סאונד הילינג» · «מסע אישי ופרטי בצלילים» · «מוקש» · «לתיאום שיחת היכרות» (SECTION 01 CTA) |
| R1-05 | כרום צוות ב-`<main>` | — | CONFIRMED | אפס PLACEHOLDER / צוות 80 · SH-01/02 ממתין לאייל |
| R1-05 | טרקר | — | CONFIRMED | `הוגש לבדיקה` |
| R1-26 | HTTP 200 | — | CONFIRMED | http://eyalamit-co-il-2026.s887.upress.link/testimonials/ |
| R1-26 | H1 «מדיה <em>ווידאו</em>» | בייטי אייל / ממתין | לא כשל (M-03) | מנדט סבב בקרה: כותרת מול תוכן המלצות — ממתין לנוסח מאייל; `<em>` לא נפתח |
| R1-26 | 3–5 ציטוטי תוכן | — | CONFIRMED | סקשן «טיפול בדיג'רידו» · «שיעורי נגינה» · «סאונד הילינג» · ציטוט שירי אלקבץ «מעבר לסידור הנשימה…» · מקור: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content%2013.8.26/ריכוז%20כל%20ההמלצות%20-%20טיפול%20בדיג_רידו,%20שיעורי%20נגינה,%20סאונדהילינג,/ממליצים%20מהפייסבוק.docx |
| R1-26 | דן ארליכמן חסר | בייטי אייל / ממתין | לא כשל (M-01a) | שם לא ב-`<main>` — טקסט ממתין לאישור אייל |
| R1-26 | «ממתין להשלמה» בסקשן מדיה | בייטי אייל / ממתין | לא כשל (M-04) | placeholder מכוון עד קישורי וידאו/כתבות מאייל |
| R1-26 | מטא description / og:description | — | CONFIRMED | `סרטונים, הקלטות, וכתבות על העבודה עם הנשימה והדיג׳רידו.` — אפס PLACEHOLDER / צוות 80 |
| R1-26 | כרום צוות ב-`<main>` | — | CONFIRMED | אפס PLACEHOLDER / צוות 80 / mrng.to |
| R1-26 | טרקר | — | CONFIRMED | `הוגש לבדיקה` · M-01a/M-03/M-04/M-05 ממתין לאייל |

---

## הערות מנדט (לא כשל)

- **סבב בקרה לעומת סבב סופי:** file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/FINDINGS-S006-FINAL-SWEEP-2026-08-18.md דרש תיקון `<em>` ב-H1 — **מנדט סבב בקרה הנוכחי** קובע אל-נפתח ל-R1-02 ו-M-03 ל-R1-26; לא נפתח מחדש.
- **מטא testimonials:** כרום `PLACEHOLDER — צוות 80` שתועד ב-FINDINGS **אינו** חוזר ב-curl 18.8.26 (מחוץ ל-`<main>` בכל מקרה).
- **בעלות המשך:** סעיפי טרקר ממתין לאייל (H-01/06/07, T-01/02, MTH-01, LSN-*, SH-*, M-01a–05) — לא חוסמי PASS.
