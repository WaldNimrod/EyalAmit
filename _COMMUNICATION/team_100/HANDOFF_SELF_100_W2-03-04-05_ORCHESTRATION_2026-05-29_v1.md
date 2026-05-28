---
id: HANDOFF_SELF_100_W2-03-04-05_ORCHESTRATION_2026-05-29_v1
mode: handoff
target_team: team_100
scope: WP-W2-03, WP-W2-04, WP-W2-05 (input-ready Wave2 content trio)
governance_depth: full
generated: 2026-05-29
generator: manual canonical render (format mirrors AOS_IDENTITY_ONBOARDING_v1.0.0; regenerate via /api/prompts/generate when that endpoint is healthy)
---

# Handoff — team_100 · Orchestrate WP-W2-03 / W2-04 / W2-05 (full)

## 0. ✅ Preconditions (all met)
- Dependency **WP-W2-02 = COMPLETE/LOD500_LOCKED** (on main, merged 61adef4).
- LOD400 specs for W2-03/04/05 **PASS L-GATE_SPEC** (team_190 Codex v2, 2026-05-28).
- These three are **input-ready** (25.5.26 `.md` sources exist) — dispatchable now.
- (W2-07/W2-08 deferred — input-blocked on team_40 / team_30 artifacts; W2-09 last.)

## 1. Activation TL;DR
- **Identity:** team_100 · Chief System Architect · eyalamit spoke (L0).
- **Mission:** Orchestrate W2-03 → W2-04 → W2-05 to canonical closure, one WP at a time, then re-handoff to the next.
- **State:** team=team_100 wp=WP-W2-03 gate=L-GATE_BUILD(next) depth=full.

## 2. Environment
- Repo: `/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026`; trunk `main` @ 61adef4.
- Hub API `http://100.125.98.56:8090` (Tailscale; `/api/prompts/generate` was unstable — use file-based ADR034 R9 for spoke WPs).
- Validate: `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` → 30 PASS / 18 SKIP / 0 FAIL.

## 3. Governance (full)
- IR#1 (team_00 strict 2026-05-28): builder=claude-sonnet → L-GATE_BUILD validator (team_50) MUST be non-Claude; L-GATE_VALIDATE (team_190) = native Codex. Applies to every WP.
- team_00 (Nimrod) is sole Principal — never override. team_100 owns roadmap (ADR034 R9) + LOD400 specs; does not implement production code except trivial validator-triggered fixes under team_00 disposition.
- Branch isolation: each WP on its OWN branch off `main` (do NOT reuse a shared tree — the W2-02/W2-06 single-tree coupling caused real friction).

## 4. The three WPs
| WP | Spec | Branch | Sources | Est |
|----|------|--------|---------|-----|
| WP-W2-03 Books | `_aos/work_packages/S002/WP-W2-03/LOD400_spec.md` | `feature/w2-03-books` | MUZZA/vekatavta/kushi_full/eyal_tsva_FINAL | 4-6d |
| WP-W2-04 Sound+Lessons | `_aos/work_packages/S002/WP-W2-04/LOD400_spec.md` | `feature/w2-04-services` | sound_healing_final/lesons | 3-4d |
| WP-W2-05 Shop | `_aos/work_packages/S002/WP-W2-05/LOD400_spec.md` | `feature/w2-05-shop` | buy didgeridoo/bags/stends/build didg | 4-5d |
Mandates: W2-03 → `_COMMUNICATION/team_10/MANDATE-TEAM10-W2-03-BOOKS-2026-05-28.md`; W2-04/05 → draft from spec at dispatch.

## 5. ORCHESTRATION LOOP (canonical — per WP)
1. Confirm spec L-GATE_SPEC PASS (done for all three) + `lod_status: LOD400`.
2. Dispatch builder (team_10) on the WP's OWN branch off main. Reuse W2-02 routing pattern (`template_include` @100 + `set_query_var('ea_wave2_shell',true)`).
3. Deploy (`scripts/ftp_deploy_site_wp_content.py` — upload-only; mind opcache + cache-bust verify).
4. L-GATE_BUILD: issue team_50 QA mandate (NON-CLAUDE). FAIL → remediate (sub-agent), redeploy, re-QA. Watch the stale-verdict trap: require the validator to prove HEAD + cache-bust.
5. L-GATE_VALIDATE: route to team_190 (Codex). BLOCKED → remediate.
6. CANONICAL END CHECKS (all pass): validate_aos 0 FAIL · all ACs verified live (cache-busted) · team_190 PASS · tree committed.
7. WP CLOSURE: team_191 archive mandate · roadmap → COMPLETE/LOD500_LOCKED + gate_history · propagation SKIP unless core/governance changed · merge `feature/<wp>` → main.
8. RE-HANDOFF: generate the next WP's handoff, present Section 6 to team_00. Order: W2-03 → W2-04 → W2-05. After W2-05, queue continues to W2-07/08 (once inputs land) → W2-09.

## 6. ACTIVATION PROMPT  ← copy to start the next session
```
HANDOFF_DEPTH: full
ACTIVATION_SCOPE: team_100 only

You are team_100 (Chief System Architect), AOS eyalamit spoke.
Repo: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026 ; trunk main @ 61adef4.
Principal: team_00 (Nimrod) — never override.

MISSION: orchestrate WP-W2-03 → W2-04 → W2-05 to canonical closure, one per session,
re-handing-off after each. All three already PASS L-GATE_SPEC (team_190 Codex v2) and are
input-ready. Each on its OWN branch off main (feature/w2-03-books, -04-services, -05-shop).

THIS WP: WP-W2-03 (Books).
  Spec: _aos/work_packages/S002/WP-W2-03/LOD400_spec.md
  Mandate: _COMMUNICATION/team_10/MANDATE-TEAM10-W2-03-BOOKS-2026-05-28.md

LOOP per WP: spec PASS confirmed → dispatch team_10 on feature/<wp> (template_include @100 +
ea_wave2_shell) → deploy (ftp_deploy_site_wp_content.py; cache-bust verify) → L-GATE_BUILD
team_50 NON-CLAUDE (IR#1; require proof-of-HEAD + cache-bust to avoid stale verdicts) →
L-GATE_VALIDATE team_190 Codex → CANONICAL CHECKS (validate_aos 0 FAIL, ACs live, team_190 PASS,
committed) → WP CLOSURE (team_191 archive; roadmap COMPLETE/LOD500_LOCKED; merge feature/<wp>→main)
→ RE-HANDOFF next WP.

FIRST ACTION:
  1. git status + git log --oneline -5 (on main, clean).
  2. validate_aos.sh . → 30 PASS / 18 SKIP / 0 FAIL.
  3. Read WP-W2-03 spec + mandate; confirm WP-W2-02 dependency COMPLETE.
  4. Ask team_00: "Dispatch WP-W2-03 build on feature/w2-03-books?" then hand the builder the
     mandate §7 activation prompt. Run the loop.
```

## 7. Operating options
[A] decision doc · [B] new WP (team_00 approval) · [C] GATE_2 fallback · [D] routing mandate · [E] gov-sync · [F] escalate team_00.

## FIRST ACTION
See Section 6. Begin with WP-W2-03 on `feature/w2-03-books`.
