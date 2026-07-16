# ARCHIVE MANIFEST — WP-S5-06 (QR embed facade — click-to-load)

**Iron Rule:** #15 (Archive) · **Procedure:** `_aos/lean-kit/modules/gate-workflow/POST_GATE_ARCHIVE_PROCEDURE.md` **v1.3.0**
**Executed by:** team_110 (closing orchestrator under ADR045 `execution_authority: full`) · **Date:** 2026-07-16
**Custodian:** team_120 · **Commit:** team_60 · **Trigger:** L-GATE_VALIDATE PASS → COMPLETE / LOD500_LOCKED

| Gate | Result | Artifact |
|---|---|---|
| L-GATE_BUILD | PASS (0 blocker / 0 major / 2 minor) | `_archive/WP-S5-06/team_90/VERDICT-WP-S5-06-BUILD-2026-07-16.md` |
| L-GATE_VALIDATE | **PASS (0 findings)** | `_archive/WP-S5-06/team_90/VERDICT-WP-S5-06-VALIDATE-2026-07-16.md` |

## Verify-and-move invariant (v1.3.0 — mandatory)

```
intended_count = 16
verified_count = 16
errors         = none
```
Every destination confirmed present **and** every source confirmed gone (physical-presence check, not
`git mv` exit status). **Non-vacuous:** 16 > 0 — see the `/AOS_archive` finding below, where 0 == 0 would
have passed this gate while moving nothing.

## 🔴 Procedure finding — `/AOS_archive` cannot archive spoke artifacts (routed to team_120, custodian)

The mandate (§4 step 6) directs `/AOS_archive <WP-ID>` (API-mediated `archive.py execute_archive()`).
**Executed against this spoke it is a structural no-op:**

```
POST http://100.125.98.56:8092/api/artifacts/archive {"wp_id":"WP-S5-06","dry_run":true,"project_id":"eyalamit"}
-> HTTP 200  {"source_files": [], "file_count": 0, "target_dir": "_archive/WP-S5-06"}
```

**Cause:** `agents-os/core/modules/management/archive.py:19` hard-wires
`_HUB_ROOT = Path(__file__).resolve().parents[3]`, and `plan_archive(wp_id)` takes **no project/spoke
parameter**. The endpoint can only ever see files inside the **hub** repo. For any L0 spoke it returns 0
files — and `execute_archive()` would then report `verified_count == intended_count == 0`, **passing the
mandate's own archive gate while archiving nothing**. `X-Project-Id` / `project_id` are not honoured by it.

**Action taken:** archived by executing the **v1.3.0 runbook manually**, which the procedure explicitly
sanctions ("Can be invoked via `/AOS_archive <wp-id>` **or executed manually following this runbook**").
**Requested of team_120:** either give `archive.py` a project-root parameter (and have the endpoint resolve
the spoke), or amend the procedure to state that spokes must use the manual runbook — and, either way, make
a 0-file plan a **hard error** rather than a silent success.

## Selection rule (why some files that mention WP-S5-06 were NOT moved)

Applied the runbook's **naming-pattern** rule (Step 3: `ROUTING_*` / `VERDICT_*` / `MANDATE_*` / `HANDOFF_*`
carrying the WP-ID) — **not** a bare grep for the WP-ID. A bare grep matches 20 files here, 9 of which are
shared, multi-WP or other-scope documents; archiving them would have removed artifacts that **WP-S5-07 and
WP-S5-03 still need in this very session** — including the active execution mandate itself.

**Deliberately retained in `_COMMUNICATION/` (mentions ≠ ownership):**

