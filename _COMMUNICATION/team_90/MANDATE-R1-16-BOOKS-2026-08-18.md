# MANDATE — team_90 · Composer · R1-16 `/books/` content contract

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
דסקטופ בלבד. http://eyalamit-co-il-2026.s887.upress.link/books/
`curl -sk` מותר בסטייג'ינג. פלט ריק = FAIL. `-fast` אסור.

## ארבעת סעיפי החוזה

התאמת מקור · האנק ממופה · Provenance · פלט ריק=FAIL.

**מקור:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/מוזה הוצאה לאור - ספרים/MUZZA.md`

## סעיפים ממופים

- `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/muzza-defaults.php`
- `chapters-render.php` (דילוג ACF ל-`muzza`)
מורשה גם shop/about/mokesh-defaults (גל מקביל).
אסור: ילדי ספרים · `template-books-hub.php` · `videoblk.php` · `block-faq-list.php`.

## HTML חי (`<main>`)

1. H1 `מוזה הוצאה לאור`. H2 רק מ-### במסמך: «למה את הספרים של מוזה תמצאו כאן» · «חבילת 3 הספרים של אייל עמית» · «שלושה ספרים, שלושה עולמות». אין H2 «הספרים של מוזה» / «סגירת עמוד».
2. CTA כרטיסים: «לעמוד הספר צבע בכחול וזרוק לים» · «לעמוד הספר כושי בלאנטיס» · «לעמוד הספר וכתבת». אין meta «2001 · מסעות».
3. כפתור אחד `לרכישת חבילת 3 הספרים` → `https://mrng.to/MTUiO3vkIg`. אין `pending-note` / «ממתין לאישור».
4. מדיה BK-04/05/06 ממתינה לאייל — לא FAIL.

`qa_probe` דסקטופ. שורה ראשונה `VERDICT: PASS` או `VERDICT: FAIL`.
