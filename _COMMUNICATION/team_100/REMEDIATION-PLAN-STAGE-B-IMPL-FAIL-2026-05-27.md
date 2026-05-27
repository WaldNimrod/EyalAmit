---
id: REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27
title: תוכנית תיקון — WP-W2-01-STAGE-B-IMPL FAIL (Phase 1) → Re-QA
status: ACTIVE
date: 2026-05-27
from_team: team_100 (Architect)
to_teams: [team_60 (FTPS+smoke), team_10 (A/B drift), team_20 (TLS), team_50 (re-QA), team_00 (acknowledge)]
parent_verdict: ../team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md
parent_disposition: ../team_00/DISPOSITION_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_2026-05-27.md
profile: L0
wp: WP-W2-01-STAGE-B-IMPL
gate: L-GATE_BUILD
phase: Round 2 (Phase 1 re-run)
---

# תוכנית תיקון — Stage B Impl FAIL (Phase 1)

## 0. אבחון

team_50 Phase 1 verdict (Round 1, commit `e773e5a`):
- **VERDICT: FAIL** — 4/14 VCs PASS, 10/14 FAIL.
- **שורש כשל:** הקוד **קיים ב-git** (commit e165218) אבל **לא נדחף לסטייג'ינג**. כל הבדיקות שדורשות תוצאה חיה (CSS enqueue, axe, Lighthouse, A/B, footer, WhatsApp) נכשלות עם 404.
- **Cross-engine violation:** team_50 רץ ב-Cursor (אותו engine כמו team_10). דורש סשן validation חדש בלא-Cursor.
- **A/B drift:** code שולח `ea_wa_ab_variant` / `{A,B,C}` במקום `eyal_cta_variant` / `{form_only,dual,wa_only}`.

**VCs שעברו ב-Round 1 (repo-side בלבד):** VC-3 (12 blocks), VC-4 (13 templates), VC-13 (books-wave1.css removed), VC-14 (validate_aos 0 FAIL). אלה **נשמרים** כתקפים — לא מריצים מחדש.

---

## 1. סדר תיקון נעול — 5 שלבים

```
[R1] team_60 FTPS deploy ──┐
[R2] team_10 A/B drift fix ─┼─→ [R3] Operator: WP page tpl-stage-b-test ─→ [R5] team_50 Re-QA (non-Cursor) ─→ verdict v2.0.0
[R4] team_20 TLS renew (parallel, MAJOR) ─┘                                                                        ↓
                                                                                              (Phase 2 awaits Eyal human gates)
```

### R1 — FTPS Deploy (team_60) · BLOCKER · 30 דק'

**מטרה:** העברת `site/wp-content/themes/ea-eyalamit/` ל-uPress staging.

**צעדים אופרטיביים:**
1. בדיקה ש-FTPS credentials עדיין תקפים (לפי `_COMMUNICATION/team_60/FTPS-VERIFY-2026-05-26.md`).
2. רשימת קבצים להעלאה (relative ל-`site/wp-content/themes/ea-eyalamit/`):
   - `assets/css/ea-tokens.css`
   - `assets/css/ea-animations.css`
   - `assets/css/ea-atoms.css`
   - `assets/js/ea-ab-testing.js`
   - `assets/js/ea-entrance.js`
   - `assets/js/ea-scroll.js`
   - `assets/js/ea-hero.js`
   - `inc/wave2-stage-b.php`
   - `inc/cf7-wave2-form.txt` (reference only — לא נטען בריצה)
   - `inc/analytics-config.json`
   - `template-parts/blocks/block-*.php` (12 קבצים)
   - `page-templates/tpl-*.php` (13 קבצים חדשים)
   - `functions.php` (מעודכן)
3. **למחוק** מהסטייג'ינג: `assets/css/books-wave1.css`.
4. אימות פוסט-deploy: `curl -I https://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css` → 200.
5. תיעוד: `_COMMUNICATION/team_60/STAGE-B-FTPS-DEPLOY-2026-05-27.md`.

