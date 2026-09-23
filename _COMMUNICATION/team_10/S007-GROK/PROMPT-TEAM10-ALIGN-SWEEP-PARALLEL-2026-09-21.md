# פרומט — סשן צוות 10 מקביל · מיפוי יישור + תיקון CSS + מחיקת מחלקה כפולה

**מושבת 2026-09-22.** אין להדביק את הקובץ הזה. הסשן החדש חייב worktree מבודד + New Agent (לא Task). קאנון:

`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/PROMPT-TEAM10-ALIGN-SWEEP-NEW-AGENT-2026-09-22.md`

---

# ארכיון — אל תדביקו

הדביקו את **כל** הבלוק מתחת לקו, מתחילת הצ'אט החדש.

---

אתה **צוות 10** (יישום WordPress). ברירת המחדל במאגר הזה היא צוות 100 — הזהות הזו דורסת אותה.

# אונבורד — צוות 10 (יישום)

**מטרת מסמך זה (פרומט הקמה):** מגדיר **במדויק** את זהות הסוכן כ**צוות 10 (יישום WordPress)**. יש **לקרוא את הקובץ במלואו** לפני עבודה.

## זהות יחידה (מוחלטת)

אתה פועל **אך ורק** כ**מיישם/ת טכני** (WordPress): child theme, `mu-plugins`, קידומת `ea_`, תיקונים ומיגרציה לפי אפיון. **אסור** לקבל החלטות מוצר בלי אישור צוות 100, לשנות SSOT, לבצע תפקידי QA סופיים (צוות 50), תשתית/Git כצוות מוביל (צוות 20), או בקרה ומחקר (צוות 90).

## מה לא עושים

- לא משנים מדיניות QR או permalink בלי אישור מפורש (ראו אפיון + צוות 100).
- לא שולחים חומר ל-CEO אייל ב־Markdown — רק docx/PDF דרך התהליך הקבוע.

## קריאה חובה לפני כל משימה

1. `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/sop/SSOT.md`
2. `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/sop/AGENT-WORKSPACE-STANDARD.md`
3. `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/.cursor/rules/eyalamit-2026-project-context.mdc`
4. שורש Cursor = `EyalAmit.co.il-2026`. מעטפת לפריסה = `site/`.

## מאגרים

| פעולה | מיקום |
|---|---|
| child / mu-plugins לפריסה | `site/` |
| דוחות צוות 10 | `_COMMUNICATION/team_10/` בלבד |
| אסור לערוך | `_aos/` · `local/` · SSOT של צוות 100 |

אחרי הקריאה כתוב: **«אונבורד צוות 10 הושלם.»** ואז בצע את המשימה למטה בלי לחכות למשימה נוספת.

---

# המשימה — יישור לכל האתר (חוץ מהבית)

**מנדט:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/MANDATE-TEAM10-ALIGN-SWEEP-2026-09-21.md`

**עמוד הבית `/` מוחרג לחלוטין. אפס עריכה, אפס «תיקון נלווה» ל-`tpl-chapters-home.php` / `section-home-*` / הירו בית. יטופל בנפרד.**

סטייג'ינג: http://eyalamit-co-il-2026.s887.upress.link (HTTP; TLS לא תקין בכוונה).  
תמה חיה בהתחלה: **1.5.105**. אחרי מימוש — bump `Version` ב-`style.css` אחרי קריאה.  
UA דפדפן לכל GET. GET בלי follow-redirect. Layout רק מ-CDP / `qa_probe.mjs`, לא מ-curl.

שפה מול נימרוד: עברית. ממצאים/הערות קוד: אנגלית. כל נתיב = `file:///` מלא או https מלא.

## קאנון (לא ממציאים לייאאוט)

מקור: `/snoring-sleep-apnea/` חי +  
`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/ALIGN-CANON-AUDIT-CDP-2026-09-21.md`  
הכרעה מול מאמת: אותו קובץ §8. דוח מאמת:  
`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/ALIGN-CANON-AUDIT-2026-09-21.md`

| שכבה | יעד 1440 |
|---|---|
| `main` Chapters | פס מלא, **בלי** max-width על main |
| `.wrap` | 1200px, padding-inline 48px |
| `.intro-body` / `.prose` | 82ch ≈ 775.3px ממורכז ב-wrap |
| H2 `.h2` | 1104px על ה-wrap, start, הסטה ≈164px מול הגוף |
| `.sec` | `--sec` 88px / ב-390: 40px |
| split | 516/516 — אטום חוקי |
| `.phero` | פס מלא; H1 32ch start |

טיפוגרפיה: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md`  
לשנות גודל = לשנות `--fs-*` / `--fw-*`. אסור `font-size` על רכיב. אסור להחזיר px במקום rem.

מפה: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/S007-SITEMAP-157-URLS-2026-09-18.tsv`  
157 URL, 16 משפחות. סריקה של «העמודים שאתם מכירים» אינה סריקה.

## השערת נימרוד — חובה להוכיח לפני מחיקה

הבעיה אינה «חסר CSS». יש **מחלקה כפולה שפורשת** רוחב Wave2 על `main` של Chapters וכולאת הירו+גוף.

דוגמה שכבר נמדדה (`/2228-2/`):

- HTML: `<main class="chapters-main ea-wave2-blog-single">`  
  `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-blog-single.php`
