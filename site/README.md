# עץ פריסה קנוני — WordPress (מה שעולה לשרת)

תיקייה זו היא **שורש הארטיפקטים** שמיועדים לפריסה ל־**uPress** (או סביבה מקבילה): תוכן שמגיע מ־**Git** כחלק מהאתר הסופי.

## מה שייך לכאן

- `wp-content/themes/ea-eyalamit/` — **child** נעול לאפיון ([`SITE-SPECIFICATION-FINAL`](../docs/project/team-100-preplanning/SITE-SPECIFICATION-FINAL-2026-03-30.md) §1.2.1); כל התאמה מותגית/PHP נוסף — כאן בלבד, קידומת **`ea_`**
- `wp-content/mu-plugins/ea-staging-noindex.php` — `noindex` לסטייג'ינג **uPress** (`*.upress.link` בלבד); ראו runbook §8
- `exports/m2-pages-seed.wxr` — **ייבוא עמודי מעטפת M2** (§7); נוצר מ־[`scripts/m2_emit_pages_wxr.py`](../scripts/m2_emit_pages_wxr.py) — אחרי ייבוא: **הגדרות → קריאה** (דף בית סטטי = «בית», עמוד פוסטים = «בלוג»)
- **GeneratePress (parent)** — **לא** נשמר במאגר; התקנה בשרת מממשק WP או מ־[wordpress.org/themes/generatepress](https://wordpress.org/themes/generatepress/)

## פריסה ראשונה לסטייג'ינג (תמצית)

1. התקנת **GeneratePress** ב־wp-admin.  
2. **FTP:** להעלות `themes/ea-eyalamit/` → `wp-content/themes/ea-eyalamit/`.  
3. **FTP:** להעלות `mu-plugins/ea-staging-noindex.php` → `wp-content/mu-plugins/`.  
4. להפעיל את תבנית **EA Eyal Amit**; לוודא permalink `/%postname%/`.  
5. **ייבוא:** כלים → ייבוא → `exports/m2-pages-seed.wxr` — אחר כך **הגדרות → קריאה** (בית סטטי, בלוג).  
6. מסירה / סיכום G2: [`_communication/team_10/M2-HANDOFF-FROM-20-2026-03-31.md`](../_communication/team_10/M2-HANDOFF-FROM-20-2026-03-31.md) · [`_communication/team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](../_communication/team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md).

## פיתוח מקומי (Docker)

ב־[`local/docker-compose.yml`](../local/docker-compose.yml) ניתן (אופציונלי) למפות את כל `wp-content` מהמאגר — להחליף את נפח `wp_data` של `wordpress` בשורת bind-mount מוצגת בהערות בקובץ. **שימו לב:** מיפוי מלא מחליף את תוכן `wp-content` בקונטיינר; מתאים כשמפתחים רק מהמאגר.

## מה לא שייך לכאן

- `_communication/`, `docs/`, `scripts/`, `.cursor/` — נשארים בשורש המאגר ו־**לא** מועלים לשרת.

## ליבת WordPress

לרוב ב־uPress ליבת WP מנוהלת ע"י האחסון או מתעדכנת דרך הממשק. אם יוחלט אחרת (למשל ליבה ב־Git), יתועד ב־`_communication/team_20/M2-RUNBOOK-ENV-*.md`.

**מדיניות מלאה:** [`docs/project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md`](../docs/project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md).
