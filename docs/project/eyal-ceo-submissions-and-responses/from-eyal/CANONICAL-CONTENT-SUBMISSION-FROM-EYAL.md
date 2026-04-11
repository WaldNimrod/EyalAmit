# פורמט קנוני להגשת תוכן מאייל — לסוכנים ולצוות

**מטרה:** לאפשר לאייל עמית לייצר **תוכן מדויק** ולהעביר אותו בצורה שסוכנים (AI / יועצים) וצוות פיתוח יכולים לצרוך **בלי פערי פרשנות**. המסמך מגדיר: (א) **עץ אתר נעול**; (ב) **פורמט הגשה** תואם Hub; (ג) **גמישות** לכלול כל סקופ עמוד — כולל אינסטנסים (FAQ · גלריות · המלצות).

**מקור אמת טכני במאגר (לא לערוך ידנית בלי סבב אישור):**

| קובץ | תפקיד |
|------|--------|
| [`hub/data/site-tree.json`](../../../../hub/data/site-tree.json) | כל צמתי ה־IA: `id`, `slug`, `titleHe`, `templateId`, `parentId`, `menuHint`, `treeNoteHe` … |
| [`hub/data/page-templates.json`](../../../../hub/data/page-templates.json) | לכל `templateId` — רשימת שדות (`fields[].id`, `labelHe`, `type`) |
| **עותק סטטי אחרי פריסת Hub** | אותו JSON בשרת: `<בסיס_URL_ציבורי>/<UPRESS_EYAL_HUB_PATH>/data/site-tree.json` (ברירת מחדל לנתיב Hub: `ea-eyal-hub`). פירוט משתנים: [`docs/project/EYAL_ENV_VARS_REFERENCE.md`](../../EYAL_ENV_VARS_REFERENCE.md). |

**העברת קבצים:** Google Drive, תיקייה **`from-eyal`** (או שם מוסכם זהה). ראו גם [`README.md`](./README.md) — קונבנציית שמות קבצים.

**נוהל חבילות (מחייב לצוות 100):** עדכוני נוהל מסודרים בשם `canonical_update_pack_YYYY-MM-DD` + דוגמאות עמוד בשם `poc_<pageId>_YYYY-MM-DD` — ראו [`canonical_update_pack_2026-04-06/PROCEDURE-MANDATORY-v1.md`](./canonical_update_pack_2026-04-06/PROCEDURE-MANDATORY-v1.md) ו־[`../../../../_communication/team_100/MANDATORY-EYAL-CONTENT-PACK-CANON-2026-04-06.md`](../../../../_communication/team_100/MANDATORY-EYAL-CONTENT-PACK-CANON-2026-04-06.md).

**נעילת עץ (ציטוט מ־`site-tree.json`, שדה `treeApprovedDocRef`):**  
נעול ליישום — אישור אייל (פגישה 2026-04-06). עץ האתר כפי בקובץ זה הוא מקור אמת ל־IA ולתפריט; שינוי מבנה או slugs — רק אחרי סבב אישור מחדש.

---

## 1. כללי זהות לכל קובץ תוכן

כל קובץ (Markdown, JSON, או Word שמושקף מאותה היררכיה) **חייב** לכלול במקום בולט:

1. **`pageId`** — מזהה צומת מטבלת סעיף 2 (למשל `st-home`). **אסור** להמציא מזהה חדש.
2. **`slug`** — כפי בעץ (למשל `home`, `muzza/kushi-blantis`). לא לשנות בלי אישור IA.
3. **`templateId`** — כפי בעץ (למשל `tpl-service`).
4. **שפת גוף:** עברית RTL לרוב האתר; EN בלבד ל־`st-en` / `tpl-en-landing`.

**שמות קבצים מומלצים ב־Drive:**

```text
YYYY-MM-DD--<pageId>--content--from-eyal.md
YYYY-MM-DD--<pageId>--content--from-eyal.json
```

דוגמה: `2026-04-10--st-home--content--from-eyal.md`

**מניפסט אצווה (אופציונלי, מומלץ כשמעלים הרבה קבצים):**

```text
YYYY-MM-DD--content-pack-manifest--from-eyal.json
```

מבנה מוצע — רשימת אובייקטים `{ "pageId", "driveFileName", "mimeType" }` לכל קובץ באצווה.

---

## 2. עץ האתר הסופי הנעול — מפת עמודים

**מזהה עמוד (`pageId`) הוא מפתח יציב** לסוכנים ול־CMS. הכותרת בעברית עשויה להשתנות בניסוח; ה־`slug` נקבע לפי העץ.

