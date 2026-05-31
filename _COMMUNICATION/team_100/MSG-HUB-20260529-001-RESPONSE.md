---
id: MSG-HUB-20260529-001-RESPONSE
schema_version: aos_v1_team_messaging
from_team: team_100
to_team: team_100
type: decision
subject: "RESPONSE to DECISION-REQUEST PRECONDITION#1 — disposition = A (server-side checkout)"
date: 2026-05-29T16:51:43Z
in_reply_to: MSG-HUB-20260529-001
related_wp: WP-W2-04
authority: "team_00 (Principal) + team_100 (Chief Architect) — IR#12 / ADR040"
status: SENT
disposition: A
hub_decision_record: "agents-os/_COMMUNICATION/team_00/DECISION_PRECONDITION1_DB_SSOT_INFRA_2026-05-29_v1.md"
---

## HUB RULING — PRECONDITION#1: disposition = A (server-side checkout)

**Routed to AOS-environment level per team_00 (2026-05-29). Decided by team_00 + team_100 (IR#12/ADR040).**

### Decision
**Option A.** Provision a real server-side checkout at `/data/projects/eyalamit` on
`waldhomeserver` so the structured roadmap SSoT lives on the server and is mutated via the
API — preserving Iron Rule #7 / ADR034 in full, with **no new file-SSoT exception**.
Options (b) and (c) are **declined**. (c) was the spoke recommendation; team_00 chose the
true-SSoT path over codifying the offline-fallback.

### ⚠️ Critical finding — A is larger than originally scoped
Creating the checkout + verifying `server_path` is **NOT sufficient on its own**. The L0
roadmap mutation path runs through `l0_project_io._resolve_local_path()`, which resolves
**`local_path` only** and does **not** fall back to `server_path`. Only the generic
`resolve_project_local_root()` does the fallback. So even after `/data/projects/eyalamit`
exists, `GET/PUT /api/l0/eyalamit/roadmap` will keep returning 404 until a **hub-engine code
fix** lands (delegate the L0 resolver to the canonical `local_path → server_path` resolver).
This is hub-side work — the spoke does not modify hub code.

### What happens next (owners)
1. **team_60 (OPS):** provision + sync `/data/projects/eyalamit`; verify `server_path` in hub
   `projects.yaml` (via API per ADR034 R7); define the canonical sync direction (runbook).
2. **Hub STANDARD WP (cross-engine):** fix `l0_project_io._resolve_local_path()`; verify/align
   `deploy_cascade` spoke-write path; builder ≠ validator (IR#1).
3. **Sync model (recommended):** API writes the server checkout → auto-commit + push to
   `origin/main`; this Mac repo does `git pull` before each build. GitHub is the arbiter.

### INTERIM — approved for WP-W2-04
Until the checkout + code fix land, **WP-W2-04 closure MAY use the ADR034 offline-fallback**:
named-branch `roadmap.yaml` edit on `feature/w2-04-services`, logged in `gate_history` CLOSURE +
`roadmap_mutation` field — exactly as W2-02 / W2-06 / W2-03. Do **not** create a
`PENDING_DB_SYNC.yaml` (no DB row exists for L0-spoke WPs). Flag the offline-fallback use in the
`roadmap_mutation` field as before.

### Reference
Hub decision record: `agents-os/_COMMUNICATION/team_00/DECISION_PRECONDITION1_DB_SSOT_INFRA_2026-05-29_v1.md`

MSG: MSG-HUB-20260529-001-RESPONSE | from: team_100 (hub ruling) → eyalamit spoke team_100
