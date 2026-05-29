---
id: DECISION-REQUEST-PRECONDITION1-DB-SSOT-INFRA-2026-05-29
from_team: team_100 (Chief System Architect — eyalamit SPOKE)
to_team: team_100 (AOS HUB — governance/canon authority over roadmap mutation)
cc: team_00 (Principal), team_60 (Infra/Home-Server)
re: PRECONDITION #1 — DB-as-SSoT roadmap-mutation infra gap (blocks W2-04 CLOSURE)
date: 2026-05-29
status: OPEN — decision request routed to hub per team_00 disposition 2026-05-29
blocks: W2-04 CLOSURE (NOT build) — Iron Rule #7 / ADR034 API-only structured mutations
routing_note: team_00 directs this be examined at the AOS-environment level (governance + canon
  for the roadmap), not decided locally by the spoke. Spoke implements a TEMPORARY BYPASS
  (offline-fallback, named-branch roadmap.yaml edit) to keep progressing until the hub decision
  is returned. Options below are the spoke's analysis for the hub to rule on — NOT a local choice.
---

# Decision Request — PRECONDITION #1 (DB-as-SSoT infra gap)

## Current state (verified live this session, 2026-05-29)
- `db_connectivity_status.json` (hub) → `status: online` (checked_at 2026-05-25, stale 4d).
- `validate_aos.sh` Check 39 → **AOS API healthy** at `http://100.125.98.56:8090` (Tailscale).
- **BUT** `GET http://100.125.98.56:8090/api/l0/eyalamit/roadmap` → **HTTP 404**:
  ```json
  {"detail":{"code":"NOT_FOUND","message":"Project root not found:
   /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026", ...}}
  ```
- **Failure mode has shifted since the handoff was written.** Previously the API looked for
  `server_path /data/projects/eyalamit` (never created). Now `projects.yaml` appears repointed
  at the **Mac `local_path`** — i.e. option (b) was *partially* attempted — but the API process
  runs **on the home server** and cannot reach the Mac filesystem path. Still 404. Gap unresolved.

## Why this matters
IR#7 / ADR034 require API-only structured mutations when the DB is online. For this spoke that
is currently **impossible** — the API cannot resolve the project root, so `deploy_cascade()`
cannot write `roadmap.yaml`. W2-02 / W2-06 / W2-03 all closed via the **ADR034 offline-fallback**
(direct `roadmap.yaml` edit on a named branch). W2-04 will need the same unless resolved.

## Decision required — choose ONE
- **(a)** team_60 creates + keeps-in-sync a server-side checkout at `/data/projects/eyalamit`
  and re-verifies `server_path` in hub `projects.yaml`. (Heaviest; gives true server SSoT.)
- **(b)** Point the API at the Mac `local_path` over Tailscale **with the API able to actually
  reach it** (e.g. mount/agent on the Mac, or run a spoke-local API the hub federates to).
  Note: the half-done repoint already in `projects.yaml` is the *broken* version of this.
- **(c)** ⭐ **RECOMMENDED** — Formally ratify the offline-fallback (named-branch `roadmap.yaml`
  edit) as the **canonical** path for this Mac-only spoke. Update CLAUDE.md step 4 + ADR034 to
  declare: for spokes with no server checkout, online DB status does NOT mandate API mutation;
  the named-branch file edit IS canonical, logged in `gate_history`. uPress hosts the *website*;
  the home server runs *governance only* and does not need the site — so a server checkout of the
  site repo is arguably unnecessary overhead. (c) removes the recurring per-WP friction.

## team_100 recommendation
**(c)** — lowest friction, matches the actual topology (Mac-only spoke; server = governance only),
and codifies what we have already done 3× in practice. (a)/(b) only if org policy requires a true
server-side SSoT checkout for all spokes.

## Until decided
Continue the **offline-fallback** for W2-04 closure (precedent W2-02/06/03), on the
`feature/w2-04-services` branch, logged in `gate_history`. **Build is NOT blocked** and proceeds now.

*team_100 — 2026-05-29 — awaiting team_00 + team_60 disposition.*
