# from-eyal — חומר שחוזר מאייל עמית

תיקייה ל**קבצים מקוריים** מהלקוח (Word, PDF, סריקות חתומות).

## פורמט קנוני לתוכן מדויק (סוכנים + צוות)

**מסמך מחייב להגדרת תוכן לפי עץ נעול ושדות תבנית:**  
[`CANONICAL-CONTENT-SUBMISSION-FROM-EYAL.md`](./CANONICAL-CONTENT-SUBMISSION-FROM-EYAL.md) — כולל טבלת כל עמודי ה־IA (`pageId` / `slug` / `templateId`), JSON תואם `content-intake.html`, Markdown עם `## field:…`, אינסטנסים (FAQ · גלריות · המלצות), והעברה דרך **Google Drive** לתיקייה זו.

**מסירה לאייל מתיקיית to-eyal:** עותק + `page-templates.json` + `site-tree.json` + קישור ישיר לשרת —  
[`../to-eyal/2026-04-06--content-submission-canonical-for-eyal/README.txt`](../to-eyal/2026-04-06--content-submission-canonical-for-eyal/README.txt).

**פלטת צבעי אתר (מחייבת):** [`../../EYAL-SITE-COLOR-PALETTE.md`](../../EYAL-SITE-COLOR-PALETTE.md) · עותק שקופית: [`../../reference/eyal-brand-palette-canva-slide-2026-04-06.png`](../../reference/eyal-brand-palette-canva-slide-2026-04-06.png).

**שלוש רמות מסירה (חובה להבחין):** [`PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md`](./PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md) — נוהל · דמו תבנית · תוכן מאושר מאייל.

**קליטת zip — תיקיית CONTENT (מזהים קנוניים):** [`CONTENT/README.md`](./CONTENT/README.md) — שש חבילות תוכן מאייל (`EYAL-CONTENT-PKG-*`), מניפסט לכל תיקייה, רישום ב־Hub ב־`deliverables.json`; מירור zip ל־`hub/dist` עם `--mirror-docs`.

- [`canonical_update_pack_2026-04-06/`](./canonical_update_pack_2026-04-06/README.md) — **נוהל בלבד** (מניפסט, `PROCEDURE-MANDATORY`). ללא מלל עמוד.
- [`poc_st-book-kushi_2026-04-06/`](./poc_st-book-kushi_2026-04-06/README.md) — בתוכה **שני סוגים:** קבצי `content--st-book-kushi.*` + JSON ישנים = **דמו סינתטי**; **`2026-04-06--st-book-kushi--content--from-eyal.md`** = **תוכן מאושר** ל־`st-book-kushi`.

**קבצים טריים:** אחרי zip — לסווג לפי המסמך למעלה; `verify_kushi_intake_poc_parity.py` בודק רק **התאמת דמו ישן ↔ HTML ישן**, לא את המסמך מאייל. פירוט: [`2026-04-02--INGEST-STATUS.md`](./2026-04-02--INGEST-STATUS.md).

## שם קובץ מומלץ

```text
YYYY-MM-DD--short-topic--from-eyal.ext
```

דוגמה למסמך «עץ אתר לנמרוד — שיקולי SEO · GEO · AEO»:

```text
2026-04-02--sitemap-nimrod-seo-aeo-geo--from-eyal.docx
```

## ייצואי JSON מה־Hub (עץ אתר / קליטת תוכן)

מ־**`site-tree.html`** ו־**`content-intake.html`** (אחרי בניית `hub/dist`) אייל יכול להוריד JSON (`eyal-site-tree-feedback`, `eyal-page-content-intake`). **אין העלאת קבצים דרך הדפדפן** — תוכן ארוך ב־**Drive**, ובטופס רק שם קובץ או קישור.

1. לשמור את קובץ ה־JSON כאן בשם מסודר, למשל:  
   `2026-03-29--site-tree-feedback--from-eyal.json`  
   או להעביר לצוות במייל — לפי מה שסוכם.  
2. אופציונלי: עותק נוסף תחת `hub/ssot/responses/` אחרי סקירה (ראו [`../../../../hub/EYAL-HUB-SSOT-WORKFLOW.md`](../../../../hub/EYAL-HUB-SSOT-WORKFLOW.md)).

## לאחר קליטת קובץ חדש

1. לשמור כאן את העותק הסופי.  
2. לעדכן את [`2026-04-02--INGEST-STATUS.md`](./2026-04-02--INGEST-STATUS.md) (או ליצור סטטוס חדש בתאריך המסירה בפועל).  
3. אם נדרש תמלול מבני ל־Markdown לצוות — לשקול תחת `to-eyal/<תאריך--נושא>/md-sources/` או `_internal/` עם קידומת `_transcription-` (לא להגשה לאייל). קאנון: [`../EYAL-CORRESPONDENCE-CANON.md`](../EYAL-CORRESPONDENCE-CANON.md).

## לוגו ומותג (קבצים בתיקייה)

נכסים שמגיעים מאייל / מעצב:

| קובץ | תיאור קצר |
|------|-----------|
| `מקורי מרובי.pdf` | לוגו צבעוני (מקור) |
| `מקורי מרובי - שחור.pdf` | לוגו שחור |
| `Icon` | מיועד לאייקון — **במאגר הנוכחי הקובץ ריק; יש להחליף** |
| `לColors Palet.jpeg` | פלטת צבעים (לא לוגו) |

**מפרט מלא + פורמט ייצור מומלץ (SVG/PNG, שמות קבצים, favicon):**  
[`LOGO-ASSETS-AND-FORMAT-SPEC.md`](./LOGO-ASSETS-AND-FORMAT-SPEC.md)

## סטטוס נוכחי

ראו [`2026-04-02--INGEST-STATUS.md`](./2026-04-02--INGEST-STATUS.md).

**מדיניות תאריך בקידומת קובץ:** להשתמש ב־**תאריך מסירה/פרסום בפועל** (או תאריך עדכון מהותי), לא בתאריך «עתידי» או placeholder — כדי למנוע דריפט בין שם הקובץ, האינדקס והדיונים.

**שמות בעברית ב־`.docx`:** כלי חיפוש/סוכנים עלולים שלא לאתרם בעץ הפרויקט; מומלץ לשמור **עותק טקסט** לניתוח (למשל `seo-content from eyal 2-4.md`) לצד הקובץ המקורי.
