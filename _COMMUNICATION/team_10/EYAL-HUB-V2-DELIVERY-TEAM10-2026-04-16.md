# מסירת צוות 10 — Eyal Client Hub V2 (LOD400 v1.1)

**תאריך ביצוע:** 2026-04-16  
**מאגר:** `EyalAmit.co.il-2026` (שורש)

---

## סיכום

נמסר Hub סטטי V2 לפי LOD400 v1.1: אקורדיון אחיד בדפי §2, נתוני `links.json` / `questions-prompts.json` / `meeting-brief.json`, הרחבות `roadmap.json` ורמזור `documentStatus` בדליברבלס, דף `meeting.html` + ייצואי `eyal-questions`, `eyal-drive-intake`, `eyal-meeting-snapshot`, ונכס `hub-form-exports.js`.

---

## שורש URL מלא (חובה ל־QA)

**לא בוצעה פריסה אמיתית מסשן זה.** להשלמת מנדט Done — להחליף בכתובת החיה בפועל:

- **סטייג'ינג (HTTP):** `http://<staging-host>/ea-eyal-hub/` — ראו [`docs/CLIENT_HUB_APPENDIX_EYAL.md`](../../docs/CLIENT_HUB_APPENDIX_EYAL.md) (ברירת נתיב `ea-eyal-hub`).
- **דוגמה לדף בית:** `http://<staging-host>/ea-eyal-hub/index.html`

---

## האם בוצע purge

**לא** (בנייה מקומית + dry-run FTP בלבד). לאחר פריסה בפועל — ניקוי מטמון EzCache/Varnish לפי הנספח (REST `ezcache/v1` או פאנל uPress).

---

## רשימת דפים לבדיקה (URL = `{BASE}` + נתיב)

החליפו `{BASE}` ב־`http://<staging-host>/ea-eyal-hub` (או כפי בפרודקשן).

| דף | URL מלא |
|----|---------|
| כניסה | `{BASE}/index.html` |
| מפת דרכים | `{BASE}/roadmap.html` |
| משימות והחלטות | `{BASE}/tasks.html` |
| תדריך פגישה | `{BASE}/meeting.html` |
| עץ אתר | `{BASE}/site-tree.html` |
| קליטת תוכן | `{BASE}/content-intake.html` |
| pending (הפניה) | `{BASE}/pending.html` → `tasks.html` |

דפים נוספים בבילד (לא ב§2 LOD אך קיימים): `meeting-checklist.html`, `purchase-links.html`, `content-index.html` (אם נבנה).

---

## טבלת דלתא AC-11 (סנכרון hub/data ↔ קאנון)

| מקור קאנון | מה עודכן ב־`hub/data` | הערה |
|-------------|-------------------------|------|
| `PROJECT-ENTRY.md` §4 — ממשק Hub | `links.json`, הרחבת `roadmap.json` (`currentGateLabelHe`, `milestoneProgress`) | יישור תצוגת שער/סטטיסטיקה ל־LOD §4 |
| `SSOT` / רודמאפ (מצב פרויקט) | `roadmap.json` — שדות שער ומיקוד M4 | טקסט שער מסונכן עם `summaryHe` קיים |
| LOD400 §5 | `questions-prompts.json`, `meeting-brief.json` | סכימות ייצוא |
| F-14 / דליברבלס | `deliverables.json` — `documentStatus` בדוגמאות | רמזור טיוטה/סופי/הוחלף |

---

## מיפוי AC → ראיה

| AC | ראיה |
|----|------|
| AC-01 | `hub/dist/*.html` כולל `meeting.html`; לוג בנייה |
| AC-02 | דפי HTML עם `<details class="hub-acc">`; ניווט כולל `meeting.html` |
| AC-03 | סריקה ידנית — אין AOS בטקסט גלוי |
| AC-04 | `index.html` — סקשני שער, סטטיסטיקה, דליברבלס+רמזור, קישורים, מוקאפים, תקציר עץ |
| AC-05 | `links.json` → קבוצות ב־`index.html` |
| AC-06 | `tasks.html` — ארבעה סקשנים: משימות, החלטות, שאלות, Drive |
| AC-07 | כפתור ייצוא `eyal-questions` + `hub-form-exports.js` |
| AC-08 | כפתור `eyal-drive-intake` |
| AC-09 | `meeting.html` + ייצוא `eyal-meeting-snapshot` |
| AC-10 | ייצואי `eyal-feedback`, `eyal-site-tree-feedback`, `eyal-page-content-intake` לא שונו במבנה קריטי |
| AC-11 | טבלת דלתא לעיל |
| AC-12 | דורש URL חי + QA צוות 50 |
| AC-13 | לוגים: `hub_validate_hub_data.py` (0), `hub_check_dist_links.py` (0) אחרי `--mirror-docs` |
| AC-14 | `:focus-visible` על `.hub-acc__summary`; תוויות טפסים |
| AC-15 | `hub/dist`: `meta robots` noindex,nofollow; `robots.txt` Disallow `/`; פוטר + `hub-brand`; `metadata.json` קיים |

---

## קבצים שנגעו (נתיבים יחסיים משורש המאגר)

- `hub/data/links.json` (חדש)
- `hub/data/questions-prompts.json` (חדש)
- `hub/data/meeting-brief.json` (חדש)
- `hub/data/roadmap.json`
- `hub/data/deliverables.json`
- `hub/data/calendar-anchor.txt`
- `hub/src/assets/hub.css`
- `hub/src/assets/hub-form-exports.js` (חדש)
- `scripts/build_eyal_client_hub.py`
- `scripts/hub_validate_hub_data.py`

---

## פקודות שהורצו

```bash
python3 scripts/hub_validate_hub_data.py
python3 scripts/build_eyal_client_hub.py --mirror-docs
python3 scripts/hub_check_dist_links.py
python3 scripts/ftp_publish_eyal_client_hub.py --dry-run
```

---

**הערה לצוות 50:** להשלמת מנדט — נדרשת פריסה FTP אמיתית, שורש URL מלא, ותיעוד purge אחרי עלייה.

**עדכון 2026-04-16 (צוות 100):** סקירה אדריכלית — [`ARCH-REVIEW-EYAL-HUB-V2-TEAM10-DELIVERY-2026-04-16.md`](../team_100/ARCH-REVIEW-EYAL-HUB-V2-TEAM10-DELIVERY-2026-04-16.md); תוקן ניסוח `stateHe` ב־`hub/data/roadmap.json` (הסרת מונחי שער גלויים ל־AC-03) ובוצעה בנייה מחדש ל־`hub/dist/`.
