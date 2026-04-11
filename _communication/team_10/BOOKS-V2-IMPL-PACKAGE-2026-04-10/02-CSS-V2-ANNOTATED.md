---
id: BOOKS-V2-CSS-2026-04-10
title: CSS V2 — מפרט מלא ומוער
---

# CSS V2 — books-v2.css

**נתיב:** `site/wp-content/themes/ea-eyalamit/assets/css/books-v2.css`
**סטטוס:** קיים — נכתב על ידי team_100 ב-2026-04-10

הקובץ קיים ומוכן. מסמך זה מספק תיאור מקיף של כל section לצורך הבנה ו-QA.

---

## מבנה הקובץ (30 sections)

| § | מחלקה | תפקיד | כלל מרכזי |
|---|--------|--------|-----------|
| 0 | * (scope) | box-sizing | בסיס |
| 1 | `.reveal` | scroll-reveal utility | כלל 1 |
| 2 | `.ea-btn` | כפתורים משותפים | כלל 3, 5, 6 |
| 3 | `.ea-books-hub` | container | כלל 1 |
| 4 | `.ea-books-hub-title` | כותרת hub + accent line | כלל 2, 4 |
| 5 | `.ea-books-hub-intro` | פתיח טקסט | כלל 1 |
| 6 | `.ea-books-hub-grid` | גריד 3 עמודות | כלל 4 |
| 7 | `.ea-books-hub-card` | כרטיס ספר | כלל 3, 5 |
| 8 | `.ea-books-hub-card__media` | תמונת כריכה בכרטיס | כלל 5 |
| 9 | `.ea-books-hub-card__body` | תוכן כרטיס | כלל 1 |
| 10 | `.ea-books-hub-card__title` | כותרת בכרטיס | כלל 1 |
| 11 | `.ea-books-hub-card__excerpt` | תיאור בכרטיס | כלל 1 |
| 12 | `.ea-books-hub-card__cta` | קישור "לעמוד הספר" | כלל 6 |
| 13 | `.ea-books-hub-empty` | מצב ריק | כלל 4, 5 |
| 14 | `.ea-books-bundle` | bundle CTA section | כלל 1, 2, 6 |
| 15 | `.ea-section-label` | label עיליות | כלל 1 |
| 16 | `.ea-book-detail` | container דף ספר | כלל 1 |
| 17 | `.ea-book-detail h1` | כותרת ספר | כלל 1 |
| 18 | `.ea-book-lead` | lead paragraph | כלל 4 |
| 19 | `.ea-book-cover` | כריכה + float | כלל 3, 5 |
| 20 | `.ea-book-body` | גוף תוכן | כלל 1 |
| 21 | `.ea-book-body h2/h3` | כותרות פנים | כלל 1 |
| 22 | lists | רשימות | RTL |
| 23 | `blockquote` | ציטוטים | כלל 3, 4, 5 |
| 24 | images | תמונות ב-body | כלל 3, 5 |
| 25 | `.wp-block-gallery` | גלריית WP | כלל 4 |
| 26 | `.wp-block-separator` | מפריד | כלל 2 |
| 27 | `.wp-block-buttons` + purchase row | כפתורי רכישה | כלל 3, 5, 6 |
| 28 | `@media max-width: 799px` | mobile single column | spec |
| 29 | focus styles | accessibility | WCAG |
| 30 | `@media print` | הדפסה | — |

---

## ערכים מרכזיים לבדיקה (QA quick reference)

```css
/* כפתורים */
border-radius: 100px;    /* pill — לא 9px, לא 12px */
box-shadow: none;
background-color: var(--eyal-terracotta, #a44e2b); /* flat, no gradient */

/* תמונות */
border-radius: 4px;
box-shadow: none;
border: 1px solid rgba(216, 199, 181, 0.35);

/* כרטיסים בגריד */
border-radius: 0;        /* sharp — flush grid */
box-shadow: none;
background-color: #faf8f5;  /* flat --bg */

/* hover כרטיס */
background-color: #f3eee8;  /* --bg-alt — NO transform */

/* גריד gap */
gap: 1px;
background-color: rgba(216, 199, 181, 0.35); /* grid parent — creates the 1px line */

/* H1 דף ספר */
font-family: "Heebo", sans-serif;
font-size: 2.8rem;
font-weight: 200;
letter-spacing: -0.5px;

/* accent line (::after ב-hub title) */
width: 24px; height: 1px;
background-color: var(--eyal-terracotta);

/* lead paragraph border */
border-inline-start: 1px solid var(--eyal-terracotta); /* NOT 4px */
```

---

## RTL — נכסים לוגיים בשימוש

| Property | משמעות ב-RTL (Hebrew) |
|----------|----------------------|
| `padding-inline-start` | padding-right |
| `border-inline-start` | border-right |
| `float: inline-start` | float: right (כריכה מופיעה מימין לטקסט) |
| `margin-inline` | margin-right + margin-left (centering) |
| `margin-inline-end` | margin-left |

---

## CSS Variables — reference

CSS V2 משתמש ב-`--eyal-*` variables שמוגדרים ב-`:root` ע"י `ea_eyalamit_enqueue_palette_root_overrides()` ב-`functions.php`. אסור לשכפל אותם ב-`books-v2.css`.

| Variable | HEX | שימוש |
|----------|-----|-------|
| `--eyal-ink` | #2E2B28 | טקסט ראשי, H1 |
| `--eyal-terracotta` | #A44E2B | accent, CTA primary, links |
| `--eyal-brick` | #AB3A2B | CTA hover, strong CTA |
| `--eyal-earth` | #8A5A44 | טקסט גוף, meta |
| `--eyal-chocolate` | #5C3A2E | כותרות ספר, כותרת כרטיס |
| `--eyal-sand` | #D8C7B5 | placeholder כריכה |
| `--eyal-olive` | #6E6F4A | H2 בתוך book body |
| `--eyal-line` | rgba(216,199,181,0.35) | קווי הפרדה, grid background |
| `--eyal-muted` | #A8A19B | section labels |
