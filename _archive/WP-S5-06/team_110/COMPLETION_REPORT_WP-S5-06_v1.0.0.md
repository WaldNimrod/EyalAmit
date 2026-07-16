---
id: COMPLETION_REPORT_WP-S5-06_v1.0.0
from_team: team_110
to: [team_00, team_100]
cc: [team_90, team_120, team_60]
date: 2026-07-16
type: COMPLETION_REPORT
wp: WP-S5-06
milestone: S005
project: eyalamit
mandate_ref: _COMMUNICATION/team_110/MANDATE_S005_TEAM110_EXECUTION_v1.0.0.md
adr_ref: ADR045 R4 (execution_authority: full)
status: COMPLETE / LOD500_LOCKED
---

# COMPLETION REPORT — WP-S5-06 (QR embed facade — click-to-load)

**The commitment `loading="lazy"` never kept is now real.** 42 QR pages were pulling **~1.06 MB** of YouTube
player on load — before the reader asked to watch. The audience scans a QR **printed in Eyal's book**, usually
on mobile data. On `/qr/qr2/` that payload is now **9.4 KB**: a **99.1% reduction**. The player arrives only
on click.

## 1. Gate chain

| Gate | Result | Findings | Artifact |
|---|---|---|---|
| L-GATE_SPEC (cycle 1) | PASS_WITH_FINDINGS | 0/0/4 minor | `_archive/WP-S5-06/team_90/VERDICT-WP-S5-06-LOD400-2026-07-16.md` |
| L-GATE_SPEC (cycle 2) | PASS | 0 | `_archive/WP-S5-06/team_90/VERDICT-WP-S5-06-LOD400-CYCLE2-2026-07-16.md` |
| **L-GATE_BUILD** | **PASS** | 0 blocker / 0 major / **2 minor** | `_archive/WP-S5-06/team_90/VERDICT-WP-S5-06-BUILD-2026-07-16.md` |
| **L-GATE_VALIDATE** | **PASS** | **0** | `_archive/WP-S5-06/team_90/VERDICT-WP-S5-06-VALIDATE-2026-07-16.md` |

Builder report: `_archive/WP-S5-06/team_110/VERDICT-WP-S5-06-BUILD-2026-07-16.md`.
Evidence: `_archive/WP-S5-06/team_110/evidence-s5-06/`.

**Both gates went to team_90** per the mandate §4 (mandate-literal reading, ruled by team_00 this session).
Note this **differs from the S5-01/02 precedent**, where team_110 self-verdicted L-GATE_BUILD and team_90 ran
only L-GATE_VALIDATE. The stricter model was chosen deliberately; it cost one extra validator cycle per WP.

**Iron Rule #1:** builder `claude-opus-4-8` (Anthropic) ≠ validator `composer-2.5` (Cursor). team_110 did not
self-validate at either gate. No correction loop was needed — cycle 1 was clean at both gates.

## 2. Measured result (independently reproduced by team_90)

| Route | videos | player BEFORE | player AFTER | poster | VideoObject |
|---|---|---|---|---|---|
| `/qr/qr2/` | 1 | 8 req / 1050.1 KB | **0 req / 0 B** | 1 req / 9.4 KB | 1 → **1** ✔ |
| `/qr/qr10/` | 3 | 8 req / 1046.2 KB | **0 req / 0 B** | 1 req / 13.4 KB | 3 → **3** ✔ |
| `/qr/qr1/` | 0 | 0 | 0 | 0 | 0 → **0** ✔ |
| `/qr/qr48/` | 0 | 0 | 0 | 0 | 0 → **0** ✔ |

Click (AC-3): 14 requests to `www.youtube-nocookie.com` + `googlevideo.com`, iframe replaces the button,
**0 requests to bare `youtube.com`** anywhere. All 6 ACs PASS.

## 3. ADR042 3-step closure audit

| Step | Done | Evidence |
|---|---|---|
| 1 — Gate chain complete, cross-engine | ✔ | L-GATE_BUILD PASS + L-GATE_VALIDATE PASS, both team_90 |
| 2 — Archive (Iron Rule #15) | ✔ | `_archive/WP-S5-06/ARCHIVE_MANIFEST.md`; **`verified_count == intended_count == 16`**, non-vacuous; M.1–M.4 applied; Path-redirects table present |
| 3 — Registration | ✔ | `_aos/roadmap.yaml` → `status: COMPLETE`, `lod_status: LOD500_LOCKED`, `current_lean_gate: L-GATE_VALIDATE`, full `gate_history` — **written via the FILE path** |

**Why the FILE path, not `POST /api/work-packages/{id}` (offered by ADR045 R2.2):** re-probed live this
session — `/api/system/health` → `db: online`, **`built_at: 2026-07-12`**. The server build predates the l0
endpoint fix, so `/api/l0/eyalamit/roadmap` still serves the S002-era payload (`l0_roadmap_source: database`,
24 WPs, **zero `WP-S5-*` rows**). An API mutation would have written the wrong object. This is a **ruled** R8/R9
invocation (team_00's T-1 ruling; ADR034 R9/R10/R12), not a silent fourth fallback.

## 4. Findings disposition

| ID | Severity | Status | Owner |
|---|---|---|---|
| **F-01** — AC-4's axe threshold is unsatisfiable as written | minor | **OPEN → team_100** | team_100 |
| **F-02** — AC harness could be silently blind (site isolation) | minor | **CLOSED** — fixed in-harness | team_110 |
| **P-01** — `/AOS_archive` cannot archive spoke artifacts | procedure | **OPEN → team_120** | team_120 |

### F-01 — needs a team_100 spec amendment (does not block)
AC-4 demands `axe exit 0` **before and after**. The **pre-facade baseline is already non-zero**: `/qr/qr2/`
serious=2 (`color-contrast`, `link-name`), `/qr/qr10/` serious=1 (`color-contrast`). All three are
pre-existing and outside §4's contract — `link-name` is an **empty `<a>` to a book page**; the facade swaps
`<iframe>`→`<button>` and creates no anchors. Executed on the AC's **stated intent** («אפס נסיגה» / zero
regression), verified per rule id + node count: **0 new, 0 worsened**. team_90 **CONFIRMED** this reading.
Same class as team_100's own §8 row #2 (the addendum's impossible "→ ~0 KB" AC-1).
**Requested:** (a) amend AC-4 to *"no new/worsened violations vs the recorded baseline"*; (b) route the 3
pre-existing serious violations to a **separate hygiene WP** — they are not S5-06 debt and do not block S5-05.

