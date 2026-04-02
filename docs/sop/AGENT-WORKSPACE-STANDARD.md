# תקן סביבת סוכני AI — Cursor (מחייב לכל האגנטים בפרויקט)

**גרסה:** 1.3 · **סטטוס:** ACTIVE — חל על כל עבודת Cursor/AI במסגרת EyalAmit.co.il-2026  
**מסמכי בסיס נלווים:** [`AGENTS.md`](../../AGENTS.md) · [`docs/PROJECT-ENTRY.md`](../PROJECT-ENTRY.md) · [`docs/sop/SSOT.md`](SSOT.md)

---

## 1. מטרה

לאחד **כלים**, **כללים** ו**סדר פעולות** כך שכל סוכן (או מפתח אנושי) יעבוד באותה שפה: וורדפרס לפי אפיון הפרויקט, מאגר 2026 כשורש עבודה, ואימות מול סטייג'ינג כשהמשימה דורשת אתר חי.

---

## 2. שורש workspace (חובה)

| דרישה | פירוט |
|--------|--------|
| **תיקיית הפרויקט הפתוחה ב-Cursor** | **`EyalAmit.co.il-2026`** (שורש המאגר), **לא** רק תיקיית האב `Eyal Amit`. |
| **סיבה** | כך נטענים `.cursor/rules/`, `.cursor/skills/`, והמלצות `.vscode/`. |

אם נפתח רק התיקייה הרחבה — ראו [`docs/WORKSPACE-POINTER.md`](../WORKSPACE-POINTER.md).

---

## 3. הרחבות Cursor / VS Code (מומלץ — יש להתקין)

### 3.1 איפה ההמלצות נשמרות

הקובץ **`EyalAmit.co.il-2026/.vscode/extensions.json`** (בתוך המאגר, ליד שורש הפרויקט). Cursor קורא אותו **רק** כשפותחים את התיקייה **`EyalAmit.co.il-2026`** כ־**Open Folder** (לא את תיקיית האב `Eyal Amit` בלבד).

### 3.2 איך מתקינים (אנושי או לפי הוראה למשתמש)

1. פתחו ב-Cursor: **File → Open Folder…** ובחרו את התיקייה **`EyalAmit.co.il-2026`**.
2. אחת מהדרכים הבאות:
   - אם מופיעה **התראה בתחתית החלון** על *Workspace Recommendations* / *הרחבות מומלצות* — ללחוץ **Install** / **Install All**.
   - **Command Palette:**  
     - macOS: **⌘⇧P**  
     - Windows / Linux: **Ctrl+Shift+P**  
     הקלידו: **`Extensions: Show Recommended Extensions`** (או בעברית אם הממשק מתורגם: הרחבות מומלצות ל-workspace) ואשרו.  
     בחלון שייפתח — **Install** לכל הרחבה ברשימה (או Install All אם מוצג).
   - **סרגל צד Extensions** (אייקון הרחבות) → בשדה החיפוש הקלידו **`@recommended`** — יוצגו ההמלצות של הפרויקט; התקינו כל אחת.

3. לאחר התקנה: **Reload Window** אם Cursor מבקש.

### 3.3 מה המאגר מגדיר (קנוני) — `.vscode/extensions.json`

אלה הרחבות ה־**workspace** של הפרויקט (מופיעות ב־**@recommended** יחד עם דברים ש־Cursor מציע מעבר).

| הרחבה | מזהה | למה זה עוזר בפרויקט שלנו |
|--------|------|---------------------------|
| **PHP Intelephense** | `bmewburn.vscode-intelephense-client` | PHP ב־`site/`, סקריפטים — השלמות, קפיצה להגדרה |
| **EditorConfig** | `EditorConfig.EditorConfig` | מיישם אוטומטית את [`.editorconfig`](../../.editorconfig) (רווחים, סוף שורה) |
| **PHP Debug** | `xdebug.php-debug` | נקודות עצירה ב־PHP **רק** כש־Xdebug פעיל בקונטיינר/PHP; יש [`launch.json`](../../.vscode/launch.json) «Listen» בפורט 9003 |
| **GitLens** | `eamodio.gitlens` | היסטוריית שורות, blame, השוואת קומיטים — שימושי לצוות ולסוכן שמסביר שינויים |

ב־`extensions.json` מוגדר גם **`unwantedRecommendations`** ל־**Git History** (`donjayamanne.githistory`) — **כפילות** מול GitLens; לא צריך את שני התוספים.

### 3.4 למה ב-Cursor מופיעות לפעמים ~8 המלצות (כמו בצילום המסך)

Cursor (וגם VS Code) יכולים להציג **מיזוג** של:

1. מה שב־**`.vscode/extensions.json`** של המאגר (למעלה), ו־
2. **המלצות נוספות** של Cursor / פרופיל משתמש / זיהוי סוג פרויקט.

