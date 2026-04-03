# ממשק לאייל (Eyal Client Hub) — מקור יחיד

**זהו** ממשק הלקוח הקנוני בפרויקט — אין עותק מקביל תחת `docs/project/`.

| מה | איפה |
|----|------|
| נתונים (JSON) | `hub/data/` |
| נכסים / תבנית | `hub/src/` |
| SSOT משוב | `hub/ssot/` |
| פלט בנייה | `hub/dist/` (לא ב־Git) |
| עוגן תאריך לסוכנים | `hub/data/calendar-anchor.txt` |
| נוהל view ↔ SSOT | [`EYAL-HUB-SSOT-WORKFLOW.md`](EYAL-HUB-SSOT-WORKFLOW.md) |

**נוהל ארגוני:** [`docs/CLIENT_HUB_STANDARD_v1.md`](../docs/CLIENT_HUB_STANDARD_v1.md) · **נספח Eyal:** [`docs/CLIENT_HUB_APPENDIX_EYAL.md`](../docs/CLIENT_HUB_APPENDIX_EYAL.md).

**כתובת אחרי פריסה (דוגמה סטייג'ינג):** `http://<staging-host>/<UPRESS_EYAL_HUB_PATH>/index.html` — ברירת מחדל לנתיב: `ea-eyal-hub`. בפרודקשן — רק HTTPS.

בנייה ופריסה — ראו [`EYAL-HUB-SSOT-WORKFLOW.md`](EYAL-HUB-SSOT-WORKFLOW.md) §2; נקודת כניסה למאגר: [`docs/PROJECT-ENTRY.md`](../docs/PROJECT-ENTRY.md). **פריסת FTP** מסירה כברירת מחדל קבצים יתומים בשרת (לא קיימים ב־`hub/dist`).
