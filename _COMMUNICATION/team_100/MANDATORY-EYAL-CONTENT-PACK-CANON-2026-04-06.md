# אימוץ מחייב — חבילות קנון ו־POC מצוות אייל (2026-04-06)

**קהל:** צוות 100 (ארכיטקטורה / SSOT / איכות מסירה) · צוות 20 (ביצוע) כשליווי תוכן.

## החלטה

1. **נוהל קבוע** — כל עדכון נוהל מסירת תוכן מצוות אייל ייכנס תחת שם התיקייה  
   `canonical_update_pack_YYYY-MM-DD`  
   עם `PACK-MANIFEST.json` + `PROCEDURE-MANDATORY-v*.md` כמתואר בחבילה הראשונה:  
   [`docs/project/eyal-ceo-submissions-and-responses/from-eyal/canonical_update_pack_2026-04-06/`](../../docs/project/eyal-ceo-submissions-and-responses/from-eyal/canonical_update_pack_2026-04-06/README.md).

2. **POC לעמוד בודד** — כל דוגמה כזו תיכנס תחת  
   `poc_<pageId>_YYYY-MM-DD`  
   עם JSON מסוג `eyal-page-content-intake` + README + (מומלץ) Markdown קנוני.

3. **מפרט תוכן כללי** — נשאר במסמך  
   [`CANONICAL-CONTENT-SUBMISSION-FROM-EYAL.md`](../../docs/project/eyal-ceo-submissions-and-responses/from-eyal/CANONICAL-CONTENT-SUBMISSION-FROM-EYAL.md);  
   חבילת הקנון **משלימה** אותו בנוהל שמות ומניפסט, לא דורסת שדות או עץ.

## הוכחת יישום (POC) — תיקון בלבול (חובה לקרוא)

**לא לבלבל:** תיקיית `poc_st-book-kushi_2026-04-06` הכילה גם **דמו סינתטי** (JSON/MD ישנים) וגם (בעותק נפרד) **תוכן מאושר**. ראו  
[`PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md`](../../docs/project/eyal-ceo-submissions-and-responses/from-eyal/PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md).

- **תוכן מאושר ל־st-book-kushi:** [`2026-04-06--st-book-kushi--content--from-eyal.md`](../../docs/project/eyal-ceo-submissions-and-responses/from-eyal/poc_st-book-kushi_2026-04-06/2026-04-06--st-book-kushi--content--from-eyal.md) (`tpl-book-detail`).
- חבילה (אינדקס): [`poc_st-book-kushi_2026-04-06/README.md`](../../docs/project/eyal-ceo-submissions-and-responses/from-eyal/poc_st-book-kushi_2026-04-06/README.md)
- ניתוח מיפוי (מבוסס דמו ישן — לעדכן אחרי מעבר לתוכן מאושר): [`TEAM100-CONTENT-ANALYSIS.md`](../../docs/project/eyal-ceo-submissions-and-responses/from-eyal/poc_st-book-kushi_2026-04-06/TEAM100-CONTENT-ANALYSIS.md)
- דף דמה ב־Hub מיושר ל־**תוכן מאושר** (`2026-04-06--st-book-kushi--content--from-eyal.md`):  
  `mockups/poc/poc-kushi-blantis-st-book-kushi-2026-04-06.html` (אימות: `scripts/verify_kushi_intake_poc_parity.py`)

## פעולות המשך (מינימום)

- [ ] עדכון `2026-04-02--INGEST-STATUS.md` (או סטטוס חדש) עם שתי התיקיות.
- [ ] פריסת Hub כדי לאפשר לאייל/סוכנים לפתוח את דף ה־POC בדפדפן.
