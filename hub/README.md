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
| פלייבוק עדכון (קצר) | [`HUB-CANONICAL-UPDATE-PLAYBOOK.md`](HUB-CANONICAL-UPDATE-PLAYBOOK.md) |
| אפיון Hub V2 (LOD400) | [`../_communication/team_100/EYAL-CLIENT-HUB-V2-LOD400-2026-04-15.md`](../_communication/team_100/EYAL-CLIENT-HUB-V2-LOD400-2026-04-15.md) |
| פלטת צבעי מותג (מחייבת לממשקים) | [`../docs/project/EYAL-SITE-COLOR-PALETTE.md`](../docs/project/EYAL-SITE-COLOR-PALETTE.md) — ממומש ב־`hub/src/assets/hub.css` |

**נוהל ארגוני:** [`docs/CLIENT_HUB_STANDARD_v1.md`](../docs/CLIENT_HUB_STANDARD_v1.md) · **נספח Eyal:** [`docs/CLIENT_HUB_APPENDIX_EYAL.md`](../docs/CLIENT_HUB_APPENDIX_EYAL.md).

**כתובת אחרי פריסה (דוגמה סטייג'ינג):** `http://<staging-host>/<UPRESS_EYAL_HUB_PATH>/index.html` — ברירת מחדל לנתיב: `ea-eyal-hub`. בפרודקשן — רק HTTPS.

בנייה ופריסה — ראו [`EYAL-HUB-SSOT-WORKFLOW.md`](EYAL-HUB-SSOT-WORKFLOW.md) §2; נקודת כניסה למאגר: [`docs/PROJECT-ENTRY.md`](../docs/PROJECT-ENTRY.md). **פריסת FTP** מסירה כברירת מחדל קבצים יתומים בשרת (לא קיימים ב־`hub/dist`).
