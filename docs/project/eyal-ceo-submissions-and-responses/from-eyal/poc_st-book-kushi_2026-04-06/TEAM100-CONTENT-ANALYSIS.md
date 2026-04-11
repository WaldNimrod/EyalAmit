# ניתוח POC — st-book-kushi (צוות 100)

> **הערת דיוק (2026-04-06):** מסמך זה תיאר את **דמו הסינתטי** (`tpl-secondary`, JSON ישן). **התוכן המאושר מאייל** נמצא ב־[`2026-04-06--st-book-kushi--content--from-eyal.md`](./2026-04-06--st-book-kushi--content--from-eyal.md) (`tpl-book-detail`). ראו [`../PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md`](../PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md).

## מקורות אמת

| שכבה | מקור |
|------|------|
| IA / מזהה עמוד | `st-book-kushi` ב־`hub/data/site-tree.json` |
| תבנית | `templateId`: **`tpl-book-detail`** — שדות מלאים: `title`, `summary`, `body`, קטע קריאה, מהדורה, שני `purchase_*`, גלריה, `cta_footer`, `media_notes` (ראו `page-templates.json`) |
| רכישה חיצונית | `morningCheckoutUrl` על אותו צומת — **לא** בשדות התבנית |

## מיפוי שדות → דף הדמה (מסמך מאושר)

| שדה ב־MD | שימוש ב־UI |
|----------|------------|
| `field:title` | H1 |
| `field:summary` | פסקת lead מתחת לכותרת |
| `field:body` | גוף (כולל שורת משנה מודגשת ראשונה) |
| `field:edition_note` | הערת מהדורה |
| `field:excerpt_*` | בלוק קטע קריאה |
| `field:purchase_*` | שני כפתורי קישור חיצוני |
| `field:gallery_*` + YAML `driveRefs` | כותרת גלריה + ממלאי מקום לתמונות |
| `field:cta_footer` | בלוק סיום |
| `field:media_notes` | הערות מימוש (מוצג כ־dev note בתחתית ה־POC) |

## כפתורי רכישה (שניים)

- **מודפס:** תווית וכתובת מהמסמך המאושר; יעד Morning `https://mrng.to/MTUiO3vkIg` (גם ב־`site-tree.json` ל־`st-book-kushi`).
- **אלקטרוני:** מנדלי `https://www.mendele.co.il/product/kushibelantis/` — לפי המסמך המאושר (לא מ־`fieldValues` הישנים של הדמו).
- אין סליקה ב־WP (D-EYAL-GREEN-UX-06).

## הוכחת הבנה

דף ה־HTML ב־`hub/src/mockups/poc/poc-kushi-blantis-st-book-kushi-2026-04-06.html` מעודכן ל־**תוכן מאושר** (`2026-04-06--st-book-kushi--content--from-eyal.md`): RTL, כותרת, תקציר, גוף, קטע קריאה, מהדורה, שני קישורי רכישה חיצוניים, בלוק גלריה (ממלאי מקום), CTA סיום והערות מימוש גלריה.