**AC:**
- [ ] R1-AC-1: כל 30+ הקבצים זמינים ב-FTPS path הנכון.
- [ ] R1-AC-2: `books-wave1.css` הוסר מהסטייג'ינג.
- [ ] R1-AC-3: curl ל-3 קבצי CSS Wave2 → 200 OK.

### R2 — A/B Contract Drift Fix (team_10) · MAJOR · 15 דק'

**הקשר:** team_50 verdict מצביע על הפרת חוזה בין mandate ל-implementation.

**שתי אופציות (Architect decides — ראו §2):**

| אופציה | פעולה |
|--------|--------|
| **2a** — patch code | team_10 משנה ב-`ea-ab-testing.js`: `KEY = 'eyal_cta_variant'`, variants `['form_only','dual','wa_only']`. סיכון: שינוי לפני re-QA |
| **2b** — update mandate | team_100 מתעדכן ב-mandate: variants A/B/C מיופים ל-form_only/dual/wa_only. סיכון: drift מתועד אבל לא מתוקן בקוד |

**🟢 team_100 בחירה: 2a** — patch code (אותו עיקרון E1 ב-DECISION RECORD: SSOT הוא המנדט; code מתאים לו).

**צעדים:**
1. team_10 (cursor session — לא דורש cross-engine כי זה patch קצר):
   ```js
   // ea-ab-testing.js
   var KEY = 'eyal_cta_variant';
   var VARIANTS = ['form_only', 'dual', 'wa_only'];
   ```
2. עדכון blocks/JS שצורכים את ה-KEY כדי שיתאם.
3. תיעוד ב-`_COMMUNICATION/team_10/A-B-DRIFT-FIX-2026-05-27.md`.

**AC:**
- [ ] R2-AC-1: `grep "ea_wa_ab_variant" site/wp-content/themes/ea-eyalamit/` = 0 results.
- [ ] R2-AC-2: `grep "eyal_cta_variant" site/wp-content/themes/ea-eyalamit/` ≥ 1 result.
- [ ] R2-AC-3: 3 variants התואמים: form_only / dual / wa_only.

### R3 — WP Smoke Page (Operator: nimrod או team_10) · BLOCKER · 5 דק'

**מטרה:** עמוד WP אמיתי ב-staging שמשתמש ב-tpl-stage-b-test.

**צעדים אופרטיביים ב-WP admin:**
1. כניסה ל-WP admin של staging: `https://eyalamit-co-il-2026.s887.upress.link/wp-admin/` (התעלם מ-TLS warning עד R4).
2. Pages → Add New.
3. Title: "Wave2 Stage B Smoke Test".
4. Slug: `wave2-test` (Permalink → Edit → wave2-test).
5. Page Attributes → Template → **tpl-stage-b-test**.
6. Publish.
7. אימות: `https://eyalamit-co-il-2026.s887.upress.link/wave2-test/` → 200, מציג 12 בלוקים.

**AC:**
- [ ] R3-AC-1: עמוד פעיל ב-slug `/wave2-test/`.
- [ ] R3-AC-2: 12 בלוקים נרנדרים.
- [ ] R3-AC-3: View Source — `<link>` ל-ea-tokens.css + ea-animations.css + ea-atoms.css.

### R4 — TLS Renew (team_20) · MAJOR · במקביל

**הקשר:** verdict מצביע שתעודת staging פגה.

**אופציות:**
- uPress פאנל → SSL → renew.
- Let's Encrypt (אם uPress תומך).
- Cloudflare flexible SSL (אם דומיין מנותב דרך Cloudflare).

**אומדן:** 15-60 דק' (תלוי בpath).

**AC:**
- [ ] R4-AC-1: `curl -I https://eyalamit-co-il-2026.s887.upress.link/` → 200 ללא TLS warning.
- [ ] R4-AC-2: תעודה תקפה ≥ 30 יום.

**הערה:** R4 הוא MAJOR, לא BLOCKER מוחלט. אם נתקעים — team_50 רץ Phase 1 על HTTP ומתעד כ-finding.

### R5 — Re-QA Phase 1 (team_50 non-Cursor) · BLOCKER

**מטרה:** validation מחודש על Stage B impl עם cross-engine נכון.

