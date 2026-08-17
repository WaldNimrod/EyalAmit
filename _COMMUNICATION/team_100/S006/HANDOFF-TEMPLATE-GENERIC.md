---
id: HANDOFF_TEMPLATE_GENERIC_S006_v3.0.0
schema_version: aos_v1_team_messaging
type: HANDOFF_TO_NEXT (team_100 → fresh team_100 session) · depth: full · reusable template
from: team_100 (S006 content-accuracy milestone)
to: team_100 (fresh session)
cc: [team_00, team_90, team_10, team_110]
date: 2026-08-17
law: S006-MILESTONE-CHARTER.md
disposition: >-
  TEMPLATE. This file is the reusable base, executed many times — once per page or page set.
  It is NOT a state document: every figure in it must be re-derived (§6). The live state lives
  in HANDOFF-CURRENT-S006.md, which this template tells you how to read but never trusts.
  v3.0.0 rebuilt onto the canonical AOS handoff skeleton (§0/§0.1/§5/§6) after two cross-engine
  adversarial reviews (Grok, lens A + lens B) returned FAIL twice on the invented structure.
status: ACTIVE — stage 1 in progress, desktop only
---

# HANDOFF → team_100 · S006 · תבנית קבועה

**כל הנתיבים יחסית לשורש הריפו. אל תעשו `cd`.**

## §0 — הצעד הראשון, לפני הכול

1. **היכנסו ל-plan mode. אל תשנו דבר** עד שקראתם את המסמך הזה במלואו.
2. **גזרו את העוגנים שלכם (§6).** 🔴 **אל תצטטו ולו מספר אחד מהמסמך הזה או מ-`HANDOFF-CURRENT`
   כמצב עדכני.** כל מספר כאן הוא קריאה של המסמך בקומיט שלו, ותו לא.
3. **קראו את קובצי המצב** (§6, טבלת המקורות) — קריאה בלבד.
   ⚠ **אל תפתחו את קובץ הסקירה של אייל בשלב הזה.** פתיחתו היא כבר קליטה, וקליטה היא ביצוע.
4. **הציגו סקואופ (§2) והמתינו לאישור מפורש.** התור נגמר עם ההצעה.

## §0.1 — מוסכמות קבועות

**במחלוקת בין מסמכים:** האמנה › התבנית הזו › `HANDOFF-CURRENT` › זיכרון סשן.
🔒 **כל כלל מחייב מנוסח באמנה בלבד. התבנית מפנה אליו ואינה משכפלת.**
אם מצאתם כלל שמנוסח פעמיים — זו דריפט; תקנו לפני עבודה, אל תבחרו את הנוסח הנוח.

| כלל | השם האנושי — תמיד מוצמד |
|---|---|
| חוק התוכן | רק קיים-ללא-הערה · קבצים מאייל · טקסט מנימרוד |
| נעילת הסיווג | מקור מצוטט + בייטים מדויקים + פעולה אחת |
| אין תוכן = אין רכיב | לא מרנדרים ריק; הרשומה חיה בטרקר |
| מנוע ≠ בנאי | ברמת מזהה המודל, לא המשפחה |
| הפער אינו היתר | מצוי≠רצוי מכניס להיקף, לא הופך ל`ברור` |

---

## §1 — מה סגור (גזרו מ-`HANDOFF-CURRENT` §ב.1, ואמתו מול הטרקר)

`HANDOFF-CURRENT-S006.md` הוא **הצהרת הסשן הקודם**, לא אמת. הטרקר הוא האמת.
עמוד נחשב סגור רק כשעמודת האנוש בטרקר קוראת `אושר ע״י אייל`.

## §2 — שער הסקואופ — נעילה, לא נימוס

