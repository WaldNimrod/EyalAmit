---
id: MANDATE-TEAM50-W2-03-L-GATE-BUILD-2026-05-29
title: team_50 mandate — L-GATE_BUILD for WP-W2-03 Muzza Publishing + 3 Book Pages
status: ACTIVE — awaiting team_50 verdict
date: 2026-05-29
from_team: team_100 (Chief System Architect / orchestrator)
to_team: team_50 (L-GATE_BUILD Validator)
wp: WP-W2-03 — Muzza Publishing catalog + 3 book-detail pages
branch: feature/w2-03-books
head_commit: 22d6109
staging: http://eyalamit-co-il-2026.s887.upress.link
spec_ref: _aos/work_packages/S002/WP-W2-03/LOD400_spec.md
---

# מנדט team_50 — L-GATE_BUILD / WP-W2-03 (Books)

## 0. הקשר
WP-W2-03 הושלמה בשלב הקוד ב-2026-05-29 (team_10, claude-sonnet) ופורסה לסטייג'ינג.
מנדט זה מסמיך את team_50 להוציא **ורדיקט L-GATE_BUILD (PASS / FAIL)**.

**Cross-engine (Iron Rule #1 + mandate §4, team_00 strict disposition 2026-05-28):**
builder = claude-sonnet → **validator team_50 חייב להיות מנוע שאינו Claude** (cursor-composer / codex).

## 1. Proof-of-HEAD (חובה לאמת לפני QA)
- Branch: `feature/w2-03-books`
- **HEAD commit: `22d6109`** ("fix(wp-w2-03): stop /books 301-redirect to /muzza")
- Commit קודם: `2e3f23c` ("feat(wp-w2-03): Muzza Publishing catalog + 3 book-detail pages")
- Working tree clean; base = main @ `c268859`.
- **אמת ש-HEAD המקומי = הקוד שפורס**: גרסת theme חדשה ב-`style.css` = **1.4.2**; וכל בדיקת HTTP חייבת cache-bust (`?cb=<timestamp>`).

## 2. מה פורס לסטייג'ינג (FTP + REST, 2026-05-29)
| קובץ מקומי | סטטוס |
|------------|-------|
| `themes/ea-eyalamit/inc/wave2-w2-03.php` (router @100, shell/body/sidebar/title filters, purchase+gallery renderers, GA4 enqueue) | ✅ |
| `themes/ea-eyalamit/inc/wave2-w2-03-content.php` (verbatim content map, 3 books) | ✅ |
| `themes/ea-eyalamit/page-templates/tpl-books.php` (catalog, 12 blocks) | ✅ |
| `themes/ea-eyalamit/page-templates/tpl-book-detail.php` (14-block contract) | ✅ |
| `themes/ea-eyalamit/assets/css/ea-atoms.css` (W2-03 styles, D-14 tokens) | ✅ |
| `themes/ea-eyalamit/assets/js/ea-book-purchase.js` (GA4 book_purchase_click) | ✅ |
| `themes/ea-eyalamit/functions.php` (append-only require) | ✅ |
| `themes/ea-eyalamit/style.css` (Version 1.4.1 → 1.4.2) | ✅ |
| `mu-plugins/ea-m2-site-tree-lock-sync-once.php` (הסרת redirect יחיד `/books/→/muzza/`) | ✅ |
| 4 עמודי WP נוצרו דרך `wp_rest_client.py`: `/books` (parent) + `vekatavta`, `kushi-blantis`, `tsva-bekahol` (children) | ✅ |

## 3. Checklist L-GATE_BUILD

### 3A. Static Code Checks
```bash
# PHP syntax
php -l site/wp-content/themes/ea-eyalamit/inc/wave2-w2-03.php
php -l site/wp-content/themes/ea-eyalamit/inc/wave2-w2-03-content.php
php -l site/wp-content/themes/ea-eyalamit/page-templates/tpl-books.php
php -l site/wp-content/themes/ea-eyalamit/page-templates/tpl-book-detail.php

# CSS — אין hex גולמי (כל צבע = var(--ea-*) / D-14 token)
grep -nE "#[0-9a-fA-F]{3,6}" site/wp-content/themes/ea-eyalamit/assets/css/ea-atoms.css
# Expected: EMPTY בתוך בלוקי W2-03 (אם hex גולמי בקוד W2-03 → FAIL)

# XSS escaping — כל פלט מוגן (esc_html/esc_url/esc_attr)
grep -nE "echo \\\$|the_|get_" site/wp-content/themes/ea-eyalamit/page-templates/tpl-books.php site/wp-content/themes/ea-eyalamit/page-templates/tpl-book-detail.php

# require_once קיים
grep "wave2-w2-03" site/wp-content/themes/ea-eyalamit/functions.php   # Expected: 1 שורה

# Version bump
grep "^Version:" site/wp-content/themes/ea-eyalamit/style.css         # Expected: 1.4.2

# AOS Validation
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .  # Expected: 0 FAIL
```

### 3B. Staging HTTP Checks (cache-busted)
```bash
BASE="http://eyalamit-co-il-2026.s887.upress.link"; CB=$(date +%s)
for p in /books /books/vekatavta /books/kushi-blantis /books/tsva-bekahol; do
  curl -s -o /dev/null -w "%{http_code}  $p\n" -L "$BASE$p/?cb=$CB"
done
# Expected: כולם 200, ללא redirect (אמת %{redirect_url} ריק)
```

### 3C. ויזואלי (דפדפן)
| בדיקה | URL | קריטריון PASS |
|-------|-----|--------------|
| קטלוג | `/books` | 12 בלוקים; 3 `ea-book-card` + בלוק bundle inline; כל כרטיס מקשר ל-`/books/<slug>` |
| ספר | `/books/<slug>` | 14 בלוקים: תקציר · קטע · על הספר · gallery · purchase · למי מתאים · FAQ מסונן · press · closing CTA |
| Purchase fallback | כל ספר | כפתור → `/contact?subject=book-<slug>` (לא `#`), GA4 `book_purchase_click` נורה |
| תוכן verbatim | כל דף | H1 + body = מקור 25.5.26 1:1 (AC-05) |
| רספונסיב | קטלוג | 3-up דסקטופ / stacked מובייל; body class `ea-wave2-shell` |
| RTL | כל דף | כיוון מימין לשמאל |

## 4. AC Checklist — ורדיקט
| AC | תיאור | ורדיקט |
|----|-------|--------|
| AC-01 | 4 URLs → HTTP 200 | [ ] PASS / [ ] FAIL |
| AC-02 | כל בלוק נדרש מוצג (block contract) | [ ] PASS / [ ] FAIL |
| AC-03 | purchase → Green Invoice בטאב חדש + GA4; **fallback** `/contact?subject=book-<slug>` + GA4 | [ ] PASS / [ ] FAIL |
| AC-04 | `/books` 3 כרטיסים + bundle; כל כרטיס מקשר לדף ספר | [ ] PASS / [ ] FAIL |
| AC-05 | H1 + body = מקור 25.5.26 1:1 | [ ] PASS / [ ] FAIL |
| AC-06 | `validate_aos.sh` 0 FAIL + רספונסיב מובייל | [ ] PASS / [ ] FAIL |

**הערה ל-AC-03:** קישורי Green Invoice לספרים בודדים טרם סופקו ע״י אייל → fallback ל-`/contact` הוא המצב התקין (לא FAIL). קישור bundle אחד חי.

## 5. דיווח ורדיקט
כתוב ב: `_COMMUNICATION/team_50/QA-VERDICT-WP-W2-03-L-GATE-BUILD-2026-05-29.md`
פורמט:
```markdown
---
verdict: PASS | PASS_WITH_FINDINGS | FAIL
wp: WP-W2-03
date: 2026-05-29
head_verified: 22d6109
validator_engine: <שם מנוע — חייב ≠ claude>
---
# L-GATE_BUILD Verdict — WP-W2-03
## Result
## AC Results [טבלה]
## Findings [AC + פלט/screenshot + קובץ + המלצה] (אם יש)
## Recommendation
```

## 6. Escalation
- **PASS / PASS_WITH_FINDINGS (ללא P0/P1)** → ורדיקט ל-`team_100` + `team_00`; team_100 מפעיל **team_190 (L-GATE_VALIDATE, Codex)**.
- **FAIL (P0/P1)** → ורדיקט ל-`team_10` בלבד; לא ממשיכים ל-team_190 עד תיקון.

## 7. Version
| תאריך | פעולה |
|-------|-------|
| 2026-05-29 | מנדט נכתב ע״י team_100 אחרי build+deploy מוצלח (4/4 URLs 200 cache-busted, validate 0 FAIL, HEAD 22d6109). |