**דרישות סשן:**
- engine: Claude Code / Codex / Gemini (**NOT Cursor**).
- artifact פלט: `_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md`.
- הצהרת engine ב-§1 חובה.

**VCs להריץ:**
- VC-1, 2, 5, 6, 7, 8, 9, 10, 11, 12 — מ-Round 1 שכשלו. עכשיו על `https://eyalamit-co-il-2026.s887.upref.link/wave2-test/` (after R1-R4).
- VC-3, 4, 13, 14 — **לא** רצים מחדש (כבר PASS ב-Round 1; AOS Iron Rule allows carry-forward של repo-side VCs).

**AC ל-verdict v2.0.0:**
- [ ] R5-AC-1: 14/14 VCs PASS (או PASS_WITH_FINDINGS עם findings non-blocker).
- [ ] R5-AC-2: validator_engine ≠ cursor (declared §1).
- [ ] R5-AC-3: evidence files נוצרו (axe JSON, Lighthouse HTML+JSON, screenshots).

---

## 2. החלטות team_100 שאני נועל כאן

### החלטה 1 — A/B drift
**🟢 בחירה: R2 אופציה 2a** (patch code לקריאות mandate). הצדקה: DECISION RECORD §2.1 — mandate הוא SSOT, code מתאים לו.

### החלטה 2 — Cross-engine carry-forward
4 ה-VCs שעברו ב-Round 1 ב-Cursor (VC-3, 4, 13, 14) הם **repo-side בלבד** (ls/grep/validate_aos) — תוצאתם דטרמיניסטית לא תלויית engine. **מאושר carry-forward** ל-verdict v2.0.0. team_50 בRound 2 צריך רק לאשר שאלה לא חזרו לכשול.

### החלטה 3 — TLS scope
R4 נשאר MAJOR, **לא חוסם** את R5. team_50 רץ על HTTP ומציין TLS כ-finding. ה-finding ייסגר ב-cutover (לפי roadmap §"מעבר מלא ל-HTTPS").

### החלטה 4 — Phase 2 trigger
Phase 2 ירוץ **רק** אחרי Phase 1 PASS ב-Round 2 **וגם** Eyal השלים 3 ה-human gates.

---

## 3. תיאום בין צוותים

### סדר הפעלה
```
T0:    team_60 R1 (deploy)  ─┐
T0+15: team_10 R2 (A/B fix) ─┼─→ T0+30: Operator R3 (smoke page) ─→ T0+45: team_50 R5 (re-QA)
T0:    team_20 R4 (TLS, parallel) ─┘
```

