# מנדט צוות 10 — יישום Eyal Client Hub V2 (מסלול מלא → הגשה ל־QA)

**תאריך:** 2026-04-15  
**גרסת מנדט:** **1.1** — מיושר ל־LOD400 v1.1 (§9 כולל AC-15, §13 תהליך קצה־לקצה).  
**מוציא:** צוות 100  
**נמען:** צוות 10 (יישום)  
**סביבת עבודה:** Cursor — workspace שורש `EyalAmit.co.il-2026`

---

## 1. מטרה

לממש את [`EYAL-CLIENT-HUB-V2-LOD400-2026-04-15.md`](./EYAL-CLIENT-HUB-V2-LOD400-2026-04-15.md) **בגרסה 1.1** בקוד: תבניות Hub, `hub/data` (קבצים חדשים וממולאים), הרחבות ל־[`scripts/build_eyal_client_hub.py`](../../scripts/build_eyal_client_hub.py), נכסי `hub/src/assets/`, סקריפטי עזר, פריסה FTP, ואז **חבילת מסירה מסודרת** שמאפשרת לצוות 50 להתחיל QA מיד.

**אין** לשנות את גוף [`docs/CLIENT_HUB_STANDARD_v1.md`](../../docs/CLIENT_HUB_STANDARD_v1.md) (נעול).

**תלות אפיונית:** L-GATE_SPEC הוזן (PASS WITH FINDINGS); דיוקי AC ב־LOD400 v1.1 סוגרים את F-01–F-06 ברמת המפרט — אין צורך לקרוא מחדש את דוח 190 לביצוע שגרתי, אלא אם יש סתירה בין מימוש לבין §9.

---

## 2. היקף לפי סעיפי LOD400 (צ'ק־ליסט ארכיטקטוני)

| אזור LOD400 | מה נכלל במימוש |
|-------------|----------------|
| §0–§1 | גבולות שכבות, שפה גלויה, ללא AOS ב־UI |
| §2 IA | כל דפי §2 בבילד, כולל `meeting.html` חדש ו־`pending.html` מפנה |
| §3 אקורדיון | טבלת סקשנים לכל דף — כיסוי מלא ב־AC-02 |
| §4 דף בית | שער, סטטיסטיקה, דליברבלס, **קישורים/מוקאפים/עץ** לפי §3 + AC-04 |
| §5 נתונים | `links.json`, `questions-prompts.json`, `meeting-brief.json`, הרחבות `roadmap.json`, ייצואים (§5.4–§5.5) |
| §6 נגישות | מקלדת, תוויות, ללא מלכודת מיקוד |
| §7–§8 | סקריפטים ירוקים, בנייה, `--mirror-docs` כשמוסיפים ל־`files/`, FTP + מטמון לפי נספח |
| §9 AC | כל השורות AC-01 … AC-15 — ראיה במסירה או פער מוסכם (רק עם צוות 100) |

---

## 3. רצף ביצוע מומלץ (מסודר)

1. **אונבורד + קריאת LOD400** — סעיפים 0–13 במלואם.
2. **נתונים (`hub/data`)** — יצירה/מילוי של JSON חדשים והרחבות; הרצת `hub_validate_hub_data.py`.
3. **בילד (`build_eyal_client_hub.py`)** — כולל `--mirror-docs` אם נוספו קבצים תחת `hub/files/` או מסלולים מסונכרנים.
4. **בדיקות מקומיות** — `hub_check_dist_links.py` על `hub/dist/`.
5. **רגרסיה F-08–F-10 (AC-15)** — השוואה למצב baseline ב־`hub/dist` (robots/meta, פוטר, `metadata.json` אם קיים).
6. **פריסה** — `ftp_publish_eyal_client_hub.py` (או dry-run אם אין גישה); אחרי פריסה: **purge** EzCache/Varnish לפי [`CLIENT_HUB_APPENDIX_EYAL.md`](../../docs/CLIENT_HUB_APPENDIX_EYAL.md).
7. **בדיקה עצמית בדפדפן** — לפחות דגימה: כל דף §2, ייצוא אחד מכל סוג חדש, אקורדיון ב־tasks (ארבעה סקשנים כולל Drive).
8. **מסירה** — קובץ אחד תחת `_COMMUNICATION/team_10/` (פירוט בסעיף 5).

---

## 4. קריאה חובה לפני התחלה (סדר מומלץ)

