# MANDATE — team_90 · Composer · S006 חוזה א׳ (SEO chrome + FAQ 404 items)

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ בלבד. TLS פג בכוונה — `curl -sk` מותר כאן בלבד. פלט ריק = FAIL. `-fast` אסור.
**אל תשנה** PHP / JSON / אקסל / טרקר. רק פסק הדין.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`

סקואופ team_00 18.8.26: ניקוי כרום צוות 80 ממטא שיתוף + רישום שלושת קישורי FAQ השבורים בטרקר. **לא** ממפים URL. **לא** פותחים H1 עם `<em>`.

בסיס: `http://eyalamit-co-il-2026.s887.upress.link`

## ארבעת סעיפי החוזה

1. `/testimonials/` head — `og:description` ו-`meta name="description"` **אינם** מכילים `PLACEHOLDER` / `צוות 80` / `לא לאישור פרסום`. העותק הצפוי הוא תת-הכותרת הקיימת: `סרטונים, הקלטות, וכתבות על העבודה עם הנשימה והדיג׳רידו.` H1 ב-`<main>` נשאר `מדיה <em>ווידאו</em>` (M-03 — אל-נפתח).
2. `/faq/` — שלושת ה-href מ-FAQ FINAL.md **נשארים** ב-`<main>`: `/blog/pregnancy-didgeridoo` · `/muse` · `/cbDidg-therapy-training`. **אין** המרה שקטה ל-`/books/` או ל-`/learning/therapist-training/`. H1 FAQ בלי `<em>`.
3. טרקר — ב-`latest-items.csv` קיימים FAQ-05, FAQ-06, FAQ-07 במצב `ממתין לאייל`. FAQ-01…04 לא נמחקו. שורת R1-25 `ממתין ל` = `אייל`. `--append` לא דרס מפתחות קיימים.
4. האנק לא ממופה — שינוי ב-`media-defaults.php` (H1), `block-faq-list.php`, `ea-faq-seed.json`, `muzza-defaults.php`, `videoblk.php`, או defaults של הקפאות (learning/lectures/workshops/galleries/therapist-training) → FAIL.

## קבצים ממופים (הגל הזה)

- `site/wp-content/themes/ea-eyalamit/inc/seo-head-fallbacks.php`
- `site/wp-content/mu-plugins/ea-s006-strip-team80-seo-once.php` (חדש, untracked עד commit)
- `scripts/ftp_deploy_site_wp_content.py`
- `scripts/tracker_page_tab.py` (`--append`)
- `scripts/tracker_render.py`
- `_COMMUNICATION/team_100/S006/tracker/r1-25-items.json`

## איך לבדוק

```
curl -sk 'http://eyalamit-co-il-2026.s887.upress.link/testimonials/?nc=1' | grep -E 'og:description|name="description"|<h1'
curl -sk 'http://eyalamit-co-il-2026.s887.upress.link/faq/?nc=1' | grep -E 'pregnancy-didgeridoo|/muse|cbDidg-therapy-training|/learning/therapist-training'
```

טרקר: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/latest-items.csv`
שורות אב: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/latest.csv`

כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-SEO-FAQ-CONTRACT-A-2026-08-18.md`
