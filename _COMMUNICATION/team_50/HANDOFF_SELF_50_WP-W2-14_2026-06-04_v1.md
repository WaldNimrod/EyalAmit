# Session Handoff — team_50 | Independent FULL-SITE deep E2E QA round (team_00 request, while awaiting Eyal content answers). Detailed test plan + scope: _COMMUNICATION/team_100/MANDATE-TEAM50-FULL-E2E-QA-2026-06-04.md. Cover EVERY interface (chrome + mobile drawer + every route) at 360/390/414/768/desktop; gates: visual-precision (mockup-vs-live desktop+390), content-accuracy (live vs Eyal source + confirm/expand F1-F9), axe a11y 0/0, link-coverage E2E, RTL/LTR, regression. Deliver _COMMUNICATION/team_50/QA-REPORT-FULL-E2E-SITE-2026-06-04.md with severity-ranked findings (P0-P3) + coverage matrix + evidence. Staging: http://eyalamit-co-il-2026.s887.upress.link. Engine: Cursor (cross-engine vs Claude Code build, IR#1); independent; no code/merge/deploy.


## 1. SESSION ACCOMPLISHED
- team_100: WP-W2-14 (mobile chrome+drawer, canonical nav/footer, Home fixes, /method elevated, Memorial/Galleries/Media) built+integrated (branch wp-w2-14-phase2)+deployed to staging
- Pre-flight clean: 0-overflow 35/35, axe 0 crit/0 serious all routes
- Content audit F1-F9 + client-hub group H published to Eyal (materials-intake.html)

## 2. IDENTITY SNAPSHOT
## Team Identity
- **Team ID:** team_50
- *(team details unavailable)*


## 3. CONTEXT SNAPSHOT
## Work Package — WP-W2-14
*(work package details unavailable — verify wp_id is correct)*


## 4. MANDATORY READS
- `_aos/governance/team_50.md`
- `_aos/roadmap.yaml`
- `methodology/AOS_IDENTITY_ONBOARDING_v1.0.0.md` (first AOS session only)


## 5. BLOCKERS / OPEN ITEMS
- Awaiting Eyal answers to F1-F9 (memorial content source/intent, biographical lead, dates, galleries/media real content) - group H on client hub
- Per-WP L-GATE_VALIDATE not yet routed - this full deep QA pass precedes it

## 6. ACTIVATION PROMPT
```
HANDOFF_DEPTH: full
ACTIVATION_SCOPE: team_50 only

# Agent Onboarding — team_50

*Generated 2026-06-04T00:48:17.333583Z  ·  Depth: full*

## Activation TL;DR
- **Identity:** team_50 · engine: — · role: —
- **Domain:** — · profile: —
- **Assignment:** WP=WP-W2-14 —  · gate=—
- **Task:** —
- **Writes to (first 3):** `_COMMUNICATION/team_50/`
- **First reads:** `CLAUDE.md` · `_aos/governance/team_50.md` · `_aos/roadmap.yaml`
- **State:** team=team_50 project=— wp=WP-W2-14 gate=— depth=full

## AOS Environment
- **Hub:** agents-os (AOS platform — methodology engine + Lean Kit)
- **Platform:** AOS v3.1.2 dashboard / Lean Kit 3.1.10+
- **Universal Iron Rules:** CLAUDE.md §Iron Rules (1–9) — cross-engine, lean-kit snapshots, project roadmap authority, inter-team artifacts, activation prompts, gate authority split, routing display (ADR032), data authority (ADR034), port canon
- **Data authority:** ADR034 — DB-as-SSoT when online (API-only mutations for canonical fields); files retain gate_history + prose
- **Directory canon:** methodology/AOS_DIRECTORY_CANON_v1.0.0.md

## Team Identity
- **Team ID:** team_50
- *(team details unavailable)*

## Governance Contract
*No governance file found for team_50.*


═══ PERMISSIONS CONTEXT ═══
## GATE AUTHORITY
  - L-GATE_BUILD: **awareness_only**
  - L-GATE_ELIGIBILITY: **awareness_only**
  - L-GATE_SPEC: **awareness_only**
  - L-GATE_VALIDATE: **awareness_only**

## WRITABLE PATHS
  - `_COMMUNICATION/team_50/`

## IRON RULES
  1. Team 50 = QA (Iron Rule)
  2. Every QA run must be a FRESH test — never repeat prior findings without re-execution
  3. GATE_4 QA evidence required: commands + outputs + exit codes
  4. All pytest runs: AOS_V3_E2E_RUN=1 AOS_V3_E2E_HEADLESS=1 — expected: 141 passed, 0 skipped, 0 failed

## MANDATORY READS
  → `_aos/governance/team_50.md`
═══════════════════════════


## Work Package — WP-W2-14
*(work package details unavailable — verify wp_id is correct)*

## Session Task
*No task was set when this session was generated.*

**First action:** Before doing any substantive work, ask the user:
> *"What task should I focus on in this session?"*

Present these intuitive options (team-appropriate) so the user can pick quickly or describe a custom task:

- **[A] Run AC validation** — execute each AC from LOD400 with full evidence (commands + outputs + exit codes)
- **[B] Submit L-GATE_B QA verdict** — PASS or FAIL with evidence; write to _COMMUNICATION/team_50/
- **[C] Report testability failure** — AC not testable; route back to Team 110 with specific issue
- **[D] Rerun QA after fix** — generate delta verdict (new file, new version number)

**Completion criteria:** Once the user confirms a task, restate it back in one sentence and proceed. Report the deliverable path + a one-line summary to Team 00 via `_COMMUNICATION/team_50/` when done.

## Instructions
You are being onboarded as an AOS agent. Read the sections below carefully.

1. **Confirm your identity** — verify your team ID, engine, and role match the Team Identity section.
2. **Read the Governance Contract** — these are your Iron Rules and authority boundaries.
3. **Understand the project** — review the Project Context and Active Modules.
4. **Locate your working directories:**
   - Deliverables: `_COMMUNICATION/team_50/`
   - Onboarding: `_COMMUNICATION/team_50/__ONBOARDING_TEAM_*.md`
   - Governance: `_aos/governance/team_50.md`
5. **Confirm readiness** — respond with a brief summary of your role and current assignment.


FIRST ACTION:
Check _aos/roadmap.yaml for active WPs and _COMMUNICATION/team_50/ for pending mandates. Confirm with Team 00 before starting new work.
```


## 7. CANONICAL OPTIONS
- **[A] Run AC validation** — execute each AC from LOD400 with full evidence (commands + outputs + exit codes)
- **[B] Submit L-GATE_B QA verdict** — PASS or FAIL with evidence; write to _COMMUNICATION/team_50/
- **[C] Report testability failure** — AC not testable; route back to Team 110 with specific issue
- **[D] Rerun QA after fix** — generate delta verdict (new file, new version number)