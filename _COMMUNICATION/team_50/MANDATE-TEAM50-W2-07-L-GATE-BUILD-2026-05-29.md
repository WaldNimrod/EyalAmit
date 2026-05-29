---
id: MANDATE-TEAM50-W2-07-L-GATE-BUILD-2026-05-29
title: team_50 mandate — L-GATE_BUILD for WP-W2-07 Heritage (48 QR + /press + /about/moksha + FB Top-5)
status: ACTIVE — awaiting team_50 verdict
date: 2026-05-29
from_team: team_100 (Chief System Architect / orchestrator)
to_team: team_50 (L-GATE_BUILD Validator)
wp: WP-W2-07 — Press + Moksha + 48 QR pages + FB Top-5 testimonials
branch: feature/w2-07-heritage
head_commit: c7dc34a
staging: http://eyalamit-co-il-2026.s887.upress.link
spec_ref: _aos/work_packages/S002/WP-W2-07/LOD400_spec.md
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-07
---

# מנדט team_50 — L-GATE_BUILD / WP-W2-07 (Heritage)

## 0. הקשר + Cross-engine (IR#1)
WP-W2-07 נבנתה (team_10, Claude) ופורסה לסטייג'ינג. הקלטים הקשיחים (48 QR + 26 press) הופקו
ואומתו מראש ע"י סשן S002-content-inputs. builder=Claude → **validator team_50 חייב מנוע שאינו Claude**
(cursor-composer / codex). אשר שם מנוע בשורה 1.

## 0.1 — Worktree
`/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-07` (branch `feature/w2-07-heritage`). הטרי המשותף על main — אל תבדוק שם.

## 1. Proof-of-HEAD
- **HEAD `c7dc34a`** ("WP-W2-07 Heritage: 48 QR pages + /press + moksha + FB Top-5"). base = main @ `8270d98`.
- `style.css` Version = **1.4.5**. כל בדיקת HTTP חייבת cache-bust (`?cb=$(date +%s)$RANDOM`).

## 2. מה נבנה/פורס
| תוצר | מנגנון |
|------|--------|
| 48 עמודי QR `/qr/qr1..qr48/` | seeder `mu-plugins/ea-w2-07-qr-seed-once.php` יוצר עמודים תחת parent `qr` עם **post_content אמיתי** מ-`ea-w2-07-qr-content-data.php`, תבנית `tpl-qr.php`. slugs/nesting 1:1 מ-QR-URL-INVENTORY.csv. |
| `tpl-qr.php` (NEW) + `inc/wave2-w2-07.php` (router) + `tpl-qr` ב-`ea_wave2_is_active_view` (`wave2-stage-b.php`) | shell דק, `the_content()`. |
| `/press` | the_content injection (router) — 26 קישורי עיתונות, external new-tab. |
| `/about/moksha` | עדכון עמוד קיים ID 181 דרך REST (לא נוצר מחדש). |
| FB Top-5 testimonials | בלוק Wave2 קיים; טקסט מ-wave2-w2-04-content.php; avatars placeholder (F05). |
| `style.css` 1.4.5 · `w2-07-heritage.css` (D-14) · deploy-list +seeder · helper scripts | |

## 3. Static + Staging checks
```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-07"
php -l site/wp-content/themes/ea-eyalamit/inc/wave2-w2-07.php
php -l site/wp-content/themes/ea-eyalamit/page-templates/tpl-qr.php
php -l site/wp-content/mu-plugins/ea-w2-07-qr-seed-once.php
php -l site/wp-content/mu-plugins/ea-w2-07-qr-content-data.php
grep -nE "#[0-9a-fA-F]{3,6}" site/wp-content/themes/ea-eyalamit/assets/css/w2-07-heritage.css   # expect EMPTY
grep "^Version:" site/wp-content/themes/ea-eyalamit/style.css                                    # 1.4.5
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .                          # 0 FAIL

BASE="http://eyalamit-co-il-2026.s887.upress.link"
# AC-01: 48 QR — loop the inventory, expect all 200, ZERO localhost:9090 in HTML
for n in $(seq 1 48); do CB=$(date +%s)$RANDOM; printf "qr%s %s\n" "$n" "$(curl -s -o /dev/null -w '%{http_code}' -L "$BASE/qr/qr$n/?cb=$CB")"; done
curl -s -L "$BASE/qr/qr1/?cb=$(date +%s)$RANDOM" | grep -c "localhost:9090"   # expect 0
```

## 3A. תוספות-scope לאימות (מעבר ל-MODIFY הצפוי)
1. **2 mu-plugins חדשים** (`ea-w2-07-qr-seed-once.php` + `ea-w2-07-qr-content-data.php` ~78KB data) + שורת deploy.
   אשר: ABSPATH, init hook, option flag `ea_w2_07_qr_seeded_v3`, transient lock, NO wp-load re-require, idempotent.
2. **KSES handling** בתוך ה-seeder: `kses_remove_filters()` מותנה (רק אם היה פעיל) + `kses_init_filters()`
   ב-`finally` — אשר שמאוזן (1:1) ושמשוחזר תמיד (גם ב-early return). מטרה: לשמר `<iframe>` YouTube במיגרציה.
3. **moksha** עודכן דרך REST (page 181) — אשר שלא נוצר עמוד כפול.
4. **28 תמונות QR הושמטו** (מקור localhost:9090 כבוי לצמיתות; לא בקטלוגים; לא בגיבוי uploads). אשר: 0 URLs
   שבורים חיים, טקסט 48 עמודים 1:1. טבלת רזולוציה מלאה: `scripts/_w2_07_image_resolution.json` + build report.

## 4. AC Checklist
| AC | תיאור | ורדיקט |
|----|-------|--------|
| AC-01 | 48 QR `/qr/qrN/` → 200 (qr1..qr48, מול inventory CSV); 0 localhost leak | [ ] PASS/FAIL |
| AC-02 | /about/moksha תוכן + תמונה + לינק ל-/about | [ ] PASS/FAIL |
| AC-03 | /press ≥5 (26) כתבות, external new-tab | [ ] PASS/FAIL |
| AC-04 | FB Top-5 testimonials טקסט+תמונה(rehosted/placeholder)+לינק | [ ] PASS/FAIL |
| AC-05 | external new-tab + `validate_aos.sh` 0 FAIL | [ ] PASS/FAIL |

**הערות לא-חוסמות:** (a) QR count 48 (לא 49) — תוקן ב-spec, **team_190 יאשר מספר** בשער הבא. (b) 28 תמונות QR
= carry-forward לשחזור team_40 (מקור לא קיים מקומית). (c) avatars placeholder = spec F05.

## 5. דיווח ורדיקט
`_COMMUNICATION/team_50/VERDICT-W2-07-L-GATE-BUILD-2026-05-29.md` (verdict, validator_engine ≠ claude, head_verified c7dc34a, AC table, scope-additions review, findings).

## 6. Escalation
PASS / PASS_WITH_FINDINGS (ללא P0/P1) → team_100 + team_00 → team_190. FAIL → team_10.

*team_100 — 2026-05-29 — 48/48 QR 200 + /press + /about/moksha + Top-5 אומתו ע"י team_100; validate 0 FAIL; HEAD c7dc34a.*
