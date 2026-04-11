# Wave1 — תיקיית מדיה (WordPress)

**מטרה:** קליטה, בדיקה, תיוג והכנה לשילוב ב־Media Library ובעמודי התבנית (GeneratePress child `ea-eyalamit`).

## מבנה מומלץ

| תיקייה | תוכן |
|--------|------|
| `brand/` | לוגו, favicon, וריאציות מותג |
| `atmosphere/` | תמונות אווירה כלליות (לא ספר ספציפי) |
| `books/<pageId>/` | כריכה, גלריה ותמונות לפי מזהה עמוד (למשל `st-book-kushi`) |
| `treatment/` | נכסים לעמוד `st-svc-treatment` |

## קובץ מפת־מדיה

להוסיף בשורש זה (או ב־`docs/project/`) קובץ `MEDIA-MANIFEST-WAVE1.csv` עם עמודות מינימום:

`filename`, `target_page_id`, `asset_type` (cover|gallery|brand|hero|other), `source` (legacy|drive|new), `status` (draft|approved), `wp_attachment_id` (אחרי העלאה).

## תהליך

1. קליטה מצוות 80 / אייל / לגאסי — שמירה כאן בשמות יציבים (אנגלית־קישורית).
2. בדיקת רזולוציה ופורמט (WebP/JPEG; מקסימום סביר לרוחב עמוד).
3. תיוג לפי עמוד וסוג נכס.
4. העלאה ל־WP (ממשק מדיה או סקריפט) — עדכון העמודה `wp_attachment_id` במניפסט.
5. קישור בעריכת עמוד (ACF/Gutenberg) לפי תבנית.

**נוהל מפורט:** [`docs/sop/PAGE-PACKAGE-CLIENT-POC-MANDATORY.md`](../../../../docs/sop/PAGE-PACKAGE-CLIENT-POC-MANDATORY.md) (מדיה אמיתית, ללא placeholder מטעה בפרזנטציה ללקוח).
