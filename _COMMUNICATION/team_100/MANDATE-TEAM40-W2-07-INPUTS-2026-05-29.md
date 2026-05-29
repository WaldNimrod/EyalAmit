# מנדט צוות 40 — קלטי קלט קשיחים ל־WP-W2-07 (Press + 49 QR)

**תאריך:** 2026-05-29
**גרסת מנדט:** 1.0
**מוציא:** צוות 100 (Chief System Architect)
**נמען:** צוות 40 (מדיה / legacy)
**סוג:** INPUT-REQUEST (חוסם L-GATE_ELIGIBILITY של WP-W2-07)
**סביבת עבודה:** workspace שורש `EyalAmit.co.il-2026`

---

## 1. מטרה

WP-W2-07 (Press + Moksha + 49 QR + FB testimonials) **חסום** על שני קלטי קלט קשיחים שצוות 40
אחראי להפיק מ־legacy. בלעדיהם הבילד (team_10) לא יכול להתחיל. מנדט זה מבקש את שני הקבצים
בסכמה המדויקת שהמפרט (LOD400, spec_gate PASS) דורש.

**מפרט מקור:** [`_aos/work_packages/S002/WP-W2-07/LOD400_spec.md`](../../_aos/work_packages/S002/WP-W2-07/LOD400_spec.md)

---

## 2. תוצרים נדרשים (שני קבצים — חובה)

### 2.1 ייצוא עיתונות — `W2-07-PRESS-EXPORT-2026-05-28.json`

- **נתיב יעד מדויק:** `_COMMUNICATION/team_40/W2-07-PRESS-EXPORT-2026-05-28.json`
- **מקור:** crawl של ה־legacy (אזכורי עיתונות / "כתבו עלינו").
- **סכמה:** מערך אובייקטים, כל אחד:
  ```json
  { "date": "YYYY-MM-DD", "title": "<כותרת הכתבה>", "url": "<קישור חיצוני>", "source": "<שם המקור/עיתון>" }
  ```
- **כמות מינימום:** ≥5 כתבות (AC-03 דורש ≥5). העדיפו את כל מה שקיים ב־legacy.
- **הערה:** הקישורים ייפתחו בלשונית חדשה — ודאו `url` מלא ותקין (http/https).

### 2.2 ייצוא תוכן QR — `W2-07-QR-CONTENT-EXPORT-2026-05-28.json`

- **נתיב יעד מדויק:** `_COMMUNICATION/team_40/W2-07-QR-CONTENT-EXPORT-2026-05-28.json`
- **מקור:** 49 דפי ה־QR ב־legacy. **מצאי הכתובות/slugs הקאנוני (לא לשנות!):**
  [`docs/project/team-100-preplanning/QR-URL-INVENTORY.csv`](../../docs/project/team-100-preplanning/QR-URL-INVENTORY.csv)
  (49 דפים: `qr/qr1`..`qr/qr49` — ה־CSV הוא ה־SSoT ל־slug/nesting לפי QR-URL-POLICY).
- **סכמה:** מערך של 49 אובייקטים, אחד לכל דף:
  ```json
  { "qr_n": <מספר 1-49>, "slug": "qr/qrN", "title": "<כותרת מ-legacy>", "body_html": "<גוף ה-HTML 1:1>", "image_urls": ["<url legacy>", ...] }
  ```
- **מיגרציה 1:1 בלבד** — לא לשכתב תוכן (Out of scope במפרט). תמונות יורדו וירוהוסטו ע"י team_10
  תחת `wp-content/uploads/ea-legacy/qr/` — אתם רק מספקים את ה־`image_urls` המקוריים.
- **התאמה למצאי:** כל 49 השורות ב־CSV חייבות לקבל רשומה. אם דף legacy ריק/חסר — החזירו רשומה
  עם `body_html` ריק + הערה, אל תשמיטו (כדי ש־team_10 יזרע את כל 49 ה־URLs; AC-01).

---

## 3. קלט שכבר קיים (לא לפעולה — לידיעה)

- ✅ קטלוג testimonials: [`_COMMUNICATION/team_40/ea-legacy-curated-2026-04-11/catalog.json`](../team_40/ea-legacy-curated-2026-04-11/catalog.json) (315 entries) — מספק FB Top-5. אין צורך בפעולה.
- ℹ️ Moksha: דף קיים (W2-02 ID 181); מקור הטקסט `…/25.5.26/מוקש דהימן/ומה היום.docx` + תמונות legacy.
  אם תמונות ה־Moksha זמינות ב־legacy crawl שלכם — צרפו `image_urls` ל־Moksha בקובץ נפרד או הערה; לא חוסם.

---

## 4. Definition of Done

- [ ] `W2-07-PRESS-EXPORT-2026-05-28.json` קיים בנתיב היעד, JSON תקין, ≥5 רשומות בסכמת §2.1.
- [ ] `W2-07-QR-CONTENT-EXPORT-2026-05-28.json` קיים בנתיב היעד, JSON תקין, 49 רשומות בסכמת §2.2, ממופות 1:1 ל־CSV.
- [ ] קובץ מסירה קצר תחת `_COMMUNICATION/team_40/` המאשר את שני הקבצים + פקודות ה־crawl שהורצו.

---

## 5. גבולות והסלמה

- מיגרציה בלבד — אסור לשכתב/לערוך תוכן עיתונות או QR.
- אסור לשנות slugs/nesting של QR — ה־CSV נעול (QR-URL-POLICY).
- כל פער שדורש שינוי מפרט או מצאי — עצירה והפניה לצוות 100 (לא "יושבים על זה" בשקט).

---

**חתימת צוות 100:** מנדט פתוח לביצוע. עם נחיתת שני הקבצים → WP-W2-07 משתחרר ל־L-GATE_ELIGIBILITY ובניית team_10.