הטבלה הבאה מתייחסת בדיוק לשמונה שמופיעות לעיתים קרובות בממשק; **לא כולן נחוצות** לפרויקט Eyal Amit:

| הרחבה (כפי שמופיעה ב-Cursor) | האם נחוצה לנו? | הערה |
|-------------------------------|----------------|--------|
| **Rainbow CSV** | בדרך כלל **לא** | עוזרת אם עורכים הרבה CSV/TSV; למאגר הנוכחי — נדיר |
| **Git History** | **לא** (אם יש GitLens) | כפילות; המאגר מסמן אותה כ־unwanted מול GitLens |
| **GitLens** | **כן, מומלץ** | חלק מהרשימה הקנונית שלנו |
| **EditorConfig** | **כן** | חלק מהרשימה הקנונית |
| **PHP Intelephense** | **כן** | חלק מהרשימה הקנונית |
| **PHP Debug** | **כן אם מתכננים דיבוג PHP** | בלי Xdebug בשרת/קונטיינר ההרחבה כמעט לא בשימוש — ראו §3.5 |
| **npm Intellisense** | **אופציונלי** | עוזר ב־`import` מ־npm; יש מעט Node (סקריפטים תחת `.cursor/skills`) — לא ליבה |
| **Microsoft Edge Tools** | **אופציונלי** | חפיפה חלקית ל־**MCP דפדפן** לאימות אתר; אם כבר עובדים עם MCP — לא חובה |

**מסקנה מעשית:** להתקין בביטחון את **ארבעת** שב־`extensions.json`; את השאר **רק לפי צורך** — לא «Install All» עיוור על כל מה ש-Cursor מציג.

### 3.5 איך לא להשאיר הרחבות כ״אבן בתרמיל״

| הרחבה | מה צריך כדי שתהיה שימושית |
|--------|----------------------------|
| **EditorConfig** | כלום — עובד מול `.editorconfig` ברירת המחדל של המאגר |
| **Intelephense** | כבר מכוונן ב־[`.vscode/settings.json`](../../.vscode/settings.json) (`phpVersion` 8.3 לדוקר מקומי); אם עובדים בעיקר מול PHP 7.4 בסטייג'ינג בלבד — אפשר לעדכן גרסה בהתאם |
| **PHP Debug** | (1) **Xdebug 3** מוטמע בתמונת Docker המקומית — `local/Dockerfile.wordpress` + `local/xdebug.ini`; `docker compose build wordpress` אחרי שינוי בסיס PHP. (2) אופציונלי: bind-mount ל־`site/wp-content` ב־`docker-compose.yml` כדי שמיפוי ב־`launch.json` יתאים לקבצים במאגר — ראו [`local/README.md`](../../local/README.md) §PHP Debug. (3) **Run and Debug** → **Listen for Xdebug (PHP)** |
| **GitLens** | אופציונלי: להפעיל **File blame** / **Line blame** מהפקודות; אפשר לצמצם התראות בהגדרות GitLens אם מפריע עומס UI |

**סוכן AI:** אם המשתמש לא הבין איפה להתקין — הפנו לסעיף **3.1–3.2** כאן; אל תניחו שההרחבות כבר מותקנות.

**הערה:** אין להחליף את תקן הקוד (`ea_`, child/mu-plugins) בהמלצות של כלים חיצוניים; הם משלימים את העורך בלבד.

---

## 4. Cursor Agent Skills (חובת שימוש לפי הקשר)

