---
id: MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0
title: team_50 QA Mandate — WP-W2-01 Stage B Implementation
status: ACTIVE — execute in fresh team_50 session
date: 2026-05-27
from_team: team_00 (nimrod, Principal) via team_100
to_team: team_50 (QA & Functional Acceptance)
target_wp: WP-W2-01 — Stage B (implementation)
gate: L-GATE_BUILD
mandate_for_review: _COMMUNICATION/team_10/MANDATE-TEAM10-STAGE-B-IMPLEMENTATION-2026-05-27.md
implementation_report: _COMMUNICATION/team_10/STAGE-B-COMPLETION-REPORT-2026-05-27.md
implementation_commit: e165218
builder_engine: cursor-composer (team_10 implemented in Cursor)
validator_engine_required: "NOT cursor (cross-engine rule). Use Claude Code OR Codex/GPT OR Gemini."
profile: L0
phases: 2
phase_1_blocker: false
phase_2_blocker: "Eyal must complete 3 human-gate items (SMTP App Password, GA4 Measurement ID, Clarity Project ID)"
---

# team_50 QA Mandate — WP-W2-01 Stage B Implementation

## 0. הקשר

team_10 השלים את Stage B implementation בסשן Cursor (engine: cursor-composer). 30+ קבצים ב-`site/wp-content/themes/ea-eyalamit/`. validate_aos.sh: 30 PASS / 18 SKIP / 0 FAIL.

