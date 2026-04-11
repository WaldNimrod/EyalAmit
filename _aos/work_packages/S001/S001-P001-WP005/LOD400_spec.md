# LOD400 — S001-P001-WP005: AOS Hub Registration

**WP ID:** S001-P001-WP005
**Label:** AOS hub registration — projects/eyalamit.yaml + _aos/projects.yaml entry
**Track:** A | **Milestone:** S001
**Author:** eyalamit_arch | **Date:** 2026-04-11

---

## Scope

Register the EyalAmit project as a canonical spoke in the AOS hub's project registry.
Two files in the hub repo must be created/updated.

---

## Acceptance Criteria

### AC-001: agents-os/projects/eyalamit.yaml created
- File exists at `projects/eyalamit.yaml` in the hub repo
- Fields: project_id, name, type (spoke), repo, local_path, profile (L0), enabled (true)
- lean_kit_version, active_milestone, canonized_at, notes

### AC-002: agents-os/_aos/projects.yaml updated
- `eyalamit` entry added to the projects array
- Fields: id, name, type, repo, local_path, profile, enabled
- Optional: lean_kit_version, active_milestone, canonized_at

### AC-003: Migration spec submitted to AOS teams
- `_COMMUNICATION/team_110/` in hub: builder review request
- `_COMMUNICATION/team_190/` in hub: validator review request
- Both files contain full LOD400 spec summary + review request

### AC-004: Hub repo committed and pushed
- Changes in hub repo committed with descriptive message
- Pushed to hub remote