כל הסקילים הנדרשים לפרויקט נמצאים ב-[`.cursor/skills/README.md`](../../.cursor/skills/README.md) (מקור מעודכן: מאגר [WordPress/agent-skills](https://github.com/WordPress/agent-skills)).

**חובה:** לפני משימה שקשורה לוורדפרס — לבחור ולקרוא את הסקיל המתאים (דרך מנגנון ה-Skills של Cursor), במיוחד:

| תחום | תיקיית סקיל | מתי |
|------|-------------|-----|
| סטייג'ינג uPress, FTP, `wp-config` | `eyalamit-staging-ftp` | פריסה, סנכרון סיסמת DB, נתיבים |
| תוספים, PHP, אבטחה | `wp-plugin-development` | קוד PHP מותאם, hooks |
| בלוקים, Block API | `wp-block-development` | בלוקים מותאמים, עורך בלוקים |
| תבניות בלוק / FSE | `wp-block-themes` | כשנוגעים ב-block themes / theme.json |
| REST API | `wp-rest-api` | אינטגרציות, endpoints |
| WP-CLI, תפעול | `wp-wpcli-and-ops` | פקודות CLI, חיפוש-החלפה בטוח |
| ביצועים | `wp-performance` | אופטימיזציה, מדידה |
| סטטי (אופציונלי) | `wp-phpstan` | ניתוח סטטי כשהופעל בפרויקט |
| מיפוי legacy | `wp-project-triage` | מאגר `eyalamit.co.il-legacy` |

עדכון סקילים מהupstream: הוראות בראש `README.md` של הסקילים.

---

## 5. MCP

### 5.1 דפדפן (חובה כשבודקים אתר / סטייג'ינג)

כאשר **MCP של הדפדפן** (cursor-ide-browser) זמין:

1. **`browser_tabs`** — לוודא טאב/URL לפני אינטראקציה.  
2. **`browser_navigate`** — לטעון את כתובת הסטייג'ינג או המקומי.  
3. **`browser_lock`** — לנעול טאב לפני קליקים/הקלדה (אחרי ניווט).  
4. **`browser_snapshot`** — לפני כל אינטראקציה; להבין מבנה DOM ו-ref.  
5. **`browser_unlock`** — בסיום כל סשן דפדפן באותו תור.

**לא** לנעול לפני שיש טאב פעיל. להעדיף המתנות קצרות + snapshot חוזר על טעינה/מטמון.

**שימוש טיפוסי:** אימות אחרי FTP (סטטוס HTTP, `noindex`, תבנית פעילה, שבירות JS — לפי נוהל QA).

### 5.2 שרתי MCP נוספים

אם בפרויקט הופעלו MCP אחרים (למשל Linear לניהול משימות), יש להשתמש בהם **למעקב ותיאום** — הם **לא** מחליפים את תקן הוורדפרס, הפריסה לסטייג'ינג, או את מסמכי ה-SSOT.

---

## 6. זרימת פיתוח WordPress (מקומי ↔ סטייג'ינג)

| שלב | היכן | הערות |
|-----|------|--------|
| עריכת קוד קנונית (child, mu-plugins) | מאגר תחת [`site/`](../../site/README.md) | עדיף לאמת מקומית ב-Docker לפי [`local/README.md`](../../local/README.md) |
| סגירת יחידת עבודה / אינטגרציה | סטייג'ינג uPress | פריסת קבצים: סקריפטים תחת `scripts/` (למשל `ftp_deploy_site_wp_content.py`) לפי סקיל `eyalamit-staging-ftp` |
| שינויי DB / תוכן | סטייג'ינג או WP-CLI / phpMyAdmin לפי נוהל | ראו [`_communication/team_20/DB-AND-PHPMYADMIN-WORKFLOW-2026-03-31.md`](../../_communication/team_20/DB-AND-PHPMYADMIN-WORKFLOW-2026-03-31.md) |

**עקרון:** הקוד וההיסטוריה במאגר; סטייג'ינג הוא מקור לאמת תצוגה מול שרת אמיתי ותוספים.

---

## 7. סקריפטים ופקודות — הרצה

- **חובה:** כשיש גישת shell בסביבת העבודה — להריץ סקריפטים (`python3`, `bash`, `docker compose`) **באמצעות הסוכן**, לא להסתפק בהנחיות "תריץ בעצמך" (כפי שמפורט ב-`AGENTS.md`).
- **סודות:** רק מקומיות ב־`local/staging.credentials.md` (ב־`.gitignore`); **לא** להדביק סיסמאות בצ'אט או במסמכים ב-Git.

---

## 8. כללי קוד ופרויקט (מזכירה קצרה)

- קידומת **`ea_`** לפונקציות/מחלקות/קבועים רלוונטיים; התאמות ב־**child theme** ו־**mu-plugins** בלבד — לא עריכת ליבה/תבנית אב/תוספי צד שלישי (הרחבה ב-SSOT §10).
- **מול אייל:** רק **docx/PDF**, לא Markdown.
- **תקשורת צוותים:** רק תחת `_communication/team_XX/` לפי [`_communication/README.md`](../../_communication/README.md).

---

## 9. סנכרון מסמך זה

שינוי בתקן זה חייב להתלוות בעדכון:

- [`AGENTS.md`](../../AGENTS.md) (קישור וסעיף קצר)
- [`docs/PROJECT-ENTRY.md`](../PROJECT-ENTRY.md) (שורה בטבלת סביבה)
- [`.cursor/rules/eyalamit-agent-workspace-mandatory.mdc`](../../.cursor/rules/eyalamit-agent-workspace-mandatory.mdc) אם משתנים כללי התנהגות חובה
- [`.vscode/extensions.json`](../../.vscode/extensions.json) ו־[`.vscode/launch.json`](../../.vscode/launch.json) כשמשנים הרחבות / דיבוג PHP

צוות 3 / Gatekeeper אחראי לוודא שהגרסה כאן תואמת את מה שמיושם בפועל ב-Cursor.