| כותרת (כפי בעץ) | `pageId` | `slug` | `templateId` | תחת (הורה לוגי) |
|------------------|----------|--------|----------------|------------------|
| דף הבית | `st-home` | `home` | `tpl-home` | — |
| טיפול בדיג'רידו | `st-svc-treatment` | `treatment` | `tpl-service` | — |
| השיטה | `st-method` | `method` | `tpl-method` | — |
| שיעורי דיג'רידו | `st-svc-lessons` | `lessons` | `tpl-service` | — |
| סאונד הילינג | `st-svc-sound` | `sound-healing` | `tpl-service` | — |
| לימוד והכשרה | `st-learning-hub` | `learning` | `tpl-nav-hub` | — |
| כלים ואביזרים | `st-didg-gear-hub` | `tools-and-accessories` | `tpl-nav-hub` | — |
| מוזה הוצאה לאור | `st-books` | `muzza` | `tpl-books` | — |
| בלוג דיג'רידו | `st-blog` | `blog` | `tpl-blog-archive` | — |
| אייל עמית | `st-eyal-hub` | `eyal-amit` | `tpl-about` | — |
| צור קשר | `st-contact` | `contact` | `tpl-contact` | — |
| אנגלית (EN) | `st-en` | `en` | `tpl-en-landing` | — |
| המלצות — קטלוג מרכזי (ומדיה) | `st-media` | `media` | `tpl-media` | — |
| עמודים נוספים | `st-extra-pages` | `extra-pages-virtual` | `tpl-secondary` | — |
| הכשרות למטפלים | `st-trainings` | `therapist-training` | `tpl-placeholder` | לימוד והכשרה |
| קורסים (סקולר / חיצוני) | `st-courses` | `courses-external` | `tpl-external-menu` | לימוד והכשרה |
| הרצאות | `st-svc-lectures` | `lectures` | `tpl-lecture-product` | לימוד והכשרה |
| סדנאות | `st-svc-workshops` | `workshops` | `tpl-service` | לימוד והכשרה |
| כלים בעבודת יד ואביזרים | `st-svc-handmade` | `instruments` | `tpl-service` | כלים ואביזרים |
| תיקון וחידוש כלים | `st-svc-repair` | `repair` | `tpl-service` | כלים ואביזרים |
| צבע בכחול וזרוק לים | `st-book-tsva` | `muzza/tsva-bechol-ve-zorek-layam` | `tpl-secondary` | מוזה הוצאה לאור |
| כושי בלאנטיס | `st-book-kushi` | `muzza/kushi-blantis` | `tpl-book-detail` | מוזה הוצאה לאור |
| וכתבת | `st-book-vekatavt` | `muzza/vekatavt` | `tpl-secondary` | מוזה הוצאה לאור |
| פוסט בודד בבלוג | `st-blog-post` | `blog/post-slug` | `tpl-secondary` | בלוג דיג'רידו |
| מוקש דהימן — לזכרו | `st-mokesh` | `mokesh-dahiman` | `tpl-memorial` | אייל עמית |
| שאלות נפוצות (FAQ) | `st-faq` | `faq` | `tpl-entity-catalog` | עמודים נוספים |
| ניהול גלריות (ממשק מערכת) | `st-gallery-cms` | `gallery-management-internal` | `tpl-secondary` | עמודים נוספים |
| גלריות — קטלוג מרכזי | `st-galleries-catalog` | `galleries` | `tpl-entity-catalog` | עמודים נוספים |
| עמוד 404 | `st-404` | `404` | `tpl-secondary` | עמודים נוספים |
| מדיניות פרטיות | `st-privacy` | `privacy` | `tpl-legal` | עמודים נוספים |
| הצהרת נגישות | `st-legal-access` | `accessibility` | `tpl-legal` | עמודים נוספים |
| תקנון | `st-legal-terms` | `terms` | `tpl-legal` | עמודים נוספים |
| תודה אחרי טפסים | `st-thankyou` | `thank-you` | `tpl-secondary` | עמודים נוספים |
| מפת אתר HTML (אופציונלי) | `st-html-sitemap` | `sitemap` | `tpl-secondary` | עמודים נוספים |
| דף מאגר «שירותים» (legacy v2.3) | `st-services-hub` | `services` | `tpl-nav-hub` | עמודים נוספים |

הערות נוספות על צמתים (מיגרציה, תפריט, מוקאפ מאושר) — בשדות `treeNoteHe`, `menuHint`, `legacyNoteHe` בתוך `site-tree.json`.

