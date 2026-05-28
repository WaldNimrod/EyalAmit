---
id: MANDATE-TEAM190-W2-02-L-GATE-VALIDATE-2026-05-28
from_team: team_100 (Chief System Architect)
to_team: team_190 (Final Validator — constitutional, IR#5)
wp: WP-W2-02 — Core Content
date: 2026-05-28
gate: L-GATE_VALIDATE
build_commit: ebb6101
staging: http://eyalamit-co-il-2026.s887.upress.link
status: ISSUED
---

# L-GATE_VALIDATE Mandate — WP-W2-02 (Core Content)

**Issued by team_100** under WP gate-routing authority. team_190 holds constitutional final-validation authority (Iron Rule #5).

## §0 — Engine constraint (IR#1, MANDATORY)
team_190 MUST run on **native Codex / OpenAI / GPT-5**. This is the third distinct engine in the chain:
- Builder = claude-sonnet-4-6
- L-GATE_BUILD QA = team_50 (cursor-composer)
- L-GATE_VALIDATE = team_190 (Codex) ← you

If you are Claude or Cursor, STOP and return REFUSED (disallowed engine).

## §1 — Prior gate state
- **L-GATE_BUILD: PASS_WITH_FINDINGS** (team_50 cursor-composer, v2) — 10/10 ACs PASS.
  - Verdict: `_COMMUNICATION/team_50/QA-VERDICT-WP-W2-02-L-GATE-BUILD-2026-05-28.md`
  - AC-05 (CF7 dequeue) was remediated in commit `ebb6101` and re-verified (0 CF7 assets on non-contact pages, 5 on /contact/). v1 FAIL was stale.
  - Remaining findings: **P3 only** (hero H1 separator → IDEA-005; FAQ mandate count doc-drift; intermittent staging timeouts). No P0/P1.

## §2 — Scope
Validate the 6 core pages (home / method / treatment / about / faq / contact) against:
- LOD400 spec: `_aos/work_packages/S002/S002-P001-WP002/LOD400_spec.md` (and sibling WP specs as applicable)
- Builder handoff: `_COMMUNICATION/team_10/W2-02-HANDOFF-TO-TEAM100-2026-05-28.md`
- The corrected dequeue logic in `inc/wave2-w2-02.php` + `inc/wave2-stage-b.php` (commit ebb6101)

Apply the 8-check validation + **LOD400 precision gate** (every spec detailed enough for a fresh agent to implement without guessing). Independently re-verify AC-05 live (cache-busted) rather than trusting the build verdict.

## §3 — Known non-blocking (do NOT block on these)
Eyal-dependent open items: CF7 form ID, GA4/Clarity IDs, homepage video embed, SMTP delivery (IDEA-003/004). `/about` created via REST (seeder stalled) — documented, acceptable.

## §4 — Deliverable
Verdict file → `_COMMUNICATION/team_190/VERDICT-WP-W2-02-L-GATE-VALIDATE-2026-05-28.md` with PASS or BLOCKED + rationale per check.
- On **PASS** → team_100 executes WP Closure Protocol (team_191 archive → roadmap COMPLETE/LOD500_LOCKED → merge feature/w2-06-blog → main).
- On **BLOCKED** → team_100 routes remediation.

*team_100 — 2026-05-28*
