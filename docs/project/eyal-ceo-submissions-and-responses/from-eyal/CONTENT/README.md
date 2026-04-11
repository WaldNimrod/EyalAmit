# CONTENT — חבילות תוכן מאייל (קליטה קנונית)

**תאריך אינדקס:** 2026-04-09  
**מסמך סבב צוות 100:** [`../../../../../_communication/team_100/M4-CONTENT-IMPLEMENTATION-ROUND-FROM-EYAL-CONTENT-2026-04-09.md`](../../../../../_communication/team_100/M4-CONTENT-IMPLEMENTATION-ROUND-FROM-EYAL-CONTENT-2026-04-09.md)

כל חבילה נקלטה כ־**zip** בתוך תיקייה בשם **מזהה קנוני** `EYAL-CONTENT-PKG-<YYYY-MM-DD>-<slug>` (תאריך = תאריך קליטה). בתוך כל תיקייה: עותק ה־zip המקורי, תוכן מפורק, ו־`PACKAGE-MANIFEST.json`.

**Hub:** אותם מזהים רשומים ב־[`hub/data/deliverables.json`](../../../../../hub/data/deliverables.json) ומופיעים ברשימת דליברבלס אחרי `build_eyal_client_hub.py --mirror-docs` (מירור **zip** מתחת ל־`from-eyal/CONTENT/`).

| מזהה קנוני | תאריך קליטה | pageId | תבנית | תפקיד / הערה | קובץ zip (בתוך התיקייה) | סטטוס |
|------------|-------------|--------|--------|----------------|-------------------------|--------|
| `EYAL-CONTENT-PKG-2026-04-09-st-svc-treatment` | 2026-04-09 | `st-svc-treatment` | `tpl-service` | FINAL — FAQ, המלצות, brief, docx | `final_st-svc-treatment_2026-04-09_SINGLE.zip` | נקלט — ממתין יישום POC / WP |
| `EYAL-CONTENT-PKG-2026-04-07-st-book-bundle` | 2026-04-07 | `st-book-bundle` | `tpl-secondary` | **הצעה** — תוכן + הרחבת עץ | `proposed_st-book-bundle_2026-04-07.zip` | נקלט — נדרש אישור IA (100) |
| `EYAL-CONTENT-PKG-2026-04-07-st-books-muzeh` | 2026-04-07 | `st-books` | `tpl-books` | FINAL — מוז״ה | `final_st-books_muzeh_2026-04-07.zip` | נקלט |
| `EYAL-CONTENT-PKG-2026-04-07-st-book-vekatavt` | 2026-04-07 | `st-book-vekatavt` | `tpl-book-detail` | FINAL + גלריה | `final_st-book-vekatavt_2026-04-07.zip` | נקלט |
| `EYAL-CONTENT-PKG-2026-04-07-st-book-tsva` | 2026-04-07 | `st-book-tsva` | `tpl-book-detail` | FINAL + גלריה | `final_st-book-tsva_2026-04-07.zip` | נקלט |
| `EYAL-CONTENT-PKG-2026-04-06-st-book-kushi` | 2026-04-06 | `st-book-kushi` | `tpl-book-detail` | POC — תוכן מאושר (מסלול Hub POC קיים) | `poc_st-book-kushi_2026-04-06.zip` | נקלט |

## מבנה תיקיות

```
CONTENT/
  EYAL-CONTENT-PKG-2026-04-06-st-book-kushi/
    PACKAGE-MANIFEST.json
    poc_st-book-kushi_2026-04-06.zip
    poc_st-book-kushi_2026-04-06/ …
  EYAL-CONTENT-PKG-2026-04-07-st-book-tsva/
  …
```

## הפניות

- [`PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md`](../PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md) — הפרדת נוהל / דמו / תוכן מאושר.
- [`CANONICAL-CONTENT-SUBMISSION-FROM-EYAL.md`](../CANONICAL-CONTENT-SUBMISSION-FROM-EYAL.md) — שדות ועץ.
- [`../../../../sop/PAGE-PACKAGE-CLIENT-POC-MANDATORY.md`](../../../../sop/PAGE-PACKAGE-CLIENT-POC-MANDATORY.md) — קריטריון POC ללקוח.
