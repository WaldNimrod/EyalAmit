# הפרדת חבילות: נוהל · דמו תהליך · תוכן מאושר מאייל

**מטרה:** למנוע חזרה על הבלבול שגרם לכך שמלל **דמה** הוטמע ב־Hub כאילו היה **מקור מאייל**.

## שלוש רמות — לא לערבב

| סוג | שם דפוס בתיקייה | מה יש בפנים | האם מלל עמוד מאושר? |
|-----|------------------|-------------|---------------------|
| **א׳ — נוהל בלבד** | `canonical_update_pack_YYYY-MM-DD` | `PACK-MANIFEST.json`, `PROCEDURE-MANDATORY-v*.md`, סכימה | **לא.** אפס כותרות/גוף לעמוד. |
| **ב׳ — דמו תהליך (POC)** | `poc_<pageId>_YYYY-MM-DD` (כאשר ממולא ב־**מלל סינתטי**) | JSON/MD שממחישים **איך** ממלאים טופס / תבנית | **לא.** רק הוכחת נוהל; המלל יכול להיות מומצא לדוגמה. |
| **ג׳ — תוכן עמוד מאושר** | אותו דפוס תיקייה **או** קובץ בשם מפורש `YYYY-MM-DD--<pageId>--content--from-eyal.md` | שדות `field:*` עם `respondent: Eyal Amit`, `contentStatus: reviewed`, וכו׳ | **כן** — זה מה שצריך לרנדר באתר / ב־POC ויזואלי. |

**כלל זהב:** אם ב־YAML כתוב `respondent: Eyal Amit — צוות ליווי תוכן` ו־`PLACEHOLDER` ב־Drive — זה לרוב **ב׳**. אם כתוב `respondent: Eyal Amit` ו־`contentStatus: reviewed` וניסוח תואם את עמוד הספר באתר — זה **ג׳**.

## מה קרה בפרויקט (שורש התקלה)

1. התקבלו **שתי חבילות נפרדות** באותו תאריך:
   - **`canonical_update_pack_2026-04-06`** — רק **א׳** (נוהל). תקין.
   - **`poc_st-book-kushi_2026-04-06`** — בתוך התיקייה הראשונה שנשמרה במאגר הופיעו `content--st-book-kushi.md` + `eyal-page-content-intake--st-book-kushi.json` עם מלל **«ספר ילדים… הרפתקאה צבעונית»** — זה **ב׳** (דמו ל־`tpl-secondary`), לא מסמך מאושר מאייל.

2. במקביל הופיעה תיקייה **`poc_st-book-kushi_2026-04-06 2`** (שם כפול טיפוסי ל־macOS) עם  
   **`2026-04-06--st-book-kushi--content--from-eyal.md`** — זה **ג׳**: כותרת «כושי בלאנטיס», גוף רומן פנטזיה למבוגרים, `tpl-book-detail`, קישורי Morning + מנדלי, הוראות גלריה.

3. צוות הפנה את ה־Hub (`poc-kushi-blantis-….html`) ואת הבדיקות לקבצים מ־**ב׳**, ולכן הוצג מלל שלא תואם את **ג׳**.

## מקור אמת קנוני ל־`st-book-kushi` (נכון לקליטה זו)

- **תוכן מאושר (ג׳):**  
  [`poc_st-book-kushi_2026-04-06/2026-04-06--st-book-kushi--content--from-eyal.md`](./poc_st-book-kushi_2026-04-06/2026-04-06--st-book-kushi--content--from-eyal.md)  
  (הועתק מתוך `poc_st-book-kushi_2026-04-06 2/` לאיחוד מקור.)

- **דמו סינתטי (ב׳) — לא להציג כמקור מאייל:**  
  [`poc_st-book-kushi_2026-04-06/content--st-book-kushi.md`](./poc_st-book-kushi_2026-04-06/content--st-book-kushi.md)  
  [`poc_st-book-kushi_2026-04-06/eyal-page-content-intake--st-book-kushi.json`](./poc_st-book-kushi_2026-04-06/eyal-page-content-intake--st-book-kushi.json)

## פעולות צוות אחרי מסירה חדשה

1. לסווג כל zip: **א׳ / ב׳ / ג׳** לפי הטבלה למעלה.
2. לא לבנות POC ציבורי מ־**ב׳** בלי תווית «דמו»; מימוש ויזואלי — מ־**ג׳** בלבד (או מייצוא Hub מאושר).
3. לעדכן את [`2026-04-02--INGEST-STATUS.md`](./2026-04-02--INGEST-STATUS.md) עם סיווג החבילה.
4. `python3 scripts/verify_kushi_intake_poc_parity.py` בודק כרגע **התאמה בין הדמו (ב׳) לבין דף ה־HTML הישן** — לא בין **ג׳** לבין האתר; עד שיוחלף ה־POC ב־Hub לפי קובץ **ג׳**, לא לפרש את הסקריפט כאימות מול מאייל.

## יישום טכני (עודכן)

- נוספה תבנית **`tpl-book-detail`** ב־`hub/data/page-templates.json`.
- `mockups/poc/poc-kushi-blantis-st-book-kushi-2026-04-06.html` נבנה מחדש משדות **ג׳** (מסמך מאושר).
- `hub/data/site-tree.json` — `st-book-kushi.templateId` = `tpl-book-detail`.
