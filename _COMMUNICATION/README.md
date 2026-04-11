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

## Rules

- Each team writes ONLY to their own directory
- WP-scoped artifacts go under `team_ID/[WP-ID]/`
- Onboarding files (`__ONBOARDING_*.md`) sort first (__ prefix)
