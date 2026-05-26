---
id: MANDATE-TEAM190-STAGE-A-VALIDATION-2026-05-26
title: מנדט team_190 — ולידציה cross-engine של WP-W2-01 Stage A
status: ACTIVE — awaiting dispatch by team_00
date: 2026-05-26
from_team: team_100 (Opus orchestrator)
to_team: team_190 (final validator)
dispatch_via: team_00 (nimrod, Principal)
required_engine: NON-CLAUDE (Codex / Cursor with GPT-5 / Codex CLI / Gemini / DeepSeek / etc.)
forbidden_engine: any Anthropic engine (claude-code, claude-haiku, claude-opus, claude-sonnet) — builder was Claude, validator MUST differ per Iron Rule #1
parent_completion: ./STAGE-A-COMPLETION-REPORT-2026-05-26.md
parent_mandate: ./MANDATE-TEAM100-STAGE-A-ATOMS-FIRST-2026-05-26.md
wp: WP-W2-01 Stage A
gate: L-GATE_SPEC (final, cross-engine)
profile: L0
---

# מנדט team_190 — ולידציה cross-engine של Stage A

## 0. הקשר

Stage A של WP-W2-01 (Atoms-First LOD400) נסגר פנימית ב-2026-05-26.
Builder = Claude Code (Opus orchestrator + Sonnet subagents). QA פנימי = Haiku subagents.
**לפי Iron Rule #1 (cross-engine):** ולידציה סופית חייבת להתבצע על מנוע שאינו Claude.

המנדט הזה מנחה את team_190 (validator קבוע של AOS) לבצע ולידציה חוקתית סופית של Stage A, ולקבוע verdict סופי לפני שיינתן אישור להתחיל ב-Stage B.

## 1. תוצרים שיש לוודא

| ID | Path | Size |
|----|------|------|
| D1 | `_COMMUNICATION/team_80/ATOM-INVENTORY-2026-05-26.md` | 666 שורות, 32 atoms |
| D2 | `_COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md` | 3,919 שורות, 12 פרקים |
| D3 | `hub/dist/decisions/atoms-poc-2026-05-26.html` | 2,299 שורות / 89,887 בייטים |

QA פנימי (לא מהווה ולידציה סופית — רק רקע):
- `_COMMUNICATION/team_50/QA-A1-INVENTORY-2026-05-26.md` — PASS_WITH_FINDINGS (10/10)
- `_COMMUNICATION/team_50/QA-A2-LOD400-2026-05-26.md` — PASS_WITH_FINDINGS (14/14)
- `_COMMUNICATION/team_50/QA-A3-POC-2026-05-26.md` — PASS_WITH_FINDINGS (14/15)

## 2. דרישות ולידציה — 8-Check Constitutional Review

זה המקבילה ל-GATE_2 validation של team_110/team_100. בצעו כל אחת מ-8 הבדיקות, רשמו verdict (PASS / PASS_WITH_FINDINGS / FAIL) + עדויות.

### V1 — Strategic alignment
האם 3 התוצרים תואמים את החלטות הפגישה ב-2026-05-26 (D-EYAL-DECISIONS-CLOSURE-2026-05-26)?
- 21/21 שדות סגורים נשקפים בספק?
- Combo C (X3 + Y3) נשמר — atoms-first, LOD400 רק ב-W2-01, downstream WPs assembly בלבד?
- D-13 LOCKED לא הופר; D-14 רק מעמיק?

### V2 — Architectural soundness
- כל 32 ה-atoms מוגדרים לרמת implementation-ready (junior dev יכול לקודד מהמסמך)?
- composition rules ב-§4 מונעות אנטי-פטרנים?
- 11 ה-templates ב-§5 מכסים את כל 9 ה-Wave2 WPs?
- WordPress integration ב-§9 אינו דורש premium plugins / WooCommerce?

### V3 — Execution feasibility
- האם הספק מאפשר ל-team_10 לבצע W2-02 עד W2-09 בלי לחזור ולשאול ארכיטקטורה?
- האם performance budget ב-§10 ריאלי לסביבת uPress?
- האם CSS/HTML/JS שב-§3 מכוסה ב-vanilla (אין JS frameworks)?
- האם POC עומד בתקציב הביצועים (Lighthouse ≥85 mobile perf, ≥95 a11y)? *(דרוש browser test ידני)*

