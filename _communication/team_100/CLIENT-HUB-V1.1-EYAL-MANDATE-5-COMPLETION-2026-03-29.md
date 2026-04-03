# Client Hub Standard v1.1 — יישום Eyal Amit 2026 (דוח השלמה למנדט §5)

**תאריך:** 2026-03-29  
**מאגר:** `EyalAmit.co.il-2026`

## מסמכים קנוניים

| פריט | נתיב |
|------|------|
| נוהל נעול (גוף verbatim מ־SFA + בלוק נעילה) | `docs/CLIENT_HUB_STANDARD_v1.md` |
| נספח פרויקט | `docs/CLIENT_HUB_APPENDIX_EYAL.md` |
| טיוטת platform (SUPERSEDED) | `docs/project/client-hub-platform/CLIENT-HUB-PLATFORM-SPEC-DRAFT.md` |

## קריטריוני הצלחה (תוכנית יישום)

| # | קריטריון | אימות |
|---|-----------|--------|
| C1 | קובץ הנוהל — רק בלוק הנעילה שונה | `diff` גוף מול `SmallFarmsAgents/docs/CLIENT_HUB_STANDARD_v1.md` — **BODY_OK** (שורות אחרי בלוק הנעילה) |
| C2 | מבנה `hub/` | `hub/data/`, `hub/src/assets/`, `hub/ssot/responses/`, בנייה ל־`hub/dist/` |
| C3 | JSON ב־`hub/data/` עם `schemaVersion: 1` ושדות `*He` | `decisions.json`, `tasks.json`, `roadmap.json`, `updates.json` |
| C4 | `tasks.html` — משימות + החלטות + משיב + ייצוא | נבנה ב־`hub/dist/tasks.html`; ניווט מ־`index.html` |
| C5 | ייצוא: `respondent`, `exportType`, `answers[]` | `hub/src/assets/feedback.js` + `HubFeedback.init` עם `eyal-feedback` |
| C6 | ingest → `hub/ssot/responses/` + manifest | `scripts/ingest_eyal_feedback_json.py` — נבדק בהרצת דוגמה (לאחר מכן נוקה ה־response לבדיקה) |
| C7 | `metadata.json` + `robots.txt` + meta robots | קיימים ב־`hub/dist/`; `<meta name="robots" content="noindex, nofollow">` |
| C8 | Footer `hub-brand` + WhatsApp | כל עמוד כולל `hub-brand` וקישור `https://wa.me/972547776770` (F-09) |
| C9 | פריסה לסטייג'ינג | `scripts/ftp_publish_eyal_client_hub.py` מצביע על `hub/dist/`; דורש `local/.env.upress` עם סודות FTP |
| C10 | בדיקת שרת (דפדפן / MCP) | **בוצע (2026-04-02):** דוח MCP מלא על `hub/dist` מקומי — [`EYAL-HUB-BROWSER-QA-MCP-2026-04-02.md`](./EYAL-HUB-BROWSER-QA-MCP-2026-04-02.md). סטייג'ינג HTTP נבדק; עדיין מוצג build ישן עד פריסת FTP. **סטייג'ינג:** `http://` · **פרודקשן:** `https://` — ראו [`docs/CLIENT_HUB_APPENDIX_EYAL.md`](../../docs/CLIENT_HUB_APPENDIX_EYAL.md) |
| C11 | תאימות מסמכים | טיוטת platform מסומנת SUPERSEDED; הפניות מעודכנות ל־`hub/` ולנוהל הנעול |

## פערים / המשך

- **v1.2+:** מיפוי אוטומטי של ייצואי SSOT ישנים עם מזהי `Q-*` (אם יימצאו) — ראו נספח Eyal.
- **F-15** (שמירת משוב בשרת): לא הוטמע כחובה; תיקיית `incoming/` מועתקת ל־`dist/` כמו קודם.

## פקודות עיקריות

```bash
python3 scripts/build_eyal_client_hub.py
python3 scripts/build_eyal_client_hub.py --mirror-docs
python3 scripts/ftp_publish_eyal_client_hub.py
python3 scripts/ingest_eyal_feedback_json.py path/to/export.json --by "Name"
```
