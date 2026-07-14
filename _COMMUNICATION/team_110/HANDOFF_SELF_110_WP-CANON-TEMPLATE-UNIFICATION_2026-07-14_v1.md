---
kind: HANDOFF
team: team_110
date: 2026-07-14
project_id: eyalamit
wp: WP-CANON-TEMPLATE-UNIFICATION
canonical_handoff: generated via /AOS_mail handoff (mode=handoff&type=onboard_agent), team_id=team_110, project_id=eyalamit, governance_depth=full, wp_id=WP-CANON-TEMPLATE-UNIFICATION, at 2026-07-14T01:49:57.464890Z
depends_on: WP-CANON-TEMPLATE-UNIFICATION-LOD400-2026-07-14.md (this repo — the actual build spec, read before anything else)
execution_authority: full — ADR045, granted by this handoff per team_00's explicit instruction (see below), not a self-declaration by team_110
---

# HANDOFF — team_100 → team_110: WP-CANON-TEMPLATE-UNIFICATION, execute (build + QA + validate)

team_00 (נמרוד) issued this handoff directly via `/AOS_handoff 110 full - מימוש התוכנית כולל qa וולידציה. שימו לב חובה להשאיר עץ נקי - פוש מלא להכול` — i.e., explicit instruction to **execute** the plan, **including QA and validation**, not just review it. This is a grant of `execution_authority: full` per ADR045 (see §6 of the appendix below) — you are the primary WP executor for this WP's full remaining lifecycle, not limited to GATE_2 review-and-advance.

## What happened before this handoff (context, not yours to redo)

team_100 (this session) took WP-CANON-TEMPLATE-UNIFICATION from LOD200 (already existing) through LOD300 → LOD400, both cross-engine validated, today (2026-07-14):

1. **LOD300** (`_COMMUNICATION/team_100/WP-CANON-TEMPLATE-UNIFICATION-LOD300-2026-07-14.md`) — behavior-level breakdown of all 8 tasks (T1, T2, T3, T3b, T4, T5, T6, T7) + 3 mockups, presented to team_00. All 3 open questions were decided by team_00 in-chat the same day and are recorded in that doc's §4:
   - **T2 (FAQ):** many-to-many categories (not single-category).
   - **T1 (Mokesh trailer):** the extend-general-video-component-vs-bespoke-solution choice is left to engineering judgment — no team_00 preference. (LOD400 already made this call — bespoke, native to Chapters — with full reasoning in its T1 §3.)
   - **T5 (`/qr`):** team_00 gave a hard, non-negotiable product constraint, not a design preference — the 48 `/qr/qrN/` URLs are physically printed as QR codes inside real books already in circulation; every one of them must keep resolving forever, directly or via permanent redirect, because new QR codes cannot be issued. LOD400 §5 (T5) designs to this constraint explicitly and explains why it's structurally satisfiable, not just "tested and worked."