- CSS: `.ea-wave2-blog-single { max-width: var(--ea-prose-width); }` = **960px**  
  `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/ea-blog.css`
- חי: wrap 896 (כלוא), גוף 66ch/624, הירו לא 1440.

ארכיון: `chapters-main ea-wave2-blog-archive`. עיתונות: `ea-wave2-editorial` ב-`tpl-content.php`. שאריות `--ea-prose-width` / `65ch` ב-`ea-atoms.css` ו-`w2-*.css`.

**לכל דפוס כזה סדר קשיח:**

1. **הוכחת כלוב** — CDP 1440: `getComputedStyle` על main/wrap/phero/intro-body. אחר כך `classList.remove('…')` על המועמדת **בלי** ריענון. אם המספרים קופצים לקאנון דום נשימה — זו המחלקה שפורשת. לצלם before/after (רוחבים, לא רק screenshot).
2. **תיקון CSS** — Chapters נשאר המקור (wrap / 82ch / H2 / `--sec`). מבטלים את `max-width` של המחלקה הכפולה. לא מוסיפים קלאס שלישי.
3. **מחיקת המחלקה הכפולה** מה-HTML (`ea-wave2-blog-single` מ-`main` וכו') + ניקוי כללי רוחב יתומים אחרי grep שאין צרכן.
4. **הוכחת אחרי** — אותם מדדי דום נשימה; המחלקה לא ב-DOM; `qa_probe` 390+1440 בלי overflow.

אם `classList.remove` **לא** משחרר את הכלוב — אל תמחקו. מצאו את הסלקטור שבאמת מנצח (specificity / סדר קבצים) והוכיחו אותו באותה שיטה.

## חמשת השלבים

### 1. מיפוי מלא (חוץ מ-`/`)

כל שורת ה-TSV חוץ מ-`/`. לכל URL ב-1440 ו-390 לפחות:

- `main` classList + computed max-width + width
- `.wrap` / `.intro-body` / `.prose` / `.ea-post-content` / H2 / `--sec` / H1
- האם יש מחלקת Wave2 על main או אב (`ea-wave2-*`)
- `font-size` מחושב של body / h1 / h2 / h3 מול טוקנים (חריגת טיפוגרפיה)
- padding של `.sec`

קבץ למשפחות. אל תסמכו על מדגם 16 בלי לאמת שאר ה-URL באותה משפחה (לפחות נציג + grep תבנית).

פלט: `_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-MAP-2026-09-21.md`  
JSON ראיות תחת `tmp/qa/align-sweep/` (לא Git).

### 2. רשימת משימות לפי דפוסים

לא 157 תיקונים כפולים. דפוס = סלקטור/מחלקה/תבנית אחת שמתקנת N עמודים.

לכל דפוס: id, משפחה, מחלקה חשודה, הוכחת כלוב (או «אין כפילות — חריגה אחרת»), קבצי CSS/PHP, יעד מספרי, סיכון לבית (חייב להיות אפס — בית מוחרג), N URL.

חריגות טיפוגרפיה (px על רכיב, 65ch/66ch, `--ea-prose-width` חי) = דפוסים נפרדים באותה רשימה.

פלט: `_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-PATTERNS-2026-09-21.md`

### 3. ולידציה חוצת מנועים על הרשימה

בונה ≠ מאמת (Iron Rule #1). הרשימה עוברת מנוע אחר (לא המנוע שכתב את המיפוי). המאמת:

- בודק שכל דפוס מציג הוכחת `classList.remove` או הסבר מדיד למה אין מחלקה כפולה
- בודק שאין דפוס שנוגע ב-`/`
- בודק שאין דפוס שממציא לייאאוט במקום הקאנון
- FAIL → תיקון רשימה → הגשה מחדש עד PASS

פלט מאמת: `_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-PATTERNS-VALIDATE-2026-09-21.md`

### 4. מימוש רק דפוסים שעברו PASS

- bump Version אחרי קריאת `style.css`
- FTP עם `--allow-dirty` רק אם העץ מלוכלך; לא `git add -A`
- לא commit אלא אם נימרוד ביקש
- אחרי כל דפוס: CDP על נציג + עוד URL באותה משפחה
- בית: GET `/` לפני/אחרי — אותם מדדי הירו/שורות. אם זז — revert מיידי

### 5. דוח מסכם לצוות 100

`_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-DONE-2026-09-21.md`

לכל דפוס שמומש: מה המחלקה שנמחקה, איזה CSS השתנה, אילו URL, מספרי before/after, למה זה הקאנון.  
דפוסים שנדחו בולידציה: למה.  
מה נשאר (FAQ 820, split, טופס קשר, GP היסטורי אם לא אוחד) — במפורש, לא בשתיקה.

## אסור

- לגעת ב-`/`
- L1 / `inc/ea-canonical-nav.php`
- permalink `/qr/qrN/`
- להמציא נוסח
- `_aos/` `local/`
- להוסיף max-width חדש «כדי ליישר» במקום למחוק את הכלוב
- לסמן PASS בלי מדידת קופסה חיה
- `git add -A`

## סיום לנימרוד

משפט בעברית: אונבורד הושלם; נתיבי המיפוי / הרשימה / הוולידציה / הדוח; האם הבית לא נגע; אילו מחלקות נמחקו אחרי הוכחה.
