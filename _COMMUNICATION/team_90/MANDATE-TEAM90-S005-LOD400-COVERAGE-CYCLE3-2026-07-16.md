---
id: MANDATE-TEAM90-S005-LOD400-COVERAGE-CYCLE3-2026-07-16
from_team: team_100
to_team: team_90
date: 2026-07-16
type: cross-engine-validation-mandate
correction_cycle: 3
prior_verdict: _COMMUNICATION/team_90/VERDICT-S005-LOD400-COVERAGE-CYCLE2-2026-07-16.md
wp: S005-PACKAGE-1-3 (WP-S5-01, WP-S5-02, WP-S5-03)
target_artifacts:
  - _COMMUNICATION/team_100/S005/S005-PACKAGE-1-3-INDEX-2026-07-16.md
  - _COMMUNICATION/team_100/S005/WP-S5-01-LOD400-2026-07-16.md
  - _COMMUNICATION/team_100/S005/WP-S5-02-LOD400-2026-07-16.md
  - _COMMUNICATION/team_100/S005/WP-S5-03-LOD400-2026-07-16.md
builder_engine: claude-opus-4-8 (Claude Code)
required_validator_engine: non-Claude (composer-2.5 / cursor vendor) — Iron Rule #1
---

# MANDATE — team_90: ולידציה חוצת-מנוע S005 LOD400 — CYCLE 3 (סגירת F-05 + PASS נקי)

## הקשר

Cycle 2 (`VERDICT-S005-LOD400-COVERAGE-CYCLE2-2026-07-16.md`): F-01..F-04 **CLOSED**, 0 blockers, אין רגרסיה,
3/3 spot-check PASS — ונותר ממצא minor אחד חדש: **F-05** (drift ספירת-hrefs במטריצת האינדקס §3, שורה #3, שנשארה «5 hrefs»
בעוד WP-S5-01 עודכן ל-6). team_100 תיקן. מטרת cycle זה: **PASS נקי (0 findings)** — parity עם S004 cycle3.

## מה תוקן

**F-05** — `S005-PACKAGE-1-3-INDEX-2026-07-16.md` §3 מטריצה שורה #3 (עמודת AC): «5 hrefs» → **«6 hrefs (hub /shop/ + 5 מסלולי-מוצר)»**.
**אמת:** grep על כל 4 מסמכי S005 ל-«5 hrefs»/«5 מסלולי-חנות» = **0 תוצאות**; «6 hrefs» עקבי בין אינדקס §3 ל-WP-S5-01 §3/§6.

## מה לבדוק ב-cycle 3

1. **סגירת F-05** — מטריצת האינדקס §3 שורה #3 אומרת כעת «6 hrefs» ותואמת את WP-S5-01 §3/§6 ואת הקוד החי (`section-nav.php` — 6 `<a href>`).
2. **אין «5 hrefs» שנותר** בשום מקום ב-4 המסמכים (`grep -rn '5 hrefs\|5 מסלולי-חנות' <S005 dir>` = ריק).
3. **אין רגרסיה** — F-01..F-04 עדיין CLOSED; `next_wp` מיושר ב-3 המקורות; `_aos/roadmap.yaml` parses; Option A עקבי; חפיפת S5-01↔S5-02 נקייה.
4. **hygiene** — 4 המסמכים `date: 2026-07-16`, frontmatter מלא, אין TBD/placeholder אמיתי.

## פורמט התשובה

Verdict: `PASS` (מטרה — 0 findings) / `PASS_WITH_FINDINGS` / `FAIL`. אם נקי — `PASS` מפורש עם attestation ש-F-01..F-05 כולם CLOSED.
פלט: `_COMMUNICATION/team_90/VERDICT-S005-LOD400-COVERAGE-CYCLE3-2026-07-16.md` (frontmatter `correction_cycle: 3`).
