# LOD300 — S001 Migration Milestone Scope

**Milestone:** S001 — AOS Canonization
**Profile:** L0 | **Track:** B (LOD300 present, milestone-level scope)
**Date:** 2026-04-11
**Author:** eyalamit_arch (Team 100)

---

## Milestone Goal

Wrap the EyalAmit.co.il 2026 project in canonical AOS governance structure
so that future work packages follow the AOS gate model and are auditable by teams 110+190 in the AOS domain.

**What changes:** Governance layer only (`_aos/`, `_COMMUNICATION/`, root context files, hub registration).
**What does NOT change:** All existing code, scripts, Hub system, WordPress theme, content pipeline.

---

## Work Packages in This Milestone

| WP ID | Label | Track | Status |
|-------|-------|-------|--------|
| S001-P001-WP001 | `_aos/` Foundation | A | IN_PROGRESS |
| S001-P001-WP002 | CLAUDE.md + .cursorrules | A | IN_PROGRESS |
| S001-P001-WP003 | Governance contracts + activation files | A | IN_PROGRESS |
| S001-P001-WP004 | `_COMMUNICATION/` AOS structure | A | IN_PROGRESS |
| S001-P001-WP005 | AOS hub registration | A | IN_PROGRESS |

---

## Exit Criterion

- `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` → exit 0 (all 12 checks)
- Team 110 review PASS (builder implementation review)
- Team 190 validation PASS (constitutional sign-off)
- Committed and pushed to both repos (EyalAmit + agents-os hub)

---

## Scope Boundaries

**In scope:**
- `_aos/` directory (all files)
- `CLAUDE.md` at repo root
- `.cursorrules` at repo root
- `.claude/settings.json` (additionalDirectories update)
- `_COMMUNICATION/` (uppercase, new directory)
- `agents-os/projects/eyalamit.yaml`
- `agents-os/_aos/projects.yaml` (add eyalamit entry)

**Out of scope:**
- WordPress theme code
- Hub build system
- Content pipeline scripts
- `_communication/` (lowercase) — unchanged
- FTP deployment configuration
- Any client-facing deliverables
