# LOD400 — S001-P001-WP001: `_aos/` Foundation

**WP ID:** S001-P001-WP001
**Label:** `_aos/` Foundation — governance structure + lean-kit snapshot
**Track:** A | **Milestone:** S001
**Author:** eyalamit_arch (Team 100) | **Date:** 2026-04-11

---

## Scope

Create the complete `_aos/` governance directory structure for the EyalAmit project,
making it a canonical AOS L0 spoke project that can operate independently of the hub.

---

## Acceptance Criteria

### AC-001: lean-kit physical copy
- `_aos/lean-kit/` exists as a physical directory (not symlink)
- Contains all modules from source hub's `lean-kit/` (≥ 80 files)
- `_aos/lean-kit/LEAN_KIT_VERSION.md` exists and readable
- `lean_kit_version` in `_aos/metadata.yaml` matches `LEAN_KIT_VERSION.md`

### AC-002: metadata.yaml
- `_aos/metadata.yaml` exists and is valid YAML
- Fields: `lean_kit_source_date`, `lean_kit_source_sha`, `lean_kit_version`, `profile`
- `profile: L0`

### AC-003: project_identity.yaml
- `_aos/project_identity.yaml` exists with `project_id: eyalamit`
- `is_hub: false`
- `boundaries.allowed_write_roots` lists project-relevant paths
- `boundaries.forbidden_patterns` prevents cross-project imports

### AC-004: definition.yaml
- `_aos/definition.yaml` is a valid YAML snapshot of relevant teams
- Contains team_00, team_100, team_110, team_190 at minimum
- `snapshot_date: 2026-04-11`, `profile: L0`

### AC-005: team_assignments.yaml
- Schema version 1.1
- 4 team entries: eyalamit_sd (human), eyalamit_arch (claude-code), eyalamit_build (cursor-composer), eyalamit_val (openai)
- `cross_engine_validator: eyalamit_val`
- `eyalamit_build.engine ≠ eyalamit_val.engine` (Iron Rule #1)

### AC-006: roadmap.yaml
- Schema version 1.1
- Project block: id, name, profile, lean_kit_version, created, owner, active_milestone
- 5 WPs defined with all required fields
- All `spec_ref` values are repo-internal relative paths (no `..` traversal)

### AC-007: ideas.json + README + MILESTONE_MAP
- `_aos/ideas.json` exists (may be empty array)
- `_aos/README.md` explains the directory purpose
- `_aos/MILESTONE_MAP.md` describes S001 + future milestones

### AC-008: governance directory
- `_aos/governance/` exists with team_00.md, team_100.md, team_110.md, team_190.md
- Each file contains identity, authority scope, iron rules, boundaries

### AC-009: context directory
- `_aos/context/PROJECT_CONTEXT.md` — project overview
- `_aos/context/ACTIVATION_ARCH.md` — architecture agent activation
- `_aos/context/ACTIVATION_BUILDER.md` — builder agent activation
- `_aos/context/ACTIVATION_VALIDATOR.md` — validator activation

### AC-010: validate_aos.sh passes
- `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` exits 0
- All 12 checks PASS or SKIP (no FAIL)

---

## Out of Scope

- Changes to project application code
- Hub build system changes
- WordPress theme changes
- `_COMMUNICATION/` (separate WP004)
- Root CLAUDE.md / .cursorrules (separate WP002)