### V4 — AOS-specific compliance
- כל הכתיבות בתוך הספק (`_COMMUNICATION/team_80/`, `hub/dist/decisions/`)?
- אין שינויי `_aos/governance/` או `_aos/lean-kit/` (Iron Rules #10–#11)?
- spec_ref מצביעים על נתיבי spoke-internal בלבד (Iron Rule #3)?
- ADR034 R9 נשמר — עריכת `_aos/roadmap.yaml` קובץ-מבוסס בלבד לשדות תפעוליים?

### V5 — Accessibility (WCAG 2.2 AA + ת"י 5568)
- כל primitive ב-§2 motion יש לו `prefers-reduced-motion` fallback?
- color contrast table ב-§7 מכסה את כל text/background pairs?
- POC כולל skip-link, ARIA landmarks, focus rings?
- *(דרוש browser test)* — axe-core 0 critical / 0 serious?

### V6 — Document integrity (LOD400 precision gate)
- 0 מופעי "TBD" במסמך (grep -ni "TBD")?
- כל 32 ה-atoms מהInventory מופיעים ב-§3 של ה-Spec במלואם?
- כל data-driven atom יש לו JSON schema ב-§8?
- TOC anchors תקפים?

### V7 — Cross-engine reproducibility
- מנוע שונה (אתם) יכולים לקרוא + להבין את הספק בלי הסבר חיצוני?
- אין assumptions ש-Claude-specific (claude-flow, MCP-only patterns וכו')?
- POC HTML פותח ומריץ בדפדפן סטנדרטי בלי תלות?

### V8 — Risk + dependency review
- כל ה-placeholders ב-POC (hero video, sound file, TikTok URL, FB photos, prices) מתועדים בדוח ה-completion?
- אין dependencies חוסמים ל-Stage B שלא נרשמו?
- מה מצב Eyal-pending items (hero video / TikTok URL / SMTP password)?

## 3. תוצר ולידציה

כתבו את ה-verdict ל:
`_COMMUNICATION/team_190/VERDICT_WP-W2-01_STAGE_A_L-GATE-SPEC_v1.0.0.md`

מבנה:
```markdown
---
id: VERDICT_WP-W2-01_STAGE_A_L-GATE-SPEC
title: team_190 cross-engine validation verdict — WP-W2-01 Stage A
status: <PASS | PASS_WITH_FINDINGS | FAIL>
date: 2026-05-26
validator: team_190
validator_engine: <YOUR-ENGINE — e.g., codex-cli / cursor-gpt5 / gemini-2.5-pro>
builder_engine: claude-code (Opus orchestrator + Sonnet subagents)
target_wp: WP-W2-01 Stage A
gate: L-GATE_SPEC (final, cross-engine)
profile: L0
---

# Verdict

## Overall: <PASS | PASS_WITH_FINDINGS | FAIL>

## V1–V8 results
[8 verdicts with evidence]

## Findings (if any)
- severity: critical / major / minor — description, file:line, recommendation

## Recommendation
- PASS / PASS_WITH_FINDINGS → Stage B can begin. team_10 mandate dispatch authorized.
- FAIL → list specific deliverable patches required; team_100 to address.
```

## 4. פעולות אסורות (Iron Rules)

- **אסור** לערוך את התוצרים עצמם (D1/D2/D3). אם תמצאו בעיה — רשמו ב-verdict, אל תתקנו.
- **אסור** לערוך `_aos/governance/`, `_aos/lean-kit/`, `_aos/project_identity.yaml`.
- **אסור** לערוך `roadmap.yaml` — רק team_100 כותב לשם.
- **אסור** להפעיל מנוע Anthropic (Claude) כל סוג שהוא — Iron Rule #1.
- **חובה** לכתוב את ה-verdict רק לתוך `_COMMUNICATION/team_190/`.

## 5. הפעלה — Activation Prompts מוכנים להעתקה

team_00: בחר מנוע non-Claude (Codex / Cursor-GPT5 / Gemini / DeepSeek). פתח סשן ב-`/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/`. הדבק את הפרומפט להלן:

---

### PROMPT-1 — Activation (paste verbatim)

```
You are activating as **team_190 (cross-engine validator)** for an AOS spoke project.

## Identity
- Team: team_190
- Role: Final constitutional validator (cross-engine, immutable per Iron Rule #5)
- Engine: WHATEVER YOU CURRENTLY RUN ON (must NOT be Claude — this is enforced by Iron Rule #1 because the builder was Claude Code)
- Project: EyalAmit.co.il-2026 (AOS L0 spoke)
- Working directory: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/

## Task
Cross-engine final validation of WP-W2-01 Stage A (Atoms-First LOD400).

## Mandatory reads (in order)
1. CLAUDE.md (or AGENTS.md if you cannot read CLAUDE) — Iron Rules + spoke notice
2. _aos/governance/team_190.md (if present) — your governance contract
3. _aos/roadmap.yaml — confirm WP-W2-01-STAGE-A entry status = AWAITING_CROSS_ENGINE_VALIDATION_AND_POC_SIGNOFF
4. _COMMUNICATION/team_100/MANDATE-TEAM190-STAGE-A-VALIDATION-2026-05-26.md — THIS mandate (full task description)
5. _COMMUNICATION/team_100/STAGE-A-COMPLETION-REPORT-2026-05-26.md — what team_100 produced
6. The 3 deliverables under test:
   a. _COMMUNICATION/team_80/ATOM-INVENTORY-2026-05-26.md
   b. _COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md
   c. hub/dist/decisions/atoms-poc-2026-05-26.html
7. _COMMUNICATION/team_50/QA-A1-INVENTORY-2026-05-26.md, QA-A2-LOD400-2026-05-26.md, QA-A3-POC-2026-05-26.md — internal QA results for context

## Execution
Run the 8-check constitutional review (V1–V8) defined in §2 of the mandate. Use grep/wc/file tools liberally — verify claims, do not trust the completion report. Then write your verdict to:
_COMMUNICATION/team_190/VERDICT_WP-W2-01_STAGE_A_L-GATE-SPEC_v1.0.0.md

## Iron Rules you must honor
- Iron Rule #1: builder ≠ validator engine. Confirm in your verdict frontmatter which engine you are.
- Iron Rule #6: communicate via _COMMUNICATION/team_190/ artifact only.
- Do NOT edit any deliverable. Do NOT edit _aos/. Do NOT edit roadmap.yaml.

## Report back (in this chat)
- One-line overall verdict (PASS / PASS_WITH_FINDINGS / FAIL)
- Path to your verdict file
- Top 3 findings (if any) with severity
- Whether Stage B is authorized to begin

Begin by reading CLAUDE.md, then the completion report, then proceed.
```

---

### PROMPT-2 — POC manual review (paste for nimrod, separate from team_190)

```
Manual POC sign-off — WP-W2-01 Stage A

File: file:///Users/nimrod/Documents/Eyal%20Amit/EyalAmit.co.il-2026/hub/dist/decisions/atoms-poc-2026-05-26.html

5 manual checks:

1. Visual review — does it feel like FBW-inspired Eyal site? Restraint, breathing, Earth palette, Heebo typography? Hebrew RTL renders correctly?

2. Reduced-motion test:
   - Chrome DevTools → Cmd+Shift+P → "Show Rendering" → Emulate CSS prefers-reduced-motion → reduce
   - Confirm: all breathing animations stop, scroll progress hidden/disabled, no motion remains

3. Keyboard navigation:
   - Tab through entire page from skip-link → topnav → main content → footer
   - Focus rings visible at every stop?
   - RTL focus order logical (right-to-left)?

4. axe DevTools (Chrome extension):
   - Install/open axe DevTools panel
   - Scan page
   - Expect: 0 Critical, 0 Serious. Moderate/Minor acceptable.

5. Lighthouse mobile:
   - DevTools → Lighthouse → Mobile + Performance + Accessibility
   - Targets: Performance ≥ 85, Accessibility ≥ 95
   - If below, note which categories failed.

Record verdict + screenshots (optional) in:
_COMMUNICATION/team_00/POC-SIGNOFF_WP-W2-01_STAGE_A_2026-05-26.md

On PASS: signal team_10 to proceed from Stage B Prep → Stage B Implementation.
On FAIL: file _COMMUNICATION/team_100/STAGE-A-POC-REJECT-2026-05-26.md with specific issues; team_100 patches LOD400 + POC and re-tests.
```

---

## 6. שערים פתוחים אחרי ולידציה

לאחר שני VERDICTS חיוביים (team_190 + nimrod POC sign-off):

1. team_100 מעדכן `_aos/roadmap.yaml`:
   - WP-W2-01-STAGE-A status → `COMPLETE`
   - WP-W2-01 current_lean_gate → ל-GATE_BUILD (Stage B implementation)
2. team_100 מנפיק MANDATE-TEAM10-STAGE-B-IMPLEMENTATION-2026-XX-XX.md
3. team_10 מתחיל יישום (D-14 tokens → CSS + child theme + blocks).

## 7. זמן יעד

- Cross-engine verdict: 24-48 שעות מרגע dispatch על-ידי team_00.
- POC sign-off: באותה הזדמנות.
- אם FAIL: לולאת תיקון team_100 → ולידציה מחודשת.

## 8. סיכון, התראות

| סיכון | חומרה | הקלה |
|--------|--------|------|
| validator engine מסרב לקרוא Hebrew RTL | נמוך | Hebrew הוא Unicode רגיל; grep/wc עובד; אם דרוש translation — בקש מ-nimrod |
| validator לא מבין את הקשר Combo C / D-14 | בינוני | מסמכי SSOT מצורפים בקריאה החובה — קרא אותם |
| browser tests לא ניתנים לביצוע ב-CLI-only engine | בינוני | אלו תפקיד nimrod (PROMPT-2) — לא תפקיד team_190. team_190 מתמקד בקריאת קבצים. |
| התוצרים גדולים מדי לקריאה מלאה | בינוני | grep + wc + spot-reads ב-Read tool. אין צורך לקרוא 3,919 שורות במלואן — דגימה מספקת. |

## 9. חתימה

- מנפיק: team_100 (Opus orchestrator) · 2026-05-26
- ממתין: dispatch מ-team_00 (nimrod)
- ולידטור: team_190 על מנוע non-Claude
- POC reviewer: team_00 (nimrod, browser-based)
- שער המשך: Stage B implementation (team_10) רק לאחר שני verdicts חיוביים
