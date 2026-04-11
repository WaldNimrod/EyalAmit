---
id: BOOKS-V2-AUDIT-2026-04-10
title: ביקורת עיצובית — Wave1 vs. V2
---

# ביקורת: Wave1 (קיים) vs. V2 (נדרש)

## מסקנה ראשית

`books-wave1.css` **אינו ניתן לתיקון חלקי.** יש בו 17 הפרות של 6 כללי העיצוב הנעולים (D-EYAL-DESIGN-STYLE-13). הפתרון: קובץ חדש `books-v2.css` שנכתב מאפס תוך ציון כל הפרת Wave1 שתוקנה.

## טבלת הפרות

| אלמנט | Wave1 — קיים (שגוי) | V2 — נדרש | כלל מופר |
|--------|---------------------|-----------|----------|
| פונט כותרת hub | Frank Ruhl Libre 700 | Heebo 200 | כלל 1 — פונט יחיד |
| פונט H1 דף ספר | Amatic SC 700 | Heebo 200 | כלל 1 |
| פונט H2/H3 בגוף | Rubik 600 | Heebo 200/400 | כלל 1 |
| box-shadow כרטיס | 2 שכבות | אין | כלל 3 |
| box-shadow תמונת כריכה | 2 שכבות | אין | כלל 3 |
| box-shadow כפתורי רכישה | כן | אין | כלל 3 |
| border-radius כרטיס | 14px | 0 (flush grid) | כלל 5 |
| border-radius כריכה | 12px | 4px | כלל 5 |
| border-radius כפתורים | 9px | 100px (pill) | כלל 5 |
| border-radius blockquote | 0 10px 10px 0 | 0 | כלל 5 |
| border-radius תמונות | 10px | 4px | כלל 5 |
| רקע כרטיס | linear-gradient | `#FAF8F5` פשוט | כלל 2/3 |
| hover כרטיס | translateY(-3px)+shadow | bg→`#F3EEE8` בלבד | כלל 3 |
| border-bottom כותרת hub | 2px solid | ← קו accent ::after 1px×24px | כלל 4 |
| border-inline-start lead | 4px solid | 1px solid | כלל 4 |
| border blockquote | 4px solid | 1px solid | כלל 4 |
| gap גריד | 1.35rem | 1px | כלל 4 |
| gradient כפתורים | linear-gradient brick→terra | צבע אחיד Terracotta | כלל 2/3 |
| פונטים שנטענים | Frank Ruhl Libre + Amatic SC | Heebo בלבד | כלל 1 |

## 6 הכללים הנעולים (תמצית)

1. **הרבה אוויר** — section padding 80-100px. אין למלא חלל ריק.
2. **אין אייקונים** — רק קווי Terracotta 1px ×20-32px כאלמנט גרפי.
3. **אין shadows** — אפס box-shadow. backdrop-filter רק בנאב.
4. **אין borders כבדים** — 1px בלבד. grid gap: 1px.
5. **פינות: pills (100px) או חדות (0/4px)** — אין ביניים (8/9/12/14/16px).
6. **Terracotta רק בנקודות מגע** — CTA, hover, links. לא כרקע.

## מה לא ניגעים

- CSS variables `--eyal-*` ב-`:root` — מוגדרים ב-`functions.php`, V2 משתמש בהם
- שמות body classes: `ea-books-hub-view`, `ea-book-detail-view` — `theme-shell-fallback.css` תלוי
- slug detection ב-`functions.php` — רק הרחבנו את המערך
- GeneratePress layout hooks — ללא שינוי
