# from-eyal — חומר שחוזר מאייל עמית

תיקייה ל**קבצים מקוריים** מהלקוח (Word, PDF, סריקות חתומות).

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

## סטטוס נוכחי

ראו [`2026-04-02--INGEST-STATUS.md`](./2026-04-02--INGEST-STATUS.md).

**מדיניות תאריך בקידומת קובץ:** להשתמש ב־**תאריך מסירה/פרסום בפועל** (או תאריך עדכון מהותי), לא בתאריך «עתידי» או placeholder — כדי למנוע דריפט בין שם הקובץ, האינדקס והדיונים.

**שמות בעברית ב־`.docx`:** כלי חיפוש/סוכנים עלולים שלא לאתרם בעץ הפרויקט; מומלץ לשמור **עותק טקסט** לניתוח (למשל `seo-content from eyal 2-4.md`) לצד הקובץ המקורי.
