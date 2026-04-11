# סטטוס קליטה — מסמך «עץ אתר לנמרוד — SEO · GEO · AEO»

**עדכון:** 2026-04-09 (נספח CONTENT)

## מצב: נקלט ונותח

| פריט | מיקום |
|------|--------|
| מקור Word (שם בעברית) | `עץ אתר לנמרוד - שיקולי SEO GEO AEO.docx` |
| עותק טקסט לניתוח (ASCII) | [`seo-content from eyal 2-4.md`](./seo-content%20from%20eyal%202-4.md) |
| דוח פנימי | [`M2-EYAL-SITEMAP-SEO-AEO-GEO-ALIGNMENT-2026-04-04.md`](../../../../_communication/team_100/M2-EYAL-SITEMAP-SEO-AEO-GEO-ALIGNMENT-2026-04-04.md) |
| משוב לאייל (MD + Word) | [`to-eyal/2026-04-04--sitemap-seo-aeo-geo-feedback/md-sources/2026-04-04--eyal-sitemap-seo-feedback-response-he.md`](../to-eyal/2026-04-04--sitemap-seo-aeo-geo-feedback/md-sources/2026-04-04--eyal-sitemap-seo-feedback-response-he.md) · [`to-eyal/2026-04-04--sitemap-seo-aeo-geo-feedback/`](../to-eyal/2026-04-04--sitemap-seo-aeo-geo-feedback/) |

**הערה:** כלי חיפוש/סוכנים עלולים שלא לאתר את קובץ ה־`.docx` בשם עברית; העתק ה־`.md` נועד לנראות ול־diff בעץ Git.

---

## 2026-04-06 — חבילות נוהל קנון + POC (קליטת צוות 100)

| חבילה | מיקום | הערה |
|--------|--------|------|
| `canonical_update_pack_2026-04-06` | [`canonical_update_pack_2026-04-06/`](./canonical_update_pack_2026-04-06/README.md) | נוהל מחייב: שמות תיקיות, מניפסט, POC |
| `poc_st-book-kushi_2026-04-06` | [`poc_st-book-kushi_2026-04-06/`](./poc_st-book-kushi_2026-04-06/README.md) | דמו JSON/MD ישן + **`2026-04-06--st-book-kushi--content--from-eyal.md` (מאושר)**; POC ב־Hub מיושר למאושר |
| אימוץ צוות 100 | [`MANDATORY-EYAL-CONTENT-PACK-CANON-2026-04-06.md`](../../../../_communication/team_100/MANDATORY-EYAL-CONTENT-PACK-CANON-2026-04-06.md) | החלטת אימוץ |

**מסירה טרייה (קבצים / zip מלפני שעה):** אם הופיעו `from-eyal/canonical_update_pack_2026-04-06.zip` או `from-eyal/poc_st-book-kushi_2026-04-06.zip` או עדכון לתיקייה המפורקת — **לא למזג נוהל לתוך תוכן עמוד**. לבדוק `mtime` על `poc_st-book-kushi_2026-04-06/*.json` ו־`*.md`, לעדכן את `hub/src/mockups/poc/poc-kushi-blantis-st-book-kushi-2026-04-06.html` אם השתנה המלל, ולהריץ `python3 scripts/verify_kushi_intake_poc_parity.py` (שורש `EyalAmit.co.il-2026/`).

### תיקון בלבול חבילות (st-book-kushi)

- **שורש הבעיה:** שתי חבילות שונות סווגו בטעות כאותו דבר: (א) **נוהל** — `canonical_update_pack_*`; (ב) **דמו תהליך** — `poc_*` עם מלל סינתטי ב־`content--st-book-kushi.md` / JSON; (ג) **תוכן מאושר** — `2026-04-06--st-book-kushi--content--from-eyal.md` (בתיקייה `poc_st-book-kushi_2026-04-06 2` ומאוחד גם ל־`poc_st-book-kushi_2026-04-06/`).
- **מסמך קנוני:** [`from-eyal/PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md`](./PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md).

---

## 2026-04-09 — חבילות תוכן ב־`from-eyal/CONTENT` (6× zip)

נקלטו ופורסו תחת מזהים `EYAL-CONTENT-PKG-*` (תיקייה לכל חבילה + `PACKAGE-MANIFEST.json`). רישום ב־Hub: [`hub/data/deliverables.json`](../../../../hub/data/deliverables.json). אינדקס: [`CONTENT/README.md`](./CONTENT/README.md) · [`CONTENT/INDEX-CONTENT.txt`](./CONTENT/INDEX-CONTENT.txt). מסמך סבב: [`M4-CONTENT-IMPLEMENTATION-ROUND-FROM-EYAL-CONTENT-2026-04-09.md`](../../../../_communication/team_100/M4-CONTENT-IMPLEMENTATION-ROUND-FROM-EYAL-CONTENT-2026-04-09.md).

| מזהה קנוני | zip מקורי |
|------------|-----------|
| `EYAL-CONTENT-PKG-2026-04-09-st-svc-treatment` | `final_st-svc-treatment_2026-04-09_SINGLE.zip` |
| `EYAL-CONTENT-PKG-2026-04-07-st-book-bundle` | `proposed_st-book-bundle_2026-04-07.zip` |
| `EYAL-CONTENT-PKG-2026-04-07-st-books-muzeh` | `final_st-books_muzeh_2026-04-07.zip` |
| `EYAL-CONTENT-PKG-2026-04-07-st-book-vekatavt` | `final_st-book-vekatavt_2026-04-07.zip` |
| `EYAL-CONTENT-PKG-2026-04-07-st-book-tsva` | `final_st-book-tsva_2026-04-07.zip` |
| `EYAL-CONTENT-PKG-2026-04-06-st-book-kushi` | `poc_st-book-kushi_2026-04-06.zip` |
