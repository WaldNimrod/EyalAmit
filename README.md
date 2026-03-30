# EyalAmit.co.il — פרויקט 2026

מאגר נפרד ל**אפיון, תכנון ופיתוח השלב הבא** של האתר, בלי לערבב עם קוד ותשתית האתר הישן.

**נקודת כניסה מרכזית (קראו תחילה):** [`docs/PROJECT-ENTRY.md`](docs/PROJECT-ENTRY.md) · סוכני AI: [`AGENTS.md`](AGENTS.md) · Cursor: `.cursor/rules/` + [`.cursor/skills/`](.cursor/skills/README.md).

**Cursor:** פתחו את התיקייה **`EyalAmit.co.il-2026`** כשורש workspace כדי שכללי הפרויקט ייטענו. אם ה-workspace הוא תיקיית האב בלבד, ראו [`docs/WORKSPACE-POINTER.md`](docs/WORKSPACE-POINTER.md).

## מדיניות Git (חשוב)

- **הריפו המרוחק של פרויקט 2026:** [`github.com/WaldNimrod/EyalAmit`](https://github.com/WaldNimrod/EyalAmit) — מכיל **רק** מה שנמצא **בתוך תיקיית הפרויקט החדשה** (מסמכים, `_communication/`, `scripts/`, `.cursor/`, `local/` כשתוגדר, וכל קוד/סביבה שתוסיפו **כאן**).
- **אין** לשלב בריפו הזה את עץ האתר הישן. התיקייה המקומית לקוד הישן: **`eyalamit.co.il-legacy`**; ב-GitHub עדיין **`EYALAMIT1/eyalamit.co.il`** (שם הריפו לא השתנה).
- **מקור אמת לתכנון ואפיון (2026):** עדכונים ו־push שמייצגים את הפרויקט החדש — **רק למאגר הזה**, לא כחלק ממחזור ה־push של האתר הישן.

## מה נמצא איפה

| מיקום | תפקיד |
|--------|--------|
| **המאגר הזה (WaldNimrod/EyalAmit)** | כל פרויקט 2026: `docs/`, `_communication/`, `scripts/`, `.cursor/`, `local/` (סביבה מקומית — כאן). |
| [`../eyalamit.co.il-legacy/`](../eyalamit.co.il-legacy/) | אתר WordPress קיים — עבודה מקומית בלבד; Git נפרד, **לא** חלק מריפו EyalAmit. |

## מבנה שורש

- `_communication/` — דוחות ותוכניות לפי צוות (`team_10` … `team_100`); אונבורד: `onboard_teamXX.md`.
- `docs/project/` — אפיון צוות 100, הגשות ל־CEO, מפת אתר, החלטות, צ'ק־ליסטים.
- `scripts/` — `build_eyal_ceo_deliverables.py` ועזרים; להרצה: `pip install -r scripts/requirements-docx.txt` ואז מתוך שורש המאגר:  
  `python3 scripts/build_eyal_ceo_deliverables.py`
- `local/` — מקום שמור לסביבה מקומית (Docker, Local WP, קבצי `.env` מקומיים — לא ל־commit).

## סנכרון עם תוכן שהועתק פעם מ־eyalamit.co.il

העתק ראשוני של `docs/project` הגיע מהאתר הישן. **מקור האמת לתכנון מעכשיו:** מאגר זה בלבד. אין לסמוך על עריכות מקבילות ב־`eyalamit.co.il-legacy/docs` כמקור לפרויקט 2026.

## Git

Remote: **`origin`** → `https://github.com/WaldNimrod/EyalAmit.git`. ענף עבודה מומלץ: **`main`**.
