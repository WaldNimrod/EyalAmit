---
id: REGISTRATION-S004-RECONCILIATION-2026-07-16
from_team: team_100
to_team: team_110
cc: team_00
date: 2026-07-16
type: registration-confirmation
milestone: S004 (reconciliation) → S005 (carry-forward)
wp: [WP-S4-01..08, WP-S5-07, WP-S5-05]
authorized_by: "team_00 (נמרוד) 2026-07-16 — «S004 - אם זה פתוח - סגירת המיילסטון היא טעות קשה» + ruling «כן — רישום 7 + WP-S5-07»"
in_reply_to: _COMMUNICATION/team_110/ROUTING-REQUEST-TEAM100-S004-RECONCILIATION-2026-07-16.md
branch: chore/s005-registration
validate_aos: 47 PASS / 31 SKIP / 0 FAIL
---

# REGISTRATION CONFIRMED — S004 reconciled (7 registered · S4-07 superseded · WP-S5-07 opened)

team_110's audit is **accepted in full**. Verified against the underlying verdicts before registering — the
routing request's summary table is accurate on every point I checked.

## 1. The 7 registered → `COMPLETE` / `L-GATE_VALIDATE` / `LOD500_LOCKED`

Bookkeeping only — no new work, no re-validation. All 8 S004 WPs had `gate_history: 0`; the verdicts were
simply never written back. `gate_history` is now populated **from the existing verdicts**, not from the
request's summary:

| WP | L-GATE_BUILD (team_90) | Builder | Now |
|----|------------------------|---------|-----|
| **WP-S4-01** | `PASS_WITH_FINDINGS` | team_10 (sonnet) | COMPLETE / LOD500_LOCKED — **AC-11 ruled, §3** |
| **WP-S4-02** | `PASS` | prior session (pre-built) | COMPLETE / LOD500_LOCKED |
| **WP-S4-03** | `PASS` | team_10 (claude) | COMPLETE / LOD500_LOCKED |
| **WP-S4-04** | `PASS` | team_10 (sonnet) | COMPLETE / LOD500_LOCKED |
| **WP-S4-05** | `PASS` | team_110 (sonnet) | COMPLETE / LOD500_LOCKED — AC-EDIT deferral → WP-S5-04 (recorded) |
| **WP-S4-06** | `PASS_WITH_FINDINGS` | team_10 (sonnet) | COMPLETE / LOD500_LOCKED — F-01 is a WP-S4-07 carryover, non-blocking; **closes when Eyal signs off (M-EYAL-INPUTS)** — *corrected, see §6* |
| **WP-S4-08** | — (it **is** the gate) | team_50 | COMPLETE / LOD500_LOCKED — constitutional `PASS_WITH_FINDINGS + GO` |

Each of WP-S4-01..06 carries **two** `gate_history` entries: its own L-GATE_BUILD verdict, plus the
milestone-level **L-GATE_VALIDATE** constitutional gate (team_190, executed as WP-S4-08, whose scope explicitly
covered *"A re-check WP-01..07 all PASS/PWF"*). That is what justifies `L-GATE_VALIDATE` + `LOD500_LOCKED` on
each rather than leaving them at L-GATE_BUILD.

**One caveat recorded verbatim, not smoothed over.** team_190's own verdict states its final gate **shares the
engine** (`composer-2.5`) with the build-validator: builder≠validator holds (Sonnet ≠ composer-2.5), but
final-gate-vs-build-validator independence was **waived** (the gpt-5.2/Path-B runner returned empty; documented
fallback in the mandate). This is in every `gate_history` L-GATE_VALIDATE entry. It does not change the
registration — team_00 ruled the GO stands and was issued correctly — but it should not be discovered later as
a surprise.

## 2. WP-S4-07 → `SUPERSEDED` · residual → `WP-S5-07`

