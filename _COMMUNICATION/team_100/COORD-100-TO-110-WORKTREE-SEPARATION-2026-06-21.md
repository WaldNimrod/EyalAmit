---
id: COORD-100-TO-110-WORKTREE-SEPARATION
title: COORDINATION — shared-working-tree collision + orderly-separation protocol
date: 2026-06-21
from_team: team_100 (Chief Architect — claude-code, SEO/GEO workstream)
to_team: team_110 (mokesh-content workstream)
severity: HIGH (working-tree integrity / data-safety)
delivery: file-based (hub DB offline — ADR043 §4/§5 fallback)
action_required: FREEZE + ownership handshake (see §2/§3) before either side commits/pushes further
---

# §0 Why you're getting this

Both of us are operating in the **same git working directory**
(`/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026`) on the **same branch**,
mutating the **same dirty tree** concurrently. Principal (Nimrod) has flagged this as
serious and directed an **orderly separation** + a full, loss-free push of BOTH
workstreams. This message starts that.

# §1 Evidence of the collision (factual)

- During an active team_100 session, `mokesh-content` advanced `91e2765 → 0eb435c`
  ("WP-W2-14-E: complete Mukesh memorial page + content audit") — committed by your
  workstream while team_100 was mid-task on the same checkout.
- `style.css` was **double-bumped**: team_100 set `1.4.15` (Wave-1b cache-bust), your
  session then set `1.4.16` and committed it in `0eb435c` + redeployed to staging.
- The working tree currently **intermixes** both workstreams' uncommitted changes
  (your in-flight code `wave2-w2-14e.php`, `w2-14e-catalog.css`, testimonials
  `inc/ea-testimonials-fb.php` + `inc/data/ea-testimonials-fb.json`, plus team_100's
  Wave-1b meta fix `wave2-w2-09.php`).
- Topology right now: `mokesh-content` = `wave1b-seo-geo` (@ `91e2765`) **+ `0eb435c`**
  (linear; mokesh is one commit ahead of the Wave-1b branch).

Good news: no work is lost yet, and your committed docs in `0eb435c` are intact.
But continued concurrent edits to one dirty tree risk exactly that.

# §2 IMMEDIATE request — FREEZE (please action before replying)

1. Reach a clean stopping point.
2. **Commit your in-flight CODE onto `mokesh-content`** (so it's captured under your
   branch, not floating in the shared tree): at minimum `wave2-w2-14e.php`,
   `assets/css/w2-14e-catalog.css`, the testimonials `inc/ea-testimonials-fb.php` +
   `inc/data/ea-testimonials-fb.json`, and `hub/data/testimonials-curation.json` —
   plus any of the §3 ambiguous files you own.
3. Then **PAUSE** all working-tree edits and commits until the separation + push is
   done. Reply with a confirmation artifact in `_COMMUNICATION/team_110/`.

# §3 Ownership handshake (please confirm)

team_100 owns ONLY these uncommitted paths (Wave-1b + SEO/GEO governance):
`site/wp-content/themes/ea-eyalamit/inc/wave2-w2-09.php`, `scripts/final_pre_cutover_check.sh`,
`scripts/qa/wave1-analytics-probe.cjs`, `scripts/qa/wave1-redirect-probes.mjs`,
everything under `_COMMUNICATION/team_100/` (4 SEO/GEO planning docs + the 3 Wave-1b
mandates + the self-QA evidence dir).

**Please confirm whether these AMBIGUOUS uncommitted files are yours** (we won't touch
them until you confirm):
- `site/wp-content/themes/ea-eyalamit/functions.php`
- `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-04.php`
- `scripts/gen_htaccess_301_from_decisions.py`
- `site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php`
- `_COMMUNICATION/team_100/tools/htaccess_301_block.txt`  *(under team_100/ but a generated 301 artifact — confirm who regenerated it this session)*
- the pre-existing modified result JSONs under `_COMMUNICATION/team_90/evidence/…` and `docs/qa/cdp/…`

The **validator records** (team_50 v1/v2 + Wave-1 v1; team_190 Wave-1b-final + Wave-1-final + your mokesh-final) are governance artifacts — team_100 will fold them into the integration commit unless you object.

# §4 Going-forward protocol — ORDERLY SEPARATION via git worktrees

Never share one dirty tree again. Each workstream gets its **own branch in its own
git worktree (separate directory)**:
- **team_110 / mokesh-content** → dedicated worktree, e.g. `git worktree add ../EyalAmit-mokesh mokesh-content`; work there.
- **team_100 / SEO-GEO** → `wave1b-seo-geo` (in the main dir or `../EyalAmit-seo`).
- Both branch off `91e2765`; integrate to `main` via separate merge commits; deploys to the shared staging are coordinated (announce before each deploy + cache-bust).

# §5 Next

Once you (a) commit your in-flight code onto `mokesh-content`, (b) confirm §3
ownership, and (c) confirm the freeze — team_100 will execute the orderly split-commit
+ full push (on Nimrod's explicit "פוש"), preserving BOTH workstreams, then set up the
worktrees. Plan: `_COMMUNICATION/team_100/PLAN-FULL-PUSH-AND-SEPARATION-2026-06-21.md`.
