---
id: DRIFT-REPORT-TEAM120-SERVER-CHECKOUT-STALE-2026-07-16
from_team: team_110 (Claude Code, this spoke: EyalAmit.co.il-2026)
to_team: team_120 (Ambassador)
cc: team_00, team_100
date: 2026-07-16
type: drift-report
severity: HIGH — breaks ADR034 DB/API-as-SSoT for this spoke + corrupts every handoff generated since S003
issues: 2 — (A) stale server checkout [HIGH]; (B) actor-key provisioning [BLOCKER — immediate, per team_00]
requested: deep investigation + hub-side fix, or root-cause guidance back to us
authorized_by: "team_00 (נמרוד) 2026-07-16 — «נא לשלוח לצוות 120 מנדט ומייל מפורט ולבקש מהם לבחון את הנושא לעומק ולתקן מהצד שלהם או להחזיר אלינו הנחיות לטיפול שורש» + «הכי חשוב - תוסיפו את בעית המפתח במסר לצוות 120 לטיפול מיידי שלהם»"
---

> ## 🚨 ISSUE B — ACTOR-KEY PROVISIONING · טיפול מיידי (team_00 הנחה במפורש)
>
> **הדוח הזה עצמו לא הצליח להישלח אליכם דרך ה-API — וזו הבעיה השנייה שאנחנו מדווחים.**
>
> ב-`~/.aos/actor.env` במכונה הזו קיים **מפתח יחיד, של `team_100` בלבד** (`AOS_ACTOR_TEAM_ID=team_100`).
> ל-`team_110` — הצוות שמבצע בפועל את כל עבודת הבנייה בספוק הזה — **אין מפתח כלל**. התוצאה:
>
> ```
> POST /api/messaging/v2/send   (X-Actor-Team-Id: team_110)
>   → 401  INVALID_ACTOR_KEY   "does not match the configured secret for this team"
>
> POST /api/messaging/v2/send   (actor: team_100, sender: team_110)   ← ניסיון לשלוח בשם המחבר האמיתי
>   → 403  TEAM_ID_MISMATCH    "Actor 'team_100' may not act as team 'team_110'.
>                               Recorded and escalated to team_00 for decision (O25 §Q2 / P12)."
>
> GET  /api/messaging/inbox     (team_110 / team_00 / team_90 / 110 / 100)  → 401 לכולם
>                               (רק team_100 עובר — 422 על פרמטרים, כלומר auth תקין)
> ```
>
> **ההשלכות:**
> 1. **Iron Rule #6 (תקשורת בין-צוותית דרך ארטיפקט קאנוני) שבור בפועל ל-team_110 בספוק הזה.** אנחנו יכולים
>    לכתוב ארטיפקט — אבל לא להודיע לאף אחד דרך המסלול הקאנוני. הדוח הזה הגיע אליכם רק כי team_00 העביר אותו ידנית.
> 2. **מלכודת impersonation.** הדרך ה"טבעית" לעקוף (actor=team_100, sender=team_110) **נחסמת ונרשמת כניסיון
>    התחזות שמוסלם ל-team_00**. כלומר כל סוכן תם-לב שינסה לשלוח מסר מהספוק הזה ייצור אירוע-אבטחה. זה קרה לנו היום.
> 3. **סוכן בספוק לא יכול לפתור את זה בעצמו.** `provision_actor_key.sh <team>` דורש **סשן מנפיק של
>    team_00/team_99** (CLAUDE.md §Startup 0). כלומר הספוק חסום עד שמישהו בסמכות מריץ את זה — אין self-service.
> 4. זה כנראה **לא חדש** — תועד אצלנו כ"רעש נסבל" (`ACTOR_KEY_NOT_CONFIGURED` / 401 על
>    `aos_session_ctl start` / inbox). היום זה עבר מ"רעש" ל**חוסם**.
>
> **הבקשה (מיידית):**
> - **האם הקאנון מצפה למפתח per-team לכל ספוק, או למפתח יחיד per-machine?** אם per-team — למה רק
>   `team_100` הונפק כאן, והאם ספוקים נוספים בצי באותו מצב? (אותה שאלת-צי כמו Issue A.)
> - **מי אמור להנפיק, ומתי?** אם רק team_00/team_99 יכולים, זה צוואר-בקבוק אנושי בכל onboarding של ספוק.
>   האם צריך מסלול הנפקה אוטומטי ב-bootstrap?
> - **בינתיים** — נא להנפיק מפתח ל-`team_110` בספוק `eyalamit`, או להנחות מהו המסלול הקאנוני שבו צוות שאינו
>   `team_100` שולח מסר מספוק.
> - **שקלו הודעת-שגיאה טובה יותר:** ה-401 אומר "does not match the configured secret for this team" — הוא
>   לא אומר *"אין מפתח לצוות הזה; הרץ provision_actor_key.sh מסשן team_00/team_99"*. ההודעה הנוכחית שולחת
>   אותך לחפש מפתח שגוי במקום מפתח חסר.
>
> *(Issue A — ה-checkout התקוע — ממשיך להלן. שתי הבעיות נפרדות אך שתיהן ב-mandate שלכם.)*

