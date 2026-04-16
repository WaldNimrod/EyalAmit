# דוח QA — Eyal Client Hub V2 — צוות 50

**תאריך ביצוע:** 2026-04-16  
**מנדט:** [`../team_100/MANDATE-TEAM50-EYAL-HUB-V2-QA-2026-04-15.md`](../team_100/MANDATE-TEAM50-EYAL-HUB-V2-QA-2026-04-15.md)  
**אפיון:** [`../team_100/EYAL-CLIENT-HUB-V2-LOD400-2026-04-15.md`](../team_100/EYAL-CLIENT-HUB-V2-LOD400-2026-04-15.md) v1.1 (§2, §9, §13)  
**מסירת צוות 10:** [`../team_10/EYAL-HUB-V2-DELIVERY-TEAM10-2026-04-16.md`](../team_10/EYAL-HUB-V2-DELIVERY-TEAM10-2026-04-16.md)

**אישור אונבורד:** אונבורד צוות 50 הושלם (קריאת [`onboard_team50.md`](./onboard_team50.md)).

---

## הצהרת היקף — אימות שרת

| שאלה | ערך |
|------|-----|
| **האם נכלל אימות שרת מלא (HTTP לכל דפי הליבה, קישורים פנימיים, `files/` / `mockups/` לפי AC-12)?** | **חלקי** — `curl -sI` לנתיבי ליבה בבסיס ציבורי (ראו למטה); לא בוצעה סריקה מלאה של `files/` / `mockups/` ב־HTTP. |
| **URL כניסה Hub חי (staging)** | **`http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/index.html`** — בסיס תיקייה: `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/`; מקור מאגר ל־`site-tree.json`: [`SITE-TREE-DIRECT-LINK.txt`](../../docs/project/eyal-ceo-submissions-and-responses/to-eyal/2026-04-06--content-submission-canonical-for-eyal/SITE-TREE-DIRECT-LINK.txt). |
| **בסיס אימות בפועל (מקומי)** | `hub/dist/` לאחר `python3 scripts/build_eyal_client_hub.py --mirror-docs` (מאגר `EyalAmit.co.il-2026`, בנייה 2026-04-16). |
| **ממצא HTTP על staging (דגימה)** | `index.html`, `tasks.html`, `roadmap.html`, `site-tree.html`, `content-intake.html`, `pending.html`, `robots.txt`, `metadata.json` → **200**. **`meeting.html` → 404** (קיים בעץ `hub/dist` המקומי — פריסה בשרת לא מעודכנת / חסר קובץ). |

**מטמון / purge:** לפי כותרות בדגימה: `Last-Modified` על `index.html` (11 באפריל 2026) — ייתכן פער מול בנייה אחרונה; לאחר תיקון פריסה — ניקוי EzCache/Varnish ואימות עם `?nocache=` לפי [`docs/CLIENT_HUB_APPENDIX_EYAL.md`](../../docs/CLIENT_HUB_APPENDIX_EYAL.md).

---

## תוכנית בדיקה (תמצית)

1. **בנייה:** `hub_validate_hub_data.py` → `build_eyal_client_hub.py --mirror-docs` → `hub_check_dist_links.py`.
2. **דפי ליבה §2:** טעינת HTML מ־`hub/dist`, ספירת `details.hub-acc`, ניווט כולל `meeting.html`, בדיקת `pending.html`.
3. **ייצואי JSON:** קריאת `hub-form-exports.js`, `feedback.js`, `site-tree-export.js`, `content-intake.js` + התאמה ל־LOD §5 / נספח.
4. **AC-03:** סריקת מחרוזות רגישות ב־`hub/dist/*.html` (AOS / `_aos` / lean-kit וכו׳).
5. **AC-14:** בדיקת קיום `:focus` / `:focus-visible` על `.hub-acc__summary` ב־`hub.css` + מבנה `<label>` בטפסים; **תוספת:** אימות MCP `cursor-ide-browser` (לחיצות / פוקוס על כפתורים אינטראקטיביים).
6. **AC-15:** קריאת `meta robots`, `robots.txt`, פוטר, `metadata.json` ב־`hub/dist`.
7. **קישורים פנימיים:** מסתמך על `hub_check_dist_links.py` (מלא post-build). חיצוניים: דגימה מנומקת — `curl -I` ל־`https://www.eyalamit.co.il/` (200).
8. **תוספת MCP (2026-04-16):** שרת מקומי `python3 -m http.server 8765 --bind 127.0.0.1` מתוך `hub/dist`; כתובות בדיקה `http://127.0.0.1:8765/…`.

