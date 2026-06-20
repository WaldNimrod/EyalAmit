# REQUEST — team_110: hub API actor key + DB-reconciliation enablement for the `eyalamit` L0 spoke

**From:** team_100 (Chief Architect, `eyalamit` spoke) · **To:** team_110 (AOS-hub — work-environment + database authority)
**cc:** team_00 (Principal) · **Date:** 2026-06-16 · **Priority:** HIGH (blocks roadmap DB reconciliation)

## Context
WP-W2-16 (post-content completion) shipped + cross-engine dual-PASS (team_50 E2E + team_190 final) and is
merged to `main`. team_00 directed a **full DB reconciliation** of the `eyalamit` roadmap before locking,
using canonical IDs. On execution I hit two facts:

1. **DB vs file drift.** `GET /api/l0/eyalamit/roadmap` (base `http://100.125.98.56:8090`) returns only
   **6 WPs** (`active_milestone: S002`). The **file** `_aos/roadmap.yaml` holds **59 WPs** — the entire Wave2
   program (WP-W2-01…16, ~50 WPs, all of S003) was tracked **file-canonically** (the API was down for that
   stretch; written file-fallback). The DB has never held them.
2. **Non-canonical IDs.** The `WP-W2-*` IDs are rejected by the DB schema (`WP_ID_STANDARD §10`: accepts
   `SNNN-PNNN-WPNNN` or `NB-Vn-WP-*` only) — this is the HTTP 400/422 prior sessions saw on `POST /api/work-packages`.
3. **Auth blocker.** Authenticated writes (`POST /api/work-packages`, `PUT /api/l0/{project}/work-packages/{id}`,
   `POST .../roadmap/advance`) return **HTTP 401 `INVALID_ACTOR_KEY`** — they require `X-Actor-Api-Key` (a per-team
   secret) which team_100 does not hold in the spoke session, and extracting it from secrets is (correctly) denied.

## The reconciliation (designed, ready)
A canonical-ID mapping for all 50 file-only WPs is prepared: **Wave2 launch → `S002-P001-WP005…016`**,
**S003 program → `S003-P001-WP001…038`** (sequential, hierarchy preserved via `parent_wp`; the 9 already-canonical
`S00x-P001-WP00x` stay as-is). Each WP migrates with its full metadata (status / current_lean_gate / lod_status /
builder / validator / milestone / spec_ref / notes / gate_history) via `POST /api/work-packages` + `PUT /api/l0/eyalamit/work-packages/{id}`,
then the COMPLETE/DONE ones lock to `LOD500_LOCKED`. WP-W2-16 (→ `S003-P001-WP032`) locks to COMPLETE on the dual-PASS.

## What we need from you (team_110)
1. **The correct `X-Actor-Api-Key` for team_100** to authenticate hub-API writes for the `eyalamit` L0 project —
   or a referral to where it is configured (env var / secrets path / the canonical key-resolution the AOS_* commands use).
2. **Full environment + DB info** for the migration: confirm the API base (`100.125.98.56:8090` / waldhomeserver) and
   the three-tier resolution; the actor-key model (per-team secret, header name, rotation); whether the `eyalamit` L0
   spoke WPs are expected DB-backed (so the 50-WP create is the right move) vs file-SSoT (ADR034 R9/R10 exception);
   `deploy_cascade()` behaviour after mutation (does it overwrite `_aos/roadmap.yaml` with the canonical IDs?); and any
   ID-renumbering constraints (the `WP-W2-*` → `SNNN-PNNN-WPNNN` rename will change the canonical IDs project-wide).
3. **Execution decision:** either (a) provide the key so team_100 runs the prepared, idempotent migration and reports
   back, or (b) team_110 runs the reconciliation from the hub (we hand off the mapping + payload spec), or (c) your
   guidance if the right path differs.

## ACTIVATION PROMPT (team_110)
```
You are team_110 (AOS-hub work-environment + database authority). team_100 on the eyalamit L0 spoke needs to run a
full roadmap DB reconciliation (50 file-only WP-W2-* WPs → canonical SNNN-PNNN-WPNNN, then lock the dual-PASS'd ones)
but is blocked: hub-API writes return 401 INVALID_ACTOR_KEY (no X-Actor-Api-Key), and the WP-W2-* IDs are DB-schema-invalid.
READ: _COMMUNICATION/team_100/REQUEST-TEAM110-HUB-API-KEY-AND-DB-MIGRATION-2026-06-16.md
PROVIDE: (1) the correct X-Actor-Api-Key for team_100 (or its canonical resolution path); (2) confirmation of the API
base + actor-key model + whether eyalamit L0 WPs are DB-backed vs file-SSoT + deploy_cascade behaviour; (3) whether
team_100 runs the prepared migration with the key, or team_110 runs it from the hub. Reply via _COMMUNICATION/team_110/.
```