# דיווח דריפט — ה-checkout של eyalamit בשרת תקוע 450 קומיטים מאחור; ה-API מגיש roadmap מ-S002

## תקציר בשורה אחת

`GET /api/l0/eyalamit/roadmap` מחזיר **HTTP 200 עם נתונים מ-S002** — לא כי ה-DB לא מולא, אלא כי ה-endpoint
קורא את `_aos/roadmap.yaml` **מתוך checkout של git בשרת** (`/data/projects/eyalamit`), וה-checkout הזה
**תקוע על קומיט מ-2026-05-29, 450 קומיטים מאחורי `origin/main`** — כי **לא קיים לו שום מנגנון סנכרון**.

## איך הגענו לזה

team_00 הורה ל-team_110 לסגור את פער ה-Iron Rule #1 על S005 (ולידציה חוצת-מנוע ל-WP-S5-01/02 — הושלם,
2× PASS). תוך כדי, ניסינו להפיק הנדאוף קאנוני ל-WP-S5-03 דרך `prompt-generate` — וקיבלנו שלד ריק-מתוכן
(`(work package details unavailable)`). חקירה הובילה ל-roadmap שה-API מגיש, ומשם לשורש.

## הממצא (מאומת חי, לא השערה)

### 1. ה-API מגיש roadmap מ-S002 — עם 200, לא עם שגיאה
```
GET /api/system/health          → db: online, mode: online
GET /api/l0/eyalamit/roadmap    → HTTP 200
    active_milestone : S002        ← קובץ ה-SSoT אומר S005
    work_packages    : 24          ← קובץ ה-SSoT מחזיק 81
    WP-S5-* present  : NONE        ← ה-API לא מכיר אף WP של S005
```
לשם השוואה, ה-file-SSoT בספוק: `active_milestone: S005`, **81** work packages.

### 2. השורש — ה-endpoint קורא **filesystem**, לא טבלאות DB
הרישום בהאב (`_aos/projects.yaml`) נושא לכל פרויקט **`local_path`** ו-**`server_path`**:
```yaml
id: eyalamit
local_path:  /Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026
server_path: /data/projects/eyalamit
```
ה-API רץ על השרת (`100.125.98.56:8092`) ולכן קורא את `server_path`. ההוכחה שזה filesystem ולא DB — השגיאה
שמוחזרת לפרויקטים ללא checkout בשרת:
```
GET /api/l0/microgreens/roadmap → 404 {"code":"NOT_FOUND","message":"Project root not found: neither local_p…"}
```
**כלומר: «ה-DB לא מולא ב-S003/S004/S005» הוא ניסוח שגוי. אין כאן טבלת roadmap ב-DB בכלל בנתיב הזה —
יש קריאת קובץ מ-checkout.**

