---
id: BOOKS-V2-PHP-2026-04-10
title: שינויי PHP — functions.php + templates
---

# שינויי PHP — V2

**סטטוס:** כל השינויים בוצעו על ידי team_100 ב-2026-04-10.
מסמך זה לתיעוד, אימות ו-reference עתידי.

---

## אימות: האם השינויים הוחלו?

```bash
# בדיקת slugs — צריך להחזיר את 3 הספרים
grep -A6 "ea_eyalamit_get_book_detail_slugs" \
  site/wp-content/themes/ea-eyalamit/functions.php

# בדיקת CSS handle — צריך לראות books-v2 ולא books-wave1
grep "books-v2\|books-wave1" \
  site/wp-content/themes/ea-eyalamit/functions.php

# בדיקת PHP syntax
php -l site/wp-content/themes/ea-eyalamit/functions.php
php -l site/wp-content/themes/ea-eyalamit/page-templates/template-books-hub.php
php -l site/wp-content/themes/ea-eyalamit/page-templates/template-book-detail.php
```

**תוצאה צפויה לכל php -l:** `No syntax errors detected`

---

## שינוי A — הרחבת book detail slugs

**קובץ:** `functions.php`
**פונקציה:** `ea_eyalamit_get_book_detail_slugs()`

**לפני:**
```php
array( 'kushi-blantis' )
```

**אחרי:**
```php
array(
    'kushi-blantis',
    'tsva-bechol-ve-zorek-layam',
    'vekatavt',
)
```

**למה:** הפונקציה `ea_eyalamit_is_book_detail_view()` בודקת את ה-slug מול המערך הזה. בלי הרחבה, עמודי "צבע בכחול" ו-"וכתבת" לא מקבלים את ה-template הנכון, לא נטענת CSS, ולא מוסתרת כותרת GeneratePress.

---

## שינוי B — החלפת font enqueues + CSS handle

**קובץ:** `functions.php`
**פונקציה:** `ea_eyalamit_books_wave1_assets` → `ea_eyalamit_books_v2_assets`

**מה הוסר:**
- `ea-eyalamit-fonts-frank-ruhl` (Frank Ruhl Libre) — הפר כלל 1
- `ea-eyalamit-fonts-amatic` (Amatic SC) — הפר כלל 1
- תלות ב-`ea-eyalamit-fonts-rubik` ב-books CSS

**מה נוסף:**
- `ea-eyalamit-fonts-heebo` — Heebo wght@100;200;300;400;500;600
  (עם `wp_style_is()` guard למניעת double-load עתידי)
- `ea-eyalamit-books-v2` — טוען `books-v2.css`
- `ea-eyalamit-books-reveal` — טוען `books-reveal.js` (footer)

**הערה לעתיד:** כשהתבנית תעבור גלובלית ל-Heebo (במקום Rubik), יש להעביר את enqueue של Heebo מכאן ל-`ea_eyalamit_enqueue_styles()` ולהסיר את ה-guard כאן.

---

## שינוי C — שינוי שמות פונקציות (קוסמטי)

| לפני | אחרי |
|------|------|
| `ea_eyalamit_books_wave1_body_class` | `ea_eyalamit_books_v2_body_class` |
| `ea_eyalamit_books_wave1_sidebar_layout` | `ea_eyalamit_books_v2_sidebar_layout` |
| `ea_eyalamit_books_wave1_hide_title` | `ea_eyalamit_books_v2_hide_title` |

**חשוב:** שמות ה-body classes **לא השתנו**: `ea-books-hub-view` ו-`ea-book-detail-view` — `theme-shell-fallback.css` תלוי בהם.

---

## template-books-hub.php — שינויים

1. הוספת `id="books-grid"` ל-`<ul>` (anchor לכפתור "לכל הספרים")
2. הוספת `class="reveal"` ל-`.ea-books-hub-intro` ולגריד
3. **bundle section חדש** אחרי `</ul>`:
   - `.ea-books-bundle` עם `.ea-books-bundle__accent` (קו 1px×24px)
   - `.ea-section-label` "הצעה מיוחדת"
   - H2 + desc + 2 כפתורי EA (primary + ghost)
   - Bundle URL: `#TODO_BUNDLE_URL` — placeholder עד אישור

---

## template-book-detail.php — שינויים

1. הוספת `class="reveal"` ל-`<h1>`, ל-`.ea-book-lead`, ל-`.ea-book-detail__cover-clearfix`, ל-`.ea-book-body`
2. אין שינוי לוגי — PHP structure זהה, רק reveal classes

---

## books-reveal.js — קובץ חדש

**נתיב:** `site/wp-content/themes/ea-eyalamit/assets/js/books-reveal.js`

IntersectionObserver, threshold 0.15.
כל `.reveal` שנכנס ל-viewport מקבל `.visible`.
Fallback: אם אין IntersectionObserver — כל האלמנטים מוצגים מיד.
