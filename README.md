# EyalAmit.co.il — פרויקט 2026

מאגר נפרד ל**אפיון, תכנון ופיתוח השלב הבא** של האתר, בלי לערבב עם קוד ותשתית האתר הישן.

**נקודת כניסה מרכזית (קראו תחילה):** [`docs/PROJECT-ENTRY.md`](docs/PROJECT-ENTRY.md) · סוכני AI: [`AGENTS.md`](AGENTS.md) · Cursor: `.cursor/rules/` + [`.cursor/skills/`](.cursor/skills/README.md).

**Cursor:** פתחו את התיקייה **`EyalAmit.co.il-2026`** כשורש workspace כדי שכללי הפרויקט ייטענו. אם ה-workspace הוא תיקיית האב בלבד, ראו [`WORKSPACE-POINTER.md`](../WORKSPACE-POINTER.md).

## מה נמצא איפה

| מיקום | תפקיד |
|--------|--------|
| **המאגר הזה** | דוקומנטציית פרויקט (`docs/project/`), סקריפטים לייצוא Word (`scripts/`), בהמשך סביבה מקומית וקוד חדש. |
| [`../eyalamit.co.il/`](../eyalamit.co.il/) | אתר WordPress קיים, תמה, תוספים — GitHub `EYALAMIT1/eyalamit.co.il`. |

## מבנה שורש

- `_communication/` — דוחות ותוכניות לפי צוות (`team_10` … `team_100`); אונבורד: `onboard_teamXX.md`.
- `docs/project/` — אפיון צוות 100, הגשות ל־CEO, מפת אתר, החלטות, צ'ק־ליסטים.
- `scripts/` — `build_eyal_ceo_deliverables.py` ועזרים; להרצה: `pip install -r scripts/requirements-docx.txt` ואז מתוך שורש המאגר:  
  `python3 scripts/build_eyal_ceo_deliverables.py`
- `local/` — מקום שמור לסביבה מקומית (Docker, Local WP, קבצי `.env` מקומיים — לא ל־commit).

## סנכרון עם המאגר הישן

העתק ראשוני של `docs/project` בוצע מתוך `eyalamit.co.il`. אם ממשיכים לערוך במאגר הישן, יש לסנכרן ידנית או להעביר עריכה למאגר הזה בלבד כדי לשמור על **מקור אמת אחד**.

## Git

מאגר Git מקומי עצמאי (לא תת־תיקייה של `eyalamit.co.il`). אפשר לחבר ל־GitHub כריפו חדש כשתרצו.
