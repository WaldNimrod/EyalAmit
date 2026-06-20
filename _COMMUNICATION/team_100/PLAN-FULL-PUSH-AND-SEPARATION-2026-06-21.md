---
id: PLAN-FULL-PUSH-AND-SEPARATION
title: Plan — full loss-free push of BOTH workstreams + orderly worktree separation
date: 2026-06-21
from_team: team_100 (Chief Architect — claude-code)
to_team: team_00 (Nimrod, for approval) · team_110 (coordination)
status: PROPOSAL — no git mutation executed; awaits team_110 freeze + handshake + Nimrod "פוש"
related: COORD-100-TO-110-WORKTREE-SEPARATION-2026-06-21.md
---

# §0 Current state (factual, 2026-06-21)

**Branches / origin gap:**
- `main` @ `817e05b` — **+30 ahead of `origin/main`** (large unpushed backlog: Wave-1 + session work).
- `wave1b-seo-geo` @ `91e2765` — +7 ahead of `main` (the Wave-1b batch + handoff). **Wave-1b is dual-PASS** (team_50 v2 + team_190 final).
- `mokesh-content` @ `0eb435c` — = `wave1b-seo-geo` **+ `0eb435c`** (mokesh memorial page + content audit + mokesh dual-PASS records). HEAD is here.
- `origin` has only `main`, `legacy/full-git-history`, `wp-w2-16` — **neither `wave1b-seo-geo` nor `mokesh-content` exists on origin yet.**

**Uncommitted working tree (shared) — categorized:**
| Owner | Paths |
|---|---|
| **team_100 (Wave-1b)** | `inc/wave2-w2-09.php` (the dual-PASS meta fix) |
| **team_100 (SEO/GEO)** | `scripts/final_pre_cutover_check.sh`; `_COMMUNICATION/team_100/` 4 planning docs (modified) + 3 mandates (REV2, FINAL-TEAM190) + `evidence/wave1b-selfqa-2026-06-21/` + this PLAN + the COORD msg; `scripts/qa/wave1-analytics-probe.cjs` + `wave1-redirect-probes.mjs` |
| **team_110 (mokesh)** | `inc/wave2-w2-14e.php`; `assets/css/w2-14e-catalog.css`; `inc/ea-testimonials-fb.php` + `inc/data/ea-testimonials-fb.json`; `hub/data/testimonials-curation.json` |
| **AMBIGUOUS (handshake)** | `functions.php`; `inc/wave2-w2-04.php`; the 301 chain (`gen_htaccess_301_from_decisions.py`, `ea-w209-legacy-301-redirects.php`, `tools/htaccess_301_block.txt`) |
| **Governance records** | `_COMMUNICATION/team_50/` v1+v2 Wave-1b + v1 Wave-1; `_COMMUNICATION/team_190/` Wave-1b-final + Wave-1-final + (mokesh-final lives in team_110, committed in 0eb435c) |
| **Pre-existing QA artifacts** | 6 `team_90/evidence/content-accuracy/*.json`; `docs/qa/cdp/qa_probe_result.json` + `screenshots/` |

# §1 Goal & principles
- **Loss-free:** every byte of BOTH workstreams ends up committed + pushed to origin.
- **Orderly separation:** each workstream's work lands in its OWN commits on its OWN branch — no blended commits, clean attribution.
- **Non-destructive to the live session:** no `stash`/`checkout` surgery in the shared dirty tree while team_110 is active — use isolated worktrees.
- **Gated:** nothing pushes without Nimrod's "פוש"; nothing commits team_110's files without their ownership confirmation.

# §2 Prerequisites (BLOCKERS — must clear first)
1. **team_110 FREEZE + commit their in-flight code** onto `mokesh-content` (per COORD §2).
2. **Ownership handshake** on the AMBIGUOUS files (COORD §3).
3. Nimrod **"פוש"** for the origin push.

# §3 Plan (ordered; executed only after §2 clears)

**Step A — team_110 captures its code** (their action): commit in-flight mokesh/testimonials/catalog code onto `mokesh-content`. After this, `mokesh-content` holds ALL team_110 work; the shared tree should contain ONLY team_100 paths + handshake-resolved files.

**Step B — team_100 commits onto `wave1b-seo-geo`, via an isolated worktree** (so the shared tree is never checked-out/disturbed):
```
git worktree add ../EyalAmit-seo wave1b-seo-geo            # isolated checkout @ 91e2765
# copy team_100's working-tree files into ../EyalAmit-seo, then commit in 3 clean commits:
#   B1  Wave-1b: inc/wave2-w2-09.php   (meta fix — dual-PASS)
#   B2  SEO/GEO: _COMMUNICATION/team_100/* docs+mandates+evidence + scripts/final_pre_cutover_check.sh + scripts/qa/wave1-*
#   B3  Governance records: team_50 + team_190 verdicts/evidence
```
(Alternatively, if Step A leaves the main tree clean of team_110 files, commit B1–B3 directly in-place on `wave1b-seo-geo` — simpler, decide at execution time based on tree state.)

**Step C — integrate to `main` (two merge commits, attribution-clean):**
```
git checkout main
git merge --no-ff wave1b-seo-geo -m "Merge Wave-1b SEO/GEO (S004-P001-WP000) — dual-PASS (team_50 v2 + team_190 final)"
git merge --no-ff mokesh-content -m "Merge mokesh-content (WP-W2-14-E memorial + testimonials) — dual-PASS (team_110)"
```
Resolve any overlap at merge time (likely `style.css` only — already 1.4.16 on mokesh-content; pick 1.4.16). The 7 shared base commits enter once (via the first merge).

**Step D — FULL push (on "פוש"):**
```
git push origin main                 # flushes the +30 backlog + both merges
git push origin wave1b-seo-geo       # preserve the SEO/GEO branch on origin
git push origin mokesh-content       # preserve the mokesh branch on origin
```

**Step E — worktree separation for going forward** (COORD §4): give each session its own worktree+branch so this never recurs.

# §4 Risks & handling
- **Active concurrent edits** → §2.1 freeze is mandatory; until then any commit races team_110. Do not proceed without their freeze confirmation.
- **Ambiguous-file mis-attribution** → §2.2 handshake; do not commit those under team_100 unless team_110 disclaims them.
- **301-chain files regenerated** (`gen_htaccess…`, `ea-w209…`, `htaccess_301_block`) → confirm the intended generated state before committing (regenerate-from-SSoT if in doubt; never hand-edit the mu-plugin).
- **origin lacks the branches** → Step D pushes them fresh (`-u` to set upstream).
- **Reversibility** → all of A–C are local; nothing irreversible until Step D push (gated).

# §5 What I need from Nimrod
1. Approve this plan (or adjust the integration order / branch strategy).
2. Confirm how team_110 freeze + handshake happens (you relay / run that session, or I keep coordinating via the COORD artifact).
3. On freeze+handshake done → I execute A–C (local) and report; then **"פוש"** for Step D.
