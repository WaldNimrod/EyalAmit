---
id: BOOKS-V2-QA-2026-04-10
title: רשימת בדיקות קבלה — פרק הספרים V2
---

# QA — פרק הספרים V2

**כלי:** DevTools (Chrome/Firefox) + Visual inspection + Network tab  
**סביבה:** http://localhost:8088  
**מדד הצלחה:** אפס הפרות מ-6 כללי העיצוב + תוכן מלא בכל 4 עמודים

---

## A. בדיקות HTTP ו-PHP

```bash
# כל 4 עמודים צריכים לחזיר HTTP 200
curl -sI http://localhost:8088/muzza/                          | head -1
curl -sI http://localhost:8088/muzza/kushi-blantis/            | head -1
curl -sI http://localhost:8088/muzza/tsva-bechol-ve-zorek-layam/ | head -1
curl -sI http://localhost:8088/muzza/vekatavt/                 | head -1
```

- [ ] כל 4 עמודים: `HTTP/... 200 OK`
- [ ] אין PHP notices/warnings ב-WP_DEBUG log
- [ ] `php -l functions.php` → No syntax errors

---

## B. CSS — עיצוב (כלל 1-6)

פתחו DevTools → Inspector → בדקו כל אלמנט:

### כלל 1: Heebo בלבד
- [ ] Network tab → Fonts: **Heebo** נטען, לא Frank Ruhl Libre, לא Amatic SC
- [ ] Inspector: `.ea-books-hub-title` → `font-family: "Heebo"`, `font-weight: 200`
- [ ] Inspector: `.ea-book-detail h1` → `font-family: "Heebo"`, `font-weight: 200`
- [ ] Inspector: `.ea-book-body h2` → `font-family: "Heebo"`, `font-weight: 200`
- [ ] Inspector: `.ea-book-body h3` → `font-family: "Heebo"`, `font-weight: 400`

### כלל 2: רק קווי accent כאלמנט גרפי
- [ ] `.ea-books-hub-title::after` → `width: 24px`, `height: 1px`, `background-color: #a44e2b`
- [ ] `.ea-books-bundle__accent` → `width: 24px`, `height: 1px`
- [ ] אין אייקונים בשום מקום

### כלל 3: אפס shadows
- [ ] Inspector על `.ea-books-hub-card` → `box-shadow: none`
- [ ] Inspector על `.ea-book-cover img` → `box-shadow: none`
- [ ] Inspector על כפתורי רכישה → `box-shadow: none`
- [ ] Inspector על כפתור `.ea-btn` → `box-shadow: none`

### כלל 4: 1px בלבד
- [ ] `.ea-book-lead` → `border-inline-start: 1px solid` (לא 4px!)
- [ ] `blockquote` → `border-inline-start: 1px solid`
- [ ] Grid gap → בדקו ב-Computed: `gap: 1px`
- [ ] `.ea-books-hub-grid` background color = `rgba(216, 199, 181, 0.35)`

### כלל 5: pills (100px) או חדות (0/4px)
- [ ] כפתורי `.ea-btn` → `border-radius: 100px`
- [ ] `.wp-block-button__link` → `border-radius: 100px` (via !important)
- [ ] `.ea-book-cover img` → `border-radius: 4px` (לא 12px!)
- [ ] `.ea-books-hub-card` → `border-radius: 0`
- [ ] `.wp-block-image img` → `border-radius: 4px`
- [ ] `blockquote` → `border-radius: 0`

### כלל 6: Terracotta רק בנקודות מגע
- [ ] `.ea-btn--primary` background = `#a44e2b` (flat, לא gradient)
- [ ] `.ea-books-hub-card` background = `#faf8f5` (לא Terracotta)
- [ ] `.ea-books-bundle` background = `#f3eee8` (לא Terracotta)
- [ ] `.ea-book-lead` border = 1px Terracotta (קו דק — בסדר)

---

## C. Hover States

- [ ] Hover על כרטיס hub → `background-color` משתנה ל-`#f3eee8`, **ללא transform**
- [ ] Hover על כרטיס hub → **אין** `translateY` ב-Computed Transforms
- [ ] Hover על `.ea-btn--primary` → background משתנה ל-`#ab3a2b`, ללא shadow

---

## D. Layout ו-Grid

- [ ] Hub desktop (>800px): 3 עמודות (`repeat(3, minmax(0, 1fr))`)
- [ ] Hub tablet (540-799px): 2 עמודות
- [ ] Hub mobile (<800px): 1 עמודה
- [ ] סרגל צד: **אין** (GeneratePress no-sidebar)
- [ ] כותרת GeneratePress מוסתרת (H1 מגיע מהתבנית, לא מ-GP)

---

## E. תוכן

### עמוד מוזה (/muzza/)
- [ ] כותרת: "מוזה הוצאה לאור"
- [ ] Intro text מוזן (פסקאות על ההוצאה)
- [ ] 3 כרטיסים מוצגים עם כריכה, כותרת, excerpt, קישור
- [ ] Bundle section מוצג אחרי הגריד
- [ ] Bundle: כותרת "חבילת 3 הספרים", "150 ₪ במקום 207 ₪"
- [ ] 2 כפתורי bundle (primary + ghost)

### עמוד כושי בלאנטיס (/muzza/kushi-blantis/)
- [ ] H1: "כושי בלאנטיס"
- [ ] Lead (excerpt) מוצג
- [ ] כריכה מוצגת (float ימין בדסקטופ)
- [ ] גוף תוכן מוזן
- [ ] כפתורי רכישה מוצגים

### עמוד צבע בכחול (/muzza/tsva-bechol-ve-zorek-layam/)
- [ ] H1: "צבע בכחול וזרוק לים"
- [ ] Lead מוצג
- [ ] כריכה מוצגת
- [ ] כפתורי רכישה

### עמוד וכתבת (/muzza/vekatavt/)
- [ ] H1: "וכתבת"
- [ ] Lead מוצג
- [ ] כריכה מוצגת
- [ ] **QR note מוצג** בגוף
- [ ] כפתורי רכישה

---

## F. Scroll Reveal

- [ ] Network tab: `books-reveal.js` נטען
- [ ] רענן עמוד, גלול ← אלמנטים `.reveal` נכנסים עם fade-up
- [ ] אלמנטים שנצפו לא מוסתרים חזרה

---

## G. Accessibility

- [ ] כל הכפתורים: `:focus-visible` מציג outline Terracotta
- [ ] כריכות: alt text מוזן
- [ ] `.ea-books-hub-grid` יש `role="list"`
- [ ] `.ea-books-hub-empty` יש `role="status"`

---

## סיכום QA

| קטגוריה | עבר | נכשל |
|---------|-----|------|
| HTTP + PHP | | |
| CSS כלל 1 (Heebo) | | |
| CSS כלל 2 (accent) | | |
| CSS כלל 3 (no shadows) | | |
| CSS כלל 4 (1px) | | |
| CSS כלל 5 (radius) | | |
| CSS כלל 6 (Terracotta) | | |
| Layout + Grid | | |
| תוכן (4 עמודים) | | |
| Scroll Reveal | | |
| Accessibility | | |

**Go/No-Go לפגישה:** כל הקטגוריות ירוק = ✅ מוכן
