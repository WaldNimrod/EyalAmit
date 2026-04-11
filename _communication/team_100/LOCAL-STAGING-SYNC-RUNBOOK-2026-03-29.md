# סנכרון מקומי–סטייג’ינג + Wave1 ספרים — runbook

**תאריך תיעוד:** 2026-03-29  
**מטרה:** סביבת פיתוח מסודרת (Docker מקומי — פגישות הדגמה מול **localhost**, לא חובה סטייג’ינג), מקור אמת לקוד ב־Git, ותוכן חי מסונכרן אחרי ייבוא/פריסה.

---

## 1. מיפוי פער (מאגר ↔ סטייג’ינג ↔ מקומי)

### 1.1 מצב מאגר (repo) — snapshot

| רכיב | מיקום | הערה |
|------|--------|------|
| Child theme | [`site/wp-content/themes/ea-eyalamit/`](../../site/wp-content/themes/ea-eyalamit/) | כולל Wave1: `template-books-hub.php`, `template-book-detail.php`, CSS ייעודי |
| זרע עמודים (WXR) | [`site/exports/m2-pages-seed.wxr`](../../site/exports/m2-pages-seed.wxr) | בסיס M2; שער מוזה קנוני **`muzza`** (לא `muzeh`); ילדים למשל `muzza/kushi-blantis` — מיושר ל־[`hub/data/site-tree.json`](../../hub/data/site-tree.json) |
| מדיה Wave1 | [`site/wp-content/uploads/ea-wave1-media/README.md`](../../site/wp-content/uploads/ea-wave1-media/README.md) | קליטה לפני שילוב ב־Media Library |
| Docker מקומי | [`local/docker-compose.yml`](../../local/docker-compose.yml) | פורט 8088, bind ל־`site/wp-content` |

### 1.2 צ’קליסט השוואה לסטייג’ינג (ידני)

בצע לפני/אחרי סנכרון:

- [ ] **תמה / MU-plugins:** השווה `wp-content/themes/ea-eyalamit` ו־`mu-plugins` מול המאגר — עריכות ישירות בשרת חייבות commit.
- [ ] **עמודים:** רשימת עמודים (במיוחד `muzza`, ילדי מוזה, טיפול) מול `site-tree.json`.
- [ ] **uploads:** ספרים / כריכות — האם קיימים רק בסטייג’ינג; אם כן, סנכרן תיקיות או העלאה מחדש לפי מניפסט.

**כתובת סטייג’ינג (קנוני):** ראו [`docs/project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md`](../../docs/project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md).

---

## 2. ייבוא חד־פעמי למקומי (Docker)

**בוצע בתאריך התיעוד:** ייבוא [`m2-pages-seed.wxr`](../../site/exports/m2-pages-seed.wxr) דרך WP-CLI אחרי התקנת `wordpress-importer`.

### 2.1 שלבים

1. `cd local && docker compose up -d`
2. העתקת WXR לקונטיינר: `docker cp …/site/exports/m2-pages-seed.wxr <container>:/tmp/m2-pages-seed.wxr`
3. `wp plugin install wordpress-importer --activate`
4. `wp import /tmp/m2-pages-seed.wxr --authors=create`
5. **מבנה קישורים:** `wp rewrite structure '/%postname%/' --hard` ואז `wp rewrite flush`
6. **Apache:** אם כל העמודים מחזירים 404 — ודא שקובץ `.htaccess` תחת document root של WordPress מכיל בלוק `mod_rewrite` הסטנדרטי (ראו תיעוד WP). בסביבת Docker מקומית ייתכן ש־`wp rewrite flush --hard` לא ימלא את הבלוק; יש לכתוב ידנית את כללי ה־rewrite בין `# BEGIN WordPress` ל־`# END WordPress`.

### 2.2 אזהרה — כפילויות

אם המקומי כבר הכיל עמודים מאותם slugs והייבוא רץ שוב, ייווצרו כפילויות (למשל `books` מול `muzza`). עדיף ייבוא על DB נקי או מחיקת טיוטות כפולות לפני ייבוא.

---

## 3. יישום Wave1 — תבניות ספרים

| תבנית Hub | slug (site-tree) | קובץ PHP |
|-----------|-------------------|----------|
| `tpl-books` | `muzza` | `page-templates/template-books-hub.php` |
| `tpl-book-detail` | `kushi-blantis` (ניתן להרחבה בפילטר) | `page-templates/template-book-detail.php` |

הצמדה אוטומטית ב־`functions.php` (מסנן `template_include`), עיצוב ב־`assets/css/books-wave1.css`.

---

## 4. דמו / פגישה — סביבת פיתוח (מקומי)

**ברירת מחדל לפגישות צוות:** `http://localhost:8088` (Docker). אין צורך בסטייג’ינג לשם הדגמה טכנית.

### 4.1 (אופציונלי) פריסה לסטייג’ינג

1. Commit + push למאגר.
2. העלאת `site/wp-content/themes/ea-eyalamit/` (ובמידת הצורך `mu-plugins`) ב־FTP/SFTP לפי [`local/README.md`](../../local/README.md) והסקיל `eyalamit-staging-ftp`.
3. נקה מטמון אם קיים תוסף cache.

### 4.2 מילוי תוכן לפגישה (מינימום)

- [ ] עמוד **מוזה** (`/muzza/`) — פתיח בגוף העמוד; כרטיסי ילדים נמשכים אוטומטית מעמודי המשנה.
- [ ] עמוד **כושי בלאנטיס** (`/muzza/kushi-blantis/`) — תקציר, תוכן, תמונה ראשית (כריכה), קישורי רכישה חיצוניים בגוף העמוד (ללא סליקה מוטמעת).
- [ ] בדיקת RTL, מובייל, וקישורים עם `rel="noopener"` לדומיינים חיצוניים.

**מיגרציה מ־slug ישן:** אם עמוד השער עדיין `muzeh`, לעדכן ל־`muzza` (ניהול עמודים או `wp post update <ID> --post_name=muzza`). קישורי legacy `/muzeh/` מקבלים 301 ל־`/muzza/` דרך MU (ראו `ea-m2-site-tree-lock-sync-once.php`).

### 4.3 אימות מקומי אחרי שינוי תמה

`http://localhost:8088/muzza/` ו־`http://localhost:8088/muzza/kushi-blantis/` — קוד 200 אחרי תיקון permalinks + `.htaccess`.

---

## 5. החלטות מקור אמת

| נושא | החלטה |
|------|--------|
| קוד (תמה, MU מותאמים) | **Git / המאגר** — לא להשאיר שינוי רק בשרת |
| תוכן ומדיה אחרי סנכרון | מקומי מסונכרן לסטייג’ינג **או** סטייג’ינג כיעד פריסה — לתעד תאריך סנכרון |
| עץ ו־slugs | [`hub/data/site-tree.json`](../../hub/data/site-tree.json); שינוי — לפי נוהל צוות 100 |
