---
id: BOOKS-V2-CONTENT-GUIDE-2026-04-10
title: מדריך הזנת תוכן WP Admin — פרק הספרים
audience: team_30
---

# מדריך הזנת תוכן — WP Admin

**גישה:** http://localhost:8088/wp-admin  
**קרא תחילה:** `00-ENTRY-README.md`

---

## 1. עמוד מוזה הוצאה לאור (hub)

**מיקום WP:** Pages → עריכת "מוזה הוצאה לאור" (ID 20, slug: `muzza`)  
**מקור תוכן:** `docs/project/eyal-ceo-submissions-and-responses/from-eyal/CONTENT/EYAL-CONTENT-PKG-2026-04-07-st-books-muzeh/2026-04-07--st-books--content--from-eyal.md`

### מה להזין

**Title (כותרת):** מוזה הוצאה לאור

**Content (תוכן ראשי — Block Editor):**
העתיקו מ-`field:intro` בקובץ התוכן:
- פסקה 1: "מוזה הוצאה לאור הנה הוצאת ספרים עצמית..."
- פסקה 2: "מוזה הוצאה לאור היא הבית של ספריו..."
- פסקה 3: "הספרים שראו כאן אור שונים מאוד..."
- כותרת H3: "למה את הספרים של מוזה תמצאו כאן"
- פסקה "ברכישת ספר דרך רשתות הספרים..."

**Excerpt:** אל תמלאו — לא בשימוש ב-hub.

**Parent:** ← וודאו ש-Parent Page = ריק (hub הוא עמוד ראשי)

**Template:** WordPress יבחר אוטומטית את `template-books-hub.php` לפי ה-slug `muzza`.

### הערות

- ה-bundle section (150 ₪) מוזן אוטומטית ב-template — אין להוסיף ידנית
- Bundle URL הוא placeholder (`#TODO_BUNDLE_URL`) — **אל תשנו אותו עד אישור URL**

---

## 2. כושי בלאנטיס

**מיקום WP:** Pages → "כושי בלאנטיס" (ID 22, slug: `kushi-blantis`)  
**Parent:** מוזה הוצאה לאור (ID 20)  
**מקור תוכן:** `docs/.../EYAL-CONTENT-PKG-2026-04-06-st-book-kushi/`

### מה להזין

**Title:** כושי בלאנטיס

**Excerpt (חשוב!):** תיאור קצר לתצוגה בכרטיס ה-hub:
```
רומן פנטזיה על התעוררות, בחירה, אומץ, והיציאה מהחיים הנוחים מדי — מסע סמלי, צבעוני ומטלטל.
```
(מתוך `field:books_list` ב-muzeh content file)

**Featured Image:** כריכת הספר — team_40 יעלה ויגדיר (ראה `05-MEDIA-ASSETS-GUIDE.md`)

**Content (Block Editor):**
מתוך חבילת התוכן — הגוף המלא של הספר, כולל:
- פסקאות תיאור
- גלריית תמונות (WP Gallery block)
- כפתורי רכישה (WP Buttons block)
  - כפתור ראשי: "לרכישה" → URL חיצוני (Morning.to/Mendele)
  - כפתור משני (is-style-outline): "לאתר ההוצאה" → URL חיצוני

**Parent:** מוזה הוצאה לאור (ID 20)  
**Template:** נבחר אוטומטית לפי slug `kushi-blantis`

---

## 3. צבע בכחול וזרוק לים

**מיקום WP:** Pages → "צבע בכחול וזרוק לים" (ID 21, slug: `tsva-bechol-ve-zorek-layam`)  
**Parent:** מוזה הוצאה לאור (ID 20)  
**מקור תוכן:** `docs/.../EYAL-CONTENT-PKG-2026-04-07-st-book-tsva/`

### מה להזין

**Title:** צבע בכחול וזרוק לים

**Excerpt:**
```
38 סיפורים קצרים ובועטים על הטיול הגדול לדרום אמריקה — על שחרור, בריחה, חופש ובלבול. מהדורה עשירית.
```

**Featured Image:** team_40 יעלה

**Content:** לפי חבילת התוכן (כולל כפתורי רכישה)

**Parent:** מוזה הוצאה לאור (ID 20)  
**Template:** נבחר אוטומטית לפי slug `tsva-bechol-ve-zorek-layam`

---

## 4. וכתבת

**מיקום WP:** Pages → "וכתבת" (ID 23, slug: `vekatavt`)  
**Parent:** מוזה הוצאה לאור (ID 20)  
**מקור תוכן:** `docs/.../EYAL-CONTENT-PKG-2026-04-07-st-book-vekatavt/`

### מה להזין

**Title:** וכתבת

**Excerpt:**
```
46 סיפורים אמיתיים מחיי אייל עמית — ספר אישי וחי על אהבה, מסעות, אובדן וצמיחה. כולל הרחבת QR.
```

**Featured Image:** team_40 יעלה

**Content:** לפי חבילת התוכן, כולל:
- **הסבר QR:** יש לכלול paragraph על אלמנט ה-QR — "הספר כולל קודי QR שמרחיבים את חוויית הקריאה מעבר לדף..."
- כפתורי רכישה

**Parent:** מוזה הוצאה לאור (ID 20)  
**Template:** נבחר אוטומטית לפי slug `vekatavt`

---

## הוראות כלליות — כפתורי רכישה

**ב-Block Editor:**
1. הוסיפו בלוק `Buttons`
2. כפתור ראשי (סגנון ברירת מחדל): טקסט → "לרכישה", URL → כתובת חיצונית
3. כפתור משני: בחרו Style → "Outline", טקסט → "לאתר ההוצאה"

CSS V2 מסגנן אוטומטית:
- ראשי: Terracotta fill, pill 100px
- Outline: ghost עם border Terracotta

**אסור** להוסיף custom class כפתור בלי תיאום עם team_10.

---

## רשימת בדיקה לאחר הזנה

- [ ] כל 4 עמודים: Title מוזן
- [ ] 3 עמודי ספר: Excerpt מוזן (מופיע ב-hub card)
- [ ] 3 עמודי ספר: Featured Image מוגדר (team_40)
- [ ] 3 עמודי ספר: Parent = מוזה (ID 20)
- [ ] "וכתבת": יש פסקת QR
- [ ] Bundle URL = `#TODO_BUNDLE_URL` (לא שוניתם)
- [ ] הצגה: http://localhost:8088/muzza/ — 3 כרטיסים מוצגים

---

## תיעוד בסיום

צרו: `_communication/team_30/BOOKS-V2-CONTENT-ENTRY-DONE-2026-04-10.md`  
עם: רשימת מה הוזן, מה ממתין לתוכן, בעיות שנתקלתם בהן.
