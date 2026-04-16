# פלייבוק — עדכון קנוני של Eyal Client Hub (חסכון בטוקנים)

**גרסה:** 1.0  
**תאריך:** 2026-04-15  
**קשור ל:** [`EYAL-HUB-SSOT-WORKFLOW.md`](./EYAL-HUB-SSOT-WORKFLOW.md) · [`docs/CLIENT_HUB_APPENDIX_EYAL.md`](../docs/CLIENT_HUB_APPENDIX_EYAL.md)

מסמך קצר (עמוד אחד) — רצף קבוע לעדכון ה-Hub בלי להטמיע את כל הנוהל בכל סשן AI.

---

## צעדים (בסדר)

1. **סנכרון מאגר** — `git pull` (או שקיל); ודא workspace = שורש `EyalAmit.co.il-2026`.
2. **מקורות אמת** — עיון ב־[`docs/PROJECT-ENTRY.md`](../docs/PROJECT-ENTRY.md) ו־[`docs/sop/SSOT.md`](../docs/sop/SSOT.md) לשלב נוכחי; אופציונלית [`docs/project/ROADMAP-2026.md`](../docs/project/ROADMAP-2026.md).
3. **עריכת נתונים** — `hub/data/*.json` (או הרצת סנכרון עתידי מ־`hub/canon-map.example.yaml` אם הוגדר מיפוי).
4. **ולידציה** — `python3 scripts/hub_validate_hub_data.py` (קוד יציאה 0).
5. **בנייה** — `python3 scripts/build_eyal_client_hub.py` (+ `--mirror-docs` אם מוסיפים קבצים ל־`dist/files/`).
6. **בדיקת קישורים מקומית** — `python3 scripts/hub_check_dist_links.py hub/dist` (קוד יציאה 0).
7. **פריסה** — `python3 scripts/ftp_publish_eyal_client_hub.py` (או `--dry-run` לבדיקה); אחרי פריסה — purge מטמון לפי נספח Eyal.
8. **אימות ציבורי** — גלישה ל־`index.html` / `tasks.html` עם `?nocache=` או דוח צוות 50.

---

## מה לא לעשות כאן

- לא לקרוא קבצי קאנון מהדפדפן של הלקוח — רק HTML סטטי בשרת.
- לא לדלג על שלב 4–6 לפני FTP — מונע שגיאות יקרות בטוקנים.

---

## הפניה לסוכנים

בפרומטי צוות 10/50: ציינו **"בצע לפי HUB-CANONICAL-UPDATE-PLAYBOOK.md"** במקום לשכפל את הרשימה.
