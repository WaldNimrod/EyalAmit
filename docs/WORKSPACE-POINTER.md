# מצביע workspace — אם פותחים מתיקיית האב

אם פתחתם ב-Cursor את תיקיית **`Eyal Amit`** (האב) כשורש workspace בלבד, **כללי `.cursor/rules` של מאגר זה לא נטענים** — הם כאן תחת `.cursor/`.

## מה לעשות

1. **מומלץ:** File → Open Folder → בחרו את **`EyalAmit.co.il-2026`** (מיקום ליד `eyalamit.co.il-legacy`).
2. **נקודת כניסה:** [`docs/PROJECT-ENTRY.md`](PROJECT-ENTRY.md)
3. **אתר WordPress (ישן):** תיקייה **`eyalamit.co.il-legacy/`** ליד מאגר זה; ריפו GitHub: `EYALAMIT1/eyalamit.co.il`.

## Eyal Client Hub V2 (צוותי Cursor 100 / 10 / 50)

סשני עבודה על **Hub V2** (אפיון, מימוש, QA) מניחים ש־**שורש ה-workspace** הוא **`EyalAmit.co.il-2026`** — אחרת נתיבי `hub/`, סקריפטים וכללי `.cursor/rules` לא יתיישרו. פרומטי אקטיבציה מלאים (זהות + קונטקסט לכל צוות): [`_COMMUNICATION/team_100/EYAL-HUB-V2-ACTIVATION-PROMPTS-ALL-TEAMS-2026-04-15.md`](../_COMMUNICATION/team_100/EYAL-HUB-V2-ACTIVATION-PROMPTS-ALL-TEAMS-2026-04-15.md).

### תהליך הפעלה — סדר ארטיפקטים (אחרי LOD400 + מנדטים)

1. **צוות 190 (OpenAI):** תוצאת L-GATE_SPEC → `_COMMUNICATION/team_190/EYAL-HUB-V2/L-GATE_SPEC_result.md` (או עדכון הקובץ הקיים).
2. **צוות 10 (Cursor):** מסירה ל-QA → `_COMMUNICATION/team_10/EYAL-HUB-V2-DELIVERY-TEAM10-<תאריך>.md`.
3. **צוות 50 (Cursor):** דוח QA → `_COMMUNICATION/team_50/EYAL-HUB-V2-QA-REPORT-TEAM50-<תאריך>.md`.
4. **צוות 90 (OpenAI):** ולידציה פוסט-QA → `_COMMUNICATION/team_90/VALIDATION-EYAL-HUB-V2-TEAM90-<תאריך>.md`.

**שימוש:** פתחו את קובץ הפרומטים למעלה, העתיקו את בלוק הצוות, הדביקו בסשן חדש והוסיפו בסוף קלט מפעיל (שאלת היקף / URL בסיס לשרת) לפי ההוראות בבלוק.

## עותק מחוץ למאגר

קובץ מקביל עשוי להימצא גם בשורש תיקיית `Eyal Amit/` (מחוץ ל-git של מאגר זה) לנוחות workspace רחב.
