---
id: MANDATE-TEAM50-W2-05-L-GATE-BUILD-2026-05-29
title: team_50 mandate — L-GATE_BUILD for WP-W2-05 Shop (5 product pages + /shop catalog)
status: ACTIVE — awaiting team_50 verdict
date: 2026-05-29
from_team: team_100 (Chief System Architect / orchestrator)
to_team: team_50 (L-GATE_BUILD Validator)
wp: WP-W2-05 — Shop (5 product/service pages + unified /shop catalog)
branch: feature/w2-05-shop
head_commit: 112b341
staging: http://eyalamit-co-il-2026.s887.upress.link
spec_ref: _aos/work_packages/S002/WP-W2-05/LOD400_spec.md
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-05
---

# מנדט team_50 — L-GATE_BUILD / WP-W2-05 (Shop)

## 0. הקשר
WP-W2-05 הושלמה בשלב הקוד ב-2026-05-29 (team_10, Claude) ופורסה לסטייג'ינג. מנדט זה מסמיך את
team_50 להוציא **ורדיקט L-GATE_BUILD (PASS / PASS_WITH_FINDINGS / FAIL)**.

**Cross-engine (Iron Rule #1, team_00 strict disposition):** builder = Claude (team_10) →
**validator team_50 חייב להיות מנוע שאינו Claude** (cursor-composer / codex). אשר את שם המנוע בשורה 1 של הוורדיקט.

## 0.1 — Worktree (בידוד)
W2-05 בעבודה ב-**worktree ייעודי**: `/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-05` (branch `feature/w2-05-shop`).
הטרי המשותף `EyalAmit.co.il-2026` נשאר על `main` — אל תבדוק שם.

## 1. Proof-of-HEAD (חובה לאמת לפני QA)
- Branch: `feature/w2-05-shop`
- **HEAD commit: `112b341`** (build W2-05 — mirror W2-04 pattern + seeder + grid)
- base = main @ `9802d90`. Working tree clean.
- **אמת ש-HEAD המקומי = הקוד שפורס**: גרסת theme חדשה ב-`style.css` = **1.4.4**; כל בדיקת HTTP חייבת
  cache-bust (`?cb=$(date +%s)$RANDOM`).

## 2. מה פורס לסטייג'ינג (FTP, 2026-05-29)
| קובץ מקומי | סטטוס |
|------------|-------|
| `themes/ea-eyalamit/inc/wave2-w2-05.php` (router @100, shell/body/sidebar/title filters, block renderers, asset enqueue) | ✅ |
| `themes/ea-eyalamit/inc/wave2-w2-05-content.php` (content map 1:1 מ-5 מקורות + GI-URL map ריק + /shop archive branch) | ✅ |
| `themes/ea-eyalamit/page-templates/tpl-shop-item.php` (thin shell) | ✅ |
| `themes/ea-eyalamit/page-templates/tpl-shop-archive.php` (thin shell — קטלוג) | ✅ |
| `themes/ea-eyalamit/assets/css/w2-05-shop.css` (D-14 tokens; product blocks + grid 4-up/2-up) | ✅ |
| `themes/ea-eyalamit/assets/js/ea-ab-testing.js` (+handler `[data-ea-product-cta]` → GA4 `product_cta_click`) | ✅ |
| `themes/ea-eyalamit/template-parts/blocks/block-faq-list.php` (+5 קטגוריות מוצר + Q/A 1:1) | ✅ |
| `themes/ea-eyalamit/functions.php` (append-only require) | ✅ |
| `themes/ea-eyalamit/style.css` (Version 1.4.3 → 1.4.4) | ✅ |
| `hub/data/site-tree.json` (+5 nodes + repoint `st-svc-repair`→tpl-shop-item + `/shop` node) | ✅ |
| **`mu-plugins/ea-w2-05-shop-pages-seed-once.php` (NEW)** — seeder חד-פעמי ל-6 עמודי שורש | ✅ |
| `mu-plugins/ea-m2-site-tree-lock-sync-once.php` (הסרת redirect ישן `/shop/→/tools-and-accessories/`) | ✅ |
| `scripts/ftp_deploy_site_wp_content.py` (+שורת upload ל-seeder) | ✅ |

## 3. Checklist L-GATE_BUILD

### 3A. Static Code Checks
```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-05"
# PHP syntax
php -l site/wp-content/themes/ea-eyalamit/inc/wave2-w2-05.php
php -l site/wp-content/themes/ea-eyalamit/inc/wave2-w2-05-content.php
php -l site/wp-content/themes/ea-eyalamit/page-templates/tpl-shop-item.php
php -l site/wp-content/themes/ea-eyalamit/page-templates/tpl-shop-archive.php
php -l site/wp-content/mu-plugins/ea-w2-05-shop-pages-seed-once.php

# CSS — אין hex גולמי (כל צבע = var(--ea-*) / D-14 token)
grep -nE "#[0-9a-fA-F]{3,6}" site/wp-content/themes/ea-eyalamit/assets/css/w2-05-shop.css
# Expected: EMPTY (אם hex גולמי → FAIL)

# מחיר — אין מחיר מקודד; שימוש ב-post meta + fallback
grep -n "ea_product_price\|מחיר לפי התאמה" site/wp-content/themes/ea-eyalamit/inc/wave2-w2-05-content.php

# require_once קיים
grep "wave2-w2-05" site/wp-content/themes/ea-eyalamit/functions.php   # Expected: 1 שורה
grep "^Version:" site/wp-content/themes/ea-eyalamit/style.css          # Expected: 1.4.4

# AOS Validation
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .  # Expected: 0 FAIL
```

### 3A.1 — בדיקת תוספות-scope (מעבר לרשימת ה-MODIFY במנדט team_10 — אשר בטיחות והצדקה)
1. **`mu-plugins/ea-w2-05-shop-pages-seed-once.php`** (חדש) + שורה ב-`ftp_deploy_site_wp_content.py`.
   seeder חד-פעמי (FTP לא יוצר עמודי WP). אשר: `defined('ABSPATH')||exit`, hook `init`, דגל
   `ea_w2_05_shop_pages_v2`, transient lock, **ללא re-require של wp-load**, אידמפוטנטי; ניקוי
   `$wpdb` של `_wp_old_slug` מוחק רק כשה-slug הנוכחי של הבעלים שונה. תואם דפוס `ea-m2/m3/m4-*-once.php`.
2. **`ea-m2-site-tree-lock-sync-once.php`**: הוסר redirect ישן `/shop → /tools-and-accessories/`
   (היה חוסם את הקטלוג). אשר עקביות עם מטרת הפונקציה (canonical paths per site-tree; תקדים `/books`).
3. **תפריט ניווט** עדיין מצביע ל-`/tools-and-accessories/repair/` למרות ש-עמוד repair הועבר ל-`/repair`
   (200). אשר אם זה ניקוי תפריט בתחום ה-WP או follow-up C3 (לא חוסם AC).

### 3B. Staging HTTP Checks (cache-busted)
```bash
BASE="http://eyalamit-co-il-2026.s887.upress.link"
for p in /didgeridoos /bags /stands-storage /stand-floor /repair /shop; do
  CB=$(date +%s)$RANDOM
  curl -s -o /dev/null -w "%{http_code}  $p\n" -L "$BASE$p/?cb=$CB"
done
# Expected: כולם 200
```

### 3C. ויזואלי (דפדפן)
| בדיקה | URL | קריטריון PASS |
|-------|-----|--------------|
| עמוד מוצר | `/didgeridoos` (+4) | 10 בלוקים: hero · what-it-is · features · who-it's-for · FAQ מסונן · testimonials(placeholder) · price · CTA · gallery · closing |
| מחיר | כל מוצר | `ea_product_price` מוצג, או fallback "מחיר לפי התאמה" |
| CTA | כל מוצר | אין GI URL → `/contact?subject=product-<slug>` (לא `#`), `target` same-tab; GA4 `product_cta_click {product_slug, cta_type}` נורה; A/B `eyal_cta_variant` (form/wa) |
| קטלוג | `/shop` | grid רספונסיבי 4-up דסקטופ / 2-up מובייל; 5 כרטיסים, כל כרטיס מקשר למוצר + מציג מחיר/fallback |
| תוכן | כל דף | body = מקור 25.5.26 1:1 (AC-05: תיקון שגיאות ברורות, שמירת קול/סלנג) |
| RTL | כל דף | כיוון מימין לשמאל; body class `ea-wave2-shell` |

## 4. AC Checklist — ורדיקט
| AC | תיאור | ורדיקט |
|----|-------|--------|
| AC-01 | 6 URLs → HTTP 200 | [ ] PASS / [ ] FAIL |
| AC-02 | block contract מלא (10) בכל עמוד מוצר | [ ] PASS / [ ] FAIL |
| AC-03 | מחיר מוצג בכרטיס+עמוד (או fallback "מחיר לפי התאמה") | [ ] PASS / [ ] FAIL |
| AC-04 | CTA matrix: `/contact?subject=product-<slug>` (לא `#`) + GA4 `product_cta_click` | [ ] PASS / [ ] FAIL |
| AC-05 | `/shop` grid רספונסיבי 4/2-up, כל כרטיס מקשר למוצר | [ ] PASS / [ ] FAIL |
| AC-06 | `validate_aos.sh` 0 FAIL + רספונסיב מובייל | [ ] PASS / [ ] FAIL |

**הערה ל-AC-04:** קישורי Green Invoice למוצרים טרם סופקו ע״י אייל → fallback ל-`/contact` הוא המצב התקין (לא FAIL).
**הערה ל-testimonials+gallery:** placeholders עד W2-07 — spec-sanctioned, לא חוסם.

## 5. דיווח ורדיקט
כתוב ב: `_COMMUNICATION/team_50/QA-VERDICT-WP-W2-05-L-GATE-BUILD-2026-05-29.md`
```markdown
---
verdict: PASS | PASS_WITH_FINDINGS | FAIL
wp: WP-W2-05
date: 2026-05-29
head_verified: 112b341
validator_engine: <שם מנוע — חייב ≠ claude>
---
# L-GATE_BUILD Verdict — WP-W2-05
## Result
## AC Results [טבלה]
## Scope-additions review [seeder mu-plugin · redirect removal · nav menu]
## Findings [AC + פלט/screenshot + קובץ + המלצה] (אם יש)
## Recommendation
```

## 6. Escalation
- **PASS / PASS_WITH_FINDINGS (ללא P0/P1)** → ורדיקט ל-`team_100` + `team_00`; team_100 מפעיל **team_190 (L-GATE_VALIDATE, Codex)**.
- **FAIL (P0/P1)** → ורדיקט ל-`team_10` בלבד; לא ממשיכים ל-team_190 עד תיקון.

## 7. Version
| תאריך | פעולה |
|-------|-------|
| 2026-05-29 | מנדט נכתב ע״י team_100 אחרי build+deploy מוצלח (6/6 URLs 200 cache-busted אומת ע״י team_100, validate 0 FAIL, HEAD 112b341). |
