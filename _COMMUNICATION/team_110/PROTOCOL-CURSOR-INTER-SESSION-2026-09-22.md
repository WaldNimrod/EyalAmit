---
id: PROTOCOL-CURSOR-INTER-SESSION-2026-09-22
schema_version: aos_v1_team_messaging
type: PROTOCOL
from: team_110
to: [team_00, team_10, team_100]
date: 2026-09-22
status: ACTIVE
---

# תקשורת בין צוותים ב-Cursor — ברירת מחדל בפרויקט הזה

AOS-mail (`/api/messaging`, INBOX, שילוח UUID) **אינו** ברירת המחדל כאן. ה-API שבורה/401 במצב הנוכחי, וזה לא ערוץ אמין.

שלושה משטחים שונים נקראים «Cursor». הפינג החיצוני עובד על שניים מהם. הסשן הזה יושב על השלישי.

| משטח | מי מדבר אליו | יש send רציף? |
|---|---|---|
| Claude Code / Codex **בתוך** חלון Cursor | `SendMessage` בין סשני Claude/Codex (teammate) | כן — זה מה שנראה «מבחוץ» |
| `cursor-agent` CLI / SDK `Agent.send` / `Agent.resume` | AOS gateway, ולידציות, סקריפטים | כן — אבל זה מריץ/ממשיך **סוכן CLI**, לא את הצ'אט ב-Agents |
| Glass Agent (הצ'אט הזה, New Agent) | רק נימרוד + `Task` יורד לילד | **לא.** אין כלי send ל-composer אח. AOS `CursorIdeAdapter.send()` הוא stub (`NotImplementedError`, `manual_hybrid`) |

לכן זה נשמע לא הגיוני: מנועים אחרים מדברים «ל-Cursor» כל הזמן. הם מדברים ל-CLI/SDK או לסשני Claude/Codex שגרים באותו חלון. הם **לא** מזריקים הודעה ללשונית Agents של צוות 10. ניסיון לחקות את זה ב-`Task resume=<uuid של הצ'אט>` הוא API אחר (subagent) — וזה מה שהעלים סשנים.

הכלים שיש לסוכן **במשטח הזה**:

| כלי | מה הוא באמת | מותר? |
|---|---|---|
| קובץ תחת `_COMMUNICATION/team_XX/` | Iron Rule #6 — ארטיפקט על דיסק, שני הסשנים קוראים אותו | **כן — ברירת המחדל** |
| New Agent באותו פרויקט + הדבקת פרומט | סשן-אב חדש, קונטקסט מתמשך, תפקיד נעול | **כן — כך מקימים צוות** |
| `SearchConversations` | מחפש צ'אטים. **לא שולח** | קריאה בלבד |
| `Task` (subagent) | סוכן **משנה** תחת ה-composer של ההורה. חד-פעמי | רק מחקר/בדיקה קצרה **בתוך** אותו צוות |
| `Task resume=<uuid של סשן-אב>` | ממנה מחדש את הסשן-אב כילד. זה מה שהעלים את סשן 110 | **אסור לעולם** |

## למה «שלח הודעה לסשן המקביל» הרס סשנים

Cursor שומר צ'אטים ב-`composerHeaders` עם `isSubagent` + `parentComposerId`.  
`Task resume` על UUID של צ'אט פתוח + `interrupt=true` **הופך הורה לילד**.  
אחרי זה Glass/רשימת Agents מתייחסת לסשן כאל subagent, והוא נעלם מהרשימה גם כשהקובץ עצמו נשאר ב-`agent-transcripts/`.

אין «unpack» רשמי. שחזור = תיקון DB כש-Cursor סגור, לא פינג חוזר.

## איך מקימים צוות מקביל (לא Task)

1. בחלון הפרויקט: **New Agent** (לא Ask, לא Task מתוך הצ'אט החי).
2. מדביקים את קובץ ה-PROMPT המלא (אונבורד + משימה + נתיב worktree).
3. פעולה ראשונה של הסוכן החדש: `move_agent_to_root` אל עץ העבודה שלו.
4. מכאן: קבצים ב־`_COMMUNICATION/` בלבד. נימרוד יכול להדביק שורת «קרא את הקובץ X» אם הסשן השני לא שם לב.

## איך צוות כותב לצוות

- `team_10` → `team_110` / `team_100`: קובץ חדש  
  `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/TO-TEAM110-<נושא>.md`
- `team_110` → `team_10`:  
  `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/TO-TEAM10-<נושא>.md`
- שורה ראשונה אחרי הכותרת: למי, מה צריך, נתיב `file:///`. בלי UUID של צ'אט.

## אסור

- `Task resume` על שיחה קיימת
- `/api/messaging` / AOS INBOX כערוץ ראשי
- לבקש מנימרוד «תדביק UUID»
- סוכן משנה במקום סשן צוות

---

# צוות מנהל ב-Cursor (110) — התקורה הנכונה

Cursor לא נותן ל-110 «לדבר» לסשן 10. הקובץ הוא תיבת הדואר. **נימרוד הוא קו ההעראה** (הדבקת שורה אחת בצ'אט של הנמען). בלי זה, הסשן השני לא מתעורר כשכותבים לדיסק.

זה לא באג זמני של AOS. זה מודל המוצר: `Task` יורד להורה→ילד בתוך אותו composer. סשן-אב מקביל הוא צ'אט נפרד בלי API שליחה.

## ארגון

| שכבה | מה זה | מה לא |
|---|---|---|
| סשן-אב לכל צוות | New Agent + אונבורד + worktree | `Task`, `.cursor/agents/` custom subagent, Cloud Automation |
| 110 מנהל | מנדט, GO/HOLD, קריאת STATUS, החלטות, SSOT | לא מיישם CSS/FTP של 10 |
| 10 מבצע | מיפוי, הוכחה, CSS, FTP מה-worktree | לא משנה SSOT, לא Plan-mode אחרי שיש GO |
| נימרוד | פותח סשנים, מחליף מצב (Plan/Agent), מדביק שורת «קרא X» | לא צריך להריץ סקריפטים במקום הסוכן |

רשימת סשנים חיה (בלי UUID לפינג):  
`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_110/ROSTER-CURSOR-SESSIONS-2026-09-22.md`

## תיבה — שלושה קבצים, לא שיחה

1. **STATUS** (צוות 10 דורס במקום, לא מצטבר):  
   `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/STATUS.md`
2. **פקודה** מ-110: `TO-TEAM10-<VERB>-<נושא>.md` עם VERB אחד מ: `GO` · `HOLD` · `ASK` · `REJECT`
3. **דיווח** מ-10: `TO-TEAM110-<VERB>-<נושא>.md` עם VERB אחד מ: `BLOCKED` · `ASK` · `DONE` · `NOTE`

כל קובץ: למי, מה צריך, נתיב `file:///`, בלי UUID.

## איך 110 מנהל בפועל

1. כותב פקודה לתיבה.
2. אומר לנימרוד משפט אחד להדבקה בצ'אט 10, למשל: `קרא file:///…/TO-TEAM10-HOLD-….md ועדכן STATUS.md`.
3. קורא `STATUS.md` כשחוזרים לסשן הזה, או כשנימרוד אומר «תבדוק את 10».
4. מחליט: המשך / עצור / דחה / העלה לנימרוד. לא נכנס לעץ של 10 אלא אם יש חריג כתוב.

אופציונלי: `/loop` על סשן 110 שרק בודק mtime של `STATUS.md` + `TO-TEAM110-*`. לא ברירת מחדל — זה רעש אם 10 שקט.

## מצב Plan מול Agent

- **צוות 10 במשימה הזו:** Plan קודם (מיפוי + דפוסים), אחר כך Agent למימוש. נימרוד 22.9: תוכנית ואז ביצוע = תוצר משופר.
- **צוות מנהל (110):** Agent כשכותבים ארטיפקטים.
- 110 **לא** יכול להחליף מצב לסשן אחר. רק נימרוד, בתוך אותו צ'אט.

## מה 110 לעולם לא עושה «כדי לנהל»

- `Task resume` על הסשן של 10
- לפתוח את ה-worktree של 10 ולערוך שם במקביל
- FTP מהעץ הראשי
- לבקש UUID «כדי לפנג»
- להחליף את 10 ב-subagent מתוך הצ'אט הזה
