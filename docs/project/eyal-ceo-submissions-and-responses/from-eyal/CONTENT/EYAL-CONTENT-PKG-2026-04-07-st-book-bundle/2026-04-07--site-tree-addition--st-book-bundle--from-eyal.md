# הצעת תוספת לעץ האתר הנעול

סטטוס: `pending-approval`

## node
- `id`: `st-book-bundle`
- `parentId`: `st-books`
- `treeOrder`: `4`
- `titleHe`: `חבילת 3 הספרים של אייל עמית`
- `slug`: `muzeh/3-books-bundle`
- `templateId`: `tpl-secondary`
- `menuHint`: `רמה 2 · תחת מוזה הוצאה לאור`

## rationale
- התוספת שומרת על עץ הספרים הקיים ומוסיפה עמוד משני אחד בלבד תחת מוזה הוצאה לאור.
- העמוד החדש אינו דף מבצעים כללי אלא דף bundle ממוקד.
- בחירה ב-`tpl-secondary` מאפשרת עמוד תוכן מלא עם הסבר, פירוט קצר על כל ספר ו-CTA ברור, בלי לפתוח תבנית חדשה בשלב זה.

## legacy mapping
- דף המקור הישן: עמוד המבצעים תחת מדור הספרים.
- בעמוד החדש נשמר רק מבצע אחד: שלושת הספרים יחד.

## implementation note
- יש לעדכן `site-tree.json` לפני ingest של קובצי התוכן.
- יש לספק `bundleCheckoutUrl` סופי במקום `TODO_BUNDLE_CHECKOUT_URL`.
