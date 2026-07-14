---
kind: SELF_HANDOFF
team: team_100
date: 2026-07-14
project_id: eyalamit
wp: WP-CANON-TEMPLATE-UNIFICATION
canonical_handoff: generated via /AOS_mail handoff (mode=handoff&type=onboard_agent), team_id=team_100, project_id=eyalamit, governance_depth=full, wp_id=WP-CANON-TEMPLATE-UNIFICATION, at 2026-07-13T22:57:04.942431Z
depends_on: WP-CANON-TEMPLATE-UNIFICATION-LOD200-2026-07-12.md (this repo, updated 2026-07-14 with the T3b book-page finding)
---

# HANDOFF — team_100 continuity: WP-CANON LOD200 → LOD300 (mockups, gated on team_00 approval) → LOD400 (full spec + external validation)

This is a **self-handoff** (`/AOS_handoff 100 full`) — team_00 (נמרוד) explicitly requested this artifact so the next session (same team, fresh context) picks up WP-CANON-TEMPLATE-UNIFICATION at exactly the right depth, with the exact two-stage gate team_00 specified.

## What this session did (context for the next session)

Reconciled two Eyal-provided (ChatGPT-assisted) spec docs against the live theme, discovered the site runs two parallel template systems (Wave2 legacy vs Chapters live), implemented and cross-engine-validated a 12-item quick-fix batch (PASS_WITH_FINDINGS via team_90/cursor-composer-2 — see `_COMMUNICATION/team_90/VERDICT_CONTENT-QA-2026-07-12_L-GATE_BUILD.md`), deployed it to staging, and scoped the architectural root cause as **WP-CANON-TEMPLATE-UNIFICATION** (LOD200, registered `_aos/roadmap.yaml`, `status: IN_PROGRESS`, L-GATE_E PASS). Along the way: found and reported a fleet-wide gap in cross-engine validation tooling propagation (hub PR #37, now landed), found and reported a bug in the validation wrapper script itself (mandate files with YAML frontmatter crashed `cursor-agent`'s arg parser — worked around, reported). On 2026-07-14, team_00 asked to re-check the books cluster specifically and a **third** instance of the same dead-Wave2-code pattern was confirmed: a fully-built, QA-passed, `LOD500_LOCKED` commerce book-detail page (`WP-W2-10-E`) is currently shadowed by the live Chapters book pages — added to the LOD200 doc as task **T3b**.

Full narrative: `_COMMUNICATION/team_100/DETAILED-DIFF-EYA-QA-SEO-VS-CURRENT-SITE-2026-07-12.md`, `_COMMUNICATION/team_100/WP-CANON-TEMPLATE-UNIFICATION-LOD200-2026-07-12.md` (now includes T3b).

## Standing mission (team_00's exact words, preserved)

> LOD-פריטה (breakdown) של WP-CANON מ-LOD200 לרמת **LOD300, כולל מוקאפים היכן שנדרש**, **לאישור שלי** [team_00] — ורק **לאחר אישור**, פריטה לרמת **LOD400 מלאה ומפורטת, כולל ולידציה חיצונית בהתאם לנוהל**.

Concretely, two sequential phases, with a hard stop between them:

### Phase 1 — LOD300 (this session's job)
- Break each of the 7 (now 8, with T3b) LOD200 tasks down to LOD300 depth: concrete before/after descriptions per page/component, the actual visual/structural decisions (not yet full implementation detail).
- **Build mockups wherever a visual/structural decision needs team_00's eyes before LOD400 detail is worth investing in** — the two flagged open decisions are the obvious candidates:
  - T2 (FAQ): single-category vs many-to-many — if there's a UI/UX dimension worth seeing before deciding, mock it.
  - T3b (books): reconcile WP-W2-10-E's commerce polish (real cover + price-on-CTA hero, split print/e-book CTA) against the live Chapters book page — a side-by-side mockup of "what Chapters gains" is probably the single highest-value mockup in this whole WP.
  - Any other T-item where the port target isn't a mechanical 1:1 (e.g., T1 Mokesh video/gallery placement within the Chapters page layout).
- **Do not proceed past LOD300 without team_00's explicit approval.** This is a hard gate, not a formality — stop, present the LOD300 breakdown + mockups, and wait.

### Phase 2 — LOD400 (only after Phase 1 approval)
- Full, detailed, file-by-file, function-by-function build spec — the "any junior developer or fresh agent could implement without gaps, guesses, or assumptions" bar (team_100's own validation-authority standard, see the Governance Contract embedded below).
- **Include external (cross-engine) validation of the LOD400 spec itself, per the now-documented procedure**: `_aos/methodology/AOS_CROSS_ENGINE_AUTONOMOUS_VALIDATION_v1.0.0.md`. Practically, this means:
  - Genuine cross-engine review (team_90, `cursor-composer-2`) of the LOD400 spec before it's treated as ready-to-build, not just of the eventual code.
  - Use the working invocation pattern discovered this session: `AOS_HUB_ROOT=/Users/nimrod/Documents/AOS_V5/agents-os bash /Users/nimrod/Documents/AOS_V5/agents-os/scripts/run_cross_engine_validation.sh team_90 <workspace_abs_path> <mandate_abs_path>` — **but do not pass mandate file content as a raw CLI argument** (the wrapper crashes on a mandate's leading YAML `---`, reported as a bug); pass a short prompt telling the agent to read the mandate by absolute path instead, with `--` before the prompt.
  - Authorization note: running `cursor-agent -p --force --trust` requires the **operator to type the literal tool name and flags** in their own message before Claude Code's safety layer allows it — generic "go ahead" is rejected even when unambiguous in context. Ask team_00 for that specific phrasing up front rather than discovering this mid-session. Full mechanics: memory `feedback_cross-engine-validation-mechanics.md`.
  - Check whether hub PR #37 (fleet propagation of the wrapper scripts) has landed via `aos_sync_all.sh --all` by the time this session runs — if so, `scripts/run_cross_engine_validation.sh` may already exist natively in this spoke; use it directly instead of the hub-path workaround.

## Critical context the next session must not re-litigate

- **T3b is new** (added 2026-07-14) — the WP-W2-10-E book-detail page (`page-templates/tpl-book-detail.php` + `inc/wave2-w2-05.php:1026-1184`) is a real, signed-off, `LOD500_LOCKED` commerce page, currently shadowed by Chapters routing (priority 103 beats Wave2's 100). Do not re-verify "does it exist" — it does, confirmed 2026-07-14 investigation, cited in the LOD200 doc.
- **Book schema (schema.org) still does not exist anywhere**, live or dead — confirmed three independent ways on 2026-07-14 (code grep, live JSON-LD parse, prior team re-check). This is a separate question from "does a book page exist" (it does) — do not conflate the two when re-verifying.
- **Two items were deliberately declined in the 2026-07-12 batch, not overlooked**: H1/H2 wording tweaks from Eyal's SEO doc (live copy judged equal-or-better), and literal `<br>`-per-source-line in vekatavta's "10 things" (source is arbitrary text-editor wrap, not intentional). Don't reopen either without new reasoning.
- **The Wave2/Chapters duplication pattern has now recurred 4 times independently** (FAQ, Product template, Mokesh media, book-detail page) — treat this as the working hypothesis for any other "gap" found during LOD300 breakdown: check dead Wave2 code before assuming something needs building from scratch.

## Open items / blockers

- No blockers to starting Phase 1 (LOD300) immediately.
- Eyal has not yet responded to the outstanding PDF questions (`_COMMUNICATION/team_100/MSG-TO-EYAL-ANCHOR-PAGE-QUESTIONS-2026-07-12.md`) — unrelated to WP-CANON, does not block this WP.
- The 2026-07-12 batch's own follow-up items (Q3 committed to `--force --trust` operator-authorization friction, item 10(c) meta-description evidence gap) are closed/accepted, not open.
- team_00 has not yet decided whether/when to commit+push the current working-tree state (2026-07-14 session) — a separate open thread from this WP, flagged here only so the next session knows the repo may have uncommitted work when it starts.

---

# Appendix A — Canonical AOS Handoff Activation (verbatim)

*Generated via `/AOS_mail handoff` → `GET /api/prompts/generate?type=onboard_agent&mode=handoff&team_id=team_100&project_id=eyalamit&governance_depth=full&wp_id=WP-CANON-TEMPLATE-UNIFICATION` at `2026-07-13T22:57:04.942431Z`. Embedded verbatim per the canonical handoff mechanism (ADR043 §A.4c). Note: the API's own WP-detail lookup returned "unavailable" for WP-CANON-TEMPLATE-UNIFICATION (it's registered file-only per the ADR034 R8/offline-fallback precedent set by WP-W2-17 — the hub API's work-package PUT endpoint has a known field-mapping bug, not re-attempted here) — the LOD200 doc + this handoff's own sections above are the authoritative WP context, not the generated block's placeholder.*

## 1. SESSION ACCOMPLISHED
*(No accomplishments recorded — session handoff for context only.)* — superseded by "What this session did" above.

## 2. IDENTITY SNAPSHOT
- **Team ID:** team_100 · **Engine:** claude-sonnet-4-6 (this session ran on Sonnet 5; roster label lags, non-blocking) · **Group:** architecture · **Profession:** domain_architect · **Domain scope:** universal
- **Role:** Program-level architecture and synthesis under Principal (Team 00). GATE_2 owner for AOS domain. Coordinates domain IDE architects team_110 and execution teams (team_60, team_50). Multi-project scope.

## 3. CONTEXT SNAPSHOT
- **Work Package:** WP-CANON-TEMPLATE-UNIFICATION — see LOD200 doc (this repo, `_COMMUNICATION/team_100/`) for full context; API lookup unavailable (file-only registration, see note above).

## 4. MANDATORY READS
- `_aos/governance/team_100.md`
- `_aos/roadmap.yaml`
- `_COMMUNICATION/team_100/WP-CANON-TEMPLATE-UNIFICATION-LOD200-2026-07-12.md` (the actual scope — read before anything else)
- `methodology/AOS_IDENTITY_ONBOARDING_v1.0.0.md` (first AOS session only)

## 5. SESSION BOOTSTRAP
```bash
export AOS_SESSION_TEAM_ID=team_100 AOS_PROJECT_ID=eyalamit
export AOS_API_BASE="${AOS_API_BASE:-http://100.125.98.56:8092}"
bash scripts/aos_session_ctl.sh start WP-CANON-TEMPLATE-UNIFICATION
/AOS_mail check
```

## 6. GOVERNANCE CONTRACT (Team 100 — Chief System Architect / Claude Code)

**Authority scope:** Delegated GATE_2 approval authority for AOS domain; GATE_4 Phase 4.2 co-owner; coordinates team_110/team_60/team_50.

**Validation authority (GATE_2 fallback):** Same 8-check validation as domain architects. **LOD400 precision gate: verify that every spec is detailed enough for any junior developer or fresh agent to implement without gaps, guesses, or assumptions.** — this is the literal bar Phase 2 (LOD400) above must clear.

**Iron rules (operating):**
- team_00 (Nimrod) is the single human Principal — team_100 NEVER overrides team_00. The LOD300→LOD400 gate in this handoff is exactly this rule in practice.
- Independence maintained — adversarial stance when acting as validator.
- Cross-engine validation — builder engine ≠ validator engine (Constitutional Iron Rule #1) — this is why Phase 2 requires the external validation step, not a self-check.
- Writes to `_COMMUNICATION/team_100/` within the active session's repository only.

**Permissions:**
```yaml
writes_to: [_COMMUNICATION/team_100/, _COMMUNICATION/team_100/*/]
gate_authority: {L-GATE_SPEC: delegated, L-GATE_BUILD: delegated, L-GATE_VALIDATE: awareness_only, L-GATE_ELIGIBILITY: awareness_only}
```

## 7. FIRST ACTION FOR THE NEXT SESSION

Do **not** ask team_00 "what should I focus on" (the generic fallback in the raw generated prompt) — the task is already fully specified above. Start directly on Phase 1 (LOD300 breakdown of the 8 T-items in the LOD200 doc, with mockups for T2/T3b at minimum), and stop for team_00's explicit approval before starting Phase 2. Report the LOD300 deliverable path + a one-line summary to team_00 when Phase 1 is ready for review.

## 8. CONTEXT CHECKPOINT (aos_handoff)
```aos-context-checkpoint
{
  "team_id": "team_100",
  "wp_id": "WP-CANON-TEMPLATE-UNIFICATION",
  "domain": "eyalamit",
  "profile": {"depth": "FULL", "target": "RICH", "lifecycle": "CONTINUATION", "mission_source": "TEAM_00_DIRECTIVE_2026-07-14"},
  "source_versions": {"base": "7b9153f29ac936bd", "team": "137ad87841de73c6", "domain": "3845125952f96d5f", "wp": "ae165a9134fb4870"}
}
```
