# LOD400 — S001-P001-WP004: `_COMMUNICATION/` AOS Canonical Structure

**WP ID:** S001-P001-WP004
**Label:** `_COMMUNICATION/` canonical structure + AOS onboarding files
**Track:** A | **Milestone:** S001
**Author:** eyalamit_arch | **Date:** 2026-04-11

---

## Scope

Create `_COMMUNICATION/` (uppercase) alongside the existing `_communication/` (lowercase).
The new directory is the AOS-canonical inter-team artifact space.
The existing `_communication/` is NOT modified or renamed.

---

## Acceptance Criteria

### AC-001: Directory exists
- `_COMMUNICATION/` directory exists at repo root (uppercase)
- `_communication/` (lowercase, existing) is untouched

### AC-002: README.md
- `_COMMUNICATION/README.md` explains the directory purpose
- Lists team directories and naming convention
- States that `_communication/` (lowercase) is the legacy project comms directory

### AC-003: Team onboarding files
- `_COMMUNICATION/team_00/__ONBOARDING_TEAM_00.md` (__ prefix = sorts first)
- `_COMMUNICATION/team_100/__ONBOARDING_TEAM_100.md`
- `_COMMUNICATION/team_110/__ONBOARDING_TEAM_110.md`
- `_COMMUNICATION/team_190/__ONBOARDING_TEAM_190.md`
- Each file contains: role identity, engine, what to read first, write authority

### AC-004: WP artifact directories
- `_COMMUNICATION/team_100/S001-P001-WP001/` (and WP002-005) for arch review artifacts
- `_COMMUNICATION/team_190/S001-P001-WP001/` (and WP002-005) for validator artifacts
- Directories may be empty initially

### AC-005: Naming convention documented
- Artifact files follow: `TEAM_{FROM}_TO_TEAM_{TO}_{TOPIC}_v{N}.md`
