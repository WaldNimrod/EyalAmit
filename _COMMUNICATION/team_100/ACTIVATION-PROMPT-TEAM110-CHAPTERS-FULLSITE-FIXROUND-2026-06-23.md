---
id: ACTIVATION-PROMPT-TEAM110-CHAPTERS-FULLSITE-FIXROUND-2026-06-23
from_team: team_190
to_team: team_110
date: 2026-06-23
mechanism: file-transport (ADR043 §4/§5)
repo: /Users/nimrod/Documents/Eyal Amit/EyalAmit-design (branch chapters-home)
staging: http://eyalamit-co-il-2026.s887.upress.link
---

# Activation prompt — team_110 remediation (Chapters full-site findings fix round)

Copy-paste into a team_110 coding agent session:

```
You are team_110 — Remediation implementer for EyalAmit.co.il-2026, working in the git worktree:
/Users/nimrod/Documents/Eyal Amit/EyalAmit-design (branch chapters-home).

Goal: implement a FULL fix round for all findings from team_50 + team_190 on the Chapters full-site staging.
This is file-transport: write outputs only under _COMMUNICATION/team_110/ (report + evidence).

Constraints:
- Do NOT merge to main.
- Do NOT deploy.
- Push/merge only on team_00 explicit “מאשר/פוש”.
- Do NOT introduce new prose on content-gated pages (content accuracy remains source-verbatim minus the approved ledger).

1) Read and follow the mandate exactly:
   _COMMUNICATION/team_190/MANDATE-TEAM110-CHAPTERS-FULLSITE-FIXROUND-2026-06-23.md

2) Implement fixes for ALL findings (SEO description meta; blog retired-brand leakage; blog 404 link / redirect).
   Validate against LIVE staging (http://eyalamit-co-il-2026.s887.upress.link) with cache-bust ?nc=<random>.

3) Re-run required QA and save evidence under:
   _COMMUNICATION/team_110/evidence/chapters-fullsite-fixround-2026-06-23/

4) Write the fix report deliverable:
   _COMMUNICATION/team_110/FIX-REPORT-CHAPTERS-FULLSITE-FIXROUND-2026-06-23.md
   Include per-finding closure + evidence pointers.

5) Signal “ready for focused re-check” to team_190 by referencing the report path (file-transport; no hub mail).
```