---

## 3. פורמט קנוני — שדות לפי תבנית (`templateId`)

לכל עמוד: מלאו **רק** את השדות של התבנית שלו. מזהי השדות (`field id`) חייבים להתאים בדיוק ל־`page-templates.json` כדי שסוכן או סקריפט יוכלו למפות ל־ACF/CPT/WP.

**עקרון גמישות:** אם חסר שדה רשמי לרעיון מסוים — השתמשו בסעיף 5 (הרחבות ואינסטנסים). אל תשנו `templateId` בלי צוות.

סיכום תבניות (לפרט מלא — הקובץ JSON):

| `templateId` | שם | שדות (`fields[].id`) |
|--------------|-----|------------------------|
| `tpl-home` | דף בית | `hero_background`, `hero_overlay`, `hero_title`, `hero_subtitle`, `hero_supporting`, `cta_primary`, `updates_block`, `media_notes` |
| `tpl-method` | השיטה | `intro`, `pillars`, `disclaimer`, `media_notes` |
| `tpl-service` | שירות | `h1`, `summary`, `body`, `faq`, `cta`, `media_notes` |
| `tpl-lecture-product` | הרצאות | `title`, `description`, `checkout_url`, `media_notes` |
| `tpl-about` | אודות | `bio`, `highlights`, `media_notes` |
| `tpl-memorial` | מוקש דהימן | `title`, `body`, `media_notes` |
| `tpl-blog-archive` | ארכיון בלוג | `intro`, `notes` |
| `tpl-entity-catalog` | קטלוג FAQ / גלריות | `intro`, `taxonomy_note`, `cms_note` |
| `tpl-media` | המלצות / מדיה | `intro`, `items`, `media_notes` |
| `tpl-books` | ספרים (שער) | `intro`, `books_list`, `media_notes` |
| `tpl-external-menu` | קישור חיצוני (קורסים) | `label`, `external_url`, `notes` |
| `tpl-placeholder` | בקרוב | `message`, `cta_optional` |
| `tpl-contact` | צור קשר | `intro`, `phones`, `external_forms` |
| `tpl-legal` | משפטי | `body` |
| `tpl-en-landing` | EN | `headline`, `body_en`, `cta_en` |
| `tpl-secondary` | משני גנרי | `title`, `body`, `media_notes` |
| `tpl-nav-hub` | דף מאגר | `intro`, `cards` |

שדות מסוג `url` — כתובת מלאה עם `https://` כשהדבר נדרש לכפתור/סליקה חיצונית.

---

## 4. וריאנט א׳ — JSON (מומלץ לסוכנים ואוטומציה)

תואם לייצוא מ־**`content-intake.html`** ב־Hub (`exportType`: `eyal-page-content-intake`). מבנה לעמוד בודד:

```json
{
  "schemaVersion": 1,
  "exportType": "eyal-page-content-intake",
  "exportTimestamp": "2026-04-10T12:00:00.000Z",
  "respondent": "Eyal Amit",
  "pageId": "st-home",
  "pageRef": "",
  "pageTitleHe": "דף הבית",
  "slug": "home",
  "templateId": "tpl-home",
  "fieldValues": {
    "hero_title": "…",
    "hero_subtitle": "…"
  },
  "driveRefs": [
    "https://drive.google.com/file/d/…/view",
    "שם_קובץ_בתיקייה.jpg"
  ]
}
```

**אצווה:** מערך `pages: [ … ]` באובייקט עוטף:

```json
{
  "schemaVersion": 1,
  "exportType": "eyal-content-pack-batch",
  "deliveredVia": "google-drive:from-eyal",
  "exportTimestamp": "2026-04-10T12:00:00.000Z",
  "respondent": "Eyal Amit",
  "pages": [ /* אובייקטים כמו למעלה, בלי כפילות exportType */ ]
}
```

---

## 5. וריאנט ב׳ — Markdown (אנושי + סוכן)

כל קובץ מתחיל בבלוק YAML (חזית) — אחריו גוף לפי כותרות.

```yaml
---
pageId: st-svc-treatment
slug: treatment
templateId: tpl-service
respondent: Eyal Amit
exportTimestamp: 2026-04-10
driveRefs:
  - https://drive.google.com/...
---

## field:h1
טקסט כותרת H1

## field:summary
תקציר למטא ולשיתוף

## field:body
גוף מלא. ניתן להשתמש ב־Markdown פנימי (רשימות, הדגשות).

## field:faq
שאלה? תשובה. (פורמט חופשי בתוך השדה)

## field:cta
טקסט כפתור ולאן מוביל

## field:media_notes
הפניות לתמונות/וידאו ב־Drive
```