```
שלב פעיל: <1 / 2 / 3>
עמוד מוצע: <שורה אחת + נתיב>          ← ברירת מחדל: עמוד אחד בלבד
מקור החומר: <קובץ הסקירה / תיקיית תוכן / אין>
פתוח מהסשן הקודם על העמוד: <סעיפים>
מחוץ לסקואופ: מובייל (שלבים 1-2) · קבצים משותפים · פרמלינקים · מדיה · תיקוני קוד
```

**האישור היחיד:** `סקואופ אושר: <שורות> בלבד` — מנימרוד, בכתב.
**רק אחריו יוצאים מ-plan mode** ומתחילים §3.
«יאללה» · «תמשיך» · «אוקיי» · שתיקה · הודעה על נושא אחר — **אינם אישור**.
**אסור לבצע באותו תור שבו הצעתם.**

| נראה כאישור | למה לא |
|---|---|
| `HANDOFF-CURRENT` §ב.2 «העמודים הבאים» | נכתב ע״י **הסוכן הקודם**. תור מוצע, לא מנדט |
| `tracker_guard --mode ingest` שמדפיס שינויים | מראה **מה השתנה**, לא מה מותר |
| «תמשיך ב-S006» בהודעת הפתיחה | מרשה **להציע**, לא לבצע |
| טאב קיים בטרקר לעמוד | טאב אינו אישור לעבוד עליו עכשיו |

---

## §3 — המשימה: מחזור עמוד. כל שלב הוא שער.

**3.1 קליטה** — קובץ הסקירה (מצוי / רצוי / הערות) + תיקיית החומר.
`מקור החומר: אין` → **ברירת מחדל: לא לפתוח את העמוד.** סריקה כלשהי מחייבת אישור נפרד.

### 🔒 3.2 נעילת הסיווג — **קראו באמנה, §3א**

**הנעילה מנוסחת במקום אחד בלבד:** `S006-MILESTONE-CHARTER.md` §3א.
**התבנית הזו אינה משכפלת אותה במכוון** — שני עותקים נסחפו זה מזה ונפסלו בביקורת.

בקצרה, ורק כתזכורת — **הנוסח המחייב הוא באמנה**: `ברור` דורש שלושה תנאים **יחד** —
מקור מצוטט (תא/שורה, לא תיקייה) · בייטים מדויקים מאותו מקור · פעולה אחת.
**הערה או פער מצוי≠רצוי מכניסים להיקף — ואינם מספיקים לסיווג `ברור`.**

**3.3 טאב לעמוד** — `python3 scripts/tracker_page_tab.py --create <ROW> --items /tmp/items.json`
סכימת הפריטים: `ITEM_HEADERS` ב-`scripts/tracker_schema.py`.
דוגמה עובדת: `_COMMUNICATION/team_100/S006/tracker/latest-items.csv`.

**3.4 ביצוע — ליין בנייה. team_100 לא כותב תוכן ולא בודק בעצמו.**
**ערוץ הכתיבה היחיד:** `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/<page>-defaults.php`
**אסור:** wp-admin · ACF · DB · `inc/data/*.json` · קובץ defaults של **עמוד אחר**.
**אין קובץ defaults לעמוד?** → עצור ואסקלץ. אל תמציא נתיב.