---

## טבלת AC — AC-01 עד AC-15

| AC | תוצאה | ראיה / פקודה / נימוק |
|----|--------|------------------------|
| **AC-01** | **PASS** | קבצי ליבה קיימים ב־`hub/dist/`: `index.html`, `tasks.html`, `roadmap.html`, `site-tree.html`, `content-intake.html`, `meeting.html`, `pending.html`. רשימה: `ls hub/dist/*.html`. |
| **AC-02** | **PASS WITH NOTES** | כל דפי הליבה כוללים `<details class="hub-acc">` לסקשנים העיקריים; ניווט כולל `meeting.html` בכל דפי הליבה שנבדקו (grep `meeting.html`). **הערה:** ב־`site-tree.html` קיימות פסקאות מבוא (תפריט 11+לוגו, הסבר `EA-XX`) **מחוץ** ל־`hub-acc`, לפני בלוקי האקורדיון — מול ניסוח LOD §3 «כל תוכן עמוד…». **הפניה לצוות 100:** לאשר אם מבוא זה נחשב «כותרת/תקציר» מותר או שיש לעטוף גם אותו. nested `<details>` בתוך עץ מפורט — תקין. |
| **AC-03** | **PASS** | לא נמצאו בקובצי HTML גלויים: `_aos/`, `lean-kit`, `L-GATE`, `agents_os` (חיפוש רגיש). **הערה לא מחייבת FAIL:** מופיעות מחרוזות נתיב מאגר `_communication/...` בטקסט גלוי (למשל `roadmap.html` — יומן עדכונים; הערות דליברבלס ב־`index.html`) — אינן מונחי «AOS» ליטרליים אך חושפות מבנה מאגר פנימי; להחלטת 100 אם לנקות לשפת לקוח. |
| **AC-04** | **PASS** | `index.html`: סקשני שער (`idx-gate`), סטטיסטיקה (`idx-stats`), דליברבלס עם רמזור (`idx-deliverables`), קישורים מהירים מ־`links.json` (`idx-links`), מוקאפים (`idx-mockups`), תקציר עץ (`idx-sitetree`). |
| **AC-05** | **PASS** | `data/links.json` נטען לקבוצות תחת «קישורים מהירים» — DOM: `hub-links-cat`, כותרות `ממשק Hub` / `מסמכים ועזר` / `אתר חי`. |
| **AC-06** | **PASS** | `tasks.html`: ארבעה סקשנים `hub-acc`: `tasks-sec-tasks`, `tasks-sec-decisions`, `tasks-sec-questions`, `tasks-sec-drive`. |
| **AC-07** | **PASS** | קוד: כנ״ל. **MCP דפדפן:** `browser_navigate` → `http://127.0.0.1:8765/tasks.html` (אחרי `http.server` על `hub/dist`); מילוי שדות נושא + תיאור שאלה; `browser_resize` 1280×1600; לחיצה על «ייצוא שאלות (JSON)» — הכפתור נקלט (`focused`); הורדת Blob בצד הדפדפן (תוכן הקובץ לא נבדק בנתיב דיסק בסשן). |
| **AC-08** | **PASS** (מקומי) | `eyal-drive-intake`: שדות `driveFileName`, `contextHe`, `dateOptional` ב־`hub-form-exports.js`; כפתור `#btn-export-drive-intake`. |
| **AC-09** | **PASS** (מקומי) | `meeting.html` קיים; `eyal-meeting-snapshot` עם `snapshotBodyHe`, `sourceFields` — `initMeetingSnapshot` באותו קובץ JS. |
| **AC-10** | **PASS** (מקומי) | `eyal-feedback`: `HubFeedback.init({ exportType: "eyal-feedback" })` ב־`tasks.html` + [`feedback.js`](../../hub/src/assets/feedback.js). `eyal-site-tree-feedback`: [`site-tree-export.js`](../../hub/src/assets/site-tree-export.js). `eyal-page-content-intake`: [`content-intake.js`](../../hub/src/assets/content-intake.js) + `tasks.html` / `content-intake.html`. לא זוהה שבירת מבנה קריטי במסגרת סקירה סטטית. |
| **AC-11** | **PASS** | התאמה לטבלת הדלתא במסירת צוות 10 (קישורים, roadmap, questions, meeting-brief, deliverables) — בדיקה מסמכית מול [`EYAL-HUB-V2-DELIVERY-TEAM10-2026-04-16.md`](../team_10/EYAL-HUB-V2-DELIVERY-TEAM10-2026-04-16.md) §טבלת AC-11. |
| **AC-12** | **FAIL WITH NOTES** | **אימות שרת (staging):** `curl -sI` מול `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/` — רוב דפי הליבה **200**; **`meeting.html` → 404** בשרת (קיים ב־`hub/dist` מקומית — פריסה חסרה/לא מעודכנת). מקומית: `hub_check_dist_links.py` עבר (0 שגיאות). **המשך:** FTP להעלאת `meeting.html` + purge לפי נספח; ריטסט HTTP 200 לכל דפי §2. |
| **AC-13** | **PASS** | פקודות (אחרי בנייה): `python3 scripts/hub_validate_hub_data.py` → exit 0, `[hub_validate_hub_data] OK — 14 data files`; `python3 scripts/hub_check_dist_links.py` → exit 0, `OK`. |
| **AC-14** | **PASS** | CSS + תוויות כנ״ל. **MCP:** כפתור סקשן «שאלות» קיבל מצב `focused` אחרי לחיצה; כפתור «ייצוא שאלות (JSON)» — לחיצה מוצלחת אחרי הרחבת viewport. **מגבלה:** לא בוצע סריקת Tab מלאה לכל סדר המיקוד בדף — רק אימות אינטראקציה על רכיבי ייצוא/אקורדיון. |
| **AC-15** | **PASS** | **F-08:** `<meta name="robots" content="noindex, nofollow">` בדגימת דפים (`index.html`, `meeting.html`). `robots.txt`: `Disallow: /`. **F-09:** `<div class="hub-brand">` עם קישור WhatsApp `https://wa.me/972547776770` וטקסט «Agents OS @ nimrod.bio». **F-10:** `metadata.json` קיים עם `generatedAt`, `schemaVersion`, `project` (+ `hubVersion`, `mirrorDocs`). |