**כללי:**

- כל כותרת שדה בפורמט `## field:<field_id>` כאשר `<field_id>` מופיע ב־`page-templates.json`.
- שדות ריקים — ניתן להשמיט את הבלוק או להשאיר שורה «(ריק)».
- **`driveRefs`** בחזית — רשימת קישורי Drive או שמות קבצים בתיקייה.

---

## 6. אינסטנסים — FAQ · גלריה · המלצה (מודל אחיד)

עמודי הקטלוג (`st-faq`, `st-galleries-catalog`, `st-media`) משתמשים ב־`tpl-entity-catalog` / `tpl-media` ל**מבוא**.  
**הפריטים עצמם** (שאלה־תשובה, גלריה, ציטוט) הם רשומות חוזרות — יש להגדיר אותם בנפרד כדי לכסות את כל הסקופ.

### 6.1 קובץ ייעודי לאינסטנסים (מומלץ)

שם קובץ:

```text
YYYY-MM-DD--instances--<kind>--from-eyal.json
```

`kind` אחד מ: `faq`, `gallery`, `testimonial` (או `media` להמלצות/עדויות).

דוגמה FAQ:

```json
{
  "schemaVersion": 1,
  "exportType": "eyal-instances-faq",
  "instances": [
    {
      "groupHe": "טיפול",
      "questionHe": "…",
      "answerHe": "…",
      "targetPageIds": ["st-home", "st-svc-treatment"],
      "driveRefs": []
    }
  ]
}
```

דוגמה המלצה / מדיה:

```json
{
  "schemaVersion": 1,
  "exportType": "eyal-instances-testimonial",
  "instances": [
    {
      "titleHe": "כותרת קצרה",
      "quoteHe": "ציטוט או תקציר",
      "attributionHe": "שם / מקור",
      "linkUrl": "https://…",
      "targetPageIds": ["st-media"],
      "driveRefs": []
    }
  ]
}
```

`targetPageIds` — איפה הפריט אמור להופיע או להישלף לקטלוג; ניתן למלא מספר עמודים.

### 6.2 הרחבות חופשיות (רק אם חייב)

אם נדרש תוכן שלא נכנס לשדות הקיימים, הוסיפו ב־Markdown:

```markdown
## extension:FREEFORM
כותרת פנימית

תוכן… הסוכן מעביר לצוות כהערת שילוב ידנית.
```

או ב־JSON:

```json
"extensions": {
  "notesForImplementerHe": "טקסט חופשי למימוש ידני"
}
```

---

## 7. Word / Google Docs

כשמעלים **Word** או **Docs** ל־Drive (הגשה רשמית), יש לשמור **את אותם מזהים**:

- בראש המסמך: `pageId`, `slug`, `templateId`.
- כותרות משנה לפי שמות השדות באנגלית (`hero_title`, `body`, …) או לפי `labelHe` מתוך `page-templates.json` — **ועמודת מזהה** בטבלה אם צריך.

מומלץ לצרף **עותק JSON** או Markdown מקביל לאותו תוכן כדי להקטין טעויות העתקה.

---

## 8. סנכרון עם Hub

- **`site-tree.html`** — צפייה והערות; מבנה נעול.
- **`content-intake.html`** — מילוי שדות לפי `pageId` וייצוא JSON התואם סעיף 4.
- לאחר קליטה: עדכון [`2026-04-02--INGEST-STATUS.md`](./2026-04-02--INGEST-STATUS.md) (או קובץ סטטוס חדש בתאריך המסירה).  
- זרימת SSOT: [`hub/EYAL-HUB-SSOT-WORKFLOW.md`](../../../../hub/EYAL-HUB-SSOT-WORKFLOW.md).

---

## 9. נכסים ויזואליים

לוגו ופורמט קבצים — [`LOGO-ASSETS-AND-FORMAT-SPEC.md`](./LOGO-ASSETS-AND-FORMAT-SPEC.md).  
שאר מדיה: קישורי Drive בשדה `driveRefs` או `media_notes`.

---

*מסמך זה משלים את [`eyal_amit_dev_agent_build_spec.md`](./eyal_amit_dev_agent_build_spec.md) (טכני־תבניתי) ואת מסמך המפתח GEO/AEO/SEO — לא מחליף אותם.*
