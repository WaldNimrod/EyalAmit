# M2 — ארטיפקט פריסה + אימות סטייג’ינג (אוטומטי מהמאגר)

**תאריך בדיקה (שרת):** 2026-04-06 (כותרות `Date` מ־nginx בבדיקות `curl`)  
**בסיס:** `http://eyalamit-co-il-2026.s887.upress.link`  
**מטרה:** הוכחה ש־FTP מהמאגר בוצע ושהאתר משקף את חבילת העץ הנעול אחרי טעינת דף הבית.

---

## 1. פריסה (FTP מהמאגר)

פקודה (משורש המאגר, עם `local/.env.upress`):

```bash
pip install -r scripts/requirements-upress.txt
python3 scripts/ftp_deploy_site_wp_content.py
```

**תיקון נלווה:** `scripts/ftp_deploy_site_wp_content.py` עודכן לכלול גם  
`wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php` (לפני כן הקובץ לא הועלה בסקריפט).

**פלט מוצלח (תמצית):**  
`OK:` לכל קבצי child `ea-eyalamit` + MU: `ea-staging-noindex.php`, `ea-m2-auto-activate-child.php`, `ea-m2-ensure-fluent-active.php`, `ea-m2-seed-shell-once.php`, **`ea-m2-site-tree-lock-sync-once.php`** — ואז `Done: FTP deploy...`.

---

## 2. טריגר ריצת WordPress / סנכרון

לאחר ה־FTP בוצע `GET /` (HTTP **200**) כדי לאפשר `init` והרצת סנכרון העץ (אופציה `ea_m2_site_tree_lock_sync_v2`).

---

## 3. בדיקות נתיבים (HTTP ללא מעקב הפניות)

| נתיב | קוד |
|------|-----|
| `/learning/` | 200 |
| `/treatment/` | 200 |
| `/faq/` | 200 |
| `/privacy/` | 200 |
| `/galleries/` | 200 |
| `/media/` | 200 |
| `/learning/courses-external/` | 200 |
| `/accessibility/` | 200 |
| `/en/` | 200 |

---

## 4. הפניות 301 (כותרות בלבד)

דוגמה — `/shop/`:

```http
HTTP/1.1 301 Moved Permanently
Location: http://eyalamit-co-il-2026.s887.upress.link/tools-and-accessories/
```

נבדקו גם: `/courses-soon/`, `/hashita/`, `/books/`, `/testimonials-media/`, `/didgeridoo-treatment-breath/`, `/accessibility-statement/`, `/courses-external/` — כולם **301** ליעד הקנוני לפי MU.

---

## 5. דגימת HTML — דף הבית

מקור: גוף התשובה של `GET /` (נשמר לניתוח).

- **EN בהדר:** מופיע  
  `<span class="ea-header-en-wrap"><a class="ea-header-en-link" href=".../en/" ...>EN</a></span>`  
  לפני כפתור התפריט — לא כפריט בתוך רשימת ה־primary בלבד.
- **תפריט primary:** פריט ראשון מקושר ל־`/treatment/` (לא legacy).
- **תוכן בית:** קישורי «טיפול» מצביעים ל־`/treatment/` (לא `didgeridoo-treatment-breath`).
- **פוטר משפטי:**  
  `<nav class="ea-footer-legal-nav" ...><ul id="menu-m2-footer-ea" class="ea-footer-legal-menu">`  
  עם קישור ל־`/faq/` (ושאר פריטי התפריט נבנים מ־MU).

---

## 6. עמוד EN — שפת מסמך

מקור: תחילת גוף `GET /en/`:

```html
<!DOCTYPE html>
<html lang="en" dir="ltr">
```

---

*מסמך זה הוא ראיה טכנית לפריסה ולא מחליף דוח צוות 50 (FINAL).*
