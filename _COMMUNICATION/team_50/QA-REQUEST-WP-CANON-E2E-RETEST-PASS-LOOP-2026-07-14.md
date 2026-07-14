---
id: QA-REQUEST-WP-CANON-E2E-RETEST-PASS-LOOP-2026-07-14
from_team: team_110
to_team: team_50
cc: team_00, team_100, team_90
date: 2026-07-14
type: qa-retest-request
wp: WP-CANON-TEMPLATE-UNIFICATION
staging: http://eyalamit-co-il-2026.s887.upress.link
builder_engine: cursor-grok-4.5
qa_engine_required: composer-2.5
prior_report: _COMMUNICATION/team_50/QA-REPORT-WP-CANON-TEMPLATE-UNIFICATION-E2E-2026-07-14.md
target_overall: PASS
---

# QA RETEST — צוות 50 · סגירת PASS_WITH_FINDINGS → PASS

## הקשר

team_00 דרש לולאת תיקון עד **PASS מלא** (לא `PASS_WITH_FINDINGS`) לפני אישור פריסה.

team_110 (Grok) תיקן את ממצאי P2 הקודמים ופרס שוב ל-FTP. נדרש **ריטסט עצמאי** על Composer 2.5 (Iron Rule #1).

## תיקונים שנסגרו (לבדיקה חוזרת)

| ID קודם | תיקון | אימות צפוי |
|---------|--------|------------|
| F50-WP-01 | `bookcard` מקבל `cta_label`; `/shop/` = «לעמוד המוצר ←»; `/books/` נשאר «לעמוד הספר ←»; `/qr/` = «לעמוד ה-QR ←» | HTML `/shop/` — 0× «לעמוד הספר» בכרטיסי מוצר |
| F50-WP-02 | גלריות ספרים: 3 תמונות אמיתיות לכל ספר; הוסר lead «תמונות נוספות יתווספו…» | `/books/vekatavta/` וכו' — אין «יתווספו»; ≥3 `.gfig` / gallery imgs |
| F90-M02 | `tpl-books.php` / `tpl-catalog-14e.php` — 301 stubs (לא קוראים ל-Wave2 שנמחק) | קובץ לא קורא `ea_w2_05_*` / `ea_w2_14e_*` |

**מחוץ לסקופ ריטסט (לא חוסם PASS):** C-5 tsva Mendele URL (ממתין לאייל); F50-WP-03/04 היו מתודולוגיה/jitter — בריטסט זה נסו MCP דפדפן אם זמין.

## סביבה

- Base: `http://eyalamit-co-il-2026.s887.upress.link`
- FTP redeploy הושלם אחרי התיקונים
- כלים: `qa_probe.mjs` + curl/HTML + **MCP דפדפן אם רשום** (navigate→lock→snapshot→unlock)

## מטריצה (מינימום)

אותה מטריצה כמו ב-QA-REQUEST המקורי, עם דגש על:

1. `/shop/` — CTA copy
2. `/books/vekatavta/`, `/books/kushi-blantis/`, `/books/tsva-bekahol/` — gallery real images, no «יתווספו»
3. `/qr/` — CTA «לעמוד ה-QR»
4. QR matrix 48/48 + qa_probe overflow @375 על נתיבי הליבה

## קריטריון PASS מלא

- **overall: PASS** רק אם **0 ממצאים P0/P1/P2 פתוחים** ששייכים לקוד/UI בבעלות team_110.
- ממצא מתודולוגי בלבד (MCP חסר) → לתעד ב-Methodology **בלי** להוריד ל-PASS_WITH_FINDINGS אם כל AC תוכן/לייאאוט עברו עם qa_probe+HTML.
- C-5 PENDING → לא ממצא חדש (מקובל).

## פלט חובה

`_COMMUNICATION/team_50/QA-REPORT-WP-CANON-E2E-RETEST-PASS-LOOP-2026-07-14.md`

Frontmatter: `overall: PASS` או `PASS_WITH_FINDINGS` / `FAIL` + טבלת ממצאים + evidence.