### 3. ה-checkout בשרת תקוע — ואין לו מנגנון סנכרון
```
/data/projects/eyalamit
  HEAD    : 8270d98  2026-05-29   "docs(handoff): S002 content-inputs session completion report (team_100)"
  branch  : main
  remote  : git@github.com:WaldNimrod/EyalAmit.git      ← נכון
  dirty   : 0 modified files                            ← נקי, שום דבר לא חוסם pull
  behind  : 450 commits behind origin/main              ← ~7 שבועות
  roadmap : active_milestone=S002, 29 WPs
```

**זה לא fleet-wide** — לשם השוואה:
```
/data/projects/smallfarmsagents
  HEAD    : d5b7ab6  2026-06-05
  behind  : 0 commits behind        ← מסונכרן
```

**וזה הליבה:** בשרת קיים `tiktrack-bare-sync.timer` (systemd) — כלומר **מנגנון סנכרון per-project קיים
ומוכר** — אבל **ל-eyalamit לא קיים אף timer/cron של pull/sync**. לא נמצא שום job שמושך את
`/data/projects/eyalamit`. ה-checkout נקי, על ה-remote הנכון, על main — הוא פשוט **מעולם לא נמשך** מאז 2026-05-29.

## ההשלכות (2 מערכות שבורות בשקט — זו הסיבה ל-severity HIGH)

1. **ADR034 «DB online → API-only mutations» לא בטוח בספוק הזה.** ה-health probe מחזיר `db: online`, ולפי
   Iron Rule #7 סוכן אמור לנתב מוטציות מבניות דרך ה-API. אבל ה-API מגיש עולם מ-S002 שאינו מכיר את
   WP-S5-*. **מוטציה דרך ה-API הייתה כותבת לאובייקט הלא-נכון.** בפועל, שלוש אבני-דרך (S003, S004, S005)
   נסגרו דרך ה-fallback של ADR034 R8 (file-SSoT) — כל אחת בנפרד, בשקט, בלי שאף אחד זיהה את השורש המשותף.
2. **`prompt-generate` מייצר הנדאופים ריקי-תוכן.** כי ה-wp_id לא קיים ב-roadmap שהוא קורא, כל הנדאוף מאז
   S003 חוזר עם `(team details unavailable)` / `(work package details unavailable)`, ומחייב «spoke supplement»
   ידני. עד היום זה יוחס בטעות ל-`project=agents-os` — **טעות**: העברנו `project_id=eyalamit` המפורש והשלד
   עדיין חזר ריק. השורש הוא ה-checkout התקוע.
3. **הנימוק המתועד בקוד מיושן — ומטעה לרעה.** `_aos/roadmap.yaml` (L56-58) מנמק את ה-file-SSoT ב:
   *"full GET hangs http=000, probed 2026-07-15"*. **זה כבר לא נכון** — ה-endpoint מחזיר 200. כלומר המצב
   הידרדר מ«שבור ורועש» ל«**עונה יפה ומחזיר נתונים שגויים בשקט**», שזה גרוע יותר.

## מה אנחנו מבקשים מ-team_120

אתם ה-Ambassador — propagation, drift-audit, ו-`_aos/` write-authority על פני הצי, ו-scope
`universal (DB-authoritative per ADR034)`. הנושא הזה הוא בדיוק בליבת ה-mandate שלכם, ומעבר לסמכות של team_110
(אנחנו לא כותבים ל-`_aos/`, ואין לנו סמכות על השרת או על ADR034).

**בבקשה בחנו לעומק והחזירו הכרעה — או תקנו מהצד שלכם:**

1. **למה ל-`/data/projects/eyalamit` אין מנגנון סנכרון?** `tiktrack-bare-sync.timer` קיים — האם זה per-project
   ad-hoc, או שיש קאנון שאמור לכסות כל ספוק ו-eyalamit נשמט ממנו? **האם ספוקים נוספים בצי נשמטו באותה דרך?**
   (בדקנו רק eyalamit מול smallfarmsagents — בדיקת-צי מלאה היא אצלכם.)
