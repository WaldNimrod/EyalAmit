---
id: INFO-HANDOFF-TO-W2-03-SESSION-2026-05-29
from: team_100 (orchestration session)
to: team_100 (W2-03 build session)
date: 2026-05-29
note: left UNCOMMITTED on purpose — do not let it interfere with your W2-03 commits; move/commit it to main when convenient.
---

# Info handoff — git/tree state for the W2-03 session

## 1. Authoritative remote is now CURRENT
- `origin/main` = **`c268859`** (I pushed it). It previously sat at the STALE `61adef4` — my last commits (S003 UI-Precision LOD400 specs + the W2-03/04/05 orchestration handoff + P3 corrections) were unpushed. **That stale base is the git/merge problem you hit.**
- ACTION: base/rebase `feature/w2-03-books` on **`origin/main` c268859**:
  `git fetch origin && git rebase origin/main`  (only ADDS S003 spec files + handoff — no overlap with W2-03 build files; should apply cleanly).

## 2. Branch deleted — do NOT reference
- `feature/w2-06-blog` was fully merged into main and has been **deleted (local + remote)** + tracking pruned. Don't branch from or merge it.

## 3. ⚠ SINGLE-TREE COLLISION (the real issue)
- Your session is operating in the SAME working directory as the orchestration session: `/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026`. Two team_100 sessions in one tree corrupt each other (branch checkouts + commits interleave). This is the same problem that bit W2-02/W2-06.
- ACTION (isolate): give W2-03 its own checkout/worktree, e.g.
  `git worktree add "/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-03" feature/w2-03-books`
  then run all W2-03 work from `EyalAmit-w2-03/`. Leave this directory on `main` for orchestration.

## 4. Your W2-03 build inputs (all on main @ c268859)
- Spec: `_aos/work_packages/S002/WP-W2-03/LOD400_spec.md` (L-GATE_SPEC **PASS_WITH_FINDINGS**, team_190 Codex; corrections already applied).
- Mandate: `_COMMUNICATION/team_10/MANDATE-TEAM10-W2-03-BOOKS-2026-05-28.md` (activation prompt in §7).
- Orchestration loop reference: `_COMMUNICATION/team_100/HANDOFF_SELF_100_W2-03-04-05_ORCHESTRATION_2026-05-29_v1.md`.

## 5. Build conventions (from W2-02/W2-06 lessons)
- Routing: `template_include` priority 100 + `set_query_var('ea_wave2_shell', true)` (Stage-B dequeue depends on it).
- Deploy: `python3 scripts/ftp_deploy_site_wp_content.py` (upload-only, safe for migrated media). uPress FTP has transient outages — retry; staging uses opcache → **cache-bust** every verify (`?cb=$(date +%s)$RANDOM`).
- IR#1: builder=claude-sonnet → L-GATE_BUILD team_50 **non-Claude** → L-GATE_VALIDATE team_190 **Codex**.
- Validator stale-verdict trap: require proof-of-HEAD + cache-busted checks (W2-02/W2-06 both produced stale verdicts initially).
- Never `git add -A`; commit only your W2-03 files by name.

## 6. Current main state (c268859)
W2-01/W2-02/W2-06 CLOSED+merged. All S002 (W2-03..09) + S003 UI-Precision (W2-10 + A–G) LOD400 specs authored + L-GATE_SPEC validated (W2-10 cluster: P3 corrections applied, confirmation pass pending). validate_aos: 30 PASS / 18 SKIP / 0 FAIL.