| Retained | Why |
|---|---|
| `team_110/MANDATE_S005_TEAM110_EXECUTION_v1.0.0.md` | the **active** mandate; governs all 3 WPs |
| `team_110/HANDOFF_SELF_110_WP-S5-03_2026-07-16_v1.md` | WP-S5-03's own handoff (in flight) |
| `team_100/FEEDBACK-TEAM110-S004-RECON-AND-WP-S5-07-2026-07-16.md` | WP-S5-07 input (in flight) |
| `team_110/ROUTING-REQUEST-TEAM100-S004-RECONCILIATION-2026-07-16.md` | spans 3 WPs |
| `team_100/GCR_team_100_L-GATE_VALIDATE_OWNER_TEAM_90_2026-07-16_v1.0.0.md` | **open** governance change request |
| `team_100/REGISTRATION-S004-*`, `REGISTRATION-S005-WP-S5-01-02-*` | other WPs' registration records |
| `team_90/*S004-RECONCILIATION-REGISTRATION*` | S004 scope |
| `team_100/S005/WP-S5-06-LOD400-2026-07-16.md` | **the spec** — kept in place, matching the WP-S5-01/02 precedent whose `spec_ref` still resolves to `_COMMUNICATION/team_100/S005/…`. It also sits at depth 2, outside the runbook's `maxdepth 1` team-root scan. `spec_ref` therefore still resolves (M.1 satisfied). |

## 🔴 Second procedure finding — ADR045 R4's report path vs `validate_aos.sh` Check 15 (routed to team_120 + team_100)

**They are mutually unsatisfiable.** ADR045 **R4** mandates the completion report at
`_COMMUNICATION/team_110/{WP_ID}/COMPLETION_REPORT_{WP_ID}_v1.0.0.md` — i.e. inside a directory **named after
the WP**. `validate_aos.sh` **Check 15** (`check_15()`, L685-715) fails when any directory under
`_COMMUNICATION/team_*/` is named after a WP whose `status == COMPLETE` and `lod_status in (LOD500,
LOD500_LOCKED)`:

```
[FAIL] Check 15: Completed WP artifacts still in _COMMUNICATION/ (Iron Rule #15 — archive required)
```

The report can only be written **after** the WP is COMPLETE (it reports the completion), so **writing the
ADR045-mandated artifact at its mandated path guarantees a validate_aos FAIL** — while the same mandate (§8)
requires **0 FAIL**. Verified this session: Check 15 was clean until this directory was created (the S5-01/02
precedent verdicts record `1 FAIL` = Check 32 only).