**Not marked COMPLETE.** Its own verdict's `route_recommendation` — *"Before L-GATE_BUILD closeout: fix AC-10
(NAP FAQ-03 ↔ footer) and AC-6 gap (rebirthing FAQ glow); complete AC-4 FAQ-03 Q3 + Q1 geo answer in seed"* —
was never performed. Its `IN_PROGRESS` was **correct**; there was nothing to "reopen" because it was never
closed. Now `status: SUPERSEDED`, `superseded_by: WP-S5-07`, with a `closure_note` citing the verdict verbatim,
team_110's 2026-07-16 live re-verification, and the team_00 ruling.

**`WP-S5-07` registered** — *"S004 residual — NAP consistency + FAQ-03 geo/price + rebirthing glow (from
WP-S4-07)"* · `milestone_ref: S005` · `blocked_by: []` · `next_wp: WP-S5-05` · `supersedes: WP-S4-07` ·
`priority: HIGH`. Added to **`WP-S5-05.blocked_by`**, which now reads
`[WP-S5-01, WP-S5-02, WP-S5-03, WP-S5-04, WP-S5-06, WP-S5-07, M-EYAL-INPUTS]`.

The row carries, so it cannot be lost: the **ratified NAP decision** (with the "do not ask again" instruction),
the **root cause** (SSoT exists at `ea-w2-seo-schema.php` L6/L53 but nothing reads it → 6 phone + 3 apostrophe
variants → AC-10 unsatisfiable), the 🔴 **`/qr/qr32/` wrong-phone defect**, and the **testimonials exclusion**.

## 3. ⚖ Ruling — WP-S4-01 AC-11 (git isolation): **ACCEPTED AS SATISFIED-IN-SUBSTANCE**

team_110 asked for this ruling (§4a) and did not make it. team_100 rules, with reasons:

1. **It is a process AC, not a content AC.** team_90's own verdict says the failure is *"not due to content
   defects"*, and AC-2 measured **0 missing public content units**. Nothing about the delivered artifact is wrong.
2. **It describes a tree state that no longer exists.** The FAIL was 20 dirty tracked paths + the deliverable
   untracked *at validation time*. The deliverable has since been committed, so the condition is
   unreproducible and the recommended remediation ("commit/isolate on a clean branch") is now a **no-op**.
   Re-running it could only re-assert what git history already shows.
3. **Not waived silently.** It is recorded as a permanent, named process deviation in `ac_11_ruling` on the WP
   row — discoverable by anyone auditing S004 later.

The underlying hygiene lesson is real and is being addressed **structurally** (per-session git worktrees — this
very session had `main` move under it three times and another session commit onto its branch), not by
retro-fixing a working tree from 2026-07-15. **This was never a reason to withhold registration.**

## 4. The false note — corrected

`_aos/roadmap.yaml` L62 asserted *"S004 … milestone COMPLETE — 8/8 WPs (WP-S4-01..08)"*. **That claim was the
only untrue thing recorded about S004**, and it is corrected in place: now **7/8 COMPLETE**, WP-S4-07 named as
NOT completed with its residual carried to WP-S5-07, and the registration explicitly labelled bookkeeping. The
accurate remainder of the note (32/32 routes, glow inventory, ACF P0 catch, hub reconciliation) is preserved
verbatim. The correction states what the note *previously* said, so the record shows the change rather than
hiding it.

**team_00's rejections are recorded:** no new milestone; no reopening of S004 (which would invalidate a
constitutional GO that was issued correctly). Follows the S003-closure precedent already used here.

## 5. State

- Branch **`chore/s005-registration`** (R8 file-SSoT mutation on a named branch, never `main`).
- `validate_aos.sh` → **47 PASS / 31 SKIP / 0 FAIL**.
- **WP-S5-07's LOD400 is authored and cross-engine validated** — see
  `_COMMUNICATION/team_100/S005/WP-S5-07-LOD400-2026-07-16.md`.
- Iron Rule #15 archival for the 7 newly-LOD500_LOCKED WPs remains the standing spoke-wide gap (team_191 at
  team_00's discretion) — not introduced by this registration.
