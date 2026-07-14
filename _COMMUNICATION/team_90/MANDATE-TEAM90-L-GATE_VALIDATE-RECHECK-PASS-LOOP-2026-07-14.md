---
id: MANDATE-TEAM90-L-GATE_VALIDATE-RECHECK-PASS-LOOP-2026-07-14
from_team: team_110
to_team: team_90
cc: team_00, team_100, team_50
date: 2026-07-14
type: validate-recheck-mandate
wp: WP-CANON-TEMPLATE-UNIFICATION
gate: L-GATE_VALIDATE
builder_engine: cursor-grok-4.5
validator_engine_required: composer-2.5
prior_verdict: _COMMUNICATION/team_90/VERDICT-WP-CANON-L-GATE_VALIDATE-2026-07-14.md
target_overall: PASS
---

# MANDATE — team_90 · L-GATE_VALIDATE recheck (PASS loop)

## מטרה

סגירת `PASS_WITH_FINDINGS` → **`PASS`** אחרי תיקוני hygiene של team_110.

## תיקונים לבדיקה

| ID | תיקון |
|----|--------|
| F90-M01 | כבר נוקה ב-`product-cta.php` (אין הפניות שורה ל-w2-05 שנמחק) — אמת מחדש |
| F90-M02 | `tpl-books.php` / `tpl-catalog-14e.php` הם stubs 301 — **אין** קריאה ל-`ea_w2_05_render_books_archive` / `ea_w2_14e_*` |
| F50-WP-01 | `/shop/` CTA = «לעמוד המוצר ←» (לא «לעמוד הספר») |
| F50-WP-02 | גלריות ספרים: אין «יתווספו»; ≥3 תמונות אמיתיות לכל ספר |
| T7-04 FAQ PARTIAL | **ACCEPT מתועד** — many-to-many by design; לא חוסם PASS אם CRITICAL V-01…V-07 עדיין PASS |

## פלט

`_COMMUNICATION/team_90/VERDICT-WP-CANON-L-GATE_VALIDATE-RECHECK-PASS-LOOP-2026-07-14.md`

`overall: PASS` אם כל CRITICAL + hygiene F90-M01/M02 סגורים. Iron Rule #1: validator = composer-2.5 ≠ builder Grok.