2. **LOD400** (`_COMMUNICATION/team_100/WP-CANON-TEMPLATE-UNIFICATION-LOD400-2026-07-14.md`, ~2,900 lines) — **this is your actual build spec — read it in full before doing anything else.** File/function/line-level detail for all 8 tasks, built to team_100's own standard: *"detailed enough for any junior developer or fresh agent to implement without gaps, guesses, or assumptions."* Its own §0 (purpose/summary), §0.1 (findings that correct LOD300), §0.2 (small open decisions), §0.3 (task dependency order), §0.4 (patch changelog) are worth reading first — they'll save you from re-deriving things already settled.
3. **Cross-engine validation of the LOD400 spec itself** (Iron Rule #1 — team_90 on cursor-composer, not Claude, validating team_100's Claude-authored spec) — two rounds:
   - Round 1: `FAIL` — 2 blockers + 1 major, all genuine cross-task integration gaps (T6's file-deletion plan would have deleted Wave2 files that T3/T3b's new code silently calls at runtime) + 4 minor.
   - Round 2 (delta): `PASS_WITH_FINDINGS` — all 7 findings closed, one small optional nit also closed. **No open blockers or majors.** Verdict: `_COMMUNICATION/team_90/VERDICT-WP-CANON-LOD400-2026-07-14.md`.

**This means the LOD400 spec is build-ready per team_90's own independent review — you are not starting from an unvalidated draft.**

## Your job, concretely

Per team_00's instruction, execute the full WP lifecycle under ADR045 execution-authority-full mode:
1. Build T1 → T7 per LOD400's file-by-file specs (T5 has zero dependencies and can start immediately in parallel with T1/T2/T3/T3b; T4 is blocked on T2+T3b locking their data contracts — LOD400 §0.3 has the full dependency diagram; T6 is a closing gate, only after T1-T5+T3b are built and verified).
2. Mandate team_90 for L-GATE_BUILD and L-GATE_VALIDATE yourself (you don't need to route through team_100 for this in execution-mandate mode) — Iron Rule #1 still applies: you (or whichever engine you build under) must not also validate your own work.
3. Run the full QA suite LOD400 §7 (T7) specifies — `qa_probe.mjs`, `content-diff.mjs` (0% content drift on every ported page), the Eyal editing-interface regeneration, the `/qr` URL-preservation verification (LOD400 T5 §4.3 — this one is non-negotiable, per team_00's own constraint, not a nice-to-have check).
4. File the mandatory `COMPLETION_REPORT_WP-CANON-TEMPLATE-UNIFICATION_v1.0.0.md` at `_COMMUNICATION/team_110/` when done (gate chain, verdict paths, findings disposition) — team_00 + team_100 are the recipients.

## One thing not yet closed — needs a call, not a block

LOD400 §0.2, decision 1: how to handle `tpl-home.php` + the relevant half of `wave2-stage-b.php` (the site's documented emergency rollback mechanism for the whole Chapters migration) when T6 gets there. team_100's recommendation — freeze-and-isolate (keep both as an inert emergency artifact, not a live dependency) — is fully reasoned in LOD400 §6.3. team_00 has not yet given an explicit sign-off on this specific point. **Given the "full" execution mandate, don't stop and wait for it** — proceed with team_100's recommended default unless you have a concrete engineering reason to prefer differently, and say explicitly which you did and why in your COMPLETION_REPORT. This mirrors exactly how team_00 already delegated the T1 video-component choice to engineering judgment in LOD300.

## Do not re-litigate

- The 3 LOD300 decisions above (many-to-many, T1 engineering judgment, `/qr` hard constraint) — settled, in-chat, by team_00 directly.
- The 5 LOD300 corrections (C-1 through C-5) and the 9 additional LOD400 corrections (F-1 through F-5, D-1 through D-9) to the original LOD200 scoping — all already verified against live code this session, cited with file:line evidence throughout LOD400. If something looks off, re-check against the live repo before assuming the spec is wrong — most of what looked like open questions when this WP started turned out to be resolvable by reading the actual code rather than assumptions.
- C-5 (the Mendele URL discrepancy for "צבע בכחול וזרוק לים") remains a genuine external blocker — it needs an answer from Eyal, not from you or team_00. LOD400 T3b §3.3/§4 has the full detail and works around it cleanly (price/CTA-structure/gallery all ship now; only the one URL value stays flagged `C-5 PENDING` in the code).

## Housekeeping instruction from team_00 (applies to your session too, not just this handoff)

Team_00's own words on this handoff: *"שימו לב חובה להשאיר עץ נקי - פוש מלא להכול"* — leave a clean git tree, push everything fully. This session (team_100) is doing that now for its own LOD300/LOD400/validation work before this handoff lands. The same standard applies to your own execution work — don't leave uncommitted or unpushed work sitting when your session ends.

---

# Appendix A — Canonical AOS Handoff Activation (verbatim)

*Generated via `/AOS_mail handoff` → `GET /api/prompts/generate?type=onboard_agent&mode=handoff&team_id=team_110&project_id=eyalamit&governance_depth=full&wp_id=WP-CANON-TEMPLATE-UNIFICATION` at `2026-07-14T01:49:57.464890Z`. Embedded verbatim per the canonical handoff mechanism (ADR043 §A.4c). Note: the API's own WP-detail lookup returned "unavailable" for WP-CANON-TEMPLATE-UNIFICATION below (same known limitation as team_100's own prior handoffs on this WP — it's registered file-only, per the ADR034 R8/offline-fallback precedent) — the sections above, plus `_aos/roadmap.yaml`'s WP-CANON-TEMPLATE-UNIFICATION entry (now updated to `lod_status: LOD400`, `current_lean_gate: L-GATE_SPEC`, with a full gate_history for the LOD300/LOD400/validation cycle), are the authoritative WP context, not the generated block's placeholder. Also note: the generated block's own "Session Task" section defaults to asking "What task should I focus on?" and its embedded permissions-context block has a stray "Team 170" typo (should read Team 100, consistent with the paragraph above it) — both are known artifacts of the generic template, not instructions to follow; the actual task is fully specified above.*

## 1. SESSION ACCOMPLISHED
*(No accomplishments recorded — session handoff for context only.)* — superseded by "What happened before this handoff" above.

## 2. IDENTITY SNAPSHOT
- **Team ID:** team_110 · **Engine:** cursor-composer-2 · **Group:** architecture · **Profession:** domain_architect · **Domain scope:** universal
- **Role:** AOS Domain Architect — architecture approval authority (GATE_2) for AOS domain WPs, and primary WP executor when holding an `execution_authority: full` mandate (ADR045, granted here by team_00's explicit instruction).

## 3. CONTEXT SNAPSHOT
- **Work Package:** WP-CANON-TEMPLATE-UNIFICATION — see LOD400 doc (this repo, `_COMMUNICATION/team_100/`) for the actual build spec; API lookup unavailable (file-only registration, see note above).

## 4. MANDATORY READS
- `_aos/governance/team_110.md`
- `_aos/roadmap.yaml` (WP-CANON-TEMPLATE-UNIFICATION entry)
- `_COMMUNICATION/team_100/WP-CANON-TEMPLATE-UNIFICATION-LOD400-2026-07-14.md` (the actual build spec — read before anything else)
- `_COMMUNICATION/team_100/WP-CANON-TEMPLATE-UNIFICATION-LOD300-2026-07-14.md` (behavior-level context + the 3 team_00 decisions)
- `_COMMUNICATION/team_90/VERDICT-WP-CANON-LOD400-2026-07-14.md` (cross-engine validation — build-ready, no open blockers)
- `methodology/AOS_IDENTITY_ONBOARDING_v1.0.0.md` (first AOS session only)

## 5. SESSION BOOTSTRAP

```bash
export AOS_SESSION_TEAM_ID=team_110 AOS_PROJECT_ID=eyalamit
export AOS_API_BASE="${AOS_API_BASE:-http://100.125.98.56:8092}"
bash scripts/aos_session_ctl.sh start WP-CANON-TEMPLATE-UNIFICATION
/AOS_mail check
```

## 6. GOVERNANCE CONTRACT (Team 110 — AOS Domain Architect / Cursor Composer 2)

**Authority scope:** Owns GATE_2/2.1 for AOS domain — architecture approval phase. Reviews and approves the LOD200/LOD400 spec produced by Team 100. `is_human_gate = 0` — uses ADVANCE, no human sign-off required at this gate itself (team_00 has already directed execution via this handoff).

**Execution Authority (WP mandate mode — ADR045)** — active for this WP, per team_00's explicit instruction on this handoff:
- May independently issue mandates to team_90 (L-GATE_BUILD), team_90 (L-GATE_VALIDATE), and team_120 (archive/closure) — without routing through team_100.
- May issue API mutations for WP lifecycle fields (`status`, `lod_status`, `current_lean_gate`) via `POST /api/work-packages/{wp_id}` — all other fields remain team_100-only; direct YAML edits to canonical fields remain forbidden when DB is online (Iron Rule #7/ADR034 R2). Note: this WP's hub API record has a known "unavailable" lookup issue (file-only registration) — if the API PUT also fails for the same reason, the `_aos/roadmap.yaml` file entry is the fallback SSoT for this specific WP (ADR034 R8 precedent, already used by team_100 this session).
- Must file `COMPLETION_REPORT_WP-CANON-TEMPLATE-UNIFICATION_v1.0.0.md` at `_COMMUNICATION/team_110/` upon LOD500_LOCKED — recipients team_00 + team_100.
- **Iron Rule #1 still applies:** must not validate your own implementation. team_90 remains independent — delegate, never self-validate.
- team_00 override is absolute at all times. Fallback to team_100 ownership if this session ends without LOD500_LOCKED, or team_00 issues explicit override.

**Permissions:**

```yaml
writes_to: [_COMMUNICATION/team_110/, _COMMUNICATION/team_110/*/, _COMMUNICATION/team_90/ (mandate delivery, execution mode), _COMMUNICATION/team_120/ (archive mandate delivery, execution mode)]
gate_authority: {L-GATE_SPEC: owner, L-GATE_BUILD: delegated, L-GATE_VALIDATE: delegated, L-GATE_ELIGIBILITY: awareness_only}
```

Full governance contract text (Iron rules, boundaries, offline-DB protocol, canonical output header, AOS vision) is in `_aos/governance/team_110.md` — read it, not duplicated here.

## 7. FIRST ACTION FOR team_110

Do **not** ask "what task should I focus on" — it's fully specified above. Read the LOD400 doc in full, confirm your understanding of the task dependency order (§0.3 there), and start building — T5 (`/shop` + `/qr`) has zero dependencies and is the safest place to prove out the workflow first, but any order consistent with §0.3's dependency diagram is fine. Report progress to team_00 + team_100 via `_COMMUNICATION/team_110/` as you close each task, and file the COMPLETION_REPORT when the whole WP reaches LOD500_LOCKED.

## 8. CONTEXT CHECKPOINT (aos_handoff)

```aos-context-checkpoint
{
  "team_id": "team_110",
  "wp_id": "WP-CANON-TEMPLATE-UNIFICATION",
  "domain": "eyalamit",
  "profile": {"depth": "FULL", "target": "RICH", "lifecycle": "NEW", "mission_source": "TEAM_00_DIRECTIVE_2026-07-14"},
  "source_versions": {"base": "7b9153f29ac936bd", "team": "6bdad8b875e47fcc", "domain": "3845125952f96d5f", "wp": "ae165a9134fb4870"}
}
```
