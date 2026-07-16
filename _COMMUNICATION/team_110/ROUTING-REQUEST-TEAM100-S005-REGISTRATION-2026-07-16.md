---
id: ROUTING-REQUEST-TEAM100-S005-REGISTRATION-2026-07-16
from_team: team_110
to_team: team_100
cc: team_00
date: 2026-07-16
type: routing-request
milestone: S005
wp: [WP-S5-01, WP-S5-02]
authorized_by: "team_00 (נמרוד) 2026-07-16 — «פרומט לסשן צוות 100 להשלמת הרישום»"
blocks: WP-S5-05
related:
  - _COMMUNICATION/team_110/REPORT-TEAM00-XVAL-WP-S5-01-02-2026-07-16.md
  - _COMMUNICATION/team_90/VERDICT-WP-S5-01-VERIFY-2026-07-16.md
  - _COMMUNICATION/team_90/VERDICT-WP-S5-02-BUILD-2026-07-16.md
commit: 6c42f20
---

# ROUTING REQUEST — team_100: complete the S005 registration (WP-S5-01 + WP-S5-02)

team_110 has closed the build + cross-engine validation of WP-S5-01 and WP-S5-02. **Registration is
team_100/team_00 authority** (`_aos/` is off-limits to team_110 — Iron Rule #4 / directory authority), so the
roadmap still does not reflect reality. This artifact lists exactly what needs registering.

## 1. What is now true (evidence-backed)

| WP | Build | Cross-engine (team_90, composer-2.5) | Commit |
|----|-------|--------------------------------------|--------|
| **WP-S5-01** | PASS 5/5 (verify package) | **PASS, 0 findings** — `VERDICT-WP-S5-01-VERIFY-2026-07-16.md` | `e8b02b9` |
| **WP-S5-02** | PASS (schema/meta build, deployed to staging) | **PASS, 0 findings** — `VERDICT-WP-S5-02-BUILD-2026-07-16.md` | `6c42f20` |

Iron Rule #1 satisfied on both: builder `claude-opus-4-8` (team_110) ≠ validator `composer-2.5` (team_90, Cursor).
No correction loop was required (cycle 1 clean). Full context: `REPORT-TEAM00-XVAL-WP-S5-01-02-2026-07-16.md`.

## 2. Registration actions requested

1. **Gate-advance `WP-S5-01`** → `current_lean_gate: L-GATE_VALIDATE`, result PASS; append `gate_history`
   entry (validator `team_90`, validator_engine `composer-2.5`, verdict artifact path, 0 findings, date 2026-07-16).
2. **Gate-advance `WP-S5-02`** → same, with its own verdict artifact.
3. **Fix status drift (the actual bug):** both WPs are still `status: PLANNED` in `_aos/roadmap.yaml`
   (L2021, L2047) despite having build PASS **and** cross-engine PASS. Advance to the correct terminal
   status per project convention (`COMPLETE` / `LOD500`), consistent with how S004's WPs were closed.
4. **Record the §3.2 facade decision as documented debt** (see §3 below) — team_00 ruled *defer + record*,
   explicitly **not** "closed because lazy is sufficient".
5. **Resolve the pre-existing `validate_aos.sh` Check-32 FAIL** (uncommitted `_aos/roadmap.yaml` drift). Note
   the tracked drift was the team_100 LOD400-authoring change (lod_status LOD200→LOD400 + spec_ref +
   parent_index for S5-01/02/03) — still uncommitted as of `6c42f20`.
6. **Carry-forward, do not close:** QR direct-200 (49 rows) stays `OPEN-until-cutover` — WP-S5-05 must re-run it
   on **production** via `scripts/final_pre_cutover_check.sh` (no `-L`; assert 200 + no `Location`). Staging PASS
   does not substitute (the documented prod 302 on `/qr/` is prod-conditional).

## 3. §3.2 facade — team_00 ruling: **DEFER + RECORD AS DEBT** (measured, not asserted)

Register as **known open debt**, not as closed. The measurement (headless Chrome over CDP, mobile 375×812,
cold cache, staging — evidence: `_COMMUNICATION/team_110/evidence/s5-02-facade-cwv/`, reproducible via
`qr_cwv_probe.mjs`):

| page | 1st iframe vs fold | LCP | YouTube payload |
|------|--------------------|-----|-----------------|
| `/qr/qr48/` (0 video, baseline) | — | 1372–1680 ms | **0 KB** |
| `/qr/qr2/` (1 video) | 958px vs 812px → below fold | 1104–1312 ms | **~1039–1062 KB** / 9 req |
| `/qr/qr10/` (3 videos) | 848px vs 812px → below fold | 1076–1328 ms | **~1063–1064 KB** / 9 req |

**Findings to record verbatim:**
- **`loading="lazy"` does NOT defer the first embed.** Despite sitting below the fold, ~1 MB of YouTube payload
  loads anyway (Chrome's lazy threshold ≈1250px swallows it). The previously-recorded justification *"native
  lazy-load already meets the CWV bar"* is **factually wrong as a mechanism** and must not be carried forward.
- **Lazy DOES work further down.** qr10 (3 videos) pulls the *same* 9 requests / ~1.06 MB as qr2 (1 video) —
  videos 2+ (≈62% down the page) are genuinely deferred. **Cost = ~1.06 MB for the first video only, × 42 pages**
  (48 QR pages: 6 with 0 videos, 27×1, 12×2, 3×3 = 60 embeds total).
- **No measured CWV penalty.** LCP on the 1-video page is *better* than the 0-video baseline; load times flat.
  So deferring the facade is **correct on CWV grounds** — the debt is **data-transfer + privacy**, not CWV.
- **Not measured:** TBT / main-thread blocking (YouTube player JS does work LCP won't show). Flagged as the one
  remaining evidence gap if the debt is ever revisited.
- **Caveat:** cross-page LCP comparison is weak (different content/LCP element) and LCP was noisy across runs
  (qr48: 1372→1680 ms). The stable, decisive number is the payload (1039–1064 KB, consistently 9 requests).

**Debt statement to register:** *"§3.2 facade deferred (team_00, 2026-07-16). Not a cutover blocker — measured
zero CWV penalty. Open debt: ~1.06 MB avoidable YouTube payload on each of 42 QR pages (mobile/cellular
audience, pages reached by scanning a printed QR code). `loading=lazy` does not mitigate the first embed.
Revisit post-cutover; TBT unmeasured."*

**Transcripts — split off.** 60 videos needing real transcript text is an **Eyal content task**, not code. It
should be tracked with **M-EYAL-INPUTS**, not bundled into any facade LOD. Not a cutover blocker.

## 4. ⚠ ADR034 finding — the recorded justification is now outdated (needs a team_100 ruling)

> ### ✅ SUPERSEDED — closed by team_00's T-1 ruling (2026-07-16). No team_100 ruling is outstanding.
>
> **Superseded by T-1 ruling 2026-07-16 — file-SSoT enforced (R9/R10/R12); no backfill; fix = endpoint
> authority guard + server checkout freshness; see `MSG-TEAM120-FINAL-RULING-ALIGNMENT-2026-07-16`.**
>
> Recorded by team_110 per team_120's ruling §4 item 2, from the S005 execution session (ADR045
> `execution_authority: full`, mandate `MANDATE_S005_TEAM110_EXECUTION_v1.0.0.md` §7 item 2).
>
> **This section is retained as provenance only — do not action anything in it.** In particular the closing
> paragraph below still asks team_100 to re-record the justification as *"server checkout 450 commits behind"*.
> That is the **retracted** diagnosis (see the RETRACTED block in this same section) and must **not** be
> actioned. The ruling's mechanism is the hybrid endpoint overriding `work_packages` from an unpopulated DB
> (`l0_project_io.py:151-165`), not checkout staleness.
>
> **Live re-confirmation (this session, 2026-07-16):** `/api/system/health` → `db: online`,
> `built_at: 2026-07-12` — the server build **predates** the endpoint fix, so the trap is still live. S005
> closures for WP-S5-03/06/07 are therefore registered via the **FILE** path, not `POST /api/work-packages/{id}`.

The roadmap's own note (L56-58) justifies file-SSoT with: *"DB online but the API L0 eyalamit roadmap is stale
… full GET hangs http=000, probed 2026-07-15"*. **Re-probed 2026-07-16 — that is no longer accurate:**

```
GET /api/system/health        → db: online, mode: online
GET /api/l0/eyalamit/roadmap  → HTTP 200 (4,962 bytes)   ← no longer hangs
   active_milestone : S002        (file SSoT says S005)
   work_packages    : 24          (file SSoT has ~60, incl. all WP-S5-*)
   WP-S5-* present  : NONE        ← the API roadmap has never heard of S005
```

So the endpoint is **responsive**, but serves **S002-era data**. **file-SSoT (`_aos/roadmap.yaml`) remains the
correct path** — but for a *different reason* than recorded, and the recorded reason must be corrected rather
than copied forward.

> ### ⛔ RETRACTED — the "CORRECTION" that stood here was ITSELF WRONG (team_120, 2026-07-16)
>
> This block previously *"corrected"* the diagnosis to *"a stale server checkout, not a DB backfill"* and
> instructed **"Do not action a 'DB backfill'"**. **team_120 (Ambassador) verified live and overturned it.
> That instruction was backwards and is hereby WITHDRAWN. The ORIGINAL diagnosis in this §4 — «the DB was
> never backfilled» — was CORRECT.**
>
> **The decisive evidence** (`l0_project_io.py:103-170`): the endpoint is a **hybrid**. It reads the file
> first (tag `"file"`), then **overrides `work_packages` from the DB** when rows exist (`:151-165`) and flips
> the tag to `"database"`. **Only `work_packages` is overridden — `active_milestone` (`:126`) stays from the
> file.** Live, every L0 domain served: **`l0_roadmap_source: database`**.
>
> | domain | API serves | file-SSoT (truth) | `active_milestone` | `work_packages` |
> |---|---|---|---|---|
> | **eyalamit** | S002, 24 | S005, 82 | **wrong** (file/checkout) | **wrong** (DB) |
> | smallfarmsagents | S003, 61 | S003, 76 | ✅ correct | **wrong** (DB) |
> | nimrod-bio | V200, 12 | V200, 33 | ✅ correct | **wrong** (DB) |
> | shaked-wg-agent | S005, 16 | S005, 38 | ✅ correct | **wrong** (DB) |
>
> A stuck checkout would stale **both** fields together. **3 of 4 domains have a correct `active_milestone`
> and a wrong WP list** — only possible if the list comes from the DB. Confirmed by team_110's own data,
> which we misread at the time: the stuck checkout file holds **29** WPs; the API serves **24**. **24 ≠ 29** —
> the served list was never the file's.
>
> **Why team_110 was misled (team_120's assessment):** `eyalamit` is the **only domain in the fleet with two
> independent faults at once** — checkout 450 behind (breaks `active_milestone`) **and** an unpopulated DB
> (breaks `work_packages`). Both screamed "stale", and the checkout was stale spectacularly, so it absorbed
> the blame. It is the worst place in the fleet from which to diagnose this bug.
>
> **The sync-timer fix proposed in the retracted block would not have worked:** `sync_l0_roadmap_to_db`
> (`:173-232`) syncs **only `current_lean_gate`**, only on **rows that already exist** — it **never INSERTs**,
> so no `WP-S5-*` would ever enter the DB. It also iterates **`local_path` only** (`:199-201`) — a Mac path
> absent on the server → a **no-op for every spoke**. A timer would have fixed one field in one domain and
> left all four WP lists wrong.
>
> **team_110 method failures to carry forward:** (1) we rationalised away the disconfirming 24≠29 instead of
> chasing it; (2) our "healthy control" (`smallfarmsagents → 0 behind`) was **invalid** — that checkout is on a
> feature branch with 299 dirty files and is serving the API; (3) **`behind=0` is a lying zero** —
> `git rev-list HEAD..origin/main` compares against the *cached* `origin/main` ref, refreshed only by `git
> fetch` (shaked-wg-agent last fetched 2026-04-17). Our 450 was real **only because we happened to fetch**.
>
> **It IS fleet-wide, and worse than reported:** of 12 projects registered with `server_path`, **only tiktrack**
> is healthy and current (the only one with a timer). Two sit on feature branches, one on April's main,
> two are not git worktrees (capra-mio → HTTP 500), five are **missing entirely** (404). **The hub's own
> checkout is 257 behind with 68 dirty files.**
>
> **Authority:** `_COMMUNICATION/team_110/RESPONSE-TEAM120-TO-TEAM110-2026-07-16.md` (team_120, team_00-approved).
> The remedy decision is **team_100's** — team_110 fixes nothing here. **file-SSoT remains the correct path
> (ADR034 R9); S005 proceeds unblocked.**

**What still stands for team_100/team_00:** ADR034's "DB online → API-only mutations" (Iron Rule #7) is a **live
trap** in this spoke — `health` reports `db: online`, instructing agents to mutate via an API that serves an
S002 world with no `WP-S5-*`. Three milestones (S003/S004/S005) have each quietly used the R8 file fallback
without anyone identifying the shared cause. **file-SSoT stays correct**; please correct the recorded
justification from *"full GET hangs http=000"* to *"server checkout 450 commits behind, no sync mechanism —
see the team_120 drift report"*, rather than adding a 4th silent R8 invocation.

## 5. Not requested / out of scope here

- WP-S5-03 build (separate handoff — the last team-executable S005 package).
- WP-S5-04 (human-verified, team_00/Eyal) and M-EYAL-INPUTS (Eyal-blocked).
- WP-S5-05 cutover — remains BLOCKED until S5-01..04 + M-EYAL-INPUTS close **and** explicit go-live approval.
