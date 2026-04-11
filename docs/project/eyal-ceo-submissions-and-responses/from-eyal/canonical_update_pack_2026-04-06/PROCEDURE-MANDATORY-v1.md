# נוהל מחייב v1 — חבילות קנון ו־POC (2026-04-06)

**סטטוס:** פורמט קבוע לצוות 100 / צוות 20 — לא לסטות בלי סבב תיעוד.

## 1. מטרה

לאחד מסירה מצוות אייל כך ש:

- כל **עדכון נוהל** יגיע בחבילה עם **מזהה ותאריך** ברורים.
- כל **דוגמת תוכן לעמוד בודד** תגיע כ־**POC** עם אותם מפתחות כמו ב־Hub (`pageId`, `slug`, `templateId`, `fieldValues`).

## 2. שמות תיקיות (חובה)

| סוג | תבנית שם | דוגמה |
|-----|-----------|--------|
| עדכון נוהל / קנון מסירה | `canonical_update_pack_YYYY-MM-DD` | `canonical_update_pack_2026-04-06` |
| הוכחת הבנה לעמוד יחיד | `poc_<pageId>_YYYY-MM-DD` | `poc_st-book-kushi_2026-04-06` |

`pageId` חייב להתאים ל־`hub/data/site-tree.json` (למשל `st-book-kushi`).

### 2.1 הפרדה: נוהל · דמו · תוכן מאושר

שם התיקייה `poc_<pageId>_…` **אינו** מבטיח שה־JSON/MD בתוכה הם מלל מאושר מאייל — ייתכן שמדובר ב־**דמו סינתטי** להוכחת נוהל. תוכן עמוד שמגיע מאייל בנפרד יש לשמור במסמך מפורש (למשל `YYYY-MM-DD--<pageId>--content--from-eyal.md`) ולסמן `contentStatus` / `respondent` בהתאם. פירוט ודוגמה `st-book-kushi`: [`../PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md`](../PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md).

## 3. תוכן חובה ב־`canonical_update_pack_*`

1. **`PACK-MANIFEST.json`** — לפי הסכימה ב־`PACK-MANIFEST.schema.json` (או מבנה שקול המופיע בדוגמה הראשונה).
2. **`PROCEDURE-MANDATORY-v1.md`** (או גרסה מאוחרת `v2`…) — תיאור הנוהל המעודכן.
3. **`README.md`** — אינדקס קצר וקישורים למסמכי המאגר הרלוונטיים.

## 4. תוכן חובה ב־`poc_<pageId>_*`

1. **`eyal-page-content-intake--<pageId>.json`** — מבנה כמו ייצוא `content-intake.html` ב־Hub (`exportType`: `eyal-page-content-intake`).
2. **`README.md`** — מי הגיש, תאריך, קישור לדף דמה אם קיים ב־`hub/dist`.
3. (מומלץ) **`content--<pageId>.md`** — אותו תוכן בפורמט Markdown הקנוני (`## field:…`).

## 5. שדות שאינם ב־`page-templates.json`

כתובות יעד שמוגדרות **בעץ** (למשל `morningCheckoutUrl` ל־`st-book-kushi`) **אינן** חלק מ־`fieldValues` — המממש חייב למזג מ־`site-tree.json`. ב־POC יש לתעד זאת ב־`README` או ב־`implementationNotesHe` ברמת החבילה.

## 6. קליטה ב־from-eyal

- שמירת החבילה תחת  
  `docs/project/eyal-ceo-submissions-and-responses/from-eyal/<שם_החבילה>/`
- עדכון [`../2026-04-02--INGEST-STATUS.md`](../2026-04-02--INGEST-STATUS.md) (או קובץ סטטוס חדש) לאחר סריקה.

## 7. דף דמה (Hub)

לאחר ניתוח POC — יש לפרסם דף HTML תחת `hub` (למשל `mockups/poc/`) שמוכיח מיפוי מלא: כותרת, גוף, מדיה, ו־CTA חיצוני כנדרש בעץ.

**נוהל מחייב משלים (תוכן + מדיה + עימוד ללקוח):** [`../../../../sop/PAGE-PACKAGE-CLIENT-POC-MANDATORY.md`](../../../../sop/PAGE-PACKAGE-CLIENT-POC-MANDATORY.md) — כולל חובת מדיה אמיתית מלגסי, פרופורציות תצוגה הגיוניות, **בידוד שכבת מטא** (`hub-meta-stack`, `data-site-layer="meta"`, `data-hub-non-content="true"`), צ׳ק־ליסט לפני מסירה, וסקריפטי parity כאשר קיימים.
