---
id: ACTIVATION-PROMPT-TEAM100-CHAPTERS-FULLSITE_POSTFIX_DEPLOY_E2E_2026-06-23
from_team: team_190
to_team: team_100
date: 2026-06-23
purpose: Activate the team_100 session to deploy the F110-01 fix to staging, run live browser E2E checks, and hand back evidence for team_190 closure.
mechanism: file-transport (ADR043 §4/§5)
repo: /Users/nimrod/Documents/Eyal Amit/EyalAmit-design (branch chapters-home)
staging: http://eyalamit-co-il-2026.s887.upress.link
---

# Activation prompt — team_100 session (post-fix deploy + E2E browser checks)

Copy-paste into a team_100 coding agent session:

```
You are team_100 — Chief Architect / integrator for EyalAmit.co.il-2026, working in the git worktree:
/Users/nimrod/Documents/Eyal Amit/EyalAmit-design (branch chapters-home).

Goal:
1) Deploy the fix-round change for F110-01 (meta description) to LIVE STAGING.
2) Re-run live, browser-rendered E2E checks against staging.
3) Produce evidence + a short closeout note so team_190 can close F110-01 and update the overall status.

Read first (source of truth):
- _COMMUNICATION/team_100/HANDOFF_100_CHAPTERS-FULLSITE_STATUS_AND_NEXTSTEPS_2026-06-23_v1.md
- _COMMUNICATION/team_110/FIX-REPORT-CHAPTERS-FULLSITE-FIXROUND-2026-06-23.md
- _COMMUNICATION/team_190/FOCUSED-RECHECK_CHAPTERS-FULLSITE_FIXROUND_2026-06-23.md

Constraints (hard):
- Do NOT merge to main.
- Do NOT push or deploy WITHOUT team_00 explicit approval (“מאשר/פוש”).
- Do NOT introduce or rewrite body prose on content-gated pages (content must remain verbatim vs Eyal source, minus approved ledger only).
- All validations are against LIVE STAGING (http://eyalamit-co-il-2026.s887.upress.link) with cache-bust ?nc=<random>.

What to deploy (minimum viable):
- site/wp-content/themes/ea-eyalamit/inc/wave2-w2-09.php  (adds <meta name="description"> for Chapters views + /en/)

Deployment (ONLY after team_00 approval):
- From repo root: python3 scripts/ftp_deploy_site_wp_content.py
- Bump theme version if needed for CSS/asset busting, but this change is head-only; ensure staging HTML cache is bypassed with ?nc=.

Post-deploy E2E checks (browser-rendered + machine evidence):
Write all outputs under: _COMMUNICATION/team_100/evidence/chapters-postdeploy-2026-06-23/

1) Focused SEO head closure for F110-01:
   - Verify metaDescriptionCount == 1 on:
     /books/vekatavta/
     /eyal-amit/mokesh-dahiman/
     /en/
   - Use team_110 helper or an equivalent probe:
     node scripts/qa/seo-head-probe.mjs --out _COMMUNICATION/team_100/evidence/chapters-postdeploy-2026-06-23/seo

2) Content regression guard:
   node scripts/qa/content-diff.mjs --out _COMMUNICATION/team_100/evidence/chapters-postdeploy-2026-06-23/content

3) a11y (axe) on at least:
   /books/vekatavta/ /eyal-amit/mokesh-dahiman/ /en/ /blog/ /contact/
   node scripts/qa/http-qa-axe.cjs --base http://eyalamit-co-il-2026.s887.upress.link <routes...>

4) H1 + dir on the same routes:
   EA_H1_OUT=_COMMUNICATION/team_100/evidence/chapters-postdeploy-2026-06-23/h1-rtl/h1-rtl-http-probe.json \
   node scripts/qa/h1-rtl-http-probe.cjs <routes...>

5) Overflow + screenshots (CDP qa_probe) — run full-site config if possible:
   node /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs \
     --config _COMMUNICATION/team_190/evidence/chapters-fullsite-2026-06-22/qa_probe/qa_probe_config.json

6) Lighthouse (representative routes):
   bash scripts/qa/http-qa-lighthouse.sh / /method/ /books/ /blog/ /contact/ /en/ /eyal-amit/mokesh-dahiman/

Deliverable back to team_190:
- Write a short closeout note:
  _COMMUNICATION/team_100/CLOSEOUT_CHAPTERS-FULLSITE_POSTFIX_DEPLOY_E2E_2026-06-23.md
  Include:
  - confirmation of deploy (what shipped, when)
  - F110-01 head closure evidence paths (show metaDescriptionCount)
  - any regressions (must be none) + links to evidence

Then ping team_00 to route the closeout + evidence to team_190 for final closure.
```