---

## מטריצת דפי ליבה (LOD §2) × סטטוס

| דף | טעינה / קובץ | אקורדיון (`hub-acc`) | ניווט + `meeting.html` | ייצואי JSON רלוונטיים | סטטוס |
|----|----------------|-------------------------|--------------------------|-------------------------|--------|
| `index.html` | קיים ב־`dist` | 6 סקשנים + מבנה §3 | כולל קישור ל־`meeting.html` | — | **PASS** |
| `tasks.html` | קיים | 4 סקשנים (משימות, החלטות, שאלות, Drive) | כולל | `eyal-feedback`, `eyal-questions`, `eyal-drive-intake` | **PASS** |
| `roadmap.html` | קיים | 2 סקשנים (מפת דרכים, לוג עדכונים) | כולל | — | **PASS** |
| `site-tree.html` | קיים | 4× `hub-acc` + עץ מקונן ב־`<details>` | כולל | `eyal-site-tree-feedback` (סקריפט) | **PASS WITH NOTES** (מבוא מחוץ ל־`hub-acc` — ראו AC-02) |
| `content-intake.html` | קיים | סקשן `hub-acc` אחד לטופס המלא | כולל | `eyal-page-content-intake` | **PASS** |
| `meeting.html` | קיים | 2 סקשנים (תדריך, סנאפשוט) | כולל | `eyal-meeting-snapshot` | **PASS** |
| `pending.html` | קיים | N/A (הפניה) | — | — | **PASS** — `<meta http-equiv="refresh" content="0; url=tasks.html">` + קישור ידני |

