# LOD400 — S001-P001-WP003: Governance Contracts + Activation Files

**WP ID:** S001-P001-WP003
**Label:** Governance contracts + context activation files
**Track:** A | **Milestone:** S001
**Author:** eyalamit_arch | **Date:** 2026-04-11

---

## Scope

Create all `_aos/governance/` team contracts and `_aos/context/` activation files,
distilled from existing project team onboarding documents.

---

## Acceptance Criteria

### AC-001: governance/team_00.md
- Identity table, authority scope, iron rules, writes_to, boundaries
- Reflects Nimrod as system designer

### AC-002: governance/team_100.md
- Architecture agent (claude-code) governance contract
- Gate authority: L-GATE_E + L-GATE_S owner

### AC-003: governance/team_110.md
- Builder agent (cursor-composer) governance contract
- Gate authority: L-GATE_B owner
- Explicit: NEVER validate own work (cross-engine rule)

### AC-004: governance/team_190.md
- Constitutional validator (openai) governance contract
- L-GATE_V exclusive ownership
- Cross-engine enforcement

### AC-005: context/PROJECT_CONTEXT.md
- Project overview readable by any agent in ≤5 minutes
- Stack, staging URL, team model, key paths
- Client contact protocol

### AC-006: context/ACTIVATION_ARCH.md
- Startup sequence, current state, responsibilities, iron rules
- Gate model table showing architect's role at each gate

### AC-007: context/ACTIVATION_BUILDER.md
- Startup sequence, validate_aos.sh requirement
- L-GATE_B responsibilities explicit

### AC-008: context/ACTIVATION_VALIDATOR.md
- L-GATE_V checklist
- Output format template for L-GATE_V_result.md