**Resolved here** by placing the completion report in `_archive/WP-S5-06/team_110/` — Iron Rule #15's own
logic (a completed WP's artifacts belong in `_archive/<WP-ID>/`), which Check 15 accepts. Recipients reach it
via the bus message and this manifest.

**Requested:** team_100/team_120 to reconcile — either amend ADR045 R4's path to `_archive/{WP_ID}/team_110/`,
or exempt the `COMPLETION_REPORT_*` directory from Check 15. Note Check 15 flags **directories only**, so a
flat `_COMMUNICATION/team_110/COMPLETION_REPORT_{WP_ID}_v1.0.0.md` would also pass — that is the cheaper
amendment if the report is meant to stay visible outside the archive.

## Path redirects (M.2 — mandatory)

| Former path (before archive) | Archived path |
|------------------------------|---------------|
| `_COMMUNICATION/team_110/ADDENDUM-TEAM100-WP-S5-06-FACADE-MANDATORY-2026-07-16.md` | `_archive/WP-S5-06/team_110/ADDENDUM-TEAM100-WP-S5-06-FACADE-MANDATORY-2026-07-16.md` |
| `_COMMUNICATION/team_110/HANDOFF_SELF_110_WP-S5-06_2026-07-16_v1.md` | `_archive/WP-S5-06/team_110/HANDOFF_SELF_110_WP-S5-06_2026-07-16_v1.md` |
| `_COMMUNICATION/team_110/VERDICT-WP-S5-06-BUILD-2026-07-16.md` | `_archive/WP-S5-06/team_110/VERDICT-WP-S5-06-BUILD-2026-07-16.md` |
| `_COMMUNICATION/team_90/MANDATE-TEAM90-WP-S5-06-BUILD-2026-07-16.md` | `_archive/WP-S5-06/team_90/MANDATE-TEAM90-WP-S5-06-BUILD-2026-07-16.md` |
| `_COMMUNICATION/team_90/MANDATE-TEAM90-WP-S5-06-LOD400-2026-07-16.md` | `_archive/WP-S5-06/team_90/MANDATE-TEAM90-WP-S5-06-LOD400-2026-07-16.md` |
| `_COMMUNICATION/team_90/MANDATE-TEAM90-WP-S5-06-LOD400-CYCLE2-2026-07-16.md` | `_archive/WP-S5-06/team_90/MANDATE-TEAM90-WP-S5-06-LOD400-CYCLE2-2026-07-16.md` |
| `_COMMUNICATION/team_90/MANDATE-TEAM90-WP-S5-06-VALIDATE-2026-07-16.md` | `_archive/WP-S5-06/team_90/MANDATE-TEAM90-WP-S5-06-VALIDATE-2026-07-16.md` |
| `_COMMUNICATION/team_90/VERDICT-WP-S5-06-BUILD-2026-07-16.md` | `_archive/WP-S5-06/team_90/VERDICT-WP-S5-06-BUILD-2026-07-16.md` |
| `_COMMUNICATION/team_90/VERDICT-WP-S5-06-LOD400-2026-07-16.md` | `_archive/WP-S5-06/team_90/VERDICT-WP-S5-06-LOD400-2026-07-16.md` |
| `_COMMUNICATION/team_90/VERDICT-WP-S5-06-LOD400-CYCLE2-2026-07-16.md` | `_archive/WP-S5-06/team_90/VERDICT-WP-S5-06-LOD400-CYCLE2-2026-07-16.md` |
| `_COMMUNICATION/team_90/VERDICT-WP-S5-06-VALIDATE-2026-07-16.md` | `_archive/WP-S5-06/team_90/VERDICT-WP-S5-06-VALIDATE-2026-07-16.md` |
| `_COMMUNICATION/team_90/cross_engine_run_MANDATE-TEAM90-WP-S5-06-BUILD-2026-07-16.md.log` | `_archive/WP-S5-06/team_90/cross_engine_run_MANDATE-TEAM90-WP-S5-06-BUILD-2026-07-16.md.log` |
| `_COMMUNICATION/team_90/cross_engine_run_MANDATE-TEAM90-WP-S5-06-LOD400-2026-07-16.md.log` | `_archive/WP-S5-06/team_90/cross_engine_run_MANDATE-TEAM90-WP-S5-06-LOD400-2026-07-16.md.log` |
| `_COMMUNICATION/team_90/cross_engine_run_MANDATE-TEAM90-WP-S5-06-LOD400-CYCLE2-2026-07-16.md.log` | `_archive/WP-S5-06/team_90/cross_engine_run_MANDATE-TEAM90-WP-S5-06-LOD400-CYCLE2-2026-07-16.md.log` |
| `_COMMUNICATION/team_90/cross_engine_run_MANDATE-TEAM90-WP-S5-06-VALIDATE-2026-07-16.md.log` | `_archive/WP-S5-06/team_90/cross_engine_run_MANDATE-TEAM90-WP-S5-06-VALIDATE-2026-07-16.md.log` |
| `_COMMUNICATION/team_110/evidence/s5-06/` | `_archive/WP-S5-06/team_110/evidence-s5-06/` |
| `_COMMUNICATION/team_110/WP-S5-06/COMPLETION_REPORT_WP-S5-06_v1.0.0.md` (ADR045 R4 path) | `_archive/WP-S5-06/team_110/COMPLETION_REPORT_WP-S5-06_v1.0.0.md` |

## Reference integrity (M.1 / M.3 / M.4)

- **M.1 — `_aos/roadmap.yaml` WP-S5-06:** `authority`, `closure_artifact` and every `gate_history` verdict
  path rewritten to their `_archive/WP-S5-06/…` locations. `spec_ref` unchanged (the spec was not moved).
- **M.3 — stubs:** none left; all known consumers updated in-place.
- **M.4 — audits:** any checker reporting "missing file" for a former path above MUST treat it as
  **satisfied** via this redirect table, not as drift.

## Harness deliberately NOT archived

`scripts/qa/qr_facade_probe.mjs` stays under `scripts/qa/`. Spec §4.F requires it: an AC's harness must
survive Iron Rule #15 archiving, or the AC breaks the moment the WP closes and **WP-S5-05 §7 loses the tool
it needs to re-measure CWV on production**. This is why the probe was promoted out of `evidence/` during the
build rather than run in place.

---

*ARCHIVE_MANIFEST | WP-S5-06 | team_110 | ADR045 execution mode | 2026-07-16*
