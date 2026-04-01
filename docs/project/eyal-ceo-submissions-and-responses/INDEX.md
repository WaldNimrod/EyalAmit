# אינדקס חומר עדכני לאייל עמית — סדר עבודה

**לאייל / דפדפן (ללא קישורי Markdown):** פתחו **[`INDEX.html`](./INDEX.html)** — כל הקישורים שם הם ל־`.docx` / `.html` / `.txt` בלבד.

**תאריך:** 2026-03-29  
**מטרה:** מעבר **מסודר** על כל מה שהוכן להחלטות ואישורים — בלי לחפש בין תיקיות.

> **הגשה רשמית לאייל:** רק **Word (.docx)** או **PDF** — לא Markdown. מקורות MD למטה הם לצוות; את ה־Word מייצרים מ־`python3 scripts/build_eyal_ceo_deliverables.py`.

---

## איך מתמצאים: `to-eyal` מול `for-eyal`

| תיקייה | מה יש שם |
|--------|-----------|
| **`to-eyal/2026-03-30--final-spec-package-for-eyal/`** | **חבילת Word מוכנה** — תקציר, מפת אתר, החלטות, טופס בחירות, חשבונית ירוקה, אפיון סופי, מדריך תנועה — **זה מה שמגיע לאייל בדוא״ל / Drive**. |
| **`for-eyal/`** | **הכנה ויזואלית:** מוקאפי HTML, תזכיר פגישה, מקורות MD לייצוא. **לא** תחליף לחבילת `to-eyal`. |

אין כפילות תפקידית: `to-eyal` = **פלט הגשה**; `for-eyal` = **דגימות ומסמכי עזר**.

---

## 1. חובה — חבילת Word (התחילו כאן)

נתיב: [`to-eyal/2026-03-30--final-spec-package-for-eyal/`](./to-eyal/2026-03-30--final-spec-package-for-eyal/)

- תקציר מנהלים · מפת אתר · החלטות · טופס בחירות · חשבונית ירוקה · אפיון סופי · תנועה/AEO/GEO  
- קראו גם [`README.txt`](./to-eyal/2026-03-30--final-spec-package-for-eyal/README.txt) בתיקיית החבילה.

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
| דף בית — A/B/C מופשט | [`for-eyal/assets/home-directions-visual.html`](./for-eyal/assets/home-directions-visual.html) |
| דף בית — דשבורד מלא (א׳ ב׳ ג׳) | [`for-eyal/assets/home-dashboard/index.html`](./for-eyal/assets/home-dashboard/index.html) |
| קורס דיגיטלי (דמה) | [`for-eyal/assets/mockups/mockup-digital-course.html`](./for-eyal/assets/mockups/mockup-digital-course.html) |
| הרצאות (דמה) | [`for-eyal/assets/mockups/mockup-lectures.html`](./for-eyal/assets/mockups/mockup-lectures.html) |
| KMD — טבלה + ייצוא | [`for-eyal/assets/kmd-inventory-prototype.html`](./for-eyal/assets/kmd-inventory-prototype.html) |
| עמוד EN (דמה LTR) | [`for-eyal/assets/en-landing-page-preview.html`](./for-eyal/assets/en-landing-page-preview.html) |

פירוט: [`for-eyal/README.md`](./for-eyal/README.md) · [`for-eyal/assets/README.txt`](./for-eyal/assets/README.txt)

---

## 4. מקורות Markdown לטופסים (ייצוא ל־Word)

תיקייה: [`for-eyal/md-sources/`](./for-eyal/md-sources/)

- [`FOR-EYAL-CHOICES-v1.2-2026-03-30.md`](./for-eyal/md-sources/FOR-EYAL-CHOICES-v1.2-2026-03-30.md)  
- [`FOR-EYAL-GREEN-INVOICE-ACTION-SHEET-2026-03-30.md`](./for-eyal/md-sources/FOR-EYAL-GREEN-INVOICE-ACTION-SHEET-2026-03-30.md)

---

## 5. תזכיר פגישה (Word)

- [`for-eyal/2026-03-31--meeting-brief/`](./for-eyal/2026-03-31--meeting-brief/) — קובץ `Copy of …meeting-brief…v1.1.docx` (עץ ועדכונים).

---

## 6. תשובות מאייל (כשמתעדכן)

- [`from-eyal/`](./from-eyal/) — קבצים חתומים / עם הערות (אם קיימים במאגר).

---

## 7. ארכיון (לא SSOT נוכחי)

- [`archive/`](./archive/) — LEGACY, stubs, סבבי הגשה ישנים.

---

## 8. מסמך מרכזי נוסף

- [`README.md`](./README.md) — מדיניות תיקייה, אינדקס ידני היסטורי, פקודות בנייה.