### F-02 — closed (but read this: it nearly produced a false PASS)
The AC harness measured the player as **1 req / 0 KB** pre-facade, contradicting §1's ratified 9 req / 1061 KB.
**Cause: Chrome site isolation** — a cross-origin embed renders out-of-process (OOPIF) and the page target's
CDP `Network` domain sees none of its traffic:
```
chrome-headless-shell (no site isolation) : /qr/qr2/ = 8 req / 1050 KB   <- reproduces §1
full Google Chrome    (site isolation on) : /qr/qr2/ = 1 req /    0 KB   <- BLIND
```
Unfixed, **AC-1 ("player == 0/0") would have passed whether or not the facade worked**. Fixed: prefer
`chrome-headless-shell`, force `--disable-features=IsolateOrigins,site-per-process`, reasoning pinned in
`findChrome()`. The AC-3 click doubles as the instrument check, so blindness can never read as success.

### P-01 — `/AOS_archive` is a structural no-op for spokes (→ team_120, custodian)
The mandate §4 step 6 directs `/AOS_archive`. Executed here:
```
POST /api/artifacts/archive {"wp_id":"WP-S5-06","dry_run":true,"project_id":"eyalamit"}
-> HTTP 200 {"source_files": [], "file_count": 0}
```
`archive.py:19` hard-wires `_HUB_ROOT = Path(__file__).resolve().parents[3]` and `plan_archive(wp_id)` takes
**no project parameter** — the endpoint can only see the **hub** repo. For any L0 spoke it returns 0 files, and
`execute_archive()` would then report `verified_count == intended_count == 0`, **passing the mandate's archive
gate while archiving nothing**. Archived instead by the **v1.3.0 runbook executed manually** (which the
procedure explicitly sanctions), giving a real `16 == 16`.
**Requested of team_120:** give `archive.py` a project-root parameter, or amend the procedure to state spokes
use the manual runbook — and make a 0-file plan a **hard error**, not a silent success.

## 5. Deferred / out of scope (each ruled, none silently dropped)

- **Transcripts (60 videos)** — excluded by explicit team_00 ruling (§5.5). An Eyal **content** task; bundling
  would make the WP permanently Eyal-blocked. **No placeholder was added** — adding one would violate the
  ruling. Tracked under M-EYAL-INPUTS.
- **Poster localisation (60 posters via `i.ytimg.com`)** — ratified §5.1 for v1 (measured: `maxresdefault`
  404s in 3/4; 0 `Set-Cookie` on the thumb CDN). Possible post-cutover improvement, **not blocking debt**.
- **`ea-w2-07b-qr-reseed-once.php` retained** — ratified §5.3; a flag-locked no-op. Deleting it would touch the
  seed path AC-2 exists to protect.
- **3 pre-existing axe serious violations** — F-01; separate hygiene WP.
- **`/qr/` prod 302** — WP-S5-05 scope.

## 6. New environmental observation (recommend adding to the standing guardrails)

**Staging returns `503` under concurrent probing.** Four QR routes returned `503` in a batch; **all four
returned `200` re-probed serially**. Same class as the documented transient `curl 000` — shared-host
throttling, never a redirect, never a defect. All AC measurement was done serially. Recommend the standing
guardrail text read **"`000` **or** `503`"**.

## 7. Delivery-criterion check (§0 / roadmap L2569)

> «להגיש לאייל את האתר הכי מדוייק שאפשר … ולהשאיר רק פליסהולדרים ברורים»

WP-S5-06 introduces **no placeholder**, disclosed or otherwise. The facade poster is a real frame of Eyal's
own video, not a stand-in. team_90 confirmed at L-GATE_VALIDATE: no undisclosed placeholder on the QR pages.

## 8. Status

**WP-S5-06 — COMPLETE / LOD500_LOCKED.** One of `WP-S5-05.blocked_by` is now cleared.
**WP-S5-05 was NOT started** — it remains the blocked cutover gate and needs explicit team_00/Eyal go-live
approval. Next in this session: WP-S5-07, then WP-S5-03.
