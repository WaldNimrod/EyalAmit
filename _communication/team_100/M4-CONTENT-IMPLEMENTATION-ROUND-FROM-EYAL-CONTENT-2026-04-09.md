# סבב יישום תוכן — חבילות CONTENT מאייל (מקליטה קנונית)

**תאריך:** 2026-04-09  
**קהל:** צוות 100 · צוות 10 (יישום) · נימרוד (תקציר)  
**מיקום חומר:** [`docs/project/eyal-ceo-submissions-and-responses/from-eyal/CONTENT/`](../../docs/project/eyal-ceo-submissions-and-responses/from-eyal/CONTENT/README.md)

## 1. תקציר מנהלים

נקלטו **שש חבילות** (קבצי zip) מאייל, אורגנו תחת מזהים קנוניים `EYAL-CONTENT-PKG-<תאריך קליטה>-<slug>`, נפרסו לתיקיות נפרדות עם `PACKAGE-MANIFEST.json`, נרשמו ב־**Hub** ב־[`hub/data/deliverables.json`](../../hub/data/deliverables.json), וניתנים להורדה מפריסת ה־Hub לאחר `build_eyal_client_hub.py --mirror-docs` (כולל מירור **zip** מתחת ל־`from-eyal/CONTENT/`).

**תוכן כולל:** דפי ספרים (`tpl-book-detail`) — צבע, וקטבט, קושי (POC); תבנית ספרים מוז״ה (`tpl-books`); **הצעת** איגום ספרים + הרחבת עץ (`st-book-bundle`, דורש אישור IA); עמוד שירות טיפול מלא (`tpl-service`) כולל FAQ, המלצות, חומרי production.

**פערים / סיכונים:** חבילת `st-book-bundle` מסומנת כ**הצעה** (תוכן + site-tree addition) — לא ליישם שינויי מבנה ללא אישור צוות 100. יישום סופי לאייל דורש עמידה ב־[`docs/sop/PAGE-PACKAGE-CLIENT-POC-MANDATORY.md`](../../docs/sop/PAGE-PACKAGE-CLIENT-POC-MANDATORY.md) (מדיה אמיתית, בידוד מטא, אינטראקציות).

## 2. טבלת חבילות (מקור אמת מול אינדקס CONTENT)

| מזהה קנוני | קליטה | pageId | תבנית | תפקיד |
|------------|-------|--------|--------|--------|
| `EYAL-CONTENT-PKG-2026-04-09-st-svc-treatment` | 2026-04-09 | st-svc-treatment | tpl-service | תוכן FINAL |
| `EYAL-CONTENT-PKG-2026-04-07-st-book-bundle` | 2026-04-07 | st-book-bundle | tpl-secondary | הצעה + עץ |
| `EYAL-CONTENT-PKG-2026-04-07-st-books-muzeh` | 2026-04-07 | st-books | tpl-books | תוכן FINAL |
| `EYAL-CONTENT-PKG-2026-04-07-st-book-vekatavt` | 2026-04-07 | st-book-vekatavt | tpl-book-detail | תוכן FINAL |
| `EYAL-CONTENT-PKG-2026-04-07-st-book-tsva` | 2026-04-07 | st-book-tsva | tpl-book-detail | תוכן FINAL |
| `EYAL-CONTENT-PKG-2026-04-06-st-book-kushi` | 2026-04-06 | st-book-kushi | tpl-book-detail | POC מאושר |

פירוט קבצים ושמות zip: [`from-eyal/CONTENT/README.md`](../../docs/project/eyal-ceo-submissions-and-responses/from-eyal/CONTENT/README.md).

## 3. תהליך מומלץ להצגת דפים סופיים לאייל

1. **נעילת תוכן** לפי מזהה הקנוני (אין לערבב קבצים בין תיקיות חבילה).
2. **POC ב־Hub** (או עדכון POC קיים) לכל עמוד שנבחר להצגה — עמידה ב־PAGE-PACKAGE (תוכן מדויק, מדיה ממקור מאושר, ממשקים פעילים או סימון «לא מוכן»).
3. **יישום ב־WordPress** סטייג'ינג — slug והורה לפי עץ נעול; ללא שינוי slug בלי אישור 100.
4. **QA צוות 50** — תוכן, טפסים, קישורים חיצוניים.
5. **הצגה לאייל** — רק לאחר PASS או רשימת הערות מוסכמות.

```mermaid
flowchart LR
  canonId[Canonical_EYAL_CONTENT_PKG]
  hubPoc[Hub_POC_or_mockup]
  wpStaging[WP_staging]
  qa50[QA_team50]
  eyal[Eyal_signoff]
  canonId --> hubPoc --> wpStaging --> qa50 --> eyal
```

## 4. החלטות נדרשות (מינימום)

- [ ] אישור או דחייה של **הרחבת עץ** בחבילת `st-book-bundle` לפני שינוי `site-tree.json`.
- [ ] סדר עדיפויות ליישום עמודים מול צוות 20/10 (למשל שירות טיפול לעומת ספרים).

## 5. הפניות

- [`from-eyal/PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md`](../../docs/project/eyal-ceo-submissions-and-responses/from-eyal/PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md)
- [`scripts/build_eyal_client_hub.py`](../../scripts/build_eyal_client_hub.py) — `mirror_docs` כולל `.zip` תחת `from-eyal/CONTENT/`.