1. [`_communication/team_10/onboard_team10.md`](../team_10/onboard_team10.md)
2. [`EYAL-CLIENT-HUB-V2-LOD400-2026-04-15.md`](./EYAL-CLIENT-HUB-V2-LOD400-2026-04-15.md) — **§9 + §13**
3. [`docs/CLIENT_HUB_STANDARD_v1.md`](../../docs/CLIENT_HUB_STANDARD_v1.md) — F-01–F-14 (בהדגשת F-06, F-08–F-10)
4. [`docs/CLIENT_HUB_APPENDIX_EYAL.md`](../../docs/CLIENT_HUB_APPENDIX_EYAL.md)
5. [`hub/EYAL-HUB-SSOT-WORKFLOW.md`](../../hub/EYAL-HUB-SSOT-WORKFLOW.md)
6. [`hub/HUB-CANONICAL-UPDATE-PLAYBOOK.md`](../../hub/HUB-CANONICAL-UPDATE-PLAYBOOK.md)
7. מנדט QA (לדעת מה ייבדק אחריכם): [`MANDATE-TEAM50-EYAL-HUB-V2-QA-2026-04-15.md`](./MANDATE-TEAM50-EYAL-HUB-V2-QA-2026-04-15.md)

---

## 5. חבילת מסירה (חובה) — הגשה לצוות 50 / QA

קובץ יחיד, שם מומלץ:

`_COMMUNICATION/team_10/EYAL-HUB-V2-DELIVERY-TEAM10-<תאריך-ביצוע>.md`

**חובה בתוך הקובץ:**

| סעיף | תוכן |
|------|------|
| **סיכום** | משפט אחד — מה נמסר ב־V2 |
| **שורש URL מלא** | בסיס Hub בשרת (דוגמה: `http://…/ea-eyal-hub/` או לפי נספח) — **http לסטייג'ינג / https לפרודקשן** כפי שבפועל |
| **האם בוצע purge** | כן/לא + איך (לצוות 50) |
| **רשימת דפים לבדיקה** | מלאה לפי §2 — עם URL מלא לכל דף (בסיס + נתיב) |
| **טבלת דלתא AC-11** | עמודות: מקור קאנון (`PROJECT-ENTRY` / `SSOT` / קטע מקביל) · מה עודכן ב־`hub/data` · הערה |
| **מיפוי AC → ראיה** | לכל AC-01…AC-15: איפה הראיה (קובץ, צילום, לוג) או **פער** + אישור צוות 100 אם רלוונטי |
| **רשימת קבצים שנגעת** | נתיבים יחסיים מהשורש מאגר |
| **פקודות שהורצו** | validate, build, linkcheck, ftp (או dry-run) |

ללא **שורש URL** וללא טבלת דלתא — צוות 50 לא יכול למלא את מנדטו.

---

## 6. Definition of Done — טכני

- [ ] `python3 scripts/hub_validate_hub_data.py` — קוד יציאה 0  
- [ ] `python3 scripts/build_eyal_client_hub.py` (עם `--mirror-docs` אם נדרש) — קוד יציאה 0  
- [ ] `python3 scripts/hub_check_dist_links.py` — קוד יציאה 0 על `hub/dist`  
- [ ] `python3 scripts/ftp_publish_eyal_client_hub.py --dry-run` מצליח **או** תיעוד מפורט מדוע לא ניתן + אישור שפריסה בוצעה בדרך אחרת  
- [ ] קובץ מסירה כבסעיף 5  
- [ ] פריסה בפועל לכתובת ציבורית + purge כנדרש  

---

## 7. גבולות והסלמה

- לא לשנות מדיניות QR/permalink ב־WordPress מתוך מנדט זה.
- לא לשלוח לאייל קבצי `.md` — רק תהליך docx/PDF הקבוע לדליברבלס פורמליים.
- **חסימה / החלטת מוצר:** כל פער שדורש שינוי LOD400 או SSOT — עצירה והפניה לצוות 100 (לא «יושבים על זה» בשקט).

---

## 8. פרומט אקטיבציה (זהות + קונטקסט מלא)

**מסמך מרכזי (העתקה לסשן Cursor חדש):**  
[`EYAL-HUB-V2-ACTIVATION-PROMPTS-ALL-TEAMS-2026-04-15.md`](./EYAL-HUB-V2-ACTIVATION-PROMPTS-ALL-TEAMS-2026-04-15.md) — **סעיף «צוות 10 — יישום (Cursor)»**.

יש לעדכן את הפרומט כך שייחשב **LOD400 גרסה 1.1** ו־**AC-15**; או להפנות ישירות למנדט זה כמקור ה־Done.

---

**חתימת צוות 100:** מנדט פתוח לביצוע; **הגשה ל־QA** = סעיפים 5–6 הושלמו + URL חי.
