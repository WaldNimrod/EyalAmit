# _COMMUNICATION/ — AOS Inter-Team Artifacts

This directory contains **AOS-canonical inter-team artifacts** for the EyalAmit project.

> **Note:** The project also has `_communication/` (lowercase) for legacy project team communications.
> That directory is unchanged. This uppercase `_COMMUNICATION/` follows AOS canon.

## Team Directories

| Directory | Team | Engine | Role |
|-----------|------|--------|------|
| `team_00/` | eyalamit_sd | human | System Designer (Nimrod) |
| `team_100/` | eyalamit_arch | claude-code | Architecture Agent |
| `team_110/` | eyalamit_build | cursor-composer | Builder Agent |
| `team_190/` | eyalamit_val | openai | Constitutional Validator |

## Naming Convention

Artifact files: `TEAM_{FROM}_TO_TEAM_{TO}_{TOPIC}_v{N}.md`

## Archive (Iron Rule #15)

Completed Work Package communication artifacts live under project-root `_archive/<WP-ID>/` (see `ARCHIVE_MANIFEST.md` in each WP folder). Active `_COMMUNICATION/` should not retain WP-scoped outputs after a WP is `COMPLETE` in `_aos/roadmap.yaml`.

**Archived in this repo:** `S002-P001-WP003` (2026-04-15). Empty placeholder dirs for completed `S001-P001-WP001` … `S001-P001-WP005` were removed (no files had been placed there).

## Eyal Client Hub V2 — activation prompts (SSOT)

For **identity + context** copy-paste prompts per team (100, 190, 10, 50, 90), use the single canonical file (workspace root must be **`EyalAmit.co.il-2026`** for Cursor teams):

- [`team_100/EYAL-HUB-V2-ACTIVATION-PROMPTS-ALL-TEAMS-2026-04-15.md`](team_100/EYAL-HUB-V2-ACTIVATION-PROMPTS-ALL-TEAMS-2026-04-15.md)

Open the file, copy the block for your team, append the operator question or scope gap at the end where indicated, and start a new session.

**Artifact order (after LOD400 + mandates):** Team 190 → `team_190/EYAL-HUB-V2/L-GATE_SPEC_result.md` → Team 10 delivery → Team 50 QA report → Team 90 validation. See [`docs/WORKSPACE-POINTER.md`](../docs/WORKSPACE-POINTER.md) (Hub V2 subsection) for the full path list.

## Orphan triage

Files with unclear WP association may be staged under `_ORPHAN_REVIEW/` and indexed in `_ORPHAN_REVIEW/ORPHAN_INDEX.md` for Team 00 review (no deletes).

## Rules

- Each team writes ONLY to their own directory
- WP-scoped artifacts go under `team_ID/[WP-ID]/`
- Onboarding files (`__ONBOARDING_*.md`) sort first (__ prefix)
