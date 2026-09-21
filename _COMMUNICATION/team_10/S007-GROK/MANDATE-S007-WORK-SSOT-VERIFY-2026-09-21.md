# מנדט צוות 10 — אישור תור העבודה S007 · 2026-09-21

**מזמין:** מנהל מבצע / צוות 100 (ops).  
**מבצע:** צוות 10 — **מנוע אחר** מהבונה של ה-JSON (Iron Rule #1).  
**לא מממשים.** אין קוד אתר, אין bump תמה, אין FTP לאתר, אין `tracker_update.py`.

אונבורד: קרא במלואו `_communication/team_10/onboard_team10.md` ואמור «אונבורד צוות 10 הושלם.»

סטייג'ינג: http://eyalamit-co-il-2026.s887.upress.link (HTTP; TLS לא תקין בכוונה). תמה חיה **1.5.100**. GET בלי follow-redirect. UA דפדפן — בלי זה WAF 403.

---

## מה מאשררים

1. **JSON הוא התור**  
   [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json)  
   `schema` = `s007-work-ssot-v1`, `isWorkSsot` = true.  
   אוצר מילים סגור: `status` closed|open|waiting · `waitingOn` none|eyal|nimrod|team10 · `surface` eyal_form|nimrod_board|both|internal · `kind` content_gap|visual|a11y|nav|ops.  
   `closed` בלי `live.check` = פגם.

2. **מול אייל C** (לא לשכתב choice/note)  
   [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-21--content-gaps--from-eyal/SOURCE-C-2026-09-21T1001Z--from-eyal.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-21--content-gaps--from-eyal/SOURCE-C-2026-09-21T1001Z--from-eyal.json)  
   sha12 **`19d11db562f7`**. 129 מזהים. שבעה בלי רדיו עם הערה נשארים כך.

3. **מול as-made + VERIFY של חבילת מיידי**  
   [ASMADE](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/EYAL-IMMEDIATE-ASMADE-2026-09-21.md) · [VERIFY](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/EYAL-IMMEDIATE-VERIFY-2026-09-21.md)  
   סעיפי `closed` חייבים לעמוד באתר. EI-A4-E2E נשאר `open` (שליחת טופס לא נבדקה) — אל תסגרו אותו.

4. **מול ATTACK**  
   [DEEP-AUDIT-ATTACK-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/DEEP-AUDIT-ATTACK-2026-09-21.md)  
   שיירי MISS (DA-WA-01, DA-NAV-01/02/03, DA-LOGO-01, DA-P2-A2/A3/A4, DA-P2-05, DA-P2-06) חייבים להופיע בתור כ-`open`/`waiting`, לא להיעלם. DA-P1-01 Lorem = `closed` אחרי B1.

5. **שתי ה-HTML הן הטלה**  
   - לוח נימרוד: [GALLERY.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html) — כותרת «לוח עבודה»  
   - טופס אייל (מקור + Hub): [FORM-EYAL-CONTENT-GAPS-2026-09-20.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html) · http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html  

   הצלחה:
   - `ssotSha12` בשני הקבצים **זהה** ל-sha256-12 של ה-JSON על הדיסק.
   - אין תווית סטטוס ב-HTML שאין לה מקור בפריט JSON (`stampHe` / `status`+`waitingOn`).
   - אין אובייקט `SITE_STATUS` / מפה ידנית ב-JS.
   - 129 `data-id` בטופס = כל פריטי `surface` eyal_form|both.

6. **מה שכבר לא SSOT**
   - אקסל: ארכיון 2026-09-20. [ARCHIVE-STAMP](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/ARCHIVE-STAMP-2026-09-20.md)
   - HANDOFF: שיחה. [HANDOFF-TO-TEAM100-2026-09-22.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/HANDOFF-TO-TEAM100-2026-09-22.md)
   - `WORKING-UNION-FROM-C.json`: stub עם `relocatedTo`.

---

## מדידה חיה (חובה על כל closed)

GET בלי `-L`. דוגמאות שכבר נמדדו אצל הבונה (לא לקבל כתורה — למדוד מחדש):

- P016 / P045 → HTTP **301** אל `/blog/`
- A4 `/thank-you/` שתי שורות אייל
- B1 iframe `youtube.com/embed/wDQoJauqsRM`, בלי Lorem
- D3 FAQ href `/learning/therapist-training/`
- L1–L3 בלי באנר טיוטה

אם האתר לא מאשר — **לא** משאירים `closed`. דוח: FAIL עם URL+קוד. אל תתקנו את ה-JSON במנדט הזה; תחזירו ממצא.

חרגת תפריט: `T-NAV-HOLD` חייב `waiting` / `nimrod`.

---

## פלט

קובץ יחיד: `_COMMUNICATION/team_10/S007-GROK/VERIFY-S007-WORK-SSOT-2026-09-21.md`

טבלה: id · מה בדקנו · PASS/FAIL · ראיה (קוד HTTP / sha / ציטוט).  
שורה סיכום: `ssotSha12` זהה בשלושת המשטחים כן/לא.

אין מנדט מימוש באתר בסיום.