**3.5 פריסה** — `python3 scripts/ftp_deploy_site_wp_content.py` (סטייג'ינג בלבד)
נגעתם ב-CSS/JS → **העלו `Version` ב-`site/wp-content/themes/ea-eyalamit/style.css` לפני הפריסה.**
mu-plugin חדש → **הוסיפו לרשימה בסקריפט הפריסה**, אחרת לא ייפרס בשקט.

**3.6 אימות — מנוע ≠ הבנאי, ברמת מזהה המודל**
```bash
scripts/run_cross_engine_validator.sh <prompt-file> <model> "$PWD" <out-file>
```
**ארבעת סעיפי חוזה המאמת — חובה בכל מנדט אימות:**
1. **התאמת מקור** — כל מחרוזת חדשה חייבת להימצא **במקור המצוטט**. אחרת FAIL.
2. **האנק לא ממופה** — שינוי קוד שאינו ממופה לסעיף בטאב → FAIL.
3. **Provenance** — מחרוזת שהשתנתה בלי הערת מקור → FAIL.
4. **פלט ריק = FAIL.** העטיפה אוכפת (exit 3) — אל תעקפו.

**אסור** לתת למאמת מחרוזת שהבנאי כתב ולבקש אישוש. תנו לו את **המקור** ובקשו התאמה.
**FAIL → ליין תיקון חדש.** אין «כמעט עבר». team_100 קורא verdict בלבד.

**3.7 רישום**
```bash
python3 scripts/tracker_page_tab.py --update <ROW> <ITEM> --set "סטטוס סעיף=בוצע"
python3 scripts/tracker_update.py --row <ROW> --set "ראיות QA=<artifact>"
python3 scripts/tracker_update.py --refresh-waiting
python3 scripts/tracker_guard.py --mode verify
python3 scripts/tracker_snapshot.py
git add <נתיבים מפורשים>    # לעולם לא -A כשליין רקע פעיל
git commit
```

**3.8 תנאי יציאה — כולם, אחרת העמוד לא מוגש לאייל**
verdict PASS · אפס רכיבים ריקים · `Version` הועלה אם נגעתם ב-CSS/JS · הטאב מלא ·
`tracker_guard --mode verify` נקי · עץ נקי.

**3.85 נעילת הקובץ ושליחה לאייל**
לפני חלון כתיבה לטרקר: `python3 scripts/tracker_update.py --acquire-lock` · בסיום `--release-lock`.
**העמוד מגיע לאייל דרך הסטייג'ינג החי בלבד** — לא markdown, לא צילומי מסך, לא הדבקה בצ'אט.
**גלגול לאחור:** כל שינוי הוא קומיט נפרד בנתיבים מפורשים; חזרה = `git revert <sha>` + פריסה מחדש.

**3.9 סגירה** — רק כש**אייל** כתב `אושר ע״י אייל` בעמודת האנוש:
`python3 scripts/tracker_page_tab.py --hide <ROW>` · «יפה» בצ'אט אינו אישור.

---

## §4 — גבולות שלעולם אינם בסקואופ של עמוד

| | למה |
|---|---|
| **קבצים משותפים** — header · footer · nav · `parts/*.php` · `inc/data/*.json` · CSS גלובלי · **`*-defaults.php` של עמוד אחר** | עמוד אחד שובר עמוד אחר שכבר ממתין לאייל |
| **פרמלינקים / slugs / 301** | קבועים אחרי עלייה לאוויר |
| **מדיה** — בחירה, ייצור, alt | שלב 3, או `לא ברור` |
| **תיקוני קוד** | סשן תוכן לא מתקן קוד → `CODE-BLOCKED-REGISTER.md` |
| **מובייל** בשלבים 1-2 | שלב 3 |

נדרש אחד מאלה? **עצור · רשום · אסקלץ** — גם אם זה «תיקון של דקה».

---

## §5 — לקחי מכשור. אלה השיטה, והם מחייבים.

**5.1 — כלי בדיקה שנכשל OPEN הוא כלי שמאשר כשל.** `qa_probe` בודק גלישה אופקית, מחרוזות
אסורות וכותרת ריקה — **ותו לא**. הוא אינו בודק טקסט חתוך, תוכן חסר או נכונות. **PASS שלו
אינו אישור תוכן.** אימות תוכן = ליין מאמת עם ארבעת סעיפי §3.6.

**5.2 — מדידה מול מטמון היא מדידה של אתמול.** נמדדו 18 ציטוטים חתוכים; הקוד היה תקין
והדפדפן הגיש CSS ישן כי `Version` לא הועלה. **כל מדידה חייבת cache-bust, וכל פריסה שנוגעת
ב-CSS/JS חייבת להעלות `Version`** — אחרת הסוקר האנושי מאשר עמוד ישן.

**5.3 — מנדט רחב מדי מחזיר פלט ריק, ופלט ריק נראה כמו PASS.** מנדט על ~400KB HTML נכשל
פעמיים. **ליין ממוקד לכל נושא**, וריק תמיד FAIL.

**5.4 — `git add -A` בזמן ליין רקע בולע עבודה של סוכן אחר.** קרה: קומיט תיאר משהו אחד ובלע
13 קבצים של ליין אחר. **תמיד נתיבים מפורשים.**

**5.5 — הקאנון מתיישן מתחת לרגליים.** מזהי מודלים שהקאנון נוקב בהם אינם קיימים ב-CLI החי.
**קראו מזהים חי** (`cursor-agent --list-models`) ודווחו דריפט ל-`_COMMUNICATION/team_120/`.

**5.6 — מלכודות מדידה שיש לתת למאמת מראש, בלי המסקנה:** הקרוסלה מדפיסה כל כרטיס **פעמיים**
(לספור אנשים ייחודיים) · TLS של סטייג'ינג פג **בכוונה** (`-k` מול הסטייג'ינג בלבד) ·
FTP נעול לפי IP (טיימאאוט = לבקש פתיחה, לא לתחקר):
https://my.upress.co.il/account/websites/eyalamit-co-il-2026.s887.upress.link?tab=development

