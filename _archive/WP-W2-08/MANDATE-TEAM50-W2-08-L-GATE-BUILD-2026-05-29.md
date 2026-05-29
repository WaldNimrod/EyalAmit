---
id: MANDATE-TEAM50-W2-08-L-GATE-BUILD-2026-05-29
title: team_50 mandate — L-GATE_BUILD for WP-W2-08 English Landing (/en)
status: ACTIVE — awaiting team_50 verdict
date: 2026-05-29
from_team: team_100 (Chief System Architect)
to_team: team_50 (L-GATE_BUILD Validator)
wp: WP-W2-08 — English Landing Page (/en)
branch: feature/w2-08-en
head_commit: 5ac435b
staging: http://eyalamit-co-il-2026.s887.upress.link
spec_ref: _aos/work_packages/S002/WP-W2-08/LOD400_spec.md
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-08
---

# מנדט team_50 — L-GATE_BUILD / WP-W2-08 (/en)

## 0. הקשר + Cross-engine (IR#1)
WP-W2-08 נבנתה (team_10, Claude) ופורסה. EN copy סופי+מאושר (team_30). builder=Claude →
**validator team_50 חייב מנוע שאינו Claude**. אשר מנוע בשורה 1.

## 0.1 Worktree
`/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-08` (branch `feature/w2-08-en`). הטרי המשותף על main — אל תבדוק שם.

## 1. Proof-of-HEAD
- **HEAD `5ac435b`** ("WP-W2-08: English landing /en"). base main @ `37921fb`. `style.css` = **1.4.6**.
  כל בדיקת HTTP cache-bust (`?cb=$(date +%s)$RANDOM`).

## 2. מה נבנה (EXTEND תשתית קיימת)
עמוד `/en` + `tpl-en-landing.php` כבר היו קיימים (200 חי). נבנה: `inc/wave2-w2-08.php` (the_content
injection keyed slug `en`, 6 סקשנים), עריכת `tpl-en-landing.php` (H1 יחיד מה-hero), הרחבת hreflang
ב-`functions.php` (B03), CTA, `assets/css/w2-08-en-landing.css` (D-14, LTR).

## 3. Checks
```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-08"
php -l site/wp-content/themes/ea-eyalamit/inc/wave2-w2-08.php
grep -nE "#[0-9a-fA-F]{3,6}" site/wp-content/themes/ea-eyalamit/assets/css/w2-08-en-landing.css  # EMPTY
grep "^Version:" site/wp-content/themes/ea-eyalamit/style.css                                     # 1.4.6
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .                           # 0 FAIL
BASE="http://eyalamit-co-il-2026.s887.upress.link"
curl -s -L "$BASE/en/?cb=$(date +%s)$RANDOM" | grep -iE "hreflang|<html"     # lang=en dir=ltr + 3 alternates
curl -s -L "$BASE/?cb=$(date +%s)$RANDOM"   | grep -i hreflang               # reciprocal en->/en on HE home
```

## 4. AC Checklist (LOD400 AC-01..05)
| AC | תיאור | ורדיקט |
|----|-------|--------|
| AC-01 | `/en` → 200, `lang="en"` | [ ] PASS/FAIL |
| AC-02 | 6 סקשנים (hero·about·method·services·books·testimonials) verbatim מ-`_COMMUNICATION/team_30/W2-08-EN-CONTENT-2026-05-28.md` (אין copy של הבונה); H1 יחיד | [ ] PASS/FAIL |
| AC-03 | hreflang B03: `/en` = en+he(→`/`)+x-default; **HE homepage `/` = reciprocal en→`/en/`** | [ ] PASS/FAIL |
| AC-04 | CTA → `/contact?lang=en` (לא `#`) | [ ] PASS/FAIL |
| AC-05 | `validate_aos.sh` 0 FAIL + responsive (LTR) | [ ] PASS/FAIL |

**הערה לא-חוסמת:** page-id-25 נושא class שיורי `ea-blog-archive-view` מ-body_class filter של WP אחר
התואם את ה-id (קוסמטי; W2-08 CSS scoped ל-`.ea-en-landing`, אין השפעה ויזואלית). מועמד ל-follow-up.

## 5. דיווח
`_COMMUNICATION/team_50/VERDICT-W2-08-L-GATE-BUILD-2026-05-29.md` (verdict, engine ≠ claude, head_verified 5ac435b, AC table, findings). PASS/PWF (ללא P0/P1) → team_100+team_00 → team_190. FAIL → team_10.

*team_100 — 2026-05-29 — /en 200 + 6 sections + hreflang דו-כיווני + CTA אומתו ע"י team_100; validate 0 FAIL.*
