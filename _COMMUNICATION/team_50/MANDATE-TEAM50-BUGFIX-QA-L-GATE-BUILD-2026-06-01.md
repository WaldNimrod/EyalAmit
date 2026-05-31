---
id: MANDATE-TEAM50-BUGFIX-QA-L-GATE-BUILD-2026-06-01
title: team_50 mandate — L-GATE_BUILD for the bug-fix sweep + HTTP QA
status: ACTIVE — awaiting team_50 verdict
date: 2026-06-01
from_team: team_100 (Chief System Architect)
to_team: team_50 (L-GATE_BUILD Validator — NON-Claude)
deliverable: known-bug fix sweep (4 fixes) + reusable HTTP QA tooling
branch: chore/bugfix-qa-http
head_commit: 016de33
fixes_commit: 90cf695
base_main: d359850
staging: http://eyalamit-co-il-2026.s887.upress.link
report_ref: _COMMUNICATION/team_100/BUGFIX-SWEEP-AND-HTTP-QA-2026-06-01.md
---

# מנדט team_50 — L-GATE_BUILD / Bug-fix sweep + HTTP QA

## 0. הקשר + Cross-engine (IR#1) — חובה
התיקונים וה-QA נבנו והורצו ע"י **Claude (builder)**. לכן **validator team_50 חייב מנוע שאינו Claude**
(cursor-composer / GPT וכד'). הצהר את המנוע בשורה הראשונה של הוורדיקט. זוהי בדיקה עצמאית — אל תסתמך על
דיווח ה-builder; שחזר הכול בעצמך מול ה-staging (HTTP בלבד — אין SSL בסטייג'ינג, EYAL_ENV_VARS_REFERENCE §44).

## 1. Proof-of-HEAD
- branch `chore/bugfix-qa-http`, HEAD **`016de33`** (fixes ב-`90cf695`), base origin/main `d359850`.
- כל בדיקת HTTP עם cache-bust: `?cb=$(date +%s)$RANDOM`. בסיס: `http://eyalamit-co-il-2026.s887.upress.link`.

## 2. מה תוקן + פורס לסטייג'ינג (4 באגים)
| # | באג | קובץ | מנגנון |
|---|-----|------|--------|
| B1 | F-W2-06-03/IDEA-006 — כרטיסי ארכיון הבלוג הדליפו `[vc_row…]` גולמי | `site/wp-content/mu-plugins/ea-blog-shortcode-cleanup.php` | נוסף filter על `get_the_excerpt` (pipeline התקציר לא מנקה shortcodes לא-רשומים) |
| B2 | F-W2-08-01 — body class `ea-blog-archive-view` דלף ל-/en ולכל עמודי Wave2 | `themes/ea-eyalamit/inc/wave2-w2-06.php` | `ea_wave2_is_active_view()` לא מקבל ארגומנט → תמיד true; צומצם ל-`is_home() \|\| tpl-blog-archive` |
| B3 | F-W2-10-F (M4/M5/M6) — footer + skip-link ב-/en עם physical props שלא מתהפכים ב-`dir=ltr` | `themes/ea-eyalamit/assets/css/w2-08-en-landing.css` | override LTR scoped ל-`body.ea-en-landing` (footer `row`/`flex-start`; skip-link `left:0`) |
| B4 | WP-W2-10-D Q1 — byline הבלוג הציג `eyaladmin` במקום אייל עמית | `themes/ea-eyalamit/.../mu-plugins/ea-w2-10-author-displayname-once.php` (חדש) | once-plugin מגדיר `display_name`/`nickname` |

NOT changed (לידיעה): hero H1 `<br>` בעמוד הבית (POC מאושר → NEEDS-DECISION, לא באג).

## 3. בדיקות (HTTP בלבד, cache-busted) — שחזר הכול
```bash
# סטטי
php -l site/wp-content/mu-plugins/ea-blog-shortcode-cleanup.php
php -l site/wp-content/mu-plugins/ea-w2-10-author-displayname-once.php
php -l site/wp-content/themes/ea-eyalamit/inc/wave2-w2-06.php
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .   # 0 FAIL
bash scripts/final_pre_cutover_check.sh                                    # exit 0 (ללא רגרסיה)

# QA אוטומטי מחדש (חייב להריץ במנוע שלך, לא Claude)
cd scripts/qa && npm install --no-audit --no-fund && cd ../..
node scripts/qa/http-qa-axe.cjs                 # 14 routes, 0 critical / 0 serious, כולם 200
bash scripts/qa/http-qa-lighthouse.sh / /treatment/ /blog/ /en/

# אימות חי של 4 התיקונים
BASE="http://eyalamit-co-il-2026.s887.upress.link"
curl -s "$BASE/blog/?cb=$(date +%s)$RANDOM"  | grep -c '\[vc_'                 # B1: צריך 0
curl -s "$BASE/en/?cb=$(date +%s)$RANDOM"    | grep -c 'ea-blog-archive-view'  # B2: צריך 0
curl -s "$BASE/blog/?cb=$(date +%s)$RANDOM"  | grep -c 'ea-blog-archive-view'  # B2: צריך ≥1 (לא נמחק יתר)
curl -s "$BASE/wp-content/themes/ea-eyalamit/assets/css/w2-08-en-landing.css" | grep -c 'LTR mirror fixes'  # B3: צריך 1
# B4: פתח פוסט מ-/blog/ ובדוק "מאת: אייל עמית" ב-.ea-post-meta__author
```

## 4. AC Checklist
| AC | תיאור | ורדיקט |
|----|-------|--------|
| AC-01 | B1: `/blog/` ללא `[vc_` כלשהו (היה 10) | [ ] PASS/FAIL |
| AC-02 | B2: `/en` ללא `ea-blog-archive-view`; `/blog/` עדיין כן | [ ] PASS/FAIL |
| AC-03 | B3: override LTR מוגש; footer/skip-link מיושרים ל-LTR ב-/en | [ ] PASS/FAIL |
| AC-04 | B4: byline פוסט = "אייל עמית" | [ ] PASS/FAIL |
| AC-05 | axe HTTP: 14/14 routes 200 + 0 critical / 0 serious | [ ] PASS/FAIL |
| AC-06 | Lighthouse HTTP: a11y ≥97; perf כמדווח (/en 84=F2 hero JPG); SEO/BP staging-capped | [ ] PASS/FAIL |
| AC-07 | אין רגרסיה: `validate_aos.sh` 0 FAIL + `final_pre_cutover_check.sh` exit 0 + 3× php -l נקי | [ ] PASS/FAIL |

תוצר הוורדיקט: `_COMMUNICATION/team_50/VERDICT-BUGFIX-QA-L-GATE-BUILD-2026-06-01.md` (הצהר מנוע; PASS/FAIL לכל AC).

---

## 📋 PROMPT מוכן-להדבקה (team_50 — הדביקו במנוע שאינו Claude)

```
אתה team_50, מאמת L-GATE_BUILD (cross-engine; אתה חייב להיות מנוע שאינו Claude — הצהר אותו).
ריפו: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026 · branch chore/bugfix-qa-http · HEAD 016de33.
משימה: אמת באופן עצמאי את תיקון 4 הבאגים + ה-QA-over-HTTP במנדט
_COMMUNICATION/team_50/MANDATE-TEAM50-BUGFIX-QA-L-GATE-BUILD-2026-06-01.md.

עשה:
1) הרץ את בלוק הבדיקות בסעיף 3 (php -l ×3, validate_aos 0 FAIL, final_pre_cutover_check exit 0).
2) הרץ בעצמך את ה-QA: `node scripts/qa/http-qa-axe.cjs` (14 routes → 0 critical/0 serious, כולם 200)
   ו-`bash scripts/qa/http-qa-lighthouse.sh / /treatment/ /blog/ /en/`.
3) אמת חי (HTTP, cache-bust) את AC-01..AC-04 (4 התיקונים) כפי שמפורט בסעיף 3.
4) staging הוא HTTP בלבד (אין SSL) — אל תשתמש ב-https.
כתוב verdict ל-_COMMUNICATION/team_50/VERDICT-BUGFIX-QA-L-GATE-BUILD-2026-06-01.md: שורה 1 = שם המנוע;
טבלת AC-01..07 PASS/FAIL עם ראיה (מספרי curl/axe/lighthouse); כל P0/P1 חוסם, P3 = carry-forward.
אל תשנה קוד — בדיקה בלבד. אל תעשה commit/push.
```

*team_100 → team_50 | מנדט L-GATE_BUILD לסבב תיקוני הבאגים + QA. PASS → מעבר ל-team_190 (L-GATE_VALIDATE).*
