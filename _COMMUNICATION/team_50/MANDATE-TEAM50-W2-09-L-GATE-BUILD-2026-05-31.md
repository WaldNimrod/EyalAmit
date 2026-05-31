---
id: MANDATE-TEAM50-W2-09-L-GATE-BUILD-2026-05-31
title: team_50 mandate — L-GATE_BUILD for WP-W2-09 Cutover Prep (301 map + media + check script)
status: ACTIVE — awaiting team_50 verdict
date: 2026-05-31
from_team: team_100 (Chief System Architect)
to_team: team_50 (L-GATE_BUILD Validator)
wp: WP-W2-09 — Media filter + full 301 application + cutover prep
branch: feature/w2-09-cutover
head_commit: 4cad377
staging: http://eyalamit-co-il-2026.s887.upress.link
spec_ref: _aos/work_packages/S002/WP-W2-09/LOD400_spec.md
decision_ref: _COMMUNICATION/team_00/DECISION_W2-09-301-REDIRECT-APPROACH_2026-05-30_v1.md
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-09
---

# מנדט team_50 — L-GATE_BUILD / WP-W2-09 (Cutover Prep)

## 0. הקשר + Cross-engine (IR#1)
WP-W2-09 (final pre-cutover) נבנתה (team_20, Claude sub-agent) ופורסה. builder=Claude →
**validator team_50 חייב מנוע שאינו Claude**. אשר מנוע בשורה 1.

## 0.1 Worktree
`/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-09` (branch `feature/w2-09-cutover`). הטרי המשותף על main — אל תבדוק שם.

## 1. Proof-of-HEAD
- **HEAD `4cad377`**. base main @ `1652fa6`. כל בדיקת HTTP cache-bust (`?cb=$(date +%s)$RANDOM`).

## 2. ⚠ מנגנון 301 — שונה מהמנדט/spec (.htaccess → PHP), מאושר team_00
**ה-.htaccess אינרטי על uPress** (nginx + Apache AllowOverride None — כל כלל per-page מחזיר 404; אומת
empirically ×3). המנגנון החי היחיד = **PHP `template_redirect`**. team_00 אישר 2026-05-31 מעבר ל-**approach A**:
plugin `site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php` (generated מ-`scripts/gen_htaccess_301_from_decisions.py`
מתוך ה-135-JSON; `template_redirect` priority 0). DECISION amended (B→A). אמת זאת — **בדוק את ה-PHP plugin, לא .htaccess**.

## 3. מה נבנה/פורס
| תוצר | מנגנון |
|------|--------|
| 25× Redirect 301 + 2× 410 | `ea-w209-legacy-301-redirects.php` (generated; SSoT = 135-JSON). `/shop*` (4 כללים) DROPPED בכוונה — `/shop` חי 200. empty targets → canonical אמיתי (לא lazy `/`). |
| In-use media regen | `_COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-REGEN-2026-05-30.json` — **74 items** (מחליף stale 7). |
| `scripts/final_pre_cutover_check.sh` | NEW — מאמת a-e (ראו §5). |
| `inc/wave2-w2-09.php` | homepage meta-description + favicon (Lighthouse). topnav aria-label fix. |
| cutover checklist | `_COMMUNICATION/team_20/W2-09-CUTOVER-CHECKLIST-2026-05-30.md`. |

## 4. Static + Staging checks
```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-09"
php -l site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .   # 0 FAIL
bash scripts/final_pre_cutover_check.sh                                     # MUST exit 0 (a-e PASS)
# health: live canonicals + QR stay 200 (NOT redirected)
BASE="http://eyalamit-co-il-2026.s887.upress.link"
for u in "" shop books en about/moksha qr/qr1 qr/qr48; do curl -s -o /dev/null -w "%{http_code} /$u\n" -L "$BASE/$u/?cb=$(date +%s)$RANDOM"; done
# redirects fire (no -L): sample legacy -> 301 + correct Location -> live target
```

## 5. AC Checklist (LOD400 AC-01..06)
| AC | תיאור | ורדיקט |
|----|-------|--------|
| AC-01 | in-use media (regen 74 ∪ W2-06 blog) כולם 200 | [ ] PASS/FAIL |
| AC-02 | 135-map מכובד: 25×301 + 2×410 חיים; 49 QR + keeps חיים (לא redirected) | [ ] PASS/FAIL |
| AC-03 | 20 הראשונים ב-decisions[] — כל אחד resolve per decision (301 + Location→200) | [ ] PASS/FAIL |
| AC-04 | 49 QR חיים מול QR-URL-INVENTORY.csv | [ ] PASS/FAIL |
| AC-05 | Lighthouse home: **Perf 96 + A11y 100 ≥90 PASS**; **SEO 69 + BP 78 staging-capped** (noindex+HTTP→100 ב-cutover; team_00 accepted 2026-05-31; HTTPS=spec OUT/M7 IDEA-001) | [ ] PASS/FAIL |
| AC-06 | `final_pre_cutover_check.sh` exits 0 | [ ] PASS/FAIL |

## 6. תוספות-scope + carry-forwards (לאימות בטיחות / לידיעה)
- PHP redirect plugin (guarded, priority 0 לפני canonical table @1, ABSPATH, skips admin/ajax/REST, no loops,
  sources=legacy Hebrew paths שאינם מתנגשים עם canonicals חיים). 2 generator scripts + check script.
- **team_100 תיקן 2 targets** → canonical ישיר: כושי-בלאנטיס→`/books/kushi-blantis/`, מוקש→`/about/moksha/`
  (generator==plugin==check byte-for-byte). 
- **flag ל-Eyal (לא חוסם):** `/תקנון`→`/` (interim); סדנאות-בנייה→`/lessons` (proxy). SEO/BP staging-cap.

## 7. דיווח
`_COMMUNICATION/team_50/VERDICT-W2-09-L-GATE-BUILD-2026-05-31.md` (verdict, engine ≠ claude, head 4cad377,
AC table, mechanism-switch + AC-05 disposition assessment). PASS/PWF (ללא P0/P1) → team_100+team_00 → team_190.

*team_100 — 2026-05-31 — final_pre_cutover_check exit 0; redirects+canonicals+QR אומתו ע"י team_100; validate 0 FAIL.*
