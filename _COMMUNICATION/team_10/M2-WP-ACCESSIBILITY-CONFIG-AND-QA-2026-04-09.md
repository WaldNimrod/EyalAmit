# M2 — WP Accessibility: הגדרה, מימוש בקוד, ובדיקות מול תקן ישראלי

**תאריך:** 2026-04-09  
**מוציא:** צוות **10** (יישום)  
**אל:** צוות **50** (QA) · צוות **100** (הקשר ארכיטקטוני)  
**מסגרת משפטית/תכנון:** [`docs/project/team-100-preplanning/LEGAL-ACCESSIBILITY-ISRAEL-SPEC.md`](../../docs/project/team-100-preplanning/LEGAL-ACCESSIBILITY-ISRAEL-SPEC.md) — **אינו ייעוץ משפטי.**

---

## 1. בחירת התוסף (מפורש)

| תוסף | מקור | סטטוס בפרויקט |
|------|------|----------------|
| **WP Accessibility** | [wordpress.org/plugins/wp-accessibility](https://wordpress.org/plugins/wp-accessibility/) (Joe Dolson) | **נבחר והותקן** — כלי עזר לדילוג לתוכן, מיקוד מקלדת ועוד |
| **Enable Accessibility** | חבילת uPress (שכבת UI / מנוי) | **לא** בשימוש — לפי [`M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md`](../team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md) **אינו** מומלץ כתחליף לנגישות מובנית |

**עקרון:** תוסף **אינו** מבטיח עמידה בת"י 5568 / WCAG; חובה **תבנית, תוכן, טפסים, ניגודיות ותהליך בדיקה**.

---

## 2. יעד דילוג לתוכן (Skip link) עם GeneratePress

בפלט HTML של **GeneratePress** (אומת בסטייג'ינג) קיימים המזהים: `#page`, `#content`, `#primary`, **`#main`**.

**המלצה להגדרת WP Accessibility:** קבעו את קישור הדילוג הראשון ל־**`#main`** (אזור התוכן העיקרי). חלופה תקינה: **`#content`**.  
אין צורך ב־`id` נוסף ב־child theme כל עוד אלה קיימים בפלט.

---

## 3. הגדרות מומלצות ב־wp-admin (Settings → WP Accessibility)

הממשק משתנה בין גרסאות; יש לאמת שדות מול המסך בפועל.

1. **Skip links** — **הפעלה**; יעד ראשון: **`#main`** (או `#content`).
2. **Visible focus / outline for keyboard users** — **הפעלה** (או מקבילה בשם דומה) כדי שמיקוד מקלדת יהיה ברור.
3. **RTL / עברית** — לוודא שהתוסף לא שובר כיוון; אם יש אפשרות לשפה — עברית.
4. **תכונות שמשנות DOM אגרסיבית** — להפעיל **בזהירות**; אחרי כל שינוי: מעבר מקלדת מלא + דגימת קורא מסך.
5. **לא** להפעיל במקביל תוסף נגישות שני שמוסיף skip links כפולים — לבדוק ב־view-source שאין שני קישורי «דלוג» מתנגשים.

**Fluent Forms (צור קשר):** לוודא שדות עם **תוויות** (labels), הודעות שגיאה קריאות, וסדר טאבים הגיוני — ראו צ'קליסט ב־`LEGAL-ACCESSIBILITY-ISRAEL-SPEC`.

---

## 4. מימוש בקוד (מאגר) — child **ea-eyalamit**

- **`assets/css/home-front.css`:** נוספו כללי **`:focus-visible`** לקישורים ולכפתורי דף הבית (מוקאפ דשבורד) כדי להשלים נראות מיקוד גם כשהתמה/תוסף לא מכסים רכיבים מותאמים.
- **תבנית דף הבית** (`template-home-dashboard.php`): נשמרו `aria-label` לסקשנים ו־`alt` לתמונות — לבדוק אחרי שינויי תוכן.

**שפת מסמך:** בדפים עבריים — `html lang="he-IL"` (מוגדר מ־WordPress כשהשפה עברית). לעמוד EN — מחלקת גוף `ea-lang-en` כמתועד ב־`M2-IMPLEMENTATION-SUMMARY` §2.2.

---

## 5. צ'קליסט QA לצוות 50 (עמידה מול האפיון הפנימי + ת"י כבסיס)

השתמשו ב־[`LEGAL-ACCESSIBILITY-ISRAEL-SPEC.md`](../../docs/project/team-100-preplanning/LEGAL-ACCESSIBILITY-ISRAEL-SPEC.md) §«צ'קליסט בדיקות לפני השקה» ובשורות הבאות:

| # | בדיקה | דף / הערה |
|---|--------|-----------|
| Q-A1 | Tab מלא מהכותרת — **דילוג לתוכן** מגיע ל־`#main` / `#content` ללא מלכודת מיקוד | בית, צור קשר, שירות לדוגמה, EN |
| Q-A2 | **מיקוד נראה** על קישורים, כפתורי תפריט, כפתורי דף הבית (`.ea-home-btn`), שדות Fluent | בית + צור קשר |
| Q-A3 | **H1** אחד לוגי לדף; היררכיית H2–H3 | בית, בלוג, שירות |
| Q-A4 | תמונות משמעותיות — `alt` בעברית/אנגלית לפי השפה | בית |
| Q-A5 | **ניגודיות** — כפתור accent על רקע כהה (דף בית) + קישורי פוטר | בית |
| Q-A6 | **הצהרת נגישות** — עמוד `accessibility-statement` + קישור מהפוטר | כללי |
| Q-A7 | **Lighthouse → Accessibility** — ללא כשלים קריטיים; לא להסתמך על ציון בלבד | דגימה |
| Q-A8 | **קורא מסך** (VoiceOver / NVDA) — דף בית אחד לפחות | בית |

**פלט צוות 50:** `M2-ACCESSIBILITY-QA-REPORT-TEAM50-<תאריך>.md` ב־`_communication/team_50/`.

---

## 6. סטטוס פריסה

לאחר הגדרת התוסף בסטייג'ינג: לעדכן [`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](./M2-IMPLEMENTATION-SUMMARY-2026-04-01.md) §3 אם גרסת התוסף או סטטוס «פעיל» משתנים.

---

*סוף מסמך.*
