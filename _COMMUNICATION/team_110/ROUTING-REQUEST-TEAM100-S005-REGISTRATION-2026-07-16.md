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

> ### ⚠ CORRECTION (2026-07-16, later same session) — the root cause below was WRONG
>
> This section originally stated the cause as *"a stale DB snapshot never backfilled with S003/S004/S005"* and
> recommended *"backfill the spoke's DB roadmap"*. **team_110 subsequently traced it properly and that diagnosis
> is wrong — there is no DB roadmap table in this path at all.**
>
> **Actual, verified root cause:** `/api/l0/<proj>/roadmap` reads `_aos/roadmap.yaml` from a **server-side git
> checkout** at the project's registered `server_path` (hub `_aos/projects.yaml` → `eyalamit.server_path:
> /data/projects/eyalamit`). Proof it is filesystem-based: `GET /api/l0/microgreens/roadmap` → 404
> `"Project root not found: neither local_p…"`. And that checkout is simply **stale**:
>
> ```
> /data/projects/eyalamit    HEAD 8270d98 (2026-05-29) · main · clean · correct remote
>                            → 450 commits behind origin/main
> /data/projects/smallfarms  HEAD d5b7ab6 (2026-06-05) → 0 behind      ← healthy, for contrast
> systemd: tiktrack-bare-sync.timer EXISTS · an eyalamit sync timer DOES NOT
> ```
>
> **It is a missing sync mechanism, not a DB backfill, and not fleet-wide.** The checkout is clean and on the
> right remote — it has simply never been pulled since 2026-05-29. **Do not action a "DB backfill".**
>
> Full evidence + the ruling request now sit with the Ambassador (team_120), whose mandate this is:
> `_COMMUNICATION/team_110/DRIFT-REPORT-TEAM120-SERVER-CHECKOUT-STALE-2026-07-16.md` (team_00-authorized).

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
