# אינדקס חומר עדכני לאייל עמית — סדר עבודה

**לאייל / דפדפן (ללא קישורי Markdown):** פתחו **[`INDEX.html`](./INDEX.html)** — כל הקישורים שם הם ל־`.docx` / `.html` / `.txt` בלבד.

**תאריך:** 2026-03-29 · **אינדקס מציאות (אפריל 2026):** [`EYAL-DOCS-FINDER-2026-04-04.md`](./EYAL-DOCS-FINDER-2026-04-04.md) — מפת אתר v2.3, אפיון, חבילת Word, מסמך GEO/AEO/SEO של אייל, דוח יישור צוות 100.  
**קאנון תיקיות (SSOT):** [`EYAL-CORRESPONDENCE-CANON.md`](./EYAL-CORRESPONDENCE-CANON.md) — רק `from-eyal/` ו־`to-eyal/`; **אין** יצירת `for-eyal/` חדש (stub בלבד).  
**מטרה:** מעבר **מסודר** על כל מה שהוכן להחלטות ואישורים — בלי לחפש בין תיקיות.

> **הגשה רשמית לאייל:** רק **Word (.docx)** או **PDF** — לא Markdown. מקורות MD למטה הם לצוות; את ה־Word מייצרים מ־`python3 scripts/build_eyal_ceo_deliverables.py` (ובסקריפטים נוספים לפי [`EYAL-CORRESPONDENCE-CANON.md`](./EYAL-CORRESPONDENCE-CANON.md)).

---

## איך מתמצאים: `from-eyal` מול `to-eyal`

