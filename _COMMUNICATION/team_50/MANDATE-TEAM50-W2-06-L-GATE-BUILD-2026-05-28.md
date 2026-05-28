---
id: MANDATE-TEAM50-W2-06-L-GATE-BUILD-2026-05-28
title: team_50 mandate — L-GATE_BUILD for WP-W2-06 Blog Migration
status: ACTIVE
date: 2026-05-28
from_team: team_10 (Developer / WordPress)
to_team: team_50 (L-GATE_BUILD Validator)
wp: WP-W2-06 — Blog Migration
branch: feature/w2-06-blog
head_commit: c043050
staging: http://eyalamit-co-il-2026.s887.upress.link
---

# מנדט team_50 — L-GATE_BUILD / WP-W2-06 Blog Migration

## 0. הקשר

WP-W2-06 (Blog Migration) הושלמה בשלב הקוד ב-2026-05-28 ופורסה לסטייג'ינג.
המנדט הזה מסמיך ומפרט את כל מה שנדרש מ-team_50 כדי להוציא **ורדיקט L-GATE_BUILD** (PASS / FAIL).

**חוק Cross-engine (Iron Rule #1):** builder = claude-sonnet → validator חייב להיות מנוע שונה.

---

## 1. מה פורס לסטייג'ינג (2026-05-28)

| קובץ מקומי | נתיב בשרת | סטטוס FTP |
|------------|-----------|-----------|
| `site/wp-content/themes/ea-eyalamit/page-templates/tpl-blog-archive.php` | `wp-content/themes/ea-eyalamit/page-templates/tpl-blog-archive.php` | ✅ OK |
| `site/wp-content/themes/ea-eyalamit/page-templates/tpl-blog-single.php` | `wp-content/themes/ea-eyalamit/page-templates/tpl-blog-single.php` | ✅ OK |
| `site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-blog-card.php` | `wp-content/themes/ea-eyalamit/template-parts/blocks/block-blog-card.php` | ✅ OK |
| `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-06.php` | `wp-content/themes/ea-eyalamit/inc/wave2-w2-06.php` | ✅ OK |
| `site/wp-content/themes/ea-eyalamit/assets/css/ea-blog.css` | `wp-content/themes/ea-eyalamit/assets/css/ea-blog.css` | ✅ OK |
| `site/wp-content/themes/ea-eyalamit/functions.php` | `wp-content/themes/ea-eyalamit/functions.php` | ✅ OK |
| `site/wp-content/themes/ea-eyalamit/style.css` | `wp-content/themes/ea-eyalamit/style.css` | ✅ OK |
| `site/wp-content/mu-plugins/ea-blog-shortcode-cleanup.php` | `wp-content/mu-plugins/ea-blog-shortcode-cleanup.php` | ✅ OK |
| `site/exports/blog-legacy.wxr` | `wp-content/uploads/ea-blog-seed/blog-legacy.wxr` | ✅ OK |

**Commits על הבranch (feature/w2-06-blog):**
- `c043050` — WXR export + import script + prep report
- `34bf680` — 301 redirect rules + verify script
- `655b102` — completion report (partial)
- `15701aa` — code phase: templates, mu-plugin, CSS, v1.4.0

---

## 2. Pre-requisite לפני תחילת Validation: ייבוא WXR

לפני שניתן לאמת AC-01 עד AC-05, יש לייבא את 54 הפוסטים לסטייג'ינג.

**פעולה ב-WP Admin (http://eyalamit-co-il-2026.s887.upress.link/wp-admin):**

1. **Tools → Import → WordPress** — installer כבר מותקן.
2. בחר "Upload file from your computer" → העלה `site/exports/blog-legacy.wxr` (588KB).
   או: לחץ "Choose from uploads" — הקובץ ב-`wp-content/uploads/ea-blog-seed/blog-legacy.wxr`.
3. Map author: `eyaladmin` (user ID 1).
4. סמן "Download and import file attachments" — תמונות יובאו אוטומטית מהשרת הישן.
5. לחץ Submit. המתן לסיום.

**אימות post-import (WP Admin → Posts):**
- מספר פוסטים: **54** (`post_status=publish`, `post_type=post`)
- 6 קטגוריות נוצרו (Posts → Categories)
- 126 תגיות (Posts → Tags)

---

## 3. Checklist L-GATE_BUILD

### 3A. Static Code Checks (ללא גישה לסטייג'ינג)

```bash
# 1. PHP syntax — כל קבצי W2-06
php -l site/wp-content/themes/ea-eyalamit/page-templates/tpl-blog-archive.php
php -l site/wp-content/themes/ea-eyalamit/page-templates/tpl-blog-single.php
php -l site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-blog-card.php
php -l site/wp-content/themes/ea-eyalamit/inc/wave2-w2-06.php
php -l site/wp-content/mu-plugins/ea-blog-shortcode-cleanup.php

# 2. CSS — אין hex גולמי (כל ערך צבע חייב להיות var(--ea-*))
grep -n "#[0-9a-fA-F]\{3,6\}" site/wp-content/themes/ea-eyalamit/assets/css/ea-blog.css
# Expected output: EMPTY (אם משהו מופיע → FAIL)

# 3. XSS escaping — כל פלט PHP חייב להיות מוגן
grep -n "echo \$\|echo get_\|echo the_" \
  site/wp-content/themes/ea-eyalamit/page-templates/tpl-blog-archive.php \
  site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-blog-card.php \
  site/wp-content/themes/ea-eyalamit/page-templates/tpl-blog-single.php
# אם מופיע echo ללא esc_html/esc_url/esc_attr → בדוק ידנית

# 4. wp_reset_postdata — חייב להופיע בarchive אחרי הלולאה
grep -n "wp_reset_postdata" site/wp-content/themes/ea-eyalamit/page-templates/tpl-blog-archive.php
# Expected: לפחות שורה אחת

# 5. Version bump
grep "^Version:" site/wp-content/themes/ea-eyalamit/style.css
# Expected: Version: 1.4.0

# 6. require_once wave2-w2-06 קיים ב-functions.php
grep "wave2-w2-06" site/wp-content/themes/ea-eyalamit/functions.php
# Expected: שורה אחת עם require_once

# 7. AOS Validation
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .
# Expected: 0 FAIL
```

### 3B. Staging — HTTP Checks

```bash
BASE="http://eyalamit-co-il-2026.s887.upress.link"

# AC-04a: ארכיון בלוג עולה
curl -s -o /dev/null -w "%{http_code}" "$BASE/blog/"
# Expected: 200

# AC-04b: פגינציה (אחרי ייבוא 54 פוסטים, 12 בעמוד → 5 עמודים)
curl -s -o /dev/null -w "%{http_code}" "$BASE/blog/?paged=2"
# Expected: 200

# AC-04c: פילטר קטגוריה — בדוק ת׳ ID הקטגוריה הראשונה (מ-WP admin → Categories)
curl -s -o /dev/null -w "%{http_code}" "$BASE/blog/?cat=1"
# Expected: 200

# AC-05: 301 redirect /Blog/ → /blog/
# (לפני: פרוס את 301 rules — ראה §4 למטה)
bash scripts/verify-301-blog.sh

# AC-01: 54 פוסטים מחזירים 200 — דגימה של 5 slugs מ-W2-06-IMPORT-PREP-2026-05-28.md
for slug in \
  "18-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%9e%d7%a1%d7%9a-%d7%94%d7%91%d7%a8%d7%96%d7%9c" \
  "23-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%9c%d7%a6%d7%99%d7%99%d7%aa-%d7%90%d7%95-%d7%9c%d7%97%d7%a9%d7%95%d7%91" \
  "29-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%a8%d7%99%d7%99%d7%91-%d7%a9%d7%91%d7%95%d7%a2-%d7%94%d7%a1%d7%a4%d7%a8"
do
  code=$(curl -s -o /dev/null -w "%{http_code}" "$BASE/blog/$slug/")
  echo "$code  /blog/$slug/"
done
# Expected: כל שורה = 200
```

### 3C. ויזואלי (דפדפן)

| בדיקה | URL | קריטריון PASS |
|-------|-----|--------------|
| ארכיון בלוג | `/blog/` | גריד 3 עמודות, כפתורי קטגוריה, פגינציה גלויה |
| כרטיס בלוג | `/blog/` | תמונה + קטגוריה + כותרת + תקציר + תאריך |
| פוסט בודד | `/blog/<slug>/` | תמונה ראשית, H1, שורת meta, תוכן נקי, contact-CTA בסוף |
| ניקוי shortcodes | 3 פוסטים עם `has_shortcodes:true` (ראה IMPORT-PREP) | אין `[vc_*]` גלוי בדף |
| RTL | כל עמוד בלוג | כיוון טקסט מימין לשמאל, גריד ב-direction:rtl |

---

## 4. פריסת 301 Rules (לפני בדיקת AC-05)

שתי אפשרויות — בחר אחת:

### אפשרות א׳ — .htaccess (מועדף)
העתק את `site/blog-301-rules.htaccess` לתוך `.htaccess` הראשי בתיקיית הWordPress root בסטייג'ינג.
ניתן לעשות זאת דרך phpMyAdmin → File Manager, או FTP ישיר.

### אפשרות ב׳ — Redirection Plugin
אם מותקן:
WP Admin → Tools → Redirection → Import/Export → Import → העלה `site/blog-301-redirection-plugin.json`

---

## 5. Posts מורכבים — Manual Inspection (AC-07)

22 פוסטים זוהו עם `has_shortcodes:true` או `content_length > 20000`.
הגבוהים בסדר עדיפות (לבדיקה ויזואלית):

| Post ID | כותרת (מקוצר) | content_length | flags |
|---------|---------------|----------------|-------|
| 1881 | ביקורות גולשים — מופע הסיפורים | 65,147 | shortcodes |
| 20056 | מן התקשורת — כתבות | 64,827 | shortcodes |
| 1629 | (ארוך ללא shortcodes) | 24,179 | — |

קריטריון PASS לAC-07: אין `[vc_`, `[et_pb_`, או שרידי shortcode אחרים גלויים ב-rendered HTML.
הmu-plugin `ea-blog-shortcode-cleanup.php` אמור לטפל ב-80%+ אוטומטית.
אם שאריות נמצאות — צוין FAIL עם screenshot ו-post ID, מועבר ל-team_10 לתיקון ידני.

---

## 6. AC Checklist — ורדיקט

מלא לפי הבדיקות:

| AC | תיאור | ורדיקט |
|----|-------|--------|
| AC-01 | 54 URLs `/blog/<slug>/` → HTTP 200 | [ ] PASS / [ ] FAIL |
| AC-02 | מטא-דאטה שמורה (author, date, cats, tags) | [ ] PASS / [ ] FAIL |
| AC-03 | תמונות לא 404 (spot-check 10 פוסטים) | [ ] PASS / [ ] FAIL |
| AC-04 | ארכיון: פגינציה + פילטר קטגוריה עובדים | [ ] PASS / [ ] FAIL |
| AC-05 | `curl -I /Blog/<slug>/` → 301 + Location: `/blog/` | [ ] PASS / [ ] FAIL |
| AC-06 | `validate_aos.sh` → 0 FAIL | [ ] PASS / [ ] FAIL |
| AC-07 | 5-10 פוסטים מורכבים: אין shortcode artifacts | [ ] PASS / [ ] FAIL |
| AC-08 | `style.css Version: 1.4.0` | [ ] PASS / [ ] FAIL |

**PASS כולל** = כל AC בסטטוס PASS.
**FAIL חלקי** = כל FAIL מחייב דיווח עם:
- AC number
- פלט הbash/screenshot
- קובץ מקומי רלוונטי
- המלצה לתיקון

---

## 7. דיווח ורדיקט

כתוב את הורדיקט ב:
`_COMMUNICATION/team_50/L-GATE_BUILD-W2-06-REPORT-2026-05-28.md`

פורמט:

```markdown
---
verdict: PASS | FAIL
wp: WP-W2-06
date: 2026-05-28
validator_engine: <שם מנוע — חייב להיות ≠ claude-sonnet>
---

# L-GATE_BUILD Verdict — WP-W2-06

## Result: PASS / FAIL

## AC Results
[טבלת AC עם ורדיקט לכל שורה]

## Issues Found (אם FAIL)
[רשימה עם AC + תיאור + קובץ + המלצה]

## Recommendation
PASS → PR feature/w2-06-blog → main מאושר לmerge לאחר team_190 PASS.
FAIL → team_10 חייבים לתקן ולשלוח IR#2 לpeer-review.
```

---

## 8. Escalation

- PASS → ורדיקט ל-`team_100` + `team_00` + הפעלת team_190 (L-GATE_VALIDATE).
- FAIL → ורדיקט ל-`team_10` בלבד; לא ממשיכים ל-team_190 עד לתיקון.

---

## 9. Version

| תאריך | פעולה |
|-------|-------|
| 2026-05-28 | מנדט נכתב ע״י team_10 אחרי פריסה מוצלחת לסטייג'ינג (9/9 FTP OK). |
