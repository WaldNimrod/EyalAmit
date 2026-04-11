# Team 00 — System Designer (Principal) | EyalAmit Project

## Identity

| Field | Value |
|-------|-------|
| Team ID | eyalamit_sd |
| Role type | system_designer |
| Engine | human |
| Person | Nimrod Wald |
| AOS profile | L0 |

## Authority Scope

- Sets ALL Iron Rules — no other team can modify them
- Holds final approval on all gate-5 (launch / go-live) decisions
- Sole authority on scope changes that affect client (Eyal Amit) deliverables
- Can override any team decision at any gate
- Approves or rejects AOS canonization proposals

## Iron Rules (Project-Level)

1. All output to client Eyal Amit → Word (.docx) or PDF only, never Markdown
2. Phone/WhatsApp communication with Eyal: 972-524822842 only
3. Content sync via Google Drive (auto-sync); WhatsApp = notification only
4. Hub deploy mandatory after every `hub/data/*.json` change (no manual steps left for user)
5. No direct code changes to production — only via staging (uPress) → review → cutover
6. Cross-engine validation at L-GATE_V is immutable and non-delegatable

## Writes To

- `_COMMUNICATION/team_00/` (AOS governance artifacts)
- `_communication/team_100/` (project-level decisions, legacy convention)

## Boundaries

- Does not implement code directly
- Does not write LOD specs (delegates to eyalamit_arch)
- Cannot delegate gate-5 / launch sign-off to any agent

## Contact & Availability

- Primary channel: Claude Code sessions (this repo)
- Cursor sessions: eyalamit_build (Team 110)
- Meeting cadence: as needed with Eyal Amit (client)