**Cross-engine constraint (Iron Rule #1):**
- Builder: cursor-composer (team_10)
- Validator: **MUST NOT be cursor**. נדרש Claude Code / Codex / GPT / Gemini.
- אם הסביבה היחידה הזמינה היא cursor — עצור, דווח ל-team_00.

---

## 1. QA דו-פאזי

### Phase 1 — Immediate QA (אפשר עכשיו, ללא תלות באייל)

מה ניתן לבדוק עכשיו, על dev/staging, ללא שאייל יזין SMTP/GA4/Clarity:

| VC | תיאור | איך לבדוק |
|----|--------|-----------|
| **VC-1** | enqueue: `ea-tokens.css`, `ea-animations.css`, `ea-atoms.css` נטענים בעמוד | `curl https://eyalamit-co-il-2026.s887.upress.link/?page=<wave2_test>` + grep ל-`<link rel="stylesheet" href=".*ea-tokens.css">` |
| **VC-2** | CSS variables זמינים: `--ea-text-body`, `--ea-muted`, `--ea-terra`, `--ea-ink` (verify מ-D-14 v1.1) | DevTools → Computed styles בעמוד test |
| **VC-3** | 12 block partials קיימים ב-`template-parts/blocks/` ובעלי תוכן תקין | `ls site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-*.php \| wc -l` = 12 |
| **VC-4** | 12 page templates (Wave2) רשומים | `grep -l "Template Name:" site/wp-content/themes/ea-eyalamit/page-templates/tpl-*.php \| wc -l` ≥ 12 |
| **VC-5** | `tpl-stage-b-test.php` מציג את 12 הבלוקים | טעינת dummy page עם template `tpl-stage-b-test` ב-staging |
| **VC-6** | axe-core CLI על `tpl-stage-b-test` — 0 violations critical/serious | `npx @axe-core/cli https://eyalamit-co-il-2026.s887.upress.link/wave2-test/ --tags wcag2aa` |
| **VC-7** | Lighthouse mobile על `tpl-stage-b-test` — perf ≥85, a11y ≥95 | `npx lighthouse <url> --form-factor=mobile --only-categories=performance,accessibility --output=json` |
| **VC-8** | `prefers-reduced-motion` fallback — אנימציות נעצרות בדפדפן עם `reduce` | DevTools → Rendering → Emulate CSS prefers-reduced-motion: reduce → manual check |
| **VC-9** | RTL behavior — `direction: rtl` על `html`/`body`, כל הבלוקים מציגים נכון | DevTools manual + visual diff |
| **VC-10** | A/B testing script מקצה variant random ב-sessionStorage | DevTools → Application → Session Storage → key `eyal_cta_variant` ∈ {form_only, dual, wa_only} |
| **VC-11** | Footer מציג 3 לינקים (FB+IG+YT) עם `target="_blank" rel="noopener noreferrer"` | DOM inspection |
| **VC-12** | WhatsApp link target — `wa.me/972524822842?text=...` (מספר 052-4822842) | DOM inspection |
| **VC-13** | `books-wave1.css` נמחק — לא נטען בשום עמוד | `find site/wp-content/themes/ea-eyalamit -name "books-wave1.css"` = empty |
| **VC-14** | validate_aos.sh: 0 FAIL | `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` |

**Phase 1 Verdict:** PASS_WITH_FINDINGS (אם VC-1..VC-14 כולם PASS) או FAIL (אם יש VC כושל).

### Phase 2 — End-to-End QA (תלוי באייל — 3 human gates)

לאחר שאייל ימלא:
1. SMTP App Password ב-WP Mail SMTP (WP admin)
2. GA4 Measurement ID ב-`site/wp-content/themes/ea-eyalamit/inc/analytics-config.json` (`ga4.measurement_id`)
3. Clarity Project ID באותו קובץ (`clarity.project_id`)

| VC | תיאור | איך לבדוק |
|----|--------|-----------|
| **VC-15** | CF7 form submission — מייל מגיע ל-`info@eyalamit.co.il` | מילוי + שליחה ידנית של הטופס ב-staging; אישור אייל קבלת מייל |
| **VC-16** | GA4 RealTime event — קליק על CTA רושם event עם `variant_label` | open GA4 → RealTime → user clicks button → event appears within 30s |
| **VC-17** | Clarity session — session test נרשם, heatmap נטען | visit staging → Clarity Dashboard → "New session" appears |
| **VC-18** | A/B distribution — אחרי 10 sessions, 3 variants מתפלגים ~33% כל אחד | GA4 → Custom Report → group by variant_label, count sessions |

**Phase 2 Verdict:** PASS (אם VC-15..VC-18 כולם PASS) או PASS_WITH_FINDINGS / FAIL.

---

## 2. Findings — חוקי דירוג

לכל finding:
- **BLOCKER** — VC כושל ועוצר מעבר ל-Stage C (content).
- **MAJOR** — VC כושל אבל יש workaround.
- **MINOR** — observation בלי כשל.

| Finding type | טיפול |
|--------------|--------|
| Phase 1 BLOCKER | חזרה ל-team_10 לתיקון; אין go ל-Phase 2. |
| Phase 1 MAJOR | team_50 רושם, team_100 מחליט: לחסום או להמשיך. |
| Phase 1 MINOR | תיעוד בלבד; non-blocking. |
| Phase 2 BLOCKER | תיקון תצורה (Eyal/team_10/team_20) → re-test. |
| Phase 2 חוסר נתונים (אייל לא מילא) | סטטוס `PENDING_HUMAN_GATE` — לא FAIL. |

---

## 3. תוצרים נדרשים

### תוצר 1: VERDICT Phase 1
`_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md`

מבנה לפי VERDICT_TEMPLATE:
- §0 verdict box (PASS / PASS_WITH_FINDINGS / FAIL)
- §1 hostname + validator_engine declaration (חובה — לא Cursor)
- §2 Phase 1 VC table (14 VCs)
- §3 Findings (BLOCKER/MAJOR/MINOR)
- §4 validate_aos.sh result
- §5 evidence (axe report, Lighthouse JSON, Screenshots)
- §6 Phase 2 trigger condition (3 human gates)

### תוצר 2: VERDICT Phase 2 (אחרי שאייל ממלא)
`_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md`

מבנה דומה, 4 VCs נוספים (VC-15..VC-18).

### תוצר 3: Disposition routing ל-team_00
`_COMMUNICATION/team_00/DISPOSITION_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_2026-05-27.md`

---

## 4. אורקסטרציה

### תהליך
1. **Phase 1 עכשיו** — Cursor-fresh-engine: לא Cursor. הכנת Claude Code session OR Codex.
2. team_50 קורא: implementation report + mandate + browser-evidence.
3. רץ axe + Lighthouse על `https://eyalamit-co-il-2026.s887.upress.link/wave2-test/` (או URL test page שיוצרים).
4. כותב VERDICT v1.0.0.
5. **המתנה** ל-3 human gates של אייל.
6. **Phase 2 לאחר**: re-launch + run VC-15..VC-18.
7. VERDICT v2.0.0 + Disposition.

### חלוקת זמן
- Phase 1: ~3-4 שעות.
- Phase 2: ~1-2 שעות (אחרי שאייל ממלא).

---

## 5. מקורות אמת

| מקור | תפקיד |
|------|--------|
| `_COMMUNICATION/team_10/STAGE-B-COMPLETION-REPORT-2026-05-27.md` | implementation declaration + AC checklist |
| `_COMMUNICATION/team_10/MANDATE-TEAM10-STAGE-B-IMPLEMENTATION-2026-05-27.md` | 14 ה-AC המקוריים + scope |
| `_COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md` (v1.1) | SSOT עיצובי — לאמת token values |
| `_COMMUNICATION/team_80/D-14-PATCH-NOTE-2026-05-27.md` | רשימת P1-P8 כדי לאמת שיושמו |
| `_COMMUNICATION/team_50/POC-BROWSER-EVIDENCE-2026-05-27.md` | baseline Stage A scores לכייל ציפיות |
| `hub/data/social-channels.json` | URLs רשת לאמת בפוטר |
| `hub/data/analytics-config.json` | GA4 + Clarity scaffolds (Phase 2) |

---

## 6. דרישת Cross-Engine — חמורה

**team_50 לא רשאי להשתמש ב:**
- ❌ Cursor (אותו engine שטעם 10 השתמש בו)

**team_50 חייב להשתמש באחד מ:**
- ✅ Claude Code (Sonnet/Opus)
- ✅ Codex (GPT-5)
- ✅ Gemini
- ✅ Claude in Chrome / Browser-isolated alternative

**אישור engine** חובה ב-§1 של VERDICT: שורת `validator_engine:` עם ערך מפורש.

---

## 7. Activation Prompt — לסשן team_50 חדש

```
HANDOFF_DEPTH: lean
ACTIVATION_SCOPE: team_50 only — Stage B Implementation QA

# Agent Onboarding — team_50 (QA & Functional Acceptance)

## Identity
- Team: team_50
- Engine: NOT cursor (cross-engine rule). Claude Code preferred.
- Role: L-GATE_BUILD QA on Stage B implementation

## Mandate
Read in full: _COMMUNICATION/team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md

## What team_10 delivered (commit e165218)
- 3 CSS files (tokens, animations, atoms) under site/wp-content/themes/ea-eyalamit/assets/css/
- 4 JS files (ab-testing, entrance, scroll, hero)
- 12 block partials in template-parts/blocks/
- 12 page templates in page-templates/
- inc/wave2-stage-b.php (enqueues + wp_head GA4/Clarity)
- inc/cf7-wave2-form.txt (CF7 form for nimrod to paste in WP admin)
- inc/analytics-config.json (PENDING_CREDENTIALS until Eyal fills)
- books-wave1.css DELETED

## Phase 1 (now)
Run 14 VCs (VC-1..VC-14): enqueue, CSS variables, 12 blocks/templates, axe-core,
Lighthouse mobile, prefers-reduced-motion, RTL, A/B variant assignment, footer
social, WhatsApp link, books-wave1 removal, validate_aos.

## Phase 2 (after Eyal completes 3 human gates)
VC-15..VC-18: CF7 mail flow, GA4 RealTime, Clarity session, A/B distribution.

## Output
_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md
(Phase 1) and v2.0.0 (Phase 2 after human gates complete).

## Cross-engine constraint
Iron Rule #1. Builder was cursor-composer (team_10). You MUST use a different
engine. Declare validator_engine in §1 of verdict.

FIRST READ: _COMMUNICATION/team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md
```

---

## 8. שינוי גרסה

| תאריך | פעולה |
|-------|--------|
| 2026-05-27 | מנדט נוצר על-ידי team_100 אחרי קליטת team_10 STAGE-B-COMPLETION-REPORT (commit e165218) |
