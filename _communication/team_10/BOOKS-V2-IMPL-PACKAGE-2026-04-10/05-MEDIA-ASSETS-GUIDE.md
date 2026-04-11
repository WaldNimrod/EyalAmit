---
id: BOOKS-V2-MEDIA-GUIDE-2026-04-10
title: מדריך נכסי מדיה — כריכות וגלריות
audience: team_40
---

# מדריך נכסי מדיה — פרק הספרים V2

**קרא תחילה:** `00-ENTRY-README.md`

---

## נכסים נדרשים

| נכס | מקור | יעד WP | עמוד |
|-----|------|--------|------|
| כריכת "כושי בלאנטיס" | ראה §1 | Featured Image | ID 22 |
| כריכת "צבע בכחול וזרוק לים" | ראה §2 | Featured Image | ID 21 |
| כריכת "וכתבת" | ראה §3 | Featured Image | ID 23 |
| גלריה — כושי בלאנטיס (4 תמונות) | ראה §4 | Gallery block בתוכן | ID 22 |
| תמונת bundle (אופציונלי) | ראה §5 | Media Library | — |

---

## §1. כריכת "כושי בלאנטיס"

**מקור:**
```
hub/dist/mockups/poc/st-book-kushi-wp-media/cover/kushi-blantis-cover-full.jpg
```

**הוראות:**
1. פתחו את הקובץ, וודאו שיחס צדדים הוא **3:4 (אנכי)** — אם לא, אל תחתכו!
2. WP Admin → Media → Add New → העלו
3. **שם קובץ מחדש לפני העלאה:** `kushi-blantis-cover.jpg` (אנגלית, hyphens, ללא עברית)
4. אחרי העלאה: Pages → כושי בלאנטיס (ID 22) → Featured Image → בחרו את הכריכה

---

## §2. כריכת "צבע בכחול וזרוק לים"

**מקור:** חבילת ZIP:
```
docs/project/eyal-ceo-submissions-and-responses/from-eyal/CONTENT/
EYAL-CONTENT-PKG-2026-04-07-st-book-tsva/final_st-book-tsva_2026-04-07_SINGLE.zip
```

**הוראות:**
1. חלצו את ה-ZIP → חפשו קובץ כריכה (JPG/PNG)
2. **שם קובץ:** `tsva-bechol-cover.jpg`
3. העלו ל-WP Admin → Media
4. Pages → "צבע בכחול וזרוק לים" (ID 21) → Featured Image

---

## §3. כריכת "וכתבת"

**מקור:** חבילת ZIP:
```
docs/project/eyal-ceo-submissions-and-responses/from-eyal/CONTENT/
EYAL-CONTENT-PKG-2026-04-07-st-book-vekatavt/final_st-book-vekatavt_2026-04-07.zip
```

**הוראות:**
1. חלצו את ה-ZIP → חפשו קובץ כריכה
2. **שם קובץ:** `vekatavt-cover.jpg`
3. העלו ל-WP Admin → Media
4. Pages → "וכתבת" (ID 23) → Featured Image

---

## §4. גלריית כושי בלאנטיס (4 תמונות)

**מקור:**
```
hub/dist/mockups/poc/st-book-kushi-wp-media/gallery/
  01-kushi-blantis-1.jpg
  02-eyal-italy-kushi-blantis-3.jpg
  03-screenshot-2013-03-12.png
  04-sinai-yuni-09-151.jpg
```

**הוראות:**
1. שנו שמות לפני העלאה: `kushi-gallery-01.jpg`, `kushi-gallery-02.jpg` וכו'
2. העלו את כל 4 לMWP Admin → Media
3. **אל תגדירו כ-Featured Image** — אלה לגלריה בתוכן בלבד
4. תיעדו את ה-Media IDs בסוף (לעדכן ב-DONE report)

---

## §5. תמונת Bundle (אופציונלי)

**מצב:** TODO — לא נמצאה עדיין תמונת bundle (3 ספרים יחד).

אם נמצאת:
- **שם קובץ:** `muzeh-bundle-3-books.jpg`
- **יחס:** 4:3 (רוחבי)
- **מינימום:** 800px רוחב
- העלו ל-Media Library — **לא כ-Featured Image** עדיין

---

## מפרט טכני מחייב לכל הכריכות

| פרמטר | ערך |
|-------|-----|
| יחס צדדים כריכה | **3:4 אנכי (portrait)** — אסור לשנות |
| רוחב מינימלי | 600px |
| גודל קובץ מקסימלי | 2MB |
| פורמט | JPG (PNG רק אם יש שקיפות) |
| שם קובץ | lowercase-hyphenated, ללא עברית |
| Alt text | `כריכת הספר «[שם ספר]» מאת אייל עמית` |

**למה אסור לשנות יחס 3:4:**
CSS V2 מגדיר `aspect-ratio: 3 / 4` על `.ea-books-hub-card__media`. כריכה עם יחס שונה תיחתך ב-`object-fit: cover`. אם המקור אינו 3:4 — אל תחתכו; דווחו לteam_100.

---

## השפעת V2 על תמונות — מה CSS עושה

| מה | V2 CSS |
|----|--------|
| border-radius כריכה בדף | `4px` (לא 12px כמו Wave1) |
| box-shadow | **אין** |
| border | `1px solid rgba(216,199,181,0.35)` |
| כריכה ב-hub card | `object-fit: cover`, aspect-ratio 3:4 |
| כריכה בדף ספר | float: inline-start (ימין ב-RTL Hebrew), max-width 15rem |

אתם **לא צריכים** לעשות crop ידני — WP ו-CSS מטפלים בהצגה.

---

## גישה ל-WP Admin

```
URL:  http://localhost:8088/wp-admin
Menu: Media → Add New (drag & drop)
```

---

## תיעוד בסיום

1. צרו תיקייה חדשה: `_communication/team_40/`
2. צרו: `BOOKS-V2-MEDIA-DONE-2026-04-10.md`
3. כללו: רשימת נכסים שהועלו עם Media IDs, מה עדיין חסר
