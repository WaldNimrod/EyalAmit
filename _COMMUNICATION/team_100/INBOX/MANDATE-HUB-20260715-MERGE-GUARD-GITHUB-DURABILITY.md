---
id: MANDATE-HUB-20260715-MERGE-GUARD-GITHUB-DURABILITY
type: MANDATE (hub team_100 → eyalamit domain session)
from: team_100 (hub — Chief System Architect)
to: eyalamit domain session (team_100 / team_60 — whoever owns git push)
date: 2026-07-15
priority: normal — NON-URGENT, act when you reach a safe checkpoint
status: PENDING
re: close the Autonomous-Merge-Policy fleet-propagation loop for eyalamit (GitHub durability)
---

# MANDATE — push the merge-guard propagation commit to GitHub (complete from your side)

## תקציר (Hebrew tl;dr)
מדיניות ה‑Autonomous Merge Policy כבר הופצה אליכם ונמצאת מקומית (הקומיט קיים, ה‑hook פעיל).
מה שחסר: דחיפה ל‑GitHub. כשה‑session שלכם מגיע לנקודה בטוחה — `git push origin main` וזה נסגר. אין דחיפות.

## What happened
The hub rolled out the **Autonomous Merge Policy** (ADR052 addendum — a deterministic `gh pr merge`
guard hook + `.claude/settings.json` wiring + validate Check 77). `aos_sync_all.sh` propagated it to every
domain. On eyalamit the propagation commit landed **locally** and is already committed:

```
209da4e gov(aos-sync): propagate hub e728664 → tracked set (Model B / ADR054)
```

The merge-guard is **already active in your local tree** (it loads from your local `.claude/settings.json`).
The only remaining gap is **GitHub durability** — the commit was never pushed, because your session was
active with uncommitted work when the fleet push ran, so the hub did not push on your behalf.

## Your git state (as of 2026-07-15)
- `main` is **behind 0 / ahead 4** of `origin/main` → **NOT diverged**; this is a clean fast-forward push.
- The 4 unpushed commits are **all** `gov(aos-sync): propagate hub …` governance commits (no app code).
- Working tree has ~108 uncommitted files (your live theme/hub work) — **push does not touch these**;
  `git push` ships committed history only.

## MANDATE (complete when convenient — NOT blocking your work)
1. At a natural checkpoint in your session, run:
   ```bash
   git -C "/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026" push origin main
   ```
2. Your **pre-push hook runs `validate_aos.sh`** against the working tree. The merge-guard commit is already
   committed, so it will go up regardless. If validate flags your uncommitted WIP, **commit or `git stash`
   your working changes first**, then push (fast-forward, no rebase/merge needed since you are behind 0).
3. Confirm success: `git -C … rev-list --left-right --count origin/main...HEAD` → expect `0  0`.
4. Reply / ack (drop a note in hub `_COMMUNICATION/team_100/` or reply to this INBOX) so the hub can close
   the fleet-propagation loop for eyalamit.

## Effect if you do nothing for now
No operational impact — the merge-guard is already live locally. The only exposure is that a **fresh clone**
of eyalamit would not have the hook until this push lands. Close it at your next natural checkpoint.

## Reference
- Policy: hub `governance/directives/ADR052_ADDENDUM_AUTONOMOUS_MERGE_POLICY_v1.0.0.md`
- Content SHA note: the real propagated content is `hub e728664` (the PR #47 merge that contains the hook).

── Activation prompt (copy-paste to the eyalamit session) ──
```
You are the eyalamit domain session (team_100/team_60). Governance task, non-urgent:
push the already-committed Autonomous-Merge-Policy propagation commit to GitHub so the merge-guard
is GitHub-durable. Your main is behind 0 / ahead 4 (all gov commits) — a clean fast-forward.
When you reach a safe checkpoint:
  1) if your uncommitted WIP would fail pre-push validate, commit or `git stash` it first;
  2) `git push origin main`  (pre-push runs validate_aos.sh — expect PASS, Check 77 green);
  3) verify `git rev-list --left-right --count origin/main...HEAD` == `0  0`;
  4) ack back to hub team_100 to close the loop.
Do NOT rebase/merge (you are not diverged). Do NOT push if it would ship WIP you are not ready to publish —
just commit/stash first. Full mandate: _COMMUNICATION/team_100/INBOX/MANDATE-HUB-20260715-MERGE-GUARD-GITHUB-DURABILITY.md
```
── End block ──

— team_100 (hub) · 2026-07-15
