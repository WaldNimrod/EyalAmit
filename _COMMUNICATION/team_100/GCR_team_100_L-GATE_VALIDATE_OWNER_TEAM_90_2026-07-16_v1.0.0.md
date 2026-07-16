---
id: GOVERNANCE_CHANGE_REQUEST_L-GATE_VALIDATE_OWNER_TEAM_90_v1.0.0
type: GOVERNANCE_CHANGE_REQUEST
from: Team 100 (Chief System Architect — eyalamit spoke session)
to: Team 100 (Chief System Architect — hub) · Team 120 (Ambassador, gatekeeper)
cc: Team 00 (Principal) · Team 90 (Default Validator) · Team 110
date: 2026-07-16
version: v1.0.0
urgency: HIGH
target_file:
  - core/governance/team_90.md
  - core/governance/directives/ADR045_TEAM_110_AUTONOMOUS_EXECUTION_v1.0.0.md
  - CLAUDE.md (Iron Rule #5 — hub template + propagated spokes)
project: eyalamit (found here; the drift is fleet-wide)
ruling_ref: "team_00 (נמרוד) 2026-07-16 — «אשר את בעלות L-GATE_VALIDATE - team_90 הוא הוולידטור»"
---

# Governance Change Request: L-GATE_VALIDATE owner = team_90 (team_190 dissolved)

## 1. Requesting Team

- **Team ID:** 100 · **Role:** Chief System Architect · **Project:** eyalamit (L0 spoke) · **Engine:** claude-opus-4-8

## 2. Proposed Change

**team_00 has ruled (2026-07-16): `team_90` owns `L-GATE_VALIDATE`**, replacing **`team_190`**, which no longer
exists in the canonical team registry. Three canonical sources still contradict that ruling and each other, and
must be amended.

## 3. Rationale

Discovered 2026-07-16 while correcting a separate `team_191` drift. **The canonical registry
(`core/governance/team_*.md`) contains exactly 14 teams** — `00, 10, 40, 50, 60, 70, 80, 90, 98, 99, 100, 110,
120, 200`. **There is no `team_190.md` and no `team_191.md`.** Yet:

| # | Source | What it says today | Problem |
|---|--------|--------------------|---------|
| 1 | `core/governance/team_90.md` — machine block | `gate_authority: {L-GATE_SPEC: awareness_only, L-GATE_BUILD: owner, L-GATE_VALIDATE: awareness_only, L-GATE_ELIGIBILITY: awareness_only}` | team_90 owns **L-GATE_BUILD only** → **L-GATE_VALIDATE is ownerless** |
| 2 | `core/governance/team_90.md` — prose | *"Does NOT own L-GATE_ELIGIBILITY, L-GATE_SPEC, or L-GATE_VALIDATE — those are **Team 90** (Senior Constitutional Validator) exclusively."* | **Self-contradictory.** A **botched 190→90 rename**: it must once have read "Team **190**". Also: *"…not requiring Team 90 (senior constitutional) review"* in Domain scope — same defect. |
| 3 | `ADR045_TEAM_110_AUTONOMOUS_EXECUTION_v1.0.0.md` **R3.2** | *"team_190 constitutional independence: team_190 remains the sole L-GATE_VALIDATE owner."* (also R2: sub-mandates to team_190 / **team_191**) | Names a team with **no governance file**; and team_191 is **dissolved** (ADR042 Addendum v1.1.0) |
| 4 | `CLAUDE.md` Iron Rule #5 (hub template + every propagated spoke) | *"Final validation owned by `team_190` (constitutional, cross-engine, immutable)"* | Same — an absent team named in a **constitutional** rule |

**Operational impact (real, not theoretical):** the eyalamit S005 milestone routed **every** L-GATE_SPEC and
L-GATE_VALIDATE validation to team_90 (WP-CANON; S005-PACKAGE-1-3 coverage cycles 1–3; WP-S5-06 + WP-S5-07
LOD400 cycles 1–2; the S004 registration audit) — all team_00-authorized, all substantively excellent
(cycle-1 caught a **major** defect that had survived three documents). But per source #1 those runs were
`awareness_only`, i.e. **not registry-backed**. team_00's ruling ratifies the practice; the contracts must now
say so, or the next session re-reads `awareness_only` and re-opens the same gap.

**Why team_100 did not just fix it:** Iron Rule #5 is **constitutional**, and `_aos/governance/` in a spoke is a
**READ-ONLY snapshot** (Iron Rule #2 / #11). Governance flows source → snapshot only.

## 4. Precise Prompt for Team 100 (hub)

**(a) `core/governance/team_90.md` — machine block.** Change:
```yaml
gate_authority:
  L-GATE_SPEC: awareness_only
  L-GATE_BUILD: owner
  L-GATE_VALIDATE: awareness_only
  L-GATE_ELIGIBILITY: awareness_only
```
to:
```yaml
gate_authority:
  L-GATE_SPEC: owner            # ⚠ pending team_00 confirm — see §5
  L-GATE_BUILD: owner
  L-GATE_VALIDATE: owner        # team_00 ruling 2026-07-16 (explicit)
  L-GATE_ELIGIBILITY: owner     # ⚠ pending team_00 confirm — see §5
```

**(b) `core/governance/team_90.md` — prose.** Replace the self-contradictory line:
> ~~"Does NOT own L-GATE_ELIGIBILITY, L-GATE_SPEC, or L-GATE_VALIDATE — those are Team 90 (Senior Constitutional Validator) exclusively."~~

with:
> "**Owns L-GATE_VALIDATE** — senior constitutional validation (team_00 ruling 2026-07-16, absorbing the
> dissolved Team 190's role). Constitutional independence applies: the verdict must not be constrained by the
> routing team, and Iron Rule #1 (builder engine ≠ validator engine) binds every verdict."

And in **Identity → Domain scope**, replace *"…not requiring Team 90 (senior constitutional) review"* with
*"…including senior constitutional review (L-GATE_VALIDATE), inherited from the dissolved Team 190."*

**(c) `ADR045_TEAM_110_AUTONOMOUS_EXECUTION_v1.0.0.md`.** In **R2**, replace the sub-mandate list
`team_90 / team_190 / team_191` with `team_90` (L-GATE_BUILD **and** L-GATE_VALIDATE) + the ADR042-Addendum
archive path (`/AOS_archive` by the closing orchestrator; **team_120** custodian; **team_60** commits). In
**R3.2**, replace *"team_190 remains the sole L-GATE_VALIDATE owner"* with *"**team_90** is the sole
L-GATE_VALIDATE owner (team_00 ruling 2026-07-16). team_110 routes to them; the mandate must not constrain
their verdict."* Also drop the stale `_COMMUNICATION/team_190/` + `_COMMUNICATION/team_191/` write paths.

**(d) `CLAUDE.md` Iron Rule #5** (hub template → propagate to all spokes). Replace:
> ~~"Final validation owned by `team_190` (constitutional, cross-engine, immutable)"~~

with:
> "Final validation owned by **`team_90`** (constitutional, cross-engine, immutable) — team_00 ruling
> 2026-07-16, absorbing the dissolved team_190."

**(e) Bump versions + propagate.** ADR045 → v1.1.0 with an addendum block citing this ruling (mirroring how
ADR042's team_191 dissolution was handled). Then `aos_sync_all.sh` / `propagate_governance.sh` to the fleet so
every spoke's snapshot agrees. **Iron Rule #2:** the spoke copies are snapshots — they update by propagation only.

## 5. ⚠ One item for team_00 to confirm — team_100 will NOT infer it

The ruling names **L-GATE_VALIDATE** explicitly. But **`L-GATE_SPEC` and `L-GATE_ELIGIBILITY` are in the same
orphaned bucket** — `team_90.md` marks all three `awareness_only` because all three belonged to the one absent
team_190. Extending a **constitutional** ruling by inference is exactly what team_100 declined to do in the
first place, so §4(a) marks those two `⚠ pending team_00 confirm`.

**team_100's recommendation: confirm all three → team_90.** The three were a single team's bundle; leaving
L-GATE_SPEC ownerless would leave every LOD400 spec validation (including the four already PASSed on S005)
un-backed, and team_90's registry role is literally *"Default Validator"*. **Awaiting one word from team_00.**

## 6. Impact if not actioned

- Every spoke keeps reading `L-GATE_VALIDATE: awareness_only` → the gap re-opens each session (it already
  consumed a full escalation cycle here).
- `ADR045` keeps routing team_110 to two non-existent teams (`team_190`, `team_191`).
- `CLAUDE.md` Iron Rule #5 — a **constitutional** rule — keeps naming a team that does not exist, in every spoke.
- **Not blocking eyalamit S005:** WP-S5-05 is the cutover gate, already BLOCKED on S5-01..04/06/07 +
  M-EYAL-INPUTS + explicit team_00 go-live approval. Its `assigned_validator` now reads `team_90` per the ruling.

## 7. Provenance

- Ruling: team_00, 2026-07-16 — *«אשר את בעלות L-GATE_VALIDATE - team_90 הוא הוולידטור»*
- Escalation that produced it: `_aos/roadmap.yaml` → `WP-S5-05.governance_drift_l_gate_validate_owner`
  (now `l_gate_validate_owner_ruling`)
- Related dissolution precedent: `ADR042_ADDENDUM_TEAM191_DISSOLUTION_v1.1.0.md` (team_191 → team_120 custodian +
  closing orchestrator via `/AOS_archive` + team_60 commits)
