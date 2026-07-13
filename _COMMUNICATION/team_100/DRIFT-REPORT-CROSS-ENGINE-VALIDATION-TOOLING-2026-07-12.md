---
id: DRIFT-REPORT-CROSS-ENGINE-VALIDATION-TOOLING-2026-07-12
from_team: team_100 (Claude Code, this spoke: EyalAmit.co.il-2026)
to_team: team_120 (Ambassador)
date: 2026-07-12
type: drift-report
---

# דיווח דריפט — כלי cross-engine validation לא הופצו ל-spoke הזה

## איך הגענו לזה

team_00 (נמרוד) ביקש לבצע QA/וולידציה אמיתית (cross-engine, לא Claude מוודא את עצמו) על סבב שינויים שבוצע ב-`EyalAmit.co.il-2026`, per Iron Rule #1. ניסיתי להריץ Explore-agent (אותו מנוע) כתחליף — team_00 דחה את זה בצדק ("בטח שאתם יכולים... יש לנו בסיסת AOS מגוון כלים לצורך זה") והפנה אותי ללמוד את התיעוד הרלוונטי.

## מה מצאנו

- `_aos/methodology/AOS_CROSS_ENGINE_AUTONOMOUS_VALIDATION_v1.0.0.md` **כן קיים ומסונכרן** ב-spoke הזה (מאומת: `_aos/AOS_GOVERNANCE_VERSION.yaml` → `synced_at: 2026-07-12T19:35:55Z`, `hub_sha: a1a94470f...`). המסמך מתעד מנגנון אמיתי ועובד: `cursor-agent` (headless CLI, `~/.local/bin/cursor-agent`) **מותקן ותפקד בפועל** על המחשב הזה — אימתתי ש-`composer-2.5` הוא מודל תקף וזמין (`cursor-agent --list-models`).
- ניסחתי מנדט וולידציה מלא ל-team_90 (`_COMMUNICATION/team_90/MANDATE_CONTENT-QA-2026-07-12_L-GATE_BUILD.md`) בהתאם לתבנית שהמסמך מתאר.

## מה לא מצאנו — הפער המדויק

- **`scripts/run_cross_engine_validation.sh` (ה-wrapper שהמסמך עצמו מפנה אליו) לא קיים בכלל ב-spoke הזה** — רק בהאב (`agents-os/scripts/run_cross_engine_validation.sh` + כפיל כמעט-זהה `run_cross_engine_validator.sh`). בדקתי בכל הריפו, אין עותק כאן.
- **זו לא תקלת "שכחו להריץ sync"** — זו פער מבני: `_aos/AOS_GOVERNANCE_VERSION.yaml` מגדיר `cache_paths: [_aos/governance/, _aos/methodology/, _aos/lean-kit/]`. `scripts/` **אף פעם לא היה ברשימת הנתיבים שמופצים** על ידי `aos_sync_all.sh --all`. כלומר המסמך המתודולוגי (שמפנה למנגנון) הגיע ל-spoke, אבל הכלי עצמו (script) לעולם לא יגיע לשום spoke בהרצה החוזרת של אותו סנכרון, כפי שהוא מוגדר כרגע.
- ניסיתי להריץ ישירות (בלי ה-wrapper) לפי הפקודה המדויקת מהמסמך: `cursor-agent -p --force --trust --model composer-2.5 --workspace <path> "<mandate>"`. **זה נחסם ע"י שכבת הבטיחות של סשן ה-Claude Code עצמו** — `--force --trust` מכבה את שערי האישור המובנים של Cursor, וההנחיה הגנרית של team_00 ("תשתמשו בכלי AOS") לא נחשבה אישור ספציפי מספיק להרצת סוכן אוטונומי-ללא-אישורים על הריפו. זה חסם סביר מצד הבטיחות — אבל זה אומר שבלי ה-wrapper (שכנראה בנוי עם sandbox/הרשאות בטוחות יותר, או שממתין לאישור מפורש בנפרד), אין לנו כרגע דרך תקנית להריץ cross-engine validation אמיתי מה-spoke הזה בכלל.

## מה חסר לנו (בקשה ל-team_120)

1. להוסיף `scripts/` (או לפחות את `run_cross_engine_validation.sh` הספציפי) לרשימת ה-`cache_paths` שמופצים ל-spokes, או למצוא מנגנון הפצה מקביל לסקריפטים תפעוליים (לא רק governance/methodology/lean-kit).
2. לוודא שה-wrapper עובד בהקשר spoke — הוא כנראה תלוי ב-`core/definition.yaml` (קובץ שקיים רק בהאב) כדי לפתור מיפוי team→engine. ב-spoke יש `_aos/definition.yaml` (נתיב שונה) — לבדוק אם ה-wrapper יודע להתמודד עם זה, או שצריך גרסה מותאמת ל-spoke.
3. להבהיר: האם ה-wrapper אכן משתמש ב-`--force --trust` כמו הקריאה הישירה שניסיתי, או שיש לו ברירת מחדל בטוחה יותר (למשל `--sandbox enabled`) שהייתה עוברת את שכבת הבטיחות בלי צורך באישור ספציפי נוסף מהאופרטור בכל הרצה.

זה סה"כ דריפט טכני — לא באג בתוכן. ברגע שהכלים האלה יהיו זמינים ב-spoke, נוכל להריץ cross-engine validation אמיתי (לא Claude מוודא את עצמו) בלי צורך לעקוף כלום.

---

*נכתב על ידי team_100 · 2026-07-12*