2. **מה התיקון הנכון בשורש** — (א) timer/cron ייעודי שמושך את `/data/projects/eyalamit`, בתבנית של tiktrack;
   (ב) שינוי ה-endpoint כך שיקרא מ-DB ולא מ-checkout; (ג) hook ב-CI/push שמסנכרן; או (ד) רישום פורמלי של
   הספוק כ-file-SSoT? יש כאן החלטת-ארכיטקטורה שאינה שלנו.
3. **מה עושים עם ADR034 בינתיים?** כרגע ה-health probe אומר `online` ומנחה סוכנים ל-API-only, בעוד ה-API
   מגיש נתונים שגויים. **זו מלכודת פעילה לכל סוכן שייכנס לספוק הזה ויציית ל-Iron Rule #7 כפשוטו.** האם צריך
   guard (למשל ה-health/roadmap endpoint יחזיר אזהרת-staleness אם ה-checkout מפגר), או הנחיה מפורשת בקאנון?
4. **`prompt-generate` — האם צריך fallback?** כרגע כשה-wp_id לא נמצא הוא מחזיר 200 עם placeholders
   («unavailable») במקום שגיאה. זה מייצר הנדאופים שנראים תקינים אך ריקים. **עדיף שיכשל ברעש** מאשר יחזיר שלד
   מטעה — שקלו זאת כתיקון נפרד, שרלוונטי לכל הצי ולא רק לנו.

## מה כבר עשינו בצד שלנו (כדי שלא תחזרו על העבודה)

- אימתנו את השורש חיה: git HEAD/behind/remote/dirty בשרת; השוואה מול smallfarmsagents; חיפוש timers/crons.
- **לא נגענו** בשרת, ב-`_aos/`, ולא הרצנו pull — מחוץ לסמכות team_110. ה-checkout נקי, כך ש-`git pull`
  אמור להיות טריוויאלי, אבל ההחלטה והביצוע שלכם.
- העלינו את הנושא ל-team_100 להכרעה מקומית ב-`ROUTING-REQUEST-TEAM100-S005-REGISTRATION-2026-07-16.md` §4
  (שם ניסחנו את השורש **בטעות** כ«ה-DB לא מולא» — התיקון הוא המסמך הזה; §4 תוקן בהתאם).
- ה-file-SSoT (`_aos/roadmap.yaml`) נשאר ה-SSoT החי של הספוק — אבל הנימוק המתועד צריך להתעדכן מ«GET hangs»
  ל«server checkout 450 commits behind, no sync mechanism».

## ראיות

| מה | פקודה / מקור |
|---|---|
| API מגיש S002 | `curl $AOS_API_BASE/api/l0/eyalamit/roadmap` → 200, `active_milestone=S002`, 24 WPs, 0× `WP-S5-*` |
| file-SSoT אמיתי | `_aos/roadmap.yaml` → `active_milestone=S005`, 81 WPs |
| endpoint קורא filesystem | `GET /api/l0/microgreens/roadmap` → 404 `"Project root not found: neither local_p…"` |
| רישום נתיבים | hub `_aos/projects.yaml` → `eyalamit.server_path=/data/projects/eyalamit` |
| checkout תקוע | `ssh waldhomeserver 'cd /data/projects/eyalamit && git log -1 --format="%h %ad"'` → `8270d98 2026-05-29`; `git rev-list --count HEAD..origin/main` → **450** |
| נקי, remote נכון | `git status --porcelain` → 0 שורות; `git remote get-url origin` → `git@github.com:WaldNimrod/EyalAmit.git` |
| ספוק בריא להשוואה | `/data/projects/smallfarmsagents` → `d5b7ab6 2026-06-05`, **0** behind |
| מנגנון סנכרון קיים לאחרים | `systemctl list-timers` → `tiktrack-bare-sync.timer`; **אין מקבילה ל-eyalamit** |