| תיקייה | מה יש שם |
|--------|-----------|
| **`from-eyal/`** | **נכנס** — חומר שחוזר מאייל (Word/PDF/סריקות). |
| **`to-eyal/`** | **יוצא** — כל גל הגשה תחת `YYYY-MM-DD--topic-kebab-case/` (Word, `md-sources/`, `assets` לגל, וכו'). מוקאפי HTML חוצי-גלים: **`to-eyal/_shared-assets/`**. |

---

## 1. חובה — חבילת Word (התחילו כאן)

נתיב: [`to-eyal/2026-03-30--final-spec-package-for-eyal/`](./to-eyal/2026-03-30--final-spec-package-for-eyal/)

- תקציר מנהלים · מפת אתר · החלטות · טופס בחירות · חשבונית ירוקה · אפיון סופי · תנועה/AEO/GEO  
- קראו גם [`README.txt`](./to-eyal/2026-03-30--final-spec-package-for-eyal/README.txt) בתיקיית החבילה.  
- מקורות MD לחבילה: [`to-eyal/2026-03-30--final-spec-package-for-eyal/md-sources/`](./to-eyal/2026-03-30--final-spec-package-for-eyal/md-sources/)

---

## 2. אפיון ומבנה (Markdown — לצוות; תוכן משוקף ב־docx)

| נושא | קישור |
|------|--------|
| אפיון מחייב | [`../team-100-preplanning/SITE-SPECIFICATION-FINAL-2026-03-30.md`](../team-100-preplanning/SITE-SPECIFICATION-FINAL-2026-03-30.md) |
| מפת אתר v2.3 (**`APPROVED`**) | [`../team-100-preplanning/SITEMAP-NEW-SITE-v2-DRAFT.md`](../team-100-preplanning/SITEMAP-NEW-SITE-v2-DRAFT.md) — שם `DRAFT` בקובץ היסטורי |
| פרוטוקול פגישה + סגירה 1–10 | [`../team-100-preplanning/MEETING-MINUTES-EYAL-2026-03-31.md`](../team-100-preplanning/MEETING-MINUTES-EYAL-2026-03-31.md) |
| Wireframes + EN | [`../team-100-preplanning/IA-WIREFRAMES-AND-EN-LANDING.md`](../team-100-preplanning/IA-WIREFRAMES-AND-EN-LANDING.md) |
| כיווני דף בית | [`../team-100-preplanning/HOME-PAGE-DIRECTIONS-v1.2.md`](../team-100-preplanning/HOME-PAGE-DIRECTIONS-v1.2.md) |
| בחירת תבנית WP | [`../team-100-preplanning/WP-THEME-EVALUATION-HEBREW-SEO-2026-03-29.md`](../team-100-preplanning/WP-THEME-EVALUATION-HEBREW-SEO-2026-03-29.md) |
| תנועה · AEO · GEO | [`../team-100-preplanning/EYAL-TRAFFIC-GROWTH-AEO-GEO-GUIDE-2026-03-29.md`](../team-100-preplanning/EYAL-TRAFFIC-GROWTH-AEO-GEO-GUIDE-2026-03-29.md) |
| עמוד EN (H1 נעול; גוף לעריכה) | [`../team-100-preplanning/EN-LANDING-PAGE-CONTENT-DRAFT-2026-03-29.md`](../team-100-preplanning/EN-LANDING-PAGE-CONTENT-DRAFT-2026-03-29.md) · [`MEETING-MINUTES-EYAL-2026-03-31.md`](../team-100-preplanning/MEETING-MINUTES-EYAL-2026-03-31.md) |
| דוח גלריות + מיפוי | [`../team-100-preplanning/GALLERY-INVENTORY-REPORT-DRAFT-2026-03-31.md`](../team-100-preplanning/GALLERY-INVENTORY-REPORT-DRAFT-2026-03-31.md) · תבנית CSV · סקריפט `scripts/inventory_legacy_galleries.py` |

---

## 3. מוקאפי HTML (פתיחה בדפדפן)

**הערת אפיון:** בכל עמוד באתר — **תמונת כותרת ייעודית** לעמוד; המוקאפים ממחישים זאת בדף הבית ובאחרים היכן שיש Hero.

| מה | קישור |
|----|--------|
| דף בית — A/B/C מופשט | [`to-eyal/_shared-assets/home-directions-visual.html`](./to-eyal/_shared-assets/home-directions-visual.html) |
| דף בית — דשבורד מלא (א׳ ב׳ ג׳) | [`to-eyal/_shared-assets/home-dashboard/index.html`](./to-eyal/_shared-assets/home-dashboard/index.html) |
| קורס דיגיטלי (דמה) | [`to-eyal/_shared-assets/mockups/mockup-digital-course.html`](./to-eyal/_shared-assets/mockups/mockup-digital-course.html) |
| הרצאות (דמה) | [`to-eyal/_shared-assets/mockups/mockup-lectures.html`](./to-eyal/_shared-assets/mockups/mockup-lectures.html) |
| KMD — טבלה + ייצוא | [`to-eyal/_shared-assets/kmd-inventory-prototype.html`](./to-eyal/_shared-assets/kmd-inventory-prototype.html) |
| עמוד EN (דמה LTR) | [`to-eyal/_shared-assets/en-landing-page-preview.html`](./to-eyal/_shared-assets/en-landing-page-preview.html) |

פירוט: [`to-eyal/_shared-assets/README.txt`](./to-eyal/_shared-assets/README.txt) · [`for-eyal/README.md`](./for-eyal/README.md) (הפניה היסטורית בלבד).

---

## 4. מקורות Markdown לטופסים (ייצוא ל־Word)

| גל / נושא | תיקייה |
|-----------|--------|
| טופס בחירות + חשבונית ירוקה (חבילת 30.3) | [`to-eyal/2026-03-30--final-spec-package-for-eyal/md-sources/`](./to-eyal/2026-03-30--final-spec-package-for-eyal/md-sources/) |
| משוב SEO/AEO/GEO (אפריל) | [`to-eyal/2026-04-04--sitemap-seo-aeo-geo-feedback/md-sources/`](./to-eyal/2026-04-04--sitemap-seo-aeo-geo-feedback/md-sources/) |
| דוח AEO/GEO לקוח | [`to-eyal/2026-03-31--aeo-geo-client-report/md-sources/`](./to-eyal/2026-03-31--aeo-geo-client-report/md-sources/) |

**ייצוא Word (משוב לאייל):** `python3 scripts/build_eyal_sitemap_seo_alignment_feedback_docx.py` — פלט: [`to-eyal/2026-04-04--sitemap-seo-aeo-geo-feedback/`](./to-eyal/2026-04-04--sitemap-seo-aeo-geo-feedback/) (`…alignment-feedback-for-eyal--v1.docx`).

---

## 5. תזכיר פגישה (Word)

- [`to-eyal/2026-03-31--meeting-brief/`](./to-eyal/2026-03-31--meeting-brief/) — קובץ `Copy of …meeting-brief…v1.1.docx` (עץ ועדכונים).

---

## 6. תשובות מאייל (כשמתעדכן)

- [`from-eyal/`](./from-eyal/) — קבצים חתומים / עם הערות (אם קיימים במאגר). ראו [`from-eyal/README.md`](./from-eyal/README.md) ו־[`from-eyal/2026-04-02--INGEST-STATUS.md`](./from-eyal/2026-04-02--INGEST-STATUS.md) לסטטוס קליטת מסמך «עץ אתר לנמרוד — SEO · GEO · AEO».

---

## 7. ארכיון (לא SSOT נוכחי)

- [`archive/`](./archive/) — LEGACY, stubs, סבבי הגשה ישנים.

---

## 8. מסמכים מרכזיים

- [`README.md`](./README.md) — מדיניות תיקייה, אינדקס ידני היסטורי, פקודות בנייה.
- [`EYAL-CORRESPONDENCE-CANON.md`](./EYAL-CORRESPONDENCE-CANON.md) — טקסונומיה קבועה (`from-eyal` / `to-eyal` בלבד).
