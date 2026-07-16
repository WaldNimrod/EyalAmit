---
id: MANDATE-TEAM90-S005-LOD400-COVERAGE-CYCLE2-2026-07-16
from_team: team_100
to_team: team_90
date: 2026-07-16
type: cross-engine-validation-mandate
correction_cycle: 2
prior_verdict: _COMMUNICATION/team_90/VERDICT-S005-LOD400-COVERAGE-2026-07-16.md
wp: S005-PACKAGE-1-3 (WP-S5-01, WP-S5-02, WP-S5-03)
target_artifacts:
  - _COMMUNICATION/team_100/S005/S005-PACKAGE-1-3-INDEX-2026-07-16.md
  - _COMMUNICATION/team_100/S005/WP-S5-01-LOD400-2026-07-16.md
  - _COMMUNICATION/team_100/S005/WP-S5-02-LOD400-2026-07-16.md
  - _COMMUNICATION/team_100/S005/WP-S5-03-LOD400-2026-07-16.md
builder_engine: claude-opus-4-8 (Claude Code)
required_validator_engine: non-Claude (composer-2.5 / cursor vendor) — Iron Rule #1
---

# MANDATE — team_90: ולידציה חוצת-מנוע S005 LOD400 — CYCLE 2 (re-check תיקוני F-01..F-04)

## הקשר

Cycle 1 (`VERDICT-S005-LOD400-COVERAGE-2026-07-16.md`) החזיר **PASS_WITH_FINDINGS**: 0 blockers, 10/10 spot-check PASS,
כל בדיקות הכיסוי/עקביות/Option-A PASS — ו-**4 ממצאים minor** (F-01..F-04). team_100 תיקן את כל ה-4. מטרת cycle זה:
לאשר **PASS נקי (0 findings)** — parity עם S004 cycle3.

## מה תוקן (אמת שכל אחד סגור)

1. **F-01** (WP-S5-01 §3/§6): אי-התאמת ספירת hrefs — היה «5 hrefs» מול 6 בפועל. תוקן ל-**«6 hrefs (hub /shop/ + 5 מסלולי-מוצר)»**
   ב-3 מקומות (§3 פתיח, §3 AC-3 סעיף 2, §6 טבלה). **אמת:** אין יותר «5 hrefs»/«5 מסלולי-חנות»; הספירה 6 עקבית ותואמת את הקוד החי
   (`section-nav.php` — 6 `<a href>`: `/shop/` + 5 מוצר).
2. **F-02** (WP-S5-02 §2.4): ה-hub `/qr/` meta היה fork «לפי בחירת הבונה». תוקן ל-**כניסת `$map` קאנונית יחידה** (`'qr' => '...'`, ≤155 תווים).
   **אמת:** אין יותר fork; יש שורה קאנונית אחת.
3. **F-03** (`_aos/roadmap.yaml` WP-S5-02 `notes`): הוסר «OR explicit noindex», הוחלף ב-**Option A ratified 2026-07-16**.
   **אמת:** ה-notes תואמים ל-Option A ול-LOD400.
4. **F-04** (`_aos/roadmap.yaml` WP-S5-01 `notes`): `/shows` → `/shows-heritage`. **אמת:** אין יותר `/shows ` בודד ב-notes.

## מה לבדוק ב-cycle 2

1. **סגירת F-01..F-04** — כל אחד מהארבעה **CLOSED** (ציטוט המיקום המתוקן).
2. **אין רגרסיה** — התיקונים לא שברו עקביות אחרת: `next_wp` עדיין מיושר ב-3 המקורות; `_aos/roadmap.yaml` עדיין parses
   (`python3 -c "import yaml; yaml.safe_load(...)"`); Option A עדיין עקבי; החפיפה S5-01↔S5-02 עדיין נקייה (verify-only מול BUILD).
3. **hygiene** — 4 המסמכים עדיין `date: 2026-07-16`, frontmatter מלא, אין TBD/placeholder אמיתי.
4. **סריקה טרייה** — spot-check קצר (2-3 טענות חדשות מול קוד חי) לוודא שלא נכנס אי-דיוק חדש בעריכות.

## פורמט התשובה

Verdict: `PASS` (מטרה) / `PASS_WITH_FINDINGS` / `FAIL`. אם נותרו ממצאים — רשימה עם חומרה + מיקום. אם נקי — `PASS` מפורש.
פלט: `_COMMUNICATION/team_90/VERDICT-S005-LOD400-COVERAGE-CYCLE2-2026-07-16.md` (frontmatter `correction_cycle: 2`).