### תוספת — אימות MCP דפדפן (סשן 2026-04-16)

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| `index.html` נטען בדפדפן | OK | URL: `http://127.0.0.1:8765/index.html` — כותרת «אייל עמית — ממשק מצב עבודה»; קישורי ניווט כולל «תדריך פגישה»; כפתורי אקורדיון מופיעים ב־snapshot. |
| `tasks.html` + ייצוא שאלות | OK | מילוי טופס + לחיצה על ייצוא; כפתור בפוקוס לאחר פעולה. |
| `meeting.html` | OK | דף נטען; כפתורי תדריך / סנאפשוט ב־snapshot. |
| `pending.html` → `tasks.html` | OK | ניווט ל־`pending.html` מחזיר URL סופי `…/tasks.html` (ריענון מטא). |

**הערת סביבה:** לפני הסשן הוסף symlink `cursor-ide-browser` לפרויקט Cursor של `EyalAmit.co.il-2026` (ראו [`docs/sop/CURSOR-MCP-BROWSER-WORKSPACE.md`](../../docs/sop/CURSOR-MCP-BROWSER-WORKSPACE.md)); זה מתעד את סיבת ה«היעדר» הקודם של כלי הדפדפן כשהworkspace שונה.

---

## קישורים

| סוג | כיסוי | הערה |
|-----|--------|------|
| פנימיים (יחסיים) | מלא דרך `hub_check_dist_links.py` אחרי `--mirror-docs` | יש לחזור על בשרת אחרי FTP (AC-12). |
| חיצוניים | דגימה | `curl -sI` ל־`https://www.eyalamit.co.il/` → **200**. יתר הקישורים החיצוניים (Drive, ספקים) — לא נבדקו אחד־אחד; סיכון נמוך יחסית; מומלץ דגימה אחרי פריסה. |

---

## תוצאה כללית

**FAIL WITH NOTES**

**נימוק:** **AC-12** על staging — **FAIL** — `meeting.html` מחזיר **404** ב־`http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/` בעוד הקובץ קיים בבנייה מקומית; שאר דגימת הליבה **200** (ראו הצהרת היקף). יתר ה־AC שנבדקו — PASS / PASS WITH NOTES כמפורט בטבלה. **AC-02 / `site-tree.html`** — הערת התאמה (מבוא מחוץ לאקורדיון). **AC-07 / AC-14** — MCP מקומי. אם צוות 100 מחמיר לגבי AC-02 — לעדכן או לדרוש תיקון מצוות 10.

---

## הפניות (ללא תיקון קוד)

1. **צוות 100:** פרשנות LOD §3 לגבי מבוא ב־`site-tree.html` (לפני האקורדיונים).
2. **צוות 100 / 10:** הצגת נתיבי `_communication/...` בטקסט גלוי — האם עומדים לרוח AC-03 / שפת לקוח.
3. **צוות 10:** העלאת `meeting.html` (ו־sync מלא מול `hub/dist`), purge מטמון — ריטסט AC-12 מול `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/` (כניסה: `…/index.html`).
4. **סביבת Cursor:** אם `cursor-ide-browser` לא מופיע בסשן — [`docs/sop/CURSOR-MCP-BROWSER-WORKSPACE.md`](../../docs/sop/CURSOR-MCP-BROWSER-WORKSPACE.md) + סקריפט ה־symlink.

---

**סוף דוח QA — צוות 50**