### סשנים נדרשים
- **team_60:** Cursor (FTPS via existing infra).
- **team_10:** Cursor (קצר — 15 דק' patch).
- **Operator:** WP admin browser (no agent).
- **team_20:** Cursor or any (uPress panel).
- **team_50:** **Claude Code / Codex / Gemini** (לא Cursor!).

---

## 4. תוצרים סופיים של Round 2 — checklist

- [ ] `_COMMUNICATION/team_60/STAGE-B-FTPS-DEPLOY-2026-05-27.md`
- [ ] `_COMMUNICATION/team_10/A-B-DRIFT-FIX-2026-05-27.md`
- [ ] WP page `/wave2-test/` live (no artifact — UI only)
- [ ] `_COMMUNICATION/team_20/STAGING-TLS-RENEW-2026-05-27.md` (if R4 attempted)
- [ ] `_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md` — PASS or PASS_WITH_FINDINGS
- [ ] team_100 acknowledges + advances gate in `_aos/roadmap.yaml` (when verdict v2 = PASS)

---

## 5. אומדן זמן Round 2

| שלב | אחראי | זמן |
|------|--------|-----|
| R1 deploy | team_60 | 30 דק' |
| R2 A/B fix | team_10 | 15 דק' |
| R3 smoke page | operator | 5 דק' |
| R4 TLS (parallel) | team_20 | 15-60 דק' |
| R5 re-QA Phase 1 | team_50 (non-Cursor) | 2-3 שעות |

**סה"כ בקריטיקל פאת:** ~3-4 שעות (לא כולל TLS אם מקביל).

---

## 6. Activation prompts לסשנים החדשים

ב-§7 — 3 prompts מוכנים: team_60 deploy, team_10 A/B patch, team_50 re-QA.

### 6.1 — team_60 deploy

```
HANDOFF_DEPTH: lean
ACTIVATION_SCOPE: team_60 only — FTPS Stage B Deploy

Identity: team_60 (Staging/FTPS infrastructure)
Engine: Cursor (no cross-engine constraint for deploy work)

Mandate: _COMMUNICATION/team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md §R1

Source files (deploy from): EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/
Target: uPress staging FTPS path /wp-content/themes/ea-eyalamit/
Credentials: per _COMMUNICATION/team_60/FTPS-VERIFY-2026-05-26.md (working).

Steps:
1. List delta vs current staging.
2. Upload all new + modified files (3 CSS, 4 JS, inc/*, 12 blocks, 13 templates, functions.php).
3. Delete staging assets/css/books-wave1.css.
4. Verify: curl -I https://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css → 200.
5. Write _COMMUNICATION/team_60/STAGE-B-FTPS-DEPLOY-2026-05-27.md.
6. git commit + push.

FIRST READ: _COMMUNICATION/team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md
```

### 6.2 — team_10 A/B fix

```
HANDOFF_DEPTH: lean
ACTIVATION_SCOPE: team_10 only — A/B Contract Drift Patch

Identity: team_10 (Builder)
Engine: Cursor (short patch; no cross-engine constraint)

Mandate: _COMMUNICATION/team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md §R2 (option 2a)

Task: Patch site/wp-content/themes/ea-eyalamit/assets/js/ea-ab-testing.js:
- KEY: 'ea_wa_ab_variant' → 'eyal_cta_variant'
- VARIANTS: ['A','B','C'] → ['form_only', 'dual', 'wa_only']
- Update any consumer code in blocks/template-parts that reads these names.
- Update header comment to reflect canonical names.

AC:
- grep "ea_wa_ab_variant" site/ → 0 results
- grep "eyal_cta_variant" site/ → ≥ 1 result
- grep -E "'(A|B|C)'" ea-ab-testing.js → 0 (after replacement)

Deliverable: _COMMUNICATION/team_10/A-B-DRIFT-FIX-2026-05-27.md + git commit.

FIRST READ: _COMMUNICATION/team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md §R2
```

### 6.3 — team_50 re-QA Round 2

```
HANDOFF_DEPTH: lean
ACTIVATION_SCOPE: team_50 only — Stage B Impl Re-QA Phase 1 Round 2

🚨 Engine: NOT Cursor. Claude Code / Codex / Gemini required.

Identity: team_50 (QA)
Mandate: _COMMUNICATION/team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md §R5
Original mandate: _COMMUNICATION/team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md
Prior verdict (FAIL): _COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md

Trigger condition (verify before starting):
1. team_60 deploy complete (curl ea-tokens.css → 200)
2. team_10 A/B fix committed (grep eyal_cta_variant → present)
3. Smoke page /wave2-test/ live (curl → 200)

Run VC-1, 2, 5, 6, 7, 8, 9, 10, 11, 12 fresh on https://eyalamit-co-il-2026.s887.upress.link/wave2-test/
(Use HTTP if TLS not yet renewed; flag as finding.)

Carry-forward: VC-3, 4, 13, 14 already PASS in Round 1 (repo-side, engine-agnostic). Confirm no regression.

Deliverable: _COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md
- §1 validator_engine declaration (NOT cursor) — MANDATORY
- §2 14 VCs (10 fresh + 4 carry-forward)
- §3 findings
- §4 validate_aos.sh
- §5 evidence (axe, Lighthouse)
- git commit "qa(WP-W2-01-STAGE-B-IMPL/L-GATE_BUILD): {VERDICT} v2 — Team 50"

FIRST READ: _COMMUNICATION/team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md
```

---

## 7. שינוי גרסה

| תאריך | פעולה |
|-------|--------|
| 2026-05-27 | team_50 verdict v1.0.0 FAIL → team_100 רושם remediation plan |
