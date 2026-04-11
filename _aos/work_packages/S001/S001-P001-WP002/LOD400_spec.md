# LOD400 — S001-P001-WP002: Root Context Files

**WP ID:** S001-P001-WP002
**Label:** Root context files — CLAUDE.md + .cursorrules
**Track:** A | **Milestone:** S001
**Author:** eyalamit_arch | **Date:** 2026-04-11

---

## Scope

Create `CLAUDE.md` and `.cursorrules` at the repository root, providing AOS-compliant
session startup context for Claude Code and Cursor agents respectively.

---

## Acceptance Criteria

### AC-001: CLAUDE.md exists at repo root
- File at `CLAUDE.md` (not `docs/CLAUDE.md`)
- Contains: project identity, AOS profile, team model, mandatory startup sequence
- References `_aos/roadmap.yaml` as first mandatory read
- References `_aos/context/PROJECT_CONTEXT.md`
- Lists iron rules applicable to this project
- Does NOT contain absolute filesystem paths that expose machine structure

### AC-002: .cursorrules exists at repo root
- File at `.cursorrules`
- Summarizes project context for Cursor agents
- Points to `_aos/context/ACTIVATION_BUILDER.md` for builder role
- Lists key paths and anti-patterns

### AC-003: .claude/settings.json updated
- `additionalDirectories` points to the AOS hub directory (relative or absolute, not exposed in CLAUDE.md)
- Enables cross-project context when needed

### AC-004: No forbidden pattern triggers
- CLAUDE.md and .cursorrules do not contain strings matching `project_identity.yaml` forbidden_patterns
- No absolute paths to other repos embedded in scanned files

---

## Source Material

Synthesize from:
- `AGENTS.md` (existing agent guide)
- `.cursor/rules/` MDC files (5 existing rules)
- `docs/sop/SSOT.md` (governance)
- `_aos/context/PROJECT_CONTEXT.md`
- AOS sandbox CLAUDE.md pattern