---

## §6 — עוגנים. גזרו כל אחד מחדש.

🔴 **אין להעתיק ולו ערך אחד מהעמודה הימנית כמצב עדכני.** היא הקריאה של המסמך בזמנו.

| עוגן | פקודה | הקריאה של המסמך הזה |
|---|---|---|
| HEAD | `git rev-parse --short HEAD` | *גזרו* |
| עץ נקי | `git status --porcelain` | חייב להיות ריק · מלוכלך = עצירה ושאלה |
| שער AOS | `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` | *גזרו* — 3 כשלי גברנס ידועים קיימים גם על עץ נקי |
| שורות סבב 1 | `grep -c 'סבב-1-ליבה' _COMMUNICATION/team_100/S006/tracker/latest.csv` | *גזרו* |
| שורות סבב 2 | `grep -c 'סבב-2' _COMMUNICATION/team_100/S006/tracker/latest.csv` | *גזרו* |
| סעיפים פתוחים | `python3 scripts/tracker_update.py --refresh-waiting` ואז מיון לפי «ממתין ל» | *גזרו* |
| טאבי עמודים | `python3 scripts/tracker_page_tab.py --list` | *גזרו* |
| מודלים חיים | `cursor-agent --list-models` | *גזרו* — אל תקודדו מזהה קשיח.
⚠ **וריאנט `-fast` אסור ללא בקשה נקודתית של team_00** (חריגה מתועדת קיימת ל-Grok) |
| סטייג'ינג חי | `curl -sk -o /dev/null -w '%{http_code}' http://eyalamit-co-il-2026.s887.upress.link/` | *גזרו* |

**מקורות שיש לקרוא (§0.3):**
`_COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md` · `EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx` ·
`_COMMUNICATION/team_100/S006/HANDOFF-CURRENT-S006.md` · `_COMMUNICATION/team_100/S006/CODE-BLOCKED-REGISTER.md` ·
`_aos/roadmap.yaml` (סוף `project.notes`) · מפל המנועים: `../agents-os/core/config/routing_policy.yaml`

---

## §7 — סגירת סשן

1. עדכנו את `_COMMUNICATION/team_100/S006/HANDOFF-CURRENT-S006.md` — סגור · הבא בתור ·
   ממתין לאייל · ממתין לנימרוד · חוב.
2. `tracker_guard.py --mode verify` → `tracker_snapshot.py` → commit נקי.
3. דווחו לנימרוד: מה נסגר · מה ממתין לו · מה ממתין לאייל.
4. **ב-~80% קונטקסט — עצרו והעבירו.** אל תתחילו עמוד שלא תספיקו לסגור.
